<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

/**
 * @property int                 $user_id
 * @property int                 $birth_district_id
 * @property string              $first_name
 * @property string              $last_name
 * @property string              $nic
 * @property mixed               $gender
 * @property \Carbon\Carbon      $dob
 * @property string              $highest_edu_qualification
 * @property string              $current_work_place
 * @property string              $professional
 * @property string              $vtc
 * @property string              $prof_pic
 * @property string              $registration_no
 * @property bool                $is_complete_profile
 * @property int                 $referral_point
 * @property string              $referral_no
 * @property \Carbon\Carbon      $created_at
 * @property \Carbon\Carbon      $updated_at
 * @property District            $district
 * @property User                $user
 * @property UserQualification[] $userQualifications
 */
class UserDetail extends Model
{
    const IMG_PATH = 'user';
    /**
     * @var array
     */
    protected $fillable = [
        'birth_district_id',
        'first_name',
        'last_name',
        'nic',
        'gender',
        'dob',
        'highest_edu_qualification',
        'current_work_place',
//        'registration_no',
        'professional',
        'vtc',
        'prof_pic',
        'referral_point',
        'referral_no',
        ];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @var string
     */
    protected $primaryKey = 'user_id';

    protected $appends = ['referral_point_lbl'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $hidden = [
        'is_complete_profile', 'user_id',
    ];

    protected $casts = ['is_complete_profile' => 'boolean'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo('App\Models\District', 'birth_district_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userQualifications()
    {
        return $this->hasMany('App\Models\UserQualification', 'user_id', 'user_id');
    }

    public function getProfPicAttribute($value)
    {
        return $value ? env('IMG_URL').'/'.static::IMG_PATH.'/'.$value : null;
    }

    public function delete()
    {
        $res = parent::delete();
        $profPicPath = Config::get('consts.img_path').'/'.static::IMG_PATH.'/'.$this->getAttributes()['prof_pic'];

        if (File::exists($profPicPath)) {
            File::delete($profPicPath);
        }

        return $res;
    }

    public function getReferralPointLblAttribute()
    {
        foreach (Config::get('consts.referral_points') as $point) {
            if ($this->referral_point == $point['id']) {
                return $point['label'];
            }
        }

        return null;
    }
}
