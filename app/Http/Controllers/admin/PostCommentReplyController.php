<?php

/**
 * Description of PostCommentReplyController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PostReply;

class PostCommentReplyController extends Controller
{
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
     * @group Admin
     */
    public function delete($cid, $id)
    {
        $reply = PostReply::find($id);
        if (!$reply) {
            return $this->responseBadRequest('Reply comment not found.');
        }

        if ($reply->delete()) {
            return $this->responseSuccess(null);
        }

        return $this->responseBadRequest('Unsuccessful');
    }
}
