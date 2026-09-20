<?php

use App\Http\Controllers\Crm\BrevoWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/crm/v1/webhooks/brevo/transactional', [BrevoWebhookController::class, 'transactional'])
    ->middleware('brevo.webhook:transactional')
    ->name('crm.v1.webhooks.brevo.transactional');
Route::post('/crm/v1/webhooks/brevo/inbound', [BrevoWebhookController::class, 'inbound'])
    ->middleware('brevo.webhook:inbound')
    ->name('crm.v1.webhooks.brevo.inbound');
Route::post('/crm/v1/webhooks/brevo/marketing', [BrevoWebhookController::class, 'marketing'])
    ->middleware('brevo.webhook:marketing')
    ->name('crm.v1.webhooks.brevo.marketing');
