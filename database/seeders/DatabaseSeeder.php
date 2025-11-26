<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed empresas first
        $this->call([
            EmpresaSeeder::class,
            EmbarcacionSeeder::class,
        ]);

        // Create test users with different roles

        // Admin user
        User::create([
            'name' => 'Admin RENET',
            'email' => 'admin@renet.gov.co',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'empresa_id' => null,
        ]);

        // Inspector user
        User::create([
            'name' => 'Inspector DIMAR',
            'email' => 'inspector@dimar.gov.co',
            'password' => Hash::make('password'),
            'role' => 'inspector',
            'empresa_id' => null,
        ]);

        // Empresa user (TransCaribe)
        User::create([
            'name' => 'Carlos Alberto Gómez',
            'email' => 'carlos.gomez@transcaribe.com',
            'password' => Hash::make('password'),
            'role' => 'empresa',
            'empresa_id' => 1, // TransCaribe
        ]);

        // Empresa user (Naviera Islas)
        User::create([
            'name' => 'María Fernanda Martínez',
            'email' => 'maria.martinez@navieraislas.com',
            'password' => Hash::make('password'),
            'role' => 'empresa',
            'empresa_id' => 2, // Naviera Islas
        ]);

        // Public user
        User::create([
            'name' => 'Usuario Público',
            'email' => 'publico@example.com',
            'password' => Hash::make('password'),
            'role' => 'publico',
            'empresa_id' => null,
        ]);
    }
}
