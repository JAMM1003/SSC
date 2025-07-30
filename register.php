<?php
/**
 * Formulario de Registro de Asistentes - Sistema de Control de Asistencia
 * IASD del Marqués
 */

// Incluir archivo de configuración
require_once 'config.php';

// Verificar que el usuario esté logueado
verificarLogin();

// Variables para mensajes y datos del formulario
$mensaje_exito = '';
$mensaje_error = '';
$nombre_completo = '';
$tipo_asistente = '';
$edad = '';
$observaciones = '';

// Procesar formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener y limpiar datos del formulario
    $nombre_completo = limpiarDatos($_POST['nombre_completo']);
    $tipo_asistente = limpiarDatos($_POST['tipo_asistente']);
    $edad = limpiarDatos($_POST['edad']);
    $observaciones = limpiarDatos($_POST['observaciones']);
    
    // Validar campos obligatorios
    $errores = [];
    
    if (empty($nombre_completo)) {
        $errores[] = 'El nombre completo es obligatorio.';
    }
    
    if (empty($tipo_asistente) || !in_array($tipo_asistente, ['miembro', 'visitante', 'interesado'])) {
        $errores[] = 'Debe seleccionar un tipo de asistente válido.';
    }
    
    if (empty($edad) || !is_numeric($edad) || $edad < 1 || $edad > 120) {
        $errores[] = 'Debe ingresar una edad válida (1-120 años).';
    }
    
    // Si no hay errores, proceder con el registro
    if (empty($errores)) {
        try {
            // Conectar a la base de datos
            $pdo = conectarDB();
            
            // Preparar consulta para insertar asistente
            $stmt = $pdo->prepare("INSERT INTO asistentes (nombre_completo, tipo_asistente, edad, observaciones, usuario_registro) VALUES (?, ?, ?, ?, ?)");
            
            // Ejecutar consulta
            $resultado = $stmt->execute([
                $nombre_completo,
                $tipo_asistente,
                (int)$edad,
                $observaciones,
                $_SESSION['usuario']
            ]);
            
            if ($resultado) {
                $mensaje_exito = '¡Asistente registrado exitosamente! El registro se ha guardado en la base de datos.';
                
                // Limpiar campos del formulario después del registro exitoso
                $nombre_completo = '';
                $tipo_asistente = '';
                $edad = '';
                $observaciones = '';
            } else {
                $mensaje_error = 'Error al registrar el asistente. Intente nuevamente.';
            }
            
        } catch (PDOException $e) {
            $mensaje_error = 'Error en la base de datos: ' . $e->getMessage();
        }
    } else {
        // Mostrar errores de validación
        $mensaje_error = implode('<br>', $errores);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Asistente - IASD del Marqués</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Header principal -->
        <div class="header">
            <h1>IASD del Marqués</h1>
            <div class="subtitle">Sistema de Control de Asistencia</div>
        </div>
        
        <!-- Barra de navegación -->
        <nav class="nav">
            <ul>
                <li><a href="dashboard.php">📊 Dashboard</a></li>
                <li><a href="register.php">➕ Registrar Asistente</a></li>
                <li><a href="view.php">👥 Ver Asistentes</a></li>
                <li><a href="logout.php">🚪 Cerrar Sesión</a></li>
            </ul>
        </nav>
        
        <!-- Formulario de registro -->
        <div class="form-container">
            <h2 class="text-center mb-2">Registrar Nuevo Asistente</h2>
            
            <!-- Mostrar mensaje de éxito -->
            <?php if (!empty($mensaje_exito)): ?>
                <div class="alert alert-success">
                    <?php echo $mensaje_exito; ?>
                </div>
            <?php endif; ?>
            
            <!-- Mostrar mensaje de error -->
            <?php if (!empty($mensaje_error)): ?>
                <div class="alert alert-error">
                    <?php echo $mensaje_error; ?>
                </div>
            <?php endif; ?>
            
            <!-- Formulario -->
            <form method="POST" action="" id="formulario-registro">
                <!-- Nombre completo -->
                <div class="form-group">
                    <label for="nombre_completo">Nombre Completo: *</label>
                    <input type="text" id="nombre_completo" name="nombre_completo" required 
                           value="<?php echo htmlspecialchars($nombre_completo); ?>"
                           placeholder="Ingrese el nombre completo del asistente">
                </div>
                
                <!-- Tipo de asistente -->
                <div class="form-group">
                    <label for="tipo_asistente">Tipo de Asistente: *</label>
                    <select id="tipo_asistente" name="tipo_asistente" required>
                        <option value="">Seleccione una opción</option>
                        <option value="miembro" <?php echo ($tipo_asistente == 'miembro') ? 'selected' : ''; ?>>
                            Miembro - Persona que forma parte activa de la iglesia
                        </option>
                        <option value="visitante" <?php echo ($tipo_asistente == 'visitante') ? 'selected' : ''; ?>>
                            Visitante - Persona que visita por primera vez o esporádicamente
                        </option>
                        <option value="interesado" <?php echo ($tipo_asistente == 'interesado') ? 'selected' : ''; ?>>
                            Interesado - Persona interesada en conocer más sobre la iglesia
                        </option>
                    </select>
                </div>
                
                <!-- Edad -->
                <div class="form-group">
                    <label for="edad">Edad: *</label>
                    <input type="number" id="edad" name="edad" required min="1" max="120"
                           value="<?php echo htmlspecialchars($edad); ?>"
                           placeholder="Ingrese la edad en años">
                </div>
                
                <!-- Observaciones -->
                <div class="form-group">
                    <label for="observaciones">Observaciones:</label>
                    <textarea id="observaciones" name="observaciones" 
                              placeholder="Ingrese observaciones adicionales (opcional)"><?php echo htmlspecialchars($observaciones); ?></textarea>
                    <small style="color: #666; font-size: 0.9rem;">
                        Campo opcional. Puede incluir información adicional como: primera visita, 
                        interés en estudios bíblicos, necesidades especiales, etc.
                    </small>
                </div>
                
                <!-- Botones -->
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-full">
                        ✅ Registrar Asistente
                    </button>
                </div>
                
                <div class="form-group">
                    <a href="dashboard.php" class="btn btn-primary btn-full">
                        ⬅️ Volver al Dashboard
                    </a>
                </div>
            </form>
            
            <!-- Información adicional -->
            <div class="alert alert-info mt-2">
                <strong>Información importante:</strong><br>
                • Los campos marcados con (*) son obligatorios<br>
                • El registro se guardará con la fecha y hora actual<br>
                • Todos los datos quedarán asociados a su usuario: <?php echo htmlspecialchars($_SESSION['usuario']); ?><br>
                • Puede ver todos los asistentes registrados en la sección "Ver Asistentes"
            </div>
        </div>
    </div>
    
    <!-- JavaScript para validación y mejora de experiencia -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enfocar automáticamente el primer campo
            document.getElementById('nombre_completo').focus();
            
            // Validación del formulario
            const formulario = document.getElementById('formulario-registro');
            
            formulario.addEventListener('submit', function(e) {
                const nombre = document.getElementById('nombre_completo').value.trim();
                const tipo = document.getElementById('tipo_asistente').value;
                const edad = document.getElementById('edad').value;
                
                let errores = [];
                
                // Validar nombre
                if (nombre === '') {
                    errores.push('El nombre completo es obligatorio.');
                } else if (nombre.length < 3) {
                    errores.push('El nombre debe tener al menos 3 caracteres.');
                }
                
                // Validar tipo
                if (tipo === '') {
                    errores.push('Debe seleccionar un tipo de asistente.');
                }
                
                // Validar edad
                if (edad === '' || isNaN(edad) || edad < 1 || edad > 120) {
                    errores.push('Debe ingresar una edad válida (1-120 años).');
                }
                
                // Si hay errores, mostrarlos y prevenir envío
                if (errores.length > 0) {
                    e.preventDefault();
                    alert('Por favor corrija los siguientes errores:\n\n' + errores.join('\n'));
                    return false;
                }
                
                // Confirmación antes de enviar
                if (!confirm('¿Está seguro que desea registrar este asistente?')) {
                    e.preventDefault();
                    return false;
                }
            });
            
            // Formatear nombre automáticamente (primera letra en mayúscula)
            document.getElementById('nombre_completo').addEventListener('blur', function() {
                let nombre = this.value.trim();
                if (nombre) {
                    // Convertir a formato título (primera letra de cada palabra en mayúscula)
                    nombre = nombre.toLowerCase().replace(/\b\w/g, function(l) {
                        return l.toUpperCase();
                    });
                    this.value = nombre;
                }
            });
            
            // Mostrar descripción del tipo de asistente seleccionado
            document.getElementById('tipo_asistente').addEventListener('change', function() {
                const tipo = this.value;
                let descripcion = '';
                
                switch(tipo) {
                    case 'miembro':
                        descripcion = 'Persona que forma parte activa de la congregación.';
                        break;
                    case 'visitante':
                        descripcion = 'Persona que visita la iglesia por primera vez o esporádicamente.';
                        break;
                    case 'interesado':
                        descripcion = 'Persona interesada en conocer más sobre la iglesia y sus actividades.';
                        break;
                }
                
                // Mostrar descripción si existe un elemento para ello
                const descripcionElement = document.getElementById('descripcion-tipo');
                if (descripcionElement) {
                    descripcionElement.textContent = descripcion;
                }
            });
        });
    </script>
</body>
</html>