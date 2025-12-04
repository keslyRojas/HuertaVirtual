<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\InventoryItem;
use App\Models\UserInventory;
use App\Models\InventoryItemCategory;

class AuthenticationController extends Controller
{

    public function showRegister()
    {
        return view('authentication.register');
    }


    public function register(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'username' => 'required|min:3',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ], [
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.min'      => 'El nombre debe tener al menos 3 caracteres.',
            'email.required'    => 'El correo es obligatorio.',
            'email.email'       => 'Debe ingresar un correo válido.',
            'email.unique'      => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $user = User::create([
            'name'     => $validated['username'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        for ($i = 1; $i <= 2; $i++) {
            \App\Models\GardenPlot::create([
                'user_id'     => $user->id,
                'plot_number' => $i,
                'status'      => 'E'
            ]);
        }

        $seedCategory = InventoryItemCategory::where('name', 'Improved & Special Seeds')->first();

        if ($seedCategory) {

            // Buscar el primer item de esa categoría
            $seedItem = InventoryItem::where('inventory_item_category_id', $seedCategory->id)->first();

            if ($seedItem) {
                UserInventory::create([
                    'user_id'            => $user->id,
                    'inventory_item_id'  => $seedItem->id,
                    'quantity'           => 2, // semillas iniciales
                ]);
            }
        }

        return redirect('/login')->with('success', 'Cuenta creada con éxito. Ahora iniciá sesión.');
    }


    public function login(Request $request)
    {
        if (!$request->email || !$request->password) {
            return redirect('/login')->with('error', 'Completa todos los campos.');
        }

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();
            return redirect('/game');
        }

        return redirect('/login')->with('error', 'Correo o contraseña incorrectos.');
    }


    public function showLogin()
    {
        return view('authentication.login');
    }

}
