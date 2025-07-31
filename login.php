<?php
// Página de login - login.php
// Iniciar sesión para manejar el estado de autenticación
session_start();

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}

// Variables para mensajes
$mensaje_error = '';
$mensaje_exito = '';

// Procesar formulario de login cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener y limpiar datos del formulario
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];
    
    // Validar que los campos no estén vacíos
    if (empty($usuario) || empty($password)) {
        $mensaje_error = 'Por favor complete todos los campos.';
    } else {
        // Verificar credenciales hardcodeadas (admin/admin)
        if ($usuario === 'admin' && $password === 'admin') {
            // Login exitoso - crear sesión
            $_SESSION['user_logged_in'] = true;
            $_SESSION['username'] = $usuario;
            $_SESSION['user_role'] = 'administrador';
            $_SESSION['login_time'] = time();
            
            // Redirigir al dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $mensaje_error = 'Usuario o contraseña incorrectos. Use admin/admin para acceder.';
        }
    }
}

// Incluir el header común
include 'header.php';
?>

<!-- Estilos específicos para la página de login -->
<style>
    /* Override del fondo para la página de login */
    body {
        background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 50%, #60a5fa 100%);
        min-height: 100vh;
    }
    
    .main-content {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 200px);
        padding: 2rem 0;
    }
    
    .login-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        padding: 3rem;
        width: 100%;
        max-width: 450px;
        margin: 0 auto;
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .login-header h2 {
        color: #1e3a8a;
        font-size: 2rem;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }
    
    .login-header p {
        color: #6b7280;
        font-size: 1rem;
    }
    
    .login-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin: 0 auto 1.5rem auto;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #374151;
        font-weight: 500;
    }
    
    .form-group input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f9fafb;
    }
    
    .form-group input:focus {
        outline: none;
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .btn-login {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }
    
    .btn-login:hover {
        background: linear-gradient(135deg, #1e40af, #2563eb);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
    }
    
    .btn-login:active {
        transform: translateY(0);
    }
    
    .alert {
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        font-weight: 500;
    }
    
    .alert-error {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    
    .alert-success {
        background: #d1fae5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }
    
    .alert-info {
        background: #dbeafe;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }
    
    .demo-credentials {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1.5rem;
        text-align: center;
    }
    
    .demo-credentials h4 {
        color: #1e3a8a;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .demo-credentials p {
        color: #6b7280;
        font-size: 0.85rem;
        margin: 0.25rem 0;
    }
    
    .back-to-home {
        text-align: center;
        margin-top: 2rem;
    }
    
    .back-to-home a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }
    
    .back-to-home a:hover {
        color: #1e40af;
        text-decoration: underline;
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
        .login-container {
            margin: 1rem;
            padding: 2rem;
        }
        
        .login-header h2 {
            font-size: 1.5rem;
        }
        
        .login-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
    }
</style>

<!-- Contenido específico de la página de login -->
<div class="container">
    <div class="login-container">
        <!-- Header del formulario de login -->
        <div class="login-header">
            <div class="login-icon">🔐</div>
            <h2>Iniciar Sesión</h2>
            <p>Accede al sistema de gestión de la iglesia</p>
        </div>
        
        <!-- Mostrar mensaje de error si existe -->
        <?php if (!empty($mensaje_error)): ?>
            <div class="alert alert-error">
                <strong>Error:</strong> <?php echo htmlspecialchars($mensaje_error); ?>
            </div>
        <?php endif; ?>
        
        <!-- Mostrar mensaje de éxito si existe -->
        <?php if (!empty($mensaje_exito)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($mensaje_exito); ?>
            </div>
        <?php endif; ?>
        
        <!-- Formulario de login -->
        <form method="POST" action="" id="loginForm">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required 
                       placeholder="Ingrese su usuario"
                       value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required 
                       placeholder="Ingrese su contraseña">
            </div>
            
            <button type="submit" class="btn-login">
                Ingresar al Sistema
            </button>
        </form>
        
        <!-- Información de credenciales de demostración -->
        <div class="demo-credentials">
            <h4>🔍 Credenciales de Demostración</h4>
            <p><strong>Usuario:</strong> admin</p>
            <p><strong>Contraseña:</strong> admin</p>
        </div>
        
        <!-- Enlace de regreso al inicio -->
        <div class="back-to-home">
            <a href="index.php">← Volver al inicio</a>
        </div>
    </div>
</div>

<!-- JavaScript para mejorar la experiencia del usuario -->
<script>
    // Enfocar automáticamente el campo de usuario al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('usuario').focus();
    });
    
    // Validación del formulario en tiempo real
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const usuario = document.getElementById('usuario').value.trim();
        const password = document.getElementById('password').value;
        
        // Validar campos vacíos
        if (usuario === '' || password === '') {
            e.preventDefault();
            showMessage('Por favor complete todos los campos.', 'error');
            return false;
        }
        
        // Validar longitud mínima
        if (usuario.length < 2) {
            e.preventDefault();
            showMessage('El usuario debe tener al menos 2 caracteres.', 'error');
            return false;
        }
        
        if (password.length < 2) {
            e.preventDefault();
            showMessage('La contraseña debe tener al menos 2 caracteres.', 'error');
            return false;
        }
    });
    
    // Efectos visuales para los campos
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });
    
    // Auto-rellenar campos con credenciales de demo al hacer doble clic
    document.querySelector('.demo-credentials').addEventListener('dblclick', function() {
        document.getElementById('usuario').value = 'admin';
        document.getElementById('password').value = 'admin';
        showMessage('Credenciales de demostración cargadas', 'success');
    });
</script>

<?php
// Incluir el footer común
include 'footer.php';
?>