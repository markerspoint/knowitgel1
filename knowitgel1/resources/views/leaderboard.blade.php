@extends('layouts.app')

@section('title', 'Leaderboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-trophy me-2"></i>Leaderboard</h4>
    </div>
    <div class="card-body">
        <table class="table table-striped">
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
                @foreach($scores as $index => $score)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $score->user->fname }} {{ $score->user->lname }}</td>
                    <td>{{ $score->score }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $score->game_type)) }}</td>
                    <td>{{ $score->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection