<?php

namespace App\Events;

use App\Models\Don;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DonCreated
{
    use Dispatchable, SerializesModels;

    public Don $don;
 // don
    public function __construct(Don $don)
    {
        $this->don = $don;
    }
}
