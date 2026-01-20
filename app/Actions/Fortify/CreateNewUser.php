<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Empresa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'tipo_documento' => ['required', 'string', 'in:CC,CE,PAS,NIT'],
            'documento' => ['required', 'string', 'max:50', 'unique:users,documento'],
            'telefono' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'role' => ['sometimes', 'string', 'in:publico,empresa,inspector,admin'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            $empresa = Empresa::create([
                'nit' => $input['documento'],
                'razon_social' => $input['name'],
                'direccion' => 'Por definir',
                'telefono' => $input['telefono'],
                'email' => $input['email'],
                'representante_legal' => $input['name'],
                'documento_representante' => $input['documento'],
                'estado' => 'activa',
            ]);

            return User::create([
                'name' => $input['name'],
                'tipo_documento' => $input['tipo_documento'],
                'documento' => $input['documento'],
                'telefono' => $input['telefono'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'role' => 'empresa',
                'empresa_id' => $empresa->id,
            ]);
        });
    }
}
