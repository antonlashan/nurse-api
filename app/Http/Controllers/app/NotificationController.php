<?php

/**
 * Description of NotificationController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Models\Notification;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Notification list.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "paginator": {
     *             "pages": 2,
     *             "current_page": 1,
     *             "per_page": 20,
     *             "total": 28
     *         },
     *         "list": [
     *             {
     *                 "id": 38,
     *                 "type": "create_new_post",
     *                 "type_id": 34,
     *                 "parameters": {
     *                     "post_id": 34
     *                 },
     *                 "title": "Job post",
     *                 "body": "We found your perfect match at company Apply Now!",
     *                 "unread": 1,
     *                 "created_at": "2019-09-05 20:26:54",
     *                 "updated_at": "2019-09-05 20:26:54"
     *             },
     *             {
     *                 "id": 37,
     *                 "type": "create_new_post",
     *                 "type_id": 33,
     *                 "parameters": {
     *                     "post_id": 33
     *                 },
     *                 "title": "Job post",
     *                 "body": "We found your perfect match at company Apply Now!",
     *                 "unread": 1,
     *                 "created_at": "2019-09-05 20:26:46",
     *                 "updated_at": "2019-09-05 20:26:46"
     *             }
     *         ]
     *     }
     * }
     *
     * @group Client
     */
    public function lists(Request $request)
    {
        $dayLimits = 21; // 3 weeks
        $date = Carbon::today()->subDays($dayLimits);

        $res = Notification::where('user_id', '=', $request->user()->id)
                ->where('created_at', '>=', $date)
                ->orderBy('created_at', 'desc')
                ->paginate(Config::get('consts.page_size'));

        return $this->responseSuccess($this->getPagination($res, $res->items()));
    }

    /**
     * Notification unread count.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": 4
     * }
     *
     * @group Client
     */
    public function unreadCnt(Request $request)
    {
        $res = Notification::where('user_id', '=', $request->user()->id)
                ->where('unread', '=', 1)
                ->count();

        return $this->responseSuccess($res);
    }

    /**
     * Notification read.
     *
     * Even this is a **PUT** request you have to send this as a **POST** request
     * because of `lumen` doesn't support form data via **PUT** request
     *
     * So we have to pass additional field with **POST** request.
     *
     * `_method=PUT` and rest of the following fields
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": 4
     * }
     *
     * @group Client
     */
    public function read(Request $request)
    {
        $res = Notification::where('user_id', '=', $request->user()->id)
                ->where('unread', '=', 1)
                ->update(['unread' => 0]);

        return $this->responseSuccess($res);
    }
}
