<?php

namespace Database\Seeders;

use App\Models\Embarcacion;
use App\Models\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmbarcacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresas = Empresa::all();

        if ($empresas->isEmpty()) {
            $this->command->warn('No hay empresas creadas. Por favor ejecuta el EmpresaSeeder primero.');
            return;
        }

        $embarcaciones = [
            [
                'empresa_id' => 1, // TransCaribe
                'matricula' => 'CTG-2023-001',
                'nombre' => 'Estrella del Caribe',
                'tipo' => 'motonave_pasaje',
                'capacidad_pasajeros' => 50,
                'eslora' => 12.50,
                'manga' => 3.80,
                'tonelaje' => 8.50,
                'ano_construccion' => 2020,
                'material_casco' => 'Fibra de vidrio',
                'motor_marca' => 'Yamaha',
                'motor_modelo' => '250 HP',
                'motor_potencia' => 250,
                'estado' => 'disponible',
                'ultima_verificacion' => now()->subDays(10),
            ],
            [
                'empresa_id' => 1, // TransCaribe
                'matricula' => 'CTG-2023-002',
                'nombre' => 'Brisa Marina',
                'tipo' => 'motonave_pasaje',
                'capacidad_pasajeros' => 45,
                'eslora' => 11.00,
                'manga' => 3.50,
                'tonelaje' => 7.00,
                'ano_construccion' => 2019,
                'material_casco' => 'Fibra de vidrio',
                'motor_marca' => 'Suzuki',
                'motor_modelo' => '200 HP',
                'motor_potencia' => 200,
                'estado' => 'disponible',
                'ultima_verificacion' => now()->subDays(5),
            ],
            [
                'empresa_id' => 2, // Naviera Islas
                'matricula' => 'CTG-2022-045',
                'nombre' => 'Isla Bonita',
                'tipo' => 'motonave_pasaje',
                'capacidad_pasajeros' => 60,
                'eslora' => 14.00,
                'manga' => 4.20,
                'tonelaje' => 10.00,
                'ano_construccion' => 2021,
                'material_casco' => 'Fibra de vidrio reforzada',
                'motor_marca' => 'Honda',
                'motor_modelo' => '300 HP',
                'motor_potencia' => 300,
                'estado' => 'disponible',
                'ultima_verificacion' => now()->subDays(2),
            ],
            [
                'empresa_id' => 2, // Naviera Islas
                'matricula' => 'CTG-2022-046',
                'nombre' => 'Rosario Express',
                'tipo' => 'motonave_pasaje',
                'capacidad_pasajeros' => 55,
                'eslora' => 13.50,
                'manga' => 4.00,
                'tonelaje' => 9.50,
                'ano_construccion' => 2022,
                'material_casco' => 'Fibra de vidrio',
                'motor_marca' => 'Yamaha',
                'motor_modelo' => '280 HP',
                'motor_potencia' => 280,
                'estado' => 'mantenimiento',
                'observaciones' => 'Mantenimiento preventivo del motor programado',
                'ultima_verificacion' => now()->subDays(30),
            ],
            [
                'empresa_id' => 3, // Lanchas Turísticas
                'matricula' => 'CTG-2023-120',
                'nombre' => 'Turista I',
                'tipo' => 'motonave_pasaje',
                'capacidad_pasajeros' => 40,
                'eslora' => 10.50,
                'manga' => 3.20,
                'tonelaje' => 6.50,
                'ano_construccion' => 2023,
                'material_casco' => 'Fibra de vidrio',
                'motor_marca' => 'Mercury',
                'motor_modelo' => '180 HP',
                'motor_potencia' => 180,
                'estado' => 'disponible',
                'ultima_verificacion' => now()->subDays(1),
            ],
            [
                'empresa_id' => 3, // Lanchas Turísticas
                'matricula' => 'CTG-2023-121',
                'nombre' => 'Turista II',
                'tipo' => 'motonave_pasaje',
                'capacidad_pasajeros' => 40,
                'eslora' => 10.50,
                'manga' => 3.20,
                'tonelaje' => 6.50,
                'ano_construccion' => 2023,
                'material_casco' => 'Fibra de vidrio',
                'motor_marca' => 'Mercury',
                'motor_modelo' => '180 HP',
                'motor_potencia' => 180,
                'estado' => 'disponible',
                'ultima_verificacion' => now()->subDays(1),
            ],
            [
                'empresa_id' => 4, // TurNorte (suspendida)
                'matricula' => 'CTG-2021-078',
                'nombre' => 'Norte Star',
                'tipo' => 'motonave_pasaje',
                'capacidad_pasajeros' => 35,
                'eslora' => 9.80,
                'manga' => 3.00,
                'tonelaje' => 5.50,
                'ano_construccion' => 2018,
                'material_casco' => 'Madera reforzada',
                'motor_marca' => 'Yamaha',
                'motor_modelo' => '150 HP',
                'motor_potencia' => 150,
                'estado' => 'suspendida',
                'observaciones' => 'Empresa suspendida - documentación vencida',
                'ultima_verificacion' => now()->subDays(180),
            ],
            [
                'empresa_id' => 5, // TransAcua
                'matricula' => 'CTG-2023-200',
                'nombre' => 'Acua Express',
                'tipo' => 'motonave_pasaje',
                'capacidad_pasajeros' => 48,
                'eslora' => 11.80,
                'manga' => 3.60,
                'tonelaje' => 7.80,
                'ano_construccion' => 2022,
                'material_casco' => 'Fibra de vidrio',
                'motor_marca' => 'Suzuki',
                'motor_modelo' => '220 HP',
                'motor_potencia' => 220,
                'estado' => 'disponible',
                'ultima_verificacion' => now()->subDays(7),
            ],
        ];

        foreach ($embarcaciones as $embarcacion) {
            $embarcacionModel = Embarcacion::create($embarcacion);
            // Generar código QR automáticamente
            $embarcacionModel->generateQrCode();
        }
    }
}
