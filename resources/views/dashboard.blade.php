<x-layouts.auth title="Dashboard">
    <h1 class="mb-3 text-xl font-bold text-brand-900">Olá, {{ auth()->user()->name }}</h1>
    <p class="mb-6 text-gray-600">Você está autenticado como {{ auth()->user()->roles()->pluck('label')->join(', ') }}.</p>
    <form method="POST" action="{{ route('logout') }}">@csrf<button class="w-full rounded-lg border border-brand-600 px-4 py-3 font-bold text-brand-700 hover:bg-brand-50">Sair</button></form>
</x-layouts.auth>
