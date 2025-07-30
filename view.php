<?php
/**
 * Página para Ver Asistentes - Sistema de Control de Asistencia
 * IASD del Marqués
 */

// Incluir archivo de configuración
require_once 'config.php';

// Verificar que el usuario esté logueado
verificarLogin();

// Variables para paginación y filtros
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$registros_por_pagina = 10;
$filtro_tipo = isset($_GET['tipo']) ? limpiarDatos($_GET['tipo']) : '';
$filtro_busqueda = isset($_GET['busqueda']) ? limpiarDatos($_GET['busqueda']) : '';

// Calcular offset para la consulta
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Construir consulta SQL con filtros
$where_conditions = [];
$params = [];

if (!empty($filtro_tipo) && in_array($filtro_tipo, ['miembro', 'visitante', 'interesado'])) {
    $where_conditions[] = "tipo_asistente = ?";
    $params[] = $filtro_tipo;
}

if (!empty($filtro_busqueda)) {
    $where_conditions[] = "nombre_completo LIKE ?";
    $params[] = "%" . $filtro_busqueda . "%";
}

$where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

try {
    $pdo = conectarDB();
    
    // Contar total de registros (para paginación)
    $count_query = "SELECT COUNT(*) as total FROM asistentes $where_clause";
    $stmt = $pdo->prepare($count_query);
    $stmt->execute($params);
    $total_registros = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Calcular total de páginas
    $total_paginas = ceil($total_registros / $registros_por_pagina);
    
    // Obtener asistentes con paginación
    $query = "SELECT * FROM asistentes $where_clause ORDER BY fecha_registro DESC LIMIT $registros_por_pagina OFFSET $offset";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $asistentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Obtener estadísticas rápidas
    $stmt = $pdo->query("SELECT tipo_asistente, COUNT(*) as cantidad FROM asistentes GROUP BY tipo_asistente");
    $estadisticas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    $error_db = "Error al obtener datos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Asistentes - IASD del Marqués</title>
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
        
        <!-- Mostrar error de base de datos si existe -->
        <?php if (isset($error_db)): ?>
            <div class="alert alert-error">
                <?php echo $error_db; ?>
            </div>
        <?php else: ?>
        
        <!-- Estadísticas rápidas -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_registros; ?></div>
                <div class="stat-label">Total de Asistentes</div>
            </div>
            
            <?php foreach ($estadisticas as $stat): ?>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stat['cantidad']; ?></div>
                <div class="stat-label"><?php echo ucfirst($stat['tipo_asistente']); ?>s</div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Filtros y búsqueda -->
        <div class="table-container">
            <h3>Lista de Asistentes Registrados</h3>
            
            <!-- Formulario de filtros -->
            <form method="GET" action="" style="margin-bottom: 1rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 1rem; align-items: end;">
                    <!-- Filtro por tipo -->
                    <div>
                        <label for="tipo" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Filtrar por tipo:</label>
                        <select name="tipo" id="tipo">
                            <option value="">Todos los tipos</option>
                            <option value="miembro" <?php echo ($filtro_tipo == 'miembro') ? 'selected' : ''; ?>>Miembros</option>
                            <option value="visitante" <?php echo ($filtro_tipo == 'visitante') ? 'selected' : ''; ?>>Visitantes</option>
                            <option value="interesado" <?php echo ($filtro_tipo == 'interesado') ? 'selected' : ''; ?>>Interesados</option>
                        </select>
                    </div>
                    
                    <!-- Búsqueda por nombre -->
                    <div>
                        <label for="busqueda" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Buscar por nombre:</label>
                        <input type="text" name="busqueda" id="busqueda" 
                               value="<?php echo htmlspecialchars($filtro_busqueda); ?>" 
                               placeholder="Ingrese nombre a buscar">
                    </div>
                    
                    <!-- Botones -->
                    <div>
                        <button type="submit" class="btn btn-primary">🔍 Filtrar</button>
                        <a href="view.php" class="btn btn-secondary" style="margin-left: 0.5rem;">🔄 Limpiar</a>
                    </div>
                </div>
            </form>
            
            <!-- Información de resultados -->
            <div style="margin-bottom: 1rem; color: #666;">
                <?php if (!empty($filtro_tipo) || !empty($filtro_busqueda)): ?>
                    <strong>Filtros aplicados:</strong>
                    <?php if (!empty($filtro_tipo)): ?>
                        Tipo: <?php echo ucfirst($filtro_tipo); ?>
                    <?php endif; ?>
                    <?php if (!empty($filtro_busqueda)): ?>
                        | Búsqueda: "<?php echo htmlspecialchars($filtro_busqueda); ?>"
                    <?php endif; ?>
                    <br>
                <?php endif; ?>
                
                Mostrando <?php echo count($asistentes); ?> de <?php echo $total_registros; ?> asistentes
                <?php if ($total_paginas > 1): ?>
                    | Página <?php echo $pagina_actual; ?> de <?php echo $total_paginas; ?>
                <?php endif; ?>
            </div>
            
            <!-- Tabla de asistentes -->
            <?php if (!empty($asistentes)): ?>
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>Tipo</th>
                                <th>Edad</th>
                                <th>Observaciones</th>
                                <th>Fecha de Registro</th>
                                <th>Registrado por</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($asistentes as $asistente): ?>
                            <tr>
                                <td><?php echo $asistente['id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($asistente['nombre_completo']); ?></strong>
                                </td>
                                <td>
                                    <span style="padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; font-weight: bold; color: white;
                                          background-color: <?php 
                                            switch($asistente['tipo_asistente']) {
                                                case 'miembro': echo '#27ae60'; break;
                                                case 'visitante': echo '#3498db'; break;
                                                case 'interesado': echo '#f39c12'; break;
                                            }
                                          ?>;">
                                        <?php echo ucfirst($asistente['tipo_asistente']); ?>
                                    </span>
                                </td>
                                <td><?php echo $asistente['edad']; ?> años</td>
                                <td>
                                    <?php if (!empty($asistente['observaciones'])): ?>
                                        <span title="<?php echo htmlspecialchars($asistente['observaciones']); ?>">
                                            <?php echo strlen($asistente['observaciones']) > 50 
                                                ? htmlspecialchars(substr($asistente['observaciones'], 0, 50)) . '...' 
                                                : htmlspecialchars($asistente['observaciones']); ?>
                                        </span>
                                    <?php else: ?>
                                        <em style="color: #999;">Sin observaciones</em>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo date('d/m/Y', strtotime($asistente['fecha_registro'])); ?><br>
                                    <small style="color: #666;">
                                        <?php echo date('H:i', strtotime($asistente['fecha_registro'])); ?>
                                    </small>
                                </td>
                                <td><?php echo htmlspecialchars($asistente['usuario_registro']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <?php if ($total_paginas > 1): ?>
                <div style="margin-top: 2rem; text-align: center;">
                    <div style="display: inline-flex; gap: 0.5rem; align-items: center;">
                        <!-- Página anterior -->
                        <?php if ($pagina_actual > 1): ?>
                            <a href="?pagina=<?php echo $pagina_actual - 1; ?><?php echo !empty($filtro_tipo) ? '&tipo=' . urlencode($filtro_tipo) : ''; ?><?php echo !empty($filtro_busqueda) ? '&busqueda=' . urlencode($filtro_busqueda) : ''; ?>" 
                               class="btn btn-primary">« Anterior</a>
                        <?php endif; ?>
                        
                        <!-- Números de página -->
                        <?php
                        $inicio = max(1, $pagina_actual - 2);
                        $fin = min($total_paginas, $pagina_actual + 2);
                        
                        for ($i = $inicio; $i <= $fin; $i++):
                        ?>
                            <?php if ($i == $pagina_actual): ?>
                                <span style="padding: 0.5rem 1rem; background-color: #3498db; color: white; border-radius: 4px;">
                                    <?php echo $i; ?>
                                </span>
                            <?php else: ?>
                                <a href="?pagina=<?php echo $i; ?><?php echo !empty($filtro_tipo) ? '&tipo=' . urlencode($filtro_tipo) : ''; ?><?php echo !empty($filtro_busqueda) ? '&busqueda=' . urlencode($filtro_busqueda) : ''; ?>" 
                                   style="padding: 0.5rem 1rem; text-decoration: none; border: 1px solid #ddd; border-radius: 4px;">
                                    <?php echo $i; ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        
                        <!-- Página siguiente -->
                        <?php if ($pagina_actual < $total_paginas): ?>
                            <a href="?pagina=<?php echo $pagina_actual + 1; ?><?php echo !empty($filtro_tipo) ? '&tipo=' . urlencode($filtro_tipo) : ''; ?><?php echo !empty($filtro_busqueda) ? '&busqueda=' . urlencode($filtro_busqueda) : ''; ?>" 
                               class="btn btn-primary">Siguiente »</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                
            <?php else: ?>
                <!-- No hay asistentes -->
                <div class="alert alert-info">
                    <?php if (!empty($filtro_tipo) || !empty($filtro_busqueda)): ?>
                        No se encontraron asistentes que coincidan con los filtros aplicados.
                        <br><br>
                        <a href="view.php" class="btn btn-primary">Ver todos los asistentes</a>
                    <?php else: ?>
                        No hay asistentes registrados aún.
                        <br><br>
                        <a href="register.php" class="btn btn-success">Registrar primer asistente</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <!-- Acciones adicionales -->
            <div style="margin-top: 2rem; text-align: center;">
                <a href="register.php" class="btn btn-success">➕ Registrar Nuevo Asistente</a>
                <a href="dashboard.php" class="btn btn-primary" style="margin-left: 1rem;">📊 Volver al Dashboard</a>
            </div>
        </div>
        
        <?php endif; ?>
        
        <!-- Información de ayuda -->
        <div class="alert alert-info mt-2">
            <strong>Información sobre la tabla:</strong><br>
            • Puede filtrar por tipo de asistente o buscar por nombre<br>
            • Los resultados se muestran paginados (<?php echo $registros_por_pagina; ?> por página)<br>
            • Las observaciones largas se muestran truncadas (pase el cursor para ver completas)<br>
            • Los datos están ordenados por fecha de registro (más recientes primero)
        </div>
    </div>
    
    <!-- JavaScript para mejorar la experiencia -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Función para exportar datos (simulada)
            function exportarDatos() {
                alert('Función de exportación no implementada en esta versión básica.\n\nEn una versión completa, aquí se podría exportar a Excel, PDF, etc.');
            }
            
            // Confirmar antes de limpiar filtros si hay datos
            const limpiarBtn = document.querySelector('a[href="view.php"]');
            if (limpiarBtn && (window.location.search.includes('tipo=') || window.location.search.includes('busqueda='))) {
                limpiarBtn.addEventListener('click', function(e) {
                    if (!confirm('¿Está seguro que desea limpiar todos los filtros?')) {
                        e.preventDefault();
                    }
                });
            }
            
            // Resaltar fila al pasar el cursor
            const filas = document.querySelectorAll('.table tbody tr');
            filas.forEach(function(fila) {
                fila.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f0f8ff';
                });
                
                fila.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
            
            // Auto-submit del formulario al cambiar el filtro de tipo
            document.getElementById('tipo').addEventListener('change', function() {
                // Opcional: enviar automáticamente el formulario al cambiar el tipo
                // this.form.submit();
            });
        });
    </script>
</body>
</html>