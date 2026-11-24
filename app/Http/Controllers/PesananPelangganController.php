<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananPelangganController extends Controller
{
    private function milikSaya(Pesanan $pesanan): void
    {
        abort_unless($pesanan->pelanggan->user_id === auth()->id(), 403);
    }

    public function index(Request $request)
    {
        $pelanggan = Pelanggan::where('user_id', $request->user()->id)->first();

        $pesanan = Pesanan::with('pembayaran')
            ->where('pelanggan_id', $pelanggan?->id)
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->cari, fn ($q, $c) => $q->where('id', (int) $c))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pesanan.index', compact('pesanan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal_kirim' => 'required|date|after:today',
            'alamat_kirim'  => 'required|string|max:500',
        ]);

        $cart = session('keranjang', []);
        $menus = Menu::whereIn('id', array_keys($cart))->where('status', true)->get();

        if ($menus->isEmpty()) {
            return back()->withErrors(['keranjang' => 'Keranjang masih kosong.']);
        }

        $pelanggan = Pelanggan::firstOrCreate(['user_id' => $request->user()->id]);

        // Harga dan total dihitung di server, bukan dari input form
        $pesanan = DB::transaction(function () use ($data, $cart, $menus, $pelanggan) {
            $pesanan = Pesanan::create([
                'pelanggan_id'  => $pelanggan->id,
                'tanggal_pesan' => now()->toDateString(),
                'tanggal_kirim' => $data['tanggal_kirim'],
                'alamat_kirim'  => $data['alamat_kirim'],
                'total'         => 0,
                'status'        => 'baru',
            ]);

            $total = 0;
            foreach ($menus as $m) {
                $jumlah = (int) $cart[$m->id];
                $subtotal = $m->harga * $jumlah;
                $total += $subtotal;

                $pesanan->detail()->create([
                    'menu_id'  => $m->id,
                    'jumlah'   => $jumlah,
                    'subtotal' => $subtotal,
                ]);
            }

            $pesanan->update(['total' => $total]);
            $pesanan->pembayaran()->create(['metode' => 'transfer', 'status_verifikasi' => 'belum']);

            return $pesanan;
        });

        session()->forget('keranjang');

        return redirect()->route('pesanan.show', $pesanan)
            ->with('sukses', 'Pesanan berhasil dibuat. Silakan unggah bukti pembayaran.');
    }

    public function show(Pesanan $pesanan)
    {
        $this->milikSaya($pesanan);
        $pesanan->load('detail.menu', 'pembayaran');

        return view('pesanan.show', compact('pesanan'));
    }

    public function bayar(Request $request, Pesanan $pesanan)
    {
        $this->milikSaya($pesanan);

        $request->validate(['bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048']);

        $path = $request->file('bukti_bayar')->store('bukti', 'public');
        $pesanan->pembayaran()->update(['bukti_bayar' => $path, 'status_verifikasi' => 'menunggu']);

        return back()->with('sukses', 'Bukti pembayaran terkirim. Menunggu verifikasi admin.');
    }

    public function batal(Pesanan $pesanan)
    {
        $this->milikSaya($pesanan);
        abort_unless($pesanan->status === 'baru', 403);

        $pesanan->update(['status' => 'batal']);

        return back()->with('sukses', 'Pesanan dibatalkan.');
    }
}