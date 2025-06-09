<?php

namespace App\Models;

use App\Services\FormatterService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incident extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $timestamps = [ "created_at" ];
    const UPDATED_AT = null;
    protected $fillable = ['sensor_id', 'type', 'created_at', 'value', 'min', 'max'];
    protected $casts = [
        'sensor_id' => 'integer',
        'created_at' => 'datetime',
        'value' => 'float',
        'min' => 'float',
        'max' => 'float',
    ];

    public function value(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => FormatterService::formatFloat(($value)),
        );
    }

    public function min(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => FormatterService::formatFloat(($value)),
        );
    }

    public function max(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => FormatterService::formatFloat(($value)),
        );
    }

    /**
     * @return BelongsTo
     */
    public function sensor(): BelongsTo
    {
        return $this->belongsTo(Sensor::class, 'sensor_id', 'id');
    }
}
