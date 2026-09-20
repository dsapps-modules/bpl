<x-layouts.crm :title="$settings['title']" eyebrow="Configurações do CRM">
    <section class="mx-auto max-w-[1200px] px-4 py-8 sm:px-6 lg:px-8" data-crm-settings data-endpoint="{{ $settings['endpoint'] }}" data-api-base="{{ $crmApiBase }}">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.14em] text-accent-600">Configurações do CRM</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $settings['title'] }}</h1>
            </div>
            <button type="button" data-settings-open class="inline-flex min-h-11 items-center justify-center rounded-lg bg-slate-900 px-5 text-sm font-bold text-white">+ Novo registro</button>
        </div>
        <div class="mt-8 hidden" data-settings-feedback role="status"></div>
        <div class="mt-4" data-settings-state="loading" aria-busy="true"><div class="h-64 animate-pulse rounded-2xl border border-slate-200 bg-slate-100"></div></div>
        <div class="mt-4 hidden" data-settings-state="error" role="alert"><div class="rounded-2xl border border-red-200 bg-red-50 p-6 text-red-800"><p data-settings-error></p><button type="button" data-settings-retry class="mt-4 rounded-lg bg-red-700 px-4 py-2 text-sm font-bold text-white">Tentar novamente</button></div></div>
        <div class="mt-4 hidden" data-settings-state="content"><div class="overflow-hidden rounded-2xl border border-slate-200 bg-white"><div class="divide-y divide-slate-100" data-settings-rows></div></div></div>
        <dialog data-settings-dialog class="w-[min(100%-2rem,42rem)] rounded-2xl border border-slate-200 p-0 shadow-2xl backdrop:bg-slate-900/30">
            <form method="dialog" data-settings-form class="p-6 sm:p-8">
                <div class="flex items-start justify-between gap-4"><div><p class="crm-kicker">Configuração</p><h2 class="mt-1 text-xl font-bold text-slate-900" data-settings-form-title>Novo registro</h2></div><button type="button" data-settings-close aria-label="Fechar formulário" class="rounded-lg p-2 text-xl leading-none text-slate-500 hover:bg-slate-100">×</button></div>
                <div class="mt-6 grid gap-5">
                    <div><label for="settings-name" class="mb-1 block text-sm font-semibold text-slate-700">Nome do funil</label><input id="settings-name" name="name" required maxlength="160" placeholder="Ex.: Vendas" class="min-h-11 w-full rounded-lg border border-slate-300 px-3"><p class="mt-1.5 text-xs text-slate-500">Dê um nome que ajude o time a reconhecer este caminho comercial.</p></div>
                    <div data-settings-extra></div>
                </div>
                <p class="mt-4 hidden rounded-lg bg-red-50 p-3 text-sm text-red-700" data-settings-form-error role="alert"></p>
                <div class="mt-7 flex justify-end gap-3"><button type="button" data-settings-close class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-bold text-slate-600">Cancelar</button><button type="submit" data-settings-submit class="rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-bold text-white">Criar funil</button></div>
            </form>
        </dialog>
    </section>
</x-layouts.crm>
