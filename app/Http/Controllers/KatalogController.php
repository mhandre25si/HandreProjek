<?php

namespace App\Http\Controllers;

use App\Models\KategoriMenu;
use App\Models\Menu;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $menu = Menu::with('kategori')
            ->where('status', true)
            ->when($request->q, fn ($q) => $q->where('nama_menu', 'like', "%{$request->q}%"))
            ->when($request->kategori, fn ($q) => $q->where('kategori_id', $request->kategori))
            ->paginate(9)
            ->withQueryString();

        return view('katalog', [
            'menu' => $menu,
            'kategori' => KategoriMenu::all(),
        ]);
    }
}