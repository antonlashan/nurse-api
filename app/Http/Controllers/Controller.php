<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class Controller extends BaseController
{
    protected function formatValidationErrors(Validator $validator)
    {
        return [
            'success' => false,
            'message' => 'Validation error',
            'data' => $validator->errors()->messages(),
        ];
    }

    /**
     * Return a new response from the application.
     *
     * @param any    $data
     * @param string $message
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function responseSuccess($data, $message = 'Successful')
    {
        $res = ['success' => true];
        $res['message'] = $message;
        $res['data'] = $data;

        return response($res, 200);
    }

    protected function responseBadRequest($message)
    {
        $res = ['success' => false];
        $res['message'] = $message;
        $res['data'] = null;

        return response($res, 400);
    }

    protected function responseValidation($message)
    {
        $res = ['success' => false];
        $res['message'] = $message;
        $res['data'] = null;

        return response($res, 422);
    }

    protected function responseUnauthorized()
    {
        $res = ['success' => false];
        $res['message'] = 'Unauthorized action.';
        $res['data'] = null;

        return response($res, 401);
    }

    protected function getPagination(LengthAwarePaginator $paginator, $list)
    {
        return [
            'paginator' => [
                'pages' => (int) $paginator->lastPage(),
                'current_page' => (int) $paginator->currentPage(),
                'per_page' => (int) $paginator->perPage(),
                'total' => (int) $paginator->total(),
            ],
            'list' => $list,
        ];
    }

    protected function uploadImage(UploadedFile $image, $path)
    {
        $destinationPath = Config::get('consts.img_path').'/'.$path;

        $imageName = uniqid(time()).'.'.$image->getClientOriginalExtension();
        if ($image->move($destinationPath, $imageName)) {
            return $imageName;
        }

        return null;
    }

    protected function deleteImage($path, $imgName)
    {
        $imgPath = Config::get('consts.img_path').'/'.$path.'/'.$imgName;

        if (File::exists($imgPath)) {
            File::delete($imgPath);
        }
    }

    protected function maskPhoneNumber($number)
    {
        return '+94'.str_repeat('*', strlen($number) - 7).substr($number, -4);
    }
}
