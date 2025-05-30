# Sistema de Cotizaciones Online

## Descripción

Sistema web para la generación y gestión de cotizaciones de servicios digitales. Permite a los clientes solicitar cotizaciones de manera rápida y profesional, recibiendo un PDF con los detalles de su cotización.

## Características Principales

- Sistema de registro y autenticación de usuarios
- Formulario de cotización con múltiples campos de configuración
- Generación automática de PDFs con cotizaciones
- Sistema de correo electrónico para notificaciones
- Panel de usuario para gestión de cotizaciones
- Sistema de recuperación de contraseña

## Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor SMTP para envío de correos
- PHPMailer instalado
- TCPDF para generación de PDFs

## Instalación

1. Clonar el repositorio
2. Importar la base de datos desde `bd.sql`
3. Configurar las credenciales en `includes/config.php`
4. Ejecutar `composer install` para instalar dependencias
5. Configurar el servidor web

## Estructura del Proyecto

```
cotizadorpro/
├── actions/              # Acciones del sistema
├── assets/               # Archivos estáticos
├── includes/            # Archivos de configuración y funciones
├── libs/                # Librerías externas
├── logs/                # Archivos PDF generados
├── templates/           # Plantillas HTML
└── archivos PHP        # Archivos principales
```

## Seguridad

- Contraseñas hasheadas con password_hash()
- Sesiones seguras
- Protección contra inyección SQL
- Validación de entradas
- Tokens de recuperación con expiración

## Licencia

Este proyecto está bajo la licencia MIT - ver el archivo LICENSE para más detalles.