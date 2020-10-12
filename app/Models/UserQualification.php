<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property int        $id
 * @property int        $user_id
 * @property string     $name
 * @property string     $grade
 * @property mixed      $type
 * @property UserDetail $userDetail
 */
class UserQualification extends Model
{
    const TYPES = ['a_level', 'o_level'];
    /**
     * @var array
     */
    protected $fillable = ['name', 'grade', 'type'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $hidden = [
        'user_id',
    ];

    protected $casts = ['user_id' => 'integer'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userDetails()
    {
        return $this->belongsTo('App\Models\UserDetails', 'user_id', 'user_id');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });
    }
}
