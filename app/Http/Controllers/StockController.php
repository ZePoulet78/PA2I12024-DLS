<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use Carbon\Carbon;

class StockController extends Controller
{
    public function addProduct(Request $request){

        $this->validate($request,[
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'expiration_date' => 'required|date_format:d/m/Y',
        ]);

        $data = $request->all();

        $expiration_date = Carbon::createFromFormat('d/m/Y', $data['expiration_date'])->format('Y-m-d');
        
        $prod = new Produit();
        $prod->name = $data['name'];
        $prod->quantity = $data['quantity'];
        $prod->expiration_date =  $expiration_date ;//$data['expiration_date'];
        
        $prod->save();
        
        return response()->json(['message' => 'product add successfully', 'data' => $prod], 201);
    }

    public function indexP()
    {
        $prod = Produit::all();

        if (!$prod) {
            return response()->json(['message' => 'product not found'], 404);
        }

        return response()->json(['prod' => $prod]);
    }

    public function showP($id)
    {
        $prod = Produit::find($id);

        if (!$prod) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json(['prod' => $prod]);
    }

    public function updateP(Request $request, $id){

        $new = Produit::find($id);

        if(!$new){
            return response()->json(['message' => 'Product not found', 404]);
        }

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'expiration_date' => 'required|date_format:d/m/Y',
        ]);

        $data = $request->all();

        $expiration_date = Carbon::createFromFormat('d/m/Y', $data['expiration_date'])->format('Y-m-d');
    
        $new->fill([
            'name' => $data['name'],
            'quantity' => $data['quantity'],
            'expiration_date' => $expiration_date,
        ]);
        
        $new->save();
    
        return response()->json(['message' => 'Product modified successfully', 'data' => $data], 201);

    }

    public function destroyP(Request $request, $id)
    {
        $prod = Produit::find($id);

        if (!$prod) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $prod->delete();

        return response()->json(['message' => 'Product deleted successfully'], 201);
    }



}
