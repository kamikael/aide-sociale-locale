<?php

namespace App\Mail;

use App\Models\Don;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonationConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Don $don;

    public function __construct(Don $don)
    {
        $this->don = $don;
    }

    public function build()
    {
        return $this->subject('Confirmation de votre don')
            ->view('emails.donation_confirmed');
    }
}
