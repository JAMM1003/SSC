<?php
/**
 * Archivo de configuración para la conexión a la base de datos
 * IASD del Marqués - Sistema de Control de Asistencia
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');      // Servidor de base de datos
define('DB_NAME', 'iasd_asistencia'); // Nombre de la base de datos
define('DB_USER', 'root');           // Usuario de MySQL (cambiar según tu configuración)
define('DB_PASS', '');               // Contraseña de MySQL (cambiar según tu configuración)

// Función para conectar a la base de datos
function conectarDB() {
    try {
        // Crear conexión PDO (PHP Data Objects) - más seguro que mysqli
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
        
        // Configurar PDO para mostrar errores
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $pdo;
    } catch(PDOException $e) {
        // Si hay error en la conexión, mostrar mensaje y detener ejecución
        die("Error de conexión: " . $e->getMessage());
    }
}

// Función para iniciar sesión de forma segura
function iniciarSesion() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

// Función para verificar si el usuario está logueado
function verificarLogin() {
    iniciarSesion();
    if (!isset($_SESSION['usuario_logueado']) || $_SESSION['usuario_logueado'] !== true) {
        // Si no está logueado, redirigir al login
        header("Location: index.php");
        exit();
    }
}

// Función para limpiar y validar datos de entrada
function limpiarDatos($dato) {
    $dato = trim($dato);           // Eliminar espacios al inicio y final
    $dato = stripslashes($dato);   // Eliminar barras invertidas
    $dato = htmlspecialchars($dato); // Convertir caracteres especiales a HTML
    return $dato;
}
?>