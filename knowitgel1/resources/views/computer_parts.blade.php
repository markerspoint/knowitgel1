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
        .game-image {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
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
    <!-- Navbar -->
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

    <!-- Main Content -->
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
                        <img id="part-image" src="{{ asset('images/computer-parts.jpg') }}" class="game-image" alt="Computer Part">
                        <h5 id="question" class="mb-3">What is this computer part?</h5>
                        
                        <div id="feedback" class="feedback-message d-none"></div>
                        
                        <div class="mb-3">
                            <input type="text" id="answer" class="answer-input" placeholder="Enter your answer...">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sample game data - in a real app, this would come from the server
        const gameData = [
            {
                image: "{{ asset('images/cpu.jpg') }}",
                question: "What is this computer part?",
                answer: "CPU"
            },
            {
                image: "{{ asset('images/gpu.jpg') }}",
                question: "What is this computer part?",
                answer: "GPU"
            },
            {
                image: "{{ asset('images/ram.jpg') }}",
                question: "What is this computer part?",
                answer: "RAM"
            }
        ];
        
        let currentQuestion = 0;
        let score = 0;
        
        const partImage = document.getElementById('part-image');
        const questionText = document.getElementById('question');
        const answerInput = document.getElementById('answer');
        const submitBtn = document.getElementById('submit-btn');
        const nextBtn = document.getElementById('next-btn');
        const feedbackDiv = document.getElementById('feedback');
        const scoreDisplay = document.getElementById('score');
        
        // Load the first question
        function loadQuestion() {
            if (currentQuestion < gameData.length) {
                partImage.src = gameData[currentQuestion].image;
                questionText.textContent = gameData[currentQuestion].question;
                answerInput.value = '';
                feedbackDiv.classList.add('d-none');
                submitBtn.classList.remove('d-none');
                nextBtn.classList.add('d-none');
            } else {
                // Game over
                partImage.src = "{{ asset('images/trophy.jpg') }}";
                questionText.textContent = "Game Over!";
                answerInput.style.display = 'none';
                submitBtn.style.display = 'none';
                nextBtn.style.display = 'none';
                feedbackDiv.classList.remove('d-none');
                feedbackDiv.classList.remove('feedback-correct', 'feedback-incorrect');
                feedbackDiv.classList.add('feedback-correct');
                feedbackDiv.textContent = Congratulations! You scored ${score} out of ${gameData.length}!;
            }
        }
        
        // Check the answer
        submitBtn.addEventListener('click', function() {
            const userAnswer = answerInput.value.trim().toLowerCase();
            const correctAnswer = gameData[currentQuestion].answer.toLowerCase();
            
            feedbackDiv.classList.remove('d-none', 'feedback-correct', 'feedback-incorrect');
            
            if (userAnswer === correctAnswer) {
                feedbackDiv.classList.add('feedback-correct');
                feedbackDiv.textContent = "Correct! Well done!";
                score++;
                scoreDisplay.textContent = score;
            } else {
                feedbackDiv.classList.add('feedback-incorrect');
                feedbackDiv.textContent = Incorrect. The correct answer is: ${gameData[currentQuestion].answer};
            }
            
            submitBtn.classList.add('d-none');
            nextBtn.classList.remove('d-none');
        });
        
        // Move to the next question
        nextBtn.addEventListener('click', function() {
            currentQuestion++;
            loadQuestion();
        });
        
        // Allow Enter key to submit
        answerInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !submitBtn.classList.contains('d-none')) {
                submitBtn.click();
            }
        });
        
        // Initialize the game
        loadQuestion();
    </script>
</body>
</html>