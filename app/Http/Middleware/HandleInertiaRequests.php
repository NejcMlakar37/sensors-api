<?php

namespace App\Http\Middleware;

use App\Http\Resources\SensorResource;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request) ?? md5_file(public_path('mix-manifest.json'));
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $sensors = Cache::rememberForever('sensors', function () {
            return SensorResource::collection(Sensor::query()->with('currentBattery')->get());
        });

        return array_merge(parent::share($request), [
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'message' => $request->session()->get('message'),
                ];
            },
            'sensors' => function () use ($sensors) {
                return SensorResource::collection(Sensor::query()->with('currentBattery')->get());
            },
            'auth.user' => fn () => $request->user()
                ? [
                    'id' => $request->user()->id,
                    'email' => $request->user()->email,
                    'company' => $request->user()->company,
                ]
                : null,
        ]);
    }
}
