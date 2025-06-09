<?php

namespace App\Services;

use App\Models\Sensor;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    private int $ttl = 60 * 60 * 24;
    
    public function getSensors(): mixed
    {
        return Cache::rememberForever('sensors', function () {
            return Sensor::query()->get()->toArray();
        });
    }
}
