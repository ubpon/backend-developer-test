<?php

use App\Http\Controllers\MartianController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\TradingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('martians', MartianController::class);

Route::get('martians/{id}/supplies', [MartianController::class, 'showMartianSupply']);

Route::apiResource('supplies', SupplyController::class);

Route::post('trades', [TradingController::class, 'trade']);
