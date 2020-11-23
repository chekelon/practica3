<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('users')->insert([
            'name'=>'Ezequiel',
            'email'=>'chekelon@gmail.com',
            'email_verified_at' => now(),
            'password'=>Hash::make('password'),
            'TipoUser'=>'admin',
        ]);
        $user=factory(App\User::class,10)->create();
    }
}
