<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Quarks\Laravel\Auditors\HasAuditors;
use Quarks\Laravel\Locking\LocksVersion;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Update extends Model implements HasMedia
{
    use HasAuditors, HasFactory, InteractsWithMedia, LocksVersion, LogsActivity;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'published' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'version',
        'changelog',
        'published',
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
}
