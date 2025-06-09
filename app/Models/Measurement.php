<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $sensor_id
 * @property float $temperature
 * @property float $humidity
 * @property int $id
 */
class Measurement extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = ['sensor_id', 'temperature', 'humidity', 'timestamp'];
    protected $casts = [
      'sensor_id' => 'integer',
      'temperature' => 'float',
      'humidity' => 'float',
      'timestamp' => 'datetime'
    ];

    /**
     * Format timestamp in a custom format
     */
    protected function formattedTimestamp(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->timestamp->format('H:i:s d.m.Y'),
        );
    }

    /**
     * @return BelongsTo
     */
    public function sensor(): BelongsTo
    {
        return $this->belongsTo(Sensor::class, 'sensor_id', 'id');
    }

    /**
     * @param Builder $query
     * @param string $from
     * @param string $to
     * @return Builder
     */
    public function scopeTimestamp(Builder $query, string $from, string $to): Builder
    {
        return $query->whereBetween('timestamp', array(Carbon::parse($from), Carbon::parse($to)));
    }
}
