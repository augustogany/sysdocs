<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();   
        
        $arrayOfPermissionNames = [
            'browse-categorias','categorias.index', 'categorias.edit','categorias.show',
            'categorias.create','categorias.destroy','browse-documentos','documentos.index',
            'documentos.edit','documentos.show','documentos.create','documentos.destroy','documentos.ver-archivo',
            'browse-users','users.index','users.edit','users.show','users.create','users.destroy',
            'browse-roles','roles.index','roles.edit','roles.show','roles.create','roles.destroy',
            'browse-permissions','permissions.index','permissions.edit','permissions.show','permissions.create',
            'permissions.destroy','browse-asignaciones','asignar-permisos-roles'
        ];
        
        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });
    
        Permission::insert($permissions->toArray());    

        $rolesa = Role::create(['name' => 'admin']);
        $rolesa->givePermissionTo(Permission::all());

        //Manager
        $manager = Role::create(['name' => 'Manager'])
                        ->givePermissionTo(
                            [
                            'browse-categorias','categorias.index', 'categorias.edit','categorias.show',
                            'categorias.create','categorias.destroy','browse-documentos','documentos.index',
                            'documentos.edit','documentos.show','documentos.create','documentos.destroy','documentos.ver-archivo',
                            'browse-users','users.index','users.edit','users.show','users.create','users.destroy',
                            'browse-roles','roles.index','roles.edit','roles.show','roles.create','roles.destroy',
                            'browse-asignaciones','asignar-permisos-roles'
                            ]);
        //Reg Documentos
        $document = Role::create(['name' => 'Reg. Documentos'])
                        ->givePermissionTo(
                            [
                                'browse-categorias','categorias.index', 'categorias.edit','categorias.show',
                                'categorias.create','categorias.destroy','browse-documentos','documentos.index',
                                'documentos.edit','documentos.show','documentos.create','documentos.destroy','documentos.ver-archivo'
                            ]);
    }
}
