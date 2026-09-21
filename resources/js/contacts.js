const root = document.querySelector('[data-crm-contacts]');

if (root) {
    const state = { page: 1, search: '', lastPage: 1, lookupSequence: 0 };
    const base = root.dataset.apiBase;
    const dialog = root.querySelector('[data-contact-dialog]');
    const form = root.querySelector('[data-contact-form]');
    const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (character) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' })[character]);
    const showState = (name) => root.querySelectorAll('[data-contact-list-state]').forEach((element) => element.classList.toggle('hidden', element.dataset.contactListState !== name));
    const setFeedback = (message, tone = 'success') => { const target = root.querySelector('[data-contact-feedback]'); target.className = `mt-4 rounded-lg p-3 text-sm ${tone === 'error' ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700'}`; target.textContent = message; target.classList.remove('hidden'); };
    const errorMessage = (payload) => Object.values(payload?.errors || {}).flat()[0] || payload?.message || 'Verifique os dados e tente novamente.';
    const digits = (value) => String(value || '').replace(/\D/g, '');
    const formatDocument = (value, type) => {
        const valueDigits = digits(value).slice(0, type === 'cnpj' ? 14 : 11);
        if (type === 'cnpj') return valueDigits.replace(/^(\d{2})(\d)/, '$1.$2').replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3').replace(/\.(\d{3})(\d)/, '.$1/$2').replace(/(\d{4})(\d)/, '$1-$2');
        return valueDigits.replace(/^(\d{3})(\d)/, '$1.$2').replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3').replace(/\.(\d{3})(\d)/, '.$1-$2');
    };
    const formatPostalCode = (value) => digits(value).slice(0, 8).replace(/^(\d{5})(\d)/, '$1-$2');
    const setField = (name, value, overwrite = false) => { if (value !== null && value !== undefined && (overwrite || !form.elements[name].value)) form.elements[name].value = value; };
    const setLookupFeedback = (selector, message = '') => { root.querySelector(selector).textContent = message; };
    const lookup = async (url, feedbackSelector, apply) => {
        const sequence = ++state.lookupSequence;
        setLookupFeedback(feedbackSelector, 'Consultando…');
        try {
            const response = await fetch(url, { headers: { Accept: 'application/json' } });
            const payload = await response.json();
            if (!response.ok) throw new Error(errorMessage(payload));
            if (sequence !== state.lookupSequence) return;
            apply(payload.data || {});
            setLookupFeedback(feedbackSelector, 'Dados preenchidos automaticamente.');
        } catch (error) {
            if (sequence === state.lookupSequence) setLookupFeedback(feedbackSelector, error.message);
        }
    };
    const lookupCnpj = () => {
        const type = form.elements.document_type.value;
        const document = digits(form.elements.document.value);
        if (type !== 'cnpj' || document.length !== 14) return;
        lookup(`${base}/lookups/cnpj/${document}`, '[data-contact-document-feedback]', (company) => {
            setField('first_name', company.name, true);
            setField('email', company.email);
            setField('phone', company.phone);
            setField('postal_code', formatPostalCode(company.postal_code));
            setField('street', company.street);
            setField('number', company.number);
            setField('complement', company.complement);
            setField('district', company.district);
            setField('city', company.city);
            setField('state', company.state);
        });
    };
    const lookupPostalCode = () => {
        const postalCode = digits(form.elements.postal_code.value);
        if (postalCode.length !== 8) return;
        lookup(`${base}/lookups/cep/${postalCode}`, '[data-contact-postal-feedback]', (address) => {
            setField('street', address.street);
            setField('district', address.district);
            setField('city', address.city);
            setField('state', address.state);
            setField('country', address.country, true);
        });
    };
    const load = async () => {
        showState('loading');
        try {
            const query = new URLSearchParams({ per_page: '15', page: String(state.page) });
            if (state.search) query.set('search', state.search);
            const response = await fetch(`${base}/contacts?${query}`);
            const payload = await response.json();
            if (!response.ok) throw new Error(errorMessage(payload));
            const page = payload;
            const contacts = page.data || [];
            root.querySelector('[data-contact-rows]').innerHTML = contacts.length ? contacts.map((contact) => `<tr class="hover:bg-slate-50"><td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-800">${escapeHtml([contact.first_name, contact.last_name].filter(Boolean).join(' '))}</td><td class="whitespace-nowrap px-5 py-4 text-slate-600">${escapeHtml(contact.email || '—')}</td><td class="whitespace-nowrap px-5 py-4 text-slate-600">${escapeHtml(contact.phone || '—')}</td><td class="whitespace-nowrap px-5 py-4 text-slate-600">${escapeHtml(contact.company_id ? `Empresa #${contact.company_id}` : '—')}</td><td class="whitespace-nowrap px-5 py-4 text-right"><button type="button" data-edit-contact="${contact.id}" class="mr-3 font-semibold text-brand-700 hover:underline">Editar</button><button type="button" data-archive-contact="${contact.id}" class="font-semibold text-red-700 hover:underline">Arquivar</button></td></tr>`).join('') : '<tr><td colspan="5" class="px-5 py-12 text-center text-slate-500">Nenhum contato encontrado. Adicione o primeiro contato para começar.</td></tr>';
            state.lastPage = page.last_page || 1;
            root.querySelector('[data-contact-summary]').textContent = page.total ? `Exibindo ${page.from}–${page.to} de ${page.total}` : 'Nenhum resultado';
            root.querySelector('[data-contact-prev]').disabled = state.page <= 1;
            root.querySelector('[data-contact-next]').disabled = state.page >= state.lastPage;
            root.querySelectorAll('[data-edit-contact]').forEach((button) => button.addEventListener('click', () => openEdit(button.dataset.editContact)));
            root.querySelectorAll('[data-archive-contact]').forEach((button) => button.addEventListener('click', () => archive(button.dataset.archiveContact)));
            showState('content');
        } catch (error) { root.querySelector('[data-contact-error]').textContent = error.message; showState('error'); }
    };
    root.querySelector('[data-contact-search]').addEventListener('submit', (event) => { event.preventDefault(); state.search = new FormData(event.currentTarget).get('search').trim(); state.page = 1; load(); });
    root.querySelector('[data-contact-retry]').addEventListener('click', load);
    root.querySelector('[data-contact-prev]').addEventListener('click', () => { if (state.page > 1) { state.page -= 1; load(); } });
    root.querySelector('[data-contact-next]').addEventListener('click', () => { if (state.page < state.lastPage) { state.page += 1; load(); } });
    const openCreate = () => { form.reset(); form.elements.country.value = 'BR'; form.dataset.contactId = ''; setLookupFeedback('[data-contact-document-feedback]'); setLookupFeedback('[data-contact-postal-feedback]'); root.querySelector('[data-contact-form-title]').textContent = 'Adicionar contato'; root.querySelector('[data-contact-submit]').textContent = 'Salvar contato'; dialog.showModal(); };
    const openEdit = async (id) => {
        try {
            const response = await fetch(`${base}/contacts/${id}`);
            const payload = await response.json();
            if (!response.ok) throw new Error(errorMessage(payload));
            const contact = payload.data || payload;
            form.dataset.contactId = contact.id;
            form.elements.first_name.value = contact.first_name || '';
            form.elements.last_name.value = contact.last_name || '';
            form.elements.email.value = contact.email || '';
            form.elements.phone.value = contact.phone || '';
            form.elements.document_type.value = contact.document_type || '';
            form.elements.document.value = formatDocument(contact.document || '', contact.document_type || 'cpf');
            form.elements.postal_code.value = formatPostalCode(contact.postal_code || '');
            form.elements.street.value = contact.street || '';
            form.elements.number.value = contact.number || '';
            form.elements.complement.value = contact.complement || '';
            form.elements.district.value = contact.district || '';
            form.elements.city.value = contact.city || '';
            form.elements.state.value = contact.state || '';
            form.elements.country.value = contact.country || 'BR';
            setLookupFeedback('[data-contact-document-feedback]');
            setLookupFeedback('[data-contact-postal-feedback]');
            root.querySelector('[data-contact-form-title]').textContent = 'Editar contato';
            root.querySelector('[data-contact-submit]').textContent = 'Salvar alterações';
            dialog.showModal();
        } catch (error) { setFeedback(error.message, 'error'); }
    };
    const archive = async (id) => {
        if (!window.confirm('Arquivar este contato? Ele deixará de aparecer nas listas ativas.')) return;
        try {
            const response = await fetch(`${base}/contacts/${id}`, { method: 'DELETE', headers: { Accept: 'application/json' } });
            if (!response.ok) throw new Error(errorMessage(await response.json()));
            setFeedback('Contato arquivado.');
            await load();
        } catch (error) { setFeedback(error.message, 'error'); }
    };
    root.querySelector('[data-contact-open-form]').addEventListener('click', openCreate);
    root.querySelectorAll('[data-contact-close]').forEach((button) => button.addEventListener('click', () => dialog.close()));
    form.elements.document_type.addEventListener('change', () => { form.elements.document.value = formatDocument(form.elements.document.value, form.elements.document_type.value || 'cpf'); lookupCnpj(); });
    form.elements.document.addEventListener('input', () => { const type = form.elements.document_type.value || (digits(form.elements.document.value).length === 14 ? 'cnpj' : 'cpf'); if (!form.elements.document_type.value && type === 'cnpj') form.elements.document_type.value = type; form.elements.document.value = formatDocument(form.elements.document.value, type); lookupCnpj(); });
    form.elements.postal_code.addEventListener('input', () => { form.elements.postal_code.value = formatPostalCode(form.elements.postal_code.value); lookupPostalCode(); });
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const submit = form.querySelector('button[type="submit"]');
        submit.disabled = true;
        root.querySelector('[data-contact-form-error]').classList.add('hidden');
        try {
            const contactId = form.dataset.contactId;
            const response = await fetch(`${base}/contacts${contactId ? `/${contactId}` : ''}`, { method: contactId ? 'PUT' : 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json' }, body: JSON.stringify(Object.fromEntries(new FormData(form))) });
            const payload = await response.json();
            if (!response.ok) throw new Error(errorMessage(payload));
            form.reset(); dialog.close(); setFeedback(contactId ? 'Contato atualizado com sucesso.' : 'Contato criado com sucesso.'); state.page = 1; await load();
        } catch (error) { const target = root.querySelector('[data-contact-form-error]'); target.textContent = error.message; target.classList.remove('hidden'); } finally { submit.disabled = false; }
    });
    load();
}
