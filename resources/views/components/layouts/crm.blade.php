@php
    $mainNavigation = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'permission' => 'dashboard.view', 'icon' => '▦'],
        ['label' => 'Contatos', 'route' => 'crm.contacts', 'permission' => 'crm.contacts.manage', 'icon' => '◎'],
        ['label' => 'Empresas', 'route' => 'crm.companies', 'permission' => 'crm.companies.manage', 'icon' => '□'],
        ['label' => 'Oportunidades / Pipeline', 'route' => 'crm.pipeline', 'permission' => 'crm.opportunities.manage', 'icon' => '↗'],
        ['label' => 'Tarefas', 'route' => 'crm.tasks', 'permission' => 'crm.tasks.manage', 'icon' => '✓'],
        ['label' => 'Agenda', 'route' => 'crm.calendar', 'permission' => 'crm.calendar.manage', 'icon' => '◷'],
        ['label' => 'Inbox / Conversas', 'route' => 'crm.inbox', 'permission' => 'crm.inbox.manage', 'icon' => '☷'],
        ['label' => 'Campanhas de e-mail', 'route' => 'crm.campaigns', 'permission' => 'crm.email_marketing.manage', 'icon' => '✉'],
        ['label' => 'Automações', 'route' => 'crm.automations', 'permission' => 'crm.automations.manage', 'icon' => '⚙'],
        ['label' => 'Relatórios / Indicadores', 'route' => 'crm.reports', 'permission' => 'crm.reports.view', 'icon' => '▥'],
    ];
    $settingsNavigation = [
        ['label' => 'Funis e etapas', 'route' => 'crm.settings.pipelines', 'permission' => 'crm.pipelines.manage'],
        ['label' => 'Equipes e membros', 'route' => 'crm.settings.teams', 'permission' => 'crm.teams.manage'],
        ['label' => 'Tags', 'route' => 'crm.settings.tags', 'permission' => 'crm.tags.manage'],
        ['label' => 'Segmentos', 'route' => 'crm.settings.segments', 'permission' => 'crm.segments.manage'],
        ['label' => 'Campos personalizados', 'route' => 'crm.settings.custom-fields', 'permission' => 'crm.fields.manage'],
    ];
    $canAccess = fn (string $permission): bool => auth()->user()?->hasPermission($permission) ?? false;
@endphp
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'CRM' }} | BPL Produtos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="crm-shell min-h-screen text-slate-800">
    <div class="flex min-h-screen">
        <aside id="crm-sidebar" class="crm-sidebar fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform lg:static lg:translate-x-0" aria-label="Navegação principal">
            <div class="flex items-center gap-3 border-b border-slate-100 px-6 py-5">
                <img src="{{ asset('images/bpl_logo_512.png') }}" alt="" class="h-10 w-10 rounded-xl object-contain">
                <div><p class="text-sm font-bold tracking-tight text-slate-900">BPL Produtos</p><p class="text-xs text-slate-500">CRM comercial</p></div>
            </div>
            <nav class="flex-1 overflow-y-auto px-3 py-5">
                <p class="px-3 pb-2 text-[0.68rem] font-bold uppercase tracking-[0.16em] text-slate-400">Operação</p>
                <div class="grid gap-1">
                    @foreach ($mainNavigation as $item)
                        @if ($canAccess($item['permission']))
                            <a href="{{ route($item['route']) }}" class="crm-nav-link {{ request()->routeIs($item['route']) ? 'crm-nav-link-active' : '' }}"><span class="crm-nav-icon" aria-hidden="true">{{ $item['icon'] }}</span><span>{{ $item['label'] }}</span></a>
                        @endif
                    @endforeach
                </div>
                <p class="mt-7 px-3 pb-2 text-[0.68rem] font-bold uppercase tracking-[0.16em] text-slate-400">Configurações do CRM</p>
                <div class="grid gap-1">
                    @foreach ($settingsNavigation as $item)
                        @if ($canAccess($item['permission']))
                            <a href="{{ route($item['route']) }}" class="crm-nav-link {{ request()->routeIs($item['route']) ? 'crm-nav-link-active' : '' }}"><span class="crm-nav-icon crm-nav-icon-muted" aria-hidden="true">•</span><span>{{ $item['label'] }}</span></a>
                        @endif
                    @endforeach
                </div>
            </nav>
            <div class="border-t border-slate-100 p-4">
                <div class="mb-3 flex items-center gap-3 rounded-xl bg-slate-50 p-3"><span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-100 text-sm font-bold text-brand-700">{{ str(auth()->user()->name)->substr(0, 1) }}</span><div class="min-w-0"><p class="truncate text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p><p class="truncate text-xs text-slate-500">{{ auth()->user()->email }}</p></div></div>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-600 transition hover:border-brand-300 hover:bg-brand-50 hover:text-brand-700">Sair</button></form>
            </div>
        </aside>
        <div id="crm-sidebar-backdrop" class="fixed inset-0 z-30 hidden bg-slate-900/30 lg:hidden" aria-hidden="true"></div>
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-slate-200 bg-white/95 px-4 backdrop-blur sm:px-6">
                <div class="flex items-center gap-3"><button id="crm-menu-toggle" type="button" class="rounded-lg border border-slate-200 p-2 text-slate-600 hover:bg-slate-50 lg:hidden" aria-label="Abrir menu" aria-controls="crm-sidebar" aria-expanded="false">☰</button><div><p class="text-xs font-semibold uppercase tracking-[0.14em] text-brand-600">{{ $eyebrow ?? 'Área de trabalho' }}</p><p class="text-sm font-semibold text-slate-900">{{ $title ?? 'CRM' }}</p></div></div>
                <div class="flex items-center gap-3 text-sm text-slate-500"><span class="hidden sm:inline">{{ now()->translatedFormat('d \d\e F \d\e Y') }}</span><span class="h-2 w-2 rounded-full bg-emerald-500" title="Sistema online"></span></div>
            </header>
            <main class="min-w-0 flex-1">{{ $slot }}</main>
        </div>
    </div>
    @vite('resources/js/crm.js')
    @vite('resources/js/contacts.js')
    @vite('resources/js/companies.js')
    @vite('resources/js/pipeline.js')
    @vite('resources/js/tasks.js')
    @vite('resources/js/calendar.js')
    @vite('resources/js/reports.js')
    @vite('resources/js/inbox.js')
    @vite('resources/js/resource.js')
    @vite('resources/js/settings.js')
</body>
</html>
