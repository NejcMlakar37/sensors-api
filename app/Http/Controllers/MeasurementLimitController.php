<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeasurementLimitRequest;
use App\Http\Resources\MeasurementLimitResource;
use App\Models\MeasurementLimit;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MeasurementLimitController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return MeasurementLimitResource|null[]
     */
    public function index(): MeasurementLimitResource|array
    {
        $limits = QueryBuilder::for(MeasurementLimit::class)
            ->with('sensor')
            ->allowedFilters([
                AllowedFilter::exact('sensor_id')
            ])
            ->defaultSort('id')
            ->allowedSorts('id, sensor_id')->first();

        if($limits != null) {
            return new MeasurementLimitResource($limits);
        } else {
            return ["data" => null];
        }
    }

    /**
     * Store a newly created resource in storage
     * @param MeasurementLimitRequest $request
     * @return mixed
     */
    public function store(MeasurementLimitRequest $request): mixed
    {
        $limit = new MeasurementLimit(
            [
                'sensor_id' => $request->input('sensor_id'),
                'min_temp' => $request->input('min_temp'),
                'max_temp' => $request->input('max_temp'),
                'min_humidity' => $request->input('min_humidity'),
                'max_humidity' => $request->input('max_humidity'),
            ]
        );

        if($limit->save()) {
            return response()->successRedirect('Meje so bile uspešno shranjene!');
        } else {
            return response()->errorRedirect('Prišlo je do napake pri shranjevanju mej!');
        }
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return MeasurementLimitResource
     */
    public function show(int $id): MeasurementLimitResource
    {
        $limit = MeasurementLimit::query()->with('sensor')->findOrFail($id);
        return new MeasurementLimitResource($limit);
    }

    /**
     * Update the specified resource in storage.
     * @param MeasurementLimitRequest $request
     * @return mixed
     */
    public function update(MeasurementLimitRequest $request): mixed
    {
        $limit = MeasurementLimit::query()->updateOrCreate(
            ['sensor_id' => $request->input('sensor_id')],
            [
                'min_temp' => $request->input('min_temp'),
                'max_temp' => $request->input('max_temp'),
                'min_humidity' => $request->input('min_humidity'),
                'max_humidity' => $request->input('max_humidity'),
            ]
        );

        if($limit->save()) {
            return response()->successRedirect('Meje so bile uspešno shranjene!');
        } else {
            return response()->errorRedirect('Prišlo je do napake pri posodabljanju mej!');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id): mixed
    {
        $limit = MeasurementLimit::query()->findOrFail($id);
        if($limit->delete()) {
            return response()->successRedirect('Meja je bil uspešno izbrisana!');
        } else {
            return response()->errorRedirect('Prišlo je do napake pri brisanju meje!');
        }
    }
}
