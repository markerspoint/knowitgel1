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
        
        /* Avatar celebration animation styles */
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
            0% { transform: scale(0.1) rotate(-10deg); opacity: 0; }
            20% { transform: scale(1.1) rotate(10deg); opacity: 1; }
            40% { transform: scale(0.9) rotate(-5deg); }
            60% { transform: scale(1.05) rotate(5deg); }
            80% { transform: scale(0.95) rotate(-2deg); }
            100% { transform: scale(1) rotate(0); }
        }
        
        .fireworks {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 999;
        }
        
        .firework {
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            animation: firework-animation 1s ease-out;
            opacity: 0;
        }
        
        @keyframes firework-animation {
            0% { transform: translateY(0); opacity: 1; }
            100% { transform: translateY(-100px); opacity: 0; }
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
                            <div id="description-area" class="mt-2 d-none" style="font-size: 0.9rem; color: rgba(255,255,255,0.85);"></div>
                            
                            <div class="mb-3">
                                {{-- Added autocomplete="off" to disable browser history/suggestions --}}
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const gameData = {!! json_encode($games) !!};
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
                    if(existingGameOverMsg) existingGameOverMsg.remove();
                    const existingRestartBtn = gameScreen.querySelector('.btn.btn-primary.mt-3');
                    if(existingRestartBtn) existingRestartBtn.remove();
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
    </script>
    
    <div id="celebration-container" class="celebration-container">
        <div class="fireworks" id="fireworks"></div>
        <div class="celebration-avatar">🏆</div>
    </div>
</body>
</html>

