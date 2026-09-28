<?php
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");

$successMsg = '';
$errorMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $assunto = trim(filter_input(INPUT_POST, 'assunto', FILTER_SANITIZE_SPECIAL_CHARS));
    $mensagem = trim(filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_SPECIAL_CHARS));

    if (!empty($nome) && !empty($email) && !empty($mensagem)) {
        $logFile = __DIR__ . '/uploads/messages_log.json';
        $entry = [
            'data' => date('Y-m-d H:i:s'),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
            'nome' => $nome,
            'email' => $email,
            'assunto' => $assunto,
            'mensagem' => $mensagem
        ];

        $existing = [];
        if (file_exists($logFile)) {
            $content = file_get_contents($logFile);
            $existing = json_decode($content, true) ?: [];
        }
        $existing[] = $entry;
        file_put_contents($logFile, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Se for requisição AJAX/fetch, devolve JSON
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => 'Mensagem registrada com sucesso!']);
            exit;
        }

        $successMsg = 'Obrigado pelo contato! Sua mensagem foi enviada à equipe do Forca Pro.';
    } else {
        $errorMsg = 'Por favor, preencha todos os campos obrigatórios.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suporte & Central de Ajuda — Forca Pro</title>
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
  <main class="max-w-4xl mx-auto px-4 py-12 flex-1 w-full space-y-10">
    
    <!-- Hero FAQ -->
    <div class="glass-card rounded-3xl p-6 md:p-10 shadow-2xl">
      <div class="mb-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-pink-500/20 text-pink-400 text-xs font-bold uppercase tracking-wider mb-3">
          <span>💡</span> Dúvidas Frequentes & Regras
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Central de Suporte & Ajuda</h1>
        <p class="text-white/60 text-sm mt-1">Aprenda a dominar os modos de jogo, acentos e recursos do Forca Pro.</p>
      </div>

      <!-- FAQ Accordion -->
      <div class="space-y-4">
        
        <details class="group bg-white/5 rounded-2xl p-4 border border-white/10 open:border-indigo-500/40 transition">
          <summary class="font-bold text-base md:text-lg text-white cursor-pointer flex justify-between items-center select-none">
            <span>🔤 Como funciona o sistema inteligente de acentos e "Ç"?</span>
            <span class="text-indigo-400 group-open:rotate-180 transition-transform">▼</span>
          </summary>
          <div class="mt-3 text-slate-300 text-sm leading-relaxed border-t border-white/10 pt-3">
            O Forca Pro possui normalização automática. Quando você chuta a letra <strong>A</strong>, o jogo valida tanto <em>A, Á, À, Ã quanto Â</em>. Ao chutar <strong>C</strong>, revela <em>C e Ç</em>. A palavra secreta na tela mantém sua grafia correta com todos os acentos e hífens visíveis!
          </div>
        </details>

        <details class="group bg-white/5 rounded-2xl p-4 border border-white/10 open:border-indigo-500/40 transition">
          <summary class="font-bold text-base md:text-lg text-white cursor-pointer flex justify-between items-center select-none">
            <span>👥 Como funciona o Modo 2 Jogadores (Duelo)?</span>
            <span class="text-indigo-400 group-open:rotate-180 transition-transform">▼</span>
          </summary>
          <div class="mt-3 text-slate-300 text-sm leading-relaxed border-t border-white/10 pt-3">
            No Modo 2 Jogadores, o <strong>Jogador 1</strong> escolhe qualquer palavra secreta personalizada e pode fornecer uma dica temática sutil. O jogo mascara a digitação para ninguém espiar e, em seguida, você passa o celular ou computador para o <strong>Jogador 2</strong> tentar adivinhar!
          </div>
        </details>

        <details class="group bg-white/5 rounded-2xl p-4 border border-white/10 open:border-indigo-500/40 transition">
          <summary class="font-bold text-base md:text-lg text-white cursor-pointer flex justify-between items-center select-none">
            <span>⚡ O que é o Modo Contra o Relógio (Blitz)?</span>
            <span class="text-indigo-400 group-open:rotate-180 transition-transform">▼</span>
          </summary>
          <div class="mt-3 text-slate-300 text-sm leading-relaxed border-t border-white/10 pt-3">
            Você começa com 60 segundos no cronômetro. Cada letra correta soma <strong>+3 segundos</strong> de bônus, e adivinhar a palavra inteira garante <strong>+15 segundos</strong> para o próximo enigma! Se o tempo acabar ou você estourar as tentativas, o jogo encerra e seu recorde é salvo.
          </div>
        </details>

        <details class="group bg-white/5 rounded-2xl p-4 border border-white/10 open:border-indigo-500/40 transition">
          <summary class="font-bold text-base md:text-lg text-white cursor-pointer flex justify-between items-center select-none">
            <span>📅 O que é o Desafio Diário?</span>
            <span class="text-indigo-400 group-open:rotate-180 transition-transform">▼</span>
          </summary>
          <div class="mt-3 text-slate-300 text-sm leading-relaxed border-t border-white/10 pt-3">
            Inspirado no <em>Termo</em> e <em>Wordle</em>, todos os jogadores recebem a mesma palavra secreta a cada dia do calendário. Ao vencer ou perder, você pode clicar em <strong>"Compartilhar Resultado"</strong> para copiar um resumo em emojis para colar no WhatsApp ou redes sociais!
          </div>
        </details>

        <details class="group bg-white/5 rounded-2xl p-4 border border-white/10 open:border-indigo-500/40 transition">
          <summary class="font-bold text-base md:text-lg text-white cursor-pointer flex justify-between items-center select-none">
            <span>✈️ O jogo funciona sem internet (offline)?</span>
            <span class="text-indigo-400 group-open:rotate-180 transition-transform">▼</span>
          </summary>
          <div class="mt-3 text-slate-300 text-sm leading-relaxed border-t border-white/10 pt-3">
            Sim! O Forca Pro é um <strong>Progressive Web App (PWA)</strong> completo. Todas as mais de 1.500 palavras e arquivos de som sintetizados rodam localmente. Clique no botão <em>"Instalar App"</em> no topo da tela para usá-lo como um aplicativo nativo em viagens ou sem rede.
          </div>
        </details>

      </div>
    </div>

    <!-- Contact Form -->
    <div class="glass-card rounded-3xl p-6 md:p-10 shadow-2xl">
      <div class="mb-6">
        <h2 class="text-2xl font-bold text-white flex items-center gap-2">
          <span>📬</span> Envie uma Mensagem ou Sugira Novas Palavras
        </h2>
        <p class="text-white/60 text-sm mt-1">Quer sugerir uma nova categoria ou relatar um comportamento inesperado? Fale conosco!</p>
      </div>

      <?php if (!empty($successMsg)): ?>
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-sm font-semibold flex items-center gap-2">
          <span>✅</span> <?= htmlspecialchars($successMsg) ?>
        </div>
      <?php elseif (!empty($errorMsg)): ?>
        <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/40 text-red-300 text-sm font-semibold flex items-center gap-2">
          <span>⚠️</span> <?= htmlspecialchars($errorMsg) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="suporte.php" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-white/70 mb-1">Seu Nome</label>
            <input type="text" name="nome" required placeholder="Ex: Maria Silva" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-indigo-500 transition text-sm">
          </div>
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-white/70 mb-1">Seu E-mail</label>
            <input type="email" name="email" required placeholder="Ex: maria@email.com" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-indigo-500 transition text-sm">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-white/70 mb-1">Assunto</label>
          <input type="text" name="assunto" placeholder="Ex: Sugestão de novas palavras em Mitologia" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-indigo-500 transition text-sm">
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-white/70 mb-1">Mensagem</label>
          <textarea name="mensagem" required rows="4" placeholder="Escreva aqui seu feedback, dúvida ou sugestão..." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-indigo-500 transition text-sm resize-y"></textarea>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-500 hover:to-pink-500 text-white font-extrabold py-3 px-6 rounded-xl shadow-lg shadow-indigo-500/25 transition transform active:scale-95 text-sm md:text-base">
          🚀 Enviar Mensagem
        </button>
      </form>
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
