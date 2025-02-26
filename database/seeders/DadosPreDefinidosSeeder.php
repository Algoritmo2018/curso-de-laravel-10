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
        $roleApi = Role::create(['name' => 'superadmin', 'guard_name' => 'api']);
        $user->syncRoles($role->name);
        $user->syncRoles($roleApi->name);
        $roleNormal = Role::create(['name' => 'normal']);
        Role::create(['name' => 'normal api', 'guard_name' => 'api']);
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
        $permissionsApi = [
            'view supports api',
            'create supports api',
            'edit supports api',
            'delete supports api',
            'view replies api',
            'create replies api',
            'edit replies api',
            'delete replies api',
            'view permissions api',
            'create permissions api',
            'edit permissions api',
            'delete permissions api',
            'view roles api',
            'create roles api',
            'edit roles api',
            'delete roles api',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        foreach ($permissionsApi as $permissionApi) {
            Permission::create(['name' => $permissionApi, 'guard_name' => 'api']);
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
