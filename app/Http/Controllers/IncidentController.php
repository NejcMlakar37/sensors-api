<?php

namespace App\Http\Controllers;

use App\Http\Resources\IncidentResource;
use App\Models\Incident;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $incidents = QueryBuilder::for(Incident::class)
            ->with('sensor')
            ->allowedFilters(['sensor_id'])
            ->defaultSort('-created_at')
            ->allowedSorts('id, sensor_id')->get();

        return IncidentResource::collection($incidents);
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return IncidentResource
     */
    public function show(int $id): IncidentResource
    {
        $incident = Incident::query()->with('sensor')->findOrFail($id);
        return new IncidentResource($incident);
    }
}
