<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Database\Factories\UserProfileFactory;

class UserProfile extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'employee_code',
        'first_name',
        'last_name',
        'phone_number',
        'date_of_birth',
        'gender',
        'avatar_url',
        'language',
        'address',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return UserProfileFactory::new();
    }

    /**
     * Get the user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
