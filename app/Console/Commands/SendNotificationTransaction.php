<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Illuminate\Console\Command;

class SendNotificationTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-notification:transaction {transactionId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for send transaction notification';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $transaction = Transaction::findOrFail($this->argument('transactionId'));
        $transaction->sendNotification();

        return 0;
    }
}
