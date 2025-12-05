<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InventoryItem;
use App\Models\UserInventory;
use App\Models\Wallet;

class MarketController extends Controller
{
    public function index()
    {
       $items = InventoryItem::whereHas('category', function($q) {
        $q->whereIn('name', ['Seeds', 'Fertilizer', 'Products']);
    })->get();

    $wallet = Wallet::firstOrCreate(['user_id' => Auth::id()]);

    return view('market.market', compact('items', 'wallet'));
    }

    public function buy(Request $request)
    {
        $user = Auth::user();
        $item = InventoryItem::find($request->item_id);

        if (!$item) return response()->json(['error' => 'Item no encontrado.'], 404);

        if (!in_array($item->category->name, ['Seeds', 'Fertilizer'])) {
            return response()->json(['error' => 'No puedes comprar este item.'], 403);
        }

        $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);
        if ($wallet->balance < $item->price) {
            return response()->json(['error' => 'No tienes suficientes monedas.'], 403);
        }

        $wallet->balance -= $item->price;
        $wallet->save();

        //Incrementa la cantidad en inventario
        $inventory = UserInventory::firstOrCreate(
            ['user_id' => $user->id, 'inventory_item_id' => $item->id],
            ['quantity' => 0]
        );
        $inventory->increment('quantity');

        return response()->json(['message' => 'Has comprado ' . $item->name, 'newBalance' => $wallet->balance]);
    }

    public function sell(Request $request)
    {
        $user = Auth::user();
        $item = InventoryItem::find($request->item_id);

        if (!$item) return response()->json(['error' => 'Item no encontrado.'], 404);

        if ($item->category->name !== 'Products') {
            return response()->json(['error' => 'No puedes vender este item.'], 403);
        }

        $inventory = UserInventory::where('user_id', $user->id)
        ->where('inventory_item_id', $item->id)
        ->first();

        if (!$inventory || $inventory->quantity < 1) {
            return response()->json(['error' => 'No tienes suficientes productos para vender.'], 403);
        }

        //Resta 1 al inventario
        $inventory->decrement('quantity');

        $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);
        $wallet->balance += $item->price;
        $wallet->save();

        return response()->json(['message' => 'Has vendido ' . $item->name, 'newBalance' => $wallet->balance]);
    }
}