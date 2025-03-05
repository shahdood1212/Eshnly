<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    private function isOwner(Client $client, Booking $booking)
    {
        return $client->id === $booking->ship->created_by || 
               $client->id === $booking->trip->created_by;
    }

    public function view(Client $client, Booking $booking)
    {
        return $this->isOwner($client, $booking);
    }

    public function create(Client $client)
    {
        return $client->ships()->exists() || $client->trips()->exists();
    }

    public function update(Client $client, Booking $booking)
    {
        return $this->isOwner($client, $booking);
    }

    public function delete(Client $client, Booking $booking)
    {
        return $this->isOwner($client, $booking);
    }
}
