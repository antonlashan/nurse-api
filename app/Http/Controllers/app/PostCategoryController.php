<?php

/**
 * Description of PostCategoryController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;

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
     * @group Client
     */
    public function lists()
    {
        return $this->responseSuccess(PostCategory::all());
    }
}
