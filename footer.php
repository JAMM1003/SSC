    </main>
    <!-- Fin del contenido principal -->

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <!-- Información principal -->
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <div class="logo-icon">⛪</div>
                        <h3>IASD El Marqués</h3>
                    </div>
                    <p class="footer-description">
                        Iglesia Adventista del Séptimo Día comprometida con la comunidad de El Marqués, 
                        compartiendo esperanza y amor a través del servicio cristiano.
                    </p>
                </div>

                <div class="footer-section">
                    <h4>Contacto</h4>
                    <div class="contact-info">
                        <p>📍 El Marqués, Querétaro</p>
                        <p>📞 (442) 123-4567</p>
                        <p>✉️ info@iasdmarques.org</p>
                    </div>
                </div>

                <div class="footer-section">
                    <h4>Horarios de Culto</h4>
                    <div class="schedule-info">
                        <p><strong>Sábados:</strong></p>
                        <p>Escuela Sabática: 9:00 AM</p>
                        <p>Culto Divino: 11:00 AM</p>
                        <p><strong>Miércoles:</strong></p>
                        <p>Oración: 7:00 PM</p>
                    </div>
                </div>

                <div class="footer-section">
                    <h4>Síguenos</h4>
                    <div class="social-links">
                        <a href="#" class="social-link">📘 Facebook</a>
                        <a href="#" class="social-link">📷 Instagram</a>
                        <a href="#" class="social-link">🐦 Twitter</a>
                        <a href="#" class="social-link">📺 YouTube</a>
                    </div>
                </div>
            </div>

            <!-- Línea divisoria -->
            <div class="footer-divider"></div>

            <!-- Copyright -->
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Iglesia Adventista del Séptimo Día - El Marqués. Todos los derechos reservados.</p>
                <p class="footer-verse">"Porque de tal manera amó Dios al mundo..." - Juan 3:16</p>
            </div>
        </div>
    </footer>

    <style>
        /* Footer Styles */
        .footer {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            margin-top: auto;
            padding: 3rem 0 1rem 0;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3,
        .footer-section h4 {
            color: #fbbf24;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .footer-logo .logo-icon {
            width: 40px;
            height: 40px;
            background: #fbbf24;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #1e3a8a;
        }

        .footer-description {
            line-height: 1.6;
            color: #e2e8f0;
            margin-bottom: 1rem;
        }

        .contact-info p,
        .schedule-info p {
            margin-bottom: 0.5rem;
            color: #e2e8f0;
        }

        .schedule-info strong {
            color: #fbbf24;
        }

        .social-links {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .social-link {
            color: #e2e8f0;
            text-decoration: none;
            transition: color 0.3s ease;
            padding: 0.25rem 0;
        }

        .social-link:hover {
            color: #fbbf24;
        }

        .footer-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #fbbf24, transparent);
            margin: 2rem 0;
        }

        .footer-bottom {
            text-align: center;
            color: #e2e8f0;
            font-size: 0.9rem;
        }

        .footer-verse {
            color: #fbbf24;
            font-style: italic;
            margin-top: 0.5rem;
        }

        /* Responsive design para footer */
        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .footer-logo {
                justify-content: center;
            }

            .social-links {
                align-items: center;
            }
        }

        /* Estilos adicionales para el layout general */
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            padding: 2rem 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Utilidades generales */
        .text-center {
            text-align: center;
        }

        .mb-2 {
            margin-bottom: 1rem;
        }

        .mb-4 {
            margin-bottom: 2rem;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #fbbf24;
            color: #1e3a8a;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #f59e0b;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
        }

        .btn-secondary {
            background: #1e3a8a;
            color: white;
        }

        .btn-secondary:hover {
            background: #1e40af;
        }
    </style>

    <!-- JavaScript básico para interactividad -->
    <script>
        // Función para mostrar mensajes de confirmación
        function showMessage(message, type = 'info') {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message message-${type}`;
            messageDiv.textContent = message;
            messageDiv.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 1rem 2rem;
                background: ${type === 'error' ? '#ef4444' : type === 'success' ? '#10b981' : '#3b82f6'};
                color: white;
                border-radius: 5px;
                z-index: 1000;
                animation: slideIn 0.3s ease;
            `;
            
            document.body.appendChild(messageDiv);
            
            setTimeout(() => {
                messageDiv.remove();
            }, 3000);
        }

        // Animación para los mensajes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
        document.head.appendChild(style);

        // Función para validar formularios
        function validateForm(formId) {
            const form = document.getElementById(formId);
            const inputs = form.querySelectorAll('input[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.style.borderColor = '#ef4444';
                    isValid = false;
                } else {
                    input.style.borderColor = '#d1d5db';
                }
            });

            return isValid;
        }
    </script>
</body>
</html>