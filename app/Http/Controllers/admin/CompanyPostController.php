<?php

/**
 * Description of CompanyPostController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use App\Models\Notification;
use App\Http\Firebase;

class CompanyPostController extends Controller
{
    /**
     * CompanyPost list.
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
     *                 "company_name": "Asiri Hospital Holdings Pvt Ltd",
     *                 "company_address": "Colombo 5",
     *                 "id": 1,
     *                 "company_id": 1,
     *                 "position": "Nurse (Female\/Male) - Colombo 5",
     *                 "description": "description",
     *                 "created_at": "2019-07-10 13:14:12",
     *                 "updated_at": "2019-07-10 13:14:12"
     *             },
     *             {
     *                 "company_name": "Wellfort Management Pvt Ltd",
     *                 "company_address": "Colombo",
     *                 "id": 2,
     *                 "company_id": 2,
     *                 "position": "Female Executive - Nugegoda",
     *                 "description": "Executive - Operations",
     *                 "created_at": "2019-07-10 13:14:12",
     *                 "updated_at": "2019-07-10 13:14:12"
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

        $q = CompanyPost::select([
                    'companies.name as company_name',
                    'companies.address as company_address',
                    'company_posts.*',
                ])
                ->join('companies', 'company_posts.company_id', '=', 'companies.id');
        switch ($sort) {
            case 'position':
                $q->orderBy('company_posts.position', $order);
                break;
            case 'id':
                $q->orderBy('company_posts.id', $order);
                break;
            case 'company':
                $q->orderBy('companies.name', $order);
                break;
            case 'location':
                $q->orderBy('companies.address', $order);
                break;
            default:
                $q->orderBy('company_posts.created_at', 'desc');
        }
        $res = $q->paginate(Config::get('consts.page_size'));

        return $this->responseSuccess($this->getPagination($res, $res->items()));
    }

    /**
     * CompanyPost create.
     *
     * @bodyParam company_id integer required Company ID.
     * @bodyParam position string required Position label.
     * @bodyParam description text required Description.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Created successfully!",
     *     "data": {
     *         "company_id": "1",
     *         "position": "test",
     *         "description": "test",
     *         "updated_at": "2019-06-24 07:19:23",
     *         "created_at": "2019-06-24 07:19:23"
     *     }
     * }
     *
     * @group Admin
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'company_id' => 'required',
            'position' => 'required|max:50',
            'description' => 'required',
        ]);

        try {
            $post = new CompanyPost();
            $post->fill($request->all());
            if ($post->save()) {
                $this->notifyAllUsers($post->id);

                return $this->responseSuccess($post, 'Created successfully!');
            }
        } catch (\Exception $e) {
            return $this->responseBadRequest($e->getMessage());
        }

        return $this->responseBadRequest('Post not created');
    }

    private function notifyAllUsers($postId)
    {
        $activeClients = User::where('role', User::ROLE_CLIENT)
                ->where('is_active', true)
                ->get();

        $title = '';
        $body = '';
        $tokens = [];
        $firebase = new Firebase();

        foreach ($activeClients as $client) {
            $notification = new Notification();
            $notification->user_id = $client->id;
            $notification->type = Notification::TYPE_CREATE_NEW_POST;
            $notification->type_id = $postId;
            $params = ['post_id' => $postId];
            $notification->parameters = json_encode($params);
            $notification->title = Notification::TITLES[Notification::TYPE_CREATE_NEW_POST];
            $notification->body = Notification::BODIES[Notification::TYPE_CREATE_NEW_POST];
            $notification->save();

            $title = $notification->title;
            $body = $notification->body;

            foreach ($client->devices as $device) {
                $tokens[] = $device->token;
            }
        }

        // maximum tokens per batch is 100 according to firebase
        foreach (array_chunk($tokens, 100) as $chunkTokens) {
            $firebase->sendNotifications($chunkTokens, $title, $body);
        }
    }

    /**
     * CompanyPost get record.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "company_id": "1",
     *         "position": "test",
     *         "description": "test",
     *         "updated_at": "2019-06-24 07:19:23",
     *         "created_at": "2019-06-24 07:19:23"
     *     }
     * }
     *
     * @group Admin
     */
    public function getOne($id)
    {
        $record = CompanyPost::with(['company'])->find($id);
        if ($record) {
            return $this->responseSuccess($record);
        }

        return $this->responseBadRequest('No record found.');
    }

    /**
     * CompanyPost update.
     *
     * Even this is a **PUT** request you have to send this as a **POST** request
     * because of `lumen` doesn't support form data via **PUT** request
     *
     * So we have to pass additional field with **POST** request.
     *
     * `_method=PUT` and rest of the following fields
     *
     * @bodyParam company_id integer required Company ID.
     * @bodyParam position string required Position label.
     * @bodyParam description text required Description.
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
            'company_id' => 'required',
            'position' => 'required|max:50',
            'description' => 'required',
        ]);

        $model = CompanyPost::find($id);
        if ($model->update($request->all())) {
            return $this->responseSuccess(null, 'Updated successfully!');
        }

        return $this->responseBadRequest('No record found.');
    }

    /**
     * CompanyPost delete.
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
        if (CompanyPost::find($id)->delete()) {
            return $this->responseSuccess(null);
        }

        return $this->responseBadRequest('Unsuccessful.');
    }
}
