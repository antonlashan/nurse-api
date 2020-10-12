<?php

/**
 * Description of NewsController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Support\Facades\Config;

class NewsController extends Controller
{
    /**
     * News list.
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
     *             "per_page": 20,
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
     * @group Client
     */
    public function lists()
    {
        $res = News::orderBy('created_at', 'desc')->paginate(Config::get('consts.page_size'));

        return $this->responseSuccess($this->getPagination($res, $res->items()));
    }

    /**
     * News get featured news.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful!",
     *     "data": {
     *         "title": "Leaving for UN missions",
     *         "desc_1": "<p>A new contingent of 61 Army personnel including 11officers under the phase six of the UN Mission of South Sudan (UNMISS),&nbsp;<\/p>",
     *         "desc_2": "<p>left this morning for South Sudan to serve in the SRIMED Level 2 Hospital in Bor, South Sudan.<strong> Pix by Army Media<\/strong><\/p>",
     *         "is_featured": true,
     *         "image": "http://api.icm.lk\/images\/news\/15621633705d1cb8aaa831d.jpg",
     *         "updated_at": "2019-07-03 14:16:10",
     *         "created_at": "2019-07-03 14:16:10",
     *         "id": 3
     *     }
     * }
     *
     * @group Client
     */
    public function getFeaturedNews()
    {
        $record = News::where('is_featured', 1)->first();
        if ($record) {
            return $this->responseSuccess($record);
        }

        return $this->responseSuccess(null, 'No record found.');
    }
}
