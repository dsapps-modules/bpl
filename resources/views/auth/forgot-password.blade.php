<x-layouts.auth title="Esqueci minha senha">
    <h1 class="mb-3 text-xl font-bold text-brand-900">Redefinir senha</h1>
    <p class="mb-6 text-sm text-gray-600">Informe seu e-mail e enviaremos um link para criar sua senha.</p>
    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        <div><label for="email" class="mb-1 block text-sm font-medium">E-mail</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 focus:border-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-100"></div>
        <button class="w-full rounded-lg bg-brand-600 px-4 py-3 font-bold text-white hover:bg-brand-700">Enviar link de recuperação</button>
    </form>
    <a href="{{ route('login') }}" class="mt-5 block text-center text-sm text-brand-700 hover:underline">Voltar para o login</a>
</x-layouts.auth>
