<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Augusto Carvalho',
            'phone' => 69658908,
            'profile' => 'Admin',
            'status' => 'Active',
            'email' => 'auguss24@gmail.com',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('Admin');

        $manager = User::create([
            'name' => 'Agustín Chinchilla espindola',
            'phone' => 72839535,
            'profile' => 'Manager',
            'status' => 'Active',
            'email' => 'chinchillaespindola2019@gmail.com',
            'password' => Hash::make('password')
        ]);

        $manager->assignRole('Manager');

        $manager = User::create([
            'name' => 'Mariana ELba',
            'phone' => 76885027,
            'profile' => 'Reg. Documentos',
            'status' => 'Active',
            'email' => 'mary@gmail.com',
            'password' => Hash::make('password')
        ]);

        $manager->assignRole('Reg. Documentos');
    }
}
