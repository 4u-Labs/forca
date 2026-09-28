<?php
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Política de Privacidade — Forca Pro</title>
  <link rel="icon" type="image/svg+xml" href="favicon.svg">
  <link rel="alternate icon" type="image/png" href="favicon-32x32.png">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { font-family: 'Nunito', sans-serif; }
    .glass-card {
      background: rgba(30, 27, 75, 0.7);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.12);
    }
  </style>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 flex flex-col justify-between selection:bg-indigo-500 selection:text-white">

  <!-- Header -->
  <header class="border-b border-white/10 bg-slate-900/60 backdrop-blur-md sticky top-0 z-50">
    <div class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
      <a href="index.php" class="flex items-center gap-3 group">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-pink-500 flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:scale-105 transition-transform">
          <span class="text-xl">🎮</span>
        </div>
        <div>
          <span class="text-xl font-black tracking-tight text-white block leading-none">Forca Pro</span>
          <span class="text-xs text-indigo-400 font-bold uppercase tracking-wider">4U.IA.BR Arcade</span>
        </div>
      </a>
      <div class="flex items-center gap-3">
        <a href="index.php" class="text-xs md:text-sm font-bold text-white/70 hover:text-white bg-white/5 hover:bg-white/10 px-4 py-2 rounded-xl transition border border-white/10">
          ← Voltar ao Jogo
        </a>
      </div>
    </div>
  </header>

  <!-- Content -->
  <main class="max-w-4xl mx-auto px-4 py-12 flex-1 w-full">
    <div class="glass-card rounded-3xl p-6 md:p-10 shadow-2xl space-y-8">
      
      <div>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-3">
          <span>🛡️</span> LGPD & GDPR Compliant • 100% Client-Side
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Política de Privacidade</h1>
        <p class="text-white/60 text-sm mt-1">Última atualização: Setembro de 2026</p>
      </div>

      <div class="prose prose-invert max-w-none space-y-6 text-slate-300 leading-relaxed text-sm md:text-base">
        
        <section class="bg-indigo-950/40 p-5 rounded-2xl border border-indigo-500/20">
          <h2 class="text-lg font-bold text-indigo-300 mb-2 flex items-center gap-2">
            <span>🔒</span> Resumo Executivo: Privacidade por Design
          </h2>
          <p>
            O <strong>Forca Pro</strong> foi projetado segundo a premissa de <em>Zero-Data Retention</em> (Retenção Zero de Dados). 
            Todas as palavras, estatísticas de jogo, sequências de vitórias e desafios ocorrem <strong>estritamente na memória e no navegador do usuário</strong>.
            Nenhum palpite, palavra personalizada ou registro de pontuação é transmitido ou armazenado em nossos servidores.
          </p>
        </section>

        <div>
          <h3 class="text-xl font-bold text-white mb-2">1. Dados Coletados</h3>
          <p>
            O aplicativo <strong>não requer criação de conta, e-mail, senha ou qualquer dado pessoal</strong> para ser utilizado.
            As preferências de áudio, pontuação e conquistas são salvas exclusivamente via <code class="text-indigo-400 bg-white/5 px-2 py-0.5 rounded">localStorage</code> no seu próprio dispositivo, podendo ser limpas a qualquer momento pelas configurações do navegador.
          </p>
        </div>

        <div>
          <h3 class="text-xl font-bold text-white mb-2">2. Modo 2 Jogadores & Desafio Diário</h3>
          <p>
            No modo de 2 jogadores, a palavra secreta e a dica digitadas pelo desafiante ficam salvas temporariamente na memória RAM do navegador durante a partida local e são destruídas ao término do jogo. No Desafio Diário, a palavra do dia é gerada matematicamente de forma offline por um algoritmo de hash baseado na data civil (`YYYY-MM-DD`).
          </p>
        </div>

        <div>
          <h3 class="text-xl font-bold text-white mb-2">3. Cookies e Rastreamento de Terceiros</h3>
          <p>
            O Forca Pro <strong>não utiliza cookies de rastreamento publicitário, pixels invisíveis ou scripts de telemetria invasiva</strong>. Não comercializamos nem compartilhamos dados com corretores de informação ou redes de anúncios.
          </p>
        </div>

        <div>
          <h3 class="text-xl font-bold text-white mb-2">4. Conformidade Legal (LGPD e GDPR)</h3>
          <p>
            Em respeito à Lei Geral de Proteção de Dados (Lei nº 13.709/2018 - LGPD) e ao Regulamento Geral sobre a Proteção de Dados da União Europeia (GDPR), garantimos transparência total, minimização estrita e autodeterminação informativa ao usuário.
          </p>
        </div>

        <div>
          <h3 class="text-xl font-bold text-white mb-2">5. Contato do Encarregado de Dados</h3>
          <p>
            Para esclarecer dúvidas sobre nossas práticas de privacidade ou sugerir melhorias, entre em contato através de nossa <a href="suporte.php" class="text-indigo-400 hover:text-indigo-300 underline font-semibold">Central de Suporte</a> ou pelo canal oficial da plataforma em <a href="https://4u.ia.br" class="text-indigo-400 hover:text-indigo-300 underline font-semibold">4u.ia.br</a>.
          </p>
        </div>

      </div>

      <div class="pt-6 border-t border-white/10 flex flex-wrap gap-4 justify-between items-center text-xs text-white/50">
        <span>&copy; 2026 4U.IA.BR. Todos os direitos reservados.</span>
        <div class="flex gap-4">
          <a href="termos.php" class="hover:text-white transition">Termos de Uso</a>
          <a href="suporte.php" class="hover:text-white transition">Suporte & FAQ</a>
        </div>
      </div>

    </div>
  </main>

  <!-- Footer -->
  <footer class="border-t border-white/10 bg-slate-950/80 py-8 text-center text-xs text-slate-400">
    <div class="max-w-5xl mx-auto px-4 space-y-3">
      <div class="flex justify-center items-center gap-6">
        <a href="https://4u.ia.br" class="hover:text-indigo-400 transition font-bold">4U.IA.BR</a>
        <a href="https://github.com/4u-Labs" target="_blank" class="hover:text-white transition">GitHub 4u-Labs</a>
        <a href="https://www.paypal.com/ncp/payment/L7YRCS984T33N" target="_blank" class="text-amber-400 hover:text-amber-300 font-bold transition">Apoiar Projeto (PayPal)</a>
      </div>
    </div>
  </footer>

</body>
</html>
