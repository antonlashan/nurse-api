<?php

/**
 * Description of DistrictController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\District;

class DistrictController extends Controller
{
    /**
     * District list.
     *
     * @response {
     * "success": true,
     *     "message": "Successful",
     *     "data": [
     *         {
     *             "id": 1,
     *             "name": "Ampara"
     *         },
     *         {
     *             "id": 2,
     *             "name": "Anuradhapura"
     *         }
     *     ]
     * }
     *
     * @group Client
     */
    public function lists()
    {
        return $this->responseSuccess(District::all());
    }
}
