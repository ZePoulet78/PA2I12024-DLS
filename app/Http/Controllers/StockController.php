<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Warehouse;
use Carbon\Carbon;

class StockController extends Controller
{
    public function addProductToWarehouse(Request $request, $warehouseId)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'expiration_date' => 'required|date_format:Y-m-d',
        ]);

        $data = $request->all();

        if ($warehouse->actual_capacity - $data['quantity'] < 0) {
            return response()->json(['message' => 'La capacité maximale de l\'entrepôt serait dépassée'], 400);
        }

        $prod = new Produit();
        $prod->name = $data['name'];
        $prod->quantity = $data['quantity'];
        $prod->expiration_date = $data['expiration_date'];
        $prod->warehouse_id = $warehouseId;
        $prod->belongs_to_maraude = 1;
        $prod->save();

        $warehouse->actual_capacity -= $data['quantity'];
        $warehouse->save();

        return response()->json(['message' => 'Produit ajouté avec succès', 'data' => $prod], 201);
    }

    public function removeProductFromWarehouse(Request $request, $productId)
    {
        $prod = Produit::findOrFail($productId);
        $warehouse = Warehouse::findOrFail($prod->warehouse_id);

        if($warehouse->actual_capacity + $prod->quantity > $warehouse->max_capacity) {
            return response()->json(['message' => 'La capacité minimale de l\'entrepôt serait dépassée'], 400);
        }

        $warehouse->actual_capacity += $prod->quantity;
        $warehouse->save();

        $prod->delete();

        return response()->json(['message' => 'Produit supprimé avec succès'], 200);
    }

    public function indexP()
    {
        $prod = Produit::where('belongs_to_maraude', true)->get();
        if (!$prod) {
            return response()->json(['message' => 'Aucun produit trouvé'], 404);
        }
        return response()->json(['prod' => $prod]);
    }

    public function indexProdStock()
    {
        $prod = Produit::where('belongs_to_maraude', false)->get();
        if (!$prod) {
            return response()->json(['message' => 'Aucun produit trouvé'], 404);
        }
        return response()->json(['prod' => $prod]);
    }

    public function showP($id)
    {
        $prod = Produit::find($id);
        if (!$prod) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }
        return response()->json(['prod' => $prod]);
    }

    public function addQuantityToStock(Request $request, $id_produit)
    {
        $prod = Produit::find($id_produit);
        if (!$prod) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        $warehouse = Warehouse::findOrFail($prod->warehouse_id);

        $this->validate($request, [
            'quantity' => 'required|integer',
        ]);

        $data = $request->all();



        if ($warehouse->actual_capacity - $data['quantity'] < 0) {
            return response()->json(['message' => 'La capacité maximale de l\'entrepôt serait dépassée'], 400);
        }

        $warehouse->actual_capacity = $warehouse->actual_capacity - $data['quantity'];
        $warehouse->save();

        $prod->fill([
            'quantity' => $data['quantity'] + $prod->quantity,
            'warehouse_id' => $prod->warehouse_id,
        ]);
        $prod->save();

        return response()->json(['message' => 'Produit modifié avec succès', 'data' => $prod], 200);
    }

    public function RemoveQuantityFromStock(Request $request, $id_produit)
    {
        $prod = Produit::find($id_produit);
        if (!$prod) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        $warehouse = Warehouse::findOrFail($prod->warehouse_id);

        $this->validate($request, [
            'quantity' => 'required|integer',

        ]);

        $data = $request->all();



        if ($warehouse->actual_capacity + $data['quantity'] > $warehouse->max_capacity) {
            return response()->json(['message' => 'La capacité minimal de l\'entrepôt serait dépassée'], 400);
        }

        $warehouse->actual_capacity = $warehouse->actual_capacity + $data['quantity'];
        $warehouse->save();

        $prod->fill([
            'quantity' => $data['quantity'] - $prod->quantity,
            'warehouse_id' => $prod->warehouse_id,
        ]);
        $prod->save();

        return response()->json(['message' => 'Produit modifié avec succès', 'data' => $prod], 200);
    }

    public function destroyP(Request $request, $id)
    {
        $prod = Produit::find($id);
        if (!$prod) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        $warehouse = Warehouse::findOrFail($prod->warehouse_id);
        $warehouse->actual_capacity -= $prod->quantity;
        $warehouse->save();

        $prod->delete();

        return response()->json(['message' => 'Produit supprimé avec succès'], 200);
    }
}