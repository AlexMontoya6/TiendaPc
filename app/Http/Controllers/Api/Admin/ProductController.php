<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Listar todos los productos",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Lista de productos obtenida correctamente")
     * )
     */
    public function index()
    {
        $products = Product::all()->makeHidden(['id', 'product_type_id', 'category_id', 'subcategory_id', 'created_at', 'updated_at']);
        return response()->json($products);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Obtener un producto por su ID",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID del producto"),
     *     @OA\Response(response=200, description="Producto obtenido"),
     *     @OA\Response(response=404, description="Producto no encontrado")
     * )
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * @OA\Post(
     *   path="/api/products",
     *   summary="Crear un nuevo producto",
     *   tags={"Productos"},
     *   security={{"bearerAuth":{}}},
     *   @OA\RequestBody(
     *       required=true,
     *       description="Datos para crear un producto",
     *       @OA\JsonContent(
     *         required={"name","price","category_id"},
     *         @OA\Property(property="name", type="string", example="Producto X"),
     *         @OA\Property(property="price", type="number", format="float", example="99.99"),
     *         @OA\Property(property="description", type="string", example="Una descripción opcional"),
     *         @OA\Property(property="category_id", type="integer", example=1)
     *       )
     *   ),
     *   @OA\Response(response=201, description="Producto creado con éxito"),
     *   @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'product_type_id' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
        ]);

        $product = Product::create($request->all());

        return response()->json($product, 201);
    }


/**
     * @OA\Put(
     *   path="/api/products/{id}",
     *   summary="Actualizar un producto existente",
     *   tags={"Productos"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(name="id", in="path", required=true, description="ID del producto",
     *                 @OA\Schema(type="integer")),
     *   @OA\RequestBody(
     *       required=true,
     *       description="Datos para actualizar el producto",
     *       @OA\JsonContent(
     *         @OA\Property(property="name", type="string", example="Producto Modificado"),
     *         @OA\Property(property="price", type="number", format="float", example="149.99"),
     *         @OA\Property(property="description", type="string", example="Nueva descripción"),
     *         @OA\Property(property="category_id", type="integer", example=2)
     *       )
     *   ),
     *   @OA\Response(response=200, description="Producto actualizado"),
     *   @OA\Response(response=404, description="Producto no encontrado"),
     *   @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'product_type_id' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
        ]);

        $product->update($request->all());

        return response()->json($product);
    }


    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Eliminar un producto",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID del producto"),
     *     @OA\Response(response=200, description="Producto eliminado correctamente"),
     *     @OA\Response(response=404, description="Producto no encontrado")
     * )
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 200);
    }


}
