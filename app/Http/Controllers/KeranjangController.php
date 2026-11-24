<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $cart = session('keranjang', []);

        $items = Menu::whereIn('id', array_keys($cart))->get()->map(function ($m) use ($cart) {
            $m->qty = $cart[$m->id];
            $m->subtotal = $m->harga * $m->qty;
            return $m;
        });

        return view('keranjang', ['items' => $items, 'total' => $items->sum('subtotal')]);
    }

    public function tambah(Menu $menu)
    {
        $cart = session('keranjang', []);
        $cart[$menu->id] = ($cart[$menu->id] ?? 0) + 1;
        session(['keranjang' => $cart]);

        return back()->with('sukses', $menu->nama_menu . ' ditambahkan ke keranjang.');
    }

    public function ubah(Request $request, Menu $menu)
    {
        $request->validate(['jumlah' => 'required|integer|min:1|max:1000']);

        $cart = session('keranjang', []);
        if (isset($cart[$menu->id])) {
            $cart[$menu->id] = (int) $request->jumlah;
            session(['keranjang' => $cart]);
        }

        return back();
    }

    public function hapus(Menu $menu)
    {
        $cart = session('keranjang', []);
        unset($cart[$menu->id]);
        session(['keranjang' => $cart]);

        return back();
    }
}