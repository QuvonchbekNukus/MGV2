<!DOCTYPE html>
<html lang="uz" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Secure Access - Harbiy Tizim</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        .orbitron {
            font-family: 'Orbitron', sans-serif;
        }

        /* Animated Background */
        .cyber-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0a0e27 0%, #1a1f3a 50%, #0a0e27 100%);
            z-index: -1;
        }

        /* Grid Animation */
        .grid-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(rgba(16, 185, 129, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(16, 185, 129, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
            z-index: -1;
        }

        @keyframes gridMove {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(50px, 50px);
            }
        }

        /* Particles */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(16, 185, 129, 0.6);
            border-radius: 50%;
            animation: float 3s ease-in-out infinite;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
        }

        /* Glowing Border */
        .glow-border {
            position: relative;
            border: 2px solid transparent;
            background: linear-gradient(#1e293b, #1e293b) padding-box,
                        linear-gradient(135deg, #10b981, #06b6d4, #8b5cf6) border-box;
            animation: borderGlow 3s ease-in-out infinite;
        }

        @keyframes borderGlow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.5),
                           0 0 40px rgba(16, 185, 129, 0.3),
                           inset 0 0 20px rgba(16, 185, 129, 0.1);
            }
            50% {
                box-shadow: 0 0 30px rgba(139, 92, 246, 0.5),
                           0 0 60px rgba(139, 92, 246, 0.3),
                           inset 0 0 30px rgba(139, 92, 246, 0.1);
            }
        }

        /* Holographic Effect */
        .holographic {
            background: linear-gradient(135deg,
                rgba(16, 185, 129, 0.1) 0%,
                rgba(6, 182, 212, 0.1) 25%,
                rgba(139, 92, 246, 0.1) 50%,
                rgba(236, 72, 153, 0.1) 75%,
                rgba(16, 185, 129, 0.1) 100%);
            background-size: 200% 200%;
            animation: holographicShift 10s ease infinite;
        }

        @keyframes holographicShift {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Neon Glow Text */
        .neon-text {
            text-shadow:
                0 0 10px rgba(16, 185, 129, 0.8),
                0 0 20px rgba(16, 185, 129, 0.6),
                0 0 30px rgba(16, 185, 129, 0.4),
                0 0 40px rgba(16, 185, 129, 0.2);
            animation: neonPulse 2s ease-in-out infinite;
        }

        @keyframes neonPulse {
            0%, 100% {
                text-shadow:
                    0 0 10px rgba(16, 185, 129, 0.8),
                    0 0 20px rgba(16, 185, 129, 0.6),
                    0 0 30px rgba(16, 185, 129, 0.4);
            }
            50% {
                text-shadow:
                    0 0 20px rgba(16, 185, 129, 1),
                    0 0 30px rgba(16, 185, 129, 0.8),
                    0 0 40px rgba(16, 185, 129, 0.6),
                    0 0 50px rgba(16, 185, 129, 0.4);
            }
        }

        /* Scanning Line */
        .scan-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg,
                transparent,
                rgba(16, 185, 129, 0.8),
                transparent);
            animation: scan 4s linear infinite;
        }

        @keyframes scan {
            0% {
                top: 0;
            }
            100% {
                top: 100%;
            }
        }

        /* Input Focus Effect */
        .cyber-input:focus {
            outline: none;
            box-shadow:
                0 0 0 2px rgba(16, 185, 129, 0.3),
                0 0 20px rgba(16, 185, 129, 0.2),
                inset 0 0 20px rgba(16, 185, 129, 0.1);
            border-color: #10b981;
        }

        /* Button Hover Effect */
        .cyber-button {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .cyber-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .cyber-button:hover::before {
            width: 300px;
            height: 300px;
        }

        /* Loading Animation */
        .loading-circle {
            animation: rotate 2s linear infinite;
        }

        @keyframes rotate {
            100% {
                transform: rotate(360deg);
            }
        }

        /* Glitch Effect */
        .glitch {
            position: relative;
        }

        .glitch::before,
        .glitch::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .glitch::before {
            left: 2px;
            text-shadow: -2px 0 #ff00de;
            animation: glitch-1 2s infinite;
        }

        .glitch::after {
            left: -2px;
            text-shadow: 2px 0 #00fff9;
            animation: glitch-2 2s infinite;
        }

        @keyframes glitch-1 {
            0%, 100% {
                clip-path: inset(0 0 0 0);
            }
            20% {
                clip-path: inset(40% 0 35% 0);
            }
            40% {
                clip-path: inset(15% 0 70% 0);
            }
            60% {
                clip-path: inset(70% 0 15% 0);
            }
            80% {
                clip-path: inset(20% 0 60% 0);
            }
        }

        @keyframes glitch-2 {
            0%, 100% {
                clip-path: inset(0 0 0 0);
            }
            20% {
                clip-path: inset(60% 0 20% 0);
            }
            40% {
                clip-path: inset(10% 0 80% 0);
            }
            60% {
                clip-path: inset(80% 0 10% 0);
            }
            80% {
                clip-path: inset(30% 0 50% 0);
            }
        }

        /* Corner Decorations */
        .corner-decoration {
            position: absolute;
            width: 40px;
            height: 40px;
            border: 2px solid #10b981;
        }

        .corner-decoration.top-left {
            top: -2px;
            left: -2px;
            border-right: none;
            border-bottom: none;
        }

        .corner-decoration.top-right {
            top: -2px;
            right: -2px;
            border-left: none;
            border-bottom: none;
        }

        .corner-decoration.bottom-left {
            bottom: -2px;
            left: -2px;
            border-right: none;
            border-top: none;
        }

        .corner-decoration.bottom-right {
            bottom: -2px;
            right: -2px;
            border-left: none;
            border-top: none;
        }
    </style>
</head>
<body class="h-full">
    <!-- Animated Background -->
    <div class="cyber-background"></div>
    <div class="grid-overlay"></div>

    <!-- Particles -->
    <div id="particles"></div>

    <!-- Main Container -->
    <div class="min-h-screen flex items-center justify-center p-4 relative">

        <!-- Login Container -->
        <div class="w-full max-w-md relative">

            <!-- Security Header -->
            <div class="text-center mb-8">
                <!-- Logo with Animation -->
                <div class="mb-6 flex justify-center">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-green-500 via-emerald-500 to-teal-500 rounded-lg flex items-center justify-center transform rotate-45 shadow-2xl">
                            <i class="fas fa-shield-alt text-white text-3xl transform -rotate-45"></i>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-teal-500 rounded-lg blur-xl opacity-50 animate-pulse"></div>
                    </div>
                </div>

                <!-- Title with Glitch Effect -->
                <h1 class="orbitron text-4xl font-bold text-white mb-2 neon-text glitch" data-text="SECURE ACCESS">
                    SECURE ACCESS
                </h1>
                <p class="text-green-400 text-sm font-mono tracking-wider">
                    <i class="fas fa-lock mr-2"></i>E-GVARDIYA TIZIMIGA XUSH KELIBSIZ
                </p>
                <div class="flex items-center justify-center mt-2 space-x-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-green-400 text-xs font-mono">SYSTEM ONLINE</span>
                </div>
            </div>

            <!-- Login Form Card -->
            <div class="glow-border rounded-2xl overflow-hidden relative">
                <!-- Scanning Line Effect -->
                <div class="scan-line"></div>

                <!-- Corner Decorations -->
                <div class="corner-decoration top-left"></div>
                <div class="corner-decoration top-right"></div>
                <div class="corner-decoration bottom-left"></div>
                <div class="corner-decoration bottom-right"></div>

                <div class="holographic backdrop-blur-xl bg-slate-800/50 p-8 relative">

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-6 p-4 bg-green-500/20 border border-green-500 rounded-lg text-green-400 text-sm">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-500/20 border border-red-500 rounded-lg text-red-400 text-sm">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Username Input -->
                        <div class="relative">
                            <label class="block text-green-400 text-sm font-mono mb-2 tracking-wide">
                                <i class="fas fa-user-circle mr-2"></i>FOYDALANUVCHI NOMI
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="username"
                                       value="{{ old('username') }}"
                                       class="cyber-input w-full px-4 py-3 bg-slate-900/80 border-2 border-slate-700 rounded-lg text-white placeholder-gray-500 focus:border-green-500 transition-all font-mono"
                                       placeholder="operator_001"
                                       required
                                       autofocus>
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                </div>
                            </div>
                            @error('username')
                                <p class="mt-2 text-xs text-red-400 font-mono">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="relative" x-data="{ showPassword: false }">
                            <label class="block text-green-400 text-sm font-mono mb-2 tracking-wide">
                                <i class="fas fa-key mr-2"></i>PAROL
                            </label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'"
                                       id="password-input"
                                       name="password"
                                       class="cyber-input w-full px-4 py-3 pr-24 bg-slate-900/80 border-2 border-slate-700 rounded-lg text-white placeholder-gray-500 focus:border-green-500 transition-all font-mono"
                                       placeholder="••••••••••••"
                                       required>
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 flex items-center space-x-2">
                                    <!-- Toggle Password Button -->
                                    <button type="button"
                                            @click="showPassword = !showPassword"
                                            class="p-1.5 bg-slate-800 hover:bg-slate-700 border border-slate-600 hover:border-green-500 rounded transition-all group"
                                            title="Toggle Password Visibility">
                                        <i x-show="!showPassword" class="fas fa-eye text-gray-400 group-hover:text-green-400 text-sm"></i>
                                        <i x-show="showPassword" class="fas fa-eye-slash text-green-400 group-hover:text-green-300 text-sm"></i>
                                    </button>
                                    <!-- Status Indicator -->
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                </div>
                            </div>
                            @error('password')
                                <p class="mt-2 text-xs text-red-400 font-mono">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input id="remember_me"
                                   type="checkbox"
                                   name="remember"
                                   class="w-4 h-4 bg-slate-900 border-2 border-green-500 rounded text-green-600 focus:ring-2 focus:ring-green-500">
                            <label for="remember_me" class="ml-3 text-gray-400 text-sm font-mono">
                                MAINTAIN SESSION
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                class="cyber-button w-full py-4 bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 hover:from-green-500 hover:via-emerald-500 hover:to-teal-500 text-white font-bold rounded-lg shadow-lg transform hover:scale-[1.02] transition-all orbitron text-lg relative overflow-hidden">
                            <span class="relative z-10 flex items-center justify-center">
                                <i class="fas fa-fingerprint mr-2"></i>
                                TIZIMGA KIRISH
                            </span>
                        </button>
                    </form>

                    <!-- Security Info -->
                    <div class="mt-8 pt-6 border-t border-slate-700">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <div class="text-green-400 text-xs font-mono mb-1">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="text-gray-500 text-xs font-mono">256-BIT</div>
                            </div>
                            <div>
                                <div class="text-green-400 text-xs font-mono mb-1">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <div class="text-gray-500 text-xs font-mono">HIMOYALANGAN</div>
                            </div>
                            <div>
                                <div class="text-green-400 text-xs font-mono mb-1">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="text-gray-500 text-xs font-mono">HAVFSIZ</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="mt-8 text-center">
                <p class="text-gray-600 text-xs font-mono">
                    © {{ date('Y') }} MILITARY SYSTEM • ALL RIGHTS RESERVED
                </p>
                <p class="text-gray-700 text-xs font-mono mt-2">
                    UNAUTHORIZED ACCESS IS PROHIBITED
                </p>
            </div>
        </div>
    </div>

    <!-- Particles Animation Script -->
    <script>
        // Create particles
        const particlesContainer = document.getElementById('particles');
        for (let i = 0; i < 50; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 3 + 's';
            particle.style.animationDuration = (Math.random() * 3 + 2) + 's';
            particlesContainer.appendChild(particle);
        }
    </script>
</body>
</html>
