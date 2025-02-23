<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Subcategory;
use Illuminate\Support\Str;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;
    /**
     * Muestra la lista de productos con todas sus imágenes.
     */
    public function index()
    {
        return view('admin.products.index');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $this->authorize('create', Product::class);

        try {
            // 🔍 Depuración antes de guardar

            $product = Product::create($request->validated());

            // Subir imágenes si existen
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');

                    Image::create([
                        'product_id' => $product->id,
                        'path' => $path,
                        'order' => $index + 1,
                    ]);
                }
            }

            // **Asignar etiquetas al producto**
            if (!empty($request->tags)) {
                $tags = collect($request->tags)->mapWithKeys(function ($tag) {
                    return [$tag['id'] => ['is_active' => $tag['is_active'], 'ttl' => $tag['ttl']]];
                });

                $product->tags()->sync($tags);
            }

            return redirect()->route('admin.products.index')->with('success', 'Producto creado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'Error al crear el producto: ' . $e->getMessage());
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // 🔥 Cargamos las relaciones necesarias
        $product->load([
            'productType',
            'category',
            'subcategory',
            'tags' => function ($query) {
                $query->withPivot('is_active', 'ttl'); // Cargar datos del pivot (activas y TTL)
            }
        ]);

        // 🔥 Devuelve la vista con el producto
        return view('admin.products.edit', compact('product'));
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(ProductStoreRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        try {
            // Actualizar datos del producto
            $product->update($request->validated());

            // Subir imágenes si existen
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');

                    Image::create([
                        'product_id' => $product->id,
                        'path' => $path,
                        'order' => $index + 1,
                    ]);
                }
            }

            // **Actualizar etiquetas**
            if (!empty($request->tags)) {
                $tags = collect($request->tags)->mapWithKeys(function ($tag) {
                    return [$tag['id'] => ['is_active' => $tag['is_active'], 'ttl' => $tag['ttl']]];
                });

                $product->tags()->sync($tags);
            } else {
                $product->tags()->detach(); // 🔥 Si no hay etiquetas, eliminamos todas
            }

            return redirect()->route('admin.products.index')->with('success', 'Producto actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'Error al actualizar el producto: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        try {
            $product->delete();

            return redirect()->route('admin.products.index')->with('success', 'Producto eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $this->authorize('restore', $product);

        $product->restore();

        return redirect()->route('admin.products.index')->with('success', 'Producto restaurado correctamente.');
    }

    public function forceDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $product);

        $product->forceDelete();

        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado permanentemente.');
    }
}
