<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\PaginationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MyTransactionController extends Controller
{
    public function index()
    {
        $paidTransactionTotal = Transaction::query()
            ->where('user_id', Auth::id())
            ->where('status', Transaction::STATUS_PAID)
            ->sum('total');
        $query = Transaction::with(['campaign'])->where('user_id', Auth::id());

        $transactions = PaginationService::make($query)->build();

        return view('my-transactions.index', [
            'paidTransactionTotal' => $paidTransactionTotal,
            'transactions' => $transactions,
        ]);
    }
}
