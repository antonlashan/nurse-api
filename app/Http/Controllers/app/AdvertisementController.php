<?php

/**
 * Description of AdvertisementController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;

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
     *             "id": 2,
     *             "name": "Image 2",
     *             "image": "http://api.icm.lk/images/advertisement/1561291227.jpg",
     *             "created_at": "2019-06-23 12:00:27",
     *             "updated_at": "2019-06-23 12:00:27"
     *         },
     *         {
     *             "id": 1,
     *             "name": "Image 1",
     *             "image": "http://api.icm.lk/images/advertisement/1561291480.jpg",
     *             "created_at": "2019-06-23 12:04:40",
     *             "updated_at": "2019-06-23 12:04:40"
     *         },
     *         {
     *             "id": 3,
     *             "name": "Image 3",
     *             "image": "http://api.icm.lk/images/advertisement/1561291485.jpg",
     *             "created_at": "2019-06-23 12:04:40",
     *             "updated_at": "2019-06-23 12:04:40"
     *         }
     *     ]
     * }
     *
     * @group Client
     */
    public function lists()
    {
        return $this->responseSuccess(Advertisement::inRandomOrder()->take(3)->get());
    }
}
