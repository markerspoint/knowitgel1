<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - KnowItGel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
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
                        <a class="nav-link" href="#">
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
            <div class="col-md-6 mb-4">
                <div class="card game-card computer-parts">
                    <div class="card-body text-white">
                        <h5 class="card-title">Guess the Computer Parts</h5>
                        <p class="card-text">Test your knowledge about computer hardware components!</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('computer.parts') }}" class="btn btn-primary">
                                <i class="fas fa-play me-1"></i>Play Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card game-card qa-game">
                    <div class="card-body text-white">
                        <h5 class="card-title">Q&A Game</h5>
                        <p class="card-text">Answer questions about computer parts and technology!</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('qa.game') }}" class="btn btn-primary">
                                <i class="fas fa-play me-1"></i>Play Now
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
                        <h4>Your Score</h4>
                        <h2>0</h2>
                        <p class="text-muted">Start playing to earn points!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-gamepad fa-3x mb-3"></i>
                        <h4>Games Played</h4>
                        <h2>0</h2>
                        <p class="text-muted">Keep playing to improve!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-star fa-3x mb-3"></i>
                        <h4>Achievements</h4>
                        <h2>0</h2>
                        <p class="text-muted">Unlock achievements as you play!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>