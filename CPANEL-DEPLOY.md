# Despliegue en cPanel - Solución Error Vite

## Error: Vite manifest not found

Este error ocurre porque cPanel no tiene Node.js/npm instalado.

## Solución: Compilar localmente y subir

### Paso 1: Compilar en tu máquina local
```bash
cd /ruta/a/tu/proyecto
npm install
npm run build
```

Esto genera la carpeta `public/build/` con:
- `manifest.json`
- `assets/app-*.css`
- `assets/app-*.js`

### Paso 2: Subir archivos compilados a cPanel

Sube la carpeta `public/build/` completa a tu servidor:
```
/home/transfor/renet.com.co/public/build/
├── manifest.json
└── assets/
    ├── app-9qxZD5eI.css
    └── app-CAiCLEjY.js
```

### Paso 3: Verificar permisos
```bash
chmod -R 755 public/build
```

## Archivos que DEBES subir a cPanel

```
✅ public/build/          (compilado localmente)
✅ vendor/                (composer install en servidor)
✅ storage/               (con permisos 755)
✅ .env                   (configurado para producción)
✅ Todos los archivos PHP
```

## Archivos que NO debes subir

```
❌ node_modules/
❌ .git/
❌ .env.example
❌ tests/
❌ storage/logs/*.log
```

## Comandos en cPanel Terminal

```bash
# 1. Ir al directorio
cd /home/transfor/renet.com.co

# 2. Instalar dependencias PHP
composer install --optimize-autoloader --no-dev

# 3. Configurar permisos
chmod -R 755 storage bootstrap/cache
chmod 644 .env

# 4. Generar key (si no existe)
php artisan key:generate

# 5. Ejecutar migraciones
php artisan migrate:fresh --seed
# O visita: https://renet.com.co/install/full

# 6. Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## Configuración .env para Producción

```env
APP_NAME=RENET
APP_ENV=production
APP_DEBUG=false
APP_URL=https://renet.com.co

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=transfor_renet
DB_USERNAME=transfor_renet
DB_PASSWORD=tu_password

SESSION_DRIVER=database
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

APP_LOCALE=es
ALLOW_INSTALL_ROUTES=true
```

## Workflow de Actualización

Cada vez que hagas cambios:

1. **En local:**
   ```bash
   npm run build
   ```

2. **Subir a cPanel:**
   - Archivos PHP modificados
   - Carpeta `public/build/` completa

3. **En cPanel Terminal:**
   ```bash
   php artisan optimize:clear
   php artisan config:cache
   php artisan route:cache
   ```

## Script de Deploy Automático (Opcional)

Crea `deploy.sh` en local:
```bash
#!/bin/bash
echo "Compilando assets..."
npm run build

echo "Subiendo archivos..."
rsync -avz --exclude 'node_modules' --exclude '.git' \
  ./ usuario@renet.com.co:/home/transfor/renet.com.co/

echo "Optimizando en servidor..."
ssh usuario@renet.com.co "cd /home/transfor/renet.com.co && php artisan optimize"

echo "Deploy completado!"
```

## Verificación Post-Deploy

1. Visita: https://renet.com.co
2. Verifica que los estilos carguen correctamente
3. Prueba el login
4. Revisa logs: `storage/logs/laravel.log`

## Solución de Problemas

### Assets no cargan
```bash
# Verifica que exista
ls -la public/build/manifest.json

# Verifica permisos
chmod -R 755 public/build
```

### Error 500
```bash
# Ver logs
tail -f storage/logs/laravel.log

# Limpiar cache
php artisan optimize:clear
```

### Estilos rotos
- Verifica APP_URL en .env
- Asegúrate que public/build/ esté completo
- Recompila: `npm run build`

## Contacto

Para soporte técnico, contactar al administrador.
