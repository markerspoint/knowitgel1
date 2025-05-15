@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-white">KnowItGel Lessons</h1>
        <p class="lead text-light">Interactive learning modules about computer hardware</p>
    </div>

    <div class="row g-4">
        @foreach($lessons as $lesson)
        @php
        // Check if the lesson is completed by the current authenticated user
        // This relies on the 'completedByUsers' relationship being loaded with the current user's ID
        // or using the isCompletedBy() method if you prefer to call it directly in the view (less efficient for lists)
        $isCompleted = Auth::check() && $lesson->completedByUsers->isNotEmpty();
        // Alternatively, if you added an attribute in the controller:
        // $isCompleted = Auth::check() && $lesson->is_completed_by_user;
        @endphp
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 lesson-card {{ $isCompleted ? 'lesson-completed-card' : '' }}">
                @if($lesson->thumbnail)
                <div class="card-img-top">
                    <img src="{{ asset($lesson->thumbnail) }}" class="img-fluid rounded-top" alt="{{ $lesson->title }}">
                </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <div class="mb-3">
                        <h3 class="card-title fw-bold">{{ $lesson->title }}</h3>
                        <div class="badge bg-primary mb-2">Lesson</div>
                    </div>
                    <div class="mt-auto">
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar {{ $isCompleted ? 'bg-success' : 'bg-secondary' }}" role="progressbar" style="width: {{ $isCompleted ? '100%' : '0%' }}" aria-valuenow="{{ $isCompleted ? '100' : '0' }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $isCompleted ? 'Completed' : '0% completed' }}</small>
                            <a href="{{ route('lesson.show', $lesson->id) }}" class="btn btn-primary btn-sm stretched-link">
                                <i class="fas {{ $isCompleted ? 'fa-check-circle' : 'fa-play' }} me-1"></i> {{ $isCompleted ? 'Review Lesson' : 'Start Lesson' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Futuristic 2075 Background Animation -->
<div class="bg-animation-container">
    <div class="bg-grid"></div>
    <div class="cyber-circuit"></div>
    <div class="bg-particles" id="bgParticles"></div>
    <div class="holographic-sphere" style="top: 20%; left: 10%;"></div>
    <div class="holographic-sphere" style="bottom: 30%; right: 15%;"></div>

    <!-- Neural Network Connections -->
    <div class="neural-connection" style="top: 10%; left: 20%; height: 40%;"></div>
    <div class="neural-connection" style="top: 30%; left: 40%; height: 50%;"></div>
    <div class="neural-connection" style="top: 5%; left: 60%; height: 30%;"></div>
    <div class="neural-connection" style="top: 50%; left: 80%; height: 45%;"></div>
    <div class="neural-connection" style="top: 70%; left: 30%; height: 25%;"></div>

    <!-- Floating Data Streams -->
    <div class="floating-data" style="left: 5%;">01001010 10101010 11001100</div>
    <div class="floating-data" style="left: 25%; animation-delay: 2s;">10110101 00110011 10101010</div>
    <div class="floating-data" style="left: 45%; animation-delay: 5s;">11001100 10101010 01001010</div>
    <div class="floating-data" style="left: 65%; animation-delay: 8s;">00110011 01001010 10110101</div>
    <div class="floating-data" style="left: 85%; animation-delay: 11s;">10101010 10110101 11001100</div>
</div>

<style>
    body {
        background: linear-gradient(135deg, #0c1e59 0%, #4b0082 100%);
        min-height: 100vh;
        color: #fff;
        position: relative;
        overflow-x: hidden;
    }

    /* Advanced Futuristic Background - 2075 Edition */
    .bg-animation-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        overflow: hidden;
    }

    .bg-grid {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image:
            linear-gradient(rgba(0, 255, 255, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 255, 255, 0.05) 1px, transparent 1px);
        background-size: 50px 50px;
        perspective: 1000px;
        transform: perspective(1000px) rotateX(60deg) scale(1.5);
        transform-origin: center top;
        animation: grid-movement 20s linear infinite;
    }

    @keyframes grid-movement {
        0% {
            background-position: 0 0;
        }

        100% {
            background-position: 0 50px;
        }
    }

    .cyber-circuit {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('/images/circuit-pattern.png');
        background-size: cover;
        opacity: 0.15;
        mix-blend-mode: screen;
    }

    .holographic-sphere {
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%,
                rgba(255, 255, 255, 0.1) 0%,
                rgba(102, 126, 234, 0.2) 25%,
                rgba(118, 75, 162, 0.3) 50%,
                rgba(0, 0, 0, 0) 70%);
        filter: blur(8px);
        animation: sphere-pulse 8s ease-in-out infinite alternate;
        box-shadow:
            0 0 60px 10px rgba(102, 126, 234, 0.3),
            inset 0 0 30px rgba(255, 255, 255, 0.3);
    }

    @keyframes sphere-pulse {
        0% {
            transform: scale(0.8);
            opacity: 0.4;
        }

        50% {
            transform: scale(1.1);
            opacity: 0.7;
        }

        100% {
            transform: scale(0.9);
            opacity: 0.5;
        }
    }

    .floating-data {
        position: absolute;
        color: rgba(0, 255, 255, 0.3);
        font-family: monospace;
        font-size: 12px;
        white-space: nowrap;
        animation: float-data 15s linear infinite;
        text-shadow: 0 0 5px rgba(0, 255, 255, 0.5);
    }

    @keyframes float-data {
        0% {
            transform: translateY(100vh);
            opacity: 0;
        }

        10% {
            opacity: 0.7;
        }

        90% {
            opacity: 0.7;
        }

        100% {
            transform: translateY(-100px);
            opacity: 0;
        }
    }

    .neural-connection {
        position: absolute;
        width: 2px;
        background: linear-gradient(to bottom, transparent, rgba(0, 255, 255, 0.5), transparent);
        animation: neural-pulse 3s ease-in-out infinite;
    }

    @keyframes neural-pulse {
        0% {
            opacity: 0.3;
            height: 30%;
        }

        50% {
            opacity: 0.8;
            height: 70%;
        }

        100% {
            opacity: 0.3;
            height: 30%;
        }
    }

    .particle {
        position: absolute;
        border-radius: 50%;
        filter: blur(1px);
    }

    @keyframes float-particle {
        0% {
            transform: translate(0, 0) rotate(0deg);
            opacity: 0;
        }

        10% {
            opacity: 0.8;
        }

        90% {
            opacity: 0.8;
        }

        100% {
            transform: translate(var(--tx), var(--ty)) rotate(360deg);
            opacity: 0;
        }
    }

    .bg-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    .lesson-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
        border-radius: 10px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2),
            0 0 20px rgba(102, 126, 234, 0.2);
    }

    .lesson-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2),
            0 0 30px rgba(0, 255, 255, 0.3);
    }

    .lesson-completed-card {
        border-left: 5px solid #198754;
        /* Green border for completed lessons */
    }

    .card-img-top {
        height: 180px;
        overflow: hidden;
    }

    .card-img-top img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Enhanced card styles for 2075 look */
    .card-body {
        position: relative;
        z-index: 1;
    }

    .card-title {
        text-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
    }

    .badge {
        background: linear-gradient(90deg, #4b0082, #0c1e59) !important;
        border: 1px solid rgba(0, 255, 255, 0.3);
        box-shadow: 0 0 10px rgba(0, 255, 255, 0.2);
    }

    .btn-primary {
        background: linear-gradient(90deg, #4b0082, #0c1e59);
        border: 1px solid rgba(0, 255, 255, 0.3);
        box-shadow: 0 0 10px rgba(0, 255, 255, 0.2);
        transition: all 0.3s;
    }

    .btn-primary:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(0, 255, 255, 0.4);
    }

    .game-avatar {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 150px;
        height: 200px;
        z-index: 100;
        transition: all 0.3s ease;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .avatar-container {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .avatar-body {
        position: absolute;
        width: 100%;
        height: 80%;
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        border-radius: 50% 50% 35% 35%;
        overflow: visible;
        box-shadow:
            0 0 10px rgba(45, 200, 255, 0.5),
            inset 0 0 15px rgba(45, 200, 255, 0.3);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .avatar-eyes {
        display: flex;
        justify-content: space-around;
        width: 70%;
        margin-top: -5px;
        position: relative;
        z-index: 2;
    }

    .avatar-glasses {
        position: absolute;
        width: 85%;
        height: 35px;
        background: linear-gradient(to bottom, rgba(0, 255, 255, 0.6), rgba(0, 255, 255, 0.2));
        border-radius: 15px;
        top: -2px;
        left: 7.5%;
        z-index: 1;
        backdrop-filter: blur(2px);
        box-shadow: inset 0 0 10px rgba(0, 255, 255, 0.3);
    }

    .avatar-glasses::before {
        content: '';
        position: absolute;
        width: 15px;
        height: 5px;
        background-color: #0076b3;
        /* Blue color for the bridge of the glasses */
        top: 15px;
        left: 50%;
        transform: translateX(-50%);
    }

    .avatar-eye {
        width: 30px;
        height: 30px;
        background-color: #000;
        border-radius: 50%;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 0 10px rgba(0, 255, 255, 0.7);
        overflow: hidden;
        z-index: 2;
    }

    .avatar-pupil {
        width: 16px;
        height: 16px;
        background: radial-gradient(circle at 30% 30%, #0ff, #009999);
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .avatar-mouth {
        width: 40px;
        height: 10px;
        margin-top: 15px;
        border-radius: 50%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 2;
    }

    .avatar-mouth::before,
    .avatar-mouth::after {
        content: '';
        width: 10px;
        height: 10px;
        background: radial-gradient(circle, #0ff, #009999);
        border-radius: 50%;
        box-shadow: 0 0 8px #0ff;
        animation: blinkLED 1s infinite alternate;
    }

    .avatar-mouth::before {
        animation-delay: 0s;
    }

    .avatar-mouth::after {
        animation-delay: 0.3s;
    }

    @keyframes blinkLED {
        from {
            opacity: 0.3;
            box-shadow: 0 0 4px #0ff;
        }

        to {
            opacity: 1;
            box-shadow: 0 0 10px #0ff;
        }
    }

    .avatar-antennas {
        position: absolute;
        top: -30px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 40px;
    }

    .avatar-antenna {
        width: 6px;
        height: 30px;
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        border-radius: 50% 50% 35% 35%;
        overflow: visible;
        box-shadow:
            0 0 10px rgba(45, 200, 255, 0.5),
            inset 0 0 15px rgba(45, 200, 255, 0.3);
        position: relative;
        z-index: -1;
    }

    @keyframes pulse {

        0%,
        100% {
            box-shadow: 0 0 5px 2px rgba(45, 200, 255, 0.8);
        }

        50% {
            box-shadow: 0 0 15px 4px rgba(45, 200, 255, 1);
        }
    }

    .avatar-antenna::before {
        content: '';
        position: absolute;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        top: -15px;
        left: 50%;
        transform: translateX(-50%);
        animation: pulse 2s infinite;
    }

    .avatar-arms {
        position: absolute;
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 -10px;
    }

    .avatar-arm {
        width: 15px;
        height: 40px;
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        border-radius: 50% 50% 35% 35%;
        overflow: visible;
        box-shadow:
            0 0 10px rgba(45, 200, 255, 0.5),
            inset 0 0 15px rgba(45, 200, 255, 0.3);
        transition: all 0.3s ease;
    }

    .avatar-arm.left {
        transform: rotate(20deg);
        transform-origin: top left;
        position: absolute;
        left: -10px;
        top: 40px;
    }

    .avatar-arm.right {
        transform: rotate(-20deg);
        transform-origin: top right;
        position: absolute;
        right: -10px;
        top: 40px;
    }

    .avatar-circuit-line {
        position: absolute;
        width: 120%;
        height: 120%;
        top: -10%;
        left: -10%;
        background-image: url('/images/circuit-pattern.png');
        background-size: cover;
        opacity: 0.15;
        mix-blend-mode: screen;
        animation: rotateCircuit 30s linear infinite;
        z-index: 0;
    }

    @keyframes rotateCircuit {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* Avatar animations */
    @keyframes celebrate-avatar {
        0% {
            transform: translateY(0) rotate(0deg);
        }

        25% {
            transform: translateY(-25px) rotate(5deg) scale(1.1);
        }

        50% {
            transform: translateY(0) rotate(-5deg) scale(1.05);
        }

        75% {
            transform: translateY(-20px) rotate(5deg) scale(1.1);
        }

        100% {
            transform: translateY(0) rotate(0deg) scale(1);
        }
    }

    @keyframes sad-avatar {
        0% {
            transform: translateY(0) rotate(0deg);
        }

        25% {
            transform: translateY(10px) rotate(-3deg);
        }

        50% {
            transform: translateY(5px) rotate(3deg);
        }

        75% {
            transform: translateY(8px) rotate(-2deg);
        }

        100% {
            transform: translateY(0) rotate(0deg);
        }
    }

    .avatar-celebrating .avatar-body {
        animation: celebrate-avatar 1s ease-in-out infinite alternate;
        background: linear-gradient(135deg, #00d68f, #00c4cc);
        box-shadow: 0 0 20px rgba(0, 255, 255, 0.6);
    }

    /* .avatar-celebrating .avatar-mouth {
            height: 15px;
            width: 30px;
            border-radius: 50px 50px 0 0;
            background-color: #0076b3;
        }
         */
    .avatar-celebrating .avatar-arm.left {
        transform: rotate(-60deg) translateY(-10px);
        animation: wave-arm 0.5s ease-in-out infinite alternate;
    }

    @keyframes wave-arm {
        from {
            transform: rotate(-60deg) translateY(-10px);
        }

        to {
            transform: rotate(-80deg) translateY(-15px);
        }
    }

    .avatar-celebrating .avatar-arm.right {
        transform: rotate(60deg) translateY(-10px);
    }

    .avatar-celebrating .avatar-eye {
        transform: scale(1.2);
    }

    .avatar-sad .avatar-body {
        animation: sad-avatar 1.5s ease-in-out;
        background-color: #29a9e0;
    }

    .avatar-sad .avatar-mouth {
        height: 15px;
        width: 30px;
        border-radius: 50px 50px 0 0;
        /* transform: rotate(180deg); */
        background-color: #0076b3;
    }

    .avatar-sad .avatar-arm.left {
        transform: rotate(-10deg) translateY(5px);
    }

    .avatar-sad .avatar-arm.right {
        transform: rotate(10deg) translateY(5px);
    }

    .avatar-sad .avatar-eye {
        transform: scaleY(0.8);
    }

    .avatar-speech-bubble {
        position: absolute;
        top: -100px;
        right: 30px;
        background-color: white;
        color: #333;
        padding: 10px 15px;
        border-radius: 15px;
        font-size: 14px;
        font-weight: bold;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
        pointer-events: none;
        max-width: 200px;
        width: 200px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .avatar-speech-bubble::after {
        border-top-color: #0ff;
    }

    .avatar-speech-bubble.show {
        animation: fadeInOut 4s ease-in-out;
    }

    @keyframes fadeInOut {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        10%,
        90% {
            opacity: 1;
            transform: translateY(0);
        }

        100% {
            opacity: 0;
            transform: translateY(-20px);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bgParticles = document.getElementById('bgParticles');


        function createBackgroundParticles() {
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');


                const size = Math.random() * 4 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;


                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;


                const colors = [
                    'rgba(0, 255, 255, 0.7)',
                    'rgba(102, 126, 234, 0.7)',
                    'rgba(118, 75, 162, 0.7)',
                    'rgba(255, 255, 255, 0.7)'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.backgroundColor = color;
                particle.style.boxShadow = `0 0 ${size * 2}px ${color}`;


                const duration = Math.random() * 20 + 10;
                const delay = Math.random() * 10;


                const tx = (Math.random() > 0.5 ? '+' : '-') + (Math.random() * 100 + 50) + 'px';
                const ty = (Math.random() > 0.5 ? '+' : '-') + (Math.random() * 100 + 50) + 'px';
                particle.style.setProperty('--tx', tx);
                particle.style.setProperty('--ty', ty);

                particle.style.animation = `float-particle ${duration}s linear ${delay}s infinite`;

                bgParticles.appendChild(particle);
            }
        }

        createBackgroundParticles();
    });
</script>

<div class="game-avatar" id="lessonGameAvatar">
    <div class="avatar-container">
        <div class="avatar-circuit-line"></div>
        <div class="avatar-body">
            <div class="avatar-glasses"></div>
            <div class="avatar-eyes">
                <div class="avatar-eye">
                    <div class="avatar-pupil"></div>
                </div>
                <div class="avatar-eye">
                    <div class="avatar-pupil"></div>
                </div>
            </div>
            <div class="avatar-mouth"></div>
        </div>
        <div class="avatar-antennas">
            <div class="avatar-antenna"></div>
            <div class="avatar-antenna"></div>
        </div>
        <div class="avatar-arms">
            <div class="avatar-arm left"></div>
            <div class="avatar-arm right"></div>
        </div>
    </div>
    <div class="avatar-speech-bubble" id="avatarSpeechBubble">Ready to learn!</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const speechBubble = document.getElementById('avatarSpeechBubble');
        if (speechBubble) {
            setTimeout(() => {
                speechBubble.classList.add('show');
            }, 1000);
        }

        const lessonCards = document.querySelectorAll('.lesson-card');
        lessonCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                const avatar = document.getElementById('lessonGameAvatar');
                const bubble = document.getElementById('avatarSpeechBubble');
                if (avatar && bubble) {
                    bubble.textContent = 'This lesson will teach you important concepts!';
                    bubble.classList.add('show');
                }
            });

            card.addEventListener('mouseleave', function() {
                const bubble = document.getElementById('avatarSpeechBubble');
                if (bubble) {
                    bubble.classList.remove('show');
                }
            });
        });
    });
</script>
</script>
@endsection