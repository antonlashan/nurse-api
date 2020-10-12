<?php

/**
 * Description of DashboardImageController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DashboardImage;
use Illuminate\Http\Request;

class DashboardImageController extends Controller
{
    /**
     * DashboardImage list.
     *
     * @response {
     *     "success": true,
     *     "message": "Successful",
     *     "data": [
     *         {
     *             "id": 1,
     *             "name": "company 1",
     *             "image": "http://api.icm.lk/thumb/w2000/images/dashboard/232323.jpg",
     *             "created_at": "2019-06-23 12:00:27",
     *             "updated_at": "2019-06-23 12:00:27"
     *         }
     *     ]
     * }
     *
     * @group Admin
     */
    public function lists()
    {
        return $this->responseSuccess(DashboardImage::get());
    }

    /**
     * DashboardImage create.
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
     *         "image": "http://api.icm.lk/thumb/w2000/images/dashboard/232323.jpg",
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

        $imageName = $this->uploadImage($image, DashboardImage::IMG_PATH);
        if ($imageName) {
            // delete all images
            DashboardImage::get()->each->delete();

            $model = DashboardImage::create(array_merge($request->all(), ['image' => $imageName]));

            return $this->responseSuccess($model, 'Created successfully!');
        }

        return $this->responseBadRequest('Unsuccessful.');
    }

    /**
     * DashboardImage get record.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "id": 2,
     *         "name": "roserbery",
     *         "image": "http://api.icm.lk/thumb/w2000/images/dashboard/232323.jpg",
     *         "created_at": "2019-06-24 06:52:40",
     *         "updated_at": "2019-06-24 06:52:40"
     *     }
     * }
     *
     * @group Admin
     */
    public function getOne($id)
    {
        $record = DashboardImage::find($id);
        if ($record) {
            return $this->responseSuccess($record);
        }

        return $this->responseBadRequest('No record found.');
    }

    /**
     * DashboardImage update.
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

        $model = DashboardImage::find($id);
        if ($model) {
            $image = $request->file('image');
            if ($image) {
                $prevImageName = $model->getAttributes()['image'];
                $imageName = $this->uploadImage($image, DashboardImage::IMG_PATH);
                if ($imageName && $model->update(array_merge($request->all(), ['image' => $imageName]))) {
                    $this->deleteImage(DashboardImage::IMG_PATH, $prevImageName);

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
        if (DashboardImage::find($id)->delete()) {
            return $this->responseSuccess(null);
        }

        return $this->responseBadRequest('Unsuccessful.');
    }
}
