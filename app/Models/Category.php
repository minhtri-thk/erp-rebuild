<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;
use App\Traits\SpatieLogsActivity;

class Category extends BaseModel
{
    use SpatieLogsActivity, SoftDeletes;

    protected $table = 'categories';

    /**
     * The categories that are mass assignable.
     */
    protected $fillable = [
        'code',
        'name',
        'description'
    ];

    /**
     * Attributes HasMany
     *
     * @return HasMany
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(CategoryAttribute::class);
    }
}
