<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KnowItGel - Level Up Your Computer Knowledge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #fff;
            overflow-x: hidden;
        }
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow: hidden;
        }
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 800px;
        }
        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: linear-gradient(45deg, #fff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: glow 2s ease-in-out infinite alternate;
        }
        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: rgba(255, 255, 255, 0.9);
        }
        .btn-custom {
            padding: 1rem 2rem;
            font-size: 1.2rem;
            border-radius: 50px;
            border: none;
            margin: 0.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .btn-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
            z-index: -1;
        }
        .btn-custom:hover::before {
            left: 100%;
        }
        .btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-success {
            background: linear-gradient(45deg, #00b09b, #96c93d);
            box-shadow: 0 4px 15px rgba(0, 176, 155, 0.4);
        }
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }
        .floating-icons {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }
        .floating-icon {
            position: absolute;
            font-size: 2rem;
            color: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }
        .features-section {
            padding: 4rem 0;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }
        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            margin: 1rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .feature-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15);
        }
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        @keyframes glow {
            from { text-shadow: 0 0 10px rgba(255, 255, 255, 0.5); }
            to { text-shadow: 0 0 20px rgba(255, 255, 255, 0.8); }
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: particleFloat 20s linear infinite;
        }
        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                transform: translateY(-100vh) scale(1);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="particles" id="particles"></div>
        <div class="floating-icons">
            <i class="fas fa-microchip floating-icon" style="top: 20%; left: 10%; animation-delay: 0s;"></i>
            <i class="fas fa-keyboard floating-icon" style="top: 30%; right: 15%; animation-delay: 1s;"></i>
            <i class="fas fa-mouse floating-icon" style="bottom: 20%; left: 20%; animation-delay: 2s;"></i>
            <i class="fas fa-desktop floating-icon" style="bottom: 30%; right: 10%; animation-delay: 3s;"></i>
            <i class="fas fa-server floating-icon" style="top: 40%; left: 30%; animation-delay: 4s;"></i>
            <i class="fas fa-network-wired floating-icon" style="top: 50%; right: 25%; animation-delay: 5s;"></i>
        </div>
        
        <div class="hero-content">
            <h1 class="hero-title">KnowItGel</h1>
            <p class="hero-subtitle">Level Up Your Computer Knowledge Through Interactive Gaming</p>
            
            <div class="mt-4">
                <a href="{{ route('login') }}" class="btn btn-custom btn-primary" onclick="showLoading()">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-custom btn-success" onclick="showLoading()">
                    <i class="fas fa-user-plus me-2"></i>Register
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="fas fa-gamepad feature-icon"></i>
                        <h3>Interactive Games</h3>
                        <p>Learn through fun and engaging computer-related games</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="fas fa-trophy feature-icon"></i>
                        <h3>Track Progress</h3>
                        <p>Monitor your learning journey and achievements</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="fas fa-users feature-icon"></i>
                        <h3>Community Learning</h3>
                        <p>Join a community of learners and share knowledge</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Create floating particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 20 + 's';
                particlesContainer.appendChild(particle);
            }
        }

        // Show loading overlay
        function showLoading() {
            const overlay = document.querySelector('.loading-overlay');
            overlay.style.display = 'flex';
        }

        // Initialize particles
        createParticles();

        // Add hover effect to buttons
        document.querySelectorAll('.btn-custom').forEach(button => {
            button.addEventListener('mouseover', function() {
                this.style.transform = 'translateY(-3px)';
            });
            button.addEventListener('mouseout', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>