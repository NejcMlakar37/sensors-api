<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSensorRequest;
use App\Http\Requests\UpdateSensorRequest;
use App\Http\Resources\SensorResource;
use App\Models\Sensor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
                'location'
            ])
            ->allowedSorts('name, location')->get();

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
     * @return SensorResource
     */
    public function show(int $id): SensorResource
    {
        $sensor = Sensor::query()->with('currentBattery')->findOrFail($id);
        return new SensorResource($sensor);
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
