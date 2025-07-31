<?php
// Página del dashboard - dashboard.php
// Verificación de autenticación y control de acceso
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // Redirigir al login si no está autenticado
    header("Location: login.php");
    exit();
}

// Obtener la sección actual (por defecto: dashboard)
$seccion_actual = isset($_GET['seccion']) ? $_GET['seccion'] : 'dashboard';

// Datos hardcodeados para las diferentes secciones
// Datos de usuarios
$usuarios = [
    [
        'id' => 1,
        'nombre' => 'Juan Moreno',
        'edad' => 24,
        'rol' => 'director',
        'telefono' => '(442) 123-4567',
        'email' => 'juan.moreno@iasd.org',
        'fecha_registro' => '2023-01-15'
    ],
    [
        'id' => 2,
        'nombre' => 'Laura López',
        'edad' => 20,
        'rol' => 'miembro',
        'telefono' => '(442) 234-5678',
        'email' => 'laura.lopez@iasd.org',
        'fecha_registro' => '2023-03-22'
    ],
    [
        'id' => 3,
        'nombre' => 'Fabiana Herrera',
        'edad' => 25,
        'rol' => 'cantante',
        'telefono' => '(442) 345-6789',
        'email' => 'fabiana.herrera@iasd.org',
        'fecha_registro' => '2023-02-10'
    ]
];

// Datos de asistencia a actividades
$actividades_asistencia = [
    [
        'id' => 1,
        'actividad' => 'Cantata 7/7',
        'fecha' => '2024-07-07',
        'asistentes' => ['Juan Moreno', 'Laura López'],
        'total_asistentes' => 2,
        'tipo' => 'evento_especial'
    ],
    [
        'id' => 2,
        'actividad' => 'Cerca de ti 21/7',
        'fecha' => '2024-07-21',
        'asistentes' => ['Laura López'],
        'total_asistentes' => 1,
        'tipo' => 'programa_joven'
    ],
    [
        'id' => 3,
        'actividad' => 'Culto 26/7',
        'fecha' => '2024-07-26',
        'asistentes' => ['Juan Moreno', 'Laura López', 'Fabiana Herrera'],
        'total_asistentes' => 3,
        'tipo' => 'culto_regular'
    ]
];

// Incluir el header común
include 'header.php';
?>

<!-- Estilos específicos para el dashboard -->
<style>
    /* Layout principal del dashboard */
    .dashboard-layout {
        display: flex;
        min-height: calc(100vh - 200px);
        background: #f8fafc;
    }
    
    /* Menú lateral */
    .sidebar {
        width: 280px;
        background: white;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        padding: 0;
        position: fixed;
        height: calc(100vh - 120px);
        overflow-y: auto;
    }
    
    .sidebar-header {
        padding: 2rem 1.5rem 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        color: white;
    }
    
    .sidebar-header h3 {
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }
    
    .sidebar-header p {
        font-size: 0.9rem;
        opacity: 0.9;
        margin: 0;
    }
    
    .sidebar-menu {
        padding: 1rem 0;
    }
    
    .menu-item {
        display: block;
        padding: 1rem 1.5rem;
        color: #374151;
        text-decoration: none;
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .menu-item:hover {
        background: #f3f4f6;
        color: #1e3a8a;
        border-left-color: #fbbf24;
    }
    
    .menu-item.active {
        background: #e0f2fe;
        color: #1e3a8a;
        border-left-color: #3b82f6;
    }
    
    .menu-item i {
        margin-right: 0.75rem;
        width: 20px;
        text-align: center;
    }
    
    /* Contenido principal */
    .main-content {
        flex: 1;
        margin-left: 280px;
        padding: 2rem;
    }
    
    .content-header {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
    }
    
    .content-header h1 {
        color: #1e3a8a;
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    
    .content-header p {
        color: #6b7280;
        font-size: 1.1rem;
    }
    
    .content-section {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    /* Estilos para la tabla de usuarios */
    .table-container {
        overflow-x: auto;
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table th {
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
    }
    
    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .data-table tr:hover {
        background: #f8fafc;
    }
    
    .role-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .role-director {
        background: #fef3c7;
        color: #92400e;
    }
    
    .role-miembro {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .role-cantante {
        background: #fce7f3;
        color: #be185d;
    }
    
    /* Estilos para las tarjetas de actividades */
    .activities-grid {
        display: grid;
        gap: 1.5rem;
        padding: 2rem;
    }
    
    .activity-card {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .activity-card:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .activity-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #1e3a8a;
    }
    
    .activity-date {
        color: #6b7280;
        font-size: 0.9rem;
    }
    
    .activity-type {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }
    
    .type-evento_especial {
        background: #fef3c7;
        color: #92400e;
    }
    
    .type-programa_joven {
        background: #ecfdf5;
        color: #065f46;
    }
    
    .type-culto_regular {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .attendees-list {
        color: #374151;
        line-height: 1.6;
    }
    
    .attendees-count {
        color: #059669;
        font-weight: 600;
        margin-top: 0.5rem;
    }
    
    /* Dashboard de bienvenida */
    .welcome-section {
        padding: 2rem;
        text-align: center;
    }
    
    .welcome-image {
        margin: 2rem 0;
    }
    
    .welcome-image img {
        max-width: 100%;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    
    .stat-card {
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        color: white;
        padding: 1.5rem;
        border-radius: 15px;
        text-align: center;
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #fbbf24;
    }
    
    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-top: 0.5rem;
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            position: relative;
            height: auto;
        }
        
        .main-content {
            margin-left: 0;
            padding: 1rem;
        }
        
        .dashboard-layout {
            flex-direction: column;
        }
        
        .data-table {
            font-size: 0.9rem;
        }
        
        .data-table th,
        .data-table td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>

<!-- Contenido del dashboard -->
<div class="dashboard-layout">
    <!-- Menú lateral -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h3>Panel de Control</h3>
            <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </div>
        
        <nav class="sidebar-menu">
            <a href="dashboard.php?seccion=dashboard" class="menu-item <?php echo $seccion_actual === 'dashboard' ? 'active' : ''; ?>">
                <i>🏠</i> Inicio
            </a>
            <a href="dashboard.php?seccion=usuarios" class="menu-item <?php echo $seccion_actual === 'usuarios' ? 'active' : ''; ?>">
                <i>👥</i> Ver usuarios
            </a>
            <a href="dashboard.php?seccion=asistencia" class="menu-item <?php echo $seccion_actual === 'asistencia' ? 'active' : ''; ?>">
                <i>📋</i> Registrar asistencia
            </a>
        </nav>
    </aside>
    
    <!-- Contenido principal -->
    <main class="main-content">
        <?php if ($seccion_actual === 'dashboard'): ?>
            <!-- Sección de bienvenida -->
            <div class="content-header">
                <h1>¡Bienvenido al Panel de Administración!</h1>
                <p>Gestiona la información de la iglesia desde este panel centralizado.</p>
            </div>
            
            <div class="content-section">
                <div class="welcome-section">
                    <h2 style="color: #1e3a8a; margin-bottom: 1rem;">Sistema de Gestión IASD El Marqués</h2>
                    <p style="color: #6b7280; font-size: 1.1rem; margin-bottom: 2rem;">
                        Utiliza el menú lateral para navegar entre las diferentes secciones del sistema.
                    </p>
                    
                    <div class="welcome-image">
                        <img src="https://placehold.co/400x200?text=Bienvenida" alt="Imagen de bienvenida">
                    </div>
                    
                    <!-- Estadísticas rápidas -->
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-number"><?php echo count($usuarios); ?></div>
                            <div class="stat-label">Usuarios Registrados</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number"><?php echo count($actividades_asistencia); ?></div>
                            <div class="stat-label">Actividades Registradas</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">
                                <?php 
                                $total_asistencias = 0;
                                foreach($actividades_asistencia as $actividad) {
                                    $total_asistencias += $actividad['total_asistentes'];
                                }
                                echo $total_asistencias;
                                ?>
                            </div>
                            <div class="stat-label">Total Asistencias</div>
                        </div>
                    </div>
                </div>
            </div>
            
        <?php elseif ($seccion_actual === 'usuarios'): ?>
            <!-- Sección Ver usuarios -->
            <div class="content-header">
                <h1>Gestión de Usuarios</h1>
                <p>Lista completa de miembros registrados en el sistema.</p>
            </div>
            
            <div class="content-section">
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>Edad</th>
                                <th>Rol</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Fecha de Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo $usuario['id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($usuario['nombre']); ?></strong>
                                </td>
                                <td><?php echo $usuario['edad']; ?> años</td>
                                <td>
                                    <span class="role-badge role-<?php echo $usuario['rol']; ?>">
                                        <?php echo ucfirst($usuario['rol']); ?>
                                    </span>
                                </td>
                                <td><?php echo $usuario['telefono']; ?></td>
                                <td><?php echo $usuario['email']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($usuario['fecha_registro'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        <?php elseif ($seccion_actual === 'asistencia'): ?>
            <!-- Sección Registrar asistencia -->
            <div class="content-header">
                <h1>Control de Asistencia</h1>
                <p>Registro histórico de asistencia a actividades y eventos de la iglesia.</p>
            </div>
            
            <div class="content-section">
                <div class="activities-grid">
                    <?php foreach ($actividades_asistencia as $actividad): ?>
                    <div class="activity-card">
                        <div class="activity-header">
                            <div class="activity-title"><?php echo htmlspecialchars($actividad['actividad']); ?></div>
                            <div class="activity-date"><?php echo date('d/m/Y', strtotime($actividad['fecha'])); ?></div>
                        </div>
                        
                        <div class="activity-type type-<?php echo $actividad['tipo']; ?>">
                            <?php 
                            $tipos = [
                                'evento_especial' => 'Evento Especial',
                                'programa_joven' => 'Programa Joven',
                                'culto_regular' => 'Culto Regular'
                            ];
                            echo $tipos[$actividad['tipo']];
                            ?>
                        </div>
                        
                        <div class="attendees-list">
                            <strong>Asistentes:</strong><br>
                            <?php echo implode(', ', $actividad['asistentes']); ?>
                        </div>
                        
                        <div class="attendees-count">
                            Total de asistentes: <?php echo $actividad['total_asistentes']; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
        <?php endif; ?>
    </main>
</div>

<!-- JavaScript para mejorar la funcionalidad del dashboard -->
<script>
    // Función para confirmar acciones
    function confirmarAccion(mensaje) {
        return confirm(mensaje);
    }
    
    // Actualizar automáticamente la hora de última actividad
    function actualizarHoraActividad() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('es-ES');
        
        // Si existe un elemento para mostrar la hora, actualizarlo
        const timeElement = document.getElementById('last-activity-time');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }
    
    // Actualizar cada minuto
    setInterval(actualizarHoraActividad, 60000);
    
    // Mejorar la experiencia de navegación
    document.addEventListener('DOMContentLoaded', function() {
        // Añadir efectos hover a las tarjetas
        const cards = document.querySelectorAll('.activity-card, .stat-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Confirmar antes de cerrar sesión
        const logoutLinks = document.querySelectorAll('a[href*="logout"]');
        logoutLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (!confirm('¿Está seguro que desea cerrar sesión?')) {
                    e.preventDefault();
                }
            });
        });
    });
    
    // Función para mostrar detalles de usuario
    function mostrarDetallesUsuario(userId) {
        // En una implementación real, esto abriría un modal con más detalles
        showMessage('Funcionalidad de detalles disponible en la versión completa', 'info');
    }
    
    // Función para filtrar tabla de usuarios
    function filtrarUsuarios(filtro) {
        const filas = document.querySelectorAll('.data-table tbody tr');
        filas.forEach(fila => {
            const texto = fila.textContent.toLowerCase();
            fila.style.display = texto.includes(filtro.toLowerCase()) ? '' : 'none';
        });
    }
</script>

<?php
// Incluir el footer común
include 'footer.php';
?>