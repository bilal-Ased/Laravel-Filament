<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ShieldSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_customer","view_any_customer","create_customer","update_customer","restore_customer","restore_any_customer","replicate_customer","reorder_customer","delete_customer","delete_any_customer","force_delete_customer","force_delete_any_customer","view_issue::category","view_any_issue::category","create_issue::category","update_issue::category","restore_issue::category","restore_any_issue::category","replicate_issue::category","reorder_issue::category","delete_issue::category","delete_any_issue::category","force_delete_issue::category","force_delete_any_issue::category","view_issue::sources","view_any_issue::sources","create_issue::sources","update_issue::sources","restore_issue::sources","restore_any_issue::sources","replicate_issue::sources","reorder_issue::sources","delete_issue::sources","delete_any_issue::sources","force_delete_issue::sources","force_delete_any_issue::sources","view_lead::source","view_any_lead::source","create_lead::source","update_lead::source","restore_lead::source","restore_any_lead::source","replicate_lead::source","reorder_lead::source","delete_lead::source","delete_any_lead::source","force_delete_lead::source","force_delete_any_lead::source","view_lead::stage","view_any_lead::stage","create_lead::stage","update_lead::stage","restore_lead::stage","restore_any_lead::stage","replicate_lead::stage","reorder_lead::stage","delete_lead::stage","delete_any_lead::stage","force_delete_lead::stage","force_delete_any_lead::stage","view_leads","view_any_leads","create_leads","update_leads","restore_leads","restore_any_leads","replicate_leads","reorder_leads","delete_leads","delete_any_leads","force_delete_leads","force_delete_any_leads","view_products","view_any_products","create_products","update_products","restore_products","restore_any_products","replicate_products","reorder_products","delete_products","delete_any_products","force_delete_products","force_delete_any_products","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_ticket","view_any_ticket","create_ticket","update_ticket","restore_ticket","restore_any_ticket","replicate_ticket","reorder_ticket","delete_ticket","delete_any_ticket","force_delete_ticket","force_delete_any_ticket","view_ticket::statuses","view_any_ticket::statuses","create_ticket::statuses","update_ticket::statuses","restore_ticket::statuses","restore_any_ticket::statuses","replicate_ticket::statuses","reorder_ticket::statuses","delete_ticket::statuses","delete_any_ticket::statuses","force_delete_ticket::statuses","force_delete_any_ticket::statuses","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","widget_StatsOverview","view_activity","view_any_activity","create_activity","update_activity","restore_activity","restore_any_activity","replicate_activity","reorder_activity","delete_activity","delete_any_activity","force_delete_activity","force_delete_any_activity","page_MyProfile","widget_TaskChart"]},{"name":"filament_user","guard_name":"web","permissions":[]},{"name":"Agent","guard_name":"web","permissions":["view_customer","view_any_customer","create_customer","update_customer","view_leads","view_any_leads","create_leads","update_leads","view_products","view_any_products","create_products","update_products","view_ticket","view_any_ticket","create_ticket","update_ticket","view_user","view_any_user","create_user","update_user"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions,true))) {

            foreach ($rolePlusPermissions as $rolePlusPermission) {

                $role = Role::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name']
                ]);

                if (! blank($rolePlusPermission['permissions'])) {

                    $role->givePermissionTo($rolePlusPermission['permissions']);

                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions,true))) {

            foreach($permissions as $permission) {

                if (Permission::whereName($permission)->doesntExist()) {
                    Permission::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
