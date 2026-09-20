const pipelineRoot = document.querySelector('[data-crm-pipeline-page]');

if (pipelineRoot) {
    const state = { pipelines: [], opportunities: [], selectedPipeline: null };
    const base = pipelineRoot.dataset.apiBase;
    const dialog = pipelineRoot.querySelector('[data-opportunity-dialog]');
    const form = pipelineRoot.querySelector('[data-opportunity-form]');
    const select = pipelineRoot.querySelector('[data-pipeline-select]');
    const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (character) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' })[character]);
    const money = (amount, currency) => amount === null || amount === undefined ? 'Sem valor' : new Intl.NumberFormat('pt-BR', { style: 'currency', currency: currency || 'BRL' }).format(Number(amount));
    const showState = (name) => pipelineRoot.querySelectorAll('[data-pipeline-state]').forEach((element) => element.classList.toggle('hidden', element.dataset.pipelineState !== name));
    const feedback = (message, tone = 'success') => { const target = pipelineRoot.querySelector('[data-pipeline-feedback]'); target.className = `mt-4 rounded-lg p-3 text-sm ${tone === 'error' ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700'}`; target.textContent = message; target.classList.remove('hidden'); };
    const errorMessage = (payload) => payload?.message || Object.values(payload?.errors || {}).flat()[0] || 'Não foi possível concluir a operação.';
    const render = () => {
        const pipeline = state.pipelines.find((item) => item.id === Number(state.selectedPipeline));
        const board = pipelineRoot.querySelector('[data-pipeline-board]');
        if (!pipeline) { board.innerHTML = '<p class="crm-empty-state">Nenhum funil ativo disponível.</p>'; return; }
        const opportunities = state.opportunities.filter((item) => item.pipeline_id === pipeline.id);
        board.innerHTML = pipeline.stages.map((stage) => {
            const items = opportunities.filter((item) => item.pipeline_stage_id === stage.id);
            return `<section class="crm-board-column" aria-labelledby="pipeline-stage-${stage.id}"><div class="crm-stage-header"><h2 id="pipeline-stage-${stage.id}">${escapeHtml(stage.name)}</h2><b class="crm-stage-count">${items.length}</b></div>${items.length ? items.map((item) => `<article class="crm-opportunity-card"><strong>${escapeHtml(item.title)}</strong><small>${money(item.amount, item.currency)}</small><span class="text-xs text-slate-500">Versão ${item.version}</span><div class="mt-1 flex gap-2"><button type="button" data-edit-opportunity="${item.id}" class="text-left text-xs font-bold text-brand-700 hover:underline">Editar</button><label class="sr-only" for="move-${item.id}">Mover ${escapeHtml(item.title)}</label><select id="move-${item.id}" data-move-opportunity="${item.id}" data-version="${item.version}" class="min-h-9 flex-1 rounded-md border border-slate-200 bg-white px-2 text-xs text-slate-600"><option value="">Mover para...</option>${pipeline.stages.filter((destination) => destination.id !== item.pipeline_stage_id).map((destination) => `<option value="${destination.id}">${escapeHtml(destination.name)}</option>`).join('')}</select></div></article>`).join('') : '<p class="crm-empty-state text-xs">Nenhum negócio nesta etapa.</p>'}</section>`;
        }).join('');
        board.querySelectorAll('[data-move-opportunity]').forEach((control) => control.addEventListener('change', () => move(control)));
        board.querySelectorAll('[data-edit-opportunity]').forEach((button) => button.addEventListener('click', () => openEdit(button.dataset.editOpportunity)));
    };
    const move = async (control) => {
        const opportunityId = control.dataset.moveOpportunity;
        const stageId = control.value;
        if (!stageId) return;
        control.disabled = true;
        try {
            const response = await fetch(`${base}/opportunities/${opportunityId}/move/${stageId}?version=${control.dataset.version}`, { method: 'POST', headers: { Accept: 'application/json' } });
            const payload = await response.json();
            if (!response.ok) {
                if (response.status === 409) {
                    await loadOpportunities();
                    feedback('Este negócio foi alterado por outra pessoa. O quadro foi atualizado.', 'error');
                    throw new Error('__pipeline_conflict__');
                }
                throw new Error(errorMessage(payload));
            }
            feedback('Oportunidade movida com sucesso.');
            await loadOpportunities();
        } catch (error) { if (error.message !== '__pipeline_conflict__') feedback(error.message, 'error'); } finally { control.disabled = false; }
    };
    const loadOpportunities = async () => {
        const response = await fetch(`${base}/opportunities?status=open&per_page=100`);
        const payload = await response.json();
        if (!response.ok) throw new Error(errorMessage(payload));
        state.opportunities = payload.data || [];
        render();
    };
    const loadReferences = async () => {
        const [contactsResponse, companiesResponse] = await Promise.all([fetch(`${base}/contacts?per_page=100`), fetch(`${base}/companies?per_page=100`)]);
        const contacts = await contactsResponse.json();
        const companies = await companiesResponse.json();
        if (!contactsResponse.ok || !companiesResponse.ok) throw new Error(errorMessage(!contactsResponse.ok ? contacts : companies));
        pipelineRoot.querySelector('[name="contact_id"]').innerHTML = '<option value="">Selecione</option>' + (contacts.data || []).map((contact) => `<option value="${contact.id}">${escapeHtml([contact.first_name, contact.last_name].filter(Boolean).join(' '))}</option>`).join('');
        pipelineRoot.querySelector('[name="company_id"]').innerHTML = '<option value="">Nenhuma</option>' + (companies.data || []).map((company) => `<option value="${company.id}">${escapeHtml(company.name)}</option>`).join('');
    };
    const openCreate = async () => {
        form.reset();
        form.dataset.opportunityId = '';
        form.dataset.version = '';
        pipelineRoot.querySelector('[data-opportunity-form-title]').textContent = 'Nova oportunidade';
        pipelineRoot.querySelector('[data-opportunity-submit]').textContent = 'Salvar oportunidade';
        await loadReferences();
        pipelineRoot.querySelector('[name="pipeline_stage_id"]').innerHTML = state.pipelines.find((item) => item.id === Number(state.selectedPipeline)).stages.map((stage) => `<option value="${stage.id}">${escapeHtml(stage.name)}</option>`).join('');
        dialog.showModal();
    };
    const openEdit = async (id) => {
        const opportunity = state.opportunities.find((item) => item.id === Number(id));
        if (!opportunity) return;
        try {
            await loadReferences();
            const pipeline = state.pipelines.find((item) => item.id === opportunity.pipeline_id);
            form.dataset.opportunityId = opportunity.id;
            form.dataset.version = opportunity.version;
            form.elements.title.value = opportunity.title || '';
            form.elements.contact_id.value = opportunity.contact_id || '';
            form.elements.company_id.value = opportunity.company_id || '';
            form.elements.pipeline_stage_id.innerHTML = pipeline.stages.map((stage) => `<option value="${stage.id}">${escapeHtml(stage.name)}</option>`).join('');
            form.elements.pipeline_stage_id.value = opportunity.pipeline_stage_id;
            form.elements.amount.value = opportunity.amount || '';
            form.elements.currency.value = opportunity.currency || 'BRL';
            pipelineRoot.querySelector('[data-opportunity-form-title]').textContent = 'Editar oportunidade';
            pipelineRoot.querySelector('[data-opportunity-submit]').textContent = 'Salvar alterações';
            dialog.showModal();
        } catch (error) { feedback(error.message, 'error'); }
    };
    const saveOpportunity = async (event) => {
        event.preventDefault();
        const submit = form.querySelector('[data-opportunity-submit]');
        submit.disabled = true;
        pipelineRoot.querySelector('[data-opportunity-form-error]').classList.add('hidden');
        try {
            const opportunityId = form.dataset.opportunityId;
            const data = Object.fromEntries(new FormData(form));
            data.pipeline_id = state.selectedPipeline;
            if (form.dataset.version) data.version = form.dataset.version;
            if (!data.amount) delete data.amount;
            const response = await fetch(`${base}/opportunities${opportunityId ? `/${opportunityId}` : ''}`, { method: opportunityId ? 'PUT' : 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json' }, body: JSON.stringify(data) });
            const payload = await response.json();
            if (!response.ok) throw new Error(errorMessage(payload));
            form.reset(); dialog.close(); feedback(opportunityId ? 'Oportunidade atualizada.' : 'Oportunidade criada.'); await loadOpportunities();
        } catch (error) { const target = pipelineRoot.querySelector('[data-opportunity-form-error]'); target.textContent = error.message; target.classList.remove('hidden'); } finally { submit.disabled = false; }
    };
    const load = async () => {
        showState('loading');
        try {
            const response = await fetch(`${base}/pipelines`);
            const payload = await response.json();
            if (!response.ok) throw new Error(errorMessage(payload));
            state.pipelines = payload.data || [];
            select.innerHTML = state.pipelines.length ? state.pipelines.map((pipeline) => `<option value="${pipeline.id}">${escapeHtml(pipeline.name)}</option>`).join('') : '<option value="">Nenhum funil ativo</option>';
            state.selectedPipeline = state.pipelines[0]?.id || null;
            await loadOpportunities();
            showState('content');
        } catch (error) { pipelineRoot.querySelector('[data-pipeline-error]').textContent = error.message; showState('error'); }
    };
    select.addEventListener('change', () => { state.selectedPipeline = select.value; render(); });
    pipelineRoot.querySelector('[data-opportunity-open-form]').addEventListener('click', openCreate);
    pipelineRoot.querySelectorAll('[data-opportunity-close]').forEach((button) => button.addEventListener('click', () => dialog.close()));
    form.addEventListener('submit', saveOpportunity);
    pipelineRoot.querySelector('[data-pipeline-refresh]').addEventListener('click', load);
    pipelineRoot.querySelector('[data-pipeline-retry]').addEventListener('click', load);
    load();
}
