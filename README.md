# Sistema de Control de Asistencia - IASD del Marqués

## Descripción del Proyecto

Este es un sistema web básico desarrollado para la **Iglesia Adventista del Séptimo Día (IASD) del Marqués** como parte de un proyecto universitario de servicio comunitario. El sistema permite registrar visitantes y miembros durante eventos, controlar asistencia, generar reportes simples y gestionar la información de manera eficiente.

## Características Principales

- ✅ **Sistema de Login Seguro**: Autenticación con usuario y contraseña
- 📊 **Dashboard Informativo**: Estadísticas en tiempo real y acceso rápido
- ➕ **Registro de Asistentes**: Formulario completo para nuevos registros
- 👥 **Gestión de Asistentes**: Lista completa con filtros y paginación
- 🔐 **Sesiones Seguras**: Control de acceso y logout seguro
- 📱 **Diseño Responsivo**: Compatible con dispositivos móviles

## Tipos de Asistentes

El sistema maneja tres tipos de asistentes:

1. **Miembros**: Personas que forman parte activa de la iglesia
2. **Visitantes**: Personas que visitan por primera vez o esporádicamente
3. **Interesados**: Personas interesadas en conocer más sobre la iglesia

## Tecnologías Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Backend**: PHP 7.4+ (sin frameworks)
- **Base de Datos**: MySQL 5.7+
- **Servidor Web**: Apache/Nginx

## Estructura de Archivos

```
sistema-iasd/
├── index.php          # Página de login principal
├── dashboard.php       # Dashboard con estadísticas
├── register.php        # Formulario de registro de asistentes
├── view.php           # Lista de asistentes con filtros
├── logout.php         # Funcionalidad de cerrar sesión
├── config.php         # Configuración de base de datos
├── style.css          # Estilos CSS del sistema
├── database.sql       # Script de creación de base de datos
└── README.md          # Este archivo
```

## Instalación y Configuración

### Requisitos del Sistema

- **Servidor Web**: Apache 2.4+ o Nginx 1.18+
- **PHP**: Versión 7.4 o superior
- **MySQL**: Versión 5.7 o superior
- **Extensiones PHP requeridas**:
  - PDO
  - PDO_MySQL
  - session

### Paso 1: Configurar la Base de Datos

1. **Crear la base de datos en MySQL**:
   ```sql
   mysql -u root -p < database.sql
   ```

2. **O ejecutar manualmente**:
   - Abra phpMyAdmin o su cliente MySQL preferido
   - Ejecute el contenido del archivo `database.sql`
   - Esto creará la base de datos `iasd_asistencia` con las tablas necesarias

### Paso 2: Configurar la Conexión

1. **Editar el archivo `config.php`**:
   ```php
   define('DB_HOST', 'localhost');        // Su servidor MySQL
   define('DB_NAME', 'iasd_asistencia');  // Nombre de la base de datos
   define('DB_USER', 'su_usuario');       // Su usuario MySQL
   define('DB_PASS', 'su_contraseña');    // Su contraseña MySQL
   ```

### Paso 3: Configurar el Servidor Web

#### Para Apache:
1. Copie todos los archivos al directorio web (ej: `/var/www/html/iasd/`)
2. Asegúrese de que Apache tenga permisos de lectura
3. Configure un VirtualHost si es necesario

#### Para Nginx:
1. Configure un server block apuntando a la carpeta del proyecto
2. Asegúrese de que PHP-FPM esté funcionando

### Paso 4: Verificar la Instalación

1. **Acceda al sistema**: `http://su-dominio/iasd/`
2. **Use las credenciales por defecto**:
   - Usuario: `admin`
   - Contraseña: `admin123`

## Uso del Sistema

### 1. Iniciar Sesión
- Acceda a la página principal
- Ingrese usuario: `admin` y contraseña: `admin123`
- Será redirigido al dashboard principal

### 2. Dashboard
- Vea estadísticas en tiempo real
- Acceda rápidamente a las funciones principales
- Observe los últimos asistentes registrados

