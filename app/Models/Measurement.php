<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
