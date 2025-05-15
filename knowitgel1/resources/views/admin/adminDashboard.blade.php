<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - KnowItGel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.95);
            margin-bottom: 20px;
        }

        .card-header {
            background: transparent;
            border-bottom: none;
            padding: 20px;
        }

        .card-header h4 {
            color: #333;
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

        .table {
            margin-bottom: 0;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #555;
        }

        .table td {
            vertical-align: middle;
        }

        .nav-link {
            color: #fff;
            font-weight: 500;
            transition: all 0.3s;
        }

        .nav-link:hover {
            color: black;
            opacity: 0.8;
        }

        .nav-link.active {
            color: black !important;
            background-color: #fff;
            opacity: 1;
            border-radius: 5px;
        }

        .nav-link.active * {
            color: black !important;
        }

        .form-control {
            border-radius: 10px;
            padding: 8px 12px;
            border: 1px solid #ddd;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .alert {
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-gamepad me-2"></i>KnowItGel Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav nav-tabs navbar-nav me-auto" id="adminTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="users-tab" data-bs-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="true">
                            <i class="fas fa-users me-1"></i>Users
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="games-tab" data-bs-toggle="tab" href="#games" role="tab" aria-controls="games" aria-selected="false">
                            <i class="fas fa-gamepad me-1"></i>Games
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="lessons-tab" data-bs-toggle="tab" href="#lessons" role="tab" aria-controls="lessons" aria-selected="false">
                            <i class="fas fa-book me-1"></i>Lessons
                        </a>
                    </li>
                </ul>
                <form action="{{ route('logout') }}" method="POST" class="d-flex">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">
                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="tab-content">
            <div class="tab-pane fade show active" id="users">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4><i class="fas fa-users me-2"></i>User Management</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->fname }} {{ $user->lname }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>
                                            {{-- Toggle Disable/Enable User Form --}}
                                            <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH') {{-- Or PUT --}}
                                                @if($user->is_disabled)
                                                <button type="submit" class="btn btn-sm btn-success" title="Enable User">
                                                    <i class="fas fa-check-circle"></i> Enable
                                                </button>
                                                @else
                                                <button type="submit" class="btn btn-sm btn-warning" title="Disable User">
                                                    <i class="fas fa-ban"></i> Disable
                                                </button>
                                                @endif
                                            </form>

                                            {{-- Delete User Form --}}
                                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="games">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4><i class="fas fa-gamepad me-2"></i>Game Management</h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGameModal">
                            <i class="fas fa-plus me-1"></i>Add New Game
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Thumbnail</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($games as $game)
                                    <tr>
                                        <td>
                                            <img src="{{ asset($game->thumbnail) }}" alt="{{ $game->title }}"
                                                class="img-thumbnail" style="max-width: 100px;">
                                        </td>
                                        <td>{{ $game->title }}</td>
                                        <td>{{ Str::limit($game->description, 100) }}</td>
                                        <td>
                                            {{ $game->type === 'guess_part' ? 'Guess the Computer Part' : ($game->type === 'qa' ? 'Q&A Game' : ucfirst($game->type)) }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $game->status === 'active' ? 'success' : 'danger' }}">
                                                {{ ucfirst($game->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editGameModal{{ $game->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.games.delete', $game) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this game?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="lessons">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4><i class="fas fa-book me-2"></i>Lesson Management</h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLessonModal">
                            <i class="fas fa-plus me-1"></i>Add New Lesson
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lessons as $lesson)
                                    <tr>
                                        <td>{{ $lesson->title }}</td>
                                        <td>{{ Str::limit($lesson->description, 50) }}</td>
                                        <td>{{ ucfirst($lesson->type) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $lesson->status === 'active' ? 'success' : 'danger' }}">
                                                {{ ucfirst($lesson->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.lessons.edit', $lesson->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.lessons.delete', $lesson->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modals should be defined here (Add Game, Add Lesson, Edit Game, Edit User etc.) --}}
    {{-- Example Placeholder for Edit User Modal --}}
    {{-- @foreach($users as $user)
    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit User: {{ $user->username }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Form fields for fname, lname, email, username --}}
                    {{-- Example: --}}
                    {{-- <div class="mb-3">
                            <label for="fname{{ $user->id }}" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="fname{{ $user->id }}" name="fname" value="{{ $user->fname }}" required>
                </div> --}}
                {{-- ... other fields ... --}}
                {{-- </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach --}}

                {{-- Existing Add Game Modal --}}
                <div class="modal fade" id="addGameModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Game</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.games.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                                        @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3" required>{{ old('description') }}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Game Type</label>
                                        <select class="form-select @error('type') is-invalid @enderror" name="type" id="gameType" required>
                                            <option value="">Select Game Type</option>
                                            <option value="guess_part">Guess the Computer Part</option>
                                            <option value="qa">Q&A Game</option>
                                        </select>
                                        @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3" id="gameFileSection">
                                        <label class="form-label">Computer Part Image</label>
                                        <input type="file" class="form-control @error('game_file') is-invalid @enderror" name="game_file" accept="image/*">
                                        @error('game_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Upload an image of the computer part</small>
                                    </div>

                                    <div class="mb-3" id="optionsSection" style="display: none;">
                                        <label class="form-label">Options (comma separated)</label>
                                        <input type="text" class="form-control @error('options') is-invalid @enderror" name="options" value="{{ old('options') }}" placeholder="Option 1, Option 2, Option 3">
                                        @error('options')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Enter multiple choice options separated by commas</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Question</label>
                                        <input type="text" class="form-control @error('question') is-invalid @enderror" name="question" value="{{ old('question') }}" required>
                                        @error('question')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Enter the question about the computer part</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Answer</label>
                                        <input type="text" class="form-control @error('answer') is-invalid @enderror" name="answer" value="{{ old('answer') }}" required>
                                        @error('answer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Enter the correct answer</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Thumbnail</label>
                                        <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" accept="image/*" required>
                                        @error('thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Upload a thumbnail image for the game</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Upload Game</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

                <script>
                    // Game type selection handler
                    document.addEventListener('DOMContentLoaded', function() {
                        const gameTypeSelect = document.getElementById('gameType');
                        const gameFileSection = document.getElementById('gameFileSection');
                        const optionsSection = document.getElementById('optionsSection');

                        // Initial check
                        updateFormSections();

                        // Add change event listener
                        gameTypeSelect.addEventListener('change', updateFormSections);

                        function updateFormSections() {
                            const selectedType = gameTypeSelect.value;

                            if (selectedType === 'guess_part') {
                                gameFileSection.style.display = 'block';
                                optionsSection.style.display = 'none';
                            } else if (selectedType === 'qa') {
                                gameFileSection.style.display = 'none';
                                optionsSection.style.display = 'block';
                            } else {
                                // Default or no selection
                                gameFileSection.style.display = 'none';
                                optionsSection.style.display = 'none';
                            }
                        }
                    });
                </script>
</body>

</html>

<div class="modal fade" id="addLessonModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Lesson</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.lessons.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea class="form-control" name="content" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Thumbnail</label>
                        <input type="file" class="form-control" name="thumbnail" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Lesson</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($games as $game)
<!-- Edit Game Modal for {{ $game->title }} -->
<div class="modal fade" id="editGameModal{{ $game->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Game: {{ $game->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.games.update', $game) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $game->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3" required>{{ $game->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Game Type</label>
                        <select class="form-select" name="type" id="editGameType{{ $game->id }}" required>
                            <option value="guess_part" {{ $game->type === 'guess_part' ? 'selected' : '' }}>Guess the Computer Part</option>
                            <option value="qa" {{ $game->type === 'qa' ? 'selected' : '' }}>Q&A Game</option>
                        </select>
                    </div>

                    <div class="mb-3" id="editGameFileSection{{ $game->id }}">
                        <label class="form-label">Computer Part Image</label>
                        <input type="file" class="form-control" name="game_file" accept="image/*">
                        @if($game->game_file)
                        <small class="text-muted">Current: {{ basename($game->game_file) }}</small>
                        @endif
                    </div>

                    <div class="mb-3" id="editOptionsSection{{ $game->id }}" style="display: none;">
                        <label class="form-label">Options (comma separated)</label>
                        <input type="text" class="form-control" name="options"
                            value="{{ $game->options ? implode(',', json_decode($game->options, true)) : '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="active" {{ $game->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $game->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Toggle sections based on game type
    document.getElementById('editGameType{{ $game->id }}').addEventListener('change', function() {
        const gameType = this.value;
        const gameFileSection = document.getElementById('editGameFileSection{{ $game->id }}');
        const optionsSection = document.getElementById('editOptionsSection{{ $game->id }}');

        if (gameType === 'guess_part') {
            gameFileSection.style.display = 'block';
            optionsSection.style.display = 'none';
        } else {
            gameFileSection.style.display = 'none';
            optionsSection.style.display = 'block';
        }
    });

    // Initialize sections based on current game type
    document.addEventListener('DOMContentLoaded', function() {
        const gameType = '{{ $game->type }}';
        const gameFileSection = document.getElementById('editGameFileSection{{ $game->id }}');
        const optionsSection = document.getElementById('editOptionsSection{{ $game->id }}');

        if (gameType === 'guess_part') {
            gameFileSection.style.display = 'block';
            optionsSection.style.display = 'none';
        } else {
            gameFileSection.style.display = 'none';
            optionsSection.style.display = 'block';
        }
    });
</script>
@endforeach