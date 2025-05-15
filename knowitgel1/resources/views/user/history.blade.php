@extends('layouts.app')

@section('title', 'User History')

@push('styles')
<style>
    html {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    html::-webkit-scrollbar {
        display: none;
    }

    .history-table {
        background: rgba(0, 0, 0, 0.3);
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0, 255, 255, 0.1), inset 0 0 10px rgba(0, 255, 255, 0.05);
        margin-bottom: 2rem;
    }

    .history-table thead th {
        background: rgba(0, 255, 255, 0.1);
        color: #00ffff;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        border-bottom: 2px solid rgba(0, 255, 255, 0.3);
        padding: 12px 15px;
        text-shadow: 0 0 5px rgba(0, 255, 255, 0.5);
    }

    .history-table tbody tr {
        background-color: rgba(255, 255, 255, 0.05);
        transition: background-color 0.3s ease;
    }

    .history-table tbody tr:hover {
        background-color: rgba(0, 255, 255, 0.15);
    }

    .history-table tbody td {
        color: #e0e0e0;
        padding: 10px 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        vertical-align: middle;
    }

    .history-table tbody tr:last-child td {
        border-bottom: none;
    }

    .card-header h4 {
        color: #00ffff;
        text-shadow: 0 0 8px rgba(0, 255, 255, 0.7);
    }

    .history-section-title {
        color: #c0c0ff;
        text-shadow: 0 0 6px rgba(192, 192, 255, 0.5);
        margin-bottom: 1rem;
        font-size: 1.5rem;
        border-bottom: 1px solid rgba(192, 192, 255, 0.2);
        padding-bottom: 0.5rem;
    }

    .alert-info-futuristic {
        background: rgba(102, 126, 234, 0.2);
        border: 1px solid rgba(102, 126, 234, 0.4);
        color: #e0e0ff;
        border-radius: 8px;
        padding: 15px;
        text-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4><i class="fas fa-history me-2"></i>Your Activity History</h4>
        </div>
        <div class="card-body">
            @if(Auth::user()->scores->isNotEmpty() || Auth::user()->completedLessons->isNotEmpty())
            <div class="row">
                @if(Auth::user()->scores->isNotEmpty())
                <div class="col-md-12 mb-4">
                    <h5 class="history-section-title">Game Scores</h5>
                    <div class="table-responsive">
                        <table class="table history-table"> {{-- Removed table-striped --}}
                            <thead>
                                <tr>
                                    <th>Game</th>
                                    <th>Score</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Auth::user()->scores()->orderBy('created_at', 'desc')->get() as $score)
                                <tr>
                                    <td>{{ ucfirst(str_replace('_', ' ', $score->game_type)) }}</td>
                                    <td>{{ $score->score }}</td>
                                    <td>{{ $score->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                @if(Auth::user()->completedLessons->isNotEmpty())
                <div class="col-md-12">
                    <h5 class="history-section-title">Completed Lessons</h5>
                    <div class="table-responsive">
                        <table class="table history-table"> {{-- Removed table-striped --}}
                            <thead>
                                <tr>
                                    <th>Lesson</th>
                                    <th>Completed On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Auth::user()->completedLessons()->orderBy('pivot_completed_at', 'desc')->get() as $lesson)
                                <tr>
                                    <td>{{ $lesson->title ?? 'Lesson #'.$lesson->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($lesson->pivot->completed_at ?? $lesson->pivot->created_at)->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
            @else
            <div class="alert alert-info-futuristic">
                <p class="mb-0">You haven't completed any games or lessons yet. Start playing to see your history!</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection