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
            max-width: 60%;
            max-height: 300px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const gameData = {!! json_encode($games) !!};
        let currentQuestion = 0;
        let score = 0;
        let spinning = false;
        
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
        
        startBtn.addEventListener('click', function() {
            startScreen.classList.add('d-none');
            gameScreen.classList.remove('d-none');
            spinAndLoadQuestion();
        });
        
        function spinAndLoadQuestion() {
            if (spinning) return;
            spinning = true;
            
            partImage.src = "";
            questionText.textContent = "Loading question...";
            answerInput.value = '';
            answerInput.disabled = true;
            submitBtn.disabled = true;
            
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
                    const randomIndex = Math.floor(Math.random() * totalImages);
                    const finalRotation = (2 * Math.PI) - (angleIncrement * randomIndex);
                    
                    carousel.style.transition = 'transform 1s cubic-bezier(0.25, 0.1, 0.25, 1)';
                    carousel.style.transform = `
                        translate(-50%, -50%)
                        rotateY(${finalRotation}rad)
                    `;
                    
                    setTimeout(() => {
                        animationContainer.remove();
                        partImage.style.display = '';
                        loadQuestion(randomIndex);
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
            feedbackDiv.classList.add('d-none');
            submitBtn.classList.remove('d-none');
            nextBtn.classList.add('d-none');
        }
        
        submitBtn.addEventListener('click', function() {
        const userAnswer = answerInput.value.trim().toLowerCase();
        const correctAnswer = gameData[currentQuestion].answer.toLowerCase();
        
        feedbackDiv.classList.remove('d-none', 'feedback-correct', 'feedback-incorrect');
        
        if (userAnswer === correctAnswer) {
        feedbackDiv.classList.add('feedback-correct');
        feedbackDiv.textContent = "Correct! Well done!";
        score++;
        scoreDisplay.textContent = score;
        
        fetch('{{ route("save.score") }}', {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
        score: score,
        game_type: 'guess_part'
        })
        });
        } else {
        feedbackDiv.classList.add('feedback-incorrect');
        feedbackDiv.textContent = `Incorrect. The correct answer is: ${gameData[currentQuestion].answer}`;
        }
        
        submitBtn.classList.add('d-none');
        nextBtn.classList.remove('d-none');
        });
        
        nextBtn.addEventListener('click', function() {
            spinAndLoadQuestion();
        });
        
        answerInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !submitBtn.classList.contains('d-none')) {
                submitBtn.click();
            }
        });
    </script>
</body>
</html>

