<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guess the Computer Parts - KnowItGel</title>
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

        .game-image {
            max-width: 60%;
            max-height: 300px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            object-fit: contain;
        }

        .answer-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 12px;
            color: #fff;
            width: 100%;
            margin-bottom: 15px;
        }

        .answer-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
            color: #fff;
        }

        .answer-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
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
            opacity: 0.15;
            mix-blend-mode: screen;
            animation: rotateCircuit 30s linear infinite;
            z-index: 0;
        }

        @keyframes rotateCircuit {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

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
            background-color: #29a9e0;
        }

        .avatar-sad .avatar-mouth {
            height: 15px;
            width: 30px;
            border-radius: 50px 50px 0 0;
            background-color: #0076b3;
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
                    <h4><i class="fas fa-microchip me-2"></i>Guess the Computer Parts</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <p class="lead">Test your knowledge about computer hardware components!</p>
                        <div class="score-display">
                            <i class="fas fa-trophy me-2"></i>Score: <span id="score">0</span>
                        </div>
                    </div>

                    <div class="text-center">
                        @if(!isset($gameStarted))
                        <div id="start-screen">
                            <h4>Guess the Computer Parts</h4>
                            <p class="lead mb-4">Test your knowledge about computer hardware components!</p>
                            <button id="start-btn" class="btn btn-primary btn-lg">
                                <i class="fas fa-play me-1"></i>Start Game
                            </button>
                        </div>
                        @endif

                        <div id="game-screen" class="{{ isset($gameStarted) ? '' : 'd-none' }}">
                            <img id="part-image" src="" class="game-image" alt="Computer Part">
                            <h5 id="question" class="mb-3"></h5>

                            <div id="feedback" class="feedback-message d-none"></div>
                            <div id="description-area" class="mt-3 p-3" style="background: rgba(255,255,255,0.1); border-radius: 10px;"></div>
                            <br>

                            <div class="mb-3">
                                <input type="text" id="answer" class="answer-input" placeholder="Enter your answer..." autocomplete="off">
                            </div>
                            <div class="d-flex justify-content-center gap-2">
                                <button id="submit-btn" class="btn btn-primary">
                                    <i class="fas fa-check me-1"></i>Submit Answer
                                </button>
                                <button id="next-btn" class="btn btn-secondary d-none">
                                    <i class="fas fa-arrow-right me-1"></i>Next Question
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="game-avatar" id="gameAvatar">
        <div class="avatar-container">
            <div class="avatar-speech-bubble" id="avatarSpeech"></div>
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
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const gameData = {
            !!json_encode($games) !!
        };
        let currentQuestion = 0;
        let score = 0;
        let spinning = false;
        let answeredQuestionIndices = [];

        const startScreen = document.getElementById('start-screen');
        const gameScreen = document.getElementById('game-screen');
        const startBtn = document.getElementById('start-btn');
        const partImage = document.getElementById('part-image');
        const questionText = document.getElementById('question');
        const answerInput = document.getElementById('answer');
        const submitBtn = document.getElementById('submit-btn');
        const nextBtn = document.getElementById('next-btn');
        const feedbackDiv = document.getElementById('feedback');
        const scoreDisplay = document.getElementById('score');
        const descriptionArea = document.getElementById('description-area');

        startBtn.addEventListener('click', function() {
            startScreen.classList.add('d-none');
            gameScreen.classList.remove('d-none');
            answeredQuestionIndices = [];
            score = 0;
            scoreDisplay.textContent = score;
            descriptionArea.classList.add('d-none');
            descriptionArea.textContent = '';
            spinAndLoadQuestion();
        });

        function spinAndLoadQuestion() {
            if (spinning) return;

            const availableQuestions = gameData.filter((game, index) => !answeredQuestionIndices.includes(index));

            if (availableQuestions.length === 0) {
                partImage.style.display = 'none';
                questionText.textContent = "Game Over! You've answered all questions.";
                answerInput.style.display = 'none';
                submitBtn.style.display = 'none';
                nextBtn.style.display = 'none';
                feedbackDiv.classList.add('d-none');
                descriptionArea.classList.add('d-none');
                descriptionArea.textContent = '';
                const gameOverMessage = document.createElement('p');
                gameOverMessage.textContent = `Final Score: ${score}. Thanks for playing!`;
                gameOverMessage.classList.add('lead', 'mt-3');

                const restartBtn = document.createElement('button');
                restartBtn.textContent = 'Play Again';
                restartBtn.classList.add('btn', 'btn-primary', 'mt-3');
                restartBtn.addEventListener('click', () => {
                    startScreen.classList.remove('d-none');
                    gameScreen.classList.add('d-none');
                    answerInput.style.display = '';
                    submitBtn.style.display = '';
                    nextBtn.style.display = '';
                    const existingGameOverMsg = gameScreen.querySelector('.lead.mt-3');
                    if (existingGameOverMsg) existingGameOverMsg.remove();
                    const existingRestartBtn = gameScreen.querySelector('.btn.btn-primary.mt-3');
                    if (existingRestartBtn) existingRestartBtn.remove();
                });

                const gameScreenDiv = document.getElementById('game-screen');
                const existingAnimationContainer = partImage.parentNode.querySelector('div[style*="perspective"]');
                if (existingAnimationContainer) {
                    existingAnimationContainer.remove();
                }

                questionText.innerHTML = `Game Over! You've answered all questions.<br>Final Score: ${score}.`;
                partImage.style.display = 'none';
                answerInput.classList.add('d-none');
                submitBtn.classList.add('d-none');
                nextBtn.classList.add('d-none');
                feedbackDiv.classList.add('d-none');
                descriptionArea.classList.add('d-none');
                descriptionArea.textContent = '';

                if (!document.getElementById('restart-game-btn')) {
                    const restartGameBtn = document.createElement('button');
                    restartGameBtn.id = 'restart-game-btn';
                    restartGameBtn.textContent = 'Play Again';
                    restartGameBtn.classList.add('btn', 'btn-primary', 'mt-3');
                    restartGameBtn.onclick = () => {
                        location.reload();
                    };
                    questionText.parentNode.appendChild(restartGameBtn);
                }
                spinning = false;
                return;
            }

            spinning = true;

            partImage.src = "";
            questionText.textContent = "Loading question...";
            answerInput.value = '';
            answerInput.disabled = true;
            submitBtn.disabled = true;
            answerInput.classList.remove('d-none');
            submitBtn.classList.remove('d-none');
            nextBtn.classList.add('d-none');
            feedbackDiv.classList.add('d-none');
            descriptionArea.classList.add('d-none');
            descriptionArea.textContent = '';

            const existingRestartBtn = document.getElementById('restart-game-btn');
            if (existingRestartBtn) {
                existingRestartBtn.remove();
            }

            const animationContainer = document.createElement('div');
            animationContainer.style.width = '100%';
            animationContainer.style.height = '400px';
            animationContainer.style.position = 'relative';
            animationContainer.style.margin = '0 auto';
            animationContainer.style.perspective = '1000px';

            const carousel = document.createElement('div');
            carousel.style.width = '300px';
            carousel.style.height = '300px';
            carousel.style.position = 'absolute';
            carousel.style.top = '50%';
            carousel.style.left = '50%';
            carousel.style.transformStyle = 'preserve-3d';
            carousel.style.transform = 'translate(-50%, -50%)';

            const totalImages = gameData.length;
            const angleIncrement = (2 * Math.PI) / totalImages;
            const radius = 200;

            gameData.forEach((game, index) => {
                const imgContainer = document.createElement('div');
                imgContainer.style.position = 'absolute';
                imgContainer.style.width = '200px';
                imgContainer.style.height = '200px';

                const angle = angleIncrement * index;
                const x = Math.sin(angle) * radius;
                const z = Math.cos(angle) * radius;

                imgContainer.style.transform = `
                translateX(${x}px)
                translateZ(${z}px)
                rotateY(${angle}rad)
            `;
                imgContainer.style.transition = 'transform 0.1s linear';

                const img = document.createElement('img');
                img.src = game.game_file;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'contain';
                img.style.borderRadius = '10px';
                img.style.boxShadow = '0 5px 15px rgba(0,0,0,0.2)';

                imgContainer.appendChild(img);
                carousel.appendChild(imgContainer);
            });

            animationContainer.appendChild(carousel);
            partImage.parentNode.insertBefore(animationContainer, partImage);
            partImage.style.display = 'none';

            let rotation = 0;
            let spinSpeed = 0.2;
            let animationFrame;
            const spinDuration = 5000;
            const startTime = Date.now();

            const animate = () => {
                const elapsed = Date.now() - startTime;
                const progress = elapsed / spinDuration;

                if (progress > 0.7) {
                    spinSpeed = Math.max(0.01, spinSpeed * 0.95);
                }

                rotation += spinSpeed;
                carousel.style.transform = `
                translate(-50%, -50%)
                rotateY(${rotation}rad)
            `;

                if (elapsed >= spinDuration) {
                    const randomAvailableIndexInFilteredArray = Math.floor(Math.random() * availableQuestions.length);
                    const selectedGame = availableQuestions[randomAvailableIndexInFilteredArray];
                    const originalGameIndex = gameData.indexOf(selectedGame);

                    answeredQuestionIndices.push(originalGameIndex);

                    const finalRotation = (2 * Math.PI) - (angleIncrement * originalGameIndex);

                    carousel.style.transition = 'transform 1s cubic-bezier(0.25, 0.1, 0.25, 1)';
                    carousel.style.transform = `
                    translate(-50%, -50%)
                    rotateY(${finalRotation}rad)
                `;

                    setTimeout(() => {
                        animationContainer.remove();
                        partImage.style.display = '';
                        loadQuestion(originalGameIndex);
                        spinning = false;
                    }, 1000);
                    return;
                }

                animationFrame = requestAnimationFrame(animate);
            };

            animate();
        }

        function loadQuestion(index) {
            currentQuestion = index;
            partImage.src = gameData[currentQuestion].game_file;
            questionText.textContent = gameData[currentQuestion].question;
            answerInput.disabled = false;
            submitBtn.disabled = false;
            answerInput.focus();
            feedbackDiv.classList.add('d-none');
            descriptionArea.classList.add('d-none');
            descriptionArea.textContent = '';
        }

        submitBtn.addEventListener('click', function() {
            const userAnswer = answerInput.value.trim().toLowerCase();
            const correctAnswer = gameData[currentQuestion].answer.toLowerCase();
            const description = gameData[currentQuestion].description || "No description available for this item.";

            feedbackDiv.classList.remove('d-none');
            feedbackDiv.classList.remove('feedback-correct', 'feedback-incorrect');
            descriptionArea.classList.add('d-none');
            descriptionArea.textContent = '';

            if (userAnswer === correctAnswer) {
                feedbackDiv.textContent = 'Correct!';
                feedbackDiv.classList.add('feedback-correct');
                score++;
                scoreDisplay.textContent = score;
            } else {
                feedbackDiv.innerHTML = `Incorrect! The correct answer is: <strong>${gameData[currentQuestion].answer}</strong>`; // Show correct answer
                feedbackDiv.classList.add('feedback-incorrect');

                descriptionArea.innerHTML = description;
                descriptionArea.classList.remove('d-none');
            }

            submitBtn.classList.add('d-none');
            nextBtn.classList.remove('d-none');
            answerInput.disabled = true;
        });

        nextBtn.addEventListener('click', function() {
            descriptionArea.classList.add('d-none');
            descriptionArea.textContent = '';
            const remainingQuestions = gameData.filter((game, index) => !answeredQuestionIndices.includes(index));
            if (remainingQuestions.length > 0) {
                spinAndLoadQuestion();
            } else {
                questionText.textContent = "Game Over! All questions answered.";
                partImage.style.display = 'none';
                answerInput.style.display = 'none';
                submitBtn.style.display = 'none';
                nextBtn.style.display = 'none';
                feedbackDiv.classList.add('d-none');
                if (!document.getElementById('restart-game-btn')) {
                    const restartGameBtn = document.createElement('button');
                    restartGameBtn.id = 'restart-game-btn';
                    restartGameBtn.textContent = 'Play Again';
                    restartGameBtn.classList.add('btn', 'btn-primary', 'mt-3');
                    restartGameBtn.onclick = () => {
                        location.reload();
                    };
                    questionText.parentNode.appendChild(restartGameBtn);
                }
            }
        });

        answerInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !submitBtn.classList.contains('d-none')) {
                submitBtn.click();
            }
        });

        const avatar = document.querySelector('.game-avatar');
        const speechBubble = document.querySelector('.avatar-speech-bubble');

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                speechBubble.textContent = "Hi there, Welcome to Guess the Computer Parts!";
                speechBubble.classList.add('show');

                setTimeout(() => {
                    speechBubble.classList.remove('show');
                }, 3000);
            }, 1000);

            initAvatar();
        });

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

        function initAvatar() {
            const pupils = document.querySelectorAll('.avatar-pupil');
        }

        submitBtn.addEventListener('click', function() {
            const userAnswer = answerInput.value.trim().toLowerCase();
            const correctAnswer = gameData[currentQuestion].answer.toLowerCase();

            feedbackDiv.classList.remove('d-none', 'feedback-correct', 'feedback-incorrect');

            if (userAnswer === correctAnswer) {
                score += 10;
                scoreDisplay.textContent = score;
                feedbackDiv.textContent = "Correct! Well done!";
                feedbackDiv.classList.add('feedback-correct');
                submitBtn.classList.add('d-none');
                nextBtn.classList.remove('d-none');
                descriptionArea.classList.remove('d-none');
                descriptionArea.textContent = gameData[currentQuestion].description;

                celebrateAvatar("Hooray! That's correct!");

                fetch('/save-score', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        game_type: 'computer_parts',
                        score: 10
                    })
                });
            } else {
                feedbackDiv.textContent = "Sorry, that's not correct. Try again!";
                feedbackDiv.classList.add('feedback-incorrect');

                sadAvatar("Aww, that's not right. Try again!");
            }

            feedbackDiv.classList.remove('d-none');
        });

        nextBtn.addEventListener('click', function() {
            avatar.classList.remove('avatar-celebrating', 'avatar-sad');
            speechBubble.classList.remove('show');

            feedbackDiv.classList.add('d-none');
            submitBtn.classList.remove('d-none');
            nextBtn.classList.add('d-none');
            answerInput.value = '';
            descriptionArea.classList.add('d-none');
            descriptionArea.textContent = '';

            answeredQuestionIndices.push(currentQuestion);

            spinAndLoadQuestion();
        });
    </script>
</body>

</html>