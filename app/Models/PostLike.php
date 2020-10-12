<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property int            $post_id
 * @property int            $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property Post           $posts
 * @property User           $users
 */
class PostLike extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['post_id', 'user_id'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * Eloquent doesn't support composite primary keys : post_id, user_id.
     *
     * @var string
     */
    protected $primaryKey = 'post_id';

    protected $casts = ['post_id' => 'integer', 'user_id' => 'integer'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function posts()
    {
        return $this->belongsTo('App\Models\Post', 'post_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });
    }
}
