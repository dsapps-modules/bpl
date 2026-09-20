# Tarefas: páginas do CRM da BPL

## Fase 1 — Fundação

- [x] 1. Definir contrato de rotas, menu e permissões CRM.
- [x] 2. Criar shell autenticado, sidebar, cabeçalho e navegação responsiva.
- [ ] 3. Consolidar cliente frontend único para a API CRM.
- [x] 4. Integrar o dashboard em Blade/Tailwind com estados de carregamento, erro e vazio.

## Checkpoint: Fundação

- [ ] Navegação autenticada funciona em desktop e mobile.
- [ ] Itens sem permissão não são exibidos e rotas protegidas retornam acesso negado.
- [ ] Dashboard carrega resumo, tarefas e oportunidades sem erro de build/console.

## Fase 2 — Dados mestres e vendas

- [x] 5. Implementar páginas de Contatos.
- [x] 6. Implementar páginas de Empresas.
- [x] 7. Implementar Pipeline e movimentação de oportunidades com conflito `409`.

## Checkpoint: Vendas

- [ ] Criar contato/empresa e oportunidade pelo navegador.
- [ ] Mover oportunidade entre etapas e tratar versão desatualizada.
- [ ] Validar busca, paginação, validação e autorização.

## Fase 3 — Execução diária

- [x] 8. Implementar Tarefas.
- [x] 9. Implementar Agenda.
- [x] 10. Implementar Inbox/Conversas.

## Checkpoint: Operação

- [ ] Tarefa criada aparece no dashboard/agenda.
- [ ] Eventos UTC/timezone e dia inteiro são exibidos corretamente.
- [ ] Inbox representa corretamente provider desconectado ou fake.

## Fase 4 — Comunicação e automação

- [x] 11. Implementar Campanhas de e-mail.
- [x] 12. Implementar Automações suportadas pelo pacote.
- [x] 13. Implementar Relatórios/Indicadores.

## Checkpoint: Inteligência operacional

- [ ] Envio de campanha exige confirmação e respeita credenciais/configuração.
- [ ] Automações não oferecem ações além das suportadas.
- [ ] Indicadores tratam `win_rate = null` e erros da API.

## Fase 5 — Configurações do CRM

- [x] 14. Implementar Funis e etapas.
- [x] 15. Implementar Equipes e membros.
- [x] 16. Implementar Tags.
- [x] 17. Implementar Segmentos.
- [x] 18. Implementar Campos personalizados.

## Checkpoint: Configurações

- [ ] Cada página é protegida por sua permissão específica.
- [ ] Filtros de segmentos são tratados como JSON declarativo, sem execução.
- [ ] Campos personalizados respeitam entidades e tipos permitidos.

## Fase 6 — Qualidade

- [x] 19. Adicionar testes dos fluxos e permissões.
- [ ] 20. Fazer revisão visual, acessibilidade e responsividade.
- [x] 21. Rodar testes focados, build, Pint e revisão final.

## Checkpoint: Entrega

- [ ] Nenhum webhook/API técnico aparece no menu.
- [ ] Todas as páginas têm estados loading, vazio, erro e acesso negado adequados.
- [ ] Critérios de pronto de `tasks/plan.md` atendidos.
