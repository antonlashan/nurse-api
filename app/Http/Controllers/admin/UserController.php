<?php

/**
 * Description of UserController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * User list.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "paginator": {
     *             "pages": 1,
     *             "current_page": 1,
     *             "per_page": 20,
     *             "total": 5
     *         },
     *         "list": [
     *             {
     *                 "user_detail_first_name": "Admin",
     *                 "user_detail_last_name": "",
     *                 "user_detail_nic": "",
     *                 "user_detail_gender": "male",
     *                 "id": 1,
     *                 "email": "admin@nurse.com",
     *                 "mobile_no": "1234567890",
     *                 "role": "admin",
     *                 "created_at": "2019-07-10 13:14:12",
     *                 "updated_at": "2019-07-18 09:46:08"
     *             },
     *             {
     *                 "user_detail_first_name": "Sean",
     *                 "user_detail_last_name": "Marshall",
     *                 "user_detail_nic": "",
     *                 "user_detail_gender": "male",
     *                 "id": 2,
     *                 "email": "client@nurse.com",
     *                 "mobile_no": "1234567891",
     *                 "role": "client",
     *                 "created_at": "2019-07-10 13:14:12",
     *                 "updated_at": "2019-07-16 11:41:48"
     *             }
     *         ]
     *     }
     * }
     *
     * @group Admin
     */
    public function lists(Request $req)
    {
        $sort = $req->query('sort');
        $order = $req->query('order');

        $q = User::select([
                    'd.first_name as user_detail_first_name',
                    'd.last_name as user_detail_last_name',
                    'd.nic as user_detail_nic',
                    'd.gender as user_detail_gender',
                    'users.*',
                ])
                ->join('user_details as d', 'users.id', '=', 'd.user_id');
        if ('id' === $sort) {
            $q->orderBy('users.id', $order);
        }
        if ('name' === $sort) {
            $q->orderBy('d.first_name', $order);
        }
        if ('email' === $sort) {
            $q->orderBy('users.email', $order);
        }
        if ('mobile_no' === $sort) {
            $q->orderBy('users.mobile_no', $order);
        }
        if ('nic' === $sort) {
            $q->orderBy('d.nic', $order);
        }
        if ('gender' === $sort) {
            $q->orderBy('d.gender', $order);
        }
        if ('role' === $sort) {
            $q->orderBy('users.role', $order);
        }
        $res = $q->paginate(Config::get('consts.page_size'));

        return $this->responseSuccess($this->getPagination($res, $res->makeVisible('role')));
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
     *         "birth_district_id": 2,
     *         "highest_edu_qualification": "Bsc",
     *         "current_work_place": "Negombo",
     *         "registration_no": "123356778",
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
     *             ],
     *             "professional": [
     *                 {
     *                     "id": 35,
     *                     "name": "SCJP",
     *                     "grade": "pass",
     *                     "type": "professional"
     *                 },
     *                 {
     *                     "id": 36,
     *                     "name": "IELTS",
     *                     "grade": "pass",
     *                     "type": "professional"
     *                 }
     *             ],
     *             "vtc": [
     *                 {
     *                     "id": 37,
     *                     "name": "VTC exam 1",
     *                     "grade": "pass",
     *                     "type": "vtc"
     *                 },
     *                 {
     *                     "id": 38,
     *                     "name": "VTC exam 2",
     *                     "grade": "pass",
     *                     "type": "vtc"
     *                 }
     *             ]
     *         }
     *     }
     * }
     * @group Admin
     */
    public function getOne($id)
    {
        User::$staticMakeVisible = ['role', 'is_active'];
        $data = [];
        $userDetail = UserDetail::with(['userQualifications', 'district', 'user'])
                ->where('user_id', $id)
                ->first()
                ->makeVisible('is_complete_profile')
                ->toArray();
        foreach ($userDetail['user_qualifications'] as $q) {
            $data[$q['type']][] = $q;
        }
        $userDetail['user_qualifications'] = $data;

        return $this->responseSuccess($userDetail);
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
     * @group Admin
     */
    public function changePwd(Request $request)
    {
        $this->validate($request, [
            'password_current' => 'required',
            'password' => 'required|confirmed',
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
     * User delete.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": null
     * }
     *
     * @group Admin
     */
    public function delete($id)
    {
        $model = User::with('userDetail')->find($id);
        if (!$model) {
            return $this->responseBadRequest('User not found.');
        }

        if ($model->userDetail->delete() && $model->delete()) {
            return $this->responseSuccess(null);
        }

        return $this->responseBadRequest('Unsuccessful');
    }
}
