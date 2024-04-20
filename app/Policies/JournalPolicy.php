<?php

namespace App\Policies;

use App\Journal;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JournalPolicy
{
    use HandlesAuthorization;

    public function view(User $user,  Journal $journal, int $clientId)
    {
        return $this->belongsToClient($clientId, $journal) && $this->belongsToUser($user, $journal);
    }

    public function destroy(User $user, Journal $journal, int $clientId)
    {
        return $this->belongsToClient($clientId, $journal) && $this->belongsToUser($user, $journal);
    }

    private function belongsToClient(int $clientId, Journal $journal)
    {
        return $journal->client_id === $clientId;
    }

    private function belongsToUser(User $user, Journal $journal)
    {
        return $journal->client->user->is($user);
    }
}
