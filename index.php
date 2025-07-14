<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secret Compliments - Spread Kindness Anonymously</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated gradient background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, 
                #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57, #ff9ff3, #54a0ff);
            background-size: 300% 300%;
            animation: gradientFlow 8s ease infinite;
            z-index: 0;
        }

        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(20px);
            animation: float 6s ease-in-out infinite;
            z-index: 1;
        }

        .orb:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .orb:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .orb:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        .orb:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 10%;
            right: 30%;
            animation-delay: 1s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-30px) rotate(120deg); }
            66% { transform: translateY(20px) rotate(240deg); }
        }

        /* Animated particles */
        .particle-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            animation: particleFloat 8s linear infinite;
        }

        @keyframes particleFloat {
            0% { transform: translateY(100vh) translateX(0px) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) translateX(100px) rotate(360deg); opacity: 0; }
        }

        /* Main container with premium layout */
        .container {
            position: relative;
            z-index: 10;
            max-width: 420px;
            width: 90%;
            animation: fadeInUp 1s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(60px) scale(0.95);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Ultra-premium glassmorphism card */
        .card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(30px);
            border-radius: 32px;
            padding: 50px 45px;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        /* Animated border glow */
        .card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, 
                #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57, #ff9ff3, #54a0ff);
            border-radius: 34px;
            z-index: -1;
            animation: borderGlow 3s ease-in-out infinite;
            opacity: 0.6;
        }

        @keyframes borderGlow {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.8; }
        }

        /* Header with premium styling */
        .header {
            margin-bottom: 40px;
            position: relative;
            z-index: 3;
        }

        .logo {
            font-size: 64px;
            margin-bottom: 16px;
            animation: logoFloat 3s ease-in-out infinite;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(5deg); }
        }

        .title {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #fff 0%, #f0f0f0 50%, #fff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            animation: titleGlow 2s ease-in-out infinite alternate;
        }

        @keyframes titleGlow {
            0% { filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.3)); }
            100% { filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.6)); }
        }

        .subtitle {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.7;
            margin-bottom: 45px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            animation: subtitleFade 3s ease-in-out infinite;
        }

        @keyframes subtitleFade {
            0%, 100% { opacity: 0.9; }
            50% { opacity: 1; }
        }

        /* Premium button styling */
        .buttons {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 40px;
            position: relative;
            z-index: 3;
        }

        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            padding: 18px 32px;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            border-radius: 20px;
            border: none;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(20px);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8e8e 50%, #ffb3b3 100%);
            color: white;
            box-shadow: 0 15px 35px rgba(255, 107, 107, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 40px rgba(255, 107, 107, 0.6);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 50%, #3d8b7f 100%);
            color: white;
            box-shadow: 0 15px 35px rgba(78, 205, 196, 0.4);
        }

        .btn-secondary:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 40px rgba(78, 205, 196, 0.6);
        }

        .btn-tertiary {
            background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 50%, #7d3c98 100%);
            color: white;
            box-shadow: 0 15px 35px rgba(155, 89, 182, 0.4);
        }

        .btn-tertiary:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 40px rgba(155, 89, 182, 0.6);
        }

        .btn-icon {
            font-size: 22px;
            animation: iconBounce 2s ease-in-out infinite;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        @keyframes iconBounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-6px); }
            60% { transform: translateY(-3px); }
        }

        /* Premium footer */
        .footer {
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
            position: relative;
            z-index: 3;
            font-weight: 500;
        }

        .heart {
            color: #ff6b6b;
            font-size: 18px;
            animation: heartPulse 1.5s ease-in-out infinite;
            filter: drop-shadow(0 0 8px rgba(255, 107, 107, 0.6));
        }

        @keyframes heartPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.3); }
        }

        /* Floating emoji animations */
        .emoji-float {
            position: fixed;
            font-size: 32px;
            opacity: 0.15;
            animation: emojiFloat 12s ease-in-out infinite;
            z-index: 2;
        }

        .emoji-float:nth-child(1) { top: 15%; left: 8%; animation-delay: 0s; }
        .emoji-float:nth-child(2) { top: 25%; right: 12%; animation-delay: 3s; }
        .emoji-float:nth-child(3) { bottom: 25%; left: 15%; animation-delay: 6s; }
        .emoji-float:nth-child(4) { bottom: 15%; right: 20%; animation-delay: 9s; }
        .emoji-float:nth-child(5) { top: 50%; left: 5%; animation-delay: 1.5s; }
        .emoji-float:nth-child(6) { top: 40%; right: 8%; animation-delay: 4.5s; }

        @keyframes emojiFloat {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.1; }
            50% { transform: translateY(-30px) rotate(180deg); opacity: 0.3; }
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .card {
                padding: 40px 30px;
                margin: 20px;
                border-radius: 28px;
            }
            
            .title {
                font-size: 32px;
            }
            
            .subtitle {
                font-size: 16px;
                margin-bottom: 35px;
            }
            
            .btn {
                padding: 16px 28px;
                font-size: 15px;
            }
            
            .logo {
                font-size: 56px;
            }
        }

        /* Loading animation */
        .loading {
            opacity: 0;
            animation: pageLoad 1s ease-out 0.2s forwards;
        }

        @keyframes pageLoad {
            to { opacity: 1; }
        }

        /* Cursor trail effect */
        .cursor-trail {
            position: fixed;
            width: 6px;
            height: 6px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            pointer-events: none;
            z-index: 1000;
            animation: cursorFade 1s ease-out forwards;
        }

        @keyframes cursorFade {
            0% { opacity: 1; transform: scale(1); }
            100% { opacity: 0; transform: scale(0); }
        }
    </style>
</head>
<body>
    <!-- Floating orbs -->
    <div class="orb"></div>
    <div class="orb"></div>
    <div class="orb"></div>
    <div class="orb"></div>

    <!-- Animated particles -->
    <div class="particle-container" id="particles"></div>

    <!-- Floating emojis -->
    <div class="emoji-float">💝</div>
    <div class="emoji-float">🌟</div>
    <div class="emoji-float">💖</div>
    <div class="emoji-float">✨</div>
    <div class="emoji-float">💫</div>
    <div class="emoji-float">🎭</div>

    <div class="container loading">
        <div class="card">
            <div class="header">
                <div class="logo">🌸</div>
                <h1 class="title">Secret Compliments</h1>
                <p class="subtitle">Send and receive anonymous compliments with your friends. Add reactions, comments, and stay kind!</p>
            </div>

            <div class="buttons">
                <a href="login.php" class="btn btn-primary">
                    <span class="btn-icon">👤</span>
                    User Login
                </a>
                <a href="register.php" class="btn btn-secondary">
                    <span class="btn-icon">📝</span>
                    Register
                </a>
                <a href="admin_login.php" class="btn btn-tertiary">
                    <span class="btn-icon">🔐</span>
                    Admin Login
                </a>
            </div>

            <div class="footer">
                Made with <span class="heart">💖</span> for anonymous kindness
            </div>
        </div>
    </div>

    <script>
        // Enhanced particle system
        function createParticles() {
            const particleContainer = document.getElementById('particles');
            
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 8 + 's';
                particle.style.animationDuration = (Math.random() * 4 + 6) + 's';
                particleContainer.appendChild(particle);
            }
        }

        // Cursor trail effect
        let trails = [];
        document.addEventListener('mousemove', function(e) {
            if (trails.length > 10) {
                trails.shift().remove();
            }
            
            const trail = document.createElement('div');
            trail.className = 'cursor-trail';
            trail.style.left = e.clientX + 'px';
            trail.style.top = e.clientY + 'px';
            document.body.appendChild(trail);
            trails.push(trail);
            
            setTimeout(() => {
                trail.remove();
            }, 1000);
        });

        // Enhanced button interactions
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px) scale(1.02)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
            
            btn.addEventListener('click', function(e) {
                // Enhanced ripple effect
                const rect = this.getBoundingClientRect();
                const ripple = document.createElement('div');
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.5);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: rippleEffect 0.8s ease-out;
                    pointer-events: none;
                `;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 800);
            });
        });

        // Add ripple animation
        const rippleStyle = document.createElement('style');
        rippleStyle.textContent = `
            @keyframes rippleEffect {
                to {
                    transform: scale(2);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(rippleStyle);

        // Initialize particles
        createParticles();

        // Add floating sparkles on scroll
        window.addEventListener('scroll', function() {
            if (Math.random() < 0.1) {
                const sparkle = document.createElement('div');
                sparkle.innerHTML = '✨';
                sparkle.style.cssText = `
                    position: fixed;
                    left: ${Math.random() * 100}%;
                    top: ${Math.random() * 100}%;
                    font-size: 20px;
                    pointer-events: none;
                    z-index: 1000;
                    animation: sparkleFloat 3s ease-out forwards;
                `;
                document.body.appendChild(sparkle);
                
                setTimeout(() => {
                    sparkle.remove();
                }, 3000);
            }
        });

        // Sparkle animation
        const sparkleStyle = document.createElement('style');
        sparkleStyle.textContent = `
            @keyframes sparkleFloat {
                0% { transform: translateY(0) scale(0) rotate(0deg); opacity: 1; }
                100% { transform: translateY(-100px) scale(1.5) rotate(360deg); opacity: 0; }
            }
        `;
        document.head.appendChild(sparkleStyle);

        // Enhanced card tilt effect
        const card = document.querySelector('.card');
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;
            
            this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-5px)`;
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0px)';
        });
    </script>
</body>
</html>