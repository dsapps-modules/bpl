---
name: NexLink MVP Design System
description: Sistema visual mobile-first para o dashboard CRM NexLink, baseado nas telas MVP de dashboard, clientes, usuário e perfil.
colors:
  primary: "rgb(89, 85, 209)"
  primary-soft: "rgb(245, 245, 252)"
  navy: "rgb(12, 36, 60)"
  navy-deep: "rgb(41, 41, 75)"
  text-muted: "rgb(105, 105, 129)"
  border: "rgb(238, 238, 243)"
  surface: "rgb(255, 255, 255)"
  canvas: "rgb(250, 250, 252)"
  success: "rgb(0, 153, 102)"
  danger: "rgb(255, 59, 64)"
  warning: "rgb(245, 166, 35)"
  purple: "rgb(112, 0, 224)"
typography:
  body:
    fontFamily: "Instrument Sans, Helvetica, Arial, sans-serif"
    fontSize: "16px"
    fontWeight: 400
    lineHeight: 1.5
  title:
    fontFamily: "Instrument Sans, Helvetica, Arial, sans-serif"
    fontSize: "24px"
    fontWeight: 700
    lineHeight: 1.2
  section-title:
    fontFamily: "Instrument Sans, Helvetica, Arial, sans-serif"
    fontSize: "18px"
    fontWeight: 700
    lineHeight: 1.3
  label:
    fontFamily: "Instrument Sans, Helvetica, Arial, sans-serif"
    fontSize: "14px"
    fontWeight: 500
    lineHeight: 1.4
rounded:
  sm: "6px"
  md: "10px"
  lg: "14px"
  pill: "999px"
spacing:
  xs: "4px"
  sm: "8px"
  md: "16px"
  lg: "24px"
  xl: "32px"
  2xl: "48px"
components:
  button-primary:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.surface}"
    typography: "{typography.label}"
    rounded: "{rounded.sm}"
    padding: "12px 20px"
  button-success:
    backgroundColor: "{colors.success}"
    textColor: "{colors.surface}"
    typography: "{typography.label}"
    rounded: "{rounded.sm}"
    padding: "12px 20px"
  input:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.text-muted}"
    typography: "{typography.body}"
    rounded: "{rounded.sm}"
    height: "52px"
  card:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.navy}"
    rounded: "{rounded.md}"
    padding: "24px"
---

# Design System: NexLink MVP

## Overview

**Creative North Star: "Quiet control room"**

O NexLink é uma interface operacional para CRM: densa o suficiente para permitir leitura e comparação rápidas, mas organizada por superfícies claras, bordas discretas e acentos indigo usados como orientação. As telas anexadas são a autoridade visual do MVP. Novas telas devem parecer parte do mesmo produto, reaproveitando a casca de navegação, o cabeçalho global, os cards, as tabelas e os padrões de formulário já demonstrados.

O visual combina fundo muito claro, superfícies brancas, tipografia Instrument Sans, navy para informação primária e indigo para ação e seleção. A profundidade vem principalmente de separação tonal, bordas finas e sombras quase imperceptíveis; não deve haver decoração que concorra com métricas, listas ou tarefas.

**Key Characteristics:**

- Shell administrativo com sidebar, topbar e área de conteúdo independente.
- Cards brancos, bordas claras, raio moderado e espaçamento consistente.
- Indigo como ação primária e estado ativo; verde, amarelo e vermelho como estados semânticos.
- Mobile-first, com prioridade para leitura, toque, rolagem controlada e redução progressiva da densidade.
- Componentes compostos e reutilizáveis; páginas não devem criar variações visuais isoladas.

**The MVP Authority Rule.** Quando uma decisão nova entrar em conflito com as imagens anexadas, preserve a estrutura, densidade, cores, hierarquia e comportamento percebidos nas telas do MVP.

## Colors

A paleta é fria, limpa e profissional: navy estrutura a informação, indigo orienta ações, e as cores semânticas aparecem em pequenas áreas de alto significado.

### Primary

- **Indigo de ação** (`{colors.primary}`): botões principais, item de navegação ativo, paginação selecionada, gráficos e destaques de interação.
- **Indigo suave** (`{colors.primary-soft}`): fundos de estados selecionados, áreas de apoio e variações sutis de cards.

### Secondary

