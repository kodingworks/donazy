<?php

namespace App\Models;

use App\Channels\WebPushChannel;
use App\Jobs\UpdateExpiredTransaction;
use App\Notifications\TransactionPaid;
use App\Notifications\TransactionWaitingForPayment;
use App\Services\UniqueCodeGeneratorService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Notification;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public const STATUS_WAITING = 'WAITING';

    public const STATUS_CANCELED = 'CANCELED';

    public const STATUS_EXPIRED = 'EXPIRED';

    public const STATUS_PAID = 'PAID';

    public const STATUSES = [
        self::STATUS_WAITING,
        self::STATUS_CANCELED,
        self::STATUS_EXPIRED,
        self::STATUS_PAID,
    ];

    public const EXPIRED_TIME_IN_SECONDS = 86400; // 24 Hours

    protected static function booted()
    {
        static::creating(function (self $transaction) {
            $lastTransaction = self::query()->orderByDesc('id')->first();
            $nextTransactionId = !empty($lastTransaction) ? $lastTransaction->id + 1 : 1;
            $transaction->code = 'INV-' . now()->format('Ymd') . str_pad($nextTransactionId, 5, 0, STR_PAD_LEFT);

            /** @var Campaign $campaign */
            $campaign = $transaction->campaign;
            $uniqueCodeGeneratorService = new UniqueCodeGeneratorService($campaign->unique_code_sufix);

            $transaction->unique_code = $uniqueCodeGeneratorService->generate();
            $transaction->total = $transaction->amount + $transaction->unique_code;

            if (empty($transaction->status)) {
                $transaction->status = self::STATUS_WAITING;
            }
        });

        static::created(function (self $transaction) {
            UpdateExpiredTransaction::dispatch($transaction)->delay(self::EXPIRED_TIME_IN_SECONDS);

            $transaction->sendNotification();
        });

        static::updated(function (self $transaction) {
            if ($transaction->wasChanged('status')) {
                $transaction->sendNotification();

                $query = self::query()
                    ->where('campaign_id', $transaction->campaign_id)
                    ->where('status', self::STATUS_PAID);

                /** @var Campaign $campaign */
                $campaign = $transaction->campaign;

                $campaign->update([
                    'collected_funds' => $query->sum('total'),
                    'donors' => $query->count(),
                ]);
            }
        });
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function paymentMethod(): BelongsTo
    
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function isAnonymous(): bool
    {
        return (bool) $this->anonymous;
    }

    public function sendNotification(): void
    {
        $notification = null;

        switch ($this->status) {
            case self::STATUS_WAITING:
                $notification = new TransactionWaitingForPayment($this);
                break;

            case self::STATUS_PAID:
                $notification = new TransactionPaid($this);
                break;
        }

        if ($notification) {
            Notification::route('mail', [$this->user_email => $this->user_name])
                ->route(WebPushChannel::class, $this->meta)
                ->notify($notification);
        }
    }
}
