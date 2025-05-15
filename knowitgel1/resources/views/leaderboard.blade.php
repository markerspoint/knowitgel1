@extends('layouts.app')

@section('title', 'Leaderboard')

@push('styles')
<style>
    html {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    html::-webkit-scrollbar {
        display: none;
    }

    .leaderboard-table {
        background: rgba(0, 0, 0, 0.3);
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0, 255, 255, 0.1), inset 0 0 10px rgba(0, 255, 255, 0.05);
    }

    .leaderboard-table thead th {
        background: rgba(0, 255, 255, 0.1);
        color: #00ffff;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        border-bottom: 2px solid rgba(0, 255, 255, 0.3);
        padding: 12px 15px;
        text-shadow: 0 0 5px rgba(0, 255, 255, 0.5);
    }

    .leaderboard-table tbody tr {
        background-color: rgba(255, 255, 255, 0.05);
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .leaderboard-table tbody tr:hover {
        background-color: rgba(0, 255, 255, 0.15);
        transform: scale(1.01);
        box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
    }

    .leaderboard-table tbody td {
        color: #e0e0e0;
        padding: 10px 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        vertical-align: middle;
    }

    .leaderboard-table tbody tr:last-child td {
        border-bottom: none;
    }

    .leaderboard-table tbody tr td:first-child {
        font-weight: bold;
        color: #00ffff;
    }

    .card-header h4 {
        color: #00ffff;
        text-shadow: 0 0 8px rgba(0, 255, 255, 0.7);
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-trophy me-2"></i>Leaderboard</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table leaderboard-table"> {{-- Removed table-striped, using custom styles --}}
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Player</th>
                        <th>Score</th>
                        <th>Game</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($scores as $index => $score)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $score->user->fname }} {{ $score->user->lname }}</td>
                        <td>{{ $score->score }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $score->game_type)) }}</td>
                        <td>{{ $score->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No scores recorded yet. Be the first!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection