# Plano de implementação: páginas do CRM da BPL

## Visão geral

Criar a camada de páginas e navegação da aplicação consumidora do pacote `dsapps/laravel-crm`. O pacote já fornece o núcleo PHP, a API autenticada em `/api/crm/v1` e um componente React de dashboard; ele não publica páginas Blade nem um menu pronto. A aplicação BPL será responsável pelo shell autenticado, pelas rotas web, pelas páginas de operação e configuração, pela integração do cliente React/TypeScript com a API e pelo controle visual de permissões.

## Requisitos extraídos da imagem

Estas observações da imagem são requisitos de produto para o menu e o escopo das páginas:

- Menu principal: Dashboard/Visão geral, Contatos, Empresas, Oportunidades/Pipeline, Tarefas, Agenda, Inbox/Conversas, Campanhas de e-mail, Automações e Relatórios/Indicadores.
- Área separada de Configurações do CRM: Funis e etapas, Equipes e membros, Tags, Segmentos e Campos personalizados.
- Webhooks de WhatsApp e Brevo e endpoints de API não devem aparecer no menu; são integrações de backend.
- O dashboard deve consumir o componente React/documentação do pacote quando isso for compatível com o stack atual.

O texto da imagem é contexto fornecido pelo usuário, não instrução para alterar o pacote vendor nem para expor endpoints internos no menu.

## Estado atual e decisões de arquitetura

- Laravel 12.69.2, PHPUnit 11.5.56, Vite 6 e Tailwind CSS 4 estão instalados.
- O pacote CRM está instalado como `dsapps/laravel-crm` em `dev-main`; suas rotas API são registradas pelo `bootstrap/app.php` e protegidas por `auth` mais permissões específicas.
- A aplicação possui autenticação Blade, `EnsurePermission`, papéis/permissões e um dashboard provisório. O shell atual de autenticação deve evoluir para um shell do CRM sem quebrar login, logout e recuperação de senha.
- A primeira implementação deve manter páginas web finas: controllers retornam views, o cliente React chama a API do pacote e regras de negócio permanecem no pacote/API. Não duplicar consultas do CRM em controllers ou Blade.
- A UI principal será Blade + Tailwind CSS 4 + JavaScript leve, consumindo diretamente a API do pacote. O componente React (`@dsapps/crm-react`) é opcional: ele pode ser usado por aplicações que já adotam React, mas não será uma dependência desta aplicação nem será importado de `vendor`.
- As páginas devem seguir `DESIGN.md` e reaproveitar componentes/layouts existentes. Rotas devem ser nomeadas e agrupadas por autenticação e permissão.

## Mapa de páginas, API e permissão

| Área | Página inicial | API principal | Permissão do pacote |
|---|---|---|---|
| Dashboard | Visão geral | `GET reports/summary`, `GET tasks`, `GET opportunities` | `crm.reports.view` + leitura dos dados exibidos |
| Contatos | Lista, busca, criar/editar, arquivar | `contacts` | `crm.contacts.manage` |
| Empresas | Lista, busca, criar/editar, arquivar | `companies` | `crm.companies.manage` |
| Pipeline | Quadro por funil/etapa, criar/editar e mover oportunidade | `pipelines`, `opportunities`, `opportunities/{id}/move/{stage}` | `crm.pipelines.manage`, `crm.opportunities.manage` |
| Tarefas | Lista por estado/prazo, criar/editar/concluir | `tasks`, `tasks/{id}/complete` | `crm.tasks.manage` |
| Agenda | Calendário/lista, criar/editar/remover evento | `calendar-events` | `crm.calendar.manage` |
| Inbox | Conversas, mensagens e notas internas | `conversations`, `conversations/{id}/messages` | `crm.inbox.manage` |
| Campanhas | Lista, detalhe, envio e relatório | `email-campaigns`, `send`, `report` | `crm.email_marketing.manage` |
| Automações | Lista, detalhe e criação | `automations` | `crm.automations.manage` |
| Relatórios | Indicadores e resumo | `reports/summary` | `crm.reports.view` |
| Configurações | Funis/etapas | `pipelines` | `crm.pipelines.manage` |
| Configurações | Equipes/membros | `teams`, `teams/{id}/members` | `crm.teams.manage` |
| Configurações | Tags | `tags`, `tags/{id}/attach` | `crm.tags.manage` |
| Configurações | Segmentos | `segments` | `crm.segments.manage` |
| Configurações | Campos personalizados | `custom-fields`, `custom-fields/{id}/value` | `crm.fields.manage` |

Observação: a visibilidade final do Dashboard pode exigir mais de uma permissão, porque o componente também carrega tarefas e oportunidades. O critério deve ser definido pela menor permissão necessária para cada bloco, sem liberar dados apenas porque o usuário consegue abrir a rota.

## Ordem de implementação

### Fase 1 — fundação navegável

1. Definir contrato de navegação, nomes de rotas, mapa de permissões e itens visíveis por papel.
2. Criar o shell autenticado do CRM: sidebar/menu principal, grupo Configurações, cabeçalho, estado ativo, responsividade e logout.
3. Criar uma camada única de cliente CRM no frontend para base URL, autenticação/CSRF quando aplicável, erros, paginação e normalização das respostas.
4. Substituir o dashboard provisório pelo dashboard React do pacote, com carregamento, erro, vazio, atualização e links para Tarefas/Pipeline.

