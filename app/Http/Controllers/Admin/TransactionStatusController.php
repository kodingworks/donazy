<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransactionStatusUpdateRequest;
use App\Models\Transaction;
use App\Notifications\TransactionPaid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;

class TransactionStatusController extends Controller
{
    /**
     * Update transaction status for given transaction model
     *
     * @param TransactionStatusUpdateRequest $request
     * @param Transaction $transaction
     * @return RedirectResponse
     */
    public function update(TransactionStatusUpdateRequest $request, Transaction $transaction): RedirectResponse
    {
        abort_if($transaction->status != Transaction::STATUS_WAITING, Response::HTTP_BAD_REQUEST);

        $transaction->update($request->validated());

        return redirect()
            ->route('admin::transactions.index')
            ->with('success', __('crud.updated', ['name' => 'transaction']));
    }
}
