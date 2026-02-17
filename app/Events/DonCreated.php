<?php

namespace App\Events;

use App\Models\Don;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DonCreated
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Don $don
    ) {}
}
