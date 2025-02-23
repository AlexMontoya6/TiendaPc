<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Listar productos eliminados y activos",
     *     description="Este endpoint devuelve todos los productos, incluyendo los eliminados lógicamente (SoftDeletes).",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Response(response=200, description="Lista de productos obtenida correctamente"),
     * )
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Product::withTrashed()->orderBy('id', 'desc')->get(), // 🔥 Incluye los eliminados
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Eliminar un producto (SoftDelete)",
     *     description="Este endpoint marca un producto como eliminado sin borrarlo permanentemente.",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(name="id", in="path", required=true, description="ID del producto a eliminar"),
     *
     *     @OA\Response(response=200, description="Producto eliminado correctamente"),
     *     @OA\Response(response=404, description="Producto no encontrado"),
     * )
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Producto eliminado correctamente.'], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/products/{id}/restore",
     *     summary="Restaurar un producto eliminado",
     *     description="Este endpoint permite restaurar un producto que ha sido eliminado mediante SoftDelete.",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(name="id", in="path", required=true, description="ID del producto a restaurar"),
     *
     *     @OA\Response(response=200, description="Producto restaurado correctamente"),
     *     @OA\Response(response=404, description="Producto no encontrado"),
     * )
     */
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return response()->json(['message' => 'Producto restaurado correctamente.'], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}/force-delete",
     *     summary="Eliminar permanentemente un producto",
     *     description="Este endpoint elimina un producto de la base de datos de manera irreversible.",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(name="id", in="path", required=true, description="ID del producto a eliminar definitivamente"),
     *
     *     @OA\Response(response=200, description="Producto eliminado permanentemente"),
     *     @OA\Response(response=404, description="Producto no encontrado"),
     * )
     */
    public function forceDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->forceDelete();

        return response()->json(['message' => 'Producto eliminado permanentemente.'], 200);
    }
}
