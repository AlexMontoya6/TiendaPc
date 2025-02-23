<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class PublicController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/public/products",
     *     summary="Obtener todos los productos disponibles",
     *     description="Este endpoint devuelve una lista de todos los productos disponibles en la tienda, ordenados por ID descendente para mostrar los más recientes primero.",
     *     tags={"Productos Públicos"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Lista de productos obtenida correctamente",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *
     *                 @OA\Items(
     *                     type="object",
     *
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Laptop Gamer"),
     *                     @OA\Property(property="price", type="number", format="float", example="1499.99"),
     *                     @OA\Property(property="description", type="string", example="Laptop con RTX 3070 y 32GB RAM"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-23T12:34:56Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function allProducts()
    {
        return response()->json([
            'success' => true,
            'data' => Product::query()->withoutTrashed()->orderBy('id', 'desc')->get(),
        ]);
    }
}
