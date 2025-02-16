<html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Web-W</title>
    <link rel="stylesheet" href="{{ asset('assets/backend/assets/css/login-style.css') }}">
    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>

    <div class="floating-shapes">
        <!-- Generamos formas flotantes con SVG -->
        <svg class="shape" style="left: 10%; top: 20%" width="50" height="50" viewBox="0 0 50 50">
            <circle cx="25" cy="25" r="20" fill="rgba(255,255,255,0.2)" />
        </svg>
        <svg class="shape" style="left: 80%; top: 60%" width="40" height="40" viewBox="0 0 40 40">
            <rect width="30" height="30" x="5" y="5" fill="rgba(255,255,255,0.2)" />
        </svg>
        <svg class="shape" style="left: 50%; top: 30%" width="60" height="60" viewBox="0 0 60 60">
            <polygon points="30,5 55,45 5,45" fill="rgba(255,255,255,0.2)" />
        </svg>
    </div>

    <div class="login-container">
        <h2>Administrator Login  </h2>
        <form method="POST" id="loginForm" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="input-group">
                <input type="email" id="email" name="email" required>
                <label for="email">Correo</label>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" required>
                <label for="password">Contraseña</label>
                <svg class="password-toggle" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
            </div>
            <button type="submit" class="btn-login">Login</button>
            <div class="links">
                <a href="#">No recuerda su contraseña?</a>
            </div>
        </form>
    </div>
    <script src="{{ asset('assets/backend/assets/js/login.js') }}"></script>

    <div id="alert-container" class="fixed top-4 right-4 flex flex-col gap-2">
        @if (session('success'))
            <div class="alert-message flex w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="flex items-center justify-center w-12 bg-green-400">
                    <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
                    </svg>
                </div>
                <div class="px-4 py-2 -mx-3">
                    <div class="mx-3">
                        <span class="font-semibold text-green-500 dark:text-green-400">Success</span>
                        <p class="text-sm text-gray-600 dark:text-gray-200">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
    
        @if (session('error'))
            <div class="alert-message flex w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="flex items-center justify-center w-12 bg-red-500">
                    <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
                    </svg>
                </div>
                <div class="px-4 py-2 -mx-3">
                    <div class="mx-3">
                        <span class="font-semibold text-red-500 dark:text-red-400">Error</span>
                        <p class="text-sm text-gray-600 dark:text-gray-200">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</body>
