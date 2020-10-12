<?php

/**
 * Description of CompanyPostApplicationController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Models\CompanyPostApplication;
use Illuminate\Http\Request;

class CompanyPostApplicationController extends Controller
{
    /**
     * CompanyPostApplication apply.
     *
     * @bodyParam company_post_id integer required Company post ID.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "You can apply for this post.",
     *     "data": true
     * }
     *
     * @response 422
     * {
     *     "success": false,
     *     "message": "User already applied.",
     *     "data": null
     * }
     *
     * @response 422
     * {
     *     "success": false,
     *     "message": "Please complete your profile.",
     *     "data": null
     * }
     *
     * @group Client
     */
    public function apply(Request $request)
    {
        $this->validate($request, [
            'company_post_id' => 'required',
        ]);

        if (CompanyPostApplication::isApplied($request->input('company_post_id'), $request->user()->id)) {
            return $this->responseValidation('User already applied.');
        }

        if (!$request->user()->userDetail->is_complete_profile) {
            return $this->responseValidation('Please complete your profile.');
        }

        return $this->responseSuccess(true, 'You can apply for this post.');
    }

    /**
     * CompanyPostApplication confirm.
     *
     * @bodyParam company_post_id integer required Company post ID.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Created successfully!",
     *     "data": {
     *         "company_post_id": "2",
     *         "updated_at": "2019-06-27 16:51:21",
     *         "created_at": "2019-06-27 16:51:21",
     *         "id": 1
     *     }
     * }
     *
     * @response 422
     * {
     *     "success": false,
     *     "message": "User already applied.",
     *     "data": null
     * }
     *
     * @response 422
     * {
     *     "success": false,
     *     "message": "Please complete your profile.",
     *     "data": null
     * }
     *
     * @group Client
     */
    public function confirm(Request $request)
    {
        $this->validate($request, [
            'company_post_id' => 'required',
        ]);

        if (CompanyPostApplication::isApplied($request->input('company_post_id'), $request->user()->id)) {
            return $this->responseValidation('User already applied.');
        }

        if (!$request->user()->userDetail->is_complete_profile) {
            return $this->responseValidation('Please complete your profile.');
        }

        try {
            $post = new CompanyPostApplication();
            $post->fill($request->all());
            if ($post->save()) {
                return $this->responseSuccess($post->getAttributes(), 'Applied successfully!');
            }
        } catch (\Exception $e) {
            return $this->responseBadRequest($e->getMessage());
        }
    }

    /**
     * CompanyPostApplication list.
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
     *                 "status": "pending",
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
        $res = CompanyPostApplication::with('companyPost.company')
                ->where('user_id', $request->user()->id)
                ->paginate(Config::get('consts.page_size'));

        return $this->responseSuccess($this->getPagination($res, $res->items()));
    }
}
