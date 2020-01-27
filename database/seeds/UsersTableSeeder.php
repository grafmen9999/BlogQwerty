<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Maxim Koban',
            'email_verified_at' => now(),
            'email' => 'grafmen9999'.'@gmail.com',
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
            'avatar_src' => 'https://place-hold.it/30x30?text=MK'
        ]);

        DB::table('users')->insert([
            'name' => 'Oleg',
            'email_verified_at' => now(),
            'email' => 'oleg'.'@gmail.com',
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
            'avatar_src' => 'https://place-hold.it/30x30?text=Oleg'
        ]);

        DB::table('users')->insert([
            'name' => 'Alex',
            'email_verified_at' => now(),
            'email' => 'alex'.'@gmail.com',
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
            'avatar_src' => 'https://place-hold.it/30x30?text=Alex'
        ]);

        DB::table('users')->insert([
            'name' => 'QwertySoftware',
            'email_verified_at' => now(),
            'email' => 'qwertysoftware'.'@gmail.com',
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
            'avatar_src' => 'https://place-hold.it/30x30?text=QS'
        ]);

        // factory(App\User::class, 50)->create();
    }
}
