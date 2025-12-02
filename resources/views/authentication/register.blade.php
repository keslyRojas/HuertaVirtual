<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Crear Cuenta - Huerta</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">

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
                <h2 class="title">Crear Cuenta</h2>
            </div>

            @if ($errors->any())
                <div class="alert-box error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert-box success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf

                <div class="form-group">
                    <label for="username">Nombre:</label>
                    <input id="username" type="text" name="username" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo:</label>
                    <input id="email" type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <button class="button">Registrarse</button>
            </form>

            <p style="margin-top:20px;">
                ¿Ya tenés cuenta?
                <a href="{{ route('login') }}" style="color: var(--clr-green); font-weight:bold;">
                    Iniciar sesión
                </a>
            </p>

        </div>
    </div>

</body
