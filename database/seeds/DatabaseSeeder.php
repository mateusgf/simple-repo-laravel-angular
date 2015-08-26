<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

        /**
         * Install OAuth 2 clients table with
         * client_id: 1
         * secret: secret
         * name: client1
         */
        Schema::table('oauth_clients', function(Blueprint $table){
            $sql = "insert into oauth_clients(id, secret, name, created_at, updated_at) values (1, 'secret', 'client1', NOW(), NOW())";
            DB::connection()->getPdo()->exec($sql);
        });


        factory(\App\User::class, 1)->create([
            'name' => 'Mateus Gomes',
            'email' => 'mateusgff@gmail.com',
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10)
        ]);

        $user = \App\User::find(1);
        $user->applications()->attach([1, 2, 3]);

        factory(\App\Application::class, 3)->create()->each(function($application) {
            $application->versions()->save(factory(\App\ApplicationVersion::class)->make());
        });




        // $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}
