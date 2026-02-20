<?php

namespace App\Listeners;

use App\Events\DonCreated;
use App\Mail\DonationConfirmedMail;
use App\Mail\DonationReceivedMail;
use Illuminate\Support\Facades\Mail;

class SendDonationNotification
{
    public function handle(DonCreated $event): void
    {
        $don = $event->don;

        // Email au donateur
        Mail::to($don->donateur->email)
            ->send(new DonationConfirmedMail($don));

        // Email à l'organisateur
        Mail::to($don->cagnotte->organisateur->email)
            ->send(new DonationReceivedMail($don));
    }
}
