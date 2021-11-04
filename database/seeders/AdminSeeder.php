<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\map;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'superadmin@adaremit.co.id',
            'password' => Hash::make('Medan1010'),
            'user_hp' => '082284395802',
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'gender' => 'male',
            'place_birth' => 'Medan',
            'date_birth' => '2000-11-08',
            'address' => 'Medan',
            'zip' => '20371',
            'citizen' => 'medan',
            'id_card_type' => 'KTP',
            'id_card_num' => '1241242141114',
            'type_user' => 3,
        ]);
        User::create([
            'email' => 'admin@adaremit.co.id',
            'password' => Hash::make('Medan1010'),
            'user_hp' => '082284395811',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'gender' => 'male',
            'place_birth' => 'Medan',
            'date_birth' => '2000-11-08',
            'address' => 'Medan',
            'zip' => '20371',
            'citizen' => 'medan',
            'id_card_type' => 'KTP',
            'id_card_num' => '124124214142223',
            'type_user' => 4,
        ]);
    }
}
