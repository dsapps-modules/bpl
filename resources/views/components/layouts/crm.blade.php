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
    $canAccess = fn (string $permission): bool => config('crm.demo.enabled') || (auth()->user()?->hasPermission($permission) ?? false);
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
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/bpl_logo_512.png') }}" alt="" class="h-10 w-10 rounded-xl object-contain">
                    <div><p class="text-sm font-bold tracking-tight text-slate-900">BPL Produtos</p><p class="text-xs text-slate-500">CRM comercial</p></div>
                </div>
                <p class="mt-3 text-xs text-slate-500">{{ now()->translatedFormat('d \d\e F \d\e Y') }}</p>
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
        </aside>
        <div id="crm-sidebar-backdrop" class="fixed inset-0 z-30 hidden bg-slate-900/30 lg:hidden" aria-hidden="true"></div>
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-slate-200 bg-white/95 px-4 backdrop-blur sm:px-6">
                <div class="flex items-center gap-3"><button id="crm-menu-toggle" type="button" class="rounded-lg border border-slate-200 p-2 text-slate-600 hover:bg-slate-50 lg:hidden" aria-label="Abrir menu" aria-controls="crm-sidebar" aria-expanded="false">☰</button><div><p class="text-xs font-semibold uppercase tracking-[0.14em] text-brand-600">{{ $eyebrow ?? 'Área de trabalho' }}</p><p class="text-sm font-semibold text-slate-900">{{ $title ?? 'CRM' }}</p></div></div>
                <div class="flex items-center gap-3">
                    <div class="relative" data-crm-user-menu>
                        <button type="button" data-crm-user-menu-toggle class="flex min-w-0 items-center gap-3 rounded-xl bg-slate-50 px-3 py-2 text-left transition hover:bg-brand-50 focus:outline-none focus:ring-2 focus:ring-brand-200" aria-expanded="false" aria-haspopup="menu" aria-controls="crm-user-menu">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-100 text-sm font-bold text-brand-700">{{ str(auth()->user()->name)->substr(0, 1) }}</span>
                        <div class="min-w-0">
                            <p class="max-w-40 truncate text-sm font-semibold text-slate-800 sm:max-w-56">{{ auth()->user()->name }}</p>
                            <p class="hidden max-w-56 truncate text-xs text-slate-500 sm:block">{{ auth()->user()->email }}</p>
                        </div>
                            <svg class="h-4 w-4 shrink-0 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.51a.75.75 0 0 1-1.08 0l-4.25-4.51a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" /></svg>
                        </button>
                        <div id="crm-user-menu" data-crm-user-menu-panel class="absolute right-0 top-[calc(100%+0.5rem)] z-50 hidden w-48 rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg" role="menu" aria-label="Opções da conta">
                            <a href="#" role="menuitem" class="block rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-brand-50 hover:text-brand-700">Perfil</a>
                            <a href="{{ route('password.request') }}" role="menuitem" class="block rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-brand-50 hover:text-brand-700">Alterar Senha</a>
                            <div class="my-1 border-t border-slate-100"></div>
                            <form method="POST" action="{{ route('logout') }}" role="none">
                                @csrf
                                <button type="submit" role="menuitem" class="block w-full rounded-lg px-3 py-2 text-left text-sm font-semibold text-slate-700 transition hover:bg-red-50 hover:text-red-700">Sair</button>
                            </form>
                        </div>
                    </div>
                    <span class="h-2 w-2 shrink-0 rounded-full bg-emerald-500" title="Sistema online"></span>
                </div>
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
