<?php
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Cache-Control: public, max-age=3600");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Forca Pro — Jogo da Forca Arcade, Desafio Diário & Duelo</title>
  <meta name="description" content="O clássico jogo da forca reinventado: 1.500+ palavras, acentos inteligentes, modo Blitz 60s, duelo para 2 jogadores, desafio diário e 100% offline.">

  <!-- PWA & Mobile -->
  <link rel="manifest" href="manifest.json">
  <meta name="theme-color" content="#4f46e5">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="Forca Pro">

  <!-- Icons -->
  <link rel="icon" type="image/svg+xml" href="favicon.svg">
  <link rel="alternate icon" type="image/png" href="favicon-32x32.png">
  <link rel="apple-touch-icon" href="icon-192.png">

  <!-- Fonts & Tailwind -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@600;700&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    * { font-family: 'Nunito', sans-serif; -webkit-tap-highlight-color: transparent; }
    .font-arcade { font-family: 'Fredoka', cursive; }
    
    .glass-panel {
      background: rgba(15, 23, 42, 0.75);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.12);
    }
    
    .glass-button {
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .glass-button:hover:not(:disabled) {
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.25), rgba(255, 255, 255, 0.1));
      transform: translateY(-1px);
    }
    .glass-button:active:not(:disabled) {
      transform: translateY(1px) scale(0.97);
    }
    .glass-button:disabled {
      opacity: 0.35;
      cursor: not-allowed;
      transform: none;
    }

    .key-btn {
      transition: all 0.12s ease;
      touch-action: manipulation;
    }
    .key-btn:hover:not(:disabled) {
      transform: translateY(-2px);
      filter: brightness(1.2);
    }
    .key-btn:active:not(:disabled) {
      transform: translateY(1px) scale(0.95);
    }

    .letter-tile {
      animation: popTile 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes popTile {
      0% { transform: scale(0.5); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }

    @keyframes swing {
      0%, 100% { transform: rotate(0deg); }
      25% { transform: rotate(3deg); }
      75% { transform: rotate(-3deg); }
    }
    .hangman-swing {
      animation: swing 2.5s ease-in-out infinite;
      transform-origin: 140px 40px;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%, 60% { transform: translateX(-6px); }
      40%, 80% { transform: translateX(6px); }
    }
    .shake-anim {
      animation: shake 0.4s ease-in-out;
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 0.6; }
      50% { opacity: 1; }
    }
    .pulse-glow {
      animation: pulseGlow 1.5s infinite;
    }

    .confetti-piece {
      position: fixed;
      width: 10px;
      height: 10px;
      pointer-events: none;
      z-index: 9999;
      animation: confettiDrop 3s linear forwards;
    }
    @keyframes confettiDrop {
      0% { transform: translateY(-10vh) rotate(0deg); opacity: 1; }
      100% { transform: translateY(105vh) rotate(720deg); opacity: 0; }
    }
  </style>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 flex flex-col justify-between selection:bg-indigo-500 selection:text-white relative overflow-x-hidden">

  <!-- Background Glow Orbs -->
  <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl"></div>
    <div class="absolute top-1/3 -right-40 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 left-1/3 w-96 h-96 bg-pink-600/15 rounded-full blur-3xl"></div>
  </div>

  <!-- Header -->
  <header class="border-b border-white/10 bg-slate-900/70 backdrop-blur-md sticky top-0 z-40">
    <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between gap-2">
      
      <!-- Brand -->
      <a href="index.php" class="flex items-center gap-3 group">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-purple-600 to-pink-500 flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:scale-105 transition-transform">
          <span class="text-xl">🎮</span>
        </div>
        <div>
          <span class="text-xl font-black tracking-tight text-white block leading-none font-arcade">Forca Pro</span>
          <span class="text-[10px] text-indigo-400 font-bold uppercase tracking-wider">4U.IA.BR Arcade</span>
        </div>
      </a>

      <!-- Quick Actions -->
      <div class="flex items-center gap-1.5 md:gap-2">
        
        <!-- Audio Toggle -->
        <button id="btnSound" onclick="toggleSound()" title="Ativar/Desativar Sons" class="glass-button p-2 md:px-3 md:py-1.5 rounded-xl text-xs font-bold flex items-center gap-1.5 text-white/90">
          <span id="soundIcon">🔊</span>
          <span class="hidden md:inline" id="soundLabel">Som</span>
        </button>

        <!-- Stats Button -->
        <button onclick="openStatsModal()" title="Ver Estatísticas & Conquistas" class="glass-button p-2 md:px-3 md:py-1.5 rounded-xl text-xs font-bold flex items-center gap-1.5 text-amber-300">
          <span>🏆</span>
          <span class="hidden md:inline">Estatísticas</span>
        </button>

        <!-- Install PWA Button -->
        <button id="btnInstallPwa" onclick="installPwa()" style="display:none;" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-extrabold px-3 py-1.5 rounded-xl text-xs shadow-lg shadow-emerald-500/30 transition transform hover:scale-105 active:scale-95 flex items-center gap-1.5">
          <span>📲</span>
          <span>Instalar App</span>
        </button>

        <a href="https://4u.ia.br" target="_blank" class="hidden sm:flex text-xs font-bold text-white/60 hover:text-white bg-white/5 hover:bg-white/10 px-3 py-1.5 rounded-xl transition border border-white/10 items-center gap-1">
          <span>←</span> Loja 4U
        </a>
      </div>

    </div>

    <!-- Mode Selector Tabs -->
    <div class="max-w-5xl mx-auto px-4 pb-2.5 pt-1 flex items-center gap-1.5 overflow-x-auto no-scrollbar">
      <button onclick="switchMode('classico')" id="tab-classico" class="mode-tab px-3.5 py-1.5 rounded-xl text-xs font-black tracking-wide transition flex items-center gap-1.5 whitespace-nowrap bg-indigo-600 text-white shadow-md shadow-indigo-600/30">
        <span>🕹️</span> Clássico
      </button>
      <button onclick="switchMode('blitz')" id="tab-blitz" class="mode-tab px-3.5 py-1.5 rounded-xl text-xs font-black tracking-wide transition flex items-center gap-1.5 whitespace-nowrap text-white/70 hover:text-white hover:bg-white/10">
        <span>⚡</span> Blitz 60s
      </button>
      <button onclick="switchMode('duelo')" id="tab-duelo" class="mode-tab px-3.5 py-1.5 rounded-xl text-xs font-black tracking-wide transition flex items-center gap-1.5 whitespace-nowrap text-white/70 hover:text-white hover:bg-white/10">
        <span>👥</span> 2 Jogadores
      </button>
      <button onclick="switchMode('diario')" id="tab-diario" class="mode-tab px-3.5 py-1.5 rounded-xl text-xs font-black tracking-wide transition flex items-center gap-1.5 whitespace-nowrap text-white/70 hover:text-white hover:bg-white/10">
        <span>📅</span> Desafio Diário
      </button>
    </div>
  </header>

  <!-- Main Game Arena -->
  <main class="max-w-4xl mx-auto px-3 sm:px-4 py-4 md:py-8 flex-1 w-full relative z-10 space-y-4 md:space-y-6">

    <!-- Top Status Bar -->
    <div class="glass-panel rounded-2xl p-3 md:p-4 shadow-xl flex flex-wrap items-center justify-between gap-3">
      
      <!-- Left: Category / Info -->
      <div class="flex items-center gap-2 flex-wrap">
        
        <!-- Category selector or display -->
        <div id="categoryContainer" class="relative">
          <div class="bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 px-3 py-1.5 rounded-xl text-xs font-bold inline-flex items-center gap-2">
            <span>💡</span>
            <span class="text-white/60">Categoria:</span>
            <span id="currentCategoryText" class="text-white font-extrabold">-</span>
            <button id="btnChangeCategory" onclick="openCategoryModal()" title="Trocar Categoria" class="text-indigo-400 hover:text-indigo-200 ml-1 text-xs">
              ✏️
            </button>
          </div>
        </div>

        <!-- Difficulty badge -->
        <button onclick="cycleDifficulty()" id="badgeDifficulty" title="Clique para mudar a dificuldade" class="bg-white/10 hover:bg-white/20 text-white/90 border border-white/15 px-2.5 py-1 rounded-xl text-xs font-extrabold inline-flex items-center gap-1 transition">
          <span id="diffIcon">🟡</span>
          <span id="diffLabel">Médio (6 vidas)</span>
        </button>

      </div>

      <!-- Right: Lives & Streak / Blitz Timer -->
      <div class="flex items-center gap-3">
        
        <!-- Blitz Timer (hidden by default) -->
        <div id="blitzTimerContainer" style="display:none;" class="bg-amber-500/20 text-amber-300 border border-amber-500/40 px-3 py-1 rounded-xl text-sm font-black flex items-center gap-1.5 pulse-glow">
          <span>⏱️</span>
          <span id="blitzTimer">60s</span>
        </div>

        <!-- Streak -->
        <div class="bg-orange-500/20 text-orange-300 border border-orange-500/30 px-3 py-1 rounded-xl text-xs font-extrabold flex items-center gap-1">
          <span>🔥</span>
          <span>Sequência:</span>
          <span id="streakCount" class="text-white font-black">0</span>
        </div>

        <!-- Hearts / Remaining lives -->
        <div class="bg-rose-500/20 text-rose-300 border border-rose-500/30 px-3 py-1 rounded-xl text-xs font-black flex items-center gap-1.5">
          <span id="heartsIcons">❤️❤️❤️❤️❤️❤️</span>
          <span id="remainingLivesText" class="text-white">6</span>
        </div>

      </div>

    </div>

    <!-- Arena Container (SVG Gallows + Hangman + Word Display) -->
    <div class="glass-panel rounded-3xl p-4 sm:p-6 md:p-8 shadow-2xl relative overflow-hidden">
      
      <!-- Hint Alert Banner (if requested) -->
      <div id="hintBanner" style="display:none;" class="mb-4 bg-amber-400/15 border border-amber-400/30 rounded-2xl p-3 text-xs md:text-sm text-amber-200 flex items-center justify-between gap-3 animate-fade-in">
        <div class="flex items-center gap-2">
          <span class="text-lg">💡</span>
          <div>
            <span class="font-extrabold text-amber-300">Dica:</span>
            <span id="hintText" class="ml-1 font-semibold"></span>
          </div>
        </div>
        <button onclick="dismissHint()" class="text-amber-300 hover:text-white text-xs font-bold px-2 py-1">✕</button>
      </div>

      <!-- Gallows SVG Area -->
      <div class="flex justify-center mb-6 relative">
        <svg id="hangmanSvg" width="220" height="230" viewBox="0 0 220 230" class="drop-shadow-2xl">
          
          <!-- Base & Gallows Structure -->
          <line x1="20" y1="215" x2="110" y2="215" stroke="#fbbf24" stroke-width="6" stroke-linecap="round"/>
          <line x1="60" y1="215" x2="60" y2="25" stroke="#fbbf24" stroke-width="6" stroke-linecap="round"/>
          <line x1="60" y1="70" x2="105" y2="25" stroke="#f59e0b" stroke-width="5" stroke-linecap="round"/>
          <line x1="55" y1="25" x2="155" y2="25" stroke="#fbbf24" stroke-width="6" stroke-linecap="round"/>
          <line x1="140" y1="25" x2="140" y2="50" stroke="#fef08a" stroke-width="3" stroke-linecap="round"/>

          <!-- Swinging Hangman Character -->
          <g id="hangmanCharacter" class="hangman-swing">
            
            <!-- Head -->
            <circle id="part-head" cx="140" cy="68" r="18" fill="#ffffff" stroke="#fbbf24" stroke-width="3" opacity="0" class="transition-opacity duration-300"/>
            
            <!-- Eyes (dynamic) -->
            <g id="part-eyes" opacity="0" class="transition-opacity duration-300">
              <!-- Happy / Normal Eyes -->
              <circle id="eye-left-normal" cx="134" cy="66" r="2.2" fill="#1e1b4b"/>
              <circle id="eye-right-normal" cx="146" cy="66" r="2.2" fill="#1e1b4b"/>
              <!-- Dead X Eyes (Loss) -->
              <g id="eyes-dead" style="display:none;" stroke="#dc2626" stroke-width="2" stroke-linecap="round">
                <line x1="131" y1="63" x2="137" y2="69"/>
                <line x1="137" y1="63" x2="131" y2="69"/>
                <line x1="143" y1="63" x2="149" y2="69"/>
                <line x1="149" y1="63" x2="143" y2="69"/>
              </g>
            </g>

            <!-- Mouth (dynamic) -->
            <g id="part-mouth" opacity="0" class="transition-opacity duration-300">
              <path id="mouth-happy" d="M 135 74 Q 140 78 145 74" fill="none" stroke="#db2777" stroke-width="2" stroke-linecap="round"/>
              <path id="mouth-sad" d="M 135 77 Q 140 72 145 77" fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round" style="display:none;"/>
            </g>

            <!-- Sweat drop (fear at 5 errors) -->
            <circle id="part-sweat" cx="156" cy="64" r="2.5" fill="#38bdf8" opacity="0"/>

            <!-- Torso -->
            <line id="part-torso" x1="140" y1="86" x2="140" y2="135" stroke="#ffffff" stroke-width="4.5" stroke-linecap="round" opacity="0" class="transition-opacity duration-300"/>
            
            <!-- Arms -->
            <line id="part-arm-left" x1="140" y1="98" x2="118" y2="118" stroke="#ffffff" stroke-width="4" stroke-linecap="round" opacity="0" class="transition-opacity duration-300"/>
            <line id="part-arm-right" x1="140" y1="98" x2="162" y2="118" stroke="#ffffff" stroke-width="4" stroke-linecap="round" opacity="0" class="transition-opacity duration-300"/>
            
            <!-- Legs -->
            <line id="part-leg-left" x1="140" y1="135" x2="118" y2="175" stroke="#ffffff" stroke-width="4" stroke-linecap="round" opacity="0" class="transition-opacity duration-300"/>
            <line id="part-leg-right" x1="140" y1="135" x2="162" y2="175" stroke="#ffffff" stroke-width="4" stroke-linecap="round" opacity="0" class="transition-opacity duration-300"/>

          </g>

        </svg>
      </div>

      <!-- Word Display (Letters Boxes) -->
      <div id="wordDisplayContainer" class="flex justify-center items-center gap-1.5 sm:gap-2.5 flex-wrap min-h-[64px] mb-6 px-2">
        <!-- Rendered by JS -->
      </div>

      <!-- Actions Bar (Hint + New Word) -->
      <div class="flex items-center justify-center gap-3 pt-2">
        <button id="btnHint" onclick="useHint()" class="glass-button px-4 py-2 rounded-2xl text-xs sm:text-sm font-bold text-amber-300 flex items-center gap-2">
          <span>💡</span>
          <span>Pedir Dica</span>
          <span id="hintCountBadge" class="bg-amber-400/30 text-amber-200 px-1.5 py-0.5 rounded-full text-[10px]">1</span>
        </button>

        <button onclick="newGame()" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-extrabold px-5 py-2 rounded-2xl text-xs sm:text-sm shadow-lg shadow-indigo-500/25 transition transform hover:scale-105 active:scale-95 flex items-center gap-2">
          <span>🔄</span>
          <span>Nova Partida</span>
        </button>
      </div>

    </div>

    <!-- Virtual Keyboard -->
    <div class="glass-panel rounded-3xl p-3 sm:p-5 shadow-2xl space-y-2">
      <div id="keyboardRows" class="flex flex-col items-center gap-1.5 sm:gap-2 select-none">
        <!-- Rows rendered by JS -->
      </div>
    </div>

  </main>

  <!-- Modal: Category Selection -->
  <div id="modalCategory" style="display:none;" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 flex items-center justify-center p-4">
    <div class="glass-panel bg-slate-900/95 rounded-3xl p-6 max-w-md w-full max-h-[85vh] flex flex-col shadow-2xl border border-white/20 animate-fade-in">
      <div class="flex items-center justify-between pb-3 border-b border-white/10 mb-4">
        <h3 class="text-lg font-black text-white flex items-center gap-2 font-arcade">
          <span>📚</span> Escolher Categoria
        </h3>
        <button onclick="closeCategoryModal()" class="text-white/60 hover:text-white text-lg">✕</button>
      </div>
      <div id="categoryList" class="flex-1 overflow-y-auto space-y-2 pr-1 custom-scroll">
        <!-- Rendered by JS -->
      </div>
    </div>
  </div>

  <!-- Modal: 2 Players Setup -->
  <div id="modalDuelo" style="display:none;" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 flex items-center justify-center p-4">
    <div class="glass-panel bg-slate-900/95 rounded-3xl p-6 max-w-md w-full shadow-2xl border border-white/20 animate-fade-in space-y-4">
      <div class="flex items-center justify-between pb-3 border-b border-white/10">
        <h3 class="text-lg font-black text-white flex items-center gap-2 font-arcade">
          <span>👥</span> Modo 2 Jogadores (Duelo Local)
        </h3>
        <button onclick="closeDueloModal()" class="text-white/60 hover:text-white text-lg">✕</button>
      </div>

      <p class="text-xs text-slate-300">
        O <strong>Jogador 1</strong> escolhe a palavra e uma dica. Depois, passe o aparelho para o <strong>Jogador 2</strong> tentar adivinhar!
      </p>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-indigo-300 mb-1">Palavra Secreta</label>
        <div class="relative">
          <input type="password" id="inputDueloWord" placeholder="Ex: ASTRONAUTA" maxlength="30" class="w-full bg-white/5 border border-white/15 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-indigo-500 font-extrabold uppercase tracking-widest text-base">
          <button type="button" onclick="togglePasswordVisibility('inputDueloWord', this)" class="absolute right-3 top-3 text-white/50 hover:text-white text-sm">
            👁️
          </button>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-indigo-300 mb-1">Dica Temática (Opcional)</label>
        <input type="text" id="inputDueloHint" placeholder="Ex: Viajante do espaço" maxlength="50" class="w-full bg-white/5 border border-white/15 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-indigo-500 text-sm">
      </div>

      <div class="pt-2 flex gap-3">
        <button onclick="startDueloGame()" class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-extrabold py-3 px-4 rounded-xl shadow-lg transition active:scale-95 text-sm">
          ⚔️ Iniciar Duelo!
        </button>
      </div>
    </div>
  </div>

  <!-- Modal: Game Over / Victory / Trivia -->
  <div id="modalGameOver" style="display:none;" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 flex items-center justify-center p-4">
    <div class="glass-panel bg-slate-900/95 rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-white/20 animate-fade-in text-center space-y-5">
      
      <div id="modalIcon" class="text-6xl animate-bounce">🎉</div>
      
      <div>
        <h3 id="modalTitle" class="text-2xl sm:text-3xl font-black text-white font-arcade">Parabéns! Você Venceu!</h3>
        <p id="modalSubtitle" class="text-sm text-slate-300 mt-1">Você desvendou o enigma a tempo.</p>
      </div>

      <!-- Revealed Word Card -->
      <div class="bg-indigo-950/50 border border-indigo-500/30 rounded-2xl p-4">
        <span class="text-xs uppercase tracking-wider text-indigo-400 font-extrabold block mb-1">Palavra Secreta</span>
        <span id="modalWordRevealed" class="text-2xl sm:text-3xl font-black text-white tracking-wider font-arcade"></span>
      </div>

      <!-- Trivia Card -->
      <div id="modalTriviaCard" class="bg-white/5 border border-white/10 rounded-2xl p-4 text-left text-xs text-slate-300 space-y-1">
        <div class="flex items-center gap-1.5 text-amber-300 font-bold text-xs">
          <span>🧠</span>
          <span>Você sabia?</span>
        </div>
        <p id="modalTriviaText" class="leading-relaxed"></p>
      </div>

      <!-- Action Buttons -->
      <div class="flex flex-col gap-2.5 pt-2">
        <button id="btnShareResult" onclick="shareResult()" class="glass-button w-full py-3 px-4 rounded-xl text-xs sm:text-sm font-extrabold text-emerald-300 flex items-center justify-center gap-2">
          <span>📲</span>
          <span>Compartilhar Resultado</span>
        </button>

        <button onclick="newGame(); closeModalGameOver();" class="w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-500 hover:to-pink-500 text-white font-black py-3 px-4 rounded-xl shadow-lg transition active:scale-95 text-sm font-arcade tracking-wide">
          🎮 Jogar Novamente
        </button>
      </div>

    </div>
  </div>

  <!-- Modal: Stats & Achievements -->
  <div id="modalStats" style="display:none;" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 flex items-center justify-center p-4">
    <div class="glass-panel bg-slate-900/95 rounded-3xl p-6 sm:p-8 max-w-md w-full max-h-[85vh] flex flex-col shadow-2xl border border-white/20 animate-fade-in space-y-4">
      
      <div class="flex items-center justify-between pb-3 border-b border-white/10">
        <h3 class="text-xl font-black text-white flex items-center gap-2 font-arcade">
          <span>🏆</span> Estatísticas & Conquistas
        </h3>
        <button onclick="closeStatsModal()" class="text-white/60 hover:text-white text-lg">✕</button>
      </div>

      <div class="flex-1 overflow-y-auto space-y-5 pr-1 custom-scroll">
        
        <!-- Key Metrics Grid -->
        <div class="grid grid-cols-3 gap-2 text-center">
          <div class="bg-white/5 rounded-2xl p-3 border border-white/10">
            <span id="statPlayed" class="text-xl sm:text-2xl font-black text-white block">0</span>
            <span class="text-[10px] uppercase font-bold text-white/50 tracking-wider">Jogadas</span>
          </div>
          <div class="bg-white/5 rounded-2xl p-3 border border-white/10">
            <span id="statWinRate" class="text-xl sm:text-2xl font-black text-emerald-400 block">0%</span>
            <span class="text-[10px] uppercase font-bold text-white/50 tracking-wider">Vitórias</span>
          </div>
          <div class="bg-white/5 rounded-2xl p-3 border border-white/10">
            <span id="statMaxStreak" class="text-xl sm:text-2xl font-black text-amber-400 block">0</span>
            <span class="text-[10px] uppercase font-bold text-white/50 tracking-wider">Maior Sequência</span>
          </div>
        </div>

        <div class="bg-indigo-950/40 p-3 rounded-2xl border border-indigo-500/20 text-xs flex justify-between items-center text-slate-300">
          <span>⚡ Recorde no Modo Blitz:</span>
          <span id="statBlitzRecord" class="font-extrabold text-amber-300 text-sm">0 palavras</span>
        </div>

        <!-- Badges / Achievements -->
        <div class="space-y-2">
          <h4 class="text-xs uppercase tracking-wider font-extrabold text-white/70">Medalhas Desbloqueáveis</h4>
          
          <div id="badgeLaser" class="p-2.5 rounded-xl border border-white/10 bg-white/5 flex items-center gap-3 opacity-40">
            <span class="text-2xl">🎯</span>
            <div class="text-left text-xs">
              <div class="font-bold text-white">Mira Laser</div>
              <div class="text-white/60 text-[11px]">Vencer sem errar nenhuma letra.</div>
            </div>
          </div>

          <div id="badgeClutch" class="p-2.5 rounded-xl border border-white/10 bg-white/5 flex items-center gap-3 opacity-40">
            <span class="text-2xl">⏳</span>
            <div class="text-left text-xs">
              <div class="font-bold text-white">No Último Suspiro</div>
              <div class="text-white/60 text-[11px]">Vencer com apenas 1 vida restante.</div>
            </div>
          </div>

          <div id="badgeFire" class="p-2.5 rounded-xl border border-white/10 bg-white/5 flex items-center gap-3 opacity-40">
            <span class="text-2xl">🔥</span>
            <div class="text-left text-xs">
              <div class="font-bold text-white">Em Chamas</div>
              <div class="text-white/60 text-[11px]">Alcançar sequência de 5 vitórias.</div>
            </div>
          </div>

          <div id="badgeBlitz" class="p-2.5 rounded-xl border border-white/10 bg-white/5 flex items-center gap-3 opacity-40">
            <span class="text-2xl">⚡</span>
            <div class="text-left text-xs">
              <div class="font-bold text-white">Relâmpago</div>
              <div class="text-white/60 text-[11px]">Vencer no modo Blitz 60s.</div>
            </div>
          </div>

        </div>

      </div>

    </div>
  </div>

  <!-- Footer -->
  <footer class="border-t border-white/10 bg-slate-950/80 py-8 text-center text-xs text-slate-400 relative z-20">
    <div class="max-w-5xl mx-auto px-4 space-y-4">
      
      <!-- Institutional Navigation -->
      <div class="flex flex-wrap justify-center items-center gap-4 text-xs font-semibold">
        <a href="https://4u.ia.br" class="text-indigo-400 hover:text-indigo-300 transition">4U.IA.BR</a>
        <span class="text-white/20">•</span>
        <a href="privacidade.php" class="hover:text-white transition">Privacidade (LGPD)</a>
        <span class="text-white/20">•</span>
        <a href="termos.php" class="hover:text-white transition">Termos de Uso</a>
        <span class="text-white/20">•</span>
        <a href="suporte.php" class="hover:text-white transition">Suporte & FAQ</a>
        <span class="text-white/20">•</span>
        <a href="https://github.com/4u-Labs/forca" target="_blank" class="hover:text-white transition">GitHub</a>
      </div>

      <!-- PayPal Official Donation -->
      <div class="pt-2">
        <a href="https://www.paypal.com/ncp/payment/L7YRCS984T33N" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-gradient-to-r from-amber-500/20 to-yellow-500/20 border border-amber-500/40 text-amber-300 hover:text-white hover:bg-amber-500/30 px-5 py-2 rounded-full font-bold transition shadow-sm">
          <span>☕</span>
          <span>Apoiar o Desenvolvimento (PayPal)</span>
        </a>
      </div>

      <p class="text-white/30 text-[11px] pt-1">
        &copy; 2026 <strong>4U.IA.BR</strong>. Desenvolvido com orgulho pelo ecossistema 4u-Labs.
      </p>

    </div>
  </footer>

  <!-- Game Logic Script -->
  <script>
    // ==========================================
    // 1. MOTOR DE ÁUDIO ROBUSTO (Web Audio API)
    // ==========================================
    let audioCtx = null;
    let soundEnabled = localStorage.getItem('forca_sound') !== 'false';

    function getAudioContext() {
      if (!audioCtx) {
        const AudioContextClass = window.AudioContext || window.webkitAudioContext;
        if (AudioContextClass) {
          audioCtx = new AudioContextClass();
        }
      }
      return audioCtx;
    }

    function unlockAudio() {
      const ctx = getAudioContext();
      if (ctx && ctx.state === 'suspended') {
        ctx.resume().catch(() => {});
      }
    }
    const initAudio = unlockAudio;

    // Desbloqueia áudio no primeiro gesto do usuário em qualquer ponto da tela
    ['click', 'touchstart', 'touchend', 'keydown', 'mousedown'].forEach(evt => {
      window.addEventListener(evt, unlockAudio, { passive: true });
    });

    function toggleSound() {
      soundEnabled = !soundEnabled;
      localStorage.setItem('forca_sound', soundEnabled);
      updateSoundUI();
      if (soundEnabled) {
        unlockAudio();
        sfxCorrect(); // Feedback sonoro imediato confirmando som ativado
      }
    }

    function updateSoundUI() {
      const icon = document.getElementById('soundIcon');
      const label = document.getElementById('soundLabel');
      if (soundEnabled) {
        icon.textContent = '🔊';
        if (label) label.textContent = 'Som';
      } else {
        icon.textContent = '🔇';
        if (label) label.textContent = 'Mudo';
      }
    }
    updateSoundUI();

    function playTone(freq, type = 'sine', duration = 0.15, gainVal = 0.3) {
      if (!soundEnabled) return;
      const ctx = getAudioContext();
      if (!ctx) return;

      const run = () => {
        try {
          const now = ctx.currentTime + 0.005;
          const osc = ctx.createOscillator();
          const gain = ctx.createGain();

          osc.type = type;
          osc.frequency.setValueAtTime(freq, now);

          // Envelope suave e audível
          gain.gain.setValueAtTime(0.001, now);
          gain.gain.linearRampToValueAtTime(gainVal, now + 0.015);
          gain.gain.exponentialRampToValueAtTime(0.001, now + duration);

          osc.connect(gain);
          gain.connect(ctx.destination);

          osc.start(now);
          osc.stop(now + duration + 0.03);
        } catch (e) {
          console.warn('Audio tone error:', e);
        }
      };

      if (ctx.state === 'suspended') {
        ctx.resume().then(run).catch(() => {});
      } else {
        run();
      }
    }

    function sfxClick() {
      playTone(700, 'triangle', 0.07, 0.25);
    }

    function sfxCorrect() {
      if (!soundEnabled) return;
      playTone(523.25, 'triangle', 0.14, 0.35); // C5
      setTimeout(() => {
        playTone(783.99, 'triangle', 0.20, 0.40); // G5
      }, 90);
    }

    function sfxWrong() {
      if (!soundEnabled) return;
      const ctx = getAudioContext();
      if (!ctx) return;

      const run = () => {
        try {
          const now = ctx.currentTime + 0.005;
          const osc = ctx.createOscillator();
          const gain = ctx.createGain();

          osc.type = 'sawtooth';
          osc.frequency.setValueAtTime(170, now);
          osc.frequency.linearRampToValueAtTime(105, now + 0.25);

          gain.gain.setValueAtTime(0.001, now);
          gain.gain.linearRampToValueAtTime(0.35, now + 0.02);
          gain.gain.linearRampToValueAtTime(0.001, now + 0.25);

          osc.connect(gain);
          gain.connect(ctx.destination);

          osc.start(now);
          osc.stop(now + 0.26);
        } catch (e) {
          playTone(140, 'sawtooth', 0.25, 0.35);
        }
      };

      if (ctx.state === 'suspended') {
        ctx.resume().then(run).catch(() => {});
      } else {
        run();
      }
    }

    function sfxWin() {
      if (!soundEnabled) return;
      const notes = [523.25, 659.25, 783.99, 1046.50, 1318.51]; // C5, E5, G5, C6, E6
      notes.forEach((freq, idx) => {
        setTimeout(() => {
          playTone(freq, 'triangle', 0.25, 0.35);
        }, idx * 100);
      });
    }

    function sfxLose() {
      if (!soundEnabled) return;
      const notes = [392.00, 369.99, 349.23, 293.66]; // G4, F#4, F4, D4
      notes.forEach((freq, idx) => {
        setTimeout(() => {
          playTone(freq, 'sawtooth', 0.30, 0.30);
        }, idx * 130);
      });
    }

    // ==========================================
    // 2. NORMALIZAÇÃO DE ACENTOS
    // ==========================================
    const ACCENT_MAP = {
      'A': ['A', 'Á', 'À', 'Ã', 'Â', 'Ä'],
      'E': ['E', 'É', 'È', 'Ê', 'Ë'],
      'I': ['I', 'Í', 'Ì', 'Î', 'Ï'],
      'O': ['O', 'Ó', 'Ò', 'Õ', 'Ô', 'Ö'],
      'U': ['U', 'Ú', 'Ù', 'Û', 'Ü'],
      'C': ['C', 'Ç']
    };

    function normalizeChar(char) {
      const upper = char.toUpperCase();
      for (const [base, accents] of Object.entries(ACCENT_MAP)) {
        if (accents.includes(upper)) return base;
      }
      return upper;
    }

    // ==========================================
    // 3. ESTADO GLOBAL DO JOGO
    // ==========================================
    let database = null;
    let currentMode = 'classico'; // 'classico', 'blitz', 'duelo', 'diario'
    let currentCategory = 'Todas as Categorias';
    let currentWord = '';
    let currentHint = '';
    let currentTrivia = '';
    let guessedKeys = [];
    let wrongCount = 0;
    let maxErrors = 6;
    let difficulty = 'medio'; // facil (7), medio (6), dificil (5)
    let gameOver = false;
    let hintUsed = false;
    let streak = parseInt(localStorage.getItem('forca_streak') || '0', 10);
    
    // Blitz Mode State
    let blitzSeconds = 60;
    let blitzTimerInterval = null;
    let blitzWordsSolved = 0;

    // Daily Word State
    let dailyCompleted = false;

    // Partes corporais do SVG para cada erro
    const hangmanParts = [
      'part-head',
      'part-torso',
      'part-arm-left',
      'part-arm-right',
      'part-leg-left',
      'part-leg-right'
    ];

    // ==========================================
    // 4. CARREGAMENTO DO BANCO DE PALAVRAS
    // ==========================================
    async function loadWordsDatabase() {
      try {
        const resp = await fetch('words.json');
        database = await resp.json();
        buildCategoryList();
        document.getElementById('streakCount').textContent = streak;
        initGame();
      } catch (err) {
        console.error('Erro ao carregar words.json:', err);
      }
    }

    // ==========================================
    // 5. INICIALIZAÇÃO E ESCOLHA DE PALAVRA
    // ==========================================
    function initGame() {
      if (!database) return;
      clearInterval(blitzTimerInterval);

      guessedKeys = [];
      wrongCount = 0;
      gameOver = false;
      hintUsed = false;
      dismissHint();

      // Ajusta maxErrors pela dificuldade
      if (difficulty === 'facil') maxErrors = 7;
      else if (difficulty === 'medio') maxErrors = 6;
      else if (difficulty === 'dificil') maxErrors = 5;

      updateDifficultyUI();

      if (currentMode === 'diario') {
        setupDailyWord();
      } else if (currentMode === 'duelo') {
        // Aguarda entrada do modal de duelo
      } else if (currentMode === 'blitz') {
        pickRandomWord();
        startBlitzTimer();
      } else {
        // Clássico
        pickRandomWord();
      }

      updateHearts();
      updateHangmanVisuals();
      renderWordDisplay();
      renderKeyboard();
      updateStreakUI();
    }

    function newGame() {
      initAudio();
      sfxClick();
      if (currentMode === 'duelo') {
        openDueloModal();
        return;
      }
      initGame();
    }

    function pickRandomWord() {
      const cats = database.categories;
      let pool = [];

      if (currentCategory === 'Todas as Categorias' || !cats[currentCategory]) {
        for (const [catName, wordsList] of Object.entries(cats)) {
          wordsList.forEach(w => pool.push({ ...w, cat: catName }));
        }
      } else {
        pool = cats[currentCategory].map(w => ({ ...w, cat: currentCategory }));
      }

      // Filtra por dificuldade se aplicável
      if (difficulty === 'facil') {
        const filtered = pool.filter(w => w.dificuldade === 'facil');
        if (filtered.length > 0) pool = filtered;
      } else if (difficulty === 'dificil') {
        const filtered = pool.filter(w => w.dificuldade === 'dificil');
        if (filtered.length > 0) pool = filtered;
      }

      const item = pool[Math.floor(Math.random() * pool.length)];
      currentWord = item.palavra.toUpperCase();
      currentHint = item.dica;
      currentTrivia = item.curiosidade || `A palavra ${currentWord} faz parte do léxico e vocabulário de ${item.cat}.`;
      document.getElementById('currentCategoryText').textContent = item.cat;
    }

    function setupDailyWord() {
      // Determinístico com base no hash da data YYYY-MM-DD
      const today = new Date().toISOString().split('T')[0];
      let hash = 0;
      for (let i = 0; i < today.length; i++) {
        hash = (hash << 5) - hash + today.charCodeAt(i);
        hash |= 0;
      }
      
      const allWords = [];
      for (const [catName, wordsList] of Object.entries(database.categories)) {
        wordsList.forEach(w => allWords.push({ ...w, cat: catName }));
      }
      
      const idx = Math.abs(hash) % allWords.length;
      const item = allWords[idx];
      currentWord = item.palavra.toUpperCase();
      currentHint = item.dica;
      currentTrivia = item.curiosidade || `Palavra especial do desafio diário de ${today}!`;
      document.getElementById('currentCategoryText').textContent = `📅 Diário: ${item.cat}`;
    }

    // ==========================================
    // 6. RENDERIZAÇÃO DA PALAVRA & TECLADO
    // ==========================================
    function renderWordDisplay() {
      const container = document.getElementById('wordDisplayContainer');
      container.innerHTML = '';

      const letters = [...currentWord];
      letters.forEach((char) => {
        if (char === ' ') {
          // Espaço entre palavras
          const space = document.createElement('div');
          space.className = 'w-4 md:w-6';
          container.appendChild(space);
          return;
        }

        const box = document.createElement('div');
        box.className = 'letter-tile w-9 h-12 sm:w-11 sm:h-14 md:w-12 md:h-16 rounded-xl flex items-center justify-center text-xl sm:text-2xl md:text-3xl font-black font-arcade transition-all';

        if (char === '-' || char === '\'') {
          box.textContent = char;
          box.className += ' text-white/70 border-b-2 border-white/20';
        } else {
          const baseChar = normalizeChar(char);
          if (guessedKeys.includes(baseChar)) {
            box.textContent = char;
            box.className += ' bg-emerald-500/25 text-emerald-300 border-2 border-emerald-500/50 shadow-lg shadow-emerald-500/20';
          } else {
            box.textContent = '_';
            box.className += ' bg-white/10 text-transparent border-b-4 border-white/30';
          }
        }

        container.appendChild(box);
      });
    }

    function renderKeyboard() {
      const container = document.getElementById('keyboardRows');
      container.innerHTML = '';

      const rows = [
        ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P'],
        ['A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Ç'],
        ['Z', 'X', 'C', 'V', 'B', 'N', 'M']
      ];

      rows.forEach(row => {
        const rowDiv = document.createElement('div');
        rowDiv.className = 'flex justify-center gap-1 sm:gap-1.5 w-full';

        row.forEach(key => {
          const btn = document.createElement('button');
          btn.textContent = key;
          btn.id = `key-${key}`;
          btn.className = 'key-btn w-7 h-10 sm:w-10 sm:h-12 md:w-11 md:h-13 bg-white/10 hover:bg-white/20 text-white font-black rounded-xl shadow-md border border-white/15 text-sm sm:text-base font-arcade flex items-center justify-center';
          btn.onclick = () => handleKeyGuess(key);
          rowDiv.appendChild(btn);
        });

        container.appendChild(rowDiv);
      });
    }

    // ==========================================
    // 7. MECÂNICA DE CHUTE DE LETRAS
    // ==========================================
    function handleKeyGuess(key) {
      if (gameOver) return;
      initAudio();

      const normalizedKey = normalizeChar(key);
      if (guessedKeys.includes(normalizedKey)) return;

      guessedKeys.push(normalizedKey);

      const btn = document.getElementById(`key-${key}`);
      if (btn) btn.disabled = true;

      // Verifica se a palavra contém a letra normalizada
      const wordNormalized = [...currentWord].map(c => normalizeChar(c));
      const hasMatch = wordNormalized.includes(normalizedKey);

      if (hasMatch) {
        sfxCorrect();
        if (btn) {
          btn.className = 'key-btn w-7 h-10 sm:w-10 sm:h-12 md:w-11 md:h-13 bg-emerald-500/80 text-white font-black rounded-xl shadow-md border border-emerald-400 text-sm sm:text-base font-arcade flex items-center justify-center';
        }
        renderWordDisplay();

        // No Blitz, adiciona tempo bônus
        if (currentMode === 'blitz') {
          blitzSeconds += 3;
          updateBlitzTimerUI();
        }

        checkVictoryCondition();
      } else {
        sfxWrong();
        if (btn) {
          btn.className = 'key-btn w-7 h-10 sm:w-10 sm:h-12 md:w-11 md:h-13 bg-rose-500/60 text-white/60 font-black rounded-xl shadow-md border border-rose-400/40 text-sm sm:text-base font-arcade flex items-center justify-center';
        }
        wrongCount++;
        updateHearts();
        updateHangmanVisuals();

        // Efeito de shake
        const arena = document.getElementById('wordDisplayContainer');
        arena.classList.add('shake-anim');
        setTimeout(() => arena.classList.remove('shake-anim'), 400);

        checkDefeatCondition();
      }
    }

    // ==========================================
    // 8. CONDIÇÃO DE VITÓRIA E DERROTA
    // ==========================================
    function checkVictoryCondition() {
      const letters = [...currentWord].filter(c => c !== ' ' && c !== '-' && c !== '\'');
      const allGuessed = letters.every(c => guessedKeys.includes(normalizeChar(c)));

      if (allGuessed) {
        gameOver = true;
        sfxWin();
        streak++;
        localStorage.setItem('forca_streak', streak);
        updateStreakUI();
        recordGameStats(true);
        triggerConfetti();

        if (currentMode === 'blitz') {
          blitzWordsSolved++;
          blitzSeconds += 15; // Bônus generoso por completar a palavra!
          setTimeout(() => {
            initGame();
          }, 1200);
          return;
        }

        setTimeout(() => {
          showGameOverModal(true);
        }, 600);
      }
    }

    function checkDefeatCondition() {
      if (wrongCount >= maxErrors) {
        gameOver = true;
        sfxLose();
        streak = 0;
        localStorage.setItem('forca_streak', 0);
        updateStreakUI();
        recordGameStats(false);

        if (blitzTimerInterval) clearInterval(blitzTimerInterval);

        // Revela rosto derrotado no boneco
        document.getElementById('eye-left-normal').style.display = 'none';
        document.getElementById('eye-right-normal').style.display = 'none';
        document.getElementById('eyes-dead').style.display = 'block';
        document.getElementById('mouth-happy').style.display = 'none';
        document.getElementById('mouth-sad').style.display = 'block';

        setTimeout(() => {
          showGameOverModal(false);
        }, 800);
      }
    }

    // ==========================================
    // 9. BONECO SVG DINÂMICO & EXPRESSÕES
    // ==========================================
    function updateHangmanVisuals() {
      // Reseta olhos e boca para estado normal
      document.getElementById('eye-left-normal').style.display = 'block';
      document.getElementById('eye-right-normal').style.display = 'block';
      document.getElementById('eyes-dead').style.display = 'none';
      document.getElementById('mouth-happy').style.display = 'block';
      document.getElementById('mouth-sad').style.display = 'none';
      document.getElementById('part-sweat').style.opacity = '0';

      hangmanParts.forEach((partId, index) => {
        const el = document.getElementById(partId);
        if (el) {
          el.style.opacity = index < wrongCount ? '1' : '0';
        }
      });

      // Olhos e boca aparecem junto com a cabeça
      const eyesEl = document.getElementById('part-eyes');
      const mouthEl = document.getElementById('part-mouth');
      if (eyesEl) eyesEl.style.opacity = wrongCount > 0 ? '1' : '0';
      if (mouthEl) mouthEl.style.opacity = wrongCount > 0 ? '1' : '0';

      // Expressão facial tensa conforme erros aumentam
      if (wrongCount >= 3 && mouthEl) {
        document.getElementById('mouth-happy').style.display = 'none';
        document.getElementById('mouth-sad').style.display = 'block';
      }
      if (wrongCount >= 5) {
        document.getElementById('part-sweat').style.opacity = '1';
      }
    }

    function updateHearts() {
      const livesLeft = Math.max(0, maxErrors - wrongCount);
      const heartsContainer = document.getElementById('heartsIcons');
      const textContainer = document.getElementById('remainingLivesText');

      let heartsStr = '';
      for (let i = 0; i < livesLeft; i++) heartsStr += '❤️';
      for (let i = 0; i < (maxErrors - livesLeft); i++) heartsStr += '🖤';

      heartsContainer.textContent = heartsStr;
      textContainer.textContent = livesLeft;
    }

    function updateStreakUI() {
      document.getElementById('streakCount').textContent = streak;
    }

    // ==========================================
    // 10. DICAS
    // ==========================================
    function useHint() {
      if (hintUsed || gameOver) return;
      initAudio();
      sfxClick();
      hintUsed = true;
      document.getElementById('hintCountBadge').textContent = '0';
      document.getElementById('btnHint').disabled = true;
      document.getElementById('hintText').textContent = currentHint;
      document.getElementById('hintBanner').style.display = 'flex';
    }

    function dismissHint() {
      document.getElementById('hintBanner').style.display = 'none';
    }

    // ==========================================
    // 11. MODAL DE FIM DE JOGO & CURIOSIDADE
    // ==========================================
    function showGameOverModal(isVictory) {
      const modal = document.getElementById('modalGameOver');
      const title = document.getElementById('modalTitle');
      const subtitle = document.getElementById('modalSubtitle');
      const icon = document.getElementById('modalIcon');
      const wordRev = document.getElementById('modalWordRevealed');
      const triviaText = document.getElementById('modalTriviaText');

      wordRev.textContent = currentWord;
      triviaText.textContent = currentTrivia;

      if (isVictory) {
        icon.textContent = '🎉';
        title.textContent = 'Vitória Espetacular!';
        title.className = 'text-2xl sm:text-3xl font-black text-emerald-400 font-arcade';
        subtitle.textContent = `Você acertou o enigma com apenas ${wrongCount} erro(s)!`;
      } else {
        icon.textContent = '💀';
        title.textContent = 'Fim de Jogo!';
        title.className = 'text-2xl sm:text-3xl font-black text-rose-400 font-arcade';
        subtitle.textContent = 'Não desanime! Toda derrota é uma nova palavra aprendida.';
      }

      modal.style.display = 'flex';
    }

    function closeModalGameOver() {
      document.getElementById('modalGameOver').style.display = 'none';
    }

    function shareResult() {
      const dateStr = new Date().toLocaleDateString('pt-BR');
      let squares = '';
      for (let i = 0; i < wrongCount; i++) squares += '🟥';
      const hits = maxErrors - wrongCount;
      for (let i = 0; i < hits; i++) squares += '🟩';

      const text = `🎮 Forca Pro (${currentMode.toUpperCase()}) - ${dateStr}\n` +
                   `Palavra: ${currentWord.length} letras\n` +
                   `Resultado: ${squares} (${maxErrors - wrongCount}/${maxErrors})\n` +
                   `Jogue grátis em: https://4u.ia.br/app/forca/`;

      if (navigator.share) {
        navigator.share({ title: 'Forca Pro 4U', text: text });
      } else {
        navigator.clipboard.writeText(text).then(() => {
          alert('Resultado copiado para a área de transferência! Cole no WhatsApp ou redes sociais.');
        });
      }
    }

    // ==========================================
    // 12. ESTATÍSTICAS E CONQUISTAS (LocalStorage)
    // ==========================================
    function recordGameStats(isWin) {
      let stats = JSON.parse(localStorage.getItem('forca_stats') || '{}');
      stats.played = (stats.played || 0) + 1;
      if (isWin) stats.wins = (stats.wins || 0) + 1;
      else stats.losses = (stats.losses || 0) + 1;
      stats.maxStreak = Math.max(stats.maxStreak || 0, streak);

      if (currentMode === 'blitz') {
        stats.blitzRecord = Math.max(stats.blitzRecord || 0, blitzWordsSolved);
      }

      // Conquistas
      stats.achievements = stats.achievements || {};
      if (isWin && wrongCount === 0) stats.achievements.laser = true;
      if (isWin && wrongCount === (maxErrors - 1)) stats.achievements.clutch = true;
      if (streak >= 5) stats.achievements.fire = true;
      if (isWin && currentMode === 'blitz') stats.achievements.blitz = true;

      localStorage.setItem('forca_stats', JSON.stringify(stats));
    }

    function openStatsModal() {
      initAudio();
      sfxClick();
      const stats = JSON.parse(localStorage.getItem('forca_stats') || '{}');
      const played = stats.played || 0;
      const wins = stats.wins || 0;
      const winRate = played > 0 ? Math.round((wins / played) * 100) : 0;
      const maxStr = stats.maxStreak || 0;
      const blitzRec = stats.blitzRecord || 0;

      document.getElementById('statPlayed').textContent = played;
      document.getElementById('statWinRate').textContent = `${winRate}%`;
      document.getElementById('statMaxStreak').textContent = maxStr;
      document.getElementById('statBlitzRecord').textContent = `${blitzRec} palavras`;

      // Atualiza Badges visuais
      const ach = stats.achievements || {};
      if (ach.laser) document.getElementById('badgeLaser').className = 'p-2.5 rounded-xl border border-emerald-500/40 bg-emerald-500/10 flex items-center gap-3 opacity-100';
      if (ach.clutch) document.getElementById('badgeClutch').className = 'p-2.5 rounded-xl border border-amber-500/40 bg-amber-500/10 flex items-center gap-3 opacity-100';
      if (ach.fire) document.getElementById('badgeFire').className = 'p-2.5 rounded-xl border border-orange-500/40 bg-orange-500/10 flex items-center gap-3 opacity-100';
      if (ach.blitz) document.getElementById('badgeBlitz').className = 'p-2.5 rounded-xl border border-purple-500/40 bg-purple-500/10 flex items-center gap-3 opacity-100';

      document.getElementById('modalStats').style.display = 'flex';
    }

    function closeStatsModal() {
      document.getElementById('modalStats').style.display = 'none';
    }

    // ==========================================
    // 13. MODOS DE JOGO & TABS
    // ==========================================
    function switchMode(mode) {
      initAudio();
      sfxClick();
      currentMode = mode;

      document.querySelectorAll('.mode-tab').forEach(tab => {
        tab.className = 'mode-tab px-3.5 py-1.5 rounded-xl text-xs font-black tracking-wide transition flex items-center gap-1.5 whitespace-nowrap text-white/70 hover:text-white hover:bg-white/10';
      });

      const activeTab = document.getElementById(`tab-${mode}`);
      if (activeTab) {
        activeTab.className = 'mode-tab px-3.5 py-1.5 rounded-xl text-xs font-black tracking-wide transition flex items-center gap-1.5 whitespace-nowrap bg-indigo-600 text-white shadow-md shadow-indigo-600/30';
      }

      const timerEl = document.getElementById('blitzTimerContainer');
      const catBtn = document.getElementById('btnChangeCategory');

      if (mode === 'blitz') {
        timerEl.style.display = 'flex';
        catBtn.style.display = 'none';
        blitzWordsSolved = 0;
        blitzSeconds = 60;
      } else {
        timerEl.style.display = 'none';
        catBtn.style.display = 'inline-block';
        clearInterval(blitzTimerInterval);
      }

      if (mode === 'duelo') {
        openDueloModal();
        return;
      }

      initGame();
    }

    function startBlitzTimer() {
      clearInterval(blitzTimerInterval);
      updateBlitzTimerUI();
      blitzTimerInterval = setInterval(() => {
        blitzSeconds--;
        updateBlitzTimerUI();
        if (blitzSeconds <= 0) {
          clearInterval(blitzTimerInterval);
          gameOver = true;
          sfxLose();
          recordGameStats(false);
          alert(`⏱️ O tempo acabou! Você resolveu ${blitzWordsSolved} palavras no Modo Blitz!`);
          showGameOverModal(false);
        }
      }, 1000);
    }

    function updateBlitzTimerUI() {
      document.getElementById('blitzTimer').textContent = `${blitzSeconds}s`;
    }

    // ==========================================
    // 14. MODAL DUELO (2 JOGADORES)
    // ==========================================
    function openDueloModal() {
      document.getElementById('inputDueloWord').value = '';
      document.getElementById('inputDueloHint').value = '';
      document.getElementById('modalDuelo').style.display = 'flex';
    }

    function closeDueloModal() {
      document.getElementById('modalDuelo').style.display = 'none';
    }

    function togglePasswordVisibility(fieldId, btn) {
      const input = document.getElementById(fieldId);
      if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
      } else {
        input.type = 'password';
        btn.textContent = '👁️';
      }
    }

    function startDueloGame() {
      const word = document.getElementById('inputDueloWord').value.trim();
      const hint = document.getElementById('inputDueloHint').value.trim();

      if (!word || word.length < 2) {
        alert('Por favor, digite uma palavra válida com pelo menos 2 letras!');
        return;
      }

      currentWord = word.toUpperCase();
      currentHint = hint || 'Palavra escolhida no Duelo pelo Jogador 1';
      currentTrivia = `Palavra secreta desafiada pelo Jogador 1: ${currentWord}!`;
      document.getElementById('currentCategoryText').textContent = '👥 Duelo Local';

      closeDueloModal();
      guessedKeys = [];
      wrongCount = 0;
      gameOver = false;
      hintUsed = false;
      dismissHint();
      updateHearts();
      updateHangmanVisuals();
      renderWordDisplay();
      renderKeyboard();
    }

    // ==========================================
    // 15. SELEÇÃO DE CATEGORIAS
    // ==========================================
    function buildCategoryList() {
      const list = document.getElementById('categoryList');
      list.innerHTML = '';

      const allBtn = document.createElement('button');
      allBtn.className = 'w-full text-left p-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-white font-bold text-xs flex items-center justify-between transition';
      allBtn.innerHTML = `<span>🌟 Todas as Categorias</span><span class="text-white/40">Aleatório</span>`;
      allBtn.onclick = () => selectCategory('Todas as Categorias');
      list.appendChild(allBtn);

      for (const [catName, words] of Object.entries(database.categories)) {
        const item = document.createElement('button');
        item.className = 'w-full text-left p-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-white font-bold text-xs flex items-center justify-between transition';
        item.innerHTML = `<span>${catName}</span><span class="text-white/40 text-[10px]">${words.length} palavras</span>`;
        item.onclick = () => selectCategory(catName);
        list.appendChild(item);
      }
    }

    function openCategoryModal() {
      initAudio();
      sfxClick();
      document.getElementById('modalCategory').style.display = 'flex';
    }

    function closeCategoryModal() {
      document.getElementById('modalCategory').style.display = 'none';
    }

    function selectCategory(catName) {
      currentCategory = catName;
      document.getElementById('currentCategoryText').textContent = catName;
      closeCategoryModal();
      initGame();
    }

    // ==========================================
    // 16. DIFICULDADE
    // ==========================================
    function cycleDifficulty() {
      initAudio();
      sfxClick();
      if (difficulty === 'facil') difficulty = 'medio';
      else if (difficulty === 'medio') difficulty = 'dificil';
      else difficulty = 'facil';
      initGame();
    }

    function updateDifficultyUI() {
      const icon = document.getElementById('diffIcon');
      const label = document.getElementById('diffLabel');
      if (difficulty === 'facil') {
        icon.textContent = '🟢';
        label.textContent = 'Fácil (7 vidas)';
      } else if (difficulty === 'medio') {
        icon.textContent = '🟡';
        label.textContent = 'Médio (6 vidas)';
      } else {
        icon.textContent = '🔴';
        label.textContent = 'Difícil (5 vidas)';
      }
    }

    // ==========================================
    // 17. TECLADO FÍSICO
    // ==========================================
    document.addEventListener('keydown', (e) => {
      if (gameOver) return;
      // Não interceptar digitação nos modais
      if (document.getElementById('modalDuelo').style.display === 'flex') return;

      const char = e.key.toUpperCase();
      if (/^[A-ZÇ]$/.test(char)) {
        handleKeyGuess(char);
      }
    });

    // ==========================================
    // 18. EFEITO DE CONFETES
    // ==========================================
    function triggerConfetti() {
      const colors = ['#6366f1', '#a855f7', '#ec4899', '#10b981', '#f59e0b', '#38bdf8'];
      for (let i = 0; i < 40; i++) {
        setTimeout(() => {
          const piece = document.createElement('div');
          piece.className = 'confetti-piece';
          piece.style.left = Math.random() * 100 + 'vw';
          piece.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
          piece.style.animationDuration = (Math.random() * 2 + 1.5) + 's';
          piece.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
          document.body.appendChild(piece);
          setTimeout(() => piece.remove(), 3500);
        }, i * 40);
      }
    }

    // ==========================================
    // 19. PWA INSTALL LOGIC & SERVICE WORKER
    // ==========================================
    let deferredPrompt = null;
    window.addEventListener('beforeinstallprompt', (e) => {
      e.preventDefault();
      deferredPrompt = e;
      const btn = document.getElementById('btnInstallPwa');
      if (btn) btn.style.display = 'flex';
    });

    function installPwa() {
      if (deferredPrompt) {
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then((choiceResult) => {
          if (choiceResult.outcome === 'accepted') {
            document.getElementById('btnInstallPwa').style.display = 'none';
          }
          deferredPrompt = null;
        });
      }
    }

    if ('serviceWorker' in navigator) {
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('sw.js').catch(err => {
          console.log('SW registration error:', err);
        });
      });
    }

    // Inicialização ao carregar
    window.addEventListener('DOMContentLoaded', loadWordsDatabase);
  </script>

</body>
</html>
