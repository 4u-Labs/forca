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
  <title>Termos de Uso — Forca Pro</title>
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
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-400 text-xs font-bold uppercase tracking-wider mb-3">
          <span>📜</span> Termos de Serviço • Uso Livre e Educacional
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Termos de Uso</h1>
        <p class="text-white/60 text-sm mt-1">Vigência: 2026</p>
      </div>

      <div class="prose prose-invert max-w-none space-y-6 text-slate-300 leading-relaxed text-sm md:text-base">
        
        <div>
          <h3 class="text-xl font-bold text-white mb-2">1. Aceitação dos Termos</h3>
          <p>
            Ao acessar e usufruir do <strong>Forca Pro</strong>, disponibilizado pelo ecossistema <strong>4U.IA.BR</strong>, você concorda expressamente com os presentes termos. Caso discorde de qualquer disposição, solicitamos que descontinue o uso do aplicativo.
          </p>
        </div>

        <div>
          <h3 class="text-xl font-bold text-white mb-2">2. Finalidade Educativa e de Lazer</h3>
          <p>
            O Forca Pro é uma aplicação gratuita destinada ao entretenimento intelectual, enriquecimento de vocabulário, treino cognitivo e apoio pedagógico para escolas, professores e estudantes da língua portuguesa.
          </p>
        </div>

        <div>
          <h3 class="text-xl font-bold text-white mb-2">3. Licença de Uso</h3>
          <p>
            Concedemos aos usuários uma licença pessoal, não exclusiva, intransferível e irrevogável para executar a aplicação via web browser ou instalada como Progressive Web App (PWA), livre de custos ou cobranças ocultas.
          </p>
        </div>

        <div>
          <h3 class="text-xl font-bold text-white mb-2">4. Propriedade Intelectual & Código Aberto</h3>
          <p>
            O código-fonte e as marcas associadas pertencem à organização <strong>4U-Labs</strong>, regidos por princípios de transparência e compartilhamento comunitário em nosso repositório no GitHub. O léxico de palavras e fatos culturais foi compilado a partir de fontes públicas e literatura aberta.
          </p>
        </div>

        <div>
          <h3 class="text-xl font-bold text-white mb-2">5. Isenção de Garantias</h3>
          <p>
            A plataforma é fornecida "como está" (<em>as is</em>), sem garantias implícitas de disponibilidade ininterrupta, embora utilizemos técnicas de Service Worker e cache offline para assegurar o funcionamento contínuo mesmo na ausência de sinal de internet.
          </p>
        </div>

      </div>

      <div class="pt-6 border-t border-white/10 flex flex-wrap gap-4 justify-between items-center text-xs text-white/50">
        <span>&copy; 2026 4U.IA.BR. Todos os direitos reservados.</span>
        <div class="flex gap-4">
          <a href="privacidade.php" class="hover:text-white transition">Privacidade</a>
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
