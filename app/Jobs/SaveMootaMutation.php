<?php

namespace App\Jobs;

use App\Services\MootaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveMootaMutation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var MootaService */
    private $mootaService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MootaService $mootaService)
    {
        $this->mootaService = $mootaService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->mootaService->save();
    }
}
