<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;
use App\Traits\SpatieLogsActivity;

class CategoryAttribute extends BaseModel
{
    use SpatieLogsActivity, SoftDeletes;

    protected $table = 'category_attributes';

    /**
     * The category attributes that are mass assignable.
     */
    protected $fillable = [
        'category_id',
        'name',
        'data_type'
    ];
    /**
     * Category BelongsTo
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Options HasMany
     *
     * @return HasMany
     */
    public function options(): HasMany
    {
        return $this->hasMany(AttributeOption::class);
    }
}