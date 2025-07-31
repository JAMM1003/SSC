<?php
// Archivo de logout - logout.php
// Manejo del cierre de sesión del usuario

session_start();

// Destruir todas las variables de sesión
$_SESSION = array();

// Si se está usando una cookie de sesión, eliminarla también
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio con un mensaje
header("Location: index.php?mensaje=logout_exitoso");
exit();
?>