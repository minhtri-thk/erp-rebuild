<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Database\Factories\UserFactory;
use App\Models\UserProfile;
use App\Models\Department;
use App\Traits\ScopeEloquent;
use App\Traits\SpatieLogsActivity;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use HasRoles;
    use HasPermissions;
    use SoftDeletes;
    use SpatieLogsActivity;
    use ScopeEloquent;

    protected $guard_name = "api";
    protected $timezone;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->timezone = Arr::get(Auth::user(), 'timezone', config('app.timezone'));
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Interact with the user's password.
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            // get: fn(string $value) => ucfirst($value),
            set: fn(string $value) => bcrypt($value),
        );
    }

    /**
     * Set format & value for the attributes
     */
    public function setAttribute($key, $value)
    {
        // set timezone to UTC before saving db
        if ($this->isDateTimeCast($key)) {
            $value = Carbon::parse($value)->tz('UTC');
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Convert format & value for the attributes
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        // set timezone to UTC before showing
        if ($this->isDateTimeCast($key)) {
            return Carbon::parse($value)->tz($this->timezone)->format('Y-m-d H:i:s');
        }

        return $value;
    }

    /**
     * Checking Datetime
     */
    protected function isDateTimeCast($key)
    {
        return array_key_exists($key, $this->getCasts()) && Arr::get($this->getCasts(), $key) === 'datetime';
    }

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // updating created_by and updated_by when model is created
        static::creating(
            function ($model) {
                if (Schema::hasColumn($model->getTable(), 'created_by') && !$model->isDirty('created_by')) {
                    $model->created_by = Auth::id() ?? 0;
                }
                if (Schema::hasColumn($model->getTable(), 'updated_by') && !$model->isDirty('updated_by')) {
                    $model->updated_by = Auth::id() ?? 0;
                }
                if (Schema::hasColumn($model->getTable(), 'uuid')) {
                    $model->uuid = Str::uuid()->toString();
                }
            }
        );

        // updating updated_by when model is updated
        static::updating(
            function ($model) {
                if (Schema::hasColumn($model->getTable(), 'updated_by') && !$model->isDirty('updated_by')) {
                    $model->updated_by = Auth::id() ?? 0;
                }
            }
        );

        // updating deleted_by when model is deleted
        static::deleting(
            function ($model) {
                if (Schema::hasColumn($model->getTable(), 'deleted_by') && !$model->isDirty('deleted_by')) {
                    $model->deleted_by = Auth::id() ?? 0;
                }
            }
        );
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }

    /**
     * Get the profile for the user.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the departments for the user.
     */
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_user');
    }

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
            $query->whereHas('profile', function ($q) use ($request) {
                $searchName = str_replace(' ', '', $request->input('search_name'));
                $q->whereRaw("REPLACE(CONCAT(first_name, '', last_name), ' ', '') LIKE ?", ["%{$searchName}%"])
                    ->orWhere('employee_code', 'LIKE', '%' . $searchName . '%');
            });
        }

        if ($request->filled('select_gender')) {
            $query->whereHas('profile', function ($q) use ($request) {
                $q->where('gender', $request->input('select_gender'));
            });
        }

        if ($request->filled('select_status')) {
            $query->where('status', $request->input('select_status'));
        }

        if ($request->filled('select_department')) {
            $selectDepartment = $request->input('select_department');
            $selectDepartments = is_array($selectDepartment) ? $selectDepartment : [$selectDepartment];
            $query->whereHas('departments', function ($q) use ($selectDepartments) {
                $q->whereIn('department_id', $selectDepartments);
            });
        }

        return $query;
    }
}
