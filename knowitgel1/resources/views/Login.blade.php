<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KnowItGel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: transparent;
            border-bottom: none;
            padding: 20px 20px 0;
        }

        .card-header h4 {
            color: #333;
            font-weight: 600;
        }

        .card-body {
            padding: 30px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .form-label {
            font-weight: 500;
            color: #555;
        }

        .alert {
            border-radius: 10px;
        }

        .login-type-selector {
            margin-bottom: 20px;
            text-align: center;
        }

        .login-type-btn {
            padding: 8px 20px;
            margin: 0 5px;
            border: 2px solid #667eea;
            border-radius: 20px;
            background: transparent;
            color: #667eea;
            transition: all 0.3s;
        }

        .login-type-btn.active {
            background: #667eea;
            color: white;
        }

        .login-type-btn:hover {
            background: #667eea;
            color: white;
        }

        .register-link {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link:hover {
            color: #fff;
            text-decoration: underline;
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
            top: -150px;
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
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h4><i class="fas fa-user-circle mb-3" style="font-size: 3rem; color: #667eea;"></i></h4>
                        <h4>Welcome Back</h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                        </div>
                        @endif

                        <div class="login-type-selector">
                            <button type="button" class="login-type-btn active" data-type="user">User</button>
                            <button type="button" class="login-type-btn" data-type="admin">Admin</button>
                        </div>

                        <form action="{{ route('login.submit') }}" method="POST" id="loginForm" onsubmit="showLoadingAnimation()">
                            @csrf
                            <input type="hidden" name="login_type" id="loginType" value="user">

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" name="username" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <span class="text-white">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="register-link ms-2">Register Now</a>
                </div>
            </div>
        </div>
    </div>

    <div class="game-avatar" id="gameAvatar">
        <div class="avatar-container">
            <div class="avatar-speech-bubble" id="avatarSpeech"></div>
            <div class="avatar-body">
                <div class="avatar-antennas">
                    <div class="avatar-antenna"></div>
                    <div class="avatar-antenna"></div>
                </div>
                <div class="avatar-circuit-line"></div>
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

                <div class="avatar-arms">
                    <div class="avatar-arm left"></div>
                    <div class="avatar-arm right"></div>
                </div>
                <div class="avatar-speech-bubble" id="avatarSpeechBubble">Welcome to KnowItGel! I'm here to help you access your learning journey. Let's get you logged in!</div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                document.querySelectorAll('.login-type-btn').forEach(button => {
                    button.addEventListener('click', function() {

                        document.querySelectorAll('.login-type-btn').forEach(btn => {
                            btn.classList.remove('active');
                        });

                        this.classList.add('active');

                        document.getElementById('loginType').value = this.dataset.type;
                    });
                });

                document.addEventListener('DOMContentLoaded', function() {
                    const speechBubble = document.getElementById('avatarSpeechBubble');
                    if (speechBubble) {
                        setTimeout(() => {
                            speechBubble.classList.add('show');
                        }, 1000);
                    }


                    const usernameField = document.querySelector('input[name="username"]');
                    const passwordField = document.querySelector('input[name="password"]');

                    if (usernameField) {
                        usernameField.addEventListener('focus', function() {
                            const bubble = document.getElementById('avatarSpeechBubble');
                            if (bubble) {
                                bubble.textContent = 'Enter your username to continue learning!';
                                bubble.classList.add('show');
                            }
                        });
                    }

                    if (passwordField) {
                        passwordField.addEventListener('focus', function() {
                            const bubble = document.getElementById('avatarSpeechBubble');
                            if (bubble) {
                                bubble.textContent = 'Keep your password secure!';
                                bubble.classList.add('show');
                            }
                        });
                    }
                });
            </script>
</body>

</html>


<script>
    function showLoadingAnimation() {

        const overlay = document.createElement('div');
        overlay.id = 'loadingOverlay2075';
        overlay.style.position = 'fixed';
        overlay.style.top = '0';
        overlay.style.left = '0';
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.backgroundColor = 'rgba(0,0,0,0.9)';
        overlay.style.zIndex = '9999';
        overlay.style.display = 'flex';
        overlay.style.justifyContent = 'center';
        overlay.style.alignItems = 'center';
        overlay.style.flexDirection = 'column';


        const loadingText = document.createElement('div');
        loadingText.textContent = 'INITIALIZING NEURAL INTERFACE';
        loadingText.style.color = '#0ff';
        loadingText.style.fontSize = '24px';
        loadingText.style.marginBottom = '30px';
        loadingText.style.fontFamily = 'monospace';
        loadingText.style.textShadow = '0 0 10px #0ff';


        const loader = document.createElement('div');
        loader.style.width = '200px';
        loader.style.height = '200px';
        loader.style.border = '5px solid rgba(0,255,255,0.3)';
        loader.style.borderRadius = '50%';
        loader.style.borderTopColor = '#0ff';
        loader.style.animation = 'spin 1s linear infinite';


        overlay.appendChild(loadingText);
        overlay.appendChild(loader);
        document.body.appendChild(overlay);


        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); box-shadow: 0 0 10px #0ff; }
                100% { transform: rotate(360deg); box-shadow: 0 0 20px #0ff; }
            }
        `;
        document.head.appendChild(style);
    }
</script>