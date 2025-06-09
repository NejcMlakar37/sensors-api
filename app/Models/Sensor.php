<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $name
 * @property string $location
 * @property bool $active_temp_alarm
 * @property bool $active_humid_alert
 * @property int $id
 */
class Sensor extends Authenticatable
{
    use HasFactory, HasApiTokens;

    public $timestamps = false;
    protected $table = "sensors";
    protected $primaryKey = "id";
    protected $fillable = ["name", "location", "position", 'active_temp_alarm', 'active_humid_alert', 'company_id'];
    protected $casts = [
        'active_temp_alarm' => 'boolean',
        'active_humid_alert' => 'boolean',
        'company_id' => 'integer',
        'position' => 'integer'
    ];

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function measurements(): HasMany
    {
        return $this->hasMany(Measurement::class);
    }

    /**
     * @return HasOne
     */
    public function currentBattery(): HasOne
    {
        return $this->hasOne(BatteryStatus::class)->latest();
    }

    /**
     * @return HasMany
     */
    public function battery(): HasMany
    {
        return $this->hasMany(BatteryStatus::class);
    }

    /**
     * @return HasOne
     */
    public function limits(): HasOne
    {
        return $this->hasOne(MeasurementLimit::class);
    }

    /**
     * @return HasMany
     */
    public function recipients(): HasMany
    {
        return $this->hasMany(EmailRecipient::class);
    }

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }

    /**
     * @return HasOne
     */
    public function latestMeasurement(): HasOne
    {
        return $this->hasOne(Measurement::class)->latest('timestamp');
    }
}
