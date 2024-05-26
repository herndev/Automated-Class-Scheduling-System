<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $superadmin_permissions = Permission::all();
        $sadmin_permissions = $superadmin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 6) != 'admin_' && substr($permission->title, 0, 5) != 'user_';
        });
        Role::findOrFail(1)->permissions()->sync($sadmin_permissions);
        $admin_permissions = $superadmin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_' && substr($permission->title, 0, 6) != 'super_' && substr($permission->title, 0, 5) != 'user_';
        });
        Role::findOrFail(2)->permissions()->sync($admin_permissions);
        $user_permissions = $superadmin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_' && substr($permission->title, 0, 6) != 'super_' && substr($permission->title, 0, 6) != 'admin_';
        });
        Role::findOrFail(3)->permissions()->sync($user_permissions);
    }
}
