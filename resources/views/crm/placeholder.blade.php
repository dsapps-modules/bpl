<x-layouts.crm :title="$page['title']" :eyebrow="$page['eyebrow']">
    <section class="mx-auto flex min-h-[calc(100vh-4rem)] max-w-5xl items-center px-4 py-10 sm:px-6 lg:px-8">
        <div class="w-full rounded-2xl border border-slate-200 bg-white p-8 shadow-[0_5px_10px_rgba(2,2,76,0.02)] sm:p-12">
            <span class="inline-flex rounded-full bg-brand-50 px-3 py-1 text-xs font-bold uppercase tracking-[0.14em] text-brand-700">Próxima etapa</span>
            <h1 class="mt-5 max-w-2xl text-3xl font-bold tracking-tight text-slate-900">{{ $page['title'] }}</h1>
            <p class="mt-4 max-w-2xl text-base leading-7 text-slate-600">{{ $page['description'] }}</p>
            <div class="mt-8 flex items-center gap-3 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-600" role="status"><span class="text-lg text-brand-600" aria-hidden="true">◌</span><span>Esta superfície já está protegida e conectada ao menu. A próxima fatia implementará seus dados e ações do CRM.</span></div>
        </div>
    </section>
</x-layouts.crm>
