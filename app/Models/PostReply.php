<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property int            $id
 * @property int            $user_id
 * @property int            $post_comment_id
 * @property string         $comment
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property PostComment    $postComment
 * @property User           $user
 * @property UserDetail     $userDetail
 */
class PostReply extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['post_comment_id', 'comment'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $casts = ['post_comment_id' => 'integer', 'user_id' => 'integer'];

    protected $appends = ['can_edit'];

    protected $hidden = ['user_id', 'can_edit'];

    public static $staticMakeVisible;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        if (isset(self::$staticMakeVisible)) {
            $this->makeVisible(self::$staticMakeVisible);
        }
    }

    public function __destruct()
    {
        self::$staticMakeVisible = null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function postComment()
    {
        return $this->belongsTo('App\Models\PostComment', 'post_comment_id');
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
