<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Laravel\Prompts\confirm;

#[Signature('app:sample')]
#[Description('Command description')]
class Sample extends Command implements PromptsForMissingInput
{

    protected $shouldKeepRunning = true;
    /**
     * Execute the console command.
     */
    public function handle()
    {

        var_dump(getmypid());

        $this->trap(SIGTERM, fn() => $this->shouldKeepRunning = false);

        $i = 0;
        while ($this->shouldKeepRunning) {
            var_dump($i++);
            sleep(1); // 処理が速すぎてログが埋まるのを防ぐため0.1秒待機
        }
    }
}
