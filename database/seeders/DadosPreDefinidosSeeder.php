<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DadosPreDefinidosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Adm',
            'email' => 'admin@gmail.com',
        ]);
        $role = Role::create(['name' => 'superadmin']);
        $user->syncRoles($role);
        $roleNormal = Role::create(['name' => 'normal']);
        $permissions = [
            'view supports',
            'create supports',
            'edit supports',
            'delete supports',
            'view replies',
            'create replies',
            'edit replies',
            'delete replies',
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'view users',
            'edit users',
        ];

        foreach ($permissions as $permission) {
            $SavePermission = Permission::create(['name' => $permission]);
        }
        //Permissões do bibliotecario
        $PermissionsNormal = [
            'view supports',
            'create supports',
            'edit supports',
            'delete supports',
            'view replies',
            'create replies',
            'edit replies',
            'delete replies'
        ];

        ///Associa algumas permissões ao perfil de bibilhotecario
        foreach ($PermissionsNormal as  $p) {
            $roleNormal->givePermissionTo($p);
        }
    }
}
