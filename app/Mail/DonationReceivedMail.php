<?php

namespace App\Mail;

use App\Models\Don;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonationReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Don $don;

    public function __construct(Don $don)
    {
        $this->don = $don;
    }

    public function build()
    {
        return $this->subject('Nouveau don reçu')
            ->view('emails.donation_received');
    }
}
