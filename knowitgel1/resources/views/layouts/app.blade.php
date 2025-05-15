<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KnowItGel - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0c1e59 0%, #4b0082 100%);
            /* Updated gradient */
            min-height: 100vh;
            color: #fff;
            position: relative;
            /* Added for positioning context */
            overflow-x: hidden;
            /* Prevent horizontal scroll from animations */
        }

        /* Advanced Futuristic Background - 2075 Edition - Core Styles */
        .bg-animation-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            /* Behind all content */
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
            /* Ensure this image exists */
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

        .bg-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            filter: blur(1px);
            /* Animation will be set by JS */
        }

        @keyframes float-particle {

            /* Used by JS */
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

        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            /* Ensure navbar is above background */
            z-index: 10;
        }

        .card {
            /* Existing card style, good for futuristic theme */
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            color: #fff;
            position: relative;
            /* Ensure card content is above background */
            z-index: 1;
        }

        /* Stacked styles from child pages */
        @stack('styles')
    </style>
</head>

<body>
    <!-- Futuristic 2075 Background Animation Elements -->
    <div class="bg-animation-container">
        <div class="bg-grid"></div>
        <div class="cyber-circuit"></div>
        <div class="bg-particles" id="bgParticles"></div>
        <div class="holographic-sphere" style="top: 15%; left: 10%; width:200px; height:200px; animation-duration: 7s;"></div>
        <div class="holographic-sphere" style="bottom: 20%; right: 15%; width:250px; height:250px; animation-delay: -3s; animation-duration: 9s;"></div>
        <div class="holographic-sphere" style="top: 50%; left: 45%; width:150px; height:150px; animation-delay: -1s; animation-duration: 6s; opacity: 0.5;"></div>

        <div class="neural-connection" style="top: 10%; left: 20%; height: 40%; animation-duration: 2.5s;"></div>
        <div class="neural-connection" style="top: 30%; left: 40%; height: 50%; animation-duration: 3s; animation-delay: -0.5s;"></div>
        <div class="neural-connection" style="top: 5%; left: 60%; height: 30%; animation-duration: 2s; animation-delay: -1s;"></div>
        <div class="neural-connection" style="top: 50%; left: 80%; height: 45%; animation-duration: 3.5s; animation-delay: -1.5s;"></div>
        <div class="neural-connection" style="top: 70%; left: 30%; height: 25%; animation-duration: 2.8s; animation-delay: -0.2s;"></div>

        <div class="floating-data" style="left: 5%; animation-delay: 0s;">01101010 11101001 10010110</div>
        <div class="floating-data" style="left: 25%; animation-delay: -3s;">DATASTREAM ACTIVE 2075</div>
        <div class="floating-data" style="left: 45%; animation-delay: -6s;">KNOWITGEL SYSTEMS ONLINE</div>
        <div class="floating-data" style="left: 65%; animation-delay: -9s;">SECURE CONNECTION</div>
        <div class="floating-data" style="left: 85%; animation-delay: -12s;">10011100 01101010 00110011</div>
    </div>

    <!-- Navbar -->
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
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bgParticlesContainer = document.getElementById('bgParticles');
            if (bgParticlesContainer) {
                function createBackgroundParticles() {
                    for (let i = 0; i < 50; i++) { // Number of particles
                        const particle = document.createElement('div');
                        particle.classList.add('particle');

                        const size = Math.random() * 3 + 1; // Particle size (1px to 4px)
                        particle.style.width = `${size}px`;
                        particle.style.height = `${size}px`;

                        particle.style.left = `${Math.random() * 100}%`;
                        particle.style.top = `${Math.random() * 100}%`;

                        const colors = ['rgba(0, 255, 255, 0.7)', 'rgba(102, 126, 234, 0.7)', 'rgba(200, 100, 255, 0.7)', 'rgba(255, 255, 255, 0.6)'];
                        const color = colors[Math.floor(Math.random() * colors.length)];
                        particle.style.backgroundColor = color;
                        particle.style.boxShadow = `0 0 ${size * 1.5}px ${size * 0.5}px ${color.replace('0.7', '0.3').replace('0.6', '0.2')}`;

                        const duration = Math.random() * 15 + 10; // Animation duration (10s to 25s)
                        const delay = Math.random() * 10; // Animation delay (0s to 10s)

                        // For @keyframes float-particle
                        particle.style.setProperty('--tx', `${(Math.random() - 0.5) * 200}px`); // Random X translation
                        particle.style.setProperty('--ty', `${(Math.random() - 0.5) * 200}px`); // Random Y translation
                        particle.style.animation = `float-particle ${duration}s linear ${delay}s infinite`;

                        bgParticlesContainer.appendChild(particle);
                    }
                }
                createBackgroundParticles();
            }
        });
    </script>
    @stack('scripts') {{-- Changed from @yield('scripts') to @stack('scripts') for consistency with @stack('styles') --}}
</body>

</html>