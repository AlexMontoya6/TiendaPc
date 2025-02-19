<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Subcategory;
use Illuminate\Support\Str;

class ProductController extends Controller
{
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
    public function store(Request $request)
    {
        // 🔹 1. Validación de los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:100', // Precio en céntimos
            'product_type_id' => 'required|exists:product_types,id',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Cada imagen debe ser válida
        ]);

       // dd($validated);



        // 🔹 2. Crear el producto en la base de datos
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'], // Precio en céntimos
            'product_type_id' => $validated['product_type_id'],
            'category_id' => $validated['category_id'] ?? null,
            'subcategory_id' => $validated['subcategory_id'] ?? null,
        ]);

        //dd($product);

        // if ($request->hasFile('images')) {
        //     dd($request->file('images')); // 🔍 Verificar si los archivos están presentes
        // }

        // 🔹 3. Subir y asociar imágenes (si existen)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public'); // Guarda en storage/app/public/products

                //dd($path);

                Image::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'order' => $index + 1, // Orden secuencial de imágenes
                ]);
            }
        }

        // 🔹 4. Redireccionar con mensaje de éxito
        return redirect()->route('admin.products.index')->with('success', 'Producto creado correctamente.');
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
