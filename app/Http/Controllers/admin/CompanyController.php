<?php

/**
 * Description of CompanyController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Company list.
     *
     * @response {
     *     "success": true,
     *     "message": "Successful",
     *     "data": [
     *         {
     *             "id": 1,
     *             "name": "company 1",
     *             "logo": "http://api.icm.lk/images/company/1561291227.jpg",
     *             "banner": "http://api.icm.lk/images/company/2561291227.jpg",
     *             "address": "addresss",
     *             "email": "sample@gmail.com",
     *             "phone": "23434343",
     *             "created_at": "2019-06-23 12:00:27",
     *             "updated_at": "2019-06-23 12:00:27"
     *         },
     *         {
     *             "id": 2,
     *             "name": "Lit solutions",
     *             "logo": "http://api.icm.lk/images/company/1561291480.jpg",
     *             "banner": "http://api.icm.lk/images/company/2561291480.jpg",
     *             "address": "Cecilia Chapman\n711-2880 Nulla St.",
     *             "email": "sample@gmail.com",
     *             "phone": "(257) 563-7401",
     *             "created_at": "2019-06-23 12:04:40",
     *             "updated_at": "2019-06-23 12:04:40"
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

        return $this->responseSuccess(Company::orderBy($sort, $order)->get());
    }

    /**
     * Company create.
     *
     * @bodyParam name string required Name.
     * @bodyParam address string required Address.
     * @bodyParam phone string required Phone.
     * @bodyParam logo file required Image.
     * @bodyParam banner file required Image.
     * @bodyParam email string required Image.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Created successfully!",
     *     "data": {
     *         "name": "Lit solutions",
     *         "address": "Cecilia Chapman\n711-2880 Nulla St.",
     *         "phone": "(257) 563-7401",
     *         "email": "sample@gmail.com",
     *         "logo": "http://api.icm.lk/images/company/1561291480.jpg",
     *         "banner": "http://api.icm.lk/images/company/3361291480.jpg",
     *         "updated_at": "2019-06-23 12:04:40",
     *         "created_at": "2019-06-23 12:04:40",
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
            'logo' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096',
            'banner' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096',
            'name' => 'required|max:50',
            'address' => 'required|max:100',
            'phone' => 'required|unique:companies|max:12',
            'email' => 'required|email|unique:companies|max:50',
        ]);

        $logo = $request->file('logo');
        $logoName = $this->uploadImage($logo, Company::IMG_PATH);

        $banner = $request->file('banner');
        $bannerName = $this->uploadImage($banner, Company::IMG_PATH);
        if ($logoName && $bannerName) {
            $company = Company::create(array_merge($request->all(), ['logo' => $logoName, 'banner' => $bannerName]));

            return $this->responseSuccess($company, 'Created successfully!');
        }

        return $this->responseBadRequest('Unsuccessful.');
    }

    /**
     * Company get record.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "id": 2,
     *         "name": "roserbery",
     *         "logo": "http://api.icm.lk/images/company/1561359160.jpg",
     *         "banner": "http://api.icm.lk/images/company/2561359160.jpg",
     *         "address": "21, Rosersbergsvägen 34",
     *         "phone": "+46761001562",
     *         "email": "antonlashan@gmail.com",
     *         "created_at": "2019-06-24 06:52:40",
     *         "updated_at": "2019-06-24 06:52:40"
     *     }
     * }
     *
     * @group Admin
     */
    public function getOne($id)
    {
        $record = Company::find($id);
        if ($record) {
            return $this->responseSuccess($record);
        }

        return $this->responseBadRequest('No record found.');
    }

    /**
     * Company update.
     *
     * Even this is a **PUT** request you have to send this as a **POST** request
     * because of `lumen` doesn't support form data via **PUT** request
     *
     * So we have to pass additional field with **POST** request.
     *
     * `_method=PUT` and rest of the following fields
     *
     * @bodyParam name string required Name.
     * @bodyParam address string required Address.
     * @bodyParam phone string required Phone.
     * @bodyParam logo file optional Image.
     * @bodyParam banner file optional Image.
     * @bodyParam email string required Image.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Updated successfully!",
     *     "data": null
     * }
     *
     * @response 422 {
     *     "success": false,
     *     "message": "Validation error",
     *     "data": {
     *         "phone": [
     *             "The phone field is required."
     *         ]
     *     }
     * }
     *
     * @group Admin
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'logo' => 'image|mimes:jpg,jpeg,png,gif|max:4096',
            'banner' => 'image|mimes:jpg,jpeg,png,gif|max:4096',
            'name' => 'required|max:50',
            'address' => 'required|max:100',
            'phone' => 'required|max:12|unique:companies,phone,'.$id,
            'email' => 'required|max:50|email|unique:companies,email,'.$id,
        ]);

        $model = Company::find($id);
        if (!$model) {
            return $this->responseBadRequest('No record found.');
        }

        $logo = $request->file('logo');
        $logoName = $model->getAttributes()['logo'];

        if ($logo) {
            $newLogoName = $this->uploadImage($logo, Company::IMG_PATH);

            if ($newLogoName && $model->update(['logo' => $newLogoName])) {
                $this->deleteImage(Company::IMG_PATH, $logoName);
            }
        }

        $banner = $request->file('banner');
        $bannerName = $model->getAttributes()['banner'];

        if ($banner) {
            $newBannerName = $this->uploadImage($banner, Company::IMG_PATH);

            if ($newBannerName && $model->update(['banner' => $newBannerName])) {
                $this->deleteImage(Company::IMG_PATH, $bannerName);
            }
        }

        $record = $model->update(array_merge($request->except(['logo', 'banner'])));

        if ($record) {
            return $this->responseSuccess($record);
        }

        return $this->responseBadRequest('Unsuccessful.');
    }

    /**
     * Company delete.
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
        if (Company::find($id)->delete()) {
            return $this->responseSuccess(null);
        }

        return $this->responseBadRequest('Unsuccessful.');
    }
}
