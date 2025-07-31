<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iglesia Adventista del Séptimo Día - El Marqués</title>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }

        /* Header styles */
        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #fbbf24 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo h1 {
            font-size: 1.8rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: #fbbf24;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #1e3a8a;
            font-weight: bold;
        }

        .login-btn {
            background: #fbbf24;
            color: #1e3a8a;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .login-btn:hover {
            background: white;
            color: #1e3a8a;
            border-color: #fbbf24;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
        }

        /* Navegación principal */
        .main-nav {
            background: rgba(30, 58, 138, 0.95);
            padding: 0.5rem 0;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .nav-links a:hover {
            background: rgba(251, 191, 36, 0.2);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .logo h1 {
                font-size: 1.5rem;
            }

            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header principal -->
    <header class="header">
        <div class="header-container">
            <div class="logo">
                <div class="logo-icon">⛪</div>
                <h1>IASD El Marqués</h1>
            </div>
            
            <?php
            // Verificar si el usuario está logueado para mostrar botón apropiado
            session_start();
            if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <span style="color: #fbbf24;">Bienvenido, <?php echo $_SESSION['username']; ?></span>
                    <a href="logout.php" class="login-btn">Cerrar Sesión</a>
                </div>
            <?php else: ?>
                <a href="login.php" class="login-btn">Login</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Navegación principal -->
    <nav class="main-nav">
        <div class="nav-container">
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="#sobre-nosotros">Sobre Nosotros</a></li>
                <li><a href="#actividades">Actividades</a></li>
                <li><a href="#contacto">Contacto</a></li>
                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                    <li><a href="dashboard.php">Panel de Control</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal comenzará aquí -->
    <main class="main-content">