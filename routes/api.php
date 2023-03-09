<?php

use App\Http\Controllers\Auth\MeController;
use Illuminate\Support\Facades\{Auth, Route};

Auth::loginUsingId('b8a670a2-3dc4-4ecd-9eaf-13139a6b8a2f');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', MeController::class);
});
