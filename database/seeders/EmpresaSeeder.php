<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresas = [
            [
                'nit' => '900123456-1',
                'razon_social' => 'Transportes Marítimos del Caribe S.A.S.',
                'nombre_comercial' => 'TransCaribe',
                'direccion' => 'Muelle La Bodeguita, Cartagena de Indias',
                'telefono' => '+57 5 6601234',
                'email' => 'info@transcaribe.com',
                'representante_legal' => 'Carlos Alberto Gómez',
                'documento_representante' => '73123456',
                'estado' => 'activa',
                'fecha_autorizacion_dimar' => '2023-01-15',
                'numero_autorizacion_dimar' => 'DIMAR-2023-001',
            ],
            [
                'nit' => '900234567-2',
                'razon_social' => 'Naviera Islas del Rosario Ltda',
                'nombre_comercial' => 'Naviera Islas',
                'direccion' => 'Muelle Turístico, Bocagrande, Cartagena',
                'telefono' => '+57 5 6602345',
                'email' => 'contacto@navieraislas.com',
                'representante_legal' => 'María Fernanda Martínez',
                'documento_representante' => '39234567',
                'estado' => 'activa',
                'fecha_autorizacion_dimar' => '2022-11-20',
                'numero_autorizacion_dimar' => 'DIMAR-2022-089',
            ],
            [
                'nit' => '900345678-3',
                'razon_social' => 'Lanchas Turísticas Cartagena S.A.',
                'nombre_comercial' => 'Lanchas Turísticas',
                'direccion' => 'Terminal Marítimo, Centro Histórico, Cartagena',
                'telefono' => '+57 5 6603456',
                'email' => 'ventas@lanchastour.com',
                'representante_legal' => 'Jorge Luis Rodríguez',
                'documento_representante' => '8345678',
                'estado' => 'activa',
                'fecha_autorizacion_dimar' => '2023-03-10',
                'numero_autorizacion_dimar' => 'DIMAR-2023-025',
            ],
            [
                'nit' => '900456789-4',
                'razon_social' => 'Embarcaciones Turísticas del Norte S.A.S.',
                'nombre_comercial' => 'TurNorte',
                'direccion' => 'Manga, Cartagena de Indias',
                'telefono' => '+57 5 6604567',
                'email' => 'info@turnorte.com.co',
                'representante_legal' => 'Ana Patricia Suárez',
                'documento_representante' => '45456789',
                'estado' => 'suspendida',
                'fecha_autorizacion_dimar' => '2021-06-05',
                'numero_autorizacion_dimar' => 'DIMAR-2021-054',
                'observaciones' => 'Suspendida por falta de actualización documental',
            ],
            [
                'nit' => '900567890-5',
                'razon_social' => 'Transporte Acuático de Pasajeros E.U.',
                'nombre_comercial' => 'TransAcua',
                'direccion' => 'Pie de la Popa, Cartagena',
                'telefono' => '+57 5 6605678',
                'email' => 'gerencia@transacua.com',
                'representante_legal' => 'Luis Eduardo Castro',
                'documento_representante' => '73567890',
                'estado' => 'activa',
                'fecha_autorizacion_dimar' => '2023-05-22',
                'numero_autorizacion_dimar' => 'DIMAR-2023-047',
            ],
        ];

        foreach ($empresas as $empresa) {
            Empresa::create($empresa);
        }
    }
}
