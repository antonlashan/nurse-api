<?php

/**
 * Description of PostCommentReplyController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\PostReply;
use Illuminate\Http\Request;
use App\Models\PostComment;

class PostCommentReplyController extends Controller
{
    /**
     * PostCommentReply add reply comment.
     *
     * @queryParam cid required Comment ID.
     * @bodyParam comment string required Reply comment.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "post_comment_id": 3,
     *         "comment": "reply 5",
     *         "updated_at": "2019-07-05 13:46:31",
     *         "created_at": "2019-07-05 13:46:31",
     *         "id": 4
     *     }
     * }
     *
     * @group Client
     */
    public function create($cid, Request $request)
    {
        $record = PostComment::find($cid);
        if (!$record) {
            return $this->responseBadRequest('Comment not found.');
        }

        $this->validate($request, [
            'comment' => 'required',
        ]);

        $reply = new PostReply();
        $reply->post_comment_id = $cid;
        $reply->comment = $request->input('comment');

        if ($reply->save()) {
            return $this->responseSuccess($reply);
        }

        return $this->responseBadRequest('Unsuccessful');
    }

    /**
     * PostCommentReply update reply.
     *
     * Even this is a **PUT** request you have to send this as a **POST** request
     * because of `lumen` doesn't support form data via **PUT** request
     *
     * So we have to pass additional field with **POST** request.
     *
     * `_method=PUT` and rest of the following fields
     *
     * @queryParam cid required Post comment ID.
     * @queryParam id required Reply ID.
     * @bodyParam comment string required Reply comment.
     * @bodyParam _method string required _method=PUT.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "id": 2,
     *         "post_comment_id": 3,
     *         "comment": "reply 3 edit",
     *         "created_at": "2019-07-05 13:41:56",
     *         "updated_at": "2019-07-05 13:43:03"
     *     }
     * }
     *
     * @group Client
     */
    public function update($cid, $id, Request $request)
    {
        $reply = PostReply::find($id);
        if (!$reply) {
            return $this->responseBadRequest('Comment not found.');
        }

        if ($reply->user_id !== $request->user()->id) {
            return $this->responseUnauthorized();
        }

        $this->validate($request, [
            'comment' => 'required',
        ]);

        $reply->comment = $request->input('comment');

        if ($reply->update()) {
            return $this->responseSuccess($reply);
        }

        return $this->responseBadRequest('Unsuccessful');
    }

    /**
     * PostCommentReply delete reply.
     *
     * @queryParam cid required Post comment ID.
     * @queryParam id required Reply ID.
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
    public function delete($cid, $id, Request $request)
    {
        $reply = PostReply::find($id);
        if (!$reply) {
            return $this->responseBadRequest('Reply comment not found.');
        }

        if ($reply->user_id !== $request->user()->id) {
            return $this->responseUnauthorized();
        }

        if ($reply->delete()) {
            return $this->responseSuccess(null);
        }

        return $this->responseBadRequest('Unsuccessful');
    }
}
