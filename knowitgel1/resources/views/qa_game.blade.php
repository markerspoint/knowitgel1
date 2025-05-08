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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #fff;
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
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
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
            box-shadow: 0 5px 15px rgba(102,126,234,0.4);
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
    </style>
</head>
<body>
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
                        </div>
                    </div>
                </div>
            </div>
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
            
            const questions = @json($games);
            
            let currentQuestionIndex = 0;
            let score = 0;
            let timer;
            let timeLeft = 10; 
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
                
                timeLeft = 10;
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
                const percentage = (timeLeft / 10) * 100;
                
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
                
                setTimeout(() => {
                    currentQuestionIndex++;
                    loadQuestion();
                }, 2000);
            }
            
            function checkAnswer(selectedOption, selectedIndex) {
                clearInterval(timer);
                
                const currentQuestion = questions[currentQuestionIndex];
                const correctAnswerIndex = currentQuestion.correctAnswerIndex;
                
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
                }
                
                setTimeout(() => {
                    currentQuestionIndex++;
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
        });
    </script>
</body>
</html>