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
        'title' => 'Documentation Title 1',
        'module_key' => 'Module Key 1',
        'type' => 'create',
        'documentation' => 'Documentation Content',
       ]);
       Documentation::create([
        'title' => 'Documentation Title',
        'module_key' => 'Module Key ',
        'type' => 'create',
        'documentation' => 'Documentation Content',
       ]);
       Documentation::create([
        'title' => 'Documentation Title 2',
        'module_key' => 'Module Key 2',
        'type' => 'create',
        'documentation' => 'Documentation Content',
       ]);
       Documentation::create([
        'title' => 'Documentation Title 3',
        'module_key' => 'Module Key 3',
        'type' => 'create',
        'documentation' => 'Documentation Content',
       ]);
       Documentation::create([
        'title' => 'Documentation Title 4',
        'module_key' => 'Module Key 4',
        'type' => 'create',
        'documentation' => 'Documentation Content',
       ]);
    }
}
