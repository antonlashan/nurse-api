<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property int            $id
 * @property int            $post_id
 * @property int            $user_id
 * @property string         $comment
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property Post           $post
 * @property User           $user
 * @property UserDetail     $userDetail
 * @property PostReply[]    $postReplies
 */
class PostComment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['post_id', 'comment'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $casts = ['post_id' => 'integer', 'user_id' => 'integer'];

    protected $appends = ['can_edit'];

    protected $hidden = ['user_id', 'can_edit'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post', 'post_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userDetail()
    {
        return $this->belongsTo('App\Models\UserDetail', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postReplies()
    {
        return $this->hasMany('App\Models\PostReply', 'post_comment_id');
    }

    public function getCanEditAttribute()
    {
        if ($this->user_id === Auth::id()) {
            return true;
        }

        return false;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });
    }
}
