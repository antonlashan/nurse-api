<?php

/**
 * Description of ForgotPwdController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\app;

use Illuminate\Http\Request;
use App\Models\User;

class ForgotPwdController extends UserController
{
    /**
     * ForgotPwd send OTP.
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
        return parent::sendOTP($request);
    }

    /**
     * ForgotPwd resend OTP.
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
     * ForgotPwd verify OTP by phone number.
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
    public function verifyOTP(Request $request, $updateUser = false)
    {
        return parent::verifyOTP($request, false);
    }

    /**
     * ForgotPwd change password.
     *
     * Even this is a **PUT** request you have to send this as a **POST** request
     * because of `lumen` doesn't support form data via **PUT** request
     *
     * So we have to pass additional field with **POST** request.
     *
     * `_method=PUT` and rest of the following fields
     *
     * @bodyParam sms_ref_id string required SMS reference id.
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
     * @group Client
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'sms_ref_id' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $passwordNew = $request->input('password');
        $smsRefId = $request->post('sms_ref_id');

        $user = User::where('sms_ref_id', '=', $smsRefId)->first();
        if (!$user) {
            return $this->responseBadRequest('User not found.');
        }

        $hasher = app()->make('hash');

        $user->password = $hasher->make($passwordNew);
        if ($user->update()) {
            return $this->responseSuccess(null, 'Password updated successfully.');
        }

        return $this->responseBadRequest('Unsuccessful.');
    }
}
