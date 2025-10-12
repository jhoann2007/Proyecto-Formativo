<?php
return [
    // Configuración SMTP
    'smtp' => [
        'host' => 'smtp.gmail.com',  // Servidor SMTP de Gmail
        'port' => 587,               // Puerto para TLS
        'encryption' => 'tls',       // Tipo de encriptación (tls o ssl)
        'auth' => true,              // Habilitar autenticación SMTP
    ],
    
    // Credenciales de correo
    'credentials' => [
        'username' => 'gymtechemails@gmail.com',            // Tu correo de Gmail (ej: tucorreo@gmail.com)
        'password' => 'vljd czpd kpdt qurq',            // Tu contraseña de aplicación de Gmail
    ],
    
    // Configuración del remitente
    'from' => [
        'address' => 'gymtechemails@gmail.com',             // Correo del remitente (mismo que username)
        'name' => 'GymTech - Sistema de Recuperación',  // Nombre del remitente
    ],
    
    // Configuración de correos de recuperación
    'recovery' => [
        'subject' => 'Código de Recuperación de Contraseña - GymTech',
        'expiry_minutes' => 15,      // Tiempo de expiración del código en minutos
        'code_length' => 6,          // Longitud del código de verificación
    ],
    
    // Configuración de debug (solo para desarrollo)
    'debug' => [
        'enabled' => false,          // Cambiar a true para habilitar debug
        'level' => 2,               // Nivel de debug (0=off, 1=client, 2=server)
    ]
];
?>