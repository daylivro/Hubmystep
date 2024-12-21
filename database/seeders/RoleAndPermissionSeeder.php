<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Enums\RoleEnum;
use App\Models\Permission;
use App\Enums\PermissionEnum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $createUsers = Permission::create(['name' => PermissionEnum::CREATE_USER, 'guard_name' => 'web', 'label' => 'Créer un utilisateur']);
        $updateUsers = Permission::create(['name' => PermissionEnum::UPDATE_USER, 'guard_name' => 'web', 'label' => 'Modifier un utilisateur']);
        $deleteUsers = Permission::create(['name' => PermissionEnum::DELETE_USER, 'guard_name' => 'web', 'label' => 'Supprimer un utilisateur']);
        $viewUsers = Permission::create(['name' => PermissionEnum::VIEW_USER, 'guard_name' => 'web', 'label' => 'Voir un utilisateur']);

        $createRoles = Permission::create(['name' => PermissionEnum::CREATE_ROLE, 'guard_name' => 'web', 'label' => 'Créer un rôle']);
        $updateRoles = Permission::create(['name' => PermissionEnum::UPDATE_ROLE, 'guard_name' => 'web', 'label' => 'Modifier un rôle']);
        $deleteRoles = Permission::create(['name' => PermissionEnum::DELETE_ROLE, 'guard_name' => 'web', 'label' => 'Supprimer un rôle']);
        $viewRoles = Permission::create(['name' => PermissionEnum::VIEW_ROLE, 'guard_name' => 'web', 'label' => 'Voir un rôle']);

        $createPermissions = Permission::create(['name' => PermissionEnum::CREATE_PERMISSION, 'guard_name' => 'web', 'label' => 'Créer une permission']);
        $updatePermissions = Permission::create(['name' => PermissionEnum::UPDATE_PERMISSION, 'guard_name' => 'web', 'label' => 'Modifier une permission']);
        $deletePermissions = Permission::create(['name' => PermissionEnum::DELETE_PERMISSION, 'guard_name' => 'web', 'label' => 'Supprimer une permission']);
        $viewPermissions = Permission::create(['name' => PermissionEnum::VIEW_PERMISSION, 'guard_name' => 'web', 'label' => 'Voir une permission']);

        $createFaqs = Permission::create(['name' => PermissionEnum::CREATE_FAQ, 'guard_name' => 'web', 'label' => 'Créer une FAQ']);
        $updateFaqs = Permission::create(['name' => PermissionEnum::UPDATE_FAQ, 'guard_name' => 'web', 'label' => 'Modifier une FAQ']);
        $deleteFaqs = Permission::create(['name' => PermissionEnum::DELETE_FAQ, 'guard_name' => 'web', 'label' => 'Supprimer une FAQ']);
        $viewFaqs = Permission::create(['name' => PermissionEnum::VIEW_FAQ, 'guard_name' => 'web', 'label' => 'Voir une FAQ']);

        $createPartnerCategories = Permission::create(['name' => PermissionEnum::CREATE_PARTNER_CATEGORY, 'guard_name' => 'web', 'label' => 'Créer une catégorie de partenaire']);
        $updatePartnerCategories = Permission::create(['name' => PermissionEnum::UPDATE_PARTNER_CATEGORY, 'guard_name' => 'web', 'label' => 'Modifier une catégorie de partenaire']);
        $deletePartnerCategories = Permission::create(['name' => PermissionEnum::DELETE_PARTNER_CATEGORY, 'guard_name' => 'web', 'label' => 'Supprimer une catégorie de partenaire']);
        $viewPartnerCategories = Permission::create(['name' => PermissionEnum::VIEW_PARTNER_CATEGORY, 'guard_name' => 'web', 'label' => 'Voir une catégorie de partenaire']);

        $createPartners = Permission::create(['name' => PermissionEnum::CREATE_PARTNER, 'guard_name' => 'web', 'label' => 'Créer un partenaire']);
        $updatePartners = Permission::create(['name' => PermissionEnum::UPDATE_PARTNER, 'guard_name' => 'web', 'label' => 'Modifier un partenaire']);
        $deletePartners = Permission::create(['name' => PermissionEnum::DELETE_PARTNER, 'guard_name' => 'web', 'label' => 'Supprimer un partenaire']);
        $viewPartners = Permission::create(['name' => PermissionEnum::VIEW_PARTNER, 'guard_name' => 'web', 'label' => 'Voir un partenaire']);


        Role::create([
            'name' => RoleEnum::SUPER_ADMIN,
            'guard_name' => 'web',
            'label' => 'Super Admin'
        ])->givePermissionTo(Permission::all());

        Role::create([
            'name' => RoleEnum::ADMIN,
            'guard_name' => 'web',
            'label' => 'Admin'
        ]);

        Role::create([
            'name' => RoleEnum::USER,
            'guard_name' => 'web',
            'label' => 'User'
        ]);
    }
}
