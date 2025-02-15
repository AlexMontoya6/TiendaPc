<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Obtener una lista de productos",
     *     tags={"Productos"},
     *     @OA\Response(
     *         response=200,
     *         description="Una lista de productos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="name", type="string", example="Laptop"),
     *                 @OA\Property(property="description", type="string", example="Un portátil de alto rendimiento"),
     *                 @OA\Property(property="price", type="number", format="float", example=999.99),
     *                 @OA\Property(property="stock", type="integer", example=10),
     *                 @OA\Property(property="image_url", type="string", example="http://example.com/images/laptop.jpg")
     *             )
     *         )
     *     )
     * )
     */
    public function getProducts()
    {
        $products = Product::all()->makeHidden(['id', 'product_type_id', 'category_id', 'subcategory_id', 'created_at', 'updated_at']);
        return response()->json($products);
    }

    /**
     * @OA\Get(
     *     path="/api/products-with-categories",
     *     summary="Obtener una lista de productos con sus categorías",
     *     tags={"Productos"},
     *     @OA\Response(
     *         response=200,
     *         description="Una lista de productos con sus categorías",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="name", type="string", example="Laptop"),
     *                 @OA\Property(property="slug", type="string", example="laptop"),
     *                 @OA\Property(property="description", type="string", example="Un portátil de alto rendimiento"),
     *                 @OA\Property(property="price", type="number", format="float", example=999.99),
     *                 @OA\Property(property="product_type", type="object",
     *                     @OA\Property(property="name", type="string", example="Electrónica")
     *                 ),
     *                 @OA\Property(property="category", type="object",
     *                     @OA\Property(property="name", type="string", example="Computadoras")
     *                 ),
     *                 @OA\Property(property="subcategory", type="object",
     *                     @OA\Property(property="name", type="string", example="Portátiles")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getProductsWithCategories()
    {
        $products = Product::with(['productType', 'category', 'subcategory'])->get();

        $formattedProducts = $products->map(function ($product) {
            return [
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'price' => $product->price,
                'product_type' => [
                    'name' => $product->productType->name,
                ],
                'category' => $product->category ? [
                    'name' => $product->category->name,
                ] : null,
                'subcategory' => $product->subcategory ? [
                    'name' => $product->subcategory->name,
                ] : null,
            ];
        });

        return response()->json($formattedProducts);
    }
}
