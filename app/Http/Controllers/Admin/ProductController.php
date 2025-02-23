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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
