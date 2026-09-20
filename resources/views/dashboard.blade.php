<x-layouts.crm title="Dashboard" eyebrow="Visão geral">
    <section class="crm-dashboard-page mx-auto max-w-[1440px] px-4 py-8 sm:px-6 lg:px-8" data-crm-dashboard data-api-base="{{ $crmApiBase }}">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
            <div><p class="text-sm font-bold uppercase tracking-[0.14em] text-accent-600">Visão geral · hoje</p><h1 class="mt-2 max-w-2xl text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Bom dia, {{ auth()->user()->name }}.</h1><p class="mt-3 max-w-2xl text-base text-slate-500">Uma leitura rápida do que merece sua atenção agora.</p></div>
            @if (auth()->user()->hasPermission('crm.tasks.manage'))<a href="{{ route('crm.tasks') }}" class="inline-flex min-h-11 items-center justify-center rounded-lg bg-slate-900 px-5 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">+ Nova tarefa</a>@endif
        </div>
        <div class="mt-8" data-crm-state="loading" aria-busy="true" aria-label="Carregando indicadores"><div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">@foreach (range(1, 4) as $skeleton)<div class="h-36 animate-pulse rounded-2xl border border-slate-200 bg-slate-100" aria-hidden="true"></div>@endforeach</div></div>
        <div class="mt-8 hidden" data-crm-state="error" role="alert"><div class="rounded-2xl border border-red-200 bg-red-50 p-6 text-red-800"><h2 class="font-bold">Não foi possível carregar o dashboard</h2><p class="mt-2 text-sm" data-crm-error-message>Confira sua conexão e tente novamente.</p><button type="button" data-crm-retry class="mt-4 rounded-lg bg-red-700 px-4 py-2 text-sm font-bold text-white hover:bg-red-800">Tentar novamente</button></div></div>
        <div class="mt-8 hidden" data-crm-state="content">
            <section class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4" aria-label="Indicadores principais">
                <article class="crm-stat-card border-t-coral"><span>Oportunidades abertas</span><strong data-crm-metric="open_opportunities">—</strong><small>em todos os funis</small></article>
                <article class="crm-stat-card border-t-teal"><span>Taxa de ganho</span><strong data-crm-metric="win_rate">—</strong><small data-crm-metric-note="win_rate">sem fechamentos ainda</small></article>
                <article class="crm-stat-card border-t-amber"><span>Tarefas atrasadas</span><strong data-crm-metric="overdue_tasks">—</strong><small data-crm-metric-note="overdue_tasks">operação em dia</small></article>
                <article class="crm-stat-card border-t-slate-800"><span>Negócios ganhos</span><strong data-crm-metric="won_opportunities">—</strong><small>histórico total</small></article>
            </section>
            <div class="mt-3 grid gap-3 lg:grid-cols-[minmax(280px,.8fr)_minmax(0,1.7fr)]">
                <section class="crm-panel-card" aria-labelledby="crm-tasks-title"><div class="flex items-start justify-between gap-4"><div><p class="crm-kicker">Acompanhamento</p><h2 id="crm-tasks-title" class="mt-1 text-lg font-bold text-slate-900">Próximas tarefas</h2></div><a href="{{ route('crm.tasks') }}" class="text-sm font-bold text-accent-600 hover:underline">Ver agenda →</a></div><div class="mt-5" data-crm-tasks></div></section>
                <section class="crm-panel-card" aria-labelledby="crm-pipeline-title"><div class="flex items-start justify-between gap-4"><div><p class="crm-kicker">Vendas</p><h2 id="crm-pipeline-title" class="mt-1 text-lg font-bold text-slate-900">Pipeline em movimento</h2></div><a href="{{ route('crm.pipeline') }}" class="text-sm font-bold text-accent-600 hover:underline">Abrir funil →</a></div><div class="mt-5 overflow-x-auto" data-crm-pipeline></div></section>
            </div>
        </div>
    </section>
</x-layouts.crm>
