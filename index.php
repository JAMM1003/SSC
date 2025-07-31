<?php
// Página de inicio - index.php
// Incluir el header común
include 'header.php';
?>

<!-- Contenido específico de la página de inicio -->
<div class="container">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">App Web</h1>
            <p class="hero-subtitle">Bienvenido al Sistema de Gestión de la Iglesia Adventista del Séptimo Día - El Marqués</p>
            <div class="hero-description">
                <p>
                    Nos complace presentarte nuestra plataforma digital diseñada para fortalecer 
                    nuestra comunidad de fe y facilitar la administración de nuestras actividades.
                </p>
            </div>
            <div class="hero-actions">
                <?php if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true): ?>
                    <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
                <?php else: ?>
                    <a href="dashboard.php" class="btn btn-primary">Ir al Panel de Control</a>
                <?php endif; ?>
                <a href="#features" class="btn btn-secondary">Conocer Más</a>
            </div>
        </div>
        <div class="hero-image">
            <img src="https://placehold.co/500x350/1e3a8a/fbbf24?text=IASD+El+Marques" alt="Iglesia IASD El Marqués" class="hero-img">
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="section-header">
            <h2>Características del Sistema</h2>
            <p>Herramientas diseñadas para servir mejor a nuestra comunidad</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3>Gestión de Miembros</h3>
                <p>Administra la información de los miembros de la iglesia de manera eficiente y segura.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📋</div>
                <h3>Control de Asistencia</h3>
                <p>Registra y monitorea la asistencia a cultos, actividades y eventos especiales.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h3>Calendario de Eventos</h3>
                <p>Mantén informada a la congregación sobre próximas actividades y eventos.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Reportes y Estadísticas</h3>
                <p>Genera reportes detallados para una mejor toma de decisiones administrativas.</p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="about-content">
            <div class="about-text">
                <h2>Nuestra Misión</h2>
                <p>
                    Como Iglesia Adventista del Séptimo Día en El Marqués, nos dedicamos a 
                    compartir el amor de Cristo y preparar a las personas para Su segunda venida. 
                    Esta plataforma digital es una herramienta más para cumplir nuestra misión 
                    de manera más efectiva.
                </p>
                <div class="mission-points">
                    <div class="mission-point">
                        <span class="point-icon">✝️</span>
                        <span>Predicar el evangelio eterno</span>
                    </div>
                    <div class="mission-point">
                        <span class="point-icon">❤️</span>
                        <span>Servir a la comunidad con amor</span>
                    </div>
                    <div class="mission-point">
                        <span class="point-icon">📖</span>
                        <span>Enseñar las Sagradas Escrituras</span>
                    </div>
                    <div class="mission-point">
                        <span class="point-icon">🤝</span>
                        <span>Fortalecer la hermandad cristiana</span>
                    </div>
                </div>
            </div>
            <div class="about-image">
                <img src="https://placehold.co/400x300/3b82f6/ffffff?text=Mision+Cristiana" alt="Nuestra Misión" class="about-img">
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h2>¿Eres parte de nuestra congregación?</h2>
            <p>Accede al sistema para gestionar información y participar activamente en nuestras actividades.</p>
            <?php if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true): ?>
                <a href="login.php" class="btn btn-primary btn-large">Iniciar Sesión Ahora</a>
            <?php else: ?>
                <a href="dashboard.php" class="btn btn-primary btn-large">Ir al Panel de Control</a>
            <?php endif; ?>
        </div>
    </section>
</div>

<style>
/* Estilos específicos para la página de inicio */
.hero-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: center;
    padding: 4rem 0;
    min-height: 500px;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: bold;
    color: #1e3a8a;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.hero-subtitle {
    font-size: 1.3rem;
    color: #3b82f6;
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.hero-description {
    color: #6b7280;
    font-size: 1.1rem;
    line-height: 1.7;
    margin-bottom: 2rem;
}

.hero-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-primary {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #1e40af, #2563eb);
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1.1rem;
}

.hero-image {
    text-align: center;
}

.hero-img {
    max-width: 100%;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    transition: transform 0.3s ease;
}

.hero-img:hover {
    transform: scale(1.05);
}

/* Features Section */
.features-section {
    padding: 4rem 0;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    margin: 2rem -2rem;
}

.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-header h2 {
    font-size: 2.5rem;
    color: #1e3a8a;
    margin-bottom: 1rem;
}

.section-header p {
    font-size: 1.2rem;
    color: #6b7280;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    padding: 0 2rem;
}

.feature-card {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.feature-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.feature-card h3 {
    color: #1e3a8a;
    margin-bottom: 1rem;
    font-size: 1.3rem;
}

.feature-card p {
    color: #6b7280;
    line-height: 1.6;
}

/* About Section */
.about-section {
    padding: 4rem 0;
}

.about-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: center;
}

.about-text h2 {
    font-size: 2.2rem;
    color: #1e3a8a;
    margin-bottom: 1.5rem;
}

.about-text p {
    color: #6b7280;
    font-size: 1.1rem;
    line-height: 1.7;
    margin-bottom: 2rem;
}

.mission-points {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.mission-point {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 10px;
    border-left: 4px solid #fbbf24;
}

.point-icon {
    font-size: 1.5rem;
}

.about-img {
    max-width: 100%;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    color: white;
    text-align: center;
    padding: 4rem 2rem;
    margin: 2rem -2rem 0 -2rem;
    border-radius: 15px 15px 0 0;
}

.cta-content h2 {
    font-size: 2.2rem;
    margin-bottom: 1rem;
}

.cta-content p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-section {
        grid-template-columns: 1fr;
        text-align: center;
        padding: 2rem 0;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .about-content {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
        padding: 0 1rem;
    }
    
    .hero-actions {
        justify-content: center;
    }
}
</style>

<?php
// Incluir el footer común
include 'footer.php';
?>