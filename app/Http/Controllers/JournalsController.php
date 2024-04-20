<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\JournalStoreRequest;
use App\Http\Resources\JournalResource;
use App\Journal;
use Carbon\Carbon;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class JournalsController extends Controller
{
    public function show(int $clientId, int $journalId): View // could have used route model binding here, but this way I can load the journal with its relations in one single query
    {
        $journal = Journal::with('client.user')->find($journalId);
        $this->authorize('view', [$journal, $clientId]);

        return view('journals.show', ['journal' => JournalResource::make($journal)]);
    }

    public function create(int $clientId): View
    {
        return view('journals.create', ['clientId' => $clientId]);
    }

    public function store(JournalStoreRequest $request): Response
    {
        $client = Client::with('user')->find($request->client_id);
        $this->authorize('update', $client);

        $journal = new Journal([
            'content' => $request->journal_content,
            'date' => Carbon::now(),
            'client_id' => $client->id,
        ]);
        $journal->save();

        return response(JournalResource::make($journal), Response::HTTP_CREATED);
    }

    public function destroy(int $clientId, int $journalId): Response
    {
        $journal = Journal::with('client')->find($journalId);
        $this->authorize('destroy', [$journal, $clientId]);
        $journal->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
