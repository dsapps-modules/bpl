<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BPL Produtos | Limpeza, Higiene e Descartáveis para Condomínios e Empresas</title>
    <link rel="icon" type="image/png" href="{{ asset('images/bpl_logo_512.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/bpl_logo_512.png') }}">
  <meta name="description" content="Soluções completas em produtos de limpeza, higiene pessoal, descartáveis e equipamentos para condomínios e empresas. Peça seu orçamento!" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --bpl-primary: rgb(89, 85, 209);
      --bpl-primary-soft: rgb(245, 245, 252);
      --bpl-navy: rgb(12, 36, 60);
      --bpl-navy-deep: rgb(41, 41, 75);
      --bpl-muted: rgb(105, 105, 129);
      --bpl-border: rgb(238, 238, 243);
      --bpl-surface: rgb(255, 255, 255);
      --bpl-canvas: rgb(250, 250, 252);
      --bpl-success: rgb(0, 153, 102);
      --bpl-warning: rgb(245, 166, 35);
    }

    html { scroll-behavior: smooth; }
    body { background: var(--bpl-canvas); color: var(--bpl-navy); font-family: 'Instrument Sans', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.5; }
    ::selection { background: var(--bpl-primary-soft); color: var(--bpl-navy-deep); }
    :focus-visible { outline: 3px solid rgba(89, 85, 209, .45); outline-offset: 3px; }
    .hero-bg { background-color: var(--bpl-navy); background-image: url('https://images.unsplash.com/photo-1585421514738-01798e348b17?auto=format&fit=crop&w=1600&q=80'); background-blend-mode: multiply; }
    .rounded-2xl { border-radius: 10px; }
    .rounded-xl { border-radius: 10px; }
    .rounded-lg { border-radius: 6px; }
    .shadow-md { box-shadow: 0 5px 10px rgba(2, 2, 76, .02); }
    .shadow-lg, .shadow-xl { box-shadow: 0 5px 10px rgba(2, 2, 76, .04); }
    .bg-gray-50 { background-color: var(--bpl-canvas); }
    .text-gray-700, .text-gray-600 { color: var(--bpl-muted); }
    .text-gray-800, .text-gray-900 { color: var(--bpl-navy); }
    [class*="border-gray-"] { border-color: var(--bpl-border); }
    [class*="hover:-translate-y-1"]:hover { transform: none; }
    [class*="bg-gradient-"] { background-image: none; }
    input, textarea { min-height: 52px; border-radius: 6px; border-color: var(--bpl-border); background-color: var(--bpl-surface); color: var(--bpl-navy); }
    textarea { min-height: 116px; }
    input::placeholder, textarea::placeholder { color: var(--bpl-muted); }
    @media (prefers-reduced-motion: reduce) {
      html { scroll-behavior: auto; }
      *, *::before, *::after { transition-duration: .01ms !important; animation-duration: .01ms !important; animation-iteration-count: 1 !important; }
    }
    .hero-bg { background-size: cover; background-position: center; }
  </style>
