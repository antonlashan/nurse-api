<?php

/**
 * Description of PostController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategoryMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Post list.
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
     *             "total": 2
     *         },
     *         "list": [
     *             {
     *                 "categories": "Category 1, Category 2, Category 3",
     *                 "id": 1,
     *                 "title": "What is Lorem Ipsum?",
     *                 "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
     *                 "image": "http://api.icm.lk\/images\/post\/777777.jpg",
     *                 "likes": 0,
     *                 "created_at": "2019-07-10 13:14:12",
     *                 "updated_at": "2019-07-10 13:14:12"
     *             },
     *             {
     *                 "categories": "Category 2, Category 3",
     *                 "id": 2,
     *                 "title": "Why do we use it?",
     *                 "description": "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).",
     *                 "image": "http://api.icm.lk\/images\/post\/888888.jpg",
     *                 "likes": 0,
     *                 "created_at": "2019-07-10 13:14:12",
     *                 "updated_at": "2019-07-10 13:14:12"
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

        $q = Post::select([
                    DB::raw('GROUP_CONCAT(c.name SEPARATOR ", ") as categories'),
                    'posts.*',
                ])
                ->leftJoin('post_category_map as m', 'posts.id', '=', 'm.post_id')
                ->leftJoin('post_categories as c', 'm.category_id', '=', 'c.id')
                ->groupBy('posts.id');

        switch ($sort) {
            case 'id':
                $q->orderBy('posts.id', $order);
                break;
            case 'title':
                $q->orderBy('posts.title', $order);
                break;
            case 'category':
                $q->orderBy('c.name', $order);
                break;
            default:
                $q->orderBy('posts.created_at', 'desc');
        }
        $res = $q->paginate(Config::get('consts.page_size'));

        return $this->responseSuccess($this->getPagination($res, $res->items()));
    }

    /**
     * Post create.
     *
     * @bodyParam image file required Image.
     * @bodyParam title string required Title.
     * @bodyParam description string optional Description.
     * @bodyParam category_id string required Category ID.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Created successfully!",
     *     "data": {
     *         "title": "2nd post",
     *         "description": "<p>test<\/p>",
     *         "image": "http://api.icm.lk\/images\/post\/15622536325d1e1940c17d3.jpg",
     *         "updated_at": "2019-07-04 15:20:32",
     *         "created_at": "2019-07-04 15:20:32",
     *         "id": 2
     *     }
     * }
     *
     * @response 422 {
     *     "success": false,
     *     "message": "Validation error",
     *     "data": {
     *         "image": [
     *             "The image field is required."
     *         ]
     *     }
     * }
     *
     * @group Admin
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096',
            'title' => 'required|max:100',
            'categories' => 'required',
        ]);

        $image = $request->file('image');
        $imageName = $this->uploadImage($image, Post::IMG_PATH);
        $categories = $request->post('categories');

        if ($imageName) {
            $model = Post::create(array_merge($request->all(), ['image' => $imageName]));
            if ($model->id) {
                $this->saveCategories($model->id, $categories);
            }

            return $this->responseSuccess($model, 'Created successfully!');
        }

        return $this->responseBadRequest('Unsuccessful.');
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
     *         "categories": [
     *             {
     *                 "id": 2,
     *                 "name": "Category 2",
     *                 "created_at": "2019-08-17 23:04:28",
     *                 "updated_at": "2019-08-17 23:04:28"
     *             },
     *             {
     *                 "id": 4,
     *                 "name": "Category 4",
     *                 "created_at": "2019-08-17 23:04:28",
     *                 "updated_at": "2019-08-17 23:04:28"
     *             }
     *         ]
     *     }
     * }
     *
     * @group Admin
     */
    public function getOne($id)
    {
        $record = Post::with('categories')->find($id);
        if ($record) {
            return $this->responseSuccess($record);
        }

        return $this->responseBadRequest('No record found.');
    }

    /**
     * Post update.
     *
     * Even this is a **PUT** request you have to send this as a **POST** request
     * because of `lumen` doesn't support form data via **PUT** request
     *
     * So we have to pass additional field with **POST** request.
     *
     * `_method=PUT` and rest of the following fields
     *
     * @bodyParam image file optional Image.
     * @bodyParam title string required Title.
     * @bodyParam description string optional Description.
     * @bodyParam category_id string required Category ID.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Updated successfully!",
     *     "data": true
     * }
     *
     * @response 422 {
     *     "success": false,
     *     "message": "Validation error",
     *     "data": {
     *         "title": [
     *             "The title field is required."
     *         ]
     *     }
     * }
     *
     * @group Admin
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:4096',
            'title' => 'required|max:100',
            'categories' => 'required',
        ]);

        $categories = $request->post('categories');

        $model = Post::find($id);
        if (!$model) {
            return $this->responseBadRequest('No record found.');
        }

        $logo = $request->file('image');
        $logoName = $model->getAttributes()['image'];

        if ($logo) {
            $newLogoName = $this->uploadImage($logo, Post::IMG_PATH);

            if ($newLogoName && $model->update(['image' => $newLogoName])) {
                $this->deleteImage(Post::IMG_PATH, $logoName);
            }
        }

        $record = $model->update($request->except(['image']));

        if ($record) {
            if ($model->id) {
                $this->saveCategories($model->id, $categories);
            }

            return $this->responseSuccess($record);
        }

        return $this->responseBadRequest('Unsuccessful.');
    }

    private function saveCategories($postId, $categories)
    {
        PostCategoryMap::where('post_id', $postId)->delete();

        $catIds = explode(',', $categories);
        foreach ($catIds as $id) {
            $map = new PostCategoryMap();
            $map->post_id = $postId;
            $map->category_id = $id;
            $map->save();
        }
    }

    /**
     * Post delete.
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
        if (Post::find($id)->delete()) {
            return $this->responseSuccess(null);
        }

        return $this->responseBadRequest('Unsuccessful.');
    }
}
