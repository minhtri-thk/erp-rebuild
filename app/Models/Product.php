<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        // 'category_id',
        'product_code',
        'serial_number',
        'purchased_date',
        'parent_product_id',
        'attribute_value',
        'description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