- **Verde sucesso** (`{colors.success}`): status Active, crescimento positivo, confirmação e ações de salvamento bem-sucedidas.
- **Amarelo atenção** (`{colors.warning}`): status Pending e informação que requer acompanhamento, sem comunicar erro.
- **Vermelho perigo** (`{colors.danger}`): status Inactive, Danger Zone, exclusão e falhas.
- **Roxo de categoria** (`{colors.purple}`): categorias secundárias, como User Management, quando já estabelecidas pela navegação.

### Neutral

- **Navy estrutural** (`{colors.navy}`): títulos, números principais, ícones e texto de alta prioridade.
- **Navy profundo** (`{colors.navy-deep}`): estados ativos escuros e ações de maior contraste, como o botão Regenerate.
- **Cinza de leitura** (`{colors.text-muted}`): corpo, metadados, labels, breadcrumbs e texto secundário.
- **Borda névoa** (`{colors.border}`): divisores, bordas de inputs, linhas de tabela e separação entre regiões.
- **Superfície branca** (`{colors.surface}`): cards, modais, campos e áreas elevadas.
- **Canvas claro** (`{colors.canvas}`): fundo da aplicação quando uma tela precisar de contraste suave com os cards.

**The Accent Rarity Rule.** Indigo e cores semânticas devem orientar decisões; não devem preencher indiscriminadamente fundos, textos longos ou todos os controles da tela.

**The Semantic Color Rule.** Nunca comunique sucesso, erro ou atenção apenas por cor. Combine cor com texto, ícone, valor ou estado explícito.

## Typography

**Display Font:** Instrument Sans (with Helvetica, Arial, sans-serif fallback)

**Body Font:** Instrument Sans (with Helvetica, Arial, sans-serif fallback)

**Character:** A tipografia é direta, legível e levemente compacta, adequada para dashboards com números, tabelas e formulários. Use peso e contraste de cor para criar hierarquia; não use caixa alta decorativa nem fontes adicionais sem aprovação.

### Hierarchy

- **Page title** (700, 24px, line-height 1.2): título principal do conteúdo, como Customer List ou Add New User.
- **Section title** (700, 18px, line-height 1.3): títulos de cards e seções, como Account Settings, Revenue e User Information.
- **Metric** (700, 28–36px, line-height 1.1): números de KPI, sempre acompanhados de label e/ou comparação.
- **Body** (400, 16px, line-height 1.5): conteúdo, nomes, e-mails e descrições.
- **Label** (500, 14px, line-height 1.4): labels de formulário, tabs, filtros, status e metadados.
- **Caption** (400–500, 12–13px, line-height 1.4): ajuda, comparação temporal e informação auxiliar.

**The Type Hierarchy Rule.** Cada página deve ter um único título principal; não pule níveis de heading e não use tamanho grande para compensar uma estrutura de conteúdo fraca.

**The Number Clarity Rule.** Métricas devem ter contraste alto, alinhamento consistente e unidade/período próximos. Percentuais positivos e negativos precisam de texto explícito, além da cor.

## Layout

O layout é um app shell de duas regiões: navegação persistente e conteúdo. Desktop usa sidebar fixa/estável à esquerda, topbar horizontal e conteúdo em grid; mobile começa sem sidebar expandida, com navegação recolhida em drawer ou sheet e topbar reduzida.

### Grid e container

- Comece em uma coluna com `width: 100%` e padding lateral de 16px no mobile.
- Use `max-width` de aproximadamente 1440px para a área de conteúdo em telas grandes, centralizando sem esticar cards indefinidamente.
- Em desktop, mantenha a composição de dashboard em colunas de prioridade: cards menores para KPIs, regiões maiores para gráficos e tabelas, e uma coluna lateral apenas quando o conteúdo realmente justificar.
- Preserve alinhamento de bordas entre cards da mesma linha. Não corrija desalinhamentos com margens negativas.
- Use a escala de spacing do frontmatter: 4/8/16/24/32/48px. Gaps usuais: 8px dentro de controles, 16px entre itens relacionados, 24px entre cards, 32–48px entre regiões.
- A navegação lateral deve reservar espaço próprio; o conteúdo nunca deve ficar escondido sob a sidebar.

### Responsividade mobile-first

