<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mutation;
use App\Services\PaginationService;
use Illuminate\Http\Request;

class MutationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mutations = PaginationService::make(Mutation::query())
            ->setSearchables([
                'account_number',
                'account_holder_name',
                'amount',
                'balance',
                'type',
                'description',
            ])
            ->build();

        return view('admin::mutations.index', [
            'mutations' => $mutations,
        ]);
    }
}
