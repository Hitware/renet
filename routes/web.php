<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('embarcaciones')->name('embarcaciones.')->group(function () {
        Route::get('/', App\Livewire\Embarcaciones\Index::class)->name('index');
        Route::get('/crear', App\Livewire\Embarcaciones\Form::class)->name('create');
        Route::get('/{embarcacion}', App\Livewire\Embarcaciones\Show::class)->name('show');
        Route::get('/{embarcacion}/editar', App\Livewire\Embarcaciones\Form::class)->name('edit');
        Route::get('/{embarcacion}/documentos', App\Livewire\Documentos\Manage::class)->name('documentos');
        Route::get('/{embarcacion}/documentos-inspector', App\Livewire\Documentos\InspectorView::class)->name('documentos.inspector');
        Route::get('/{embarcacion}/historial', App\Livewire\Documentos\History::class)->name('historial');
        Route::get('/{embarcacion}/carnet', [App\Http\Controllers\VerificacionController::class, 'descargarCarnet'])->name('carnet');
    });
});

Route::get('/verificar/{codigo?}', [App\Http\Controllers\VerificacionController::class, 'verificar'])->name('verificar');
Route::get('/qr/{codigo}', [App\Http\Controllers\VerificacionController::class, 'generarQR'])->name('qr.generar');
Route::post('/reportes', [App\Http\Controllers\ReporteController::class, 'store'])->name('reportes.store');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/reportes', App\Livewire\Reportes\Index::class)->name('reportes.index');
});

// Rutas de instalación (solo para desarrollo/producción inicial)
if (env('APP_ENV') !== 'production' || env('ALLOW_INSTALL_ROUTES', false)) {
    Route::get('/install/migrate', function () {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh');
        return 'Migraciones ejecutadas correctamente. <a href="/install/seed">Ejecutar seeders</a>';
    });

    Route::get('/install/seed', function () {
        \Illuminate\Support\Facades\Artisan::call('db:seed');
        return 'Seeders ejecutados correctamente. <a href="/login">Ir al login</a>';
    });

    Route::get('/install/full', function () {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh --seed');
        return 'Instalación completa ejecutada. <a href="/login">Ir al login</a>';
    });
}
