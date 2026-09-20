<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CrmPageController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
    Route::get('/esqueci-minha-senha', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/esqueci-minha-senha', [ForgotPasswordController::class, 'store'])->middleware('throttle:5,1')->name('password.email');
    Route::get('/redefinir-senha/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/redefinir-senha', [ResetPasswordController::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->middleware('permission:dashboard.view')->name('dashboard');

    Route::get('/crm/contatos', [CrmPageController::class, 'show'])
        ->defaults('slug', 'contacts')
        ->middleware('permission:crm.contacts.manage')
        ->name('crm.contacts');
    Route::get('/crm/empresas', [CrmPageController::class, 'show'])
        ->defaults('slug', 'companies')
        ->middleware('permission:crm.companies.manage')
        ->name('crm.companies');
    Route::get('/crm/pipeline', [CrmPageController::class, 'show'])
        ->defaults('slug', 'pipeline')
        ->middleware(['permission:crm.opportunities.manage', 'permission:crm.pipelines.manage'])
        ->name('crm.pipeline');
    Route::get('/crm/tarefas', [CrmPageController::class, 'show'])
        ->defaults('slug', 'tasks')
        ->middleware('permission:crm.tasks.manage')
        ->name('crm.tasks');
    Route::get('/crm/agenda', [CrmPageController::class, 'show'])
        ->defaults('slug', 'calendar')
        ->middleware('permission:crm.calendar.manage')
        ->name('crm.calendar');
    Route::get('/crm/inbox', [CrmPageController::class, 'show'])
        ->defaults('slug', 'inbox')
        ->middleware('permission:crm.inbox.manage')
        ->name('crm.inbox');
    Route::get('/crm/campanhas', [CrmPageController::class, 'show'])
        ->defaults('slug', 'campaigns')
        ->middleware('permission:crm.email_marketing.manage')
        ->name('crm.campaigns');
    Route::get('/crm/automacoes', [CrmPageController::class, 'show'])
        ->defaults('slug', 'automations')
        ->middleware('permission:crm.automations.manage')
        ->name('crm.automations');
    Route::get('/crm/relatorios', [CrmPageController::class, 'show'])
        ->defaults('slug', 'reports')
        ->middleware('permission:crm.reports.view')
        ->name('crm.reports');

    Route::prefix('/crm/configuracoes')->name('crm.settings.')->group(function (): void {
        Route::get('/funis', [CrmPageController::class, 'show'])
            ->defaults('slug', 'settings/pipelines')
            ->middleware('permission:crm.pipelines.manage')
            ->name('pipelines');
        Route::get('/equipes', [CrmPageController::class, 'show'])
            ->defaults('slug', 'settings/teams')
            ->middleware('permission:crm.teams.manage')
            ->name('teams');
        Route::get('/tags', [CrmPageController::class, 'show'])
            ->defaults('slug', 'settings/tags')
            ->middleware('permission:crm.tags.manage')
            ->name('tags');
        Route::get('/segmentos', [CrmPageController::class, 'show'])
            ->defaults('slug', 'settings/segments')
            ->middleware('permission:crm.segments.manage')
            ->name('segments');
        Route::get('/campos-personalizados', [CrmPageController::class, 'show'])
            ->defaults('slug', 'settings/custom-fields')
            ->middleware('permission:crm.fields.manage')
            ->name('custom-fields');
    });

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
