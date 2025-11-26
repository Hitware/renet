# Medidas de Seguridad Implementadas

## 1. Protección contra Hackeo de Cuentas

### Rate Limiting en Login
- **Límite**: 5 intentos por minuto por IP/email
- **Implementación**: Laravel Fortify con RateLimiter
- **Ubicación**: `app/Providers/FortifyServiceProvider.php`

### Autenticación Segura
- **Laravel Sanctum**: Tokens de autenticación seguros
- **Session Management**: Gestión segura de sesiones con Jetstream
- **Password Hashing**: Bcrypt para contraseñas

## 2. Protección contra Ataques DDoS

### Rate Limiting Global
- **Rutas Públicas**: 10 peticiones/minuto
  - `/verificar`
  - `/qr`
  - `/reportes` (POST)
- **Rutas Autenticadas**: 60 peticiones/minuto
- **API**: Throttle nativo de Laravel

### Implementación
```php
Route::middleware('throttle:10,1')->group(function () {
    // Rutas públicas limitadas
});

Route::middleware('throttle:60,1')->group(function () {
    // Rutas autenticadas limitadas
});
```

## 3. Protección contra Archivos Maliciosos

### Validación de Archivos
- **Tipos Permitidos**: PDF, JPG, JPEG, PNG
- **Tamaño Máximo**: 10MB
- **Validación MIME Type**: Verificación real del tipo de archivo
- **Validación de Extensión**: Doble verificación

### Middleware ValidateFileUpload
```php
// app/Http/Middleware/ValidateFileUpload.php
- Valida MIME types
- Valida tamaño de archivo
- Valida extensiones
```

### Validación en Livewire
```php
'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240'
```

## 4. Headers de Seguridad HTTP

### SecurityHeaders Middleware
- **X-Frame-Options**: SAMEORIGIN (previene clickjacking)
- **X-Content-Type-Options**: nosniff (previene MIME sniffing)
- **X-XSS-Protection**: 1; mode=block (protección XSS)
- **Referrer-Policy**: strict-origin-when-cross-origin
- **Permissions-Policy**: Deshabilita geolocalización, micrófono, cámara

### Content Security Policy (CSP)
- **Paquete**: spatie/laravel-csp
- **Configuración**: `config/csp.php`
- **Protección**: XSS, inyección de scripts maliciosos

## 5. Protección contra Robo de Información

### Encriptación de IDs
- **Método**: Laravel encrypt()
- **Uso**: Todas las URLs de embarcaciones
- **Beneficio**: IDs no predecibles ni secuenciales

### Sanitización de Inputs
- **strip_tags()**: Elimina HTML/scripts
- **Regex Validation**: Patrones estrictos
- **Type Casting**: Conversión segura de tipos

### Control de Acceso
- **Middleware auth**: Autenticación requerida
- **Role-based**: Verificación de roles (admin, empresa, inspector)
- **Ownership Check**: Validación de propiedad de recursos

## 6. Protección CSRF

### Laravel CSRF Protection
- **Tokens CSRF**: Automáticos en todos los formularios
- **Livewire**: Protección CSRF integrada
- **Validación**: Automática en cada petición POST/PUT/DELETE

## 7. Validación y Sanitización

### Inputs de Usuario
```php
// Matrícula
'matricula' => 'required|regex:/^[A-Z0-9\-]+$/'

// Nombre
'nombre' => 'required|regex:/^[a-zA-Z0-9\s\-\.]+$/'

// Sanitización
strip_tags(trim($input))
strtoupper($matricula)
```

### SQL Injection Prevention
- **Eloquent ORM**: Queries parametrizadas
- **Prepared Statements**: Automáticas
- **No Raw Queries**: Sin consultas SQL directas

## 8. Logging y Auditoría

### Audit Trail
- **Tabla**: `historial_documentos`
- **Registra**: Cambios, usuario, IP, timestamp
- **Soft Deletes**: Recuperación de datos eliminados

### Reportes Anónimos
- **IP Tracking**: Registro de IP en reportes
- **Rate Limiting**: Prevención de spam

## Paquetes de Seguridad Instalados

1. **spatie/laravel-csp** (v3.21)
   - Content Security Policy
   - Protección XSS

2. **intervention/image** (v3.11)
   - Validación de imágenes
   - Procesamiento seguro

3. **Laravel Sanctum** (incluido)
   - Autenticación API
   - Tokens seguros

4. **Laravel Fortify** (incluido)
   - Rate limiting login
   - Gestión de autenticación

## Configuración Recomendada

### .env
```env
# Seguridad
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

# CSP
CSP_ENABLED=true
CSP_NONCE_ENABLED=true

# Rate Limiting
THROTTLE_LOGIN=5
THROTTLE_API=60
```

### Servidor Web
- HTTPS obligatorio en producción
- Certificado SSL válido
- HTTP/2 habilitado

## Mantenimiento

### Actualizaciones
```bash
composer update --with-dependencies
php artisan optimize:clear
```

### Monitoreo
- Revisar logs regularmente: `storage/logs/laravel.log`
- Monitorear intentos de login fallidos
- Revisar reportes de CSP violations

## Contacto de Seguridad

Para reportar vulnerabilidades de seguridad, contactar al administrador del sistema.
