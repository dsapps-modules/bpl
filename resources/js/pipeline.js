const pipelineRoot = document.querySelector('[data-crm-pipeline-page]');

if (pipelineRoot) {
    const state = { pipelines: [], opportunities: [], selectedPipeline: null, draggedOpportunity: null };
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
            return `<section class="crm-board-column" data-drop-stage="${stage.id}" aria-labelledby="pipeline-stage-${stage.id}"><div class="crm-stage-header"><h2 id="pipeline-stage-${stage.id}">${escapeHtml(stage.name)}</h2><b class="crm-stage-count">${items.length}</b></div>${items.length ? items.map((item) => `<article class="crm-opportunity-card" draggable="true" data-drag-opportunity="${item.id}" data-version="${item.version}" aria-label="${escapeHtml(item.title)}. Arraste para mover de etapa."><button type="button" data-edit-opportunity="${item.id}" class="crm-opportunity-edit" aria-label="Editar ${escapeHtml(item.title)}" title="Editar oportunidade"><svg aria-hidden="true" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m13.7 3.2 3.1 3.1M4 16l.7-3.5L13.7 3.5a1.8 1.8 0 0 1 2.6 0l.2.2a1.8 1.8 0 0 1 0 2.6l-9 9L4 16Z"/></svg></button><strong>${escapeHtml(item.title)}</strong><small>${money(item.amount, item.currency)}</small></article>`).join('') : '<p class="crm-empty-state text-xs">Nenhum negócio nesta etapa.</p>'}</section>`;
        }).join('');
        board.querySelectorAll('[data-edit-opportunity]').forEach((button) => button.addEventListener('click', () => openEdit(button.dataset.editOpportunity)));
        board.querySelectorAll('[data-drag-opportunity]').forEach((card) => {
            card.addEventListener('dragstart', (event) => startDragging(card, event));
            card.addEventListener('dragend', () => stopDragging(card));
        });
        board.querySelectorAll('[data-drop-stage]').forEach((column) => {
            column.addEventListener('dragover', (event) => allowDrop(column, event));
            column.addEventListener('dragleave', () => column.classList.remove('crm-board-column-drag-over'));
            column.addEventListener('drop', (event) => dropOpportunity(column, event));
        });
    };
    const startDragging = (card, event) => { state.draggedOpportunity = { id: card.dataset.dragOpportunity, version: card.dataset.version }; card.classList.add('crm-opportunity-card-dragging'); event.dataTransfer.effectAllowed = 'move'; event.dataTransfer.setData('text/plain', card.dataset.dragOpportunity); };
    const stopDragging = (card) => { card.classList.remove('crm-opportunity-card-dragging'); state.draggedOpportunity = null; pipelineRoot.querySelectorAll('[data-drop-stage]').forEach((column) => column.classList.remove('crm-board-column-drag-over')); };
    const allowDrop = (column, event) => { if (!state.draggedOpportunity) return; event.preventDefault(); event.dataTransfer.dropEffect = 'move'; column.classList.add('crm-board-column-drag-over'); };
    const dropOpportunity = async (column, event) => { event.preventDefault(); column.classList.remove('crm-board-column-drag-over'); if (!state.draggedOpportunity) return; const dragged = state.draggedOpportunity; state.draggedOpportunity = null; const opportunity = state.opportunities.find((item) => item.id === Number(dragged.id)); if (!opportunity || opportunity.pipeline_stage_id === Number(column.dataset.dropStage)) return; await moveOpportunity(dragged.id, column.dataset.dropStage, dragged.version); };
    const moveOpportunity = async (opportunityId, stageId, version) => {
        try {
            const response = await fetch(`${base}/opportunities/${opportunityId}/move/${stageId}?version=${version}`, { method: 'POST', headers: { Accept: 'application/json' } });
            const payload = await response.json();
            if (!response.ok) {
                if (response.status === 409) { await loadOpportunities(); feedback('Este negócio foi alterado por outra pessoa. O quadro foi atualizado.', 'error'); return; }
                throw new Error(errorMessage(payload));
            }
            await loadOpportunities();
        } catch (error) { feedback(error.message, 'error'); }
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
