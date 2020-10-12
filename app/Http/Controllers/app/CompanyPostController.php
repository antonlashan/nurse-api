<?php

/**
 * Description of CompanyPostController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\CompanyPost;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

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
     *             "total": 15
     *         },
     *         "list": [
     *             {
     *                 "id": 15,
     *                 "company_id": 4,
     *                 "position": "Room Assistant - Trincomalee",
     *                 "description": "<p>⇒⇒⇒ අප තරු පන්තියේ හෝටලය සදහා පහත සේවකයින් බදවා ගනු ලැබේ..</p><p># තනතුර ;<br>➫ Room Boy&nbsp;<br># අවශ්\u200dය සුදුසුකම් ;</p><p>➫ වයස අවු, 18 - 35 අතර බඳවා ගනු ලැබේ.<br>➫ අ.පො.ස (සා /පෙළ ) සමත් විය යුතුය.<br>➫ ක්\u200dරියාශීලි අයෙක් විය යුතුය .<br>➫ සාමාන්\u200dය ඉංග්\u200dරීසි දැනුම අනිවාර්ය වේ.</p><p>➫ ආහාර, නවාතැන් පහසුකම් නොමිලේ.<br>➫ වැටුප රු.35,000 වැඩි&nbsp;<br>➫ ETF/ EPF ඇතුළු දිරි දීමනා රැසක්.</p><p>☞ ඉහත සුදුසුකම් සපුරාලු ඔබ , අදම අපගේ පහත අංකයට අමතන්න.</p><p>&nbsp;</p><p><br>&nbsp;</p>",
     *                 "created_at": "2019-07-13 10:34:32",
     *                 "updated_at": "2019-07-13 10:34:32",
     *                 "applied_status": null,
     *                 "has_bookmarked": false,
     *                 "company": {
     *                     "id": 4,
     *                     "name": "Medical center at Mount Lavinia",
     *                     "logo": "http://api.icm.lk/thumb/w2000/images/company/15636318485d3320e89ad55.jpg",
     *                     "banner": "http://api.icm.lk/thumb/w2000/images/company/15635268375d3186b53f18e.jpg",
     *                     "address": "Galle Road, Mt. Lavinia, Sri Lanka",
     *                     "phone": "123456231",
     *                     "email": "mount@parmacy.com",
     *                     "created_at": "2019-07-13 10:23:08",
     *                     "updated_at": "2019-07-20 14:10:48"
     *                 }
     *             },
     *             {
     *                 "id": 14,
     *                 "company_id": 2,
     *                 "position": "HR Executive - Gampaha",
     *                 "description": "<p># POSITION: HR Executive<br># REQUIREMENTS:<br>• HR Professional qualification from a recognized Institute.&nbsp;<br>• Age below 25 - 30 years.&nbsp;<br>• Computer literacy.<br>• A minimum of 1-2 years’ work experience in HR field.&nbsp;<br>• Excellent Communication Skills.<br>• A pleasing personality with hands on experience on recruitment, a positive attitude, high on initiative, proactive thinking and the ability on multi-tasking&nbsp;<br>Attractive remuneration package on par with other fringe benefits.<br># HOW TO APPLY:<br>Please send your resume stating the position applied on the subject line of e-mail with details of two non- related referees within 14 days of this advertisement<br>If you feel you are the right individual for the above position, then apply via \"Apply for this job\" of this advert with your RESUME.</p><p>&nbsp;</p><p>See less</p>",
     *                 "created_at": "2019-07-13 10:34:02",
     *                 "updated_at": "2019-07-13 10:34:02",
     *                 "applied_status": null,
     *                 "has_bookmarked": false,
     *                 "company": {
     *                     "id": 2,
     *                     "name": "Wellfort Management Pvt Ltd",
     *                     "logo": "http://api.icm.lk/thumb/w2000/images/company/15643103865d3d7b726e5bd.jpg",
     *                     "banner": "http://api.icm.lk/thumb/w2000/images/company/111111.jpg",
     *                     "address": "Colombo",
     *                     "phone": "0777222963",
     *                     "email": "test@wellfort.com",
     *                     "created_at": "2019-07-10 23:44:12",
     *                     "updated_at": "2019-07-28 10:39:46"
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
        $res = CompanyPost::with([
                    'company',
                    'postApplications' => function ($q) use ($request) {
                        $q->where('user_id', '=', $request->user()->id);
                    },
                    'postBookmarks' => function ($q) use ($request) {
                        $q->where('user_id', '=', $request->user()->id);
                    },
                ])
                ->orderBy('created_at', 'desc')
                ->paginate(Config::get('consts.page_size'));
        $res->makeHidden(['postApplications', 'postBookmarks']);
        $res->makeVisible(['applied_status', 'has_bookmarked', 'applied_status_lbl']);

        return $this->responseSuccess($this->getPagination($res, $res->items()));
    }

    /**
     * CompanyPost get record.
     *
     * @response
     * {
     *     "success": true,
     *     "message": "Successful",
     *     "data": {
     *         "id": 1,
     *         "company_id": 1,
     *         "position": "Nurse (Female/Male) - Colombo 5",
     *         "description": "Description",
     *         "created_at": "2019-06-27 17:14:10",
     *         "updated_at": "2019-06-27 17:14:10",
     *         "applied_status": "pending",
     *         "has_bookmarked": true,
     *         "company": {
     *             "id": 1,
     *             "name": "Asiri Hospital Holdings Pvt Ltd",
     *             "image": "http://api.icm.lk/images/company/111111.jpg",
     *             "address": "Colombo 5",
     *             "phone": "2575637401",
     *             "email": "test@chapman.com",
     *             "created_at": "2019-06-27 17:14:10",
     *             "updated_at": "2019-06-27 17:14:10"
     *         }
     *     }
     * }
     *
     * @group Client
     */
    public function getOne(Request $request, $id)
    {
        $record = CompanyPost::where('id', $id)
                ->with([
                    'company',
                    'postApplications' => function ($q) use ($request) {
                        $q->where('user_id', '=', $request->user()->id);
                    },
                    'postBookmarks' => function ($q) use ($request) {
                        $q->where('user_id', '=', $request->user()->id);
                    },
                ])
                ->first()
                ->makeHidden(['postApplications', 'postBookmarks'])
                ->makeVisible(['applied_status', 'has_bookmarked', 'applied_status_lbl']);
        if ($record) {
            return $this->responseSuccess($record);
        }

        return $this->responseBadRequest('No record found.');
    }
}
