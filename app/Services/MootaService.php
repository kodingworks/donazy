<?php

namespace App\Services;

use App\Models\Moota\Bank as MootaBank;
use App\Models\Moota\Mutation as MootaMutation;
use App\Models\Mutation;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class MootaService
{
    /** @var string */
    private $payload;

    /** @var Collection */
    private $mutations;

    /**
     * Constructor
     *
     * @param string $payload
     * @param string $signature
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
        $this->mutations = Collection::make(json_decode($payload, true));
    }

    public function validateSignature($signature): bool
    {
        return hash_hmac('sha256', $this->payload, Config::get('services.moota.secret')) === $signature;
    }

    public function save(): void
    {
        DB::beginTransaction();

        $this->mutations
            ->each(function ($item) {
                $bank = new MootaBank(
                    $item['bank']['corporate_id'],
                    $item['bank']['username'],
                    $item['bank']['atas_nama'],
                    $item['bank']['balance'],
                    $item['bank']['account_number'],
                    $item['bank']['bank_type'],
                    $item['bank']['login_retry'],
                    Carbon::parse($item['bank']['date_from']),
                    Carbon::parse($item['bank']['date_to']),
                    $item['bank']['interval_refresh'],
                    $item['bank']['next_queue'],
                    $item['bank']['is_active'],
                    $item['bank']['in_queue'],
                    $item['bank']['in_progress'],
                    Carbon::parse($item['bank']['recurred_at']),
                    Carbon::parse($item['bank']['created_at']),
                    $item['bank']['token'],
                    $item['bank']['bank_id'],
                    $item['bank']['label'],
                    Carbon::parse($item['bank']['last_update'])
                );

                $mutation = new MootaMutation(
                    $item['account_number'],
                    Carbon::parse($item['date']),
                    $item['description'],
                    $item['note'],
                    $item['amount'],
                    $item['type'],
                    $item['balance'],
                    Carbon::parse($item['updated_at']),
                    Carbon::parse($item['created_at']),
                    $item['mutation_id'],
                    $item['token'],
                    $item['bank_id'],
                    $bank
                );

                Mutation::firstOrCreate(
                    [
                        'account_number' => $bank->accountNumber,
                        'received_at' => $mutation->date,
                        'type' => $mutation->getFormattedType(),
                        'amount' => floor($mutation->amount),
                        'balance' => floor($mutation->balance),
                    ],
                    [
                        'account_number' => $bank->accountNumber,
                        'account_holder_name' => $bank->atasNama,
                        'bank_name' => $bank->label,
                        'received_at' => $mutation->date,
                        'type' => $mutation->getFormattedType(),
                        'description' => $mutation->description,
                        'amount' => floor($mutation->amount),
                        'balance' => floor($mutation->balance),
                    ]
                );

                if ($mutation->getFormattedType() === Mutation::TYPE_CREDIT) {
                    $transaction = Transaction::query()
                        ->where('status', Transaction::STATUS_WAITING)
                        ->where('total', $mutation->amount)
                        ->first();

                    if ($transaction) {
                        $transaction->update(['status' => Transaction::STATUS_PAID]);
                    }
                }
            });

        DB::commit();
    }
}
