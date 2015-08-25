<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment() === 'production') {
            exit('Wow! Stop it!');
        }

        Model::unguard();

        factory(\App\User::class, 1)->create([
            'name' => 'Mateus Gomes',
            'email' => 'mateusgff@gmail.com',
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10)
        ])->each(function($user) {
            $user->applications()->save(factory(\App\Application::class)->make());
        });

        //factory(\App\Application::class, 3)->create();

        // $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}
