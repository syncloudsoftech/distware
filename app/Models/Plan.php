<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Quarks\Laravel\Auditors\HasAuditors;
use Quarks\Laravel\Locking\LocksVersion;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Plan extends Model
{
    use HasAuditors, LocksVersion, LogsActivity;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'entitlements' => 'array',
        'published' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'entitlements',
        'published',
        'notes',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->logExcept([
                // quarks/laravel-auditors
                'created_by_id',
                'created_by_type',
                'updated_by_id',
                'updated_by_type',
                'deleted_by_id',
                'deleted_by_type',
                // quarks/laravel-locking
                'lock_version',
            ]);
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }
}
