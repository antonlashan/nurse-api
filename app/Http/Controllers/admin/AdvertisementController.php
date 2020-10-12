<?php

/**
 * Description of AdvertisementController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    /**
     * Advertisement list.
     *
     * @response {
     *     "success": true,
     *     "message": "Successful",
     *     "data": [
     *         {
     *             "id": 1,
     *             "name": "company 1",
     *             "image": "http://api.icm.lk/images/advertisement/1561291227.jpg",
     *             "created_at": "2019-06-23 12:00:27",
     *             "updated_at": "2019-06-23 12:00:27"
     *         },
     *         {
     *             "id": 2,
     *             "name": "Lit solutions",
     *             "image": "http://api.icm.lk/images/advertisement/1561291480.jpg",
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
        $sort = $req->query('sort');
        $order = $req->query('order');

        return $this->responseSuccess(Advertisement::orderBy($sort, $order)->get());
    }

    /**
     * Advertisement create.
     *
     * @bodyParam name string optional Name.
     * @bodyParam image file required Image.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Created successfully!",
     *     "data": {
     *         "name": "Lit solutions",
     *         "image": "http://api.icm.lk/images/advertisement/1561291480.jpg",
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
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096',
            'name' => 'max:50',
        ]);

        $image = $request->file('image');

        $imageName = $this->uploadImage($image, Advertisement::IMG_PATH);
        if ($imageName) {
            $company = Advertisement::create(array_merge($request->all(), ['image' => $imageName]));

            return $this->responseSuccess($company, 'Created successfully!');
        }

        return $this->responseBadRequest('Unsuccessful.');
    }

    /**
     * Advertisement get record.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "id": 2,
     *         "name": "roserbery",
     *         "image": "http://api.icm.lk/images/advertisement/1561291480.jpg",
     *         "created_at": "2019-06-24 06:52:40",
     *         "updated_at": "2019-06-24 06:52:40"
     *     }
     * }
     *
     * @group Admin
     */
    public function getOne($id)
    {
        $record = Advertisement::find($id);
        if ($record) {
            return $this->responseSuccess($record);
        }

        return $this->responseBadRequest('No record found.');
    }

    /**
     * Advertisement update.
     *
     * Even this is a **PUT** request you have to send this as a **POST** request
     * because of `lumen` doesn't support form data via **PUT** request
     *
     * So we have to pass additional field with **POST** request.
     *
     * `_method=PUT` and rest of the following fields
     *
     * @bodyParam name string optional Name.
     * @bodyParam image file optional Image.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Updated successfully!",
     *     "data": null
     * }
     *
     * @group Admin
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:4096',
            'name' => 'max:50',
        ]);

        $model = Advertisement::find($id);
        if ($model) {
            $image = $request->file('image');
            if ($image) {
                $prevImageName = $model->getAttributes()['image'];
                $imageName = $this->uploadImage($image, Advertisement::IMG_PATH);
                if ($imageName && $model->update(array_merge($request->all(), ['image' => $imageName]))) {
                    $this->deleteImage(Advertisement::IMG_PATH, $prevImageName);

                    return $this->responseSuccess(null, 'Updated successfully!');
                } else {
                    return $this->responseBadRequest('Unsuccessful.');
                }
            } else {
                $record = $model->update($request->all());

                return $this->responseSuccess($record);
            }
        }

        return $this->responseBadRequest('No record found.');
    }

    /**
     * Advertisement delete.
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
        if (Advertisement::find($id)->delete()) {
            return $this->responseSuccess(null);
        }

        return $this->responseBadRequest('Unsuccessful.');
    }
}
