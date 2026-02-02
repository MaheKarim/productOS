<?php

namespace App\Console\Commands;

use App\Jobs\ExpireNotifications;
use App\Jobs\SendScheduledNotifications;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScheduleNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process scheduled and expire notifications';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        Log::info('Processing scheduled notifications...');

        // Dispatch job to send scheduled notifications
        SendScheduledNotifications::dispatch();

        // Dispatch job to expire notifications
        ExpireNotifications::dispatch();

        Log::info('Notification processing completed.');

        return Command::SUCCESS;
    }
}
