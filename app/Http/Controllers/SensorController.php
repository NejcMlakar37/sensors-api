<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSensorRequest;
use App\Http\Requests\UpdateSensorRequest;
use App\Http\Resources\EmailRecipientResource;
use App\Http\Resources\IncidentResource;
use App\Http\Resources\MeasurementLimitResource;
use App\Http\Resources\MeasurementResource;
use App\Http\Resources\SensorResource;
use App\Http\Resources\SensorWithLatestResource;
use App\Models\Sensor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $sensors = QueryBuilder::for(Sensor::class)
            ->with('currentBattery')
            ->defaultSort('name')
            ->allowedFilters([
                'name',
                'location',
                AllowedFilter::exact('company_id'),
            ])
            ->allowedSorts('name, location')
            ->where('company_id', auth()->user()->company_id)
            ->get();
        
        return SensorResource::collection($sensors);
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateSensorRequest $request
     * @return JsonResponse
     */
    public function store(CreateSensorRequest $request): JsonResponse
    {
        $sensor = new Sensor([
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'position' => $request->input('position'),
            'company_id' => $request->input('company'),
        ]);

        if($sensor->save()) {
            return response()->insert($sensor->id);
        } else {
            return response()->error('Prišlo je do napake pri shranjevanju senzorja!');
        }
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $sensor = Sensor::query()->with(['measurements', 'currentBattery', 'limits', 'recipients', 'incidents'])->findOrFail($id);

        return Inertia::render('SingleSensorView', [
            'sensor' => new SensorResource($sensor),
            'measurements' => MeasurementResource::collection([]),
            'incidents' => IncidentResource::collection($sensor->incidents),
            'limit' => $sensor->limits != null? new MeasurementLimitResource($sensor->limits): null,
            'recipients' => EmailRecipientResource::collection($sensor->recipients)
        ]);
    }

    public function fullScreen(int $id): Response
    {
        $sensor = Sensor::query()->with('latestMeasurement')->findOrFail($id);
        return Inertia::render('FullScreenView', [
            'sensor' => new SensorWithLatestResource($sensor),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateSensorRequest $request
     * @param string $id
     * @return mixed
     */
    public function update(UpdateSensorRequest $request, string $id): mixed
    {
        $sensor = Sensor::query()
            ->with('currentBattery')
            ->findOrFail($id);
        $sensor->name = $request->input('name');
        $sensor->location = $request->input('location');
        $sensor->position = $request->input('position');
        $sensor->company_id = $request->input('company');

        if($sensor->save()) {
            return response()->success(new SensorResource($sensor));
        } else {
            return response()->error('Prišlo je do napake pri posodabljanju sensorja!');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $sensor = Sensor::query()->with('measurements')->findOrFail($id);
        if($sensor->measurements->count() <= 0) {
            $sensor->delete();
            return response()->json(array('success' => true));
        }

        return response()->error('Sensor ima povezane entitete');
    }
}
