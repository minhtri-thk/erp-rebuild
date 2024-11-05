<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Database\Factories\DepartmentFactory;

class Department extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'name',
        'phone',
        'deleted_by',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public $timestamps = true;

    protected $table = 'departments';

    /**
     * Scope Filter
     *
     * @param  mixed $query
     * @param  mixed $request
     * @return void
     */
    public function scopeFilter($query, $request)
    {
        if ($request->filled('search_name')) {
            $query->where('name', 'like', "%{$request->input('search_name')}%");
        }

        return $query;
    }

    /**
     * Get the users for the user.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'department_user');
    }

    /** Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return DepartmentFactory::new();
    }
}
