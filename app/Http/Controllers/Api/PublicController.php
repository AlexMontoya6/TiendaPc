<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/public/products",
     *     summary="Obtener productos con filtros, búsqueda y paginación",
     *     tags={"Productos Públicos"},
     *
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Filtrar por categoría",
     *         required=false,
     *
     *         @OA\Schema(type="string", example="Laptops")
     *     ),
     *
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Buscar productos por nombre",
     *         required=false,
     *
     *         @OA\Schema(type="string", example="MacBook")
     *     ),
     *
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número de página para paginación",
     *         required=false,
     *
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Lista de productos obtenida correctamente"
     *     )
     * )
     */
    public function allProducts(Request $request)
    {
        $query = Product::query()->withoutTrashed();

        // 🔍 Filtrar por categoría
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // 🔎 Buscar por nombre
        if ($request->has('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        // 📜 Paginación
        $products = $query->orderBy('id', 'desc')->paginate(10);

        return ProductResource::collection($products);
    }
}
