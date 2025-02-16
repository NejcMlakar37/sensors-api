<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'city', 'postcode', 'country', 'contact_email'];

    /**
     * @return HasMany
     */
    public function sensors(): HasMany
    {
        return $this->hasMany(Sensor::class);
    }
}
