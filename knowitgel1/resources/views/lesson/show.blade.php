@extends('layouts.app')

@section('content')
<div class="container py-5 lesson-show-page"> {{-- lesson-show-page class for potential specific page overrides --}}
    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if(session('success'))
            <div class="alert alert-success-futuristic">{{ session('success') }}</div>
            @endif
            @if(session('info'))
            <div class="alert alert-info-futuristic">{{ session('info') }}</div>
            @endif

            <div class="card shadow-sm lesson-card-details"> {{-- This card will use the global .card style from app.blade.php and can be further customized below --}}
                <div class="card-header lesson-card-header text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="mb-0 h3 lesson-title">{{ $lesson->title }}</h1>
                        <a href="{{ route('lesson.game') }}" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to Lessons
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    @php
                    $isCompletedByUser = Auth::check() && $lesson->isCompletedBy(Auth::user());
                    $completionRecord = Auth::check() ? $lesson->getCompletionRecord(Auth::user()) : null;
                    @endphp

                    <div class="lesson-meta mb-4 border-bottom-futuristic pb-3">
                        <h2 class="h5 lesson-subtitle">Lesson Overview</h2>
                        <p class="lead lesson-description">{{ $lesson->description }}</p>
                        @if(Auth::check())
                        @if($isCompletedByUser && $completionRecord)
                        <p class="text-success-futuristic"><i class="fas fa-check-circle"></i> You completed this lesson on {{ \Carbon\Carbon::parse($completionRecord->completed_at)->format('M d, Y') }}.</p>
                        @else
                        <form action="{{ route('lesson.complete', $lesson->id) }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-success-futuristic">
                                <i class="fas fa-check"></i> Mark as Complete
                            </button>
                        </form>
                        @endif
                        @endif
                    </div>

                    <div class="lesson-content-section">
                        <h2 class="h4 mb-3 lesson-subtitle">Lesson Content</h2>
                        <div class="lesson-content-wrapper">
                            {!! $lesson->content !!}
                        </div>
                    </div>
                </div>

                <div class="card-footer lesson-card-footer d-flex justify-content-between align-items-center">
                    <div>
                        <small>Lesson Status: {{ ucfirst($lesson->status) }}</small><br>
                        @if(Auth::check())
                        <small>Your Progress:
                            @if($isCompletedByUser)
                            <span class="text-success-futuristic fw-bold">Completed</span>
                            @else
                            <span class="text-warning-futuristic fw-bold">In Progress</span>
                            @endif
                        </small>
                        @endif
                    </div>
                    {{-- Add next/previous lesson buttons if needed --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    html {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    html::-webkit-scrollbar {
        display: none;
    }

    .lesson-show-page {
        position: relative;
        z-index: 1;
    }

    .lesson-card-details {

        border: 1px solid rgba(0, 255, 255, 0.3);
        box-shadow: 0 0 25px rgba(0, 255, 255, 0.15),
            inset 0 0 15px rgba(0, 0, 0, 0.2);
    }

    .lesson-card-header {
        background: linear-gradient(90deg, rgba(75, 0, 130, 0.5), rgba(12, 30, 89, 0.5)) !important;
        border-bottom: 1px solid rgba(0, 255, 255, 0.2);
    }

    .lesson-title {
        color: #00ffff;
        text-shadow: 0 0 10px rgba(0, 255, 255, 0.7);
    }

    .lesson-subtitle {
        color: #c0c0ff;
        text-shadow: 0 0 8px rgba(192, 192, 255, 0.5);
    }

    .lesson-description {
        color: #d0d0e0;
        font-size: 1.1rem;
    }

    .border-bottom-futuristic {
        border-bottom: 1px solid rgba(0, 255, 255, 0.2) !important;
    }

    .lesson-content-wrapper {
        background-color: rgba(0, 0, 0, 0.3);
        /* Darker content area */
        padding: 1.5rem 2rem;
        border-radius: 8px;
        line-height: 1.8;
        border: 1px solid rgba(0, 255, 255, 0.1);
        box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.2);
        color: #e0e0e0;
    }

    .lesson-content-wrapper h1,
    .lesson-content-wrapper h2,
    .lesson-content-wrapper h3,
    .lesson-content-wrapper h4 {
        margin-top: 1.5em;
        margin-bottom: 0.75em;
        font-weight: 600;
        color: #00ffff;
        text-shadow: 0 0 8px rgba(0, 255, 255, 0.5);
    }

    .lesson-content-wrapper p {
        margin-bottom: 1.2em;
        color: #d0d0e0;
    }

    .lesson-content-wrapper img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5em 0;
        border: 2px solid rgba(0, 255, 255, 0.3);
        box-shadow: 0 0 25px rgba(0, 255, 255, 0.3);
    }

    .lesson-card-footer {
        background: rgba(0, 0, 0, 0.2) !important;
        border-top: 1px solid rgba(0, 255, 255, 0.15);
        color: #a0a0c0 !important;
    }

    .lesson-card-footer small {
        font-size: 0.9rem;
    }


    .btn-success-futuristic {
        background: linear-gradient(45deg, #00b09b, #00e676);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        box-shadow: 0 0 15px rgba(0, 200, 150, 0.4);
        transition: all 0.3s ease;
    }

    .btn-success-futuristic:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 0 25px rgba(0, 220, 180, 0.6);
        color: white;
    }

    .btn-outline-light {
        border-color: rgba(0, 255, 255, 0.5);
        color: rgba(0, 255, 255, 0.8);
        transition: all 0.3s ease;
    }

    .btn-outline-light:hover {
        background-color: rgba(0, 255, 255, 0.1);
        border-color: rgba(0, 255, 255, 0.8);
        color: #00ffff;
        box-shadow: 0 0 10px rgba(0, 255, 255, 0.3);
    }


    .text-success-futuristic {
        color: #00ffaa !important;
        text-shadow: 0 0 10px rgba(0, 255, 170, 0.6);
    }

    .text-warning-futuristic {
        color: #ffdd44 !important;
        text-shadow: 0 0 10px rgba(255, 221, 68, 0.6);
    }


    .alert-success-futuristic,
    .alert-info-futuristic {
        border-radius: 8px;
        padding: 15px;
        color: #e0e0ff;
        text-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    .alert-success-futuristic {
        background: rgba(0, 176, 155, 0.25);
        border: 1px solid rgba(0, 176, 155, 0.5);
    }

    .alert-info-futuristic {
        background: rgba(102, 126, 234, 0.25);
        border: 1px solid rgba(102, 126, 234, 0.5);
    }
</style>
@endpush