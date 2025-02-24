<?php


use Tests\Traits\CreatesProducts;
use Tests\Traits\CreatesUsers;

uses(CreatesProducts::class, CreatesUsers::class);

it('permite a un admin crear un producto', function () {
    $admin = self::actingAsSuperAdmin();
    $product = $this->newProduct();

    $policy = new \App\Policies\ProductPolicy();

    expect($policy->create($admin, $product))->toBeTrue();
});

it('permite a un admin actualizar un producto', function () {
    $admin = self::actingAsSuperAdmin();
    $product = $this->newProduct();

    $policy = new \App\Policies\ProductPolicy();

    expect($policy->update($admin, $product))->toBeTrue();
});

it('permite a un admin eliminar un producto', function () {
    $admin = self::actingAsSuperAdmin();
    $product = $this->newProduct();

    $policy = new \App\Policies\ProductPolicy();

    expect($policy->delete($admin, $product))->toBeTrue();
});