- Projete primeiro para 320px, valide em 375px/390px, depois expanda para 768px, 1024px e 1440px.
- Em 320–767px, transforme grids em coluna única, empilhe campos de formulário, mova ações para largura disponível e permita que tabelas usem rolagem horizontal contida.
- Em mobile, o cabeçalho deve manter busca, notificações e perfil acessíveis sem comprimir texto até truncar ações. Oculte elementos secundários ou transfira-os para menus.
- Cards de KPI empilham; gráficos preservam legenda e leitura, mas podem reduzir a densidade e permitir rolagem horizontal apenas no gráfico, nunca na página inteira.
- Tabelas devem manter cabeçalho compreensível e ações acessíveis. Quando não couberem, use `overflow-x: auto` no wrapper da tabela, largura mínima deliberada e indicador de rolagem; não quebre e-mails, números ou ações de maneira ilegível.
- Modais devem ocupar quase toda a largura no mobile, respeitar safe areas, ter rolagem interna e manter ações primárias visíveis. No desktop, use largura moderada e centralização como na tela Add New User.
- Em telas estreitas, ordem de conteúdo vem antes de simetria: título, filtros/ação, conteúdo principal, conteúdo auxiliar.
- Toques e focos precisam de alvos de pelo menos 44px, mesmo quando o ícone visual for menor.

**The Mobile-First Truth Rule.** O layout mobile não é uma versão desktop espremida: é a especificação de prioridade do produto. Tudo que permanecer visível no mobile é essencial; o restante deve colapsar, reordenar ou ser acessado sob demanda.

**The Controlled Overflow Rule.** Rolagem horizontal só é aceitável dentro de componentes intrinsicamente largos, como tabelas e alguns gráficos. Nunca permita overflow horizontal no `body`.

**The Negative Gap Rule.** Não use gaps ou margens negativas para criar sobreposição. Exceções devem ser raras e documentadas no componente, limitadas a elementos claramente sobrepostos — por exemplo, badge/avatar sobre uma imagem — sem alterar o fluxo de leitura ou a área de toque.

## Elevation & Depth

O sistema é predominantemente plano e usa camadas tonais. Cards e painéis usam superfície branca sobre canvas claro, borda de `1px` em `{colors.border}` e sombra ambiente muito discreta quando precisam se separar do fundo. A extração observou sombras próximas de `0 5px 10px rgba(2, 2, 76, 0.02)` em cards e `0 5px 10px rgba(0, 0, 0, 0.05)` em menus; trate isso como profundidade auxiliar, não como efeito decorativo.

### Shadow Vocabulary

- **Card ambient:** `0 5px 10px rgba(2, 2, 76, 0.02)`; use com parcimônia em cards sobre canvas.
- **Menu lift:** `0 5px 10px rgba(0, 0, 0, 0.05)`; reservado para dropdowns, popovers e menus.
- **Modal separation:** sombra moderada derivada do padrão de menu, combinada com overlay; nunca use sombra para substituir o overlay.

**The Quiet Depth Rule.** A superfície, a borda e o espaçamento devem comunicar a maior parte da hierarquia. Se uma sombra é a primeira coisa percebida, ela está forte demais.

## Shapes

Use cantos suavemente arredondados, mas com hierarquia: `6px` para controles e botões, `10px` para cards e campos agrupados, `14px` para painéis maiores e `999px` para pills/badges. Inputs, cards e botões têm silhuetas estáveis; não misture raios arbitrários na mesma região.

Campos devem ter borda clara, fundo branco, altura confortável e padding horizontal de 16px. Badges de status usam fundo semântico suave, texto semântico forte e formato compacto. Avatares são circulares; imagens devem ser recortadas com `object-fit: cover`.

## Components

### Buttons

- **Shape:** cantos discretamente arredondados (`6px`), altura mínima de 44px em qualquer viewport.
- **Primary:** fundo indigo, texto branco, peso 500, padding visual de 12px 20px; use para a ação principal da região.
- **Success:** fundo verde, texto branco; reservado para Save Changes e confirmações equivalentes.
- **Danger:** fundo vermelho, texto branco; ações destrutivas devem sempre usar confirmação e copy explícita.
- **Secondary / Ghost:** superfície branca ou cinza muito claro, texto navy/indigo, borda clara; não competir com o primário.
- **Hover / Focus:** transição curta e discreta, mudança tonal clara e `:focus-visible` com indicador de foco de alto contraste. Nunca remova o outline sem substituição.

### Chips

- **Style:** pills (`999px`) com fundo semântico suave, texto semântico forte e padding compacto (`8px 12px`).
- **State:** Active usa verde, Inactive usa vermelho suave, Pending usa amarelo suave. O texto deve permanecer visível fora do estado de hover.

### Cards / Containers

