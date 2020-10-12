<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

/**
 * @property int            $id
 * @property string         $title
 * @property string         $desc_1
 * @property string         $desc_2
 * @property string         $image
 * @property bool           $is_featured
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class News extends Model
{
    const IMG_PATH = 'news';
    /**
     * @var array
     */
    protected $fillable = ['title', 'desc_1', 'desc_2', 'image', 'is_featured'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function getImageAttribute($value)
    {
        return $value ? env('IMG_URL').'/'.static::IMG_PATH.'/'.$value : null;
    }

    public function delete()
    {
        $res = parent::delete();
        $imgPath = Config::get('consts.img_path').'/'.static::IMG_PATH.'/'.$this->getAttributes()['image'];

        if (File::exists($imgPath)) {
            File::delete($imgPath);
        }

        return $res;
    }
}
