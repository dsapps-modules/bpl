<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="BPL Produtos: soluções de higiene, limpeza e abastecimento para empresas e condomínios.">
        <title>BPL Produtos — Abastecimento que acompanha o seu ritmo</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|space-grotesk:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-ink text-paper antialiased selection:bg-signal selection:text-ink">
        <a class="skip-link" href="#conteudo">Pular para o conteúdo</a>
        <header class="site-header" data-header>
            <div class="mx-auto flex max-w-[1440px] items-center justify-between px-6 py-5 lg:px-10">
                <a class="brand-mark" href="#top" aria-label="BPL Produtos, início">
                    <span class="brand-mark__symbol" aria-hidden="true"><svg viewBox="0 0 34 34" fill="none"><path d="M3 29V14.5L17 5l14 9.5V29M8 29V18h18v11M13 29v-6h8v6" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M2 29h30" stroke="currentColor" stroke-width="2"/></svg></span>
                    <span><strong>BPL</strong><small>produtos &amp; higiene</small></span>
                </a>
                <nav class="hidden items-center gap-8 lg:flex" aria-label="Navegação principal">
                    <a class="nav-link" href="#solucoes">Soluções</a><a class="nav-link" href="#ritmo">Como funciona</a><a class="nav-link" href="#contato">Atendimento</a><a class="button button--small button--light" href="#contato">Falar com a BPL <span aria-hidden="true">↗</span></a>
                </nav>
                <button class="menu-toggle lg:hidden" type="button" aria-expanded="false" aria-controls="mobile-menu" data-menu-toggle><span class="sr-only">Abrir menu</span><span></span><span></span></button>
            </div>
            <nav id="mobile-menu" class="mobile-menu" aria-label="Navegação móvel" data-mobile-menu hidden>
                <a href="#solucoes">Soluções</a><a href="#ritmo">Como funciona</a><a href="#contato">Atendimento</a><a class="button button--light" href="#contato">Falar com a BPL <span aria-hidden="true">↗</span></a>
            </nav>
        </header>

        <main id="conteudo">
            <section id="top" class="hero-section">
                <div class="hero-noise" aria-hidden="true"></div>
                <div class="mx-auto grid max-w-[1440px] gap-14 px-6 pb-20 pt-16 lg:grid-cols-[1.05fr_.95fr] lg:items-end lg:px-10 lg:pb-28 lg:pt-24">
                    <div class="relative z-10 max-w-3xl" data-reveal>
                        <p class="eyebrow eyebrow--blue">BPL / CENTRAL DE ABASTECIMENTO</p>
                        <h1 class="display mt-6 max-w-4xl">Higiene em ordem. <em>Rotina sem ruído.</em></h1>
                        <p class="hero-copy mt-7 max-w-xl">Soluções essenciais para manter empresas e condomínios funcionando bem — da limpeza diária ao cuidado que as pessoas percebem.</p>
                        <div class="mt-9 flex flex-col gap-3 sm:flex-row"><a class="button button--signal" href="#solucoes">Explorar soluções <span aria-hidden="true">↓</span></a><a class="button button--outline" href="#contato">Montar meu abastecimento <span aria-hidden="true">↗</span></a></div>
                    </div>
                    <div class="supply-board" data-reveal data-reveal-delay="120" aria-label="Painel de soluções BPL">
                        <div class="supply-board__topline"><span>PAINEL 001</span><span class="status-dot">● ONLINE</span></div>
                        <div class="supply-board__title">O essencial,<br><strong>bem resolvido.</strong></div>
                        <div class="supply-board__diagram" aria-hidden="true"><div class="diagram-ring diagram-ring--one"></div><div class="diagram-ring diagram-ring--two"></div><div class="diagram-node diagram-node--center"><span>BPL</span><small>FLOW</small></div><span class="diagram-label diagram-label--top">LIMPEZA</span><span class="diagram-label diagram-label--right">PAPÉIS</span><span class="diagram-label diagram-label--bottom">CUIDADO</span><span class="diagram-label diagram-label--left">APOIO</span></div>
                        <div class="supply-board__footer"><span>ATENDIMENTO COMERCIAL</span><span>01 — 04</span></div>
                    </div>
                </div>
                <div class="hero-rail" aria-hidden="true"><span>FORNECIMENTO INTELIGENTE</span><span>EMPRESAS / CONDOMÍNIOS / OPERAÇÕES</span><span>SCROLL PARA DESCOBRIR ↓</span></div>
            </section>

            <section id="solucoes" class="paper-section">
                <div class="mx-auto max-w-[1440px] px-6 py-24 lg:px-10 lg:py-32">
                    <div class="section-heading" data-reveal><div><p class="eyebrow eyebrow--orange">ROTAS DE COMPRA</p><h2 class="section-title mt-4">Tudo para a rotina<br><span>seguir fluindo.</span></h2></div><p class="section-intro">Escolha uma frente, encontre o que resolve o seu dia e conte com uma equipe que entende o ritmo da operação.</p></div>
                    <div class="category-toolbar mt-14" role="toolbar" aria-label="Filtrar soluções"><button class="filter-chip is-active" type="button" data-filter="all">Tudo <span>06</span></button><button class="filter-chip" type="button" data-filter="ambiente">Ambientes</button><button class="filter-chip" type="button" data-filter="operacao">Operação</button><button class="filter-chip" type="button" data-filter="cuidado">Cuidado</button></div>
                    <div class="product-grid mt-8" data-product-grid>
                        <article class="product-card product-card--wide" data-category="operacao" data-reveal><div class="product-card__copy"><span class="product-index">01 / 06</span><h3>Limpeza profissional</h3><p>Concentrados e soluções para a manutenção diária de áreas que não podem parar.</p><a href="#contato" class="text-link">Encontrar a solução <span aria-hidden="true">↗</span></a></div><div class="product-visual product-visual--blue" aria-hidden="true"><span class="visual-bottle visual-bottle--tall"></span><span class="visual-bottle visual-bottle--short"></span><span class="visual-sticker">USO<br>DIÁRIO</span></div></article>
                        <article class="product-card" data-category="cuidado" data-reveal data-reveal-delay="80"><div class="product-card__copy"><span class="product-index">02 / 06</span><h3>Higiene das mãos</h3><p>Gel, sabonetes e dispensers para áreas de alto fluxo.</p><a href="#contato" class="text-link">Ver opções <span aria-hidden="true">↗</span></a></div><div class="product-visual product-visual--orange" aria-hidden="true"><span class="visual-bottle visual-bottle--pump"></span><span class="visual-spark">✦</span></div></article>
                        <article class="product-card" data-category="ambiente" data-reveal data-reveal-delay="160"><div class="product-card__copy"><span class="product-index">03 / 06</span><h3>Ambientes cuidados</h3><p>Produtos para perfumar, proteger e deixar cada espaço pronto.</p><a href="#contato" class="text-link">Ver opções <span aria-hidden="true">↗</span></a></div><div class="product-visual product-visual--mint" aria-hidden="true"><span class="visual-orb"></span><span class="visual-leaf">⌁</span></div></article>
                        <article class="product-card product-card--tall" data-category="cuidado" data-reveal><div class="product-card__copy"><span class="product-index">04 / 06</span><h3>Papéis &amp; descartáveis</h3><p>Abastecimento recorrente para banheiros, cozinhas e áreas comuns.</p><a href="#contato" class="text-link">Encontrar a solução <span aria-hidden="true">↗</span></a></div><div class="product-visual product-visual--lilac" aria-hidden="true"><span class="visual-roll"></span><span class="visual-roll visual-roll--back"></span></div></article>
                        <article class="product-card product-card--wide" data-category="operacao" data-reveal data-reveal-delay="80"><div class="product-card__copy"><span class="product-index">05 / 06</span><h3>Equipamentos &amp; apoio</h3><p>Itens que organizam o trabalho e dão consistência para a equipe.</p><a href="#contato" class="text-link">Ver opções <span aria-hidden="true">↗</span></a></div><div class="product-visual product-visual--yellow" aria-hidden="true"><span class="visual-grid"></span><span class="visual-tool">+</span></div></article>
                        <article class="product-card" data-category="ambiente" data-reveal data-reveal-delay="160"><div class="product-card__copy"><span class="product-index">06 / 06</span><h3>Kits sob medida</h3><p>Uma seleção pensada para o tamanho e o ritmo da sua operação.</p><a href="#contato" class="text-link">Montar um kit <span aria-hidden="true">↗</span></a></div><div class="product-visual product-visual--coral" aria-hidden="true"><span class="visual-box"></span><span class="visual-box visual-box--small"></span></div></article>
                    </div><p class="filter-empty" data-filter-empty hidden>Nenhuma solução nesta rota. Experimente outra categoria.</p>
                </div>
            </section>

            <section id="ritmo" class="rhythm-section"><div class="mx-auto grid max-w-[1440px] gap-14 px-6 py-24 lg:grid-cols-[.8fr_1.2fr] lg:items-start lg:px-10 lg:py-32"><div data-reveal><p class="eyebrow eyebrow--blue">DO PEDIDO AO PRÓXIMO DIA</p><h2 class="section-title section-title--light mt-4">Menos tempo<br>procurando.<br><span>Mais tempo<br>fazendo.</span></h2></div><div class="process-list" data-reveal data-reveal-delay="120"><div class="process-row"><span class="process-number">01</span><div><h3>Você conta o cenário</h3><p>Empresa, condomínio, área comum ou operação: começamos pela sua rotina real.</p></div><span class="process-arrow" aria-hidden="true">↗</span></div><div class="process-row"><span class="process-number">02</span><div><h3>A gente organiza as opções</h3><p>Indicamos categorias e combinações que fazem sentido para a sua necessidade.</p></div><span class="process-arrow" aria-hidden="true">↗</span></div><div class="process-row"><span class="process-number">03</span><div><h3>Seu abastecimento ganha ritmo</h3><p>Uma conversa objetiva para transformar escolha em rotina bem cuidada.</p></div><span class="process-arrow" aria-hidden="true">↗</span></div></div></div></section>

            <section id="contato" class="contact-section"><div class="mx-auto grid max-w-[1440px] gap-14 px-6 py-24 lg:grid-cols-[1fr_.9fr] lg:items-end lg:px-10 lg:py-32"><div data-reveal><p class="eyebrow eyebrow--orange">VAMOS RESOLVER JUNTOS</p><h2 class="section-title mt-4">A próxima rotina<br><span>começa aqui.</span></h2><p class="section-intro mt-7">Conte um pouco sobre sua operação. A equipe BPL retorna com um caminho claro para o que você precisa.</p><div class="contact-note mt-10"><span class="contact-note__mark">BPL</span><span>Atendimento comercial<br><strong>feito para o seu contexto.</strong></span></div></div><form class="contact-form" data-contact-form data-reveal data-reveal-delay="120"><div class="form-line"><label for="name">Seu nome</label><input id="name" name="name" type="text" autocomplete="name" placeholder="Como podemos chamar você?" required></div><div class="form-line"><label for="email">Seu melhor e-mail</label><input id="email" name="email" type="email" autocomplete="email" placeholder="voce@empresa.com" required></div><div class="form-line"><label for="context">O que você precisa?</label><select id="context" name="context"><option>Quero conhecer as soluções</option><option>Preciso abastecer uma empresa</option><option>Preciso abastecer um condomínio</option><option>Quero falar sobre um kit</option></select></div><button class="button button--dark mt-7 w-full" type="submit">Enviar para a equipe BPL <span aria-hidden="true">↗</span></button><p class="form-feedback" data-form-feedback role="status" aria-live="polite" hidden>Recebemos seu pedido de contato. Esta demonstração confirma a intenção localmente.</p></form></div></section>
        </main>

        <footer class="site-footer"><div class="mx-auto flex max-w-[1440px] flex-col gap-7 px-6 py-8 lg:flex-row lg:items-center lg:justify-between lg:px-10"><a class="brand-mark brand-mark--footer" href="#top" aria-label="Voltar ao início"><span class="brand-mark__symbol" aria-hidden="true"><svg viewBox="0 0 34 34" fill="none"><path d="M3 29V14.5L17 5l14 9.5V29M8 29V18h18v11M13 29v-6h8v6" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M2 29h30" stroke="currentColor" stroke-width="2"/></svg></span><span><strong>BPL</strong><small>produtos &amp; higiene</small></span></a><p>Higiene em ordem. Rotina sem ruído.</p><p>© <span data-current-year></span> BPL Produtos</p></div></footer>
    </body>
</html>
