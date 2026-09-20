<?php

use App\Http\Controllers\Crm\BrevoWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/crm/v1/webhooks/brevo', BrevoWebhookController::class)
    ->name('api.crm.v1.webhooks.brevo');
