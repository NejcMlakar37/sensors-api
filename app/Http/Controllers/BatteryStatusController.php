<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewBatteryStatusRequest;
use App\Http\Resources\BatteryStatusResource;
use App\Models\BatteryStatus;
use App\Services\AlarmService;
use App\Services\FormatterService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BatteryStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $batteryStatuses = QueryBuilder::for(BatteryStatus::class)
            ->defaultSort('created_at')
            ->allowedFilters([
                AllowedFilter::exact('sensor_id'),
                AllowedFilter::scope('created_at'),
            ])
            ->allowedSorts('created_at')->get();

        return BatteryStatusResource::collection($batteryStatuses);
    }

    /**
     * Store a newly created resource in storage.
     * @param NewBatteryStatusRequest $request
     * @param AlarmService $alarmService
     * @return mixed
     */
    public function store(NewBatteryStatusRequest $request, AlarmService $alarmService): mixed
    {
        $batteryStatus = $request->input('status');
        $sensorId = $request->input('sensor_id');

        $status = new BatteryStatus([
            'sensor_id' => $sensorId,
            'status' => $batteryStatus,
        ]);

        if($status->save()) {
            $alarmService->handleBatteryStatus($sensorId, FormatterService::formatFloat($batteryStatus));
            return response()->insert($status->id);
        } else {
            return response()->error('Prišlo je do napake pri shranjevanju novega statusa!');
        }
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return BatteryStatusResource
     */
    public function show(int $id): BatteryStatusResource
    {
        $status = BatteryStatus::query()->findOrFail($id);
        return new BatteryStatusResource($status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $status = BatteryStatus::query()->findOrFail($id);
        if($status->delete()) {
            return response()->success('Status je bil uspešno izbrisan!');
        } else {
            return response()->error('Prišlo je do napake pri brisanju statusa!');
        }
    }
}
