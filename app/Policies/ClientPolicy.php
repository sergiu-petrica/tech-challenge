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
        return $client->user->is($user);
    }

    public function update(User $user, Client $client): bool
    {
        return $client->user->is($user);
    }

    public function destroy(User $user, Client $client): bool
    {
        return $client->user->is($user);
    }
}
