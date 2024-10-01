<?php

namespace App\Http\Controllers;

use App\Models\SubPermintaan_Pembelian;
use App\Http\Requests\StoreSubPermintaan_PembelianRequest;
use App\Http\Requests\UpdateSubPermintaan_PembelianRequest;
use App\Models\Anggaran;
use App\Models\Permintaan_Pembelian;
use App\Models\Produk;
use App\Models\SubAnggaran;

class SubPermintaanPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreSubPermintaan_PembelianRequest $request, $id)
    {
        try {
            $permintaan_Pembelian = Permintaan_Pembelian::findOrFail($id);
            $anggaran = $permintaan_Pembelian->anggaran;

            if (!$anggaran) {
                throw new \Exception('Anggaran tidak ditemukan untuk Permintaan Pembelian ini.');
            }

            $validation = $request->validate([
                'sub_anggaran_id' => 'required|exists:sub_anggarans,id',
                'produk_id' => 'required|exists:produks,id',
                'spesifikasi_sub_permintaan_pembelian' => 'required|string',
                'kuantitas_sub_permintaan_pembelian' => 'required|numeric',
                'harga_sub_permintaan_pembelian' => 'required|numeric',
                'keterangan_sub_permintaan_pembelian' => 'nullable|string',
            ]);

            $subAnggaran = SubAnggaran::findOrFail($validation['sub_anggaran_id']);

            if ($subAnggaran->anggaran_id !== $anggaran->id) {
                throw new \Exception('Sub Anggaran tidak sesuai dengan Anggaran Permintaan Pembelian.');
            }

            $validation['permintaanpembelian_id'] = $permintaan_Pembelian->id;
            $validation['total_sub_permintaan_pembelian'] = $validation['kuantitas_sub_permintaan_pembelian'] * $validation['harga_sub_permintaan_pembelian'];

            if ($validation['kuantitas_sub_permintaan_pembelian'] > $subAnggaran->kuantitas_anggaran || $validation['total_sub_permintaan_pembelian'] > $subAnggaran->total_anggaran) {
                throw new \Exception('Kuantitas dan total harga permintaan melebihi kuantitas anggaran yang tersedia.');
            }

            $validation['sub_anggaran_id'] = $subAnggaran->id;
            SubPermintaan_Pembelian::create($validation);
            // Kurangi anggaran
            $subAnggaran->kuantitas_anggaran -= $validation['kuantitas_sub_permintaan_pembelian'];
            $subAnggaran->total_anggaran -= $validation['total_sub_permintaan_pembelian'];
            // Update total anggaran induk
            $subAnggaran->save();


            return redirect()->route('permintaanPembelians.show', $permintaan_Pembelian)->with([
                notyf()->position('y', 'top')->success('Sub Permintaan Pembelian berhasil dibuat dan anggaran diperbarui'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                notyf()->position('y', 'top')->error('Sub Permintaan Pembelian gagal dibuat. ' . $e->getMessage())
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SubPermintaan_Pembelian $subPermintaan_Pembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubPermintaan_Pembelian $subPermintaan_Pembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubPermintaan_PembelianRequest $request, SubPermintaan_Pembelian $subPermintaan_Pembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $subPermintaan_Pembelian = SubPermintaan_Pembelian::findOrFail($id);
            $subPermintaan_Pembelian->delete();
            return redirect()->route('permintaanPembelians.show', $subPermintaan_Pembelian->permintaanPembelian)->with([
                notyf()->position('y', 'top')->success('Sub Permintaan Pembelian berhasil dihapus'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Sub Permintaan Pembelian gagal dihapus. Silakan coba lagi.')]);
        }
    }
}
