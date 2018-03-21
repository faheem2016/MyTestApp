<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Spatie\Permission\Models\Role::firstOrcreate(['name' => 'admin', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Role::firstOrcreate(['name' => 'user', 'guard_name' => 'web']);
        $this->call(PermissionsTableSeeder::class);

        $admin = \App\User::firstOrCreate(['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('12345')]);
        $admin->assignRole('admin');
        $admin->givePermissionTo('view-file', 'upload-file', 'delete-file', 'download-file');


    }
}
