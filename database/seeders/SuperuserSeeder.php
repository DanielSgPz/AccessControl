<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Superuser;

class SuperuserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Super',
            'last_name' => 'User',
            'email' => 'aurora@mail.com',
            'password' => bcrypt('rino2024'),
            'role'=>'SU'
        ]);

        Superuser::create([
            'user_id' => $user->id,
        ]);
    }
}
