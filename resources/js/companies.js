const companyRoot = document.querySelector('[data-crm-companies]');

if (companyRoot) {
    const state = { page: 1, search: '', lastPage: 1 };
    const base = companyRoot.dataset.apiBase;
    const dialog = companyRoot.querySelector('[data-company-dialog]');
    const form = companyRoot.querySelector('[data-company-form]');
    const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (character) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' })[character]);
    const showState = (name) => companyRoot.querySelectorAll('[data-company-list-state]').forEach((element) => element.classList.toggle('hidden', element.dataset.companyListState !== name));
    const setFeedback = (message, tone = 'success') => { const target = companyRoot.querySelector('[data-company-feedback]'); target.className = `mt-4 rounded-lg p-3 text-sm ${tone === 'error' ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700'}`; target.textContent = message; target.classList.remove('hidden'); };
    const errorMessage = (payload) => Object.values(payload?.errors || {}).flat()[0] || payload?.message || 'Verifique os dados e tente novamente.';
    const load = async () => {
        showState('loading');
        try {
            const query = new URLSearchParams({ per_page: '15', page: String(state.page) });
            if (state.search) query.set('search', state.search);
            const response = await fetch(`${base}/companies?${query}`);
            const payload = await response.json();
            if (!response.ok) throw new Error(errorMessage(payload));
            const companies = payload.data || [];
            companyRoot.querySelector('[data-company-rows]').innerHTML = companies.length ? companies.map((company) => `<tr class="hover:bg-slate-50"><td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-800">${escapeHtml(company.name)}</td><td class="whitespace-nowrap px-5 py-4 text-slate-600">${escapeHtml(company.legal_name || '—')}</td><td class="whitespace-nowrap px-5 py-4 text-slate-600">${escapeHtml(company.email || '—')}</td><td class="whitespace-nowrap px-5 py-4 text-slate-600">${escapeHtml(company.phone || '—')}</td><td class="whitespace-nowrap px-5 py-4 text-right"><button type="button" data-edit-company="${company.id}" class="mr-3 font-semibold text-brand-700 hover:underline">Editar</button><button type="button" data-archive-company="${company.id}" class="font-semibold text-red-700 hover:underline">Arquivar</button></td></tr>`).join('') : '<tr><td colspan="5" class="px-5 py-12 text-center text-slate-500">Nenhuma empresa encontrada. Adicione a primeira empresa para começar.</td></tr>';
            state.lastPage = payload.last_page || 1;
            companyRoot.querySelector('[data-company-summary]').textContent = payload.total ? `Exibindo ${payload.from}–${payload.to} de ${payload.total}` : 'Nenhum resultado';
            companyRoot.querySelector('[data-company-prev]').disabled = state.page <= 1;
            companyRoot.querySelector('[data-company-next]').disabled = state.page >= state.lastPage;
            companyRoot.querySelectorAll('[data-edit-company]').forEach((button) => button.addEventListener('click', () => openEdit(button.dataset.editCompany)));
            companyRoot.querySelectorAll('[data-archive-company]').forEach((button) => button.addEventListener('click', () => archive(button.dataset.archiveCompany)));
            showState('content');
        } catch (error) { companyRoot.querySelector('[data-company-error]').textContent = error.message; showState('error'); }
    };
    companyRoot.querySelector('[data-company-search]').addEventListener('submit', (event) => { event.preventDefault(); state.search = new FormData(event.currentTarget).get('search').trim(); state.page = 1; load(); });
    companyRoot.querySelector('[data-company-retry]').addEventListener('click', load);
    companyRoot.querySelector('[data-company-prev]').addEventListener('click', () => { if (state.page > 1) { state.page -= 1; load(); } });
    companyRoot.querySelector('[data-company-next]').addEventListener('click', () => { if (state.page < state.lastPage) { state.page += 1; load(); } });
    const openCreate = () => { form.reset(); form.dataset.companyId = ''; companyRoot.querySelector('[data-company-form-title]').textContent = 'Adicionar empresa'; companyRoot.querySelector('[data-company-submit]').textContent = 'Salvar empresa'; dialog.showModal(); };
    const openEdit = async (id) => {
        try {
            const response = await fetch(`${base}/companies/${id}`);
            const payload = await response.json();
            if (!response.ok) throw new Error(errorMessage(payload));
            const company = payload.data || payload;
            form.dataset.companyId = company.id;
            form.elements.name.value = company.name || '';
            form.elements.legal_name.value = company.legal_name || '';
            form.elements.email.value = company.email || '';
            form.elements.phone.value = company.phone || '';
            companyRoot.querySelector('[data-company-form-title]').textContent = 'Editar empresa';
            companyRoot.querySelector('[data-company-submit]').textContent = 'Salvar alterações';
            dialog.showModal();
        } catch (error) { setFeedback(error.message, 'error'); }
    };
    const archive = async (id) => {
        if (!window.confirm('Arquivar esta empresa? Ela deixará de aparecer nas listas ativas.')) return;
        try {
            const response = await fetch(`${base}/companies/${id}`, { method: 'DELETE', headers: { Accept: 'application/json' } });
            if (!response.ok) throw new Error(errorMessage(await response.json()));
            setFeedback('Empresa arquivada.');
            await load();
        } catch (error) { setFeedback(error.message, 'error'); }
    };
    companyRoot.querySelector('[data-company-open-form]').addEventListener('click', openCreate);
    companyRoot.querySelectorAll('[data-company-close]').forEach((button) => button.addEventListener('click', () => dialog.close()));
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const submit = form.querySelector('button[type="submit"]');
        submit.disabled = true;
        companyRoot.querySelector('[data-company-form-error]').classList.add('hidden');
        try {
            const companyId = form.dataset.companyId;
            const response = await fetch(`${base}/companies${companyId ? `/${companyId}` : ''}`, { method: companyId ? 'PUT' : 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json' }, body: JSON.stringify(Object.fromEntries(new FormData(form))) });
            const payload = await response.json();
            if (!response.ok) throw new Error(errorMessage(payload));
            form.reset(); dialog.close(); setFeedback(companyId ? 'Empresa atualizada com sucesso.' : 'Empresa criada com sucesso.'); state.page = 1; await load();
        } catch (error) { const target = companyRoot.querySelector('[data-company-form-error]'); target.textContent = error.message; target.classList.remove('hidden'); } finally { submit.disabled = false; }
    });
    load();
}
