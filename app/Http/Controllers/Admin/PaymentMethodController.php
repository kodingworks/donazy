<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentMethodRequest;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Services\PaginationService;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaginationService::make(PaymentMethod::query())
            ->setSearchables([
                'name',
                'account_holder_name',
            ])
            ->build();

        return view('admin::paymentMethod.index', [
            'paymentMethods' => $paymentMethods,
        ]);
    }

    public function create()
    {
        return view('admin::paymentMethod.create');
    }

    public function store(PaymentMethodRequest $request)
    {
        $paymentMethod = PaymentMethod::create($request->validated());

        return redirect()
            ->route('admin::paymentMethod.index')
            ->with('success', __('crud.created', ['name' => 'paymentMethod']));
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin::paymentMethod.edit', ['paymentMethod' => $paymentMethod]);
    }


    public function update(PaymentMethodRequest $request, PaymentMethod $paymentMethod)
    {
        $paymentMethod->update($request->validated());

        return redirect()
            ->route('admin::paymentMethod.edit', $paymentMethod)
            ->with('success', __('crud.updated', ['name' => 'Metode Pembaaran']));
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()
            ->route('admin::paymentMethod.index')
            ->with('success', __('crud.deleted', ['name' => 'Metode Pembayaran']));
    }
}
