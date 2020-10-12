<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int            $id
 * @property int            $post_id
 * @property int            $category_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property PostCategories $postCategories
 * @property Posts          $posts
 */
class PostCategoryMap extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_category_map';

    /**
     * @var array
     */
    protected $fillable = ['id', 'post_id', 'category_id'];

    protected $casts = ['post_id' => 'integer', 'category_id' => 'integer'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function postCategories()
    {
        return $this->belongsTo('PostCategories', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function posts()
    {
        return $this->belongsTo('Posts', 'post_id');
    }
}
