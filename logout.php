<?php
/**
 * Página de Logout - Sistema de Control de Asistencia
 * IASD del Marqués
 */

// Incluir archivo de configuración
require_once 'config.php';

// Iniciar sesión para poder destruirla
iniciarSesion();

// Destruir todas las variables de sesión
$_SESSION = array();

// Si se desea destruir la sesión completamente, también hay que borrar la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir la sesión
session_destroy();

// Redirigir al login con mensaje de confirmación
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrando Sesión - IASD del Marqués</title>
    <link rel="stylesheet" href="style.css">
    <meta http-equiv="refresh" content="3;url=index.php">
</head>
<body>
    <div class="container">
        <!-- Header principal -->
        <div class="header">
            <h1>IASD del Marqués</h1>
            <div class="subtitle">Sistema de Control de Asistencia</div>
        </div>
        
        <!-- Mensaje de logout -->
        <div class="form-container">
            <div class="text-center">
                <div style="font-size: 4rem; margin-bottom: 1rem;">👋</div>
                <h2>Sesión Cerrada Exitosamente</h2>
                
                <div class="alert alert-success mt-2">
                    <strong>¡Hasta luego!</strong><br>
                    Su sesión ha sido cerrada de forma segura.<br>
                    Será redirigido automáticamente a la página de login en <span id="countdown">3</span> segundos.
                </div>
                
                <div class="alert alert-info mt-2">
                    <strong>Información de seguridad:</strong><br>
                    • Su sesión ha sido completamente destruida<br>
                    • Todas las cookies de sesión han sido eliminadas<br>
                    • Para acceder nuevamente, deberá iniciar sesión<br>
                    • Si está en una computadora compartida, asegúrese de cerrar el navegador
                </div>
                
                <div class="form-group mt-2">
                    <a href="index.php" class="btn btn-primary btn-full">
                        🔐 Volver al Login
                    </a>
                </div>
                
                <!-- Información adicional -->
                <div style="margin-top: 2rem; color: #666; font-size: 0.9rem;">
                    <p>Gracias por usar el Sistema de Control de Asistencia de IASD del Marqués</p>
                    <p>Sistema desarrollado para el servicio comunitario universitario</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript para countdown y redirección -->
    <script>
        // Contador regresivo
        let tiempoRestante = 3;
        const countdownElement = document.getElementById('countdown');
        
        const intervalo = setInterval(function() {
            tiempoRestante--;
            countdownElement.textContent = tiempoRestante;
            
            if (tiempoRestante <= 0) {
                clearInterval(intervalo);
                window.location.href = 'index.php';
            }
        }, 1000);
        
        // Limpiar localStorage y sessionStorage por seguridad adicional
        if (typeof(Storage) !== "undefined") {
            localStorage.clear();
            sessionStorage.clear();
        }
        
        // Prevenir que el usuario regrese usando el botón atrás del navegador
        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function() {
            window.history.pushState(null, null, window.location.href);
        };
        
        // Mensaje en consola para desarrolladores
        console.log('Sesión cerrada exitosamente - Sistema IASD del Marqués');
    </script>
</body>
</html>