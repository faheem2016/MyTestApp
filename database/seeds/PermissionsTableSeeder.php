<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'upload-file']);
        \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'download-file']);
        \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'delete-file']);
        \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'view-file']);
    }
}
