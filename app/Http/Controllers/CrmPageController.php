<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CrmPageController extends Controller
{
    /**
     * @param  array{title: string, eyebrow: string, description: string}  $page
     */
    public function show(string $slug): View
    {
        if ($slug === 'contacts') {
            return view('crm.contacts', [
                'crmApiBase' => url('/api/crm/v1'),
            ]);
        }

        if ($slug === 'companies') {
            return view('crm.companies', [
                'crmApiBase' => url('/api/crm/v1'),
            ]);
        }

        if ($slug === 'pipeline') {
            return view('crm.pipeline', [
                'crmApiBase' => url('/api/crm/v1'),
            ]);
        }

        if ($slug === 'tasks') {
            return view('crm.tasks', [
                'crmApiBase' => url('/api/crm/v1'),
            ]);
        }

        if ($slug === 'calendar') {
            return view('crm.calendar', [
                'crmApiBase' => url('/api/crm/v1'),
            ]);
        }

        if ($slug === 'reports') {
            return view('crm.reports', ['crmApiBase' => url('/api/crm/v1')]);
        }

        if ($slug === 'inbox') {
            return view('crm.inbox', ['crmApiBase' => url('/api/crm/v1')]);
        }

        if (in_array($slug, ['campaigns', 'automations'], true)) {
            return view('crm.resource', [
                'crmApiBase' => url('/api/crm/v1'),
                'resource' => $slug,
            ]);
        }

        $settings = [
            'settings/pipelines' => ['title' => 'Funis e etapas', 'endpoint' => 'pipelines', 'permission' => 'crm.pipelines.manage'],
            'settings/teams' => ['title' => 'Equipes e membros', 'endpoint' => 'teams', 'permission' => 'crm.teams.manage'],
            'settings/tags' => ['title' => 'Tags', 'endpoint' => 'tags', 'permission' => 'crm.tags.manage'],
            'settings/segments' => ['title' => 'Segmentos', 'endpoint' => 'segments', 'permission' => 'crm.segments.manage'],
            'settings/custom-fields' => ['title' => 'Campos personalizados', 'endpoint' => 'custom-fields', 'permission' => 'crm.fields.manage'],
        ];
        if (isset($settings[$slug])) {
            return view('crm.settings', ['crmApiBase' => url('/api/crm/v1'), 'settings' => $settings[$slug]]);
        }

        $pages = [
            'contacts' => [
                'title' => 'Contatos',
                'eyebrow' => 'Relacionamento',
                'description' => 'Centralize pessoas, histórico e próximos contatos da sua operação.',
            ],
            'companies' => [
                'title' => 'Empresas',
                'eyebrow' => 'Relacionamento',
                'description' => 'Organize as empresas atendidas e os contatos associados a cada uma.',
            ],
            'pipeline' => [
                'title' => 'Oportunidades e pipeline',
                'eyebrow' => 'Vendas',
                'description' => 'Acompanhe negócios abertos e mova oportunidades entre as etapas do funil.',
            ],
            'tasks' => [
                'title' => 'Tarefas',
                'eyebrow' => 'Execução',
                'description' => 'Priorize os próximos passos e mantenha a operação em dia.',
            ],
            'calendar' => [
                'title' => 'Agenda',
                'eyebrow' => 'Execução',
                'description' => 'Visualize compromissos e eventos importantes para o relacionamento.',
            ],
            'inbox' => [
                'title' => 'Inbox e conversas',
                'eyebrow' => 'Relacionamento',
                'description' => 'Reúna conversas e mensagens internas em um único lugar.',
            ],
            'campaigns' => [
                'title' => 'Campanhas de e-mail',
                'eyebrow' => 'Comunicação',
                'description' => 'Crie campanhas, acompanhe envios e consulte seus relatórios.',
            ],
            'automations' => [
                'title' => 'Automações',
                'eyebrow' => 'Operação',
                'description' => 'Transforme eventos do CRM em tarefas, movimentações e avisos internos.',
            ],
            'reports' => [
                'title' => 'Relatórios e indicadores',
                'eyebrow' => 'Visão geral',
                'description' => 'Leia os indicadores que ajudam a orientar as próximas decisões.',
            ],
            'settings/pipelines' => [
                'title' => 'Funis e etapas',
                'eyebrow' => 'Configurações do CRM',
                'description' => 'Configure os caminhos que suas oportunidades percorrem.',
            ],
            'settings/teams' => [
                'title' => 'Equipes e membros',
                'eyebrow' => 'Configurações do CRM',
                'description' => 'Organize os times que trabalham no relacionamento comercial.',
            ],
            'settings/tags' => [
                'title' => 'Tags',
                'eyebrow' => 'Configurações do CRM',
                'description' => 'Classifique contatos, empresas e oportunidades com marcadores úteis.',
            ],
            'settings/segments' => [
                'title' => 'Segmentos',
                'eyebrow' => 'Configurações do CRM',
                'description' => 'Crie públicos a partir de filtros declarativos do CRM.',
            ],
            'settings/custom-fields' => [
                'title' => 'Campos personalizados',
                'eyebrow' => 'Configurações do CRM',
                'description' => 'Adapte os registros do CRM às informações específicas da BPL.',
            ],
        ];

        abort_unless(isset($pages[$slug]), 404);

        return view('crm.placeholder', [
            'page' => $pages[$slug],
        ]);
    }
}
