<?php

namespace App\Listeners;

use App\Events\SampleEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SampleLintener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SampleEvent $event)
    {
        Log::info('Sample Listener id called');
        return 1;
    }

    public function shouldQueue(SampleEvent $event): bool
    {
        return $event->id === 1;
    }
}
