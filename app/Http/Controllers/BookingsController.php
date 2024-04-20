<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Response;

class BookingsController extends Controller
{
    // doesn't seem like this was mentioned anywhere in the readme, but booking deletion didn't work because it didn't have an associated action
    public function destroy(int $clientId, int $bookingId): Response
    {
        $booking = Booking::with('client.user')->find($bookingId);
        $this->authorize('destroy', $booking);
        $booking->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
