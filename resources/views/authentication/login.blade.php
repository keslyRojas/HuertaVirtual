<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign Up - Huerta</title>

    {{-- CSRF para formularios --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>

    <div class="nav-bar"></div>

    <div class="login-container">
        <div class="login-card">

            <div class="header">
                <div class="fruits-icon">
                    <img src="{{ asset('img/icon.png') }}" alt="Icono" class="fruit-icons">
                </div>
                <h2 class="title">Sign Up</h2>
            </div>

            <form method="POST" action="/registrar">
                @csrf

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input id="username" type="text" name="username" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input id="email" type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <button class="button">Registrarse</button>
            </form>

        </div>
    </div>

</body>
</html>
