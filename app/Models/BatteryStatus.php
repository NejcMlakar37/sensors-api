<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BatteryStatus extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    const UPDATED_AT = null;
    protected $fillable = ['sensor_id', 'status'];

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
    public function scopeCreatedAt(Builder $query, string $from, string $to): Builder
    {
        return $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
    }

    /**
     * @param Builder $query
     * @param string $from
     * @param string $to
     * @return Builder
     */
    public function scopeUpdatedAt(Builder $query, string $from, string $to): Builder
    {
        return $query->whereBetween('updated_at', array(Carbon::parse($from), Carbon::parse($to)));
    }
}
