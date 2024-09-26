<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaksi::query();
        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");
        $perPage = $request->input("perPage", 10);
        $perStatus = $request->input("perStatus", 'all');
        $search = $request->input('search', '');
        $lastKodeTransaksi = Transaksi::orderBy('kode_transaksi', 'desc')->first();
        $nextKodeTransaksi = $lastKodeTransaksi ? str_pad((int)$lastKodeTransaksi->kode_transaksi + 1, 8, '0', STR_PAD_LEFT) : '00000001';

        // $searchableColumns = ['kode_transaksi', 'nama_transaksi'];
        if ($search) {
            $query->where("nama_transaksi", "like", "%" . $search . "%")
                ->orWhere("kode_transaksi", "like", "%" . $search . "%");
        }

        if ($perStatus !== 'all') {
            $query->where('status_transaksi', $perStatus);
        }

        if ($perPage === 'all') {

            $transaksis = $query->orderBy($sortField, $sortDirection)->get();
        } else {
            $perPage = (int) $perPage;

            $transaksis = $query->orderBy($sortField, $sortDirection)
                ->paginate($perPage)
                ->onEachSide(1);
        }

        return view('pages.transaksi.index', compact('transaksis', 'sortField', 'sortDirection', 'perPage', 'perStatus', 'nextKodeTransaksi'));
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
    public function store(StoreTransaksiRequest $request)
    {
        try {
            $validation = $request->validate([
                'nama_transaksi' => 'required',
            ]);
            $lastKodeTransaksi = Transaksi::orderBy('kode_transaksi', 'desc')->first();
            $nextKodeTransaksi = $lastKodeTransaksi ? str_pad((int)$lastKodeTransaksi->kode_transaksi + 1, 8, '0', STR_PAD_LEFT) : '00000001';

            // Add the next kode_transaksi to the validated data
            $validation['kode_transaksi'] = $nextKodeTransaksi;
            // dd($validation);
            Transaksi::create($validation);

            return redirect()->route('transaksis.index')->with([
                notyf()->position('y', 'top')->success('Transaksi berhasil dibuat'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Transaksi gagal dibuat. Silakan coba lagi.')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaksiRequest $request, $id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);
            $validation = $request->validate([
                'nama_transaksi' => 'required',
            ]);
            $transaksi->update($validation);

            return redirect()->route('transaksis.index')->with([
                notyf()->position('y', 'top')->success('Transaksi berhasil diupdate'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Transaksi gagal diupdate. Silakan coba lagi.')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->delete();
            return redirect()->route('transaksis.index')->with([
                notyf()->position('y', 'top')->success('Transaksi berhasil di hapus'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Transaksi gagal di hapus. Silakan coba lagi.')]);
        }
    }
}
