<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\Satuan;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryProduk = Produk::query();
        $querySatuan = Satuan::query();
        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");
        $perPage = $request->input("perPage", 10);
        $search = $request->input('search', '');
        $lastKodeProduk = Produk::orderBy('kode_produk', 'desc')->first();
        $nextKodeProduk = $lastKodeProduk ? str_pad((int)$lastKodeProduk->kode_produk + 1, 6, '0', STR_PAD_LEFT) : '000001';

        // $searchableColumns = ['kode_produk', 'nama_produk'];
        if ($search) {
            $queryProduk->where("nama_produk", "like", "%" . $search . "%")
                ->orWhere("kode_produk", "like", "%" . $search . "%");
        }

        if ($perPage === 'all') {

            $produks = $queryProduk->orderBy($sortField, $sortDirection)->get();
        } else {
            $perPage = (int) $perPage;

            $satuans = $querySatuan->orderBy($sortField, $sortDirection)->get();
            $produks = $queryProduk->orderBy($sortField, $sortDirection)
                ->paginate($perPage)
                ->onEachSide(1);
        }

        return view('pages.produk.index', compact('produks', 'satuans', 'sortField', 'sortDirection', 'perPage', 'nextKodeProduk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdukRequest $request)
    {
        try {
            $validation = $request->validate([
                'nama_produk' => 'required',
                'harga_produk' => 'required|numeric|gt:0',
                'satuan_id' => 'required|exists:satuans,id'
            ]);
            $lastKodeProduk = Produk::orderBy('kode_produk', 'desc')->first();
            $nextKodeProduk = $lastKodeProduk ? str_pad((int)$lastKodeProduk->kode_produk + 1, 6, '0', STR_PAD_LEFT) : '000001';

            // Add the next kode_produk to the validated data
            $validation['kode_produk'] = $nextKodeProduk;
            // dd($validation);
            Produk::create($validation);

            return redirect()->route('products.index')->with([
                notyf()->position('y', 'top')->success('Produk berhasil dibuat'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Produk gagal dibuat. Silakan coba lagi.')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdukRequest $request, $id)
    {
        try {
            $produk = Produk::findOrFail($id);
            $validation = $request->validate([
                'nama_produk' => 'required',
                'harga_produk' => 'required|numeric|gt:0',
                'satuan_id' => 'required|exists:satuans,id'
            ]);
            $produk->update($validation);

            return redirect()->route('products.index')->with([
                notyf()->position('y', 'top')->success('Produk berhasil diupdate'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Produk gagal diupdate. Silakan coba lagi.')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $produk = Produk::findOrFail($id);
            $produk->delete();
            return redirect()->route('products.index')->with([
                notyf()->position('y', 'top')->success('Produk berhasil di hapus'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Produk gagal di hapus. Silakan coba lagi.')]);
        }
    }
}
