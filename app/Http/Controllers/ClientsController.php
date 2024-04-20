<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Resources\ClientResource;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ClientsController extends Controller
{
    public function index(): View // refactoring note: added return types everywhere
    {
        $clients = Client::where('user_id', auth()->id())->get();

        foreach ($clients as $client) {
            $client->append('bookings_count');
        }

        // refactoring note: added resource classes for response data, this way we're forced to whitelist
        // relevant properties without worrying about accidentally throwing properties we don't want in the frontend.
        // the model's $hidden property achieves something similar, but resource classes are an extra layer of assurance
        return view('clients.index', ['clients' => ClientResource::collection($clients)]);
    }

    public function create(): View
    {
        return view('clients.create');
    }

    public function show(int $clientId): View
    {
        $client = Client::with(['bookings', 'journals'])->find($clientId);
        $this->authorize('view', $client);

        return view('clients.show', ['client' => ClientResource::make($client)]);
    }

    public function store(ClientStoreRequest $request): Response
    {
        $client = new Client([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'city' => $request->get('city'),
            'postcode' => $request->get('postcode'),
            'user_id' => auth()->id(),
        ]);
        $client->save();

        return response(ClientResource::make($client), Response::HTTP_CREATED); // refactor notes: added responses everywhere, this way we can control the status code
    }

    public function destroy(int $clientId): Response
    {
        $client = Client::with('user')->find($clientId);
        $this->authorize('destroy', $client);
        $client->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
