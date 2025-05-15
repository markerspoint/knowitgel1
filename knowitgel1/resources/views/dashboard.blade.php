<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - KnowItGel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        html::-webkit-scrollbar {
            display: none;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #fff;
        }

        .row.game-row {
            height: 100%;
            min-height: 320px;
        }

        .game-card {
            height: 100%;
            min-height: 300px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: flex-end;
            justify-content: flex-start;
            padding: 20px;
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .game-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
            z-index: 0;
        }

        .game-card .card-body {
            width: 100%;
            padding: 0;
            position: relative;
            z-index: 1;
        }

        .game-card.computer-parts {
            background-image: url('/images/computer-parts-bg.png');
        }

        .game-card.qa-game {
            background-image: url('/images/qa-game-bg.png');
        }

        .game-card.lesson-game {
            background-image: url('/images/lesson-game-bg.png');
        }

        .col-md-6 {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            color: #fff;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px;
        }

        .card-header h4 {
            color: #fff;
            font-weight: 600;
        }

        .card-body {
            padding: 20px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .game-card {
            transition: transform 0.3s;
            cursor: pointer;
        }

        .game-card:hover {
            transform: translateY(-5px);
        }

        .game-image {
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .nav-link {
            color: #fff;
            font-weight: 500;
            transition: all 0.3s;
        }

        .nav-link:hover {
            color: #fff;
            opacity: 0.8;
        }

        .nav-link.active {
            color: #fff;
            opacity: 1;
        }

        .badge {
            padding: 8px 12px;
            border-radius: 8px;
        }

        .welcome-section {
            text-align: center;
            padding: 40px 0;
            margin-bottom: 30px;
        }

        .welcome-section h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .welcome-section p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* 3D Animation Styles - 2075 Edition */
        .game-animation-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s;
            backdrop-filter: blur(8px);
        }

        .game-animation-container {
            perspective: 1500px;
            width: 300px;
            height: 300px;
            position: relative;
            transform-style: preserve-3d;
        }

        .game-animation-cube {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transform: translateZ(-150px);
            animation: cube-spin-2075 2.5s ease-out forwards;
        }

        @keyframes cube-spin-2075 {
            0% {
                transform: translateZ(-150px) rotateY(0deg) rotateX(0deg) scale(0.8);
                filter: brightness(0.5);
            }

            20% {
                transform: translateZ(-100px) rotateY(180deg) rotateX(180deg) scale(1.1);
                filter: brightness(1.2);
            }

            40% {
                transform: translateZ(-50px) rotateY(360deg) rotateX(360deg) scale(0.9);
                filter: brightness(0.8);
            }

            60% {
                transform: translateZ(0px) rotateY(540deg) rotateX(540deg) scale(1.05);
                filter: brightness(1.5);
            }

            80% {
                transform: translateZ(100px) rotateY(720deg) rotateX(720deg) scale(0.95);
                filter: brightness(1);
            }

            100% {
                transform: translateZ(300px) rotateY(900deg) rotateX(900deg) scale(0);
                filter: brightness(2);
            }
        }

        .cube-face {
            position: absolute;
            width: 300px;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 40px;
            color: white;
            background-size: cover;
            background-position: center;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 30px rgba(102, 126, 234, 0.8);
            overflow: hidden;
            background-blend-mode: overlay;
        }

        .cube-face::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(102, 126, 234, 0.5), rgba(118, 75, 162, 0.5));
            z-index: -1;
        }

        .cube-face::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transform: translateX(-100%);
            animation: holographic-sweep 2s ease-in-out infinite;
        }

        @keyframes holographic-sweep {
            0% {
                transform: translateX(-100%) skewX(-20deg);
            }

            100% {
                transform: translateX(100%) skewX(-20deg);
            }
        }

        .cube-front {
            transform: rotateY(0deg) translateZ(150px);
        }

        .cube-back {
            transform: rotateY(180deg) translateZ(150px);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .cube-right {
            transform: rotateY(90deg) translateZ(150px);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .cube-left {
            transform: rotateY(-90deg) translateZ(150px);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .cube-top {
            transform: rotateX(90deg) translateZ(150px);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .cube-bottom {
            transform: rotateX(-90deg) translateZ(150px);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .particles-container {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 10px;
            height: 10px;
            background: white;
            border-radius: 50%;
            animation: particle-animation-2075 2s ease-out forwards;
            box-shadow: 0 0 10px 2px currentColor;
            filter: blur(1px);
        }

        @keyframes particle-animation-2075 {
            0% {
                transform: translate(0, 0) scale(0) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            50% {
                transform: translate(calc(var(--tx) * 0.5), calc(var(--ty) * 0.5)) scale(1.2) rotate(180deg);
                opacity: 0.8;
            }

            100% {
                transform: translate(var(--tx), var(--ty)) scale(0) rotate(360deg);
                opacity: 0;
            }
        }

        .hologram-grid {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(rgba(102, 126, 234, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(102, 126, 234, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            pointer-events: none;
            opacity: 0.5;
            animation: grid-pulse 4s infinite;
        }

        @keyframes grid-pulse {
            0% {
                opacity: 0.3;
                background-size: 20px 20px;
            }

            50% {
                opacity: 0.6;
                background-size: 25px 25px;
            }

            100% {
                opacity: 0.3;
                background-size: 20px 20px;
            }
        }

        .loading-text {
            position: absolute;
            bottom: 20%;
            left: 0;
            width: 100%;
            text-align: center;
            font-family: 'Arial', sans-serif;
            font-size: 18px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 3px;
            opacity: 0;
            animation: text-fade 2.5s ease-in-out forwards;
        }

        @keyframes text-fade {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            20% {
                opacity: 1;
                transform: translateY(0);
            }

            80% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        .digital-circuit {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/images/circuit-pattern.png');
            background-size: cover;
            opacity: 0.15;
            mix-blend-mode: screen;
            pointer-events: none;
        }

        .energy-ring {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            border: 4px solid transparent;
            border-top: 4px solid rgba(102, 126, 234, 0.8);
            border-right: 4px solid rgba(118, 75, 162, 0.8);
            animation: ring-spin 3s linear infinite;
        }

        .energy-ring:nth-child(2) {
            width: 350px;
            height: 350px;
            animation-duration: 2s;
            animation-direction: reverse;
            border-top: 4px solid rgba(118, 75, 162, 0.8);
            border-left: 4px solid rgba(102, 126, 234, 0.8);
        }

        .energy-ring:nth-child(3) {
            width: 450px;
            height: 450px;
            animation-duration: 4s;
            border-bottom: 4px solid rgba(102, 126, 234, 0.8);
            border-left: 4px solid rgba(118, 75, 162, 0.8);
        }

        @keyframes ring-spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <!-- Futuristic 2075 Background Animation -->
    <div class="bg-animation-container">
        <div class="bg-grid"></div>
        <div class="cyber-circuit"></div>
        <div class="bg-particles" id="bgParticles"></div>
        <div class="holographic-sphere" style="top: 20%; left: 10%;"></div>
        <div class="holographic-sphere" style="bottom: 30%; right: 15%;"></div>
    </div>

    <!-- Animation Overlay - 2075 Edition -->
    <div class="game-animation-overlay" id="gameAnimationOverlay">
        <div class="hologram-grid"></div>
        <div class="digital-circuit"></div>

        <div class="energy-ring"></div>
        <div class="energy-ring"></div>
        <div class="energy-ring"></div>

        <div class="game-animation-container">
            <div class="game-animation-cube" id="gameAnimationCube">
                <div class="cube-face cube-front" id="cubeFront"></div>
                <div class="cube-face cube-back"></div>
                <div class="cube-face cube-right"></div>
                <div class="cube-face cube-left"></div>
                <div class="cube-face cube-top"></div>
                <div class="cube-face cube-bottom"></div>
            </div>
        </div>

        <div class="particles-container" id="particlesContainer"></div>
        <div class="loading-text" id="loadingText">Initializing Neural Interface</div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-gamepad me-2"></i>KnowItGel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-trophy me-1"></i>Leaderboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.history') }}">
                            <i class="fas fa-history me-1"></i>History
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="text-light me-3">
                        <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->fname }} {{ Auth::user()->lname }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-section">
            <h1>Welcome, {{ Auth::user()->fname }}!</h1>
            <p>Ready to test your knowledge about computer parts?</p>
        </div>

        <div class="row game-row">
            <div class="col-md-4 mb-4">
                <div class="card game-card computer-parts">
                    <div class="card-body text-white">
                        <h5 class="card-title">Guess the Computer Parts</h5>
                        <p class="card-text">Test your knowledge about computer hardware components!</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('computer.parts') }}" class="btn btn-primary play-now-btn" data-game-type="computer-parts" data-game-title="Computer Parts">
                                <i class="fas fa-play me-1"></i>Play Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card game-card qa-game">
                    <div class="card-body text-white">
                        <h5 class="card-title">Q&A Game</h5>
                        <p class="card-text">Answer questions about computer parts and technology!</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('qa.game') }}" class="btn btn-primary play-now-btn" data-game-type="qa-game" data-game-title="Q&A Game">
                                <i class="fas fa-play me-1"></i>Play Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card game-card lesson-game">
                    <div class="card-body text-white">
                        <h5 class="card-title">KnowItGel Lessons</h5>
                        <p class="card-text">Learn about computer parts through interactive lessons!</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('lesson.game') }}" class="btn btn-primary play-now-btn" data-game-type="lesson-game" data-game-title="KnowItGel Lessons">
                                <i class="fas fa-play me-1"></i>Learn Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-trophy fa-3x mb-3"></i>
                        <h4>Your Total Score</h4>
                        <h2>{{ Auth::user()->scores->sum('score') ?? 0 }}</h2>
                        <p class="text-muted">{{ Auth::user()->scores->count() > 0 ? 'Keep playing to improve!' : 'Start playing to earn points!' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-gamepad fa-3x mb-3"></i>
                        <h4>Games Played</h4>
                        <h2>{{ Auth::user()->scores->count() ?? 0 }}</h2>
                        <p class="text-muted">{{ Auth::user()->scores->count() > 0 ? 'Keep playing to improve!' : 'Start playing to earn points!' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-book fa-3x mb-3"></i>
                        <h4>Lessons Completed</h4>
                        <h2>{{ Auth::user()->completedLessons->count() ?? 0 }}</h2>
                        <p class="text-muted">{{ Auth::user()->completedLessons->count() > 0 ? 'Great progress!' : 'Complete lessons to learn more!' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('loadingOverlay2075');
            if (overlay) {
                overlay.style.opacity = '0';
                setTimeout(() => overlay.remove(), 500);
            }
            const playButtons = document.querySelectorAll('.play-now-btn');
            const overlay = document.getElementById('gameAnimationOverlay');
            const cube = document.getElementById('gameAnimationCube');
            const cubeFront = document.getElementById('cubeFront');
            const particlesContainer = document.getElementById('particlesContainer');
            const loadingText = document.getElementById('loadingText');
            const bgParticles = document.getElementById('bgParticles');
            const bgParticles = document.getElementById('bgParticles');

            createBackgroundElements();

            createBackgroundParticles();

            const gameBackgrounds = {
                'computer-parts': '/images/computer-parts-bg.png',
                'qa-game': '/images/qa-game-bg.png',
                'lesson-game': '/images/lesson-game-bg.png'
            };

            const loadingTexts = {
                'computer-parts': 'Initializing Hardware Recognition',
                'qa-game': 'Loading Knowledge Database',
                'lesson-game': 'Preparing Neural Learning Interface'
            };

            playButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const gameType = this.getAttribute('data-game-type');
                    const gameTitle = this.getAttribute('data-game-title');
                    const targetUrl = this.getAttribute('href');

                    cubeFront.style.backgroundImage = `url('${gameBackgrounds[gameType]}')`;
                    cubeFront.innerHTML = `<div style="background: rgba(0,0,0,0.5); padding: 20px; border-radius: 10px; backdrop-filter: blur(5px); border: 1px solid rgba(102, 126, 234, 0.5); box-shadow: 0 0 20px rgba(102, 126, 234, 0.8);">${gameTitle}</div>`;

                    loadingText.textContent = loadingTexts[gameType];

                    overlay.style.opacity = '1';
                    overlay.style.visibility = 'visible';

                    createFuturisticParticles();

                    setTimeout(() => {
                        window.location.href = targetUrl;
                    }, 2500);
                });
            });

            function createBackgroundParticles() {
                for (let i = 0; i < 50; i++) {
                    const particle = document.createElement('div');
                    particle.classList.add('particle');

                    const size = Math.random() * 4 + 2;
                    particle.style.width = `${size}px`;
                    particle.style.height = `${size}px`;

                    const posX = Math.random() * 100;
                    const posY = Math.random() * 100;
                    particle.style.left = `${posX}%`;
                    particle.style.top = `${posY}%`;

                    const colors = [
                        'rgba(0, 255, 255, 0.7)',
                        'rgba(102, 126, 234, 0.7)',
                        'rgba(118, 75, 162, 0.7)',
                        'rgba(255, 255, 255, 0.7)'
                    ];
                    const color = colors[Math.floor(Math.random() * colors.length)];
                    particle.style.backgroundColor = color;
                    particle.style.boxShadow = `0 0 ${size * 2}px ${color}`;

                    const duration = Math.random() * 20 + 10;
                    const delay = Math.random() * 10;
                    particle.style.animation = `float-particle ${duration}s linear ${delay}s infinite`;

                    bgParticles.appendChild(particle);
                }
            }

            const style = document.createElement('style');
            style.textContent = `
                @keyframes float-particle {
                    0% { transform: translate(0, 0) rotate(0deg); opacity: 0; }
                    10% { opacity: 0.8; }
                    90% { opacity: 0.8; }
                    100% { transform: translate(${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px, ${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px) rotate(360deg); opacity: 0; }
                }
                
                .bg-particles {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    pointer-events: none;
                }
                
                .particle {
                    position: absolute;
                    border-radius: 50%;
                    filter: blur(1px);
                }
            `;
            document.head.appendChild(style);

            function createFuturisticParticles() {
                particlesContainer.innerHTML = '';

                for (let i = 0; i < 100; i++) {
                    const particle = document.createElement('div');
                    particle.classList.add('particle');

                    const x = Math.random() * 300 - 150;
                    const y = Math.random() * 300 - 150;

                    const colors = [
                        '#667eea', '#764ba2', '#63b3ed', '#7f9cf5', '#b794f4',
                        '#00ffff', '#ff00ff', '#00ff99', '#3366ff', '#ff3366'
                    ];
                    const color = colors[Math.floor(Math.random() * colors.length)];

                    const size = Math.random() * 12 + 3;

                    const tx = (Math.random() - 0.5) * window.innerWidth * 1.5;
                    const ty = (Math.random() - 0.5) * window.innerHeight * 1.5;

                    particle.style.left = '50%';
                    particle.style.top = '50%';
                    particle.style.transform = `translate(${x}px, ${y}px)`;
                    particle.style.backgroundColor = color;
                    particle.style.color = color;
                    particle.style.width = `${size}px`;
                    particle.style.height = `${size}px`;
                    particle.style.setProperty('--tx', `${tx}px`);
                    particle.style.setProperty('--ty', `${ty}px`);

                    particle.style.animationDelay = `${Math.random() * 0.8}s`;

                    particlesContainer.appendChild(particle);
                }
            }

            function playFuturisticSound() {
                try {
                    const AudioContext = window.AudioContext || window.webkitAudioContext;
                    const audioCtx = new AudioContext();

                    const oscillator = audioCtx.createOscillator();
                    const gainNode = audioCtx.createGain();

                    oscillator.type = 'sine';
                    oscillator.frequency.setValueAtTime(880, audioCtx.currentTime);
                    oscillator.frequency.exponentialRampToValueAtTime(220, audioCtx.currentTime + 1.5);

                    gainNode.gain.setValueAtTime(0, audioCtx.currentTime);
                    gainNode.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.1);
                    gainNode.gain.linearRampToValueAtTime(0, audioCtx.currentTime + 2);

                    oscillator.connect(gainNode);
                    gainNode.connect(audioCtx.destination);

                    oscillator.start();
                    oscillator.stop(audioCtx.currentTime + 2);

                    setTimeout(() => {
                        const oscillator2 = audioCtx.createOscillator();
                        const gainNode2 = audioCtx.createGain();

                        oscillator2.type = 'sawtooth';
                        oscillator2.frequency.setValueAtTime(440, audioCtx.currentTime);
                        oscillator2.frequency.exponentialRampToValueAtTime(880, audioCtx.currentTime + 0.5);

                        gainNode2.gain.setValueAtTime(0, audioCtx.currentTime);
                        gainNode2.gain.linearRampToValueAtTime(0.1, audioCtx.currentTime + 0.1);
                        gainNode2.gain.linearRampToValueAtTime(0, audioCtx.currentTime + 1);

                        oscillator2.connect(gainNode2);
                        gainNode2.connect(audioCtx.destination);

                        oscillator2.start();
                        oscillator2.stop(audioCtx.currentTime + 1);
                    }, 500);

                } catch (e) {
                    console.log('Web Audio API not supported or user interaction required');
                }
            }
        });
    </script>
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const playButtons = document.querySelectorAll('.play-now-btn');
        const overlay = document.getElementById('gameAnimationOverlay');
        const cube = document.getElementById('gameAnimationCube');
        const cubeFront = document.getElementById('cubeFront');
        const particlesContainer = document.getElementById('particlesContainer');
        const loadingText = document.getElementById('loadingText');

        createBackgroundParticles();

        const gameBackgrounds = {
            'computer-parts': '/images/computer-parts-bg.png',
            'qa-game': '/images/qa-game-bg.png',
            'lesson-game': '/images/lesson-game-bg.png'
        };

        const loadingTexts = {
            'computer-parts': 'Initializing Hardware Recognition',
            'qa-game': 'Loading Knowledge Database',
            'lesson-game': 'Preparing Neural Learning Interface'
        };

        playButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const gameType = this.getAttribute('data-game-type');
                const gameTitle = this.getAttribute('data-game-title');
                const targetUrl = this.getAttribute('href');

                cubeFront.style.backgroundImage = `url('${gameBackgrounds[gameType]}')`;
                cubeFront.innerHTML = `<div style="background: rgba(0,0,0,0.5); padding: 20px; border-radius: 10px; backdrop-filter: blur(5px); border: 1px solid rgba(102, 126, 234, 0.5); box-shadow: 0 0 20px rgba(102, 126, 234, 0.8);">${gameTitle}</div>`;

                loadingText.textContent = loadingTexts[gameType];

                overlay.style.opacity = '1';
                overlay.style.visibility = 'visible';

                createFuturisticParticles();


                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 2500);
            });
        });

        function createBackgroundParticles() {
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                const size = Math.random() * 4 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;

                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;

                const colors = [
                    'rgba(0, 255, 255, 0.7)',
                    'rgba(102, 126, 234, 0.7)',
                    'rgba(118, 75, 162, 0.7)',
                    'rgba(255, 255, 255, 0.7)'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.backgroundColor = color;
                particle.style.boxShadow = `0 0 ${size * 2}px ${color}`;

                const duration = Math.random() * 20 + 10;
                const delay = Math.random() * 10;
                particle.style.animation = `float-particle ${duration}s linear ${delay}s infinite`;

                bgParticles.appendChild(particle);
            }
        }

        const style = document.createElement('style');
        style.textContent = `
                @keyframes float-particle {
                    0% { transform: translate(0, 0) rotate(0deg); opacity: 0; }
                    10% { opacity: 0.8; }
                    90% { opacity: 0.8; }
                    100% { transform: translate(${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px, ${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px) rotate(360deg); opacity: 0; }
                }
                
                .bg-particles {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    pointer-events: none;
                }
                
                .particle {
                    position: absolute;
                    border-radius: 50%;
                    filter: blur(1px);
                }
            `;
        document.head.appendChild(style);

        function createFuturisticParticles() {
            particlesContainer.innerHTML = '';

            for (let i = 0; i < 100; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                const x = Math.random() * 300 - 150;
                const y = Math.random() * 300 - 150;

                const colors = [
                    '#667eea', '#764ba2', '#63b3ed', '#7f9cf5', '#b794f4',
                    '#00ffff', '#ff00ff', '#00ff99', '#3366ff', '#ff3366'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];

                const size = Math.random() * 12 + 3;

                const tx = (Math.random() - 0.5) * window.innerWidth * 1.5;
                const ty = (Math.random() - 0.5) * window.innerHeight * 1.5;

                particle.style.left = '50%';
                particle.style.top = '50%';
                particle.style.transform = `translate(${x}px, ${y}px)`;
                particle.style.backgroundColor = color;
                particle.style.color = color;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.setProperty('--tx', `${tx}px`);
                particle.style.setProperty('--ty', `${ty}px`);

                particle.style.animationDelay = `${Math.random() * 0.8}s`;

                particlesContainer.appendChild(particle);
            }
        }

        function playFuturisticSound() {
            try {
                const AudioContext = window.AudioContext || window.webkitAudioContext;
                const audioCtx = new AudioContext();

                const oscillator = audioCtx.createOscillator();
                const gainNode = audioCtx.createGain();

                oscillator.type = 'sine';
                oscillator.frequency.setValueAtTime(880, audioCtx.currentTime);
                oscillator.frequency.exponentialRampToValueAtTime(220, audioCtx.currentTime + 1.5);

                gainNode.gain.setValueAtTime(0, audioCtx.currentTime);
                gainNode.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.1);
                gainNode.gain.linearRampToValueAtTime(0, audioCtx.currentTime + 2);

                oscillator.connect(gainNode);
                gainNode.connect(audioCtx.destination);

                oscillator.start();
                oscillator.stop(audioCtx.currentTime + 2);

                setTimeout(() => {
                    const oscillator2 = audioCtx.createOscillator();
                    const gainNode2 = audioCtx.createGain();

                    oscillator2.type = 'sawtooth';
                    oscillator2.frequency.setValueAtTime(440, audioCtx.currentTime);
                    oscillator2.frequency.exponentialRampToValueAtTime(880, audioCtx.currentTime + 0.5);

                    gainNode2.gain.setValueAtTime(0, audioCtx.currentTime);
                    gainNode2.gain.linearRampToValueAtTime(0.1, audioCtx.currentTime + 0.1);
                    gainNode2.gain.linearRampToValueAtTime(0, audioCtx.currentTime + 1);

                    oscillator2.connect(gainNode2);
                    gainNode2.connect(audioCtx.destination);

                    oscillator2.start();
                    oscillator2.stop(audioCtx.currentTime + 1);
                }, 500);

            } catch (e) {
                console.log('Web Audio API not supported or user interaction required');
            }
        }
    });
</script>
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const playButtons = document.querySelectorAll('.play-now-btn');
        const overlay = document.getElementById('gameAnimationOverlay');
        const cube = document.getElementById('gameAnimationCube');
        const cubeFront = document.getElementById('cubeFront');
        const particlesContainer = document.getElementById('particlesContainer');
        const loadingText = document.getElementById('loadingText');

        createBackgroundParticles();

        const gameBackgrounds = {
            'computer-parts': '/images/computer-parts-bg.png',
            'qa-game': '/images/qa-game-bg.png',
            'lesson-game': '/images/lesson-game-bg.png'
        };

        const loadingTexts = {
            'computer-parts': 'Initializing Hardware Recognition',
            'qa-game': 'Loading Knowledge Database',
            'lesson-game': 'Preparing Neural Learning Interface'
        };

        playButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const gameType = this.getAttribute('data-game-type');
                const gameTitle = this.getAttribute('data-game-title');
                const targetUrl = this.getAttribute('href');

                cubeFront.style.backgroundImage = `url('${gameBackgrounds[gameType]}')`;
                cubeFront.innerHTML = `<div style="background: rgba(0,0,0,0.5); padding: 20px; border-radius: 10px; backdrop-filter: blur(5px); border: 1px solid rgba(102, 126, 234, 0.5); box-shadow: 0 0 20px rgba(102, 126, 234, 0.8);">${gameTitle}</div>`;

                loadingText.textContent = loadingTexts[gameType];

                overlay.style.opacity = '1';
                overlay.style.visibility = 'visible';

                createFuturisticParticles();

                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 2500);
            });
        });

        function createBackgroundParticles() {
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                const size = Math.random() * 4 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;

                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;

                const colors = [
                    'rgba(0, 255, 255, 0.7)',
                    'rgba(102, 126, 234, 0.7)',
                    'rgba(118, 75, 162, 0.7)',
                    'rgba(255, 255, 255, 0.7)'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.backgroundColor = color;
                particle.style.boxShadow = `0 0 ${size * 2}px ${color}`;

                const duration = Math.random() * 20 + 10;
                const delay = Math.random() * 10;
                particle.style.animation = `float-particle ${duration}s linear ${delay}s infinite`;

                bgParticles.appendChild(particle);
            }
        }

        const style = document.createElement('style');
        style.textContent = `
                @keyframes float-particle {
                    0% { transform: translate(0, 0) rotate(0deg); opacity: 0; }
                    10% { opacity: 0.8; }
                    90% { opacity: 0.8; }
                    100% { transform: translate(${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px, ${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px) rotate(360deg); opacity: 0; }
                }
                
                .bg-particles {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    pointer-events: none;
                }
                
                .particle {
                    position: absolute;
                    border-radius: 50%;
                    filter: blur(1px);
                }
            `;
        document.head.appendChild(style);

        function createFuturisticParticles() {
            particlesContainer.innerHTML = '';

            for (let i = 0; i < 100; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                const x = Math.random() * 300 - 150;
                const y = Math.random() * 300 - 150;

                const colors = [
                    '#667eea', '#764ba2', '#63b3ed', '#7f9cf5', '#b794f4',
                    '#00ffff', '#ff00ff', '#00ff99', '#3366ff', '#ff3366'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];

                const size = Math.random() * 12 + 3;

                const tx = (Math.random() - 0.5) * window.innerWidth * 1.5;
                const ty = (Math.random() - 0.5) * window.innerHeight * 1.5;

                particle.style.left = '50%';
                particle.style.top = '50%';
                particle.style.transform = `translate(${x}px, ${y}px)`;
                particle.style.backgroundColor = color;
                particle.style.color = color;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.setProperty('--tx', `${tx}px`);
                particle.style.setProperty('--ty', `${ty}px`);


                particle.style.animationDelay = `${Math.random() * 0.8}s`;

                particlesContainer.appendChild(particle);
            }
        }
    });
</script>
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const playButtons = document.querySelectorAll('.play-now-btn');
        const overlay = document.getElementById('gameAnimationOverlay');
        const cube = document.getElementById('gameAnimationCube');
        const cubeFront = document.getElementById('cubeFront');
        const particlesContainer = document.getElementById('particlesContainer');
        const loadingText = document.getElementById('loadingText');


        createBackgroundParticles();


        const gameBackgrounds = {
            'computer-parts': '/images/computer-parts-bg.png',
            'qa-game': '/images/qa-game-bg.png',
            'lesson-game': '/images/lesson-game-bg.png'
        };


        const loadingTexts = {
            'computer-parts': 'Initializing Hardware Recognition',
            'qa-game': 'Loading Knowledge Database',
            'lesson-game': 'Preparing Neural Learning Interface'
        };

        playButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const gameType = this.getAttribute('data-game-type');
                const gameTitle = this.getAttribute('data-game-title');
                const targetUrl = this.getAttribute('href');


                cubeFront.style.backgroundImage = `url('${gameBackgrounds[gameType]}')`;
                cubeFront.innerHTML = `<div style="background: rgba(0,0,0,0.5); padding: 20px; border-radius: 10px; backdrop-filter: blur(5px); border: 1px solid rgba(102, 126, 234, 0.5); box-shadow: 0 0 20px rgba(102, 126, 234, 0.8);">${gameTitle}</div>`;


                loadingText.textContent = loadingTexts[gameType];

                overlay.style.opacity = '1';
                overlay.style.visibility = 'visible';


                createFuturisticParticles();



                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 2500);
            });
        });

        function createBackgroundParticles() {
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');


                const size = Math.random() * 4 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;


                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;


                const colors = [
                    'rgba(0, 255, 255, 0.7)',
                    'rgba(102, 126, 234, 0.7)',
                    'rgba(118, 75, 162, 0.7)',
                    'rgba(255, 255, 255, 0.7)'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.backgroundColor = color;
                particle.style.boxShadow = `0 0 ${size * 2}px ${color}`;


                const duration = Math.random() * 20 + 10;
                const delay = Math.random() * 10;
                particle.style.animation = `float-particle ${duration}s linear ${delay}s infinite`;

                bgParticles.appendChild(particle);
            }
        }


        const style = document.createElement('style');
        style.textContent = `
                @keyframes float-particle {
                    0% { transform: translate(0, 0) rotate(0deg); opacity: 0; }
                    10% { opacity: 0.8; }
                    90% { opacity: 0.8; }
                    100% { transform: translate(${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px, ${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px) rotate(360deg); opacity: 0; }
                }
                
                .bg-particles {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    pointer-events: none;
                }
                
                .particle {
                    position: absolute;
                    border-radius: 50%;
                    filter: blur(1px);
                }
            `;
        document.head.appendChild(style);

        function createFuturisticParticles() {

            particlesContainer.innerHTML = '';


            for (let i = 0; i < 100; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');


                const x = Math.random() * 300 - 150;
                const y = Math.random() * 300 - 150;


                const colors = [
                    '#667eea', '#764ba2', '#63b3ed', '#7f9cf5', '#b794f4',
                    '#00ffff', '#ff00ff', '#00ff99', '#3366ff', '#ff3366'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];


                const size = Math.random() * 12 + 3;


                const tx = (Math.random() - 0.5) * window.innerWidth * 1.5;
                const ty = (Math.random() - 0.5) * window.innerHeight * 1.5;


                particle.style.left = '50%';
                particle.style.top = '50%';
                particle.style.transform = `translate(${x}px, ${y}px)`;
                particle.style.backgroundColor = color;
                particle.style.color = color;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.setProperty('--tx', `${tx}px`);
                particle.style.setProperty('--ty', `${ty}px`);


                particle.style.animationDelay = `${Math.random() * 0.8}s`;

                particlesContainer.appendChild(particle);
            }
        }
    });
</script>
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const playButtons = document.querySelectorAll('.play-now-btn');
        const overlay = document.getElementById('gameAnimationOverlay');
        const cube = document.getElementById('gameAnimationCube');
        const cubeFront = document.getElementById('cubeFront');
        const particlesContainer = document.getElementById('particlesContainer');
        const loadingText = document.getElementById('loadingText');


        createBackgroundParticles();


        const gameBackgrounds = {
            'computer-parts': '/images/computer-parts-bg.png',
            'qa-game': '/images/qa-game-bg.png',
            'lesson-game': '/images/lesson-game-bg.png'
        };


        const loadingTexts = {
            'computer-parts': 'Initializing Hardware Recognition',
            'qa-game': 'Loading Knowledge Database',
            'lesson-game': 'Preparing Neural Learning Interface'
        };

        playButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const gameType = this.getAttribute('data-game-type');
                const gameTitle = this.getAttribute('data-game-title');
                const targetUrl = this.getAttribute('href');


                cubeFront.style.backgroundImage = `url('${gameBackgrounds[gameType]}')`;
                cubeFront.innerHTML = `<div style="background: rgba(0,0,0,0.5); padding: 20px; border-radius: 10px; backdrop-filter: blur(5px); border: 1px solid rgba(102, 126, 234, 0.5); box-shadow: 0 0 20px rgba(102, 126, 234, 0.8);">${gameTitle}</div>`;


                loadingText.textContent = loadingTexts[gameType];


                overlay.style.opacity = '1';
                overlay.style.visibility = 'visible';


                createFuturisticParticles();



                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 2500);
            });
        });

        function createBackgroundParticles() {
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');


                const size = Math.random() * 4 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;


                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;


                const colors = [
                    'rgba(0, 255, 255, 0.7)',
                    'rgba(102, 126, 234, 0.7)',
                    'rgba(118, 75, 162, 0.7)',
                    'rgba(255, 255, 255, 0.7)'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.backgroundColor = color;
                particle.style.boxShadow = `0 0 ${size * 2}px ${color}`;


                const duration = Math.random() * 20 + 10;
                const delay = Math.random() * 10;
                particle.style.animation = `float-particle ${duration}s linear ${delay}s infinite`;

                bgParticles.appendChild(particle);
            }
        }


        const style = document.createElement('style');
        style.textContent = `
                @keyframes float-particle {
                    0% { transform: translate(0, 0) rotate(0deg); opacity: 0; }
                    10% { opacity: 0.8; }
                    90% { opacity: 0.8; }
                    100% { transform: translate(${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px, ${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px) rotate(360deg); opacity: 0; }
                }
                
                .bg-particles {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    pointer-events: none;
                }
                
                .particle {
                    position: absolute;
                    border-radius: 50%;
                    filter: blur(1px);
                }
            `;
        document.head.appendChild(style);

        function createFuturisticParticles() {

            particlesContainer.innerHTML = '';


            for (let i = 0; i < 100; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');


                const x = Math.random() * 300 - 150;
                const y = Math.random() * 300 - 150;


                const colors = [
                    '#667eea', '#764ba2', '#63b3ed', '#7f9cf5', '#b794f4',
                    '#00ffff', '#ff00ff', '#00ff99', '#3366ff', '#ff3366'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];


                const size = Math.random() * 12 + 3;


                const tx = (Math.random() - 0.5) * window.innerWidth * 1.5;
                const ty = (Math.random() - 0.5) * window.innerHeight * 1.5;


                particle.style.left = '50%';
                particle.style.top = '50%';
                particle.style.transform = `translate(${x}px, ${y}px)`;
                particle.style.backgroundColor = color;
                particle.style.color = color;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.setProperty('--tx', `${tx}px`);
                particle.style.setProperty('--ty', `${ty}px`);


                particle.style.animationDelay = `${Math.random() * 0.8}s`;

                particlesContainer.appendChild(particle);
            }
        }
    });
</script>
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const playButtons = document.querySelectorAll('.play-now-btn');
        const overlay = document.getElementById('gameAnimationOverlay');
        const cube = document.getElementById('gameAnimationCube');
        const cubeFront = document.getElementById('cubeFront');
        const particlesContainer = document.getElementById('particlesContainer');
        const loadingText = document.getElementById('loadingText');


        createBackgroundParticles();


        const gameBackgrounds = {
            'computer-parts': '/images/computer-parts-bg.png',
            'qa-game': '/images/qa-game-bg.png',
            'lesson-game': '/images/lesson-game-bg.png'
        };


        const loadingTexts = {
            'computer-parts': 'Initializing Hardware Recognition',
            'qa-game': 'Loading Knowledge Database',
            'lesson-game': 'Preparing Neural Learning Interface'
        };

        playButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const gameType = this.getAttribute('data-game-type');
                const gameTitle = this.getAttribute('data-game-title');
                const targetUrl = this.getAttribute('href');


                cubeFront.style.backgroundImage = `url('${gameBackgrounds[gameType]}')`;
                cubeFront.innerHTML = `<div style="background: rgba(0,0,0,0.5); padding: 20px; border-radius: 10px; backdrop-filter: blur(5px); border: 1px solid rgba(102, 126, 234, 0.5); box-shadow: 0 0 20px rgba(102, 126, 234, 0.8);">${gameTitle}</div>`;


                loadingText.textContent = loadingTexts[gameType];


                overlay.style.opacity = '1';
                overlay.style.visibility = 'visible';


                createFuturisticParticles();



                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 2500);
            });
        });

        function createBackgroundParticles() {
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');


                const size = Math.random() * 4 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;


                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;


                const colors = [
                    'rgba(0, 255, 255, 0.7)',
                    'rgba(102, 126, 234, 0.7)',
                    'rgba(118, 75, 162, 0.7)',
                    'rgba(255, 255, 255, 0.7)'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.backgroundColor = color;
                particle.style.boxShadow = `0 0 ${size * 2}px ${color}`;


                const duration = Math.random() * 20 + 10;
                const delay = Math.random() * 10;
                particle.style.animation = `float-particle ${duration}s linear ${delay}s infinite`;

                bgParticles.appendChild(particle);
            }
        }


        const style = document.createElement('style');
        style.textContent = `
                @keyframes float-particle {
                    0% { transform: translate(0, 0) rotate(0deg); opacity: 0; }
                    10% { opacity: 0.8; }
                    90% { opacity: 0.8; }
                    100% { transform: translate(${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px, ${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px) rotate(360deg); opacity: 0; }
                }
                
                .bg-particles {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    pointer-events: none;
                }
                
                .particle {
                    position: absolute;
                    border-radius: 50%;
                    filter: blur(1px);
                }
            `;
        document.head.appendChild(style);

        function createFuturisticParticles() {

            particlesContainer.innerHTML = '';


            for (let i = 0; i < 100; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');


                const x = Math.random() * 300 - 150;
                const y = Math.random() * 300 - 150;


                const colors = [
                    '#667eea', '#764ba2', '#63b3ed', '#7f9cf5', '#b794f4',
                    '#00ffff', '#ff00ff', '#00ff99', '#3366ff', '#ff3366'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];


                const size = Math.random() * 12 + 3;


                const tx = (Math.random() - 0.5) * window.innerWidth * 1.5;
                const ty = (Math.random() - 0.5) * window.innerHeight * 1.5;


                particle.style.left = '50%';
                particle.style.top = '50%';
                particle.style.transform = `translate(${x}px, ${y}px)`;
                particle.style.backgroundColor = color;
                particle.style.color = color;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.setProperty('--tx', `${tx}px`);
                particle.style.setProperty('--ty', `${ty}px`);


                particle.style.animationDelay = `${Math.random() * 0.8}s`;

                particlesContainer.appendChild(particle);
            }
        }
    });
</script>
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const playButtons = document.querySelectorAll('.play-now-btn');
        const overlay = document.getElementById('gameAnimationOverlay');
        const cube = document.getElementById('gameAnimationCube');
        const cubeFront = document.getElementById('cubeFront');
        const particlesContainer = document.getElementById('particlesContainer');
        const loadingText = document.getElementById('loadingText');


        createBackgroundParticles();


        const gameBackgrounds = {
            'computer-parts': '/images/computer-parts-bg.png',
            'qa-game': '/images/qa-game-bg.png',
            'lesson-game': '/images/lesson-game-bg.png'
        };


        const loadingTexts = {
            'computer-parts': 'Initializing Hardware Recognition',
            'qa-game': 'Loading Knowledge Database',
            'lesson-game': 'Preparing Neural Learning Interface'
        };

        playButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const gameType = this.getAttribute('data-game-type');
                const gameTitle = this.getAttribute('data-game-title');
                const targetUrl = this.getAttribute('href');


                cubeFront.style.backgroundImage = `url('${gameBackgrounds[gameType]}')`;
                cubeFront.innerHTML = `<div style="background: rgba(0,0,0,0.5); padding: 20px; border-radius: 10px; backdrop-filter: blur(5px); border: 1px solid rgba(102, 126, 234, 0.5); box-shadow: 0 0 20px rgba(102, 126, 234, 0.8);">${gameTitle}</div>`;


                loadingText.textContent = loadingTexts[gameType];


                overlay.style.opacity = '1';
                overlay.style.visibility = 'visible';


                createFuturisticParticles();



                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 2500);
            });
        });

        function createBackgroundParticles() {
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');


                const size = Math.random() * 4 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;


                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;


                const colors = [
                    'rgba(0, 255, 255, 0.7)',
                    'rgba(102, 126, 234, 0.7)',
                    'rgba(118, 75, 162, 0.7)',
                    'rgba(255, 255, 255, 0.7)'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.backgroundColor = color;
                particle.style.boxShadow = `0 0 ${size * 2}px ${color}`;


                const duration = Math.random() * 20 + 10;
                const delay = Math.random() * 10;
                particle.style.animation = `float-particle ${duration}s linear ${delay}s infinite`;

                bgParticles.appendChild(particle);
            }
        }


        const style = document.createElement('style');
        style.textContent = `
                @keyframes float-particle {
                    0% { transform: translate(0, 0) rotate(0deg); opacity: 0; }
                    10% { opacity: 0.8; }
                    90% { opacity: 0.8; }
                    100% { transform: translate(${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px, ${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px) rotate(360deg); opacity: 0; }
                }
                
                .bg-particles {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    pointer-events: none;
                }
                
                .particle {
                    position: absolute;
                    border-radius: 50%;
                    filter: blur(1px);
                }
            `;
        document.head.appendChild(style);

        function createFuturisticParticles() {

            particlesContainer.innerHTML = '';


            for (let i = 0; i < 100; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');


                const x = Math.random() * 300 - 150;
                const y = Math.random() * 300 - 150;


                const colors = [
                    '#667eea', '#764ba2', '#63b3ed', '#7f9cf5', '#b794f4',
                    '#00ffff', '#ff00ff', '#00ff99', '#3366ff', '#ff3366'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];


                const size = Math.random() * 12 + 3;


                const tx = (Math.random() - 0.5) * window.innerWidth * 1.5;
                const ty = (Math.random() - 0.5) * window.innerHeight * 1.5;


                particle.style.left = '50%';
                particle.style.top = '50%';
                particle.style.transform = `translate(${x}px, ${y}px)`;
                particle.style.backgroundColor = color;
                particle.style.color = color;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.setProperty('--tx', `${tx}px`);
                particle.style.setProperty('--ty', `${ty}px`);


                particle.style.animationDelay = `${Math.random() * 0.8}s`;

                particlesContainer.appendChild(particle);
            }
        }
    });
</script>
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const playButtons = document.querySelectorAll('.play-now-btn');
        const overlay = document.getElementById('gameAnimationOverlay');
        const cube = document.getElementById('gameAnimationCube');
        const cubeFront = document.getElementById('cubeFront');
        const particlesContainer = document.getElementById('particlesContainer');
        const loadingText = document.getElementById('loadingText');


        createBackgroundParticles();


        const gameBackgrounds = {
            'computer-parts': '/images/computer-parts-bg.png',
            'qa-game': '/images/qa-game-bg.png',
            'lesson-game': '/images/lesson-game-bg.png'
        };


        const loadingTexts = {
            'computer-parts': 'Initializing Hardware Recognition',
            'qa-game': 'Loading Knowledge Database',
            'lesson-game': 'Preparing Neural Learning Interface'
        };

        playButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const gameType = this.getAttribute('data-game-type');
                const gameTitle = this.getAttribute('data-game-title');
                const targetUrl = this.getAttribute('href');


                cubeFront.style.backgroundImage = `url('${gameBackgrounds[gameType]}')`;
                cubeFront.innerHTML = `<div style="background: rgba(0,0,0,0.5); padding: 20px; border-radius: 10px; backdrop-filter: blur(5px); border: 1px solid rgba(102, 126, 234, 0.5); box-shadow: 0 0 20px rgba(102, 126, 234, 0.8);">${gameTitle}</div>`;


                loadingText.textContent = loadingTexts[gameType];


                overlay.style.opacity = '1';
                overlay.style.visibility = 'visible';


                createFuturisticParticles();



                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 2500);
            });
        });

        function createBackgroundParticles() {
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');


                const size = Math.random() * 4 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;


                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;


                const colors = [
                    'rgba(0, 255, 255, 0.7)',
                    'rgba(102, 126, 234, 0.7)',
                    'rgba(118, 75, 162, 0.7)',
                    'rgba(255, 255, 255, 0.7)'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.backgroundColor = color;
                particle.style.boxShadow = `0 0 ${size * 2}px ${color}`;


                const duration = Math.random() * 20 + 10;
                const delay = Math.random() * 10;
                particle.style.animation = `float-particle ${duration}s linear ${delay}s infinite`;

                bgParticles.appendChild(particle);
            }
        }


        const style = document.createElement('style');
        style.textContent = `
                @keyframes float-particle {
                    0% { transform: translate(0, 0) rotate(0deg); opacity: 0; }
                    10% { opacity: 0.8; }
                    90% { opacity: 0.8; }
                    100% { transform: translate(${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px, ${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px) rotate(360deg); opacity: 0; }
                }
                
                .bg-particles {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    pointer-events: none;
                }
                
                .particle {
                    position: absolute;
                    border-radius: 50%;
                    filter: blur(1px);
                }
            `;
        document.head.appendChild(style);

        function createFuturisticParticles() {

            particlesContainer.innerHTML = '';


            for (let i = 0; i < 100; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');


                const x = Math.random() * 300 - 150;
                const y = Math.random() * 300 - 150;


                const colors = [
                    '#667eea', '#764ba2', '#63b3ed', '#7f9cf5', '#b794f4',
                    '#00ffff', '#ff00ff', '#00ff99', '#3366ff', '#ff3366'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];


                const size = Math.random() * 12 + 3;


                const tx = (Math.random() - 0.5) * window.innerWidth * 1.5;
                const ty = (Math.random() - 0.5) * window.innerHeight * 1.5;


                particle.style.left = '50%';
                particle.style.top = '50%';
                particle.style.transform = `translate(${x}px, ${y}px)`;
                particle.style.backgroundColor = color;
                particle.style.color = color;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.setProperty('--tx', `${tx}px`);
                particle.style.setProperty('--ty', `${ty}px`);


                particle.style.animationDelay = `${Math.random() * 0.8}s`;

                particlesContainer.appendChild(particle);
            }
        }
    });
