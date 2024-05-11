<?php

namespace App\Http\Controllers;


use App\Models\Maraude;
use App\Models\Produit;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class MaraudeProductController extends Controller
{
    public function addProductToMaraude(Request $request, $maraudeId)
    {
        $maraude = Maraude::findOrFail($maraudeId);

        $request->validate([
            'product_id' => 'required|exists:produit,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $data = $request->all();
        $produit = Produit::findOrFail($data['product_id']);
        $warehouse = Warehouse::findOrFail($produit->warehouse_id);

        if ($produit->quantity < $data['quantity']) {
            return response()->json(['message' => 'Quantité insuffisante en stock pour ce produit'], 400);
        }

        if ($warehouse->actual_capacity + $data['quantity'] > $warehouse->max_capacity) {
            return response()->json(['message' => 'La capacité minimale de l\'entrepôt serait dépassée'], 400);
        }

        $produit->quantity -= $data['quantity'];
        $produit->save();

        $prod = new Produit();
        $prod->name = $produit->name;
        $prod->quantity = $data['quantity'];
        $prod->expiration_date = $produit->expiration_date;
        $prod->warehouse_id = $warehouse->id;
        $prod->belongs_to_maraude = true;
        $prod->save();


        $warehouse->actual_capacity += $data['quantity'];
        $warehouse->save();

        $maraude->produits()->attach($produit->id, ['quantity' => $data['quantity']]);

        return response()->json(['message' => 'Produit ajouté à la maraude avec succès'], 201);
    }

    public function showProduits($maraudeId)
{
    $maraude = Maraude::findOrFail($maraudeId);
    $produits = $maraude->produits;

    return response()->json($produits);
}

public function removeProductFromMaraude(Request $request, $maraudeId, $productId)
{
    $maraude = Maraude::findOrFail($maraudeId);
    $produit = Produit::findOrFail($productId);
    $warehouse = Warehouse::findOrFail($produit->warehouse_id);

    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $data = $request->all();

    if ($data['quantity'] > $produit->quantity) {
        return response()->json(['message' => 'Quantité insuffisante en stock pour ce produit'], 400);
    }

    $produit->quantity += $data['quantity'];
    $produit->save();

    $warehouse->actual_capacity -= $data['quantity'];
    $warehouse->save();

    $maraude->produits()->detach($produit->id);

    return response()->json(['message' => 'Produit retiré de la maraude avec succès'], 200);

}

public function GetProductFromMaraude(Request $request, $maraudeId,)
{
    $maraude = Maraude::findOrFail($maraudeId);
    $produits = $maraude->produits;

    return response()->json($produits);
}

}