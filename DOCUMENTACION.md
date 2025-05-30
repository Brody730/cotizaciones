# Documentación del Sistema de Cotizaciones Online

## Estructura del Proyecto

```
cotizadorpro/
├── actions/              # Acciones del sistema (eliminar cotizaciones, etc.)
├── assets/               # Archivos estáticos (CSS, JS, imágenes)
├── includes/            # Archivos de configuración y funciones
├── libs/                # Librerías externas (PHPMailer)
├── logs/                # Archivos PDF generados
├── templates/           # Plantillas HTML
└── archivos PHP        # Archivos principales de la aplicación
```

## Funcionalidades Principales

### 1. Registro de Usuarios
- **register.php**: Permite crear una nueva cuenta
- Campos requeridos:
  - Nombre
  - Email
  - Contraseña

### 2. Login
- **login.php**: Sistema de autenticación
- Verifica credenciales y crea sesión
- Redirige al dashboard

### 3. Recuperación de Contraseña
- **forgot-password.php**: Solicita recuperación de contraseña
- **reset-password.php**: Permite cambiar la contraseña
- Usa tokens de recuperación con expiración

### 4. Dashboard
- **dashboard.php**: Panel principal del usuario
- Muestra:
  - Lista de cotizaciones recientes
  - Botones para:
    - Crear nueva cotización
    - Ver PDF de cotizaciones
    - Eliminar cotizaciones
    - Cerrar sesión

### 5. Cotizador
- **cotizador.php**: Formulario principal de cotización
- **procesar_cotizacion.php**: Procesa los datos del formulario
- Genera cotizaciones basadas en:
  - Tipo de servicio
  - Complejidad
  - Plazo

### 6. Sistema de Correo
- **includes/email_functions.php**: Funciones para enviar correos
- Usa PHPMailer para:
  - Enviar cotizaciones en PDF
  - Enviar correos de recuperación

## Base de Datos

### Tablas Principales
1. **usuarios**
   - id
   - nombre
   - email
   - password
   - created_at

2. **cotizaciones**
   - id
   - usuario_id
   - tipo_servicio
   - complejidad
   - plazo
   - precio
   - pdf_filename
   - fecha_creacion

3. **tokens_recuperacion**
   - id
   - usuario_id
   - token
   - expiracion

## Seguridad

1. **Autenticación**
   - Passwords hasheados con password_hash()
   - Sesiones seguras
   - Verificación de permisos

2. **Validación de Datos**
   - Prepared statements para SQL
   - Validación de entradas
   - Protección contra inyección SQL

3. **Gestión de Sesiones**
   - Sesiones iniciadas con session_start()
   - Verificación de sesión en cada página
   - Cierre de sesión seguro

## Configuración

### Archivos de Configuración
- **includes/config.php**: Configuración del sistema
  - Conexión a la base de datos
  - Configuración de correo
  - Variables globales

### Archivos de Funciones
- **includes/auth_functions.php**: Funciones de autenticación
- **includes/email_functions.php**: Funciones de correo

## Flujo de Usuario

1. **Nuevo Usuario**
   - Visita index.php
   - Se registra en register.php
   - Inicia sesión en login.php
   - Accede al dashboard

2. **Usuario Registrado**
   - Accede al dashboard
   - Crea nuevas cotizaciones
   - Consulta cotizaciones anteriores
   - Descarga PDFs
   - Elimina cotizaciones
   - Cambia contraseña

## Mantenimiento

1. **Logs**
   - Archivos PDF en logs/
   - Archivos de error en logs/

2. **Actualizaciones**
   - PHPMailer se actualiza usando Composer
   - Base de datos se actualiza usando bd.sql

3. **Backup**
   - Copias de seguridad de la base de datos
   - Copias de seguridad de archivos PDF

## Requisitos del Sistema

1. **Servidor**
   - PHP 7.4 o superior
   - MySQL/MariaDB
   - SMTP para correo

2. **Cliente**
   - Navegador moderno
   - JavaScript habilitado
   - Cookies habilitadas

## Mejores Prácticas

1. **Seguridad**
   - Nunca almacenar contraseñas en texto plano
   - Validar siempre las entradas
   - Usar HTTPS

2. **Desarrollo**
   - Usar version control (Git)
   - Documentar cambios
   - Mantener backups

3. **Uso**
   - Mantener sesión activa
   - No compartir credenciales
   - Verificar correos recibidos
