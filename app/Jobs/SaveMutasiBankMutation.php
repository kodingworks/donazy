<?php

namespace App\Jobs;

use App\Services\MutasiBankService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveMutasiBankMutation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var MutasiBankService */
    private $mutasiBankService;

    public function __construct(MutasiBankService $mutasiBankService)
    {
        $this->mutasiBankService = $mutasiBankService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->mutasiBankService->save();
    }
}
