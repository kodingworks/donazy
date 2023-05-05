<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Illuminate\Console\Command;

class UpdateExpiredTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expired-transactions:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for update expire transactions to: ' . Transaction::STATUS_EXPIRED;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start = now();
        $this->line('Started at: ' . $start);

        Transaction::query()
            ->where('status', Transaction::STATUS_WAITING)
            ->whereRaw('TIMESTAMPDIFF(DAY, created_at, ?) >= 1', [now()])
            ->update(['status' => Transaction::STATUS_EXPIRED]);

        $this->line('Finished at: ' . now());
        $this->info('Duration: ' . now()->diffInMinutes($start) . ' minutes');

        return 0;
    }
}
