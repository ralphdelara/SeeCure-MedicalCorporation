<?php

namespace App\Traits;

use DateTimeInterface;
use Illuminate\Support\Carbon;

trait CorrectTimezone
{
    protected function serializeDate(DateTimeInterface $date): string
    {
        return Carbon::instance($date)
            ->setTimezone('Asia/Manila')
            ->format('Y-m-d H:i:s');
    }
}
