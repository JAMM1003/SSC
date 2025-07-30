<?php
/**
 * Página de Login - Sistema de Control de Asistencia
 * IASD del Marqués
 */

// Incluir archivo de configuración
require_once 'config.php';

// Iniciar sesión
iniciarSesion();

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['usuario_logueado']) && $_SESSION['usuario_logueado'] === true) {
    header("Location: dashboard.php");
    exit();
}

// Variables para mensajes
$mensaje_error = '';

// Procesar formulario de login cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener y limpiar datos del formulario
    $usuario = limpiarDatos($_POST['usuario']);
    $password = $_POST['password']; // No limpiar la contraseña para mantener caracteres especiales
    
    // Validar que los campos no estén vacíos
    if (empty($usuario) || empty($password)) {
        $mensaje_error = 'Por favor complete todos los campos.';
    } else {
        try {
            // Conectar a la base de datos
            $pdo = conectarDB();
            
            // Buscar usuario en la base de datos
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
            $stmt->execute([$usuario]);
            $usuario_db = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificar si el usuario existe y la contraseña es correcta
            if ($usuario_db && password_verify($password, $usuario_db['password'])) {
                // Login exitoso - crear sesión
                $_SESSION['usuario_logueado'] = true;
                $_SESSION['usuario'] = $usuario_db['usuario'];
                $_SESSION['nombre'] = $usuario_db['nombre'];
                
                // Redirigir al dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $mensaje_error = 'Usuario o contraseña incorrectos.';
            }
        } catch (PDOException $e) {
            $mensaje_error = 'Error en el sistema. Intente nuevamente.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IASD del Marqués</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Header principal -->
        <div class="header">
            <h1>IASD del Marqués</h1>
            <div class="subtitle">Sistema de Control de Asistencia</div>
        </div>
        
        <!-- Formulario de login -->
        <div class="form-container">
            <h2 class="text-center mb-2">Iniciar Sesión</h2>
            
            <!-- Mostrar mensaje de error si existe -->
            <?php if (!empty($mensaje_error)): ?>
                <div class="alert alert-error">
                    <?php echo $mensaje_error; ?>
                </div>
            <?php endif; ?>
            
            <!-- Formulario -->
            <form method="POST" action="">
                <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" required 
                           value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-full">Ingresar</button>
                </div>
            </form>
            
            <!-- Información de usuario de prueba -->
            <div class="alert alert-info mt-2">
                <strong>Usuario de prueba:</strong><br>
                Usuario: admin<br>
                Contraseña: admin123
            </div>
        </div>
    </div>
    
    <!-- JavaScript básico para mejorar la experiencia -->
    <script>
        // Enfocar automáticamente el campo de usuario al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('usuario').focus();
        });
        
        // Validación básica del formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const usuario = document.getElementById('usuario').value.trim();
            const password = document.getElementById('password').value;
            
            if (usuario === '' || password === '') {
                e.preventDefault();
                alert('Por favor complete todos los campos.');
                return false;
            }
        });
    </script>
</body>
</html>