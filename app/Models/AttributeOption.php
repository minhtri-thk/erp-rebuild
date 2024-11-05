<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;
use App\Traits\SpatieLogsActivity;

class AttributeOption extends BaseModel
{
    use SpatieLogsActivity, SoftDeletes;

    protected $table = 'attribute_options';

    /**
     * The categories that are mass assignable.
     */
    protected $fillable = [
        'value'
    ];

    /**
     * Attribute BelongsTo
     *
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(CategoryAttribute::class);
    }
}