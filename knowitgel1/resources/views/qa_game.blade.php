<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q&A Game - KnowItGel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0c1e59 0%, #4b0082 100%);
            min-height: 100vh;
            color: #fff;
            position: relative;
            overflow-x: hidden;
        }

        .bg-animation-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .bg-grid {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(rgba(0, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            perspective: 1000px;
            transform: perspective(1000px) rotateX(60deg) scale(1.5);
            transform-origin: center top;
            animation: grid-movement 20s linear infinite;
        }

        @keyframes grid-movement {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 0 50px;
            }
        }

        .cyber-circuit {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/images/circuit-pattern.png');
            background-size: cover;
            opacity: 0.15;
            mix-blend-mode: screen;
        }

        .holographic-sphere {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%,
                    rgba(255, 255, 255, 0.1) 0%,
                    rgba(102, 126, 234, 0.2) 25%,
                    rgba(118, 75, 162, 0.3) 50%,
                    rgba(0, 0, 0, 0) 70%);
            filter: blur(8px);
            animation: sphere-pulse 8s ease-in-out infinite alternate;
            box-shadow:
                0 0 60px 10px rgba(102, 126, 234, 0.3),
                inset 0 0 30px rgba(255, 255, 255, 0.3);
        }

        @keyframes sphere-pulse {
            0% {
                transform: scale(0.8);
                opacity: 0.4;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }

            100% {
                transform: scale(0.9);
                opacity: 0.5;
            }
        }

        .floating-data {
            position: absolute;
            color: rgba(0, 255, 255, 0.3);
            font-family: monospace;
            font-size: 12px;
            white-space: nowrap;
            animation: float-data 15s linear infinite;
            text-shadow: 0 0 5px rgba(0, 255, 255, 0.5);
        }

        @keyframes float-data {
            0% {
                transform: translateY(100vh);
                opacity: 0;
            }

            10% {
                opacity: 0.7;
            }

            90% {
                opacity: 0.7;
            }

            100% {
                transform: translateY(-100px);
                opacity: 0;
            }
        }

        .neural-connection {
            position: absolute;
            width: 2px;
            background: linear-gradient(to bottom, transparent, rgba(0, 255, 255, 0.5), transparent);
            animation: neural-pulse 3s ease-in-out infinite;
        }

        @keyframes neural-pulse {
            0% {
                opacity: 0.3;
                height: 30%;
            }

            50% {
                opacity: 0.8;
                height: 70%;
            }

            100% {
                opacity: 0.3;
                height: 30%;
            }
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            filter: blur(1px);
        }

        @keyframes float-particle {
            0% {
                transform: translate(0, 0) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 0.8;
            }

            90% {
                opacity: 0.8;
            }

            100% {
                transform: translate(var(--tx), var(--ty)) rotate(360deg);
                opacity: 0;
            }
        }

        .bg-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        /* Existing styles */
        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 10;
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

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 600;
            transition: all 0.3s;
            color: #fff;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: #fff;
        }

        .game-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .question-text {
            font-size: 1.2rem;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .options-container {
            display: grid;
            gap: 10px;
            margin-bottom: 20px;
        }

        .option-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 12px;
            color: #fff;
            text-align: left;
            transition: all 0.3s;
            cursor: pointer;
        }

        .option-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }

        .option-btn.selected {
            background: rgba(102, 126, 234, 0.3);
            border-color: rgba(102, 126, 234, 0.5);
        }

        .option-btn.correct {
            background: rgba(40, 167, 69, 0.3);
            border-color: rgba(40, 167, 69, 0.5);
        }

        .option-btn.incorrect {
            background: rgba(220, 53, 69, 0.3);
            border-color: rgba(220, 53, 69, 0.5);
        }

        .score-display {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .feedback-message {
            padding: 10px 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .feedback-correct {
            background: rgba(40, 167, 69, 0.3);
            border: 1px solid rgba(40, 167, 69, 0.5);
        }

        .feedback-incorrect {
            background: rgba(220, 53, 69, 0.3);
            border: 1px solid rgba(220, 53, 69, 0.5);
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

        /* Add new avatar styles */
        .game-avatar {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 150px;
            height: 200px;
            z-index: 100;
            transition: all 0.3s ease;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .avatar-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .avatar-body {
            position: absolute;
            width: 100%;
            height: 80%;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            border-radius: 50% 50% 35% 35%;
            overflow: visible;
            box-shadow:
                0 0 10px rgba(45, 200, 255, 0.5),
                inset 0 0 15px rgba(45, 200, 255, 0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .avatar-eyes {
            display: flex;
            justify-content: space-around;
            width: 70%;
            margin-top: -5px;
            position: relative;
            z-index: 2;
        }

        .avatar-glasses {
            position: absolute;
            width: 85%;
            height: 35px;
            background: linear-gradient(to bottom, rgba(0, 255, 255, 0.6), rgba(0, 255, 255, 0.2));
            border-radius: 15px;
            top: -2px;
            left: 7.5%;
            z-index: 1;
            backdrop-filter: blur(2px);
            box-shadow: inset 0 0 10px rgba(0, 255, 255, 0.3);
        }

        .avatar-glasses::before {
            content: '';
            position: absolute;
            width: 15px;
            height: 5px;
            background-color: #0076b3;
            /* Blue color for the bridge of the glasses */
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
        }

        .avatar-eye {
            width: 30px;
            height: 30px;
            background-color: #000;
            border-radius: 50%;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.7);
            overflow: hidden;
            z-index: 2;
        }

        .avatar-pupil {
            width: 16px;
            height: 16px;
            background: radial-gradient(circle at 30% 30%, #0ff, #009999);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .avatar-mouth {
            width: 40px;
            height: 10px;
            margin-top: 15px;
            border-radius: 50%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 2;
        }

        .avatar-mouth::before,
        .avatar-mouth::after {
            content: '';
            width: 10px;
            height: 10px;
            background: radial-gradient(circle, #0ff, #009999);
            border-radius: 50%;
            box-shadow: 0 0 8px #0ff;
            animation: blinkLED 1s infinite alternate;
        }

        .avatar-mouth::before {
            animation-delay: 0s;
        }

        .avatar-mouth::after {
            animation-delay: 0.3s;
        }

        @keyframes blinkLED {
            from {
                opacity: 0.3;
                box-shadow: 0 0 4px #0ff;
            }

            to {
                opacity: 1;
                box-shadow: 0 0 10px #0ff;
            }
        }

        .avatar-antennas {
            position: absolute;
            top: -30px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 40px;
        }

        .avatar-antenna {
            width: 6px;
            height: 30px;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            border-radius: 50% 50% 35% 35%;
            overflow: visible;
            box-shadow:
                0 0 10px rgba(45, 200, 255, 0.5),
                inset 0 0 15px rgba(45, 200, 255, 0.3);
            position: relative;
            z-index: -1;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 5px 2px rgba(45, 200, 255, 0.8);
            }

            50% {
                box-shadow: 0 0 15px 4px rgba(45, 200, 255, 1);
            }
        }

        .avatar-antenna::before {
            content: '';
            position: absolute;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            animation: pulse 2s infinite;
        }

        .avatar-arms {
            position: absolute;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 -10px;
        }

        .avatar-arm {
            width: 15px;
            height: 40px;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            border-radius: 50% 50% 35% 35%;
            overflow: visible;
            box-shadow:
                0 0 10px rgba(45, 200, 255, 0.5),
                inset 0 0 15px rgba(45, 200, 255, 0.3);
            transition: all 0.3s ease;
        }

        .avatar-arm.left {
            transform: rotate(20deg);
            transform-origin: top left;
            position: absolute;
            left: -10px;
            top: 40px;
        }

        .avatar-arm.right {
            transform: rotate(-20deg);
            transform-origin: top right;
            position: absolute;
            right: -10px;
            top: 40px;
        }

        .avatar-circuit-line {
            position: absolute;
            width: 120%;
            height: 120%;
            top: -10%;
            left: -10%;
            background-image: url('/images/circuit-pattern.png');
            background-size: cover;
            opacity: 0.1;
            mix-blend-mode: screen;
            border-radius: 50%;
            z-index: -1;
        }

        /* Avatar animations */
        @keyframes celebrate-avatar {
            0% {
                transform: translateY(0) rotate(0deg);
            }

            25% {
                transform: translateY(-25px) rotate(5deg) scale(1.1);
            }

            50% {
                transform: translateY(0) rotate(-5deg) scale(1.05);
            }

            75% {
                transform: translateY(-20px) rotate(5deg) scale(1.1);
            }

            100% {
                transform: translateY(0) rotate(0deg) scale(1);
            }
        }

        @keyframes sad-avatar {
            0% {
                transform: translateY(0) rotate(0deg);
            }

            25% {
                transform: translateY(10px) rotate(-3deg);
            }

            50% {
                transform: translateY(5px) rotate(3deg);
            }

            75% {
                transform: translateY(8px) rotate(-2deg);
            }

            100% {
                transform: translateY(0) rotate(0deg);
            }
        }

        .avatar-celebrating .avatar-body {
            animation: celebrate-avatar 1s ease-in-out infinite alternate;
            background: linear-gradient(135deg, #00d68f, #00c4cc);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.6);
        }

        .avatar-celebrating .avatar-arm.left {
            transform: rotate(-60deg) translateY(-10px);
            animation: wave-arm 0.5s ease-in-out infinite alternate;
        }

        @keyframes wave-arm {
            from {
                transform: rotate(-60deg) translateY(-10px);
            }

            to {
                transform: rotate(-80deg) translateY(-15px);
            }
        }

        .avatar-celebrating .avatar-arm.right {
            transform: rotate(60deg) translateY(-10px);
        }

        .avatar-celebrating .avatar-eye {
            transform: scale(1.2);
        }

        .avatar-sad .avatar-body {
            animation: sad-avatar 1.5s ease-in-out;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        }

        .avatar-sad .avatar-arm.left {
            transform: rotate(-10deg) translateY(5px);
        }

        .avatar-sad .avatar-arm.right {
            transform: rotate(10deg) translateY(5px);
        }

        .avatar-sad .avatar-eye {
            transform: scaleY(0.8);
        }

        .avatar-happy .avatar-mouth {
            transform: scaleX(1.2);
        }

        .avatar-excited .avatar-body {
            transform: scale(1.05);
        }

        .avatar-excited .avatar-arm.left {
            transform: rotate(40deg) translateY(-5px);
        }

        .avatar-excited .avatar-arm.right {
            transform: rotate(-40deg) translateY(-5px);
        }

        .avatar-thinking .avatar-arm.right {
            transform: rotate(-70deg) translateY(-10px);
        }

        .avatar-sad .avatar-arm.left {
            transform: rotate(10deg) translateY(5px);
        }

        .avatar-sad .avatar-eye {
            transform: scaleY(0.8);
        }

        .avatar-speech-bubble {
            position: absolute;
            top: -100px;
            right: 30px;
            background-color: white;
            color: #333;
            padding: 10px 15px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: bold;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            pointer-events: none;
            max-width: 200px;
            width: 200px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .avatar-speech-bubble::after {
            border-top-color: #0ff;
        }

        .avatar-speech-bubble.show {
            animation: fadeInOut 4s ease-in-out;
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            10%,
            90% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        .celebration-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            pointer-events: none;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .celebration-avatar {
            width: 200px;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 100px;
            animation: celebrate 2s ease-in-out;
        }

        @keyframes celebrate {
            0% {
                transform: scale(0.1) rotate(-10deg);
                opacity: 0;
            }

            20% {
                transform: scale(1.1) rotate(10deg);
                opacity: 1;
            }

            40% {
                transform: scale(0.9) rotate(-5deg);
            }

            60% {
                transform: scale(1.05) rotate(5deg);
            }

            80% {
                transform: scale(0.95) rotate(-2deg);
            }

            100% {
                transform: scale(1) rotate(0);
            }
        }
    </style>
</head>

<body>

    <div class="bg-animation-container">
        <div class="bg-grid"></div>
        <div class="cyber-circuit"></div>
        <div class="bg-particles" id="bgParticles"></div>
        <div class="holographic-sphere" style="top: 20%; left: 10%;"></div>
        <div class="holographic-sphere" style="bottom: 30%; right: 15%;"></div>


        <div class="neural-connection" style="top: 10%; left: 20%; height: 40%;"></div>
        <div class="neural-connection" style="top: 30%; left: 40%; height: 50%;"></div>
        <div class="neural-connection" style="top: 5%; left: 60%; height: 30%;"></div>
        <div class="neural-connection" style="top: 50%; left: 80%; height: 45%;"></div>
        <div class="neural-connection" style="top: 70%; left: 30%; height: 25%;"></div>


        <div class="floating-data" style="left: 5%;">01001010 10101010 11001100</div>
        <div class="floating-data" style="left: 25%; animation-delay: 2s;">10110101 00110011 10101010</div>
        <div class="floating-data" style="left: 45%; animation-delay: 5s;">11001100 10101010 01001010</div>
        <div class="floating-data" style="left: 65%; animation-delay: 8s;">00110011 01001010 10110101</div>
        <div class="floating-data" style="left: 85%; animation-delay: 11s;">10101010 10110101 11001100</div>
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
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('leaderboard') }}">
                            <i class="fas fa-trophy me-1"></i>Leaderboard
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
        <div class="game-container">
            <div class="card">
                <div class="card-header text-center">
                    <h4><i class="fas fa-question-circle me-2"></i>Q&A Game</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <p class="lead">Test your knowledge with these computer-related questions!</p>
                        <div class="score-display">
                            <i class="fas fa-trophy me-2"></i>Score: <span id="score">0</span>
                        </div>
                    </div>

                    <div class="text-center">
                        <div id="start-screen">
                            <h4>Q&A Game</h4>
                            <p class="lead mb-4">Test your knowledge with these computer-related questions!</p>
                            <button id="start-btn" class="btn btn-primary btn-lg">
                                <i class="fas fa-play me-1"></i>Start Game
                            </button>
                        </div>

                        <div id="game-screen" class="d-none">
                            <div class="question-text" id="question">Loading question...</div>

                            <div class="options-container" id="options"></div>

                            <div id="feedback" class="feedback-message d-none"></div>
                            <div id="description-area" class="mt-3 p-3" style="background: rgba(255,255,255,0.1); border-radius: 10px; display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="game-avatar" id="gameAvatar">
        <div class="avatar-container">
            <div class="avatar-body">
                <div class="avatar-antennas">
                    <div class="avatar-antenna"></div>
                    <div class="avatar-antenna"></div>
                </div>
                <div class="avatar-circuit-line"></div>

                <div class="avatar-glasses"></div>


                <div class="avatar-eyes">
                    <div class="avatar-eye">
                        <div class="avatar-pupil"></div>
                    </div>
                    <div class="avatar-eye">
                        <div class="avatar-pupil"></div>
                    </div>
                </div>


                <div class="avatar-mouth"></div>


                <div class="avatar-arms">
                    <div class="avatar-arm left"></div>
                    <div class="avatar-arm right"></div>
                </div>
            </div>
            <div class="avatar-speech-bubble" id="avatarSpeechBubble"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startScreen = document.getElementById('start-screen');
            const gameScreen = document.getElementById('game-screen');
            const startBtn = document.getElementById('start-btn');
            const questionElement = document.getElementById('question');
            const optionsContainer = document.getElementById('options');
            const feedbackElement = document.getElementById('feedback');
            const scoreElement = document.getElementById('score');
            const gameAvatar = document.getElementById('gameAvatar');
            const avatarBody = gameAvatar.querySelector('.avatar-body');
            const avatarSpeechBubble = document.getElementById('avatarSpeechBubble');
            const celebrationContainer = document.getElementById('celebrationContainer');

            const questions = @json($games);

            let currentQuestionIndex = 0;
            let score = 0;
            let timer;
            let timeLeft = 15;
            let timerElement;

            startBtn.addEventListener('click', startGame);


            function showAvatarMessage(message, mood = 'neutral') {

                avatarBody.className = 'avatar-body';


                if (mood === 'happy') {
                    avatarBody.classList.add('avatar-happy');
                } else if (mood === 'excited') {
                    avatarBody.classList.add('avatar-excited');
                } else if (mood === 'thinking') {
                    avatarBody.classList.add('avatar-thinking');
                } else if (mood === 'sad') {
                    avatarBody.classList.add('avatar-sad');
                }


                avatarSpeechBubble.textContent = message;
                avatarSpeechBubble.classList.remove('show');
                void avatarSpeechBubble.offsetWidth;
                avatarSpeechBubble.classList.add('show');
            }

            function showCelebration() {
                celebrationContainer.style.opacity = '1';
                setTimeout(() => {
                    celebrationContainer.style.opacity = '0';
                }, 2000);
            }

            function startGame() {
                startScreen.classList.add('d-none');
                gameScreen.classList.remove('d-none');
                showAvatarMessage("Let's get started! Good luck!", 'excited');
                loadQuestion();
            }

            function loadQuestion() {
                if (currentQuestionIndex >= questions.length) {
                    gameScreen.innerHTML = `
                        <h3>Game Over!</h3>
                        <p>Your final score: ${score}/${questions.length}</p>
                        <button class="btn btn-primary" onclick="location.reload()">Play Again</button>
                    `;

                    if (score >= questions.length * 0.7) {
                        showAvatarMessage("Amazing job! You're a computer genius!", 'excited');
                        showCelebration();
                    } else if (score >= questions.length * 0.5) {
                        showAvatarMessage("Good effort! Keep learning!", 'happy');
                    } else {
                        showAvatarMessage("Don't worry, practice makes perfect!", 'thinking');
                    }

                    return;
                }

                const currentQuestion = questions[currentQuestionIndex];
                questionElement.textContent = currentQuestion.question;

                optionsContainer.innerHTML = '';

                if (!document.getElementById('timer-container')) {
                    const timerContainer = document.createElement('div');
                    timerContainer.id = 'timer-container';
                    timerContainer.classList.add('mb-3', 'text-center');
                    timerContainer.innerHTML = `
                        <div class="progress" style="height: 30px;">
                            <div id="timer-bar" class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <span id="timer-text">10s</span>
                            </div>
                        </div>
                    `;
                    questionElement.parentNode.insertBefore(timerContainer, questionElement);
                }

                timeLeft = 15;
                timerElement = document.getElementById('timer-text');
                const timerBar = document.getElementById('timer-bar');
                timerElement.textContent = timeLeft + 's';
                timerBar.style.width = '100%';
                timerBar.classList.remove('bg-warning', 'bg-danger');
                timerBar.classList.add('bg-primary');

                clearInterval(timer);
                timer = setInterval(updateTimer, 1000);

                if (currentQuestion.options && Array.isArray(currentQuestion.options)) {
                    currentQuestion.options.forEach((option, index) => {
                        const button = document.createElement('button');
                        button.textContent = option;
                        button.classList.add('option-btn');
                        button.addEventListener('click', () => checkAnswer(option, index));
                        optionsContainer.appendChild(button);
                    });
                } else {
                    console.error('Invalid options format for question:', currentQuestion);
                }

                feedbackElement.classList.add('d-none');


                showAvatarMessage("Hmm, think carefully about this one...", 'thinking');
            }

            function updateTimer() {
                timeLeft--;
                const timerBar = document.getElementById('timer-bar');
                const percentage = (timeLeft / 15) * 100;

                timerElement.textContent = timeLeft + 's';
                timerBar.style.width = percentage + '%';

                if (timeLeft <= 4 && timeLeft > 2) {
                    timerBar.classList.remove('bg-primary', 'bg-danger');
                    timerBar.classList.add('bg-warning');
                    showAvatarMessage("Hurry up! Time is running out!", 'thinking');
                } else if (timeLeft <= 2) {
                    timerBar.classList.remove('bg-primary', 'bg-warning');
                    timerBar.classList.add('bg-danger');
                }

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    timeOut();
                }
            }

            function timeOut() {
                const optionButtons = document.querySelectorAll('.option-btn');
                const currentQuestion = questions[currentQuestionIndex];
                const correctAnswerIndex = currentQuestion.correctAnswerIndex;
                const descriptionArea = document.getElementById('description-area');

                optionButtons.forEach((button, index) => {
                    button.disabled = true;

                    if (index === correctAnswerIndex) {
                        button.classList.add('correct');
                    }
                });

                feedbackElement.textContent = "Time's up! The correct answer is: " + currentQuestion.options[correctAnswerIndex];
                feedbackElement.className = 'feedback-message feedback-incorrect';
                feedbackElement.classList.remove('d-none');

                if (descriptionArea) {
                    descriptionArea.innerHTML = currentQuestion.description || "No additional information available.";
                    descriptionArea.style.display = 'block';
                }

                showAvatarMessage("Oops! You ran out of time. The correct answer was: " + currentQuestion.options[correctAnswerIndex], 'sad');

                setTimeout(() => {
                    currentQuestionIndex++;
                    loadQuestion();
                }, 3000);
            }

            /*
              function celebrateAvatar() {
        const avatar = document.getElementById('gameAvatar');
        avatar.className = 'game-avatar avatar-celebrating';
        showAvatarSpeech('Great job! You got it right!');
        setTimeout(() => {
            avatar.className = 'game-avatar';
            hideAvatarSpeech();
        }, 3000);
    }

     function sadAvatar() {
        const avatar = document.getElementById('gameAvatar');
        avatar.className = 'game-avatar avatar-sad';
        showAvatarSpeech('Aww, that\'s not right. Try again!');
        setTimeout(() => {
            avatar.className = 'game-avatar';
            hideAvatarSpeech();
        }, 3000);
    }
       function showAvatarSpeech(text) {
        const speech = document.getElementById('avatarSpeech');
        speech.textContent = text;
        speech.classList.add('show');
    }
     function hideAvatarSpeech() {
        const speech = document.getElementById('avatarSpeech');
        speech.classList.remove('show');
    }
            */
            function checkAnswer(selectedOption, selectedIndex) {
                clearInterval(timer);

                const currentQuestion = questions[currentQuestionIndex];
                const correctAnswerIndex = currentQuestion.correctAnswerIndex;
                const isCorrect = selectedIndex === correctAnswerIndex;
                const optionButtons = document.querySelectorAll('.option-btn');
                const descriptionArea = document.getElementById('description-area');

                optionButtons.forEach((button, index) => {
                    button.disabled = true;

                    if (index === correctAnswerIndex) {
                        button.classList.add('correct');
                    } else if (index === selectedIndex && !isCorrect) {
                        button.classList.add('incorrect');
                    }
                });

                if (isCorrect) {
                    score++;
                    scoreElement.textContent = score;
                    feedbackElement.textContent = "Correct! Well done!";
                    feedbackElement.className = 'feedback-message feedback-correct';

                    if (gameAvatar) {
                        gameAvatar.classList.remove('avatar-sad');
                        gameAvatar.classList.add('avatar-celebrating');
                    }
                    showAvatarMessage("Hooray! That's correct!", 'happy');

                    if (score % 3 === 0) {
                        showCelebration();
                    }
                } else {
                    feedbackElement.textContent = "Incorrect. The correct answer is: " + currentQuestion.options[correctAnswerIndex];
                    feedbackElement.className = 'feedback-message feedback-incorrect';

                    if (gameAvatar) {
                        gameAvatar.classList.remove('avatar-celebrating');
                        gameAvatar.classList.add('avatar-sad');
                    }
                    showAvatarMessage("Aww, that's not right. Try again!", 'sad');
                }

                feedbackElement.classList.remove('d-none');

                if (descriptionArea) {
                    descriptionArea.innerHTML = currentQuestion.description || "No additional information available.";
                    descriptionArea.style.display = 'block';
                }


                if (gameAvatar) {
                    setTimeout(() => {
                        gameAvatar.classList.remove('avatar-celebrating', 'avatar-sad');
                    }, 3000);
                }

                setTimeout(() => {
                    currentQuestionIndex++;
                    loadQuestion();
                }, 3000);
            }


            function createBackgroundParticles() {
                const bgParticles = document.getElementById('bgParticles');
                const particleCount = 50;

                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('div');
                    particle.classList.add('particle');


                    const size = Math.random() * 4 + 2;
                    const posX = Math.random() * 100;
                    const posY = Math.random() * 100;
                    const tx = (Math.random() - 0.5) * 200;
                    const ty = (Math.random() - 0.5) * 200;
                    const duration = Math.random() * 10 + 10;
                    const delay = Math.random() * 5;
                    const hue = Math.random() * 60 + 180;


                    particle.style.width = size + 'px';
                    particle.style.height = size + 'px';
                    particle.style.left = posX + '%';
                    particle.style.top = posY + '%';
                    particle.style.backgroundColor = `hsla(${hue}, 100%, 70%, 0.8)`;
                    particle.style.setProperty('--tx', tx + 'px');
                    particle.style.setProperty('--ty', ty + 'px');
                    particle.style.animation = `float-particle ${duration}s ease-in-out ${delay}s infinite`;

                    bgParticles.appendChild(particle);
                }
            }

            createBackgroundParticles();
        });



        const bgParticles = document.getElementById('bgParticles');


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


                const tx = (Math.random() > 0.5 ? '+' : '-') + (Math.random() * 100 + 50) + 'px';
                const ty = (Math.random() > 0.5 ? '+' : '-') + (Math.random() * 100 + 50) + 'px';
                particle.style.setProperty('--tx', tx);
                particle.style.setProperty('--ty', ty);

                particle.style.animation = `float-particle ${duration}s linear ${delay}s infinite`;

                bgParticles.appendChild(particle);
            }
        }

        createBackgroundParticles();


        const startScreen = document.getElementById('start-screen');
        const gameScreen = document.getElementById('game-screen');
        const startBtn = document.getElementById('start-btn');
        const questionElement = document.getElementById('question');
        const optionsContainer = document.getElementById('options');
        const feedbackElement = document.getElementById('feedback');
        const scoreElement = document.getElementById('score');

        const questions = @json($games);

        let currentQuestionIndex = 0;
        let score = 0;
        let timer;
        let timeLeft = 15;
        let timerElement;

        startBtn.addEventListener('click', startGame);

        function startGame() {
            startScreen.classList.add('d-none');
            gameScreen.classList.remove('d-none');
            loadQuestion();
        }

        function loadQuestion() {
            if (currentQuestionIndex >= questions.length) {
                gameScreen.innerHTML = `
                        <h3>Game Over!</h3>
                        <p>Your final score: ${score}/${questions.length}</p>
                        <button class="btn btn-primary" onclick="location.reload()">Play Again</button>
                    `;
                return;
            }

            const currentQuestion = questions[currentQuestionIndex];
            questionElement.textContent = currentQuestion.question;

            optionsContainer.innerHTML = '';

            if (!document.getElementById('timer-container')) {
                const timerContainer = document.createElement('div');
                timerContainer.id = 'timer-container';
                timerContainer.classList.add('mb-3', 'text-center');
                timerContainer.innerHTML = `
                        <div class="progress" style="height: 30px;">
                            <div id="timer-bar" class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <span id="timer-text">10s</span>
                            </div>
                        </div>
                    `;
                questionElement.parentNode.insertBefore(timerContainer, questionElement);
            }

            timeLeft = 15;
            timerElement = document.getElementById('timer-text');
            const timerBar = document.getElementById('timer-bar');
            timerElement.textContent = timeLeft + 's';
            timerBar.style.width = '100%';
            timerBar.classList.remove('bg-warning', 'bg-danger');
            timerBar.classList.add('bg-primary');

            clearInterval(timer);
            timer = setInterval(updateTimer, 1000);

            if (currentQuestion.options && Array.isArray(currentQuestion.options)) {
                currentQuestion.options.forEach((option, index) => {
                    const button = document.createElement('button');
                    button.textContent = option;
                    button.classList.add('option-btn');
                    button.addEventListener('click', () => checkAnswer(option, index));
                    optionsContainer.appendChild(button);
                });
            } else {
                console.error('Invalid options format for question:', currentQuestion);
            }

            feedbackElement.classList.add('d-none');
        }

        function updateTimer() {
            timeLeft--;
            const timerBar = document.getElementById('timer-bar');
            const percentage = (timeLeft / 15) * 100;

            timerElement.textContent = timeLeft + 's';
            timerBar.style.width = percentage + '%';

            if (timeLeft <= 4 && timeLeft > 2) {
                timerBar.classList.remove('bg-primary', 'bg-danger');
                timerBar.classList.add('bg-warning');
            } else if (timeLeft <= 2) {
                timerBar.classList.remove('bg-primary', 'bg-warning');
                timerBar.classList.add('bg-danger');
            }

            if (timeLeft <= 0) {
                clearInterval(timer);
                timeOut();
            }
        }

        function timeOut() {
            const optionButtons = document.querySelectorAll('.option-btn');
            const currentQuestion = questions[currentQuestionIndex];
            const correctAnswerIndex = currentQuestion.correctAnswerIndex;
            const descriptionArea = document.getElementById('description-area');

            optionButtons.forEach((button, index) => {
                button.disabled = true;

                if (index === correctAnswerIndex) {
                    button.classList.add('correct');
                }
            });

            feedbackElement.classList.remove('d-none');
            feedbackElement.textContent = `Time's up! The correct answer is ${currentQuestion.options[correctAnswerIndex]}.`;
            feedbackElement.classList.add('feedback-incorrect');
            feedbackElement.classList.remove('feedback-correct');

            if (currentQuestion.description) {
                descriptionArea.innerHTML = currentQuestion.description;
                descriptionArea.style.display = 'block';
            }

            setTimeout(() => {
                currentQuestionIndex++;
                descriptionArea.style.display = 'none';
                descriptionArea.innerHTML = '';
                loadQuestion();
            }, 2000);
        }

        function checkAnswer(selectedOption, selectedIndex) {
            clearInterval(timer);

            const currentQuestion = questions[currentQuestionIndex];
            const correctAnswerIndex = currentQuestion.correctAnswerIndex;
            const descriptionArea = document.getElementById('description-area');

            const optionButtons = document.querySelectorAll('.option-btn');
            optionButtons.forEach((button, index) => {
                button.disabled = true;

                if (index === correctAnswerIndex) {
                    button.classList.add('correct');
                } else if (index === selectedIndex && selectedIndex !== correctAnswerIndex) {
                    button.classList.add('incorrect');
                }
            });

            feedbackElement.classList.remove('d-none');

            if (selectedIndex === correctAnswerIndex) {
                score++;
                scoreElement.textContent = score;
                feedbackElement.textContent = "Correct! Well done!";
                feedbackElement.classList.add('feedback-correct');
                feedbackElement.classList.remove('feedback-incorrect');
            } else {
                feedbackElement.textContent = `Incorrect. The correct answer is ${currentQuestion.options[correctAnswerIndex]}.`;
                feedbackElement.classList.add('feedback-incorrect');
                feedbackElement.classList.remove('feedback-correct');

                if (currentQuestion.description) {
                    descriptionArea.innerHTML = currentQuestion.description;
                    descriptionArea.style.display = 'block';
                }
            }

            setTimeout(() => {
                currentQuestionIndex++;
                descriptionArea.style.display = 'none';
                descriptionArea.innerHTML = '';
                loadQuestion();
            }, 2000);
        }

        function saveScore() {
            fetch('{{ route("save.score") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        score: score,
                        game_type: 'qa'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Score saved successfully!');
                    }
                })
                .catch(error => {
                    console.error('Error saving score:', error);
                });
        }
    </script>
</body>

</html>