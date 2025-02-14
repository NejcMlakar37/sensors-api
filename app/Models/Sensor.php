<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $name
 * @property string $location
 * @property bool $active_temp_alarm
 * @property bool $active_humid_alert
 * @property int $id
 */
class Sensor extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "sensors";
    protected $primaryKey = "id";
    protected $fillable = ["name", "location", "position", 'active_temp_alarm', 'active_humid_alert'];

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
}
