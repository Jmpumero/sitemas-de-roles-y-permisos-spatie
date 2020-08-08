<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name'      => 'Jose Medina',
            'email'     => 'jmpumero@gmail.com',
            'password'     => bcrypt('123'),

        ]);

        App\User::create([
            'name'      => 'Jhon Doe',
            'email'     => 'josejmedina@ghotmail.com',
            'password'     => bcrypt('123'),

        ]);


        factory(User::class,18)->create();
    }
}
