<x-layouts.auth title="Login">
    <h1 class="mb-6 text-xl font-bold text-brand-900">Entrar</h1>
    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
        @csrf
        <div><label for="email" class="mb-1 block text-sm font-medium">E-mail</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 focus:border-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-100"></div>
        <div><label for="password" class="mb-1 block text-sm font-medium">Senha</label><input id="password" name="password" type="password" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 focus:border-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-100"></div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember" value="1"> Lembrar de mim</label>
        <button class="w-full rounded-lg bg-brand-600 px-4 py-3 font-bold text-white hover:bg-brand-700">Entrar</button>
    </form>
    <a href="{{ route('password.request') }}" class="mt-5 block text-center text-sm text-brand-700 hover:underline">Esqueci minha senha</a>
</x-layouts.auth>
