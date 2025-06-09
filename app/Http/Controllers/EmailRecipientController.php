<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRecipientRequest;
use App\Http\Requests\UpdateRecipientRequest;
use App\Http\Resources\EmailRecipientResource;
use App\Models\EmailRecipient;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class EmailRecipientController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $recipients = QueryBuilder::for(EmailRecipient::class)
            ->with('sensor')
            ->allowedFilters([AllowedFilter::exact('sensor_id')])
            ->get();

        return EmailRecipientResource::collection($recipients);
    }

    /**
     * Store a newly created resource in storage.
     * @param EmailRecipientRequest $request
     * @return mixed
     */
    public function store(EmailRecipientRequest $request): mixed
    {
        $recipient = new EmailRecipient([
            'sensor_id' => $request->get('sensor_id'),
            'email' => $request->get('email'),
        ]);

        if($recipient->save()) {
            return response()->successRedirect('Prejemnik je bil uspešno dodan!');
        } else {
            return response()->errorRedirect('Prišlo je do težave pri ustvarjanju prejemnika!');
        }
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return EmailRecipientResource
     */
    public function show(int $id): EmailRecipientResource
    {
        $recipient = EmailRecipient::query()->with('sensor')->findOrFail($id);
        return new EmailRecipientResource($recipient);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRecipientRequest $request
     * @return mixed
     */
    public function update(UpdateRecipientRequest $request): mixed
    {
        $recipient = EmailRecipient::query()->with('sensor')->findOrFail($request->get('recipient_id'));
        $recipient->sensor_id = $request->input('sensor_id');
        $recipient->email = $request->input('email');

        if($recipient->save()) {
            $recipient->refresh();
            return response()->successRedirect('Prejemnik je bil uspešno posodobljen!');
        } else {
            return response()->errorRedirect('Prišlo je do težave pri posodabljanju prejemnika!');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id): mixed
    {
        $recipient = EmailRecipient::query()->findOrFail($id);
        if($recipient->delete()) {
            return response()->successRedirect('Prejemnik je bil uspešno izbrisan!');
        } else {
            return response()->errorRedirect('Prišlo je do težave pri izbrisu prejemnika!');
        }
    }
}
