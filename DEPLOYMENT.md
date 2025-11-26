# Guía de Despliegue en cPanel

## Problema: Error de Virus al Subir ZIP

El error "Sanesecurity.Foxhole.Zip_fn31.UNOFFICIAL FOUND" es un **falso positivo** común en cPanel.

## Soluciones:

### Opción 1: Subir sin comprimir (Recomendado)
1. Usa **File Manager** de cPanel
2. Sube los archivos directamente sin comprimir
3. O usa FTP/SFTP (FileZilla)

### Opción 2: Excluir directorios del ZIP
Crea el ZIP excluyendo estas carpetas:
```bash
zip -r proyecto.zip . -x "node_modules/*" "vendor/*" ".git/*" "storage/logs/*" "storage/framework/cache/*"
```

### Opción 3: Usar Git Deploy
1. En cPanel, ve a **Git Version Control**
2. Clona tu repositorio
3. Ejecuta `composer install` desde Terminal

### Opción 4: Subir por partes
1. Sube primero los archivos de configuración
2. Luego sube `app/`, `config/`, `routes/`, etc.
3. Finalmente ejecuta `composer install` en Terminal

## Pasos de Instalación en cPanel

### 1. Preparar el Servidor
```bash
# En Terminal de cPanel
cd public_html
```

### 2. Subir Archivos
- Sube todos los archivos EXCEPTO `vendor/` y `node_modules/`
- Mueve el contenido de `public/` a `public_html/`
- Los demás archivos van un nivel arriba

### 3. Configurar .env
```bash
cp .env.example .env
nano .env
```

Configurar:
```env
APP_NAME=RENET
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tudominio.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=tu_base_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

APP_LOCALE=es
```

### 4. Instalar Dependencias
```bash
composer install --optimize-autoloader --no-dev
```

### 5. Generar Key
```bash
php artisan key:generate
```

### 6. Configurar Permisos
```bash
chmod -R 755 storage bootstrap/cache
```

### 7. Ejecutar Migraciones
Visita: `https://tudominio.com/install/full`

O desde Terminal:
```bash
php artisan migrate:fresh --seed
```

### 8. Optimizar para Producción
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Estructura de Directorios en cPanel

```
/home/usuario/
├── public_html/              # Contenido de /public
│   ├── index.php
│   ├── .htaccess
│   └── assets/
├── renet/                    # Resto de la aplicación
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   └── .env
```

## Modificar index.php

Edita `public_html/index.php`:
```php
require __DIR__.'/../renet/vendor/autoload.php';
$app = require_once __DIR__.'/../renet/bootstrap/app.php';
```

## Solución de Problemas

### Error 500
- Verifica permisos de `storage/` y `bootstrap/cache/`
- Revisa logs en `storage/logs/laravel.log`

### Error de Base de Datos
- Verifica credenciales en `.env`
- Asegúrate que el usuario tenga permisos

### Rutas no funcionan
- Verifica que `.htaccess` esté en `public_html/`
- Activa `mod_rewrite` en cPanel

### Sesiones no funcionan
- Ejecuta: `php artisan session:table`
- Luego: `php artisan migrate`

## Seguridad Post-Instalación

1. **Deshabilitar rutas de instalación:**
```env
ALLOW_INSTALL_ROUTES=false
```

2. **Verificar permisos:**
```bash
chmod 644 .env
chmod -R 755 storage
```

3. **Configurar SSL:**
- Activa SSL en cPanel
- Fuerza HTTPS en `.htaccess`

4. **Backup automático:**
- Configura backups en cPanel
- Exporta base de datos regularmente

## Comandos Útiles

```bash
# Limpiar cache
php artisan optimize:clear

# Ver logs
tail -f storage/logs/laravel.log

# Verificar configuración
php artisan config:show

# Crear usuario admin manualmente
php artisan tinker
>>> User::create(['name'=>'Admin','email'=>'admin@renet.com','password'=>bcrypt('password'),'role'=>'admin'])
```

## Contacto Soporte

Para problemas de despliegue, contactar al administrador del sistema.
