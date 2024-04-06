<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class defaultAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(
            [
                'role' => 0,
                'firstname' => 'Donnesh',
                'lastname' => 'YATHAVARASAN',
                'email' => 'vdonnesh@gmail.com',
                'password' => Hash::make('Respons11'),
                'tel' => '0699770780'
            ]
        );
    }
}
