<?php

/**
 * Description of CompanyPostBookmarkController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Models\CompanyPostBookmark;
use Illuminate\Http\Request;

class CompanyPostBookmarkController extends Controller
{
    /**
     * CompanyPostBookmark list.
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
     *                 "id": 1,
     *                 "user_id": 2,
     *                 "first_name": "Sean",
     *                 "last_name": "Marshall",
     *                 "position": "Nurse (Female\/Male) - Colombo 5",
     *                 "company_name": "Asiri Hospital Holdings Pvt Ltd"
     *             },
     *             {
     *                 "id": 2,
     *                 "user_id": 2,
     *                 "first_name": "Sean",
     *                 "last_name": "Marshall",
     *                 "position": "Female Executive - Nugegoda",
     *                 "company_name": "Wellfort Management Pvt Ltd"
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

        CompanyPostBookmark::$staticMakeVisible = ['user_id'];
        $q = CompanyPostBookmark::select([
                    'company_post_bookmarks.id',
                    'company_post_bookmarks.user_id',
                    'user_details.first_name',
                    'user_details.last_name',
                    'company_posts.position',
                    'companies.name as company_name',
                ])
                ->join('user_details', 'company_post_bookmarks.user_id', '=', 'user_details.user_id')
                ->join('company_posts', 'company_post_bookmarks.company_post_id', '=', 'company_posts.id')
                ->join('companies', 'company_posts.company_id', '=', 'companies.id');
        if ('position' === $sort) {
            $q->orderBy('company_posts.position', $order);
        }
        if ('user' === $sort) {
            $q->orderBy('user_details.first_name', $order);
        }
        if ('id' === $sort) {
            $q->orderBy('company_post_bookmarks.id', $order);
        }
        if ('company' === $sort) {
            $q->orderBy('companies.name', $order);
        }
        $res = $q->paginate(Config::get('consts.page_size'));

        return $this->responseSuccess($this->getPagination($res, $res->items()));
    }
}
