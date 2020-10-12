<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

/**
 * @property int               $id
 * @property string            $name
 * @property string            $logo
 * @property string            $banner
 * @property string            $email
 * @property string            $address
 * @property string            $phone
 * @property \Carbon\Carbon    $created_at
 * @property \Carbon\Carbon    $updated_at
 * @property CompanyPosition[] $companyPositions
 */
class Company extends Model
{
    const IMG_PATH = 'company';
    /**
     * @var array
     */
    protected $fillable = ['name', 'address', 'phone', 'logo', 'banner', 'email'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companyPositions()
    {
        return $this->hasMany('App\Models\CompanyPositions', 'company_id');
    }

    public function getLogoAttribute($value)
    {
        return env('IMG_URL').'/'.static::IMG_PATH.'/'.$value;
    }

    public function getBannerAttribute($value)
    {
        return env('IMG_URL').'/'.static::IMG_PATH.'/'.$value;
    }

    public function delete()
    {
        $res = parent::delete();
        $logoPath = Config::get('consts.img_path').'/'.static::IMG_PATH.'/'.$this->getAttributes()['logo'];
        $bannerPath = Config::get('consts.img_path').'/'.static::IMG_PATH.'/'.$this->getAttributes()['banner'];

        if (File::exists($logoPath)) {
            File::delete($logoPath);
        }
        if (File::exists($bannerPath)) {
            File::delete($bannerPath);
        }

        return $res;
    }
}
