<?php

namespace App;

use App\Events\GeneralOptionEvent;
use Illuminate\Database\Eloquent\Model;

class GeneralOption extends Model
{
    protected $dispatchesEvents = [
        'updated' => GeneralOptionEvent::class
    ];
}
