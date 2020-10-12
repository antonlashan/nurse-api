<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int            $id
 * @property int            $user_id
 * @property mixed          $type
 * @property string         $token
 * @property bool           $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property User           $user
 */
class PushNotificationDevice extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['type', 'token'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
}
