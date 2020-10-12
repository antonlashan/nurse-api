<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

/**
 * @property int            $id
 * @property string         $name
 * @property string         $image
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class DashboardImage extends Model
{
    const IMG_PATH = 'dashboard';

    /**
     * @var array
     */
    protected $fillable = ['name', 'image'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    public function getImageAttribute($value)
    {
        return env('IMG_URL').'/'.static::IMG_PATH.'/'.$value;
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