- **Corner Style:** `10px` para cards padrão; `14px` em painéis maiores quando o agrupamento pedir uma silhueta mais forte.
- **Background:** branco sobre canvas claro, com borda de `{colors.border}`.
- **Shadow Strategy:** usar o vocabulário de Elevation & Depth somente quando a superfície precisar se separar do canvas.
- **Internal Padding:** 24px no desktop; 16px no mobile quando necessário para preservar densidade sem apertar controles.
- **Header:** título à esquerda, ação contextual/ellipsis à direita; não esconda a ação principal em um menu se ela for necessária para completar o fluxo.

### Inputs / Fields

- **Style:** altura base de 52px, borda `1px` clara, fundo branco, raio `6px`, padding horizontal de 16px.
- **Focus:** borda indigo ou anel de foco visível, sem deslocar o layout.
- **Error / Disabled:** erro usa vermelho mais mensagem textual e associação com o campo; disabled reduz contraste e interação, mas continua legível.
- **Forms:** em desktop, campos relacionados podem usar duas colunas; em mobile, uma coluna na mesma ordem semântica. Labels sempre ficam visíveis, como no modal Add New User.

### Navigation

- **Style:** sidebar clara com marca NexLink, ícones lineares, labels Instrument Sans e separadores discretos entre grupos.
- **Active:** indigo no texto/ícone e fundo indigo suave; não depender apenas de peso tipográfico.
- **Desktop:** mantenha a navegação estável e o conteúdo alinhado ao seu início.
- **Mobile:** recolha em drawer/sheet; forneça botão de abertura com label acessível, mantenha o item atual anunciado e feche após navegação quando apropriado.

### Tables

- **Style:** cabeçalho com fundo muito claro, texto 500–700, linhas separadas por borda clara e densidade equivalente à Customer List.
- **Behavior:** checkbox, avatar, nome, dados, status e ações devem manter ordem e alinhamento; ações de linha são agrupadas em alvos de toque separados.
- **Pagination:** use controles claros, página atual em indigo e texto de contagem; em mobile, reduza controles sem remover a informação de página.

### Dialogs

- **Style:** superfície branca, raio `14px`, header separado por divisor, título forte e botão de fechar com label acessível.
- **Behavior:** overlay deve deixar o contexto reconhecível sem permitir interação acidental; foco entra no dialog, fica contido e retorna ao gatilho ao fechar.
- **Actions:** ação destrutiva/irreversível fica visualmente distinta; o botão primário aparece no final do formulário e permanece acessível em mobile.

## Do's and Don'ts

### Do:

- **Do** tratar as quatro imagens anexadas como referência visual primária para o MVP.
- **Do** reutilizar shell, topbar, sidebar, card, table, input, dialog, badge, avatar e pagination antes de criar um componente novo.
- **Do** manter tokens semânticos; componentes devem referenciar `primary`, `surface`, `border`, `text-muted` e estados, não espalhar hex/rgb arbitrário.
- **Do** implementar mobile-first e testar pelo menos em 320px, 768px, 1024px e 1440px.
- **Do** garantir estados de loading com skeleton, vazio, erro, disabled, hover e foco para cada fluxo relevante.
- **Do** usar HTML semântico, labels visíveis, navegação por teclado, `aria-label` em ícones e foco gerenciado em dialogs.
- **Do** preservar contraste mínimo WCAG AA: 4.5:1 para texto normal e 3:1 para texto grande/elementos essenciais.
- **Do** usar conteúdo realista para validar quebra de nomes, e-mails, números, valores e tabelas.

### Don't:

- **Don't** criar uma estética paralela: sem novos gradientes, paletas, fontes, raios ou sombras sem justificativa no Design System.
- **Don't** usar roxo/indigo em tudo; o indigo é um acento de ação e orientação, não o fundo padrão de cada componente.
- **Don't** usar cards e espaçamentos gigantes que reduzam a densidade operacional mostrada nas telas MVP.
- **Don't** remover a sidebar/topbar ou mudar a ordem de navegação em uma tela sem uma razão de produto clara.
- **Don't** depender apenas de cor para status, feedback, erro ou seleção.
- **Don't** permitir overflow horizontal da página, textos cortados sem tooltip/alternativa ou tabelas impossíveis de usar no toque.
- **Don't** usar `div` clicável no lugar de button/link, remover outlines, ou deixar ícones sem nome acessível.
- **Don't** criar margens negativas, valores arbitrários e estilos inline para corrigir desalinhamentos locais; ajuste grid, spacing e componente.
