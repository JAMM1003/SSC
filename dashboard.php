<?php
/**
 * Dashboard Principal - Sistema de Control de Asistencia
 * IASD del Marqués
 */

// Incluir archivo de configuración
require_once 'config.php';

// Verificar que el usuario esté logueado
verificarLogin();

// Obtener estadísticas de la base de datos
try {
    $pdo = conectarDB();
    
    // Contar total de asistentes
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM asistentes");
    $total_asistentes = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Contar por tipo de asistente
    $stmt = $pdo->query("SELECT tipo_asistente, COUNT(*) as cantidad FROM asistentes GROUP BY tipo_asistente");
    $estadisticas_tipo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Contar asistentes registrados hoy
    $stmt = $pdo->query("SELECT COUNT(*) as hoy FROM asistentes WHERE DATE(fecha_registro) = CURDATE()");
    $asistentes_hoy = $stmt->fetch(PDO::FETCH_ASSOC)['hoy'];
    
    // Contar asistentes de esta semana
    $stmt = $pdo->query("SELECT COUNT(*) as semana FROM asistentes WHERE YEARWEEK(fecha_registro) = YEARWEEK(NOW())");
    $asistentes_semana = $stmt->fetch(PDO::FETCH_ASSOC)['semana'];
    
    // Obtener últimos 5 asistentes registrados
    $stmt = $pdo->query("SELECT nombre_completo, tipo_asistente, fecha_registro FROM asistentes ORDER BY fecha_registro DESC LIMIT 5");
    $ultimos_asistentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    $error_db = "Error al obtener estadísticas: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - IASD del Marqués</title>
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
        
        <!-- Mensaje de bienvenida -->
        <div class="alert alert-info">
            <strong>¡Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</strong><br>
            Has iniciado sesión correctamente. Desde aquí puedes gestionar el registro de asistentes.
        </div>
        
        <!-- Mostrar error de base de datos si existe -->
        <?php if (isset($error_db)): ?>
            <div class="alert alert-error">
                <?php echo $error_db; ?>
            </div>
        <?php else: ?>
        
        <!-- Estadísticas principales -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_asistentes; ?></div>
                <div class="stat-label">Total Asistentes</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-number"><?php echo $asistentes_hoy; ?></div>
                <div class="stat-label">Registrados Hoy</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-number"><?php echo $asistentes_semana; ?></div>
                <div class="stat-label">Esta Semana</div>
            </div>
            
            <!-- Mostrar estadísticas por tipo -->
            <?php foreach ($estadisticas_tipo as $tipo): ?>
            <div class="stat-card">
                <div class="stat-number"><?php echo $tipo['cantidad']; ?></div>
                <div class="stat-label"><?php echo ucfirst($tipo['tipo_asistente']); ?>s</div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Acciones rápidas -->
        <div class="table-container">
            <h3>Acciones Rápidas</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1rem;">
                <a href="register.php" class="btn btn-success" style="text-align: center; padding: 2rem;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">➕</div>
                    <div>Registrar Nuevo Asistente</div>
                </a>
                
                <a href="view.php" class="btn btn-primary" style="text-align: center; padding: 2rem;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">👥</div>
                    <div>Ver Lista de Asistentes</div>
                </a>
            </div>
        </div>
        
        <!-- Últimos asistentes registrados -->
        <?php if (!empty($ultimos_asistentes)): ?>
        <div class="table-container mt-2">
            <h3>Últimos Asistentes Registrados</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Fecha de Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ultimos_asistentes as $asistente): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($asistente['nombre_completo']); ?></td>
                        <td>
                            <span style="padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; 
                                  background-color: <?php 
                                    switch($asistente['tipo_asistente']) {
                                        case 'miembro': echo '#d4edda'; break;
                                        case 'visitante': echo '#d1ecf1'; break;
                                        case 'interesado': echo '#fff3cd'; break;
                                    }
                                  ?>;">
                                <?php echo ucfirst($asistente['tipo_asistente']); ?>
                            </span>
                        </td>
                        <td><?php echo date('d/m/Y H:i', strtotime($asistente['fecha_registro'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="text-center mt-2">
                <a href="view.php" class="btn btn-primary">Ver Todos los Asistentes</a>
            </div>
        </div>
        <?php endif; ?>
        
        <?php endif; ?>
        
        <!-- Información del sistema -->
        <div class="alert alert-info mt-2">
            <strong>Información del Sistema:</strong><br>
            • Este sistema permite registrar y gestionar asistentes a eventos de la iglesia<br>
            • Puedes registrar miembros, visitantes e interesados<br>
            • Todas las acciones quedan registradas con fecha y hora<br>
            • Los datos se almacenan de forma segura en la base de datos
        </div>
    </div>
    
    <!-- JavaScript para actualizar estadísticas automáticamente -->
    <script>
        // Función para actualizar la hora actual
        function actualizarHora() {
            const ahora = new Date();
            const horaFormateada = ahora.toLocaleString('es-ES');
            
            // Si existe un elemento para mostrar la hora, actualizarlo
            const elementoHora = document.getElementById('hora-actual');
            if (elementoHora) {
                elementoHora.textContent = horaFormateada;
            }
        }
        
        // Actualizar cada minuto
        setInterval(actualizarHora, 60000);
        
        // Función para mostrar confirmación antes de cerrar sesión
        document.addEventListener('DOMContentLoaded', function() {
            const logoutLink = document.querySelector('a[href="logout.php"]');
            if (logoutLink) {
                logoutLink.addEventListener('click', function(e) {
                    if (!confirm('¿Está seguro que desea cerrar la sesión?')) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
</body>
</html>