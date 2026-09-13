<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class SampleJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Product $product
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('from sample job show product instance');
        // logger($this->product->toArray());
    }

    // /**
    //  * このジョブを通過させるミドルウェアを取得
    //  *
    //  * @return array<int, object>
    //  */
    // public function middleware(): array
    // {
    //     return [new WithoutOverlapping($this->product->id)];
    // }
}
