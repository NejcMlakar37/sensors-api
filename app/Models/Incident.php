<?php

namespace App\Models;

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

    /**
     * @return BelongsTo
     */
    public function sensor(): BelongsTo
    {
        return $this->belongsTo(Sensor::class, 'sensor_id', 'id');
    }
}
