<?php

/**
 * Description of CompanyPostApplicationController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Models\CompanyPostApplication;
use Illuminate\Http\Request;

class CompanyPostApplicationController extends Controller
{
    /**
     * CompanyPostApplication list.
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
     *             "total": 5
     *         },
     *         "list": [
     *             {
     *                 "id": 1,
     *                 "user_id": 2,
     *                 "status": "pending",
     *                 "first_name": "Sean",
     *                 "last_name": "Marshall",
     *                 "position": "Nurse (Female\/Male) - Colombo 5",
     *                 "company_name": "Asiri Hospital Holdings Pvt Ltd"
     *             },
     *             {
     *                 "id": 2,
     *                 "user_id": 3,
     *                 "status": "pending",
     *                 "first_name": "John",
     *                 "last_name": "Edmunds",
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

        CompanyPostApplication::$staticMakeVisible = ['user_id'];
        $q = CompanyPostApplication::select([
                    'company_post_applications.id',
                    'company_post_applications.user_id',
                    'company_post_applications.status',
                    'user_details.first_name',
                    'user_details.last_name',
                    'company_posts.position',
                    'companies.name as company_name',
                ])
                ->join('user_details', 'company_post_applications.user_id', '=', 'user_details.user_id')
                ->join('company_posts', 'company_post_applications.company_post_id', '=', 'company_posts.id')
                ->join('companies', 'company_posts.company_id', '=', 'companies.id');
        if ('position' === $sort) {
            $q->orderBy('company_posts.position', $order);
        }
        if ('user' === $sort) {
            $q->orderBy('user_details.first_name', $order);
        }
        if ('id' === $sort) {
            $q->orderBy('company_post_applications.id', $order);
        }
        if ('company' === $sort) {
            $q->orderBy('companies.name', $order);
        }
        if ('status' === $sort) {
            $q->orderBy('company_post_applications.status', $order);
        }
        $res = $q->paginate(Config::get('consts.page_size'));

        return $this->responseSuccess($this->getPagination($res, $res->items()));
    }

    /**
     * CompanyPostApplication update.
     *
     * Even this is a **PUT** request you have to send this as a **POST** request
     * because of `lumen` doesn't support form data via **PUT** request
     *
     * So we have to pass additional field with **POST** request.
     *
     * `_method=PUT` and rest of the following fields
     *
     * @bodyParam status string required 'pending' or 'accept' or 'reject'.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successfully updated.",
     *     "data": null
     * }
     *
     * @group Admin
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);
        $model = CompanyPostApplication::find($id);

        if ($model) {
            $model->status = $request->input('status');
            if ($model->save()) {
                return $this->responseSuccess(null, 'Successfully updated.');
            }

            return $this->responseBadRequest('Unsuccesful.');
        }

        return $this->responseBadRequest('No record found.');
    }
}
