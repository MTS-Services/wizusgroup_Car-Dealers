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

    }
}
