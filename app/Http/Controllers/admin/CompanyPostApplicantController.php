<?php

/**
 * Description of CompanyPostApplicantController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyPostApplication;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use App\Http\Firebase;
use App\Http\SMS;
use GuzzleHttp\Exception\ClientException;

class CompanyPostApplicantController extends Controller
{
    /**
     * CompanyPostApplicantController list.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": [
     *         {
     *             "id": 3,
     *             "user_id": 3,
     *             "status": "reject",
     *             "first_name": "John",
     *             "last_name": "Edmunds",
     *             "email": "john.edmunds@nurse.com",
     *             "mobile_no": "+94775186152",
     *             "status_lbl": "Rejected"
     *         },
     *         {
     *             "id": 5,
     *             "user_id": 5,
     *             "status": "reject",
     *             "first_name": "Rebecca",
     *             "last_name": "Hunter",
     *             "email": "rebecca.hunter@nurse.com",
     *             "mobile_no": "+94775186150",
     *             "status_lbl": "Rejected"
     *         }
     *     ]
     * }
     *
     * @group Admin
     */
    public function lists(Request $req, $id)
    {
        $sort = $req->query('sort');
        $order = $req->query('order');

        CompanyPostApplication::$staticMakeVisible = ['user_id'];
        $q = CompanyPostApplication::select([
                    'company_post_applications.id',
                    'company_post_applications.user_id',
                    'company_post_applications.status',
                    'user_details.first_name',
                    'user_details.last_name',
                    'users.email',
                    'users.mobile_no',
                ])
                ->join('user_details', 'company_post_applications.user_id', '=', 'user_details.user_id')
                ->join('users', 'user_details.user_id', '=', 'users.id')
                ->where('company_post_applications.company_post_id', $id);
        switch ($sort) {
            case 'name':
                $q->orderBy('user_details.first_name', $order)
                    ->orderBy('user_details.last_name', $order);
                break;
            case 'email':
                $q->orderBy('users.email', $order);
                break;
            case 'mobile_no':
                $q->orderBy('users.mobile_no', $order);
                break;
            case 'status':
                $q->orderBy('company_post_applications.status', $order);
                break;
        }

        return $this->responseSuccess($q->get());
    }

    /**
     * CompanyPostApplicantController send message.
     *
     * @group Admin
     */
    public function sendMessage(Request $req, $id)
    {
        $this->validate($req, [
            'userIds' => 'required|array',
            'message' => 'required',
        ]);

        $userIds = $req->post('userIds');
        $message = $req->post('message');

        $this->notifiyApplicants($id, $userIds, $message);

        return $this->responseSuccess([]);
    }

    private function notifiyApplicants($postId, $userIds, $message)
    {
        $deviceTokens = [];
        $mobileNos = [];
        $title = '';
        $body = '';

        $applicants = User::whereIn('id', $userIds)
                ->get();
        foreach ($applicants as $applicant) {
            $notification = new Notification();
            $notification->user_id = $applicant->id;
            $notification->type = Notification::TYPE_SEND_POST_MSG;
            $notification->type_id = $postId;
            $params = ['post_id' => $postId];
            $notification->parameters = json_encode($params);
            $notification->title = Notification::TITLES[Notification::TYPE_SEND_POST_MSG];
            $notification->body = $message;
            $notification->save();

            $title = $notification->title;
            $body = $notification->body;

            preg_match('/(\+94)[0-9]{9}/', $applicant->mobile_no, $output_array);
            if ($output_array) {
                $mobileNos[] = $applicant->mobile_no;
            }

            foreach ($applicant->devices as $device) {
                $deviceTokens[] = $device->token;
            }
        }

        $this->sendPushNotification($deviceTokens, $title, $body);
        $this->sendSms($mobileNos, $body);
    }

    private function sendSms($mobileNos, $body)
    {
        $sms = new SMS();
        try {
            $sms->sendSMS($mobileNos, $body);
        } catch (ClientException $e) {
        }
    }

    private function sendPushNotification($deviceTokens, $title, $body)
    {
        $firebase = new Firebase();

        // maximum tokens per batch is 100 according to firebase
        foreach (array_chunk($deviceTokens, 100) as $chunkTokens) {
            $firebase->sendNotifications($chunkTokens, $title, $body);
        }
    }
}
