<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

#[Signature('system-updates:stop')]
#[Description('Stops System Update notifications')]
class StopSystemUpdates extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        Cache::delete('warning');

        return self::SUCCESS;
    }
}
