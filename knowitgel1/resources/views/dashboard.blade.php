<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .game-option {
            width: 150px;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            color: white;
            transition: transform 0.2s ease-in-out;
        }
        .game-option:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">KnowItGel1</a>
            <div class="d-flex">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5 text-center">
        <h1>Welcome, {{ auth()->user()->fname }}!</h1>
        <p class="lead">You have successfully logged in.</p>
        <p class="lead">Welcome to KnowItGel1!</p>

        <!-- Button to Open the Modal -->
        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#gameModal">
            Choose a Game
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="gameModal" tabindex="-1" aria-labelledby="gameModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gameModalLabel">Pick a Game</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Choose a game to play:</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('computer.parts') }}" class="game-option bg-success">
                            Know the Computer Parts
                        </a>
                        <a href="{{ route('qa.game') }}" class="game-option bg-warning">
                            Q&A Game
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
