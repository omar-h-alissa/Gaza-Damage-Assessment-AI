<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{

    public function run(Generator $faker): void
    {

        $user = User::create([
            'name'              => $faker->name,
            'national_id'             => '2323323',
            'phone'             => '+9705692496',
            'address'             => '',
            'family_members'             => 21,
            'password'          => Hash::make('demo'),
        ]) ;

        $user->assignRole('super_admin');


    }
}
