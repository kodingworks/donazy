<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Admin\TransactionsExport;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\PaginationService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $builder = Transaction::query()
            ->join('campaigns', 'transactions.campaign_id', '=', 'campaigns.id')
            ->select([
                'transactions.*',
                'campaigns.name as campaign_name',
            ]);

        if (request('action') === 'export') {
            return (new TransactionsExport($builder))->download();
        }

        $transactions = PaginationService::make($builder)
            ->setSearchables([
                'transactions.id',
                'code',
                'campaigns.name',
                'user_name',
                'total',
                'transactions.created_at',
                'status',
            ])
            ->build();

        return view('admin::transactions.index', [
            'transactions' => $transactions,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['campaign']);

        return view('admin::transactions.show', [
            'transaction' => $transaction,
            'statuses' => Transaction::STATUSES,
        ]);
    }
}
