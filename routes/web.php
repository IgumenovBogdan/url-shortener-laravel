<?php

use App\Http\Controllers\LinkController;
use App\Services\LinkService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix(LinkService::getShortenerPrefix())->group(function () {
    Route::get('/{token}', [LinkController::class, 'show']);
});
