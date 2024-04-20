<?php

namespace App\Policies;

use App\Booking;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    public function destroy(User $user, Booking $booking): bool
    {
        return $booking->client->user->is($user);
    }
}
