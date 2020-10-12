<?php

/**
 * Description of PostCommentController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Models\PostComment;
use App\Models\PostReply;

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
     *                 "can_edit": true,
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
     *                 "can_edit": true,
     *                 "post_replies": [
     *                     {
     *                         "id": 1,
     *                         "post_comment_id": 3,
     *                         "comment": "reply 1",
     *                         "created_at": "2019-07-05 13:41:51",
     *                         "updated_at": "2019-07-05 13:41:51",
     *                         "can_edit": true,
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
     *                         "can_edit": false,
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
     *                 "can_edit": false,
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
     * @group Client
     */
    public function lists($pid)
    {
        PostReply::$staticMakeVisible = ['can_edit'];
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
        $res->makeVisible(['can_edit']);

        return $this->responseSuccess($this->getPagination($res, $res->items()));
    }

    /**
     * PostComment add comment.
     *
     * @queryParam pid required Post ID.
     * @bodyParam comment string required Comment.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "post_id": 1,
     *         "comment": "test",
     *         "updated_at": "2019-07-05 11:46:24",
     *         "created_at": "2019-07-05 11:46:24",
     *         "id": 5
     *     }
     * }
     *
     * @group Client
     */
    public function create($pid, Request $request)
    {
        $record = Post::find($pid);
        if (!$record) {
            return $this->responseBadRequest('Post not found.');
        }

        $this->validate($request, [
            'comment' => 'required',
        ]);

        $comment = new PostComment();
        $comment->post_id = $pid;
        $comment->comment = $request->input('comment');

        if ($comment->save()) {
            return $this->responseSuccess($comment);
        }

        return $this->responseBadRequest('Unsuccessful');
    }

    /**
     * PostComment update comment.
     *
     * Even this is a **PUT** request you have to send this as a **POST** request
     * because of `lumen` doesn't support form data via **PUT** request
     *
     * So we have to pass additional field with **POST** request.
     *
     * `_method=PUT` and rest of the following fields
     *
     * @queryParam pid required Post ID.
     * @queryParam id required Comment ID.
     * @bodyParam comment string required Comment.
     * @bodyParam _method string required _method=PUT.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "post_id": 1,
     *         "comment": "test",
     *         "updated_at": "2019-07-05 11:46:24",
     *         "created_at": "2019-07-05 11:46:24",
     *         "id": 5
     *     }
     * }
     *
     * @group Client
     */
    public function update($pid, $id, Request $request)
    {
        $comment = PostComment::find($id);
        if (!$comment) {
            return $this->responseBadRequest('Comment not found.');
        }

        if ($comment->user_id !== $request->user()->id) {
            return $this->responseUnauthorized();
        }

        $this->validate($request, [
            'comment' => 'required',
        ]);

        $comment->comment = $request->input('comment');

        if ($comment->update()) {
            return $this->responseSuccess($comment);
        }

        return $this->responseBadRequest('Unsuccessful');
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
     * @group Client
     */
    public function delete($pid, $id, Request $request)
    {
        $comment = PostComment::find($id);
        if (!$comment) {
            return $this->responseBadRequest('Comment not found.');
        }

        if ($comment->user_id !== $request->user()->id) {
            return $this->responseUnauthorized();
        }

        if ($comment->delete()) {
            return $this->responseSuccess(null);
        }

        return $this->responseBadRequest('Unsuccessful');
    }
}
