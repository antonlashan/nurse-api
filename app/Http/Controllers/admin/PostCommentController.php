<?php

/**
 * Description of PostCommentController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Models\PostComment;

class PostCommentController extends Controller
{
    /**
     * PostComment list.
     *
     * @queryParam pid required Post ID.
     * @queryParam page Page number.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "paginator": {
     *             "pages": 1,
     *             "current_page": 1,
     *             "per_page": 10,
     *             "total": 4
     *         },
     *         "list": [
     *             {
     *                 "id": 6,
     *                 "post_id": 1,
     *                 "comment": "test",
     *                 "created_at": "2019-07-05 11:54:18",
     *                 "updated_at": "2019-07-05 11:54:18",
     *                 "post_replies": [],
     *                 "user_detail": {
     *                     "first_name": "Client",
     *                     "last_name": "",
     *                     "gender": "male",
     *                     "prof_pic": null
     *                 }
     *             },
     *             {
     *                 "id": 3,
     *                 "post_id": 1,
     *                 "comment": "test",
     *                 "created_at": "2019-07-05 11:45:53",
     *                 "updated_at": "2019-07-05 11:45:53",
     *                 "post_replies": [
     *                     {
     *                         "id": 1,
     *                         "post_comment_id": 3,
     *                         "comment": "reply 1",
     *                         "created_at": "2019-07-05 13:41:51",
     *                         "updated_at": "2019-07-05 13:41:51",
     *                         "user_detail": {
     *                             "first_name": "Client",
     *                             "last_name": "",
     *                             "gender": "male",
     *                             "prof_pic": null
     *                         }
     *                     },
     *                     {
     *                         "id": 3,
     *                         "post_comment_id": 3,
     *                         "comment": "reply 3",
     *                         "created_at": "2019-07-05 13:42:04",
     *                         "updated_at": "2019-07-05 13:42:04",
     *                         "user_detail": {
     *                             "first_name": "Admin",
     *                             "last_name": "",
     *                             "gender": "male",
     *                             "prof_pic": null
     *                         }
     *                     }
     *                 ],
     *                 "user_detail": {
     *                     "first_name": "Client",
     *                     "last_name": "",
     *                     "gender": "male",
     *                     "prof_pic": null
     *                 }
     *             },
     *             {
     *                 "id": 2,
     *                 "post_id": 1,
     *                 "comment": "test",
     *                 "created_at": "2019-07-05 11:45:52",
     *                 "updated_at": "2019-07-05 11:45:52",
     *                 "post_replies": [],
     *                 "user_detail": {
     *                     "first_name": "Admin",
     *                     "last_name": "",
     *                     "gender": "male",
     *                     "prof_pic": null
     *                 }
     *             }
     *         ]
     *     }
     * }
     *
     * @group Admin
     */
    public function lists($pid)
    {
        $res = PostComment::where('post_id', $pid)
                ->with([
                    'postReplies' => function ($q) {
                        $q->orderBy('created_at', 'desc');
                    },
                    'postReplies.userDetail' => function ($q) {
                        $q->select(['user_id', 'first_name', 'last_name', 'gender', 'prof_pic']);
                    },
                    'userDetail' => function ($q) {
                        $q->select(['user_id', 'first_name', 'last_name', 'gender', 'prof_pic']);
                    }, ])
                ->orderBy('created_at', 'desc')
                ->paginate(Config::get('consts.page_size'));

        return $this->responseSuccess($this->getPagination($res, $res->items()));
    }

    /**
     * PostComment delete comment.
     *
     * @queryParam pid required Post ID.
     * @queryParam id required Comment ID.
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
    public function delete($pid, $id, Request $request)
    {
        $comment = PostComment::find($id);
        if (!$comment) {
            return $this->responseBadRequest('Comment not found.');
        }

        if ($comment->delete()) {
            return $this->responseSuccess(null);
        }

        return $this->responseBadRequest('Unsuccessful');
    }
}
