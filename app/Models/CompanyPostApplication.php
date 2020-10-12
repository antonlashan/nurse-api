<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property int            $id
 * @property int            $company_post_id
 * @property int            $user_id
 * @property mixed          $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property CompanyPosts   $companyPosts
 * @property Users          $users
 */
class CompanyPostApplication extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPT = 'accept';
    const STATUS_REJECT = 'reject';

    /**
     * @var array
     */
    protected $fillable = ['company_post_id'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    protected $hidden = [
        'user_id',
    ];

    protected $casts = ['company_post_id' => 'integer', 'user_id' => 'integer'];

    protected $appends = ['status_lbl'];

    public static $staticMakeVisible;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyPost()
    {
        return $this->belongsTo('App\Models\CompanyPost', 'company_post_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
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

    public function statusLbls()
    {
        return [
            static::STATUS_PENDING => 'Pending',
            static::STATUS_ACCEPT => 'Accepted',
            static::STATUS_REJECT => 'Rejected',
        ];
    }

    public function getStatusLblAttribute()
    {
        return $this->statusLbls()[$this->status];
    }

    public static function isApplied($compPostId, $userId)
    {
        $model = CompanyPostApplication::where('company_post_id', $compPostId)
                ->where('user_id', $userId)
                ->get();

        return $model->isEmpty() ? false : true;
    }
}
