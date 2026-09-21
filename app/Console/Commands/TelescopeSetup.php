<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('telescope:setup')]
#[Description('telescope setup')]
class TelescopeSetup extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sqlitePath = database_path('telescope/telescope.sqlite');

        if (file_exists($sqlitePath)) {
            unlink($sqlitePath);
        }

        $this->call('migrate', [
            '--database' => 'telescope_sqlite',
            '--path' => 'database/telescope/migrations',
        ]);

        return self::SUCCESS;
    }
}
