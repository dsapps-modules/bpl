<?php

use App\Http\Controllers\Crm\BrevoWebhookController;
use App\Http\Controllers\Crm\CompanyDirectoryController;
use App\Http\Controllers\Crm\ContactDirectoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/crm/v1/directory')->middleware(['web', 'auth'])->group(function (): void {
    Route::apiResource('companies', CompanyDirectoryController::class)->middleware('permission:crm.companies.manage');
    Route::apiResource('contacts', ContactDirectoryController::class)->middleware('permission:crm.contacts.manage');
});

Route::post('/crm/v1/webhooks/brevo/transactional', [BrevoWebhookController::class, 'transactional'])
    ->middleware('brevo.webhook:transactional')
    ->name('crm.v1.webhooks.brevo.transactional');
Route::post('/crm/v1/webhooks/brevo/inbound', [BrevoWebhookController::class, 'inbound'])
    ->middleware('brevo.webhook:inbound')
    ->name('crm.v1.webhooks.brevo.inbound');
Route::post('/crm/v1/webhooks/brevo/marketing', [BrevoWebhookController::class, 'marketing'])
    ->middleware('brevo.webhook:marketing')
    ->name('crm.v1.webhooks.brevo.marketing');