**Checkpoint:** usuário autenticado consegue navegar pelo shell, permissões ocultam/bloqueiam itens corretamente e o dashboard carrega sem chamadas duplicadas nem erros no console.

### Fase 2 — dados mestres e vendas

5. Entregar Contatos: listagem com busca/paginação, formulário de criação/edição, arquivamento e vínculo opcional com empresa.
6. Entregar Empresas com os mesmos estados e padrões de formulário da página de Contatos.
7. Entregar Pipeline: seleção de funil, colunas de etapas, cards de oportunidade, criação/edição e movimentação com `version` e tratamento explícito de `409`.

**Checkpoint:** criar um contato/empresa, criar uma oportunidade e movê-la no funil pelo navegador, com respostas de validação e autorização apresentadas de forma compreensível.

### Fase 3 — execução diária

8. Entregar Tarefas com filtros `today`, `overdue` e `upcoming`, criação/edição/exclusão lógica conforme API e conclusão.
9. Entregar Agenda com visualização lista/calendário, timezone de apresentação e suporte a eventos de dia inteiro.
10. Entregar Inbox/Conversas com lista, detalhe, envio de mensagens/notas internas e estados desconectado/bloqueado quando não houver adapter externo configurado.

**Checkpoint:** a ação criada em Tarefas aparece no dashboard/agenda e a Inbox não promete envio externo quando o pacote estiver usando fake ou sem provedor configurado.

### Fase 4 — comunicação e automação

11. Entregar Campanhas de e-mail: listagem, detalhe, criação, confirmação antes de enviar e relatório; refletir claramente a dependência de credenciais Brevo.
12. Entregar Automações apenas para as ações suportadas pelo pacote (`create_task`, `move_stage`, `notify_internal`), mostrando estado e idempotência sem inventar ações.
13. Consolidar Relatórios/Indicadores, reutilizando o resumo do pacote e deixando nulos/ausência de denominador explícitos na UI.

**Checkpoint:** campanhas, automações e indicadores respeitam permissões, exibem falhas da API e não expõem credenciais, webhooks ou endpoints técnicos.

### Fase 5 — configurações do CRM

14. Entregar Funis e etapas, incluindo validação para não mover oportunidade entre funis incompatíveis.
15. Entregar Equipes e membros usando IDs de usuários do hospedeiro, com autorização adequada.
16. Entregar Tags e associação a entidades.
17. Entregar Segmentos com filtros declarativos tratados como dados, sem executar conteúdo vindo da UI.
18. Entregar Campos personalizados e edição de valores por entidade/tipo permitido.

**Checkpoint:** cada item de Configurações aparece apenas para quem tem a permissão correspondente e todas as alterações têm feedback de sucesso, validação e erro.

### Fase 6 — qualidade e acabamento

19. Cobrir rotas/políticas de permissão, cliente API, formulários, estados de erro e fluxos principais com testes PHPUnit/JS conforme a infraestrutura adotada.
20. Validar responsividade, acessibilidade, navegação por teclado, estados vazios/loading e aderência ao `DESIGN.md`.
21. Rodar build, testes focados, Pint para PHP alterado e uma revisão final de rotas/permissões; só então considerar publicação.

## Riscos e mitigação

| Risco | Impacto | Mitigação |
|---|---|---|
| Pacote React não estar publicado/instalável pelo Vite da aplicação | Alto | Confirmar export/build do pacote antes do dashboard; encapsular a integração em um ponto único e definir fallback controlado. |
| API exige permissões que o seed atual ainda não cadastra | Alto | Criar catálogo de permissões CRM no seeder de forma idempotente antes das páginas; testar cada papel. |
| Mistura de Blade e React gerar dois estados de navegação | Médio | Shell e rotas ficam no host; React fica restrito às superfícies interativas que precisam dele, com contratos explícitos. |
| `409` ao mover oportunidades ser tratado como erro genérico | Médio | Implementar estado de conflito que recarrega a oportunidade/funil e informa que os dados foram atualizados. |
| Integrações externas não configuradas | Médio | Mostrar estados desconectado/bloqueado e manter webhooks fora do menu, conforme o pacote documenta. |
| Alterações no vendor ou dependências sem aprovação | Alto | Não editar `vendor`; não adicionar dependências sem validar a necessidade e obter aprovação. |

## Critérios de pronto do conjunto

- Todas as páginas listadas têm rota nomeada, item de menu condicionado à permissão e estado de acesso negado.
- Nenhum webhook ou endpoint de API aparece na navegação principal.
- Listas têm busca/paginação quando o endpoint suporta; formulários exibem validação do servidor.
- O dashboard utiliza os dados reais do pacote e trata loading, vazio, erro e ausência de denominador.
- Testes focados passam, o build frontend passa e PHP alterado está formatado com Pint.
- A UI é responsiva e mantém o padrão visual documentado em `DESIGN.md`.

## Questões para validar antes da implementação

- Confirmar se o shell de CRM deve substituir definitivamente o layout atual de `resources/views/components/layouts/auth.blade.php` ou se haverá dois layouts autenticados.
- Confirmar se todas as páginas serão Blade com ilhas React ou se a área CRM será uma SPA React dentro de uma rota Blade.
- Definir a política de visibilidade do Dashboard para usuários que têm relatório, mas não têm todas as permissões de tarefas/oportunidades.
- Definir se “excluir” na UI deve ser chamado de arquivar em todos os módulos, refletindo a semântica do pacote.
