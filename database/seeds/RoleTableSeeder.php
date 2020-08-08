<?php

use App\Http\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->nombre_rol='admin';
        $role->descripcion="Administrador";
        $role->save();

        $role = new Role();
        $role->nombre_rol='user';
        $role->descripcion="Usuario Normal";
        $role->save();
    }
}
