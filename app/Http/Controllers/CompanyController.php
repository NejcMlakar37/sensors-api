<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $companies = QueryBuilder::for(Company::class)
            ->defaultSort('name')
            ->allowedFilters([
                'name'
            ])
            ->allowedSorts('name')->get();

        return CompanyResource::collection($companies);
    }

    /**
     * Store a newly created resource in storage.
     * @param CompanyRequest $request
     * @return mixed
     */
    public function store(CompanyRequest $request): mixed
    {
        $company = new Company([
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'city' => $request->get('city'),
            'postcode' => $request->get('postcode'),
            'country' => $request->get('country'),
            'contact_email' => $request->get('email')
        ]);

        if($company->save()) {
            return response()->insert($company->id);
        } else {
            return response()->error('Prišlo je do napake pri shranjevanju novega podjetja!');
        }
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return CompanyResource
     */
    public function show(int $id): CompanyResource
    {
        $company = Company::query()->findOrFail($id);
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     * @param CompanyRequest $request
     * @param int $companyId
     * @return mixed
     */
    public function update(CompanyRequest $request, int $companyId): mixed
    {
        $company = Company::query()->findOrFail($companyId);
        $company->name = $request->get('name');
        $company->address = $request->get('address');
        $company->city = $request->get('city');
        $company->postcode = $request->get('postcode');
        $company->country = $request->get('country');
        $company->contact_email = $request->get('email');

        if($company->save()) {
            return response()->success(new CompanyResource($company));
        } else {
            return response()->error('Prišlo je do napake pri posodabljanju sensorja!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $companyId)
    {
        $company = Company::query()->with('sensors')->findOrFail($companyId);
        if($company->sensors->count() <= 0) {
            $company->delete();
            return response()->json(array('success' => true));
        }

        return response()->error('Podjetje ima povezane senzorje!');
    }
}
