<?php

namespace App\Policies;

use App\Client;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Client $client): bool
    {
        return $this->belongsToUser($user, $client);
    }

    public function update(User $user, Client $client): bool
    {
        return $this->belongsToUser($user, $client);
    }

    public function destroy(User $user, Client $client): bool
    {
        return $this->belongsToUser($user, $client);
    }

    public function belongsToUser(User $user, Client $client): bool
    {
        if (!$client->user) {
            return false;
        }

        return $client->user->is($user);
    }
}
