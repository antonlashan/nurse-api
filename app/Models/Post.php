<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

/**
 * @property int            $id
 * @property string         $title
 * @property string         $description
 * @property string         $image
 * @property int            $likes
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property PostCategory   $categories
 * @property PostComment[]  $postComments
 * @property PostLike[]     $postLikes
 */
class Post extends Model
{
    const IMG_PATH = 'post';

    /**
     * @var array
     */
    protected $fillable = ['title', 'description', 'image'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $appends = ['has_liked'];

    protected $hidden = ['has_liked'];

    protected $casts = ['likes' => 'integer'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\PostCategory', 'post_category_map', 'post_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postComments()
    {
        return $this->hasMany('App\Models\PostComment', 'post_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postLikes()
    {
        return $this->hasMany('App\Models\PostLike', 'post_id');
    }

    public function getImageAttribute($value)
    {
        return env('IMG_URL').'/'.static::IMG_PATH.'/'.$value;
    }

    public function delete()
    {
        $res = parent::delete();
        $logoPath = Config::get('consts.img_path').'/'.static::IMG_PATH.'/'.$this->getAttributes()['image'];

        if (File::exists($logoPath)) {
            File::delete($logoPath);
        }

        return $res;
    }

    public function getHasLikedAttribute()
    {
        if ($this->postLikes->isEmpty()) {
            return false;
        }

        return true;
    }
}
