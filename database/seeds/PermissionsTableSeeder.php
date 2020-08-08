<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permission list
        Permission::create(['name' => 'productos.index']);
        Permission::create(['name' => 'productos.edit']);
        Permission::create(['name' => 'productos.show']);
        Permission::create(['name' => 'productos.create']);
        Permission::create(['name' => 'productos.destroy']);
        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.show']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.destroy']);

        //Admin
        $admin = Role::create(['name' => 'Admin']);

        $admin->givePermissionTo([
            'productos.index',
            'productos.edit',
            'productos.show',
            'productos.create',
            'productos.destroy',
            'users.index',
            'users.edit',
            'users.show',
            'users.create',
            'users.destroy'
        ]);
        //$admin->givePermissionTo('products.index');
        //$admin->givePermissionTo(Permission::all());

        //Guest
        $guest = Role::create(['name' => 'Guest']);

        $guest->givePermissionTo([
            'productos.index',
            'productos.show'
        ]);

        $prueba= Role::create(['name' => 'prueba']);

        $prueba->givePermissionTo([
            'productos.index',
            'productos.show',
            'productos.destroy'
        ]);


        //User Admin
        $user = User::find(1); //yo
        $user->assignRole('Admin');

        $user = User::find(2); //otro
        $user->assignRole('prueba');
    }

}