### 3. Registrar Asistentes
- Haga clic en "Registrar Asistente"
- Complete el formulario con:
  - Nombre completo (obligatorio)
  - Tipo de asistente (obligatorio)
  - Edad (obligatorio)
  - Observaciones (opcional)
- El registro se guardará automáticamente

### 4. Ver Asistentes
- Acceda a la lista completa de asistentes
- Use filtros por tipo o búsqueda por nombre
- Navegue por páginas si hay muchos registros
- Vea información detallada de cada asistente

### 5. Cerrar Sesión
- Use el botón "Cerrar Sesión" en el menú
- Su sesión se cerrará de forma segura

## Características de Seguridad

- **Contraseñas Hasheadas**: Usando `password_hash()` de PHP
- **Prepared Statements**: Prevención de inyección SQL
- **Validación de Datos**: Limpieza y validación de entradas
- **Control de Sesiones**: Verificación de autenticación en cada página
- **Escape de HTML**: Prevención de XSS

## Personalización

### Cambiar Credenciales por Defecto

```sql
-- Cambiar contraseña del usuario admin
UPDATE usuarios SET password = PASSWORD_HASH('nueva_contraseña', PASSWORD_DEFAULT) WHERE usuario = 'admin';

-- Crear nuevo usuario
INSERT INTO usuarios (usuario, password, nombre) VALUES 
('nuevo_usuario', PASSWORD_HASH('contraseña', PASSWORD_DEFAULT), 'Nombre Completo');
```

### Modificar Estilos

Edite el archivo `style.css` para personalizar:
- Colores corporativos
- Tipografías
- Espaciados
- Diseño responsive

### Agregar Campos

Para agregar nuevos campos al registro:

1. **Modificar la base de datos**:
   ```sql
   ALTER TABLE asistentes ADD COLUMN nuevo_campo VARCHAR(100);
   ```

2. **Actualizar el formulario** en `register.php`
3. **Modificar la consulta** de inserción
4. **Actualizar la vista** en `view.php`

## Resolución de Problemas

### Error de Conexión a la Base de Datos
- Verifique las credenciales en `config.php`
- Asegúrese de que MySQL esté funcionando
- Confirme que la base de datos existe

### Página en Blanco
- Active la visualización de errores PHP:
  ```php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  ```
- Revise los logs del servidor web

### Problemas de Sesión
- Verifique que las sesiones estén habilitadas en PHP
- Confirme permisos de escritura en el directorio de sesiones

### Estilos no se Cargan
- Verifique la ruta del archivo `style.css`
- Confirme permisos de lectura del archivo

## Futuras Mejoras

Este es un prototipo básico. Posibles mejoras incluyen:

- 📧 **Envío de emails automáticos**
- 📊 **Reportes en PDF/Excel**
- 📅 **Sistema de eventos**
- 👤 **Gestión de usuarios múltiples**
- 🔄 **Backup automático**
- 📱 **App móvil**
- 🌐 **API REST**

## Soporte y Contacto

Este sistema fue desarrollado como proyecto de servicio comunitario universitario para IASD del Marqués.

### Información del Desarrollador
- **Proyecto**: Sistema de Control de Asistencia
- **Institución**: Universidad (Proyecto de Servicio Comunitario)
- **Beneficiario**: IASD del Marqués
- **Tecnología**: PHP, MySQL, HTML, CSS, JavaScript

### Reporte de Errores
Si encuentra algún problema:
1. Documente el error con capturas de pantalla
2. Incluya los pasos para reproducir el problema
3. Proporcione información del entorno (PHP, MySQL, navegador)

## Licencia

Este proyecto fue desarrollado con fines educativos y de servicio comunitario. El código es de uso libre para instituciones religiosas y educativas.

---

**¡Gracias por usar el Sistema de Control de Asistencia de IASD del Marqués!**

*Desarrollado con ❤️ para el servicio comunitario*
