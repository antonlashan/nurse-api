<?php

/**
 * Description of UserController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\app;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\UserDetail;
use App\Models\UserQualification;
use Illuminate\Support\Facades\Hash;
use App\Http\SMS;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Config;

class UserController extends Controller
{
    /**
     * User register.
     *
     * **mobile_no** should according to E.164 international format
     * Ex: +94775186150 (0775186150, 775186150 are wrong)
     *
     * Here if **oauth_provider** and **oauth_uid** is set, **password** not required
     * otherwise **password** is required.
     *
     * Dob format `1990-12-13`.
     *
     * Gender is an enum which has only `male` or `female`
     *
     * @bodyParam first_name string required First name.
     * @bodyParam mobile_no string required Mobile number.
     * @bodyParam email string required Email.
     * @bodyParam password string required Password.
     * @bodyParam oauth_provider string required '' or facebook or google.
     * @bodyParam oauth_uid string required Auth ID.
     * @bodyParam dob string required birthday.
     * @bodyParam gender enum required male or female.
     * @bodyParam referral_point int required.
     * @bodyParam referral_no string max 6.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Registered successfully!",
     *     "data": [
     *         {
     *             "id": 33,
     *             "email": "antonlashan12@gmail.com",
     *             "mobile_no": "94775186150",
     *             "sms_ref_id": "f437c171-2d08-48c8-a4a2-xxxxxxxx",
     *             "created_at": "2019-07-24 11:15:06",
     *             "updated_at": "2019-07-24 11:15:06",
     *             "user_detail": {
     *                 "first_name": "Anton",
     *                 "last_name": "",
     *                 "nic": "",
     *                 "gender": "male",
     *                 "dob": "2010-01-01",
     *                 "birth_district_id": null,
     *                 "highest_edu_qualification": "",
     *                 "current_work_place": "",
     *                 "registration_no": "",
     *                 "prof_pic": null,
     *                 "referral_point": 2,
     *                 "referral_no": "",
     *                 "created_at": "2019-07-24 11:15:06",
     *                 "updated_at": "2019-07-24 11:15:06"
     *             }
     *         }
     *     ]
     * }
     * @response 422 {
     *      "success": false,
     *      "message": "Validation error",
     *      "data": {
     *         "mobile_no": [
     *            "The mobile no has already been taken."
     *        ],
     *        "email": [
     *           "The email has already been taken."
     *       ]
     *      }
     *  }
     *
     * @group Client
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:50',
            'mobile_no' => 'required|unique:users|regex:/(\+94)[0-9]{9}/',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required_if:oauth_provider,',
            'oauth_provider' => 'required_if:password,|unique:users,oauth_provider,NULL,NULL,oauth_uid,'.$request->input('oauth_uid'),
            'oauth_uid' => 'required_if:password,|max:100|unique:users,oauth_uid,NULL,NULL,oauth_provider,'.$request->input('oauth_provider'),
            'dob' => 'required',
            'gender' => 'required',
            'referral_point' => 'required|integer',
            'referral_no' => 'max:6',
        ]);

        $hasher = app()->make('hash');
        $password = $hasher->make($request->input('password'));

        DB::beginTransaction();
        try {
            $user = User::create(array_merge($request->all(), ['password' => $password]));
            $userDetail = $user->userDetail()->create($request->all());

            $sms = new SMS();
            $smsRes = $sms->OTPSend($user->mobile_no);
            $user->sms_ref_id = $smsRes->referenceId;
            $user->save();
        } catch (ServerException $e) {
            $err = json_decode($e->getResponse()->getBody()->getContents())->message;

            DB::rollback();

            return $this->responseBadRequest(isset($err->description) ? $err->description : $err);
        } catch (\Exception $e) {
            DB::rollback();

            return $this->responseBadRequest($e->getMessage());
        }
        if (!$userDetail) {
            return $this->responseBadRequest('User not created for account');
        }
        DB::commit();

        return $this->responseSuccess(User::with('userDetail')->where('id', '=', $user->id)->get(), 'Registered successfully!');
    }

    /**
     * User send OTP.
     *
     * @bodyParam email string required Email address.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "id": 5,
     *         "email": "rebecca.hunter@nurse.com",
     *         "mobile_no": "94775186150",
     *         "sms_ref_id": "6337fca0-ae24-11e9-96e2-19a992bdbfe1",
     *         "created_at": "2019-07-24 14:30:52",
     *         "updated_at": "2019-07-24 15:04:52"
     *     }
     * }
     *
     * @group Client
     */
    public function sendOTP(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:50',
        ]);

        $email = $request->post('email');
        $user = User::where('email', '=', $email)->first();
        if (!$user) {
            return $this->responseBadRequest('Email not found.');
        }

        try {
            $sms = new SMS();
            $smsRes = $sms->OTPSend($user->mobile_no);
            $user->sms_ref_id = $smsRes->referenceId;
            $user->save();
            $user->mobile_no = $this->maskPhoneNumber($user->mobile_no);
        } catch (ServerException $e) {
            $err = json_decode($e->getResponse()->getBody()->getContents())->message;

            return $this->responseBadRequest(isset($err->description) ? $err->description : $err);
        }

        return $this->responseSuccess($user);
    }

    /**
     * User resend OTP.
     *
     * @bodyParam email string required Email address.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "id": 5,
     *         "email": "rebecca.hunter@nurse.com",
     *         "mobile_no": "94775186150",
     *         "sms_ref_id": "6337fca0-ae24-11e9-96e2-19a992bdbfe1",
     *         "created_at": "2019-07-24 14:30:52",
     *         "updated_at": "2019-07-24 15:04:52"
     *     }
     * }
     *
     * @group Client
     */
    public function resendOTP(Request $request)
    {
        return $this->sendOTP($request);
    }

    /**
     * User verify OTP by phone number.
     *
     * @bodyParam code string required OTP code from sms.
     * @bodyParam sms_ref_id string required SMS reference id.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "referenceId": "f6eaefa0-ae1c-11e9-a959-dd0d4e395bb7",
     *         "code": "36449",
     *         "statusCode": "1000",
     *         "description": "verification success"
     *     }
     * }
     *
     * @response 400
     * {
     *     "success": false,
     *     "message": "verification failed",
     *     "data": null
     * }
     *
     * @group Client
     */
    public function verifyOTP(Request $request, $updateUser = true)
    {
        $this->validate($request, [
            'code' => 'required|size:5',
            'sms_ref_id' => 'required',
        ]);

        $code = $request->post('code');
        $smsRefId = $request->post('sms_ref_id');

        $user = User::where('sms_ref_id', '=', $smsRefId)->first();
        if (!$user) {
            return $this->responseBadRequest('User not found.');
        }

        $sms = new SMS();
        $smsRes = $sms->OTPVerify($smsRefId, $code);

        if ('1000' === $smsRes->statusCode) {
            if ($updateUser) {
                $user->is_active = true;
                $user->update();
            }

            return $this->responseSuccess($smsRes);
        }

        return $this->responseBadRequest($smsRes->description);
    }

    /**
     * User profile update.
     *
     * Even this is a **PUT** request you have to send this as a **POST** request
     * because of `lumen` doesn't support form data via **PUT** request
     *
     * So we have to pass additional field with **POST** request.
     *
     * `_method=PUT` and rest of the following fields
     *
     * @bodyParam first_name string required First name.
     * @bodyParam last_name string Last name.
     * @bodyParam nic string required NIC.
     * @bodyParam dob string required DOB(1985-01-01).
     * @bodyParam gender enum required male or female.
     * @bodyParam birth_district_id int required District ID.
     * @bodyParam highest_edu_qualification string required Highest education qualification.
     * @bodyParam current_work_place string Current work place.
     * @bodyParam a_level array required A level results [{"name": "Sinhala", "grade": "A"}, {"name": "CHEM", "grade": "B"}].
     * @bodyParam o_level array required O level results [{"name": "Maths", "grade": "A"}].
     * @bodyParam professional string Professional exam results.
     * @bodyParam vtc string VTC exam results.
     * @bodyParam _method string required _method=PUT.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Profile updated successfully.",
     *     "data": null
     * }
     *
     * @group Client
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:50',
            'last_name' => 'max:50',
            'nic' => 'required|max:12',
            'dob' => 'required|max:10',
            'gender' => 'required|in:male,female',
            'birth_district_id' => 'required',
            'highest_edu_qualification' => 'required|max:50',
            'current_work_place' => 'max:20',
//            'registration_no' => 'required|max:20',
            'a_level' => 'required_if:o_level,|array',
            'a_level.*' => 'required|array',
            'o_level' => 'required_if:a_level,|array',
            'o_level.*' => 'required|array',
            'professional' => 'max:50',
            'vtc' => 'max:50',
        ]);

        $userDetail = UserDetail::find($request->user()->id);
        if ($userDetail) {
            DB::beginTransaction();
            try {
                $userDetail->is_complete_profile = true;
                $userDetail->update($request->all());
                $this->addQualifications($userDetail->user_id, $request->all());
            } catch (\Exception $e) {
                DB::rollback();

                return $this->responseBadRequest($e->getMessage());
            }
            DB::commit();
        } else {
            return $this->responseBadRequest('User not found.');
        }

        return $this->responseSuccess(null, 'Profile updated successfully.');
    }

    private function addQualifications($userId, $data)
    {
        UserQualification::where('user_id', $userId)->delete();

        $qKeys = UserQualification::TYPES; // qualification keys
        foreach ($qKeys as $key) {
            if (isset($data[$key])) {
                foreach ($data[$key] as $values) {
                    $qualification = new UserQualification();
                    $qualification->name = $values['name'];
                    $qualification->grade = $values['grade'];
                    $qualification->type = $key;
                    $qualification->save();
                }
            }
        }
    }

    /**
     * User get profile.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "first_name": "Lashan",
     *         "last_name": "Fernando",
     *         "nic": "198516003220",
     *         "gender": "male",
     *         "dob": "1985-06-08",
     *         "birth_district_id": 15,
     *         "highest_edu_qualification": "Bsc",
     *         "current_work_place": "Negombo",
     *         "registration_no": "123356778",
     *         "prof_pic": "http://api.icm.lk/images/user/1561291480.jpg",
     *         "professional": "",
     *         "vtc": "",
     *         "referral_point": 2,
     *         "referral_point_lbl": "Social media",
     *         "referral_no": "",
     *         "created_at": "2019-07-02 09:37:20",
     *         "updated_at": "2019-07-02 11:32:54",
     *         "user_qualifications": {
     *             "a_level": [
     *                 {
     *                     "id": 28,
     *                     "name": "Maths",
     *                     "grade": "A",
     *                     "type": "a_level"
     *                 },
     *                 {
     *                     "id": 29,
     *                     "name": "Physics",
     *                     "grade": "B",
     *                     "type": "a_level"
     *                 },
     *                 {
     *                     "id": 30,
     *                     "name": "Chemistry",
     *                     "grade": "C",
     *                     "type": "a_level"
     *                 }
     *             ],
     *             "o_level": [
     *                 {
     *                     "id": 31,
     *                     "name": "Sinhala",
     *                     "grade": "A",
     *                     "type": "o_level"
     *                 },
     *                 {
     *                     "id": 32,
     *                     "name": "Maths",
     *                     "grade": "A",
     *                     "type": "o_level"
     *                 },
     *                 {
     *                     "id": 33,
     *                     "name": "Science",
     *                     "grade": "B",
     *                     "type": "o_level"
     *                 },
     *                 {
     *                     "id": 34,
     *                     "name": "English",
     *                     "grade": "C",
     *                     "type": "o_level"
     *                 }
     *             ]
     *         },
     *         "user": {
     *             "id": 3,
     *             "email": "john.edmunds@nurse.com",
     *             "mobile_no": "1234567892",
     *             "sms_ref_id": "",
     *             "created_at": "2019-08-17 10:54:05",
     *             "updated_at": "2019-08-17 11:02:21"
     *         },
     *         "district": {
     *             "id": 15,
     *             "name": "Mannar"
     *         }
     *     }
     * }
     * @group Client
     */
    public function getOne(Request $request)
    {
        $data = [];
        $userDetail = UserDetail::with('userQualifications', 'user', 'district')
                ->where('user_id', $request->user()->id)
                ->first()
                ->toArray();

        $qKeys = UserQualification::TYPES; // qualification keys
        foreach ($qKeys as $key) {
            $data[$key] = [];
        }

        foreach ($userDetail['user_qualifications'] as $q) {
            $data[$q['type']][] = $q;
        }
        $userDetail['user_qualifications'] = $data;

        return $this->responseSuccess($userDetail);
    }

    /**
     * User update profile pic.
     *
     * Even this is a **PUT** request you have to send this as a **POST** request
     * because of `lumen` doesn't support form data via **PUT** request
     *
     * So we have to pass additional field with **POST** request.
     *
     * `_method=PUT` and rest of the following fields
     *
     * @bodyParam prof_pic file required Profile image.
     * @bodyParam _method string required _method=PUT.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Uploaded successfully!",
     *     "data": {
     *         "first_name": "Client",
     *         "last_name": "",
     *         "nic": "",
     *         "gender": "male",
     *         "dob": "1985-01-02",
     *         "birth_district_id": null,
     *         "highest_edu_qualification": "",
     *         "current_work_place": "",
     *         "registration_no": "",
     *         "prof_pic": "http://api.icm.lk/images/user/15621426975d1c67e9da92a.png",
     *         "created_at": "2019-07-03 08:19:36",
     *         "updated_at": "2019-07-03 08:31:37"
     *     }
     * }
     *
     * @group Client
     */
    public function updateProfPic(Request $request)
    {
        $this->validate($request, [
            'prof_pic' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        $model = UserDetail::find($request->user()->id);
        if ($model) {
            $image = $request->file('prof_pic');
            $prevImageName = $model->getAttributes()['prof_pic'];
            $imageName = $this->uploadImage($image, UserDetail::IMG_PATH);
            if ($imageName && $model->update(['prof_pic' => $imageName])) {
                $this->deleteImage(UserDetail::IMG_PATH, $prevImageName);

                return $this->responseSuccess($model, 'Uploaded successfully!');
            } else {
                return $this->responseBadRequest('Unsuccessful.');
            }
        }

        return $this->responseBadRequest('No record found.');
    }

    /**
     * User change password.
     *
     * Even this is a **PUT** request you have to send this as a **POST** request
     * because of `lumen` doesn't support form data via **PUT** request
     *
     * So we have to pass additional field with **POST** request.
     *
     * `_method=PUT` and rest of the following fields
     *
     * @bodyParam password_current string required Current password.
     * @bodyParam password string required New password.
     * @bodyParam password_confirmation string required Confirmation password.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Password updated successfully.",
     *     "data": null
     * }
     *
     * @response 422
     * {
     *     "success": false,
     *     "message": "Current password not matched.",
     *     "data": null
     * }
     *
     * @group Client
     */
    public function changePwd(Request $request)
    {
        $this->validate($request, [
            'password_current' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);
        $passwordCurr = $request->input('password_current');
        $passwordNew = $request->input('password');

        $user = User::find($request->user()->id);
        if (!$user) {
            return $this->responseBadRequest('User not found.');
        }
        if (!Hash::check($passwordCurr, $user->password)) {
            return $this->responseValidation('Current password not matched.');
        }

        $hasher = app()->make('hash');

        $user->password = $hasher->make($passwordNew);
        if ($user->update()) {
            return $this->responseSuccess(null, 'Password updated successfully.');
        }

        return $this->responseBadRequest('Unsuccessful.');
    }

    /**
     * User get referral points.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": [
     *         {
     *             "id": 1,
     *             "label": "Agent"
     *         },
     *         {
     *             "id": 2,
     *             "label": "Social Media"
     *         },
     *         {
     *             "id": 3,
     *             "label": "Campaign"
     *         },
     *         {
     *             "id": 4,
     *             "label": "News Paper"
     *         },
     *         {
     *             "id": 5,
     *             "label": "Other"
     *         }
     *     ]
     * }
     *
     * @group Client
     */
    public function getReferralPoints()
    {
        return $this->responseSuccess(Config::get('consts.referral_points'));
    }
}
