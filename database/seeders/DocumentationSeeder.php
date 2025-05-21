<?php

namespace Database\Seeders;

use App\Models\Documentation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Documentation::create([
        'title' => 'Admin Create Documentation',
        'module_key' => 'admin',
        'type' => 'create',
        'documentation' => 'Documentation Contents',
       ]);
       Documentation::create([
        'title' => 'Admin Update Documentation',
        'module_key' => 'admin',
        'type' => 'update',
        'documentation' => 'Documentation Contents',
       ]);
       Documentation::create([
        'title' => 'Permission Create Documentation',
        'module_key' => 'permission',
        'type' => 'create',
        'documentation' => 'Documentation Contents',
       ]);
       Documentation::create([
        'title' => 'Permission Update Documentation',
        'module_key' => 'permission',
        'type' => 'update',
        'documentation' => 'Documentation Contents',
       ]);
       Documentation::create([
        'title' => 'Role Create Documentation',
        'module_key' => 'role',
        'type' => 'create',
        'documentation' => 'Documentation Contents',
       ]);
       Documentation::create([
        'title' => 'Role Update Documentation',
        'module_key' => 'role',
        'type' => 'update',
        'documentation' => 'Documentation Contents',
       ]);
       Documentation::create([
        'title' => 'User Create Documentation',
        'module_key' => 'user',
        'type' => 'create',
        'documentation' => 'Documentation Contents',
       ]);
       Documentation::create([
        'title' => 'User Update Documentation',
        'module_key' => 'user',
        'type' => 'update',
        'documentation' => 'Documentation Contents',
       ]);
       Documentation::create([
        'title' => 'Supplier Create Documentation',
        'module_key' => 'supplier',
        'type' => 'create',
        'documentation' => 'Documentation Contents',
       ]);
       Documentation::create([
        'title' => 'Supplier Update Documentation',
        'module_key' => 'supplier',
        'type' => 'update',
        'documentation' => 'Documentation Contents',
       ]);
    }
}
