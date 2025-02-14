<?php

namespace App\Http\Controllers;

use App\Exports\MeasurementsExport;
use App\Http\Requests\NewMeasurementRequest;
use App\Http\Resources\MeasurementResource;
use App\Models\Measurement;
use App\Models\Sensor;
use App\Services\AlarmService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MeasurementController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param NewMeasurementRequest $request
     * @param AlarmService $alarmService
     * @return JsonResponse
     */
    public function store(NewMeasurementRequest $request, AlarmService $alarmService): JsonResponse
    {
        $measurement = new Measurement([
            'sensor_id' => $request->input('sensor_id'),
            'temperature' => $request->input('temperature'),
            'humidity' => $request->input('humidity'),
        ]);

        $alarmService->handleSensorLimits($request->input('sensor_id'), $request->input('temperature'), $request->input('humidity'));

        if($measurement->save()) {
            return response()->insert($measurement->id);
        } else {
            return response()->error('Prišlo je do napake pri shranjevanju meritve!');
        }
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return MeasurementResource
     */
    public function show(int $id): MeasurementResource
    {
        $measurement = Measurement::query()->with('sensor')->findOrFail($id);
        return new MeasurementResource($measurement);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $measurements = QueryBuilder::for(Measurement::class)
            ->with('sensor')
            ->defaultSort('-timestamp')
            ->allowedFilters([
                AllowedFilter::exact('sensor_id'),
                AllowedFilter::scope('timestamp')
            ])
            ->allowedSorts('timestamp')
            ->get();

        $count = $measurements->count();
        return MeasurementResource::collection($measurements->nth(ceil($count / 500)));
    }

    /**
     * @return BinaryFileResponse
     */
    public function exportToExcel(): BinaryFileResponse
    {
        $measurements = QueryBuilder::for(Measurement::class)
            ->with('sensor')
            ->defaultSort('-timestamp')
            ->allowedFilters([
                AllowedFilter::exact('sensor_id'),
                AllowedFilter::scope('timestamp')
            ])
            ->allowedSorts('timestamp')
            ->get();

        $sensorId = 0;
        if(count($measurements) > 0) {
            $sensorId = $measurements->first()->sensor_id;
        }

        return Excel::download(new MeasurementsExport($measurements), 'meritve-za-sensor-'.$sensorId.'.xlsx');
    }

    /**
     * @param int $sensorId
     * @return MeasurementResource
     */
    public function getLatestMeasurement(int $sensorId): MeasurementResource
    {
        $measurements = Measurement::with(['sensor'])
            ->where('sensor_id', $sensorId)
            ->latest('timestamp')->first();

        return new MeasurementResource($measurements);
    }

    public function destroy(int $id)
    {
        $measurement = Measurement::query()->findOrFail($id);
        if($measurement->delete()) {
            return response()->success('Meritev je bila uspešno izbrisana!');
        } else {
            return response()->error('Prišlo je do napake pri brisanju meritve!');
        }
    }
}
