<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int                      $id
 * @property int                      $company_id
 * @property string                   $position
 * @property string                   $description
 * @property \Carbon\Carbon           $created_at
 * @property \Carbon\Carbon           $updated_at
 * @property Company                  $company
 * @property CompanyPostApplication[] $postApplications
 * @property CompanyPostBookmark[]    $postBookmarks
 */
class CompanyPost extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['company_id', 'position', 'description'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @var string
     */
    protected $appends = ['applied_status', 'has_bookmarked', 'applied_status_lbl'];

    protected $hidden = ['applied_status', 'has_bookmarked', 'applied_status_lbl'];

    protected $casts = ['company_id' => 'integer'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id');
    }

    public function getAppliedStatusAttribute()
    {
        if (!$this->postApplications->isEmpty()) {
            return $this->postApplications[0]->status;
        }
    }

    public function getAppliedStatusLblAttribute()
    {
        if (!$this->postApplications->isEmpty()) {
            return $this->postApplications[0]->status_lbl;
        }
    }

    public function getHasBookmarkedAttribute()
    {
        if (!$this->postBookmarks->isEmpty()) {
            return true;
        }

        return false;
    }

    public function postApplications()
    {
        return $this->hasMany('App\Models\CompanyPostApplication', 'company_post_id');
    }

    public function postBookmarks()
    {
        return $this->hasMany('App\Models\CompanyPostBookmark', 'company_post_id');
    }

    public function delete()
    {
        $pid = $this->id;
        $res = parent::delete();

        Notification::where('type_id', '=', $pid)->delete();

        return $res;
    }
}