</script>
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const playButtons = document.querySelectorAll('.play-now-btn');
        const overlay = document.getElementById('gameAnimationOverlay');
        const cube = document.getElementById('gameAnimationCube');
        const cubeFront = document.getElementById('cubeFront');
        const particlesContainer = document.getElementById('particlesContainer');
        const loadingText = document.getElementById('loadingText');


        createBackgroundParticles();


        const gameBackgrounds = {
            'computer-parts': '/images/computer-parts-bg.png',
            'qa-game': '/images/qa-game-bg.png',
            'lesson-game': '/images/lesson-game-bg.png'
        };


        const loadingTexts = {
            'computer-parts': 'Initializing Hardware Recognition',
            'qa-game': 'Loading Knowledge Database',
            'lesson-game': 'Preparing Neural Learning Interface'
        };

        playButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const gameType = this.getAttribute('data-game-type');
                const gameTitle = this.getAttribute('data-game-title');
                const targetUrl = this.getAttribute('href');


                cubeFront.style.backgroundImage = `url('${gameBackgrounds[gameType]}')`;
                cubeFront.innerHTML = `<div style="background: rgba(0,0,0,0.5); padding: 20px; border-radius: 10px; backdrop-filter: blur(5px); border: 1px solid rgba(102, 126, 234, 0.5); box-shadow: 0 0 20px rgba(102, 126, 234, 0.8);">${gameTitle}</div>`;


                loadingText.textContent = loadingTexts[gameType];


                overlay.style.opacity = '1';
                overlay.style.visibility = 'visible';


                createFuturisticParticles();



                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 2500);
            });
        });

        function createBackgroundParticles() {
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');


                const size = Math.random() * 4 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;


                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;


                const colors = [
                    'rgba(0, 255, 255, 0.7)',
                    'rgba(102, 126, 234, 0.7)',
                    'rgba(118, 75, 162, 0.7)',
                    'rgba(255, 255, 255, 0.7)'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.backgroundColor = color;
                particle.style.boxShadow = `0 0 ${size * 2}px ${color}`;


                const duration = Math.random() * 20 + 10;
                const delay = Math.random() * 10;
                particle.style.animation = `float-particle ${duration}s linear ${delay}s infinite`;

                bgParticles.appendChild(particle);
            }
        }


        const style = document.createElement('style');
        style.textContent = `
                @keyframes float-particle {
                    0% { transform: translate(0, 0) rotate(0deg); opacity: 0; }
                    10% { opacity: 0.8; }
                    90% { opacity: 0.8; }
                    100% { transform: translate(${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px, ${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px) rotate(360deg); opacity: 0; }
                }
                
                .bg-particles {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    pointer-events: none;
                }
                
                .particle {
                    position: absolute;
                    border-radius: 50%;
                    filter: blur(1px);
                }
            `;
        document.head.appendChild(style);

        function createFuturisticParticles() {

            particlesContainer.innerHTML = '';


            for (let i = 0; i < 100; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');


                const x = Math.random() * 300 - 150;
                const y = Math.random() * 300 - 150;


                const colors = [
                    '#667eea', '#764ba2', '#63b3ed', '#7f9cf5', '#b794f4',
                    '#00ffff', '#ff00ff', '#00ff99', '#3366ff', '#ff3366'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];


                const size = Math.random() * 12 + 3;


                const tx = (Math.random() - 0.5) * window.innerWidth * 1.5;
                const ty = (Math.random() - 0.5) * window.innerHeight * 1.5;


                particle.style.left = '50%';
                particle.style.top = '50%';
                particle.style.transform = `translate(${x}px, ${y}px)`;
                particle.style.backgroundColor = color;
                particle.style.color = color;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.setProperty('--tx', `${tx}px`);
                particle.style.setProperty('--ty', `${ty}px`);


                particle.style.animationDelay = `${Math.random() * 0.8}s`;

                particlesContainer.appendChild(particle);
            }
        }
    });
</script>
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const playButtons = document.querySelectorAll('.play-now-btn');
        const overlay = document.getElementById('gameAnimationOverlay');
        const cube = document.getElementById('gameAnimationCube');
        const cubeFront = document.getElementById('cubeFront');
        const particlesContainer = document.getElementById('particlesContainer');
        const loadingText = document.getElementById('loadingText');


        createBackgroundParticles();


        const gameBackgrounds = {
            'computer-parts': '/images/computer-parts-bg.png',
            'qa-game': '/images/qa-game-bg.png',
            'lesson-game': '/images/lesson-game-bg.png'
        };


        const loadingTexts = {
            'computer-parts': 'Initializing Hardware Recognition',
            'qa-game': 'Loading Knowledge Database',
            'lesson-game': 'Preparing Neural Learning Interface'
        };

        playButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const gameType = this.getAttribute('data-game-type');
                const gameTitle = this.getAttribute('data-game-title');
                const targetUrl = this.getAttribute('href');


                cubeFront.style.backgroundImage = `url('${gameBackgrounds[gameType]}')`;
                cubeFront.innerHTML = `<div style="background: rgba(0,0,0,0.5); padding: 20px; border-radius: 10px; backdrop-filter: blur(5px); border: 1px solid rgba(102, 126, 234, 0.5); box-shadow: 0 0 20px rgba(102, 126, 234, 0.8);">${gameTitle}</div>`;


                loadingText.textContent = loadingTexts[gameType];


                overlay.style.opacity = '1';
                overlay.style.visibility = 'visible';


                createFuturisticParticles();



                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 2500);
            });
        });

        function createBackgroundParticles() {
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');


                const size = Math.random() * 4 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;


                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;


                const colors = [
                    'rgba(0, 255, 255, 0.7)',
                    'rgba(102, 126, 234, 0.7)',
                    'rgba(118, 75, 162, 0.7)',
                    'rgba(255, 255, 255, 0.7)'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.backgroundColor = color;
                particle.style.boxShadow = `0 0 ${size * 2}px ${color}`;


                const duration = Math.random() * 20 + 10;
                const delay = Math.random() * 10;
                particle.style.animation = `float-particle ${duration}s linear ${delay}s infinite`;

                bgParticles.appendChild(particle);
            }
        }


        const style = document.createElement('style');
        style.textContent = `
                @keyframes float-particle {
                    0% { transform: translate(0, 0) rotate(0deg); opacity: 0; }
                    10% { opacity: 0.8; }
                    90% { opacity: 0.8; }
                    100% { transform: translate(${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px, ${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px) rotate(360deg); opacity: 0; }
                }
                
                .bg-particles {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    pointer-events: none;
                }
                
                .particle {
                    position: absolute;
                    border-radius: 50%;
                    filter: blur(1px);
                }
            `;
        document.head.appendChild(style);

        function createFuturisticParticles() {

            particlesContainer.innerHTML = '';


            for (let i = 0; i < 100; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');


                const x = Math.random() * 300 - 150;
                const y = Math.random() * 300 - 150;


                const colors = [
                    '#667eea', '#764ba2', '#63b3ed', '#7f9cf5', '#b794f4',
                    '#00ffff', '#ff00ff', '#00ff99', '#3366ff', '#ff3366'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];


                const size = Math.random() * 12 + 3;


                const tx = (Math.random() - 0.5) * window.innerWidth * 1.5;
                const ty = (Math.random() - 0.5) * window.innerHeight * 1.5;


                particle.style.left = '50%';
                particle.style.top = '50%';
                particle.style.transform = `translate(${x}px, ${y}px)`;
                particle.style.backgroundColor = color;
                particle.style.color = color;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.setProperty('--tx', `${tx}px`);
                particle.style.setProperty('--ty', `${ty}px`);


                particle.style.animationDelay = `${Math.random() * 0.8}s`;

                particlesContainer.appendChild(particle);
            }
        }
    });