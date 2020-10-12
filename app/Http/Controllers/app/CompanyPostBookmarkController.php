<?php

/**
 * Description of CompanyPostBookmarkController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Models\CompanyPostBookmark;
use Illuminate\Http\Request;

class CompanyPostBookmarkController extends Controller
{
    /**
     * CompanyPostBookmark bookmark.
     *
     * @bodyParam company_post_id integer required Company post ID.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Created successfully!",
     *     "data": {
     *         "id": 5,
     *         "company_post_id": 3
     *     }
     * }
     *
     * @group Client
     */
    public function bookmark(Request $request)
    {
        $this->validate($request, [
            'company_post_id' => 'required',
        ]);

        try {
            $post = CompanyPostBookmark::firstOrCreate($request->all());
            if ($post) {
                return $this->responseSuccess($post, 'Created successfully!');
            }
        } catch (\Exception $e) {
            return $this->responseBadRequest($e->getMessage());
        }
    }

    /**
     * CompanyPostBookmark list.
     *
     * @queryParam page Page id.
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
     *             "total": 1
     *         },
     *         "list": [
     *             {
     *                 "id": 5,
     *                 "company_post_id": 3,
     *                 "company_post": {
     *                     "id": 3,
     *                     "company_id": 5,
     *                     "position": "test",
     *                     "description": "test2",
     *                     "created_at": "2019-06-24 07:19:23",
     *                     "updated_at": "2019-06-25 18:52:01",
     *                     "company": {
     *                          "id": 1,
     *                          "name": "Asiri Hospital Holdings Pvt Ltd",
     *                          "logo": "http://api.icm.lk/thumb/w2000/images/company/111111.jpg",
     *                          "banner": "http://api.icm.lk/thumb/w2000/images/company/15641511165d3b0d4c1c7de.jpeg",
     *                          "address": "Colombo 5",
     *                          "phone": "2575637401",
     *                          "email": "test@chapman.com",
     *                          "created_at": "2019-07-10 23:44:12",
     *                          "updated_at": "2019-07-26 14:25:16"
     *                      }
     *                 }
     *             }
     *         ]
     *     }
     * }
     *
     * @group Client
     */
    public function lists(Request $request)
    {
        $res = CompanyPostBookmark::with('companyPost.company')
                ->where(['user_id' => $request->user()->id])
                ->paginate(Config::get('consts.page_size'));

        return $this->responseSuccess($this->getPagination($res, $res->items()));
    }
}
