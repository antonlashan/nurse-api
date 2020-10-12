<?php

/**
 * Description of PostController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Models\PostLike;

class PostController extends Controller
{
    /**
     * Post list.
     *
     * @queryParam category_id Category ID.
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
     *             "total": 1
     *         },
     *         "list": [
     *             {
     *                 "id": 1,
     *                 "title": "AA bb eee",
     *                 "description": "<p>dd<\/p>",
     *                 "image": "http://api.icm.lk\/images\/post\/15622527715d1e15e3d045d.jpg",
     *                 "likes": 2,
     *                 "category_id": 1,
     *                 "created_at": "2019-07-04 15:06:11",
     *                 "updated_at": "2019-07-04 15:12:29",
     *                 "has_liked": true,
     *                 "categories": [
     *                     {
     *                         "id": 2,
     *                         "name": "Category 2",
     *                         "created_at": "2019-08-17 23:04:28",
     *                         "updated_at": "2019-08-17 23:04:28"
     *                     },
     *                     {
     *                         "id": 5,
     *                         "name": "Category 5",
     *                         "created_at": "2019-08-17 23:04:28",
     *                         "updated_at": "2019-08-17 23:04:28"
     *                     }
     *                 ]
     *             }
     *         ]
     *     }
     * }
     *
     * @group Client
     */
    public function lists(Request $request)
    {
        $catId = $request->query('category_id');

        $res = Post::with([
                    'categories',
                    'postLikes' => function ($q) use ($request) {
                        $q->where('user_id', '=', $request->user()->id);
                    }, ])
                ->whereHas('categories', function ($query) use ($catId) {
                    if ($catId) {
                        $query->where('category_id', '=', $catId);
                    }
                })
                ->orderBy('created_at', 'desc')
                ->paginate(Config::get('consts.page_size'));
        $res->makeHidden(['postLikes'])
            ->makeVisible(['has_liked']);

        return $this->responseSuccess($this->getPagination($res, $res->items()));
    }

    /**
     * Post get record.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "id": 1,
     *         "title": "AA bb eee",
     *         "description": "<p>dd<\/p>",
     *         "image": "http://api.icm.lk\/images\/post\/15622527715d1e15e3d045d.jpg",
     *         "likes": 0,
     *         "category_id": 1,
     *         "created_at": "2019-07-04 15:06:11",
     *         "updated_at": "2019-07-04 15:12:29",
     *         "has_liked": true,
     *         "categories": [
     *             {
     *                 "id": 2,
     *                 "name": "Category 2",
     *                 "created_at": "2019-08-17 23:04:28",
     *                 "updated_at": "2019-08-17 23:04:28"
     *             },
     *             {
     *                 "id": 5,
     *                 "name": "Category 5",
     *                 "created_at": "2019-08-17 23:04:28",
     *                 "updated_at": "2019-08-17 23:04:28"
     *             }
     *         ]
     *     }
     * }
     *
     * @group Client
     */
    public function getOne($id, Request $request)
    {
        $record = Post::where('id', $id)
                ->with([
                    'categories',
                    'postLikes' => function ($q) use ($request) {
                        $q->where('user_id', '=', $request->user()->id);
                    }, ])
                ->first();
        if ($record) {
            $record->makeHidden(['postLikes'])
                ->makeVisible(['has_liked']);
        }
        if ($record) {
            return $this->responseSuccess($record);
        }

        return $this->responseBadRequest('No record found.');
    }

    /**
     * Post hit like.
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
     *     "data": {
     *         "id": 1,
     *         "likes": 2
     *     }
     * }
     *
     * @group Client
     */
    public function like($id, Request $request)
    {
        $record = Post::select('id', 'likes')->find($id);
        if (!$record) {
            return $this->responseBadRequest('No record found.');
        }

        if (PostLike::firstOrCreate(['post_id' => $id, 'user_id' => $request->user()->id])) {
            $count = PostLike::where('post_id', $id)->count();
            $record->likes = $count;
            $record->update();

            return $this->responseSuccess($record);
        }

        return $this->responseBadRequest('Unsuccessful');
    }

    /**
     * Post hit dislike.
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
     *     "data": {
     *         "id": 1,
     *         "likes": 0
     *     }
     * }
     *
     * @group Client
     */
    public function dislike($id, Request $request)
    {
        $record = Post::select('id', 'likes')->find($id);
        if (!$record) {
            return $this->responseBadRequest('No record found.');
        }

        $like = PostLike::where('post_id', $id)
                ->where('user_id', $request->user()->id);
        if ($like->delete()) {
            $count = PostLike::where('post_id', $id)->count();
            $record->likes = $count;
            $record->update();
        }

        return $this->responseSuccess($record);
    }
}
