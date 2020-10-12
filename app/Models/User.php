<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * @property int                      $id
 * @property string                   $email
 * @property string                   $mobile_no
 * @property string                   $password
 * @property string                   $api_key
 * @property string                   $role
 * @property string                   $oauth_provider
 * @property string                   $oauth_uid
 * @property string                   $sms_ref_id
 * @property bool                     $is_active
 * @property \Carbon\Carbon           $created_at
 * @property \Carbon\Carbon           $updated_at
 * @property UserDetail               $userDetail
 * @property PushNotificationDevice[] $devices
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;

    const ROLE_ADMIN = 'admin';
    const ROLE_CLIENT = 'client';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mobile_no', 'email', 'password', 'oauth_provider', 'oauth_uid',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_key', 'role', 'oauth_provider', 'oauth_uid', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public static $staticMakeVisible;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        if (isset(self::$staticMakeVisible)) {
            $this->makeVisible(self::$staticMakeVisible);
        }
    }

    public function userDetail()
    {
        return $this->hasOne('App\Models\UserDetail');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devices()
    {
        return $this->hasMany('App\Models\PushNotificationDevice', 'user_id');
    }

    public function __destruct()
    {
        self::$staticMakeVisible = null;
    }
}