</head>
<body class="font-sans text-gray-800 antialiased">

  <!-- HEADER -->
  <header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16 md:h-20">
        <!-- Logo -->
        <a href="#inicio" class="flex items-center gap-2">
          <img src="{{ asset('images/bpl_logo_512.png') }}" alt="BPL Produtos" class="w-10 h-10 md:w-12 md:h-12 object-contain" />
          <span class="font-bold text-brand-800 text-lg md:text-xl hidden sm:block">BPL Produtos</span>
        </a>

        <!-- Nav Desktop -->
        <nav class="hidden lg:flex items-center gap-8 text-sm font-medium text-gray-700">
          <a href="#inicio" class="hover:text-brand-600 transition">Início</a>
          <a href="#produtos" class="hover:text-brand-600 transition">Produtos</a>
          <a href="#vantagens" class="hover:text-brand-600 transition">Vantagens</a>
          <a href="#como-funciona" class="hover:text-brand-600 transition">Como Funciona</a>
          <a href="https://wa.me/5511997073652?text=Ol%C3%A1%2C%20gostaria%20de%20solicitar%20um%20or%C3%A7amento%20com%20a%20BPL%20Produtos." class="hover:text-brand-600 transition">Contato</a>
        </nav>

        <!-- CTA Header -->
        <a href="https://wa.me/5511997073652?text=Ol%C3%A1%2C%20gostaria%20de%20solicitar%20um%20or%C3%A7amento%20com%20a%20BPL%20Produtos." class="bg-brand-500 hover:bg-brand-700 text-white font-semibold px-3 md:px-6 py-2 md:py-2.5 rounded-lg shadow-md transition text-xs md:text-base whitespace-nowrap">
          Solicitar Orçamento
        </a>
      </div>
    </div>
  </header>

  <!-- HERO -->
  <section id="inicio" class="hero-bg pt-32 md:pt-40 pb-20 md:pb-28 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="max-w-3xl">
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
          Soluções Completas em <span class="text-cta-400">Limpeza, Higiene e Descartáveis</span> para o seu Negócio
        </h1>
        <p class="text-base md:text-xl text-blue-50 mb-8 leading-relaxed">
          Da faxina pesada à higiene pessoal: tudo em um só lugar, com entrega rápida, produtos de qualidade e preços competitivos para o seu condomínio ou empresa.
        </p>
        <div class="flex flex-col sm:flex-row gap-4">
          <a href="https://wa.me/5511997073652?text=Ol%C3%A1%2C%20gostaria%20de%20solicitar%20um%20or%C3%A7amento%20com%20a%20BPL%20Produtos." class="bg-brand-500 hover:bg-brand-700 text-white font-bold px-8 py-4 rounded-lg shadow-xl transition text-center">
            Peça seu Orçamento Agora
          </a>
          <a href="#produtos" class="bg-white/10 hover:bg-white/20 border border-white/40 text-white font-semibold px-8 py-4 rounded-lg transition text-center">
            Ver Categorias
          </a>
        </div>

        <!-- Selos -->
        <div class="grid grid-cols-3 gap-4 md:gap-8 mt-12 pt-8 border-t border-white/20">
          <div class="flex flex-col items-center text-center">
            <svg class="w-8 h-8 md:w-10 md:h-10 text-cta-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            <span class="text-xs md:text-sm font-medium">Entrega Rápida</span>
          </div>
          <div class="flex flex-col items-center text-center">
            <svg class="w-8 h-8 md:w-10 md:h-10 text-cta-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-xs md:text-sm font-medium">Preços B2B</span>
          </div>
          <div class="flex flex-col items-center text-center">
            <svg class="w-8 h-8 md:w-10 md:h-10 text-cta-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            <span class="text-xs md:text-sm font-medium">Qualidade Garantida</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- PRODUTOS -->
  <section id="produtos" class="py-12 md:py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-2xl mx-auto mb-10">
        <h2 class="text-3xl md:text-4xl font-extrabold text-brand-900 mt-3 mb-4">O que você encontra na BPL Produtos</h2>
        <p class="text-gray-600">Tudo o que seu condomínio ou empresa precisa em um único fornecedor.</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300 border border-gray-100">
          <div class="w-14 h-14 bg-brand-50 rounded-xl flex items-center justify-center mb-5">
            <svg class="w-7 h-7 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
          </div>
          <h3 class="text-lg font-bold text-brand-900 mb-2">Produtos de Limpeza</h3>
          <p class="text-gray-600 text-sm leading-relaxed">Desinfetantes, multiuso, álcool, sabão, ceras, cloro e muito mais.</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300 border border-gray-100">
          <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center mb-5">
            <svg class="w-7 h-7 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
          </div>
          <h3 class="text-lg font-bold text-brand-900 mb-2">Higiene Pessoal</h3>
          <p class="text-gray-600 text-sm leading-relaxed">Papel higiênico, sabonete líquido, papel toalha, álcool em gel e absorventes.</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300 border border-gray-100">
          <div class="w-14 h-14 bg-brand-50 rounded-xl flex items-center justify-center mb-5">
            <svg class="w-7 h-7 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
          </div>
          <h3 class="text-lg font-bold text-brand-900 mb-2">Descartáveis</h3>
          <p class="text-gray-600 text-sm leading-relaxed">Copos, pratos, talheres, sacos de lixo, luvas e toucas descartáveis.</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300 border border-gray-100">
          <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center mb-5">
            <svg class="w-7 h-7 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          </div>
          <h3 class="text-lg font-bold text-brand-900 mb-2">Equipamentos</h3>
          <p class="text-gray-600 text-sm leading-relaxed">Mop, rodo, vassouras, carrinhos de limpeza, aspiradores e dispensers.</p>
        </div>
      </div>

      <div class="text-center mt-12">
        <a href="https://wa.me/5511997073652?text=Ol%C3%A1%2C%20gostaria%20de%20solicitar%20um%20or%C3%A7amento%20com%20a%20BPL%20Produtos." class="inline-block bg-brand-700 hover:bg-brand-800 text-white font-semibold px-8 py-3.5 rounded-lg shadow-md transition">
          Solicitar Tabela de Preços
        </a>
      </div>
    </div>
  </section>

  <!-- VANTAGENS -->
  <section id="vantagens" class="py-12 md:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-2xl mx-auto mb-10">
        <h2 class="text-3xl md:text-4xl font-extrabold text-brand-900 mt-3 mb-4">Por que Condomínios e Empresas escolhem a BPL?</h2>
        <p class="text-gray-600">Reduza custos, simplifique compras e mantenha seu ambiente sempre impecável.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="text-center p-6 rounded-2xl hover:bg-brand-50 transition">
          <div class="w-16 h-16 bg-brand-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
          </div>
          <h3 class="font-bold text-brand-900 mb-2">Variedade em um só lugar</h3>
          <p class="text-gray-600 text-sm">Reduza fornecedores e simplifique suas compras com um único parceiro.</p>
        </div>

        <div class="text-center p-6 rounded-2xl hover:bg-brand-50 transition">
          <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <h3 class="font-bold text-brand-900 mb-2">Condições Especiais B2B</h3>
          <p class="text-gray-600 text-sm">Preços diferenciados para compras em volume e condições flexíveis.</p>
        </div>

        <div class="text-center p-6 rounded-2xl hover:bg-brand-50 transition">
          <div class="w-16 h-16 bg-brand-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          </div>
          <h3 class="font-bold text-brand-900 mb-2">Entrega Ágil</h3>
          <p class="text-gray-600 text-sm">Logística eficiente para não parar sua operação. Receba quando precisar.</p>
        </div>

        <div class="text-center p-6 rounded-2xl hover:bg-brand-50 transition">
          <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
          </div>
          <h3 class="font-bold text-brand-900 mb-2">Atendimento Consultivo</h3>
          <p class="text-gray-600 text-sm">Ajudamos a escolher os produtos certos para cada necessidade.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- COMO FUNCIONA -->
  <section id="como-funciona" class="py-12 md:py-16 bg-brand-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-2xl mx-auto mb-10">
        <h2 class="text-3xl md:text-4xl font-extrabold mt-3 mb-4">Solicitar é Fácil</h2>
        <p class="text-blue-100">Em apenas 3 passos você garante os produtos que seu condomínio ou empresa precisa.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
        <div class="text-center">
          <div class="w-20 h-20 bg-white/15 border-2 border-white/40 rounded-full flex items-center justify-center mx-auto mb-5 text-3xl font-extrabold">
            1
          </div>
          <h3 class="text-xl font-bold mb-2">Envie sua lista</h3>
          <p class="text-blue-100 text-sm">Envie sua lista de produtos ou solicite nosso catálogo completo.</p>
        </div>
        <div class="text-center">
          <div class="w-20 h-20 bg-white/15 border-2 border-white/40 rounded-full flex items-center justify-center mx-auto mb-5 text-3xl font-extrabold">
            2
          </div>
          <h3 class="text-xl font-bold mb-2">Receba a cotação</h3>
          <p class="text-blue-100 text-sm">Nossa equipe prepara uma cotação personalizada com as melhores condições.</p>
        </div>
        <div class="text-center">
          <div class="w-20 h-20 bg-white/15 border-2 border-white/40 rounded-full flex items-center justify-center mx-auto mb-5 text-3xl font-extrabold">
            3
          </div>
          <h3 class="text-xl font-bold mb-2">Aprove e receba</h3>
          <p class="text-blue-100 text-sm">Aprove a proposta e agende a entrega no melhor dia para você.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- DEPOIMENTOS -->
  <section class="py-12 md:py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-2xl mx-auto mb-10">
        <h2 class="text-3xl md:text-4xl font-extrabold text-brand-900 mt-3 mb-4">Quem confia na BPL Produtos</h2>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-md">
          <div class="flex text-cta-500 mb-3">
            <span aria-label="5 de 5 estrelas">Avaliação 5/5</span>
          </div>
          <p class="text-gray-700 italic mb-5">"Reduzi meus fornecedores de limpeza para um só. A entrega é sempre pontual e o atendimento é excelente."</p>
          <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
            <div class="w-10 h-10 bg-brand-600 text-white rounded-full flex items-center justify-center font-bold">JM</div>
            <div>
              <div class="font-semibold text-brand-900 text-sm">João Martins</div>
              <div class="text-xs text-gray-500">Síndico - Ed. Vista Verde</div>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-md">
          <div class="flex text-cta-500 mb-3">
            <span aria-label="5 de 5 estrelas">Avaliação 5/5</span>
          </div>
          <p class="text-gray-700 italic mb-5">"Preços competitivos e variedade enorme. Nossa equipe de facilities não fica sem nenhum item."</p>
          <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
            <div class="w-10 h-10 bg-accent-600 text-white rounded-full flex items-center justify-center font-bold">CS</div>
            <div>
              <div class="font-semibold text-brand-900 text-sm">Carla Souza</div>
              <div class="text-xs text-gray-500">Gerente de Facilities</div>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-md">
          <div class="flex text-cta-500 mb-3">
            <span aria-label="5 de 5 estrelas">Avaliação 5/5</span>
          </div>
          <p class="text-gray-700 italic mb-5">"Atendimento consultivo de verdade. Me ajudaram a escolher os produtos certos e economizei bastante."</p>
          <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
            <div class="w-10 h-10 bg-brand-700 text-white rounded-full flex items-center justify-center font-bold">RP</div>
            <div>
              <div class="font-semibold text-brand-900 text-sm">Ricardo Pereira</div>
              <div class="text-xs text-gray-500">Administrador de Condomínio</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTATO -->
  <section id="contato" class="py-12 md:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        <!-- Info -->
        <div>
          <h2 class="text-3xl md:text-4xl font-extrabold text-brand-900 mt-3 mb-5">Solicite um Orçamento sem Compromisso</h2>
          <p class="text-gray-600 mb-8 leading-relaxed">
            Preencha o formulário ao lado e nossa equipe entrará em contato rapidamente com uma cotação personalizada. Atendemos condomínios, empresas, escritórios, indústrias e restaurantes.
          </p>

          <div class="space-y-5">
            <div class="flex items-start gap-4">
              <div class="w-12 h-12 bg-brand-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
              </div>
              <div>
                <div class="font-semibold text-brand-900">Telefone / WhatsApp</div>
                <div class="text-gray-600">+55 11 99707-3652</div>
              </div>
            </div>

            <div class="flex items-start gap-4">
              <div class="w-12 h-12 bg-brand-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
              </div>
              <div>
                <div class="font-semibold text-brand-900">E-mail</div>
                <div class="text-gray-600">E-mail comercial a confirmar</div>
              </div>
            </div>

            <div class="flex items-start gap-4">
              <div class="w-12 h-12 bg-brand-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              </div>
              <div>
                <div class="font-semibold text-brand-900">Endereço</div>
                <div class="text-gray-600">Endereço comercial a confirmar</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Formulário -->
        <div class="bg-gray-50 rounded-2xl p-6 md:p-8 shadow-lg border border-gray-100">
          <form action="#" method="POST" class="space-y-5">
            <div>
              <label for="nome" class="block text-sm font-semibold text-gray-700 mb-1.5">Nome*</label>
              <input type="text" id="nome" name="nome" required placeholder="Seu nome completo"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none transition" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">E-mail*</label>
                <input type="email" id="email" name="email" required placeholder="seu@email.com"
                  class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none transition" />
              </div>
              <div>
                <label for="telefone" class="block text-sm font-semibold text-gray-700 mb-1.5">Telefone / WhatsApp*</label>
                <input type="tel" id="telefone" name="telefone" required placeholder="(00) 00000-0000"
                  class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none transition" />
              </div>
            </div>

            <div>
              <label for="empresa" class="block text-sm font-semibold text-gray-700 mb-1.5">Empresa ou condomínio*</label>

              <input type="text" id="empresa" name="empresa" required placeholder="Nome da empresa ou condomínio"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none transition" />
            </div>

            <div>
              <label for="mensagem" class="block text-sm font-semibold text-gray-700 mb-1.5">Mensagem (opcional)</label>
              <textarea id="mensagem" name="mensagem" rows="4" placeholder="Conte brevemente o que você precisa..."
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none transition"></textarea>
            </div>

            <button type="submit" class="w-full bg-brand-500 hover:bg-brand-700 text-white font-bold px-6 py-3.5 rounded-lg shadow-md transition">
              Enviar Pedido de Orçamento
            </button>
            <p class="text-xs text-gray-500 text-center">Responderemos o mais rápido possível pelo WhatsApp.</p>
          </form>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-brand-900 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <div class="flex items-center gap-2 mb-4">
            <img src="{{ asset('images/bpl_logo_512.png') }}" alt="BPL Produtos" class="w-12 h-12 object-contain" />
            <span class="font-bold text-lg">BPL Produtos</span>
          </div>
          <p class="text-blue-200 text-sm">Soluções completas em limpeza, higiene e descartáveis para sua operação.</p>
        </div>
        <div>
          <h3 class="font-bold mb-4">Links Rápidos</h3>
          <ul class="space-y-2 text-blue-200 text-sm">
            <li><a href="#produtos" class="hover:text-white transition">Produtos</a></li>
            <li><a href="#vantagens" class="hover:text-white transition">Vantagens</a></li>
            <li><a href="#como-funciona" class="hover:text-white transition">Como Funciona</a></li>
            <li><a href="#contato" class="hover:text-white transition">Contato</a></li>
          </ul>
        </div>
        <div>
          <h3 class="font-bold mb-4">Fale Conosco</h3>
          <ul class="space-y-2 text-blue-200 text-sm">
            <li><a href="https://wa.me/5511997073652" target="_blank" rel="noopener" class="hover:text-white transition">WhatsApp: +55 11 99707-3652</a></li>
            <li>E-mail comercial a confirmar</li>
            <li>Endereço comercial a confirmar</li>
          </ul>
        </div>
        <div>
          <h3 class="font-bold mb-4">Siga a BPL</h3>
          <div class="flex gap-3">
            <a href="#" aria-label="Instagram a configurar" class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center hover:bg-white/20 transition"><span aria-hidden="true">IG</span></a>
            <a href="#" aria-label="Facebook a configurar" class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center hover:bg-white/20 transition"><span aria-hidden="true">FB</span></a>
            <a href="https://wa.me/5511997073652" target="_blank" rel="noopener" aria-label="WhatsApp BPL" class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center hover:bg-white/20 transition"><span aria-hidden="true">WA</span></a>
          </div>
        </div>
      </div>
      <div class="border-t border-white/20 mt-8 pt-6 text-center text-blue-200 text-sm">
        © {{ date('Y') }} BPL Produtos. Todos os direitos reservados.
      </div>
    </div>
  </footer>

  <script>
    const form = document.querySelector('form');
    form?.addEventListener('submit', (event) => {
      event.preventDefault();
      const data = new FormData(form);
      const message = [
        'Olá, BPL Produtos. Gostaria de solicitar um orçamento.',
        'Nome: ' + data.get('nome'),
        'E-mail: ' + data.get('email'),
        'Telefone: ' + data.get('telefone'),
        'Empresa ou condomínio: ' + data.get('empresa'),
        'Mensagem: ' + (data.get('mensagem') || 'A definir'),
      ].join('\n');
      window.open('https://wa.me/5511997073652?text=' + encodeURIComponent(message), '_blank', 'noopener');
    });
  </script>
</body>
</html>
