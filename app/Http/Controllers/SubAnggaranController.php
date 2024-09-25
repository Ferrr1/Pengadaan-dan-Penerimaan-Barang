<?php

namespace App\Http\Controllers;

use App\Models\SubAnggaran;
use App\Http\Requests\StoreSubAnggaranRequest;
use App\Http\Requests\UpdateSubAnggaranRequest;
use App\Models\Anggaran;
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
        $validation = $request->validate([
            'no_detail' => 'required',
            'kode_anggaran' => 'required',
            'nama_anggaran' => 'required|string',
            'satuan_id' => 'required|exists:satuans,id',
            'kuantitas_anggaran' => 'required|numeric',
            'harga_anggaran' => 'required|numeric',
        ]);

        $validation['anggaran_id'] = $anggaran->id;

        SubAnggaran::create($validation);

        return redirect()->route('anggarans.show', $anggaran)->with([
            'success' => 'Sub Anggaran created successfully',
        ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubAnggaran $subAnggaran)
    {
        //
    }
}
