<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedPermissionsToPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission = \App\Models\Permission::create([
            'name' => 'Manage group',
            'label' => 'group.manage',
        ]);

        $role = \App\Models\Role::where('label', 'user')->first();
        $role->givePermissionTo($permission);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Not implemented...
    }
}
