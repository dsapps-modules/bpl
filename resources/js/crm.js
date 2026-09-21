const nativeFetch = window.fetch.bind(window);

window.fetch = (input, init = {}) => {
    const method = String(init.method || 'GET').toUpperCase();

    if (!['GET', 'HEAD', 'OPTIONS'].includes(method)) {
        const headers = new Headers(init.headers || {});
        const token = document.querySelector('meta[name="csrf-token"]')?.content;

        if (token) {
            headers.set('X-CSRF-TOKEN', token);
        }

        init = { ...init, headers };
    }

    return nativeFetch(input, init);
};

const state = {
    root: document.querySelector('[data-crm-dashboard]'),
};

const formatDate = (value) => value
    ? new Intl.DateTimeFormat('pt-BR', { dateStyle: 'medium' }).format(new Date(value))
    : 'Sem prazo';

const formatMoney = (amount, currency) => {
    if (amount === null || amount === undefined) return 'Sem valor';

    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: currency || 'BRL' }).format(Number(amount));
};

const unwrap = (payload) => payload?.data ?? payload;

const setView = (view) => {
    state.root.querySelectorAll('[data-crm-state]').forEach((element) => {
        element.classList.toggle('hidden', element.dataset.crmState !== view);
    });
};

const renderMetric = (key, value) => {
    const element = state.root.querySelector(`[data-crm-metric="${key}"]`);
    if (element) element.textContent = value;
};

const renderTasks = (tasks) => {
    const target = state.root.querySelector('[data-crm-tasks]');
    if (!tasks.length) {
        target.innerHTML = '<p class="crm-empty-state">Nenhuma tarefa pendente. Seu próximo contato está em dia.</p>';
        return;
    }

    target.innerHTML = tasks.map((task) => `
        <div class="crm-task-row">
            <span class="crm-task-dot crm-task-dot-${task.priority || 'normal'}" aria-hidden="true"></span>
            <div class="crm-task-copy"><strong>${task.title || 'Tarefa sem título'}</strong><time datetime="${task.due_at || ''}">${formatDate(task.due_at)}</time></div>
        </div>
    `).join('');
};

const renderPipeline = (opportunities) => {
    const target = state.root.querySelector('[data-crm-pipeline]');
    if (!opportunities.length) {
        target.innerHTML = '<p class="crm-empty-state">Nenhuma oportunidade aberta ainda.</p>';
        return;
    }

    const stages = opportunities.reduce((groups, opportunity) => {
        const stage = opportunity.pipeline_stage_id || 'sem-etapa';
        groups[stage] = groups[stage] || [];
        groups[stage].push(opportunity);
        return groups;
    }, {});

    target.innerHTML = `<div class="crm-pipeline-grid">${Object.entries(stages).slice(0, 4).map(([stage, items]) => `
        <div class="crm-stage"><div class="crm-stage-header"><span>Etapa ${stage}</span><b class="crm-stage-count">${items.length}</b></div>
            ${items.slice(0, 3).map((item) => `<div class="crm-opportunity-card"><strong>${item.title || 'Oportunidade sem título'}</strong><small>${formatMoney(item.amount, item.currency)}</small></div>`).join('')}
        </div>
    `).join('')}</div>`;
};

const loadDashboard = async () => {
    setView('loading');
    const base = state.root.dataset.apiBase;

    try {
        const response = await Promise.all([
            fetch(`${base}/reports/summary`),
            fetch(`${base}/tasks?scope=upcoming&per_page=5`),
            fetch(`${base}/opportunities?status=open&per_page=100`),
        ]);

        if (response.some((item) => !item.ok)) throw new Error('A API do CRM retornou um erro.');

        const [summaryResponse, tasksResponse, opportunitiesResponse] = await Promise.all(response.map((item) => item.json()));
        const summary = unwrap(summaryResponse);
        const tasks = unwrap(tasksResponse)?.data ?? unwrap(tasksResponse) ?? [];
        const opportunities = unwrap(opportunitiesResponse)?.data ?? unwrap(opportunitiesResponse) ?? [];

        renderMetric('open_opportunities', summary.open_opportunities ?? 0);
        renderMetric('won_opportunities', summary.won_opportunities ?? 0);
        renderMetric('overdue_tasks', summary.overdue_tasks ?? 0);
        renderMetric('win_rate', summary.win_rate === null || summary.win_rate === undefined ? '—' : `${Math.round(summary.win_rate * 100)}%`);
        state.root.querySelector('[data-crm-metric-note="win_rate"]').textContent = summary.win_rate === null || summary.win_rate === undefined ? 'sem fechamentos ainda' : `${summary.win_rate_denominator} fechamentos`;
        state.root.querySelector('[data-crm-metric-note="overdue_tasks"]').textContent = summary.overdue_tasks ? 'precisam de atenção' : 'operação em dia';
        renderTasks(Array.isArray(tasks) ? tasks : []);
        renderPipeline(Array.isArray(opportunities) ? opportunities : []);
        setView('content');
    } catch (error) {
        state.root.querySelector('[data-crm-error-message]').textContent = error.message;
        setView('error');
    }
};

const setupNavigation = () => {
    const button = document.querySelector('#crm-menu-toggle');
    const sidebar = document.querySelector('#crm-sidebar');
    const backdrop = document.querySelector('#crm-sidebar-backdrop');
    if (!button || !sidebar || !backdrop) return;

    const close = () => {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
        button.setAttribute('aria-expanded', 'false');
    };
    button.addEventListener('click', () => {
        const open = sidebar.classList.toggle('-translate-x-full');
        backdrop.classList.toggle('hidden', open);
        button.setAttribute('aria-expanded', String(!open));
    });
    backdrop.addEventListener('click', close);
};

const setupUserMenu = () => {
    const root = document.querySelector('[data-crm-user-menu]');
    const toggle = root?.querySelector('[data-crm-user-menu-toggle]');
    const panel = root?.querySelector('[data-crm-user-menu-panel]');
    if (!root || !toggle || !panel) return;

    const close = () => {
        panel.classList.add('hidden');
        toggle.setAttribute('aria-expanded', 'false');
    };

    toggle.addEventListener('click', () => {
        const isOpen = !panel.classList.toggle('hidden');
        toggle.setAttribute('aria-expanded', String(isOpen));
    });

    document.addEventListener('click', (event) => {
        if (!root.contains(event.target)) close();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !panel.classList.contains('hidden')) {
            close();
            toggle.focus();
        }
    });
};

setupNavigation();
setupUserMenu();

if (state.root) {
    state.root.querySelector('[data-crm-retry]').addEventListener('click', loadDashboard);
    loadDashboard();
}
