# 📧 Configuración del Sistema de Recuperación de Contraseñas

## Resumen del Sistema

El sistema de recuperación de contraseñas permite a los usuarios restablecer su contraseña mediante un código de verificación enviado por correo electrónico.

### Archivos Principales:
- **Modelo**: `app/models/olvidoContraseniaModel.php`
- **Controlador**: `app/controllers/olvidoContraseniaController.php`
- **Vistas**: `app/views/olvido-contrasenia/`
- **Configuración**: `app/config/mail.php`
- **Rutas**: `app/config/routes.php`

## 🔧 Configuración Paso a Paso

### 1. Configuración de Gmail

#### Paso 1: Habilitar verificación en dos pasos
1. Ve a [Google Account](https://myaccount.google.com/)
2. Selecciona "Seguridad" → "Verificación en 2 pasos"
3. Sigue las instrucciones para habilitarla

#### Paso 2: Generar contraseña de aplicación
1. En "Seguridad" → "Contraseñas de aplicaciones"
2. Selecciona "Correo" → "Otro (nombre personalizado)"
3. Escribe "GymTech"
4. **Guarda la contraseña de 16 caracteres generada**

### 2. Configurar archivo mail.php

Edita `app/config/mail.php` y completa:

```php
'credentials' => [
    'username' => 'tu_correo@gmail.com',        // Tu correo de Gmail
    'password' => 'abcd efgh ijkl mnop',        // Contraseña de aplicación (16 caracteres)
],

'from' => [
    'address' => 'tu_correo@gmail.com',         // Mismo correo que username
    'name' => 'GymTech - Sistema de Recuperación',
],
```

### 3. Verificar Base de Datos

La tabla `password_reset_tokens` debe existir con esta estructura:

```sql
CREATE TABLE password_reset_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    used TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_token (token)
);
```

## 🚀 Rutas del Sistema

El sistema utiliza estas rutas:

- **GET** `/olvido-contrasenia/solicitar` - Formulario para solicitar recuperación
- **POST** `/olvido-contrasenia/procesar-solicitud` - Procesar solicitud y enviar código
- **GET** `/olvido-contrasenia/verificar` - Formulario para verificar código
- **POST** `/olvido-contrasenia/procesar-verificacion` - Verificar código ingresado
- **GET** `/olvido-contrasenia/cambiar` - Formulario para nueva contraseña
- **POST** `/olvido-contrasenia/procesar-cambio` - Cambiar contraseña

## 🔍 Flujo del Sistema

1. **Solicitud**: Usuario ingresa su email
2. **Verificación**: Sistema verifica que el email existe
3. **Código**: Se genera código de 6 dígitos y se envía por correo
4. **Validación**: Usuario ingresa el código recibido
5. **Cambio**: Usuario establece nueva contraseña
6. **Confirmación**: Sistema actualiza la contraseña y confirma el cambio

## ⚙️ Configuraciones Personalizables

En `app/config/mail.php` puedes modificar:

```php
'recovery' => [
    'subject' => 'Tu Asunto Personalizado',
    'expiry_minutes' => 15,      // Tiempo de expiración (minutos)
    'code_length' => 6,          // Longitud del código
],

'debug' => [
    'enabled' => true,           // Habilitar para depuración
    'level' => 2,               // Nivel de debug
],
```

## 🛠️ Solución de Problemas

### Error: "Class PHPMailer not found"
```bash
composer install
```

### Error: "SMTP Authentication failed"
- Verifica que la verificación en 2 pasos esté habilitada
- Usa la contraseña de aplicación, no tu contraseña normal
- Verifica que el correo sea correcto

### Error: "Database connection failed"
- Verifica `app/config/database.php`
- Asegúrate de que la base de datos `gymtech` exista
- Verifica que la tabla `password_reset_tokens` exista

### Código no llega al correo
- Revisa la carpeta de spam
- Habilita debug en `mail.php` para ver errores
- Verifica que el correo del usuario exista en la base de datos

## 📝 Logs y Depuración

Para habilitar logs detallados:

1. En `app/config/mail.php`:
```php
'debug' => [
    'enabled' => true,
    'level' => 2,
],
```

2. Los errores se registran en el log de PHP y se muestran en pantalla durante desarrollo.

## 🔒 Seguridad

- Los códigos expiran automáticamente
- Solo se permite un código activo por usuario
- Las contraseñas se hashean con `password_hash()`
- Se valida que el usuario exista antes de enviar códigos
- Se invalidan códigos anteriores al generar uno nuevo

## 📞 Soporte

Si encuentras problemas:
1. Verifica los logs de PHP
2. Revisa la configuración de correo
3. Confirma que la base de datos esté correcta
4. Prueba con debug habilitado