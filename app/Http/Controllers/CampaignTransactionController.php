<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Http\Requests\CampaignTransactionStoreRequest;
use App\Models\Campaign;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Services\PaymentMethodService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CampaignTransactionController extends Controller
{
    /** @var PaymentMethodService */
    protected PaymentMethodService $paymentMethodService;

    public function __construct(PaymentMethodService $paymentMethodService)
    {
        $this->paymentMethodService = $paymentMethodService;
    }

    public function create(string $slug): View
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::query()
            ->where('slug', $slug)
            ->published()
            ->available()
            ->firstOrFail();

        $amounts = [
            10000,
            15000,
            20000,
            25000,
            50000,
            100000,
        ];

        $minAmount = min($amounts);

        $paymentMethod = $this->paymentMethodService->getPaymentMethod();

        return view('campaigns.transactions.create', [
            'campaign' => $campaign,
            'amounts' => $amounts,
            'minAmount' => $minAmount,
            'paymentMethod' => $paymentMethod,
            'user' => Auth::user() ?? null,
        ]);
    }

    public function store(string $slug, CampaignTransactionStoreRequest $request): RedirectResponse
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::query()
        ->where('slug', $slug)
        ->published()
        ->available()
        ->firstOrFail();
        
        $paymentMethod = PaymentMethod::query()->where('id', intval($request->payment_method_id))->firstOrFail();

        $paymentMethod = PaymentMethod::query()->where('id', intval($request->payment_method_id))->get();

        /** @var Transaction $transaction */
        $transaction = $campaign
            ->transactions()
            ->create($request->validation());

        if (Auth::check()) {
            return redirect()->route('transactions.show', ['code' => $transaction->code]);
        }

        /** @var array $transactionCodes */
        $transactionCodes = [];

        if ($cookie = Cookie::get('transactionCodes')) {
            $transactionCodes = json_decode($cookie);
        }

        $transactionCodes[] = $transaction->code;

        Cookie::queue('transactionCodes', json_encode($transactionCodes), 60 * 24); // expire on 24 Hours

        return redirect()->route('transactions.show', [
            'payment_method' => $paymentMethod,
            'code' => $transaction->code
        ]);
    }
}
