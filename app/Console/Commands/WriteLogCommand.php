<?php

namespace App\Console\Commands;

use App\Jobs\WriteLog;
use Illuminate\Console\Command;

class WriteLogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'writelog:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Description of your command';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        WriteLog::dispatch();
    }
}
