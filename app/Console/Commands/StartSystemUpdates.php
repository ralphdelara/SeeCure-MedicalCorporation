<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

#[Signature('system-updates:start')]
#[Description('Trigger System Update notifications')]
class StartSystemUpdates extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $warning = [
            'title'   => 'Developer is performing system updates.',
            'current' => 0,
            'total'   => 0,
            'msg'     => 'We are currently updating our system to bring you new features. Thanks for your patience!',
        ];
        Cache::put('warning', $warning);

        return self::SUCCESS;
    }
}
