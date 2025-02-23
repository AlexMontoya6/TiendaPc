<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

it('elimina imágenes en test/', function () {

    $imageName = uniqid().'.jpg';
    $imagePath = 'test/'.$imageName;

    Storage::disk('public')->put($imagePath, file_get_contents('https://picsum.photos/640/480'));

    expect(Storage::disk('public')->exists($imagePath))->toBeTrue();

    Artisan::call('images:clear test');

    expect(Storage::disk('public')->exists($imagePath))->toBeFalse();
});

it('muestra mensaje si el directorio no existe', function () {

    Storage::fake('public');

    Storage::disk('public')->deleteDirectory('test');

    expect(Storage::disk('public')->exists('test'))->toBeFalse();

    Artisan::call('images:clear test');

    expect(Artisan::output())->toContain('El directorio /storage/app/public/test no existe.');
});
