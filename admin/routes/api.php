<?php

use App\Http\Controllers\WebhookController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupBallController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook', [WebHookController::class, '__invoke']);

Route::get('/ball', [GroupBallController::class, 'getOneBall']);

Route::get('/group/{phone}/{chatId}', [GroupController::class, 'apiGroup']);

Route::get('/cabinet/{chatId}', [GroupController::class, 'apiCabinet']);

