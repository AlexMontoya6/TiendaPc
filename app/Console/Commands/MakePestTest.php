<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakePestTest extends Command
{
    protected $signature = 'make:test-pest {name}';
    protected $description = 'Create a Pest test with custom stub';

    public function handle()
    {
        $name = $this->argument('name');
        $path = base_path("tests/Feature/{$name}Test.php");

        if (File::exists($path)) {
            $this->error('Test already exists!');
            return 1;
        }

        $stub = File::get(base_path('stubs/test/pest_test.stub'));
        File::put($path, str_replace('{{ class }}', $name, $stub));

        $this->info('Pest test created successfully.');
        return 0;
    }
}
