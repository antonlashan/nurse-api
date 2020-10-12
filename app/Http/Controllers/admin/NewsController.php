<?php

/**
 * Description of NewsController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class NewsController extends Controller
{
    /**
     * News list.
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
     *             "total": 2
     *         },
     *         "list": [
     *             {
     *                 "id": 1,
     *                 "title": "Hemasiri, Pujith further remanded",
     *                 "desc_1": "<p>Former Defence Secretary Hemasiri Fernando and IGP Pujith Jayasundara, who were arrested by the CID at the Colombo National Hospital yesterday, were further remanded until July 9 by Colombo Chief Magistrate Lanka Jayaratne.<\/p>",
     *                 "desc_2": "<p>Former Defence Secretary Hemasiri Fernando and IGP Pujith Jayasundara, who were arrested by the CID at the Colombo National Hospital yesterday, were further remanded until July 9 by Colombo Chief Magistrate Lanka Jayaratne. (Shehan Chamika Silva)<\/p>",
     *                 "image": "http://api.icm.lk\/images\/news\/333333.jpg",
     *                 "is_featured": false,
     *                 "created_at": "2019-07-03 13:32:33",
     *                 "updated_at": "2019-07-03 13:59:37"
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

        $q = News::query();
        switch ($sort) {
            case 'id':
                $q->orderBy('id', $order);
                break;
            case 'title':
                $q->orderBy('title', $order);
                break;
            case 'is_featured':
                $q->orderBy('is_featured', $order);
                break;
            default:
                $q->orderBy('created_at', 'desc');
        }
        $res = $q->paginate(Config::get('consts.page_size'));

        return $this->responseSuccess($this->getPagination($res, $res->items()));
    }

    /**
     * News create.
     *
     * @bodyParam image file required Image.
     * @bodyParam title string required Title.
     * @bodyParam desc_1 string required Description 1.
     * @bodyParam desc_2 string Description 2.
     * @bodyParam banner file required Image.
     * @bodyParam is_featured boolean required Featured.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Created successfully!",
     *     "data": {
     *         "title": "Leaving for UN missions",
     *         "desc_1": "<p>A new contingent of 61 Army personnel including 11officers under the phase six of the UN Mission of South Sudan (UNMISS),&nbsp;<\/p>",
     *         "desc_2": "<p>left this morning for South Sudan to serve in the SRIMED Level 2 Hospital in Bor, South Sudan.<strong> Pix by Army Media<\/strong><\/p>",
     *         "is_featured": false,
     *         "image": "http://api.icm.lk\/images\/news\/15621633705d1cb8aaa831d.jpg",
     *         "updated_at": "2019-07-03 14:16:10",
     *         "created_at": "2019-07-03 14:16:10",
     *         "id": 3
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
            'desc_1' => 'required',
            'is_featured' => 'required',
        ]);

        $image = $request->file('image');
        $isFeatured = $this->isFeatured($request);
        if ($isFeatured) {
            $this->updateAllFeaturedNewsAsFalse();
        }
        $imageName = $this->uploadImage($image, News::IMG_PATH);

        if ($imageName) {
            $model = News::create(array_merge($request->all(), ['image' => $imageName, 'is_featured' => $isFeatured]));

            return $this->responseSuccess($model, 'Created successfully!');
        }

        return $this->responseBadRequest('Unsuccessful.');
    }

    /**
     * News get record.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful!",
     *     "data": {
     *         "title": "Leaving for UN missions",
     *         "desc_1": "<p>A new contingent of 61 Army personnel including 11officers under the phase six of the UN Mission of South Sudan (UNMISS),&nbsp;<\/p>",
     *         "desc_2": "<p>left this morning for South Sudan to serve in the SRIMED Level 2 Hospital in Bor, South Sudan.<strong> Pix by Army Media<\/strong><\/p>",
     *         "is_featured": false,
     *         "image": "http://api.icm.lk\/images\/news\/15621633705d1cb8aaa831d.jpg",
     *         "updated_at": "2019-07-03 14:16:10",
     *         "created_at": "2019-07-03 14:16:10",
     *         "id": 3
     *     }
     * }
     *
     * @group Admin
     */
    public function getOne($id)
    {
        $record = News::find($id);
        if ($record) {
            return $this->responseSuccess($record);
        }

        return $this->responseBadRequest('No record found.');
    }

    /**
     * News update.
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
     * @bodyParam desc_1 string required Description 1.
     * @bodyParam desc_2 string Description 2.
     * @bodyParam banner file required Image.
     * @bodyParam is_featured boolean required Featured.
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
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:4096',
            'title' => 'required|max:100',
            'desc_1' => 'required',
            'is_featured' => 'required',
        ]);

        $model = News::find($id);
        if (!$model) {
            return $this->responseBadRequest('No record found.');
        }

        $isFeatured = $this->isFeatured($request);
        if ($isFeatured) {
            $this->updateAllFeaturedNewsAsFalse();
        }

        $logo = $request->file('image');
        $logoName = $model->getAttributes()['image'];

        if ($logo) {
            $newLogoName = $this->uploadImage($logo, News::IMG_PATH);

            if ($newLogoName && $model->update(['image' => $newLogoName])) {
                $this->deleteImage(News::IMG_PATH, $logoName);
            }
        }

        $record = $model->update(array_merge($request->except(['image']), ['is_featured' => $isFeatured]));

        if ($record) {
            return $this->responseSuccess($record);
        }

        return $this->responseBadRequest('Unsuccessful.');
    }

    private function isFeatured(Request $request)
    {
        return filter_var($request->input('is_featured'), FILTER_VALIDATE_BOOLEAN);
    }

    private function updateAllFeaturedNewsAsFalse()
    {
        News::where('is_featured', 1)
          ->update(['is_featured' => 0]);
    }

    /**
     * News delete.
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
        if (News::find($id)->delete()) {
            return $this->responseSuccess(null);
        }

        return $this->responseBadRequest('Unsuccessful.');
    }
}
