<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $modules = config('permissions.modules');
        $actions = config('permissions.actions');
    
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::updateOrCreate([
                    'module' => $module,
                    'action' => $action,
                ]);
            }
        }

    }
}
