<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

it('genera correctamente un test de Pest', function () {
    $testName = 'GeneratedTest';
    $testPath = base_path("tests/Feature/{$testName}Test.php");

    File::delete($testPath);

    Artisan::call("make:test-pest", ['name' => $testName]);

    expect(File::exists($testPath))->toBeTrue();

    File::delete($testPath);
});
