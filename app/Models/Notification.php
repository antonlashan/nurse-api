<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int            $id
 * @property int            $user_id
 * @property string         $type
 * @property int            $type_id
 * @property string         $parameters
 * @property string         $title
 * @property string         $body
 * @property bool           $unread
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property User           $user
 */
class Notification extends Model
{
    const TYPE_CREATE_NEW_POST = 'create_new_post';
    const TYPE_SEND_POST_MSG = 'send_post_msg';
    const TITLES = [
        self::TYPE_CREATE_NEW_POST => 'Job post',
        self::TYPE_SEND_POST_MSG => 'Job interview selected',
    ];
    const BODIES = [
        self::TYPE_CREATE_NEW_POST => 'We found your perfect match at company Apply Now!',
        self::TYPE_SEND_POST_MSG => 'You have been selected for {{position}} at {{company_name}}',
    ];

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    protected $hidden = ['user_id'];
    protected $casts = ['type_id' => 'integer'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function getParametersAttribute()
    {
        return json_decode($this->getAttributes()['parameters']);
    }
}
