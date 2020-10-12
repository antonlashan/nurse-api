<?php

/**
 * Description of PostCategoryController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    /**
     * PostCategory list.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": [
     *         {
     *             "id": 1,
     *             "name": "Cat 3",
     *             "created_at": "2019-07-04 13:40:19",
     *             "updated_at": "2019-07-04 13:43:56"
     *         },
     *         {
     *             "id": 2,
     *             "name": "Cate 2",
     *             "created_at": "2019-07-04 13:47:33",
     *             "updated_at": "2019-07-04 13:47:33"
     *         }
     *     ]
     * }
     *
     * @group Admin
     */
    public function lists(Request $req)
    {
        $sort = $req->query('sort', 'name');
        $order = $req->query('order', 'asc');

        return $this->responseSuccess(PostCategory::orderBy($sort, $order)->get());
    }

    /**
     * PostCategory get record.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "id": 1,
     *         "name": "Cat 3",
     *         "created_at": "2019-07-04 13:40:19",
     *         "updated_at": "2019-07-04 13:43:56"
     *     }
     * }
     *
     * @group Admin
     */
    public function getOne($id)
    {
        $record = PostCategory::find($id);
        if ($record) {
            return $this->responseSuccess($record);
        }

        return $this->responseBadRequest('No record found.');
    }

    /**
     * PostCategory create.
     *
     * @bodyParam name string optional Name.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Created successfully!",
     *     "data": {
     *         "name": "Cate 2",
     *         "updated_at": "2019-07-04 13:47:33",
     *         "created_at": "2019-07-04 13:47:33",
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
            'name' => 'required|max:20',
        ]);

        $model = PostCategory::create($request->all());
        if ($model) {
            return $this->responseSuccess($model, 'Created successfully!');
        }

        return $this->responseBadRequest('Unsuccessful.');
    }

    /**
     * PostCategory update.
     *
     * Even this is a **PUT** request you have to send this as a **POST** request
     * because of `lumen` doesn't support form data via **PUT** request
     *
     * So we have to pass additional field with **POST** request.
     *
     * `_method=PUT` and rest of the following fields
     *
     * @bodyParam name string optional Name.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Updated successfully!",
     *     "data": {
     *         "id": 1,
     *         "name": "Cat 3",
     *         "created_at": "2019-07-04 13:40:19",
     *         "updated_at": "2019-07-04 13:43:56"
     *     }
     * }
     *
     * @group Admin
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:20',
        ]);

        $model = PostCategory::find($id);
        if ($model->update($request->all())) {
            return $this->responseSuccess($model, 'Updated successfully!');
        }

        return $this->responseBadRequest('No record found.');
    }

    /**
     * PostCategory delete.
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
        if (PostCategory::find($id)->delete()) {
            return $this->responseSuccess(null);
        }

        return $this->responseBadRequest('Unsuccessful.');
    }
}
