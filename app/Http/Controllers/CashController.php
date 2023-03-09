<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CashController extends Controller
{
    public function store(Request $request)
    {
        $auth_user = auth()->user();

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
