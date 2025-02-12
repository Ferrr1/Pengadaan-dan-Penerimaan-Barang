<?php

namespace App\Http\Controllers;

use App\Models\SubAnggaran;
use App\Http\Requests\StoreSubAnggaranRequest;
use App\Http\Requests\UpdateSubAnggaranRequest;
use App\Models\Anggaran;
use App\Models\Kel_Anggaran;
use App\Models\Satuan;
use Illuminate\Http\Request;

class SubAnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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
    public function store(StoreSubAnggaranRequest $request, Anggaran $anggaran)
    {
        try {
            $kel_anggaran = Kel_Anggaran::where('id', $request->input('kel_anggaran'))->firstOrFail();
            $validation = $request->validate([
                'no_detail' => 'required',
                'produk_id' => 'required|exists:produks,id',
                'kuantitas_anggaran' => 'required|numeric',
                'harga_anggaran' => 'required|numeric',
            ]);
            $validation['anggaran_id'] = $anggaran->id;
            $validation['kel_anggaran_id'] = $kel_anggaran->id;
            $validation['total_anggaran'] = $validation['kuantitas_anggaran'] * $validation['harga_anggaran'];
            SubAnggaran::create($validation);

            return redirect()->route('anggarans.show', $anggaran)->with([
                notyf()->position('y', 'top')->success('Sub Anggaran berhasil dibuat'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Sub Anggaran gagal dibuat. Silakan coba lagi.' . ' ' . $th->getMessage())]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SubAnggaran $subAnggaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubAnggaran $subAnggaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubAnggaranRequest $request, SubAnggaran $subAnggaran)
    {
        try {
            $anggaran = $subAnggaran->anggaran;
            $validation = $request->validate([
                'no_detail' => 'required',
                'produk_id' => 'required|exists:produks,id',
                'kuantitas_anggaran' => 'required|numeric',
                'harga_anggaran' => 'required|numeric',
            ]);

            $validation['anggaran_id'] = $anggaran->id;
            $validation['total_anggaran'] = $validation['kuantitas_anggaran'] * $validation['harga_anggaran'];
            $kel_anggaran = Kel_Anggaran::where('id', $request->input('kel_anggaran'))->firstOrFail();
            $validation['kel_anggaran_id'] =  $kel_anggaran->id;

            $subAnggaran->update($validation);

            return redirect()->route('anggarans.show', $anggaran)->with([
                notyf()->position('y', 'top')->success('Sub Anggaran berhasil diupdate'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Sub Anggaran gagal diupdate. Silakan coba lagi.' . ' ' . $th->getMessage())]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubAnggaran $subAnggaran)
    {
        try {
            $subAnggaran->delete();
            return redirect()->route('anggarans.show', $subAnggaran->anggaran)->with([
                notyf()->position('y', 'top')->success('Sub Anggaran berhasil di hapus'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Sub Anggaran gagal di hapus. Silakan coba lagi.')]);
        }
    }
}
