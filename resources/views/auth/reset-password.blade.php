<x-layouts.auth title="Nova senha">
    <h1 class="mb-3 text-xl font-bold text-brand-900">Criar nova senha</h1>
    <p class="mb-6 text-sm text-gray-600">Use uma senha com pelo menos 8 caracteres.</p>
    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div><label for="email" class="mb-1 block text-sm font-medium">E-mail</label><input id="email" name="email" type="email" value="{{ old('email', $email) }}" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 focus:border-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-100"></div>
        <div><label for="password" class="mb-1 block text-sm font-medium">Nova senha</label><input id="password" name="password" type="password" required minlength="8" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 focus:border-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-100"></div>
        <div><label for="password_confirmation" class="mb-1 block text-sm font-medium">Confirme a nova senha</label><input id="password_confirmation" name="password_confirmation" type="password" required minlength="8" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 focus:border-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-100"></div>
        <button class="w-full rounded-lg bg-brand-600 px-4 py-3 font-bold text-white hover:bg-brand-700">Salvar senha</button>
    </form>
</x-layouts.auth>
