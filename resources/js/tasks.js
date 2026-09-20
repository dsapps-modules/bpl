const taskRoot = document.querySelector('[data-crm-tasks-page]');

if (taskRoot) {
    const state = { scope: 'upcoming', page: 1, lastPage: 1, tasks: [] };
    const base = taskRoot.dataset.apiBase;
    const dialog = taskRoot.querySelector('[data-task-dialog]');
    const form = taskRoot.querySelector('[data-task-form]');
    const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (character) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' })[character]);
    const date = (value) => value ? new Intl.DateTimeFormat('pt-BR', { dateStyle: 'medium', timeStyle: 'short' }).format(new Date(value)) : 'Sem prazo';
    const localDateTime = (value) => value ? new Date(value).toLocaleString('sv-SE').slice(0, 16).replace(' ', 'T') : '';
    const showState = (name) => taskRoot.querySelectorAll('[data-task-state]').forEach((element) => element.classList.toggle('hidden', element.dataset.taskState !== name));
    const feedback = (message, tone = 'success') => { const target = taskRoot.querySelector('[data-task-feedback]'); target.className = `mt-4 rounded-lg p-3 text-sm ${tone === 'error' ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700'}`; target.textContent = message; target.classList.remove('hidden'); };
    const errorMessage = (payload) => Object.values(payload?.errors || {}).flat()[0] || payload?.message || 'Verifique os dados e tente novamente.';
    const resetForm = () => { form.reset(); delete form.dataset.taskId; taskRoot.querySelector('[data-task-form-title]').textContent = 'Adicionar tarefa'; taskRoot.querySelector('[data-task-submit]').textContent = 'Salvar tarefa'; };
    const openCreate = () => { resetForm(); dialog.showModal(); };
    const openEdit = (id) => { const task = state.tasks.find((item) => String(item.id) === String(id)); if (!task) return; form.dataset.taskId = id; form.elements.title.value = task.title || ''; form.elements.due_at.value = localDateTime(task.due_at); form.elements.priority.value = task.priority || 'normal'; form.elements.notes.value = task.notes || ''; taskRoot.querySelector('[data-task-form-title]').textContent = 'Editar tarefa'; taskRoot.querySelector('[data-task-submit]').textContent = 'Salvar alterações'; dialog.showModal(); };
    const load = async () => {
        showState('loading');
        try {
            const query = new URLSearchParams({ per_page: '15', page: String(state.page) });
            if (state.scope !== 'all') query.set('scope', state.scope);
            const response = await fetch(`${base}/tasks?${query}`);
            const payload = await response.json();
            if (!response.ok) throw new Error(errorMessage(payload));
            state.tasks = payload.data || [];
            taskRoot.querySelector('[data-task-rows]').innerHTML = state.tasks.length ? state.tasks.map((task) => `<div class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"><div class="flex min-w-0 items-start gap-3"><span class="crm-task-dot crm-task-dot-${escapeHtml(task.priority || 'normal')} mt-2" aria-hidden="true"></span><div class="min-w-0"><h2 class="truncate font-semibold text-slate-800">${escapeHtml(task.title)}</h2><p class="mt-1 text-sm text-slate-500">${date(task.due_at)} · <span class="capitalize">${escapeHtml(task.priority || 'normal')}</span></p></div></div><div class="flex flex-wrap items-center gap-2">${task.status === 'completed' ? '<span class="text-sm font-semibold text-emerald-700">Concluída</span>' : `<button type="button" data-complete-task="${task.id}" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-bold text-slate-600 hover:border-accent-400 hover:bg-emerald-50 hover:text-accent-600">Concluir</button>`}<button type="button" data-edit-task="${task.id}" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-bold text-slate-600 hover:bg-slate-50">Editar</button><button type="button" data-cancel-task="${task.id}" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-bold text-slate-600 hover:border-red-300 hover:bg-red-50 hover:text-red-700">Cancelar</button></div></div>`).join('') : '<div class="px-5 py-14 text-center text-slate-500">Nenhuma tarefa encontrada para este filtro.</div>';
            taskRoot.querySelector('[data-task-summary]').textContent = payload.total ? `Exibindo ${payload.from}–${payload.to} de ${payload.total}` : 'Nenhum resultado';
            state.lastPage = payload.last_page || 1;
            taskRoot.querySelector('[data-task-prev]').disabled = state.page <= 1;
            taskRoot.querySelector('[data-task-next]').disabled = state.page >= state.lastPage;
            taskRoot.querySelectorAll('[data-complete-task]').forEach((button) => button.addEventListener('click', () => complete(button)));
            taskRoot.querySelectorAll('[data-edit-task]').forEach((button) => button.addEventListener('click', () => openEdit(button.dataset.editTask)));
            taskRoot.querySelectorAll('[data-cancel-task]').forEach((button) => button.addEventListener('click', () => cancelTask(button)));
            showState('content');
        } catch (error) { taskRoot.querySelector('[data-task-error]').textContent = error.message; showState('error'); }
    };
    const complete = async (button) => { button.disabled = true; try { const response = await fetch(`${base}/tasks/${button.dataset.completeTask}/complete`, { method: 'POST', headers: { Accept: 'application/json' } }); const payload = await response.json(); if (!response.ok) throw new Error(errorMessage(payload)); feedback('Tarefa concluída.'); await load(); } catch (error) { feedback(error.message, 'error'); button.disabled = false; } };
    const cancelTask = async (button) => { if (!confirm('Cancelar esta tarefa?')) return; button.disabled = true; try { const response = await fetch(`${base}/tasks/${button.dataset.cancelTask}`, { method: 'DELETE', headers: { Accept: 'application/json' } }); const payload = await response.json(); if (!response.ok) throw new Error(errorMessage(payload)); feedback('Tarefa cancelada.'); await load(); } catch (error) { feedback(error.message, 'error'); button.disabled = false; } };
    taskRoot.querySelectorAll('[data-task-scope]').forEach((button) => button.addEventListener('click', () => { state.scope = button.dataset.taskScope; state.page = 1; taskRoot.querySelectorAll('[data-task-scope]').forEach((item) => item.classList.toggle('crm-filter-button-active', item === button)); load(); }));
    taskRoot.querySelector('[data-task-retry]').addEventListener('click', load);
    taskRoot.querySelector('[data-task-prev]').addEventListener('click', () => { if (state.page > 1) { state.page -= 1; load(); } });
    taskRoot.querySelector('[data-task-next]').addEventListener('click', () => { if (state.page < state.lastPage) { state.page += 1; load(); } });
    taskRoot.querySelector('[data-task-open-form]').addEventListener('click', openCreate);
    taskRoot.querySelectorAll('[data-task-close]').forEach((button) => button.addEventListener('click', () => dialog.close()));
    form.addEventListener('submit', async (event) => { event.preventDefault(); const submit = form.querySelector('[data-task-submit]'); submit.disabled = true; taskRoot.querySelector('[data-task-form-error]').classList.add('hidden'); try { const data = Object.fromEntries(new FormData(form)); if (data.due_at) data.due_at = new Date(data.due_at).toISOString(); data.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone; const id = form.dataset.taskId; const response = await fetch(id ? `${base}/tasks/${id}` : `${base}/tasks`, { method: id ? 'PUT' : 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json' }, body: JSON.stringify(data) }); const payload = await response.json(); if (!response.ok) throw new Error(errorMessage(payload)); resetForm(); dialog.close(); feedback(id ? 'Tarefa atualizada com sucesso.' : 'Tarefa criada com sucesso.'); state.page = 1; await load(); } catch (error) { const target = taskRoot.querySelector('[data-task-form-error]'); target.textContent = error.message; target.classList.remove('hidden'); } finally { submit.disabled = false; } });
    load();
}
