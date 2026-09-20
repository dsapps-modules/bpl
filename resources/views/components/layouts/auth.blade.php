<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Acesso' }} | BPL Produtos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-shell min-h-screen text-gray-800">
    <main class="grid min-h-screen lg:grid-cols-[minmax(0,1.1fr)_minmax(420px,0.9fr)]">
        <aside class="auth-visual relative flex min-h-[250px] overflow-hidden lg:min-h-[280px]">
            <img src="{{ asset('images/auth-cleaning-products.png') }}" alt="Produtos de limpeza organizados em uma bancada" class="absolute inset-0 h-full w-full object-cover">
            <div class="auth-visual-panel absolute inset-0 z-10 flex flex-col justify-between p-6 text-white sm:p-10 xl:p-16">
                <a href="{{ url('/') }}" class="flex items-center gap-3 text-xl font-bold tracking-tight">
                    <img src="{{ asset('images/bpl_logo_512.png') }}" alt="" class="h-12 w-12 rounded-xl bg-white/95 object-contain p-1">
                    <span>BPL Produtos</span>
                </a>
                <div class="max-w-md">
                    <p class="mb-4 text-sm font-medium uppercase tracking-[0.18em] text-blue-100">Área exclusiva</p>
                    <h1 class="text-3xl font-bold leading-tight sm:text-4xl xl:text-5xl">Tudo limpo para sua operação continuar avançando.</h1>
                    <p class="mt-4 max-w-sm text-sm leading-6 text-blue-100 sm:text-base sm:leading-7">Acesse sua conta BPL para acompanhar as soluções e oportunidades da sua equipe.</p>
                </div>
                <p class="text-sm text-blue-100/80">Produtos de limpeza, higiene e descartáveis.</p>
            </div>
        </aside>
        <section class="flex items-center justify-center px-4 py-8 sm:px-8 lg:px-12 xl:px-20">
            <div class="auth-card w-full max-w-md rounded-2xl border border-white bg-white p-6 sm:p-9">
                <div class="mb-8">
                    <p class="mb-2 text-sm font-medium text-brand-600">Acesso seguro</p>
                    <div class="h-px bg-brand-100"></div>
                </div>
            @if (session('status'))
                <div class="mb-4 rounded-lg bg-emerald-50 p-3 text-sm text-emerald-700">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</div>
            @endif
                {{ $slot }}
            </div>
        </section>
    </main>
    @if (app()->isLocal() && session('password_reset_url'))
        <script>
            console.log('Link local para redefinição de senha:', @json(session('password_reset_url')));
        </script>
    @endif
</body>
</html>
