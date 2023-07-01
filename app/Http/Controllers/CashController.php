<?php

namespace App\Http\Controllers;

use App\Http\Resources\CashResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CashController extends Controller
{
    public function index()
    {
        $debit = Auth::user()
            ->cashes()
            ->whereBetween('when', [now()->firstOfMonth(), now()])
            ->where('amount', '>=', 0)
            ->get('amount')
            ->sum('amount');

        $credit = Auth::user()
            ->cashes()
            ->whereBetween('when', [now()->firstOfMonth(), now()])
            ->where('amount', '<', 0)
            ->get('amount')
            ->sum('amount');

        $balances = Auth::user()->cashes()->get('amount')->sum('amount');
        return $debit;



        // $transactions = Auth::user()->cashes()->whereBetween('when', [now()->firstOfMonth(), now()])->latest()->get();

        // $response = [
        //     "balances" => formatPrice($balances),
        //     "debit" => formatPrice($debit),
        //     "credit" => formatPrice($credit),
        //     "transactions" => CashResource::collection($transactions),
        // ];

        // return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "amount" => "required|numeric"
        ]);

        Auth::user()->cashes()->create([
            "name" => $request->name,
            "slug" => Str::slug($request->name . '-' . Str::random(8)),
            "when" => $request->when ?? now(),
            "amount" => $request->amount,
            "description" => $request->description,
        ]);

        return response()->json([
            "message" => "The transaction {$request->name} has been saved"
        ]);
    }
}
