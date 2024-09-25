<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use App\Http\Requests\StoreSatuanRequest;
use App\Http\Requests\UpdateSatuanRequest;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Satuan::query();

        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");
        $perPage = $request->input("perPage", 10);
        $search = $request->input('search', '');
        $lastKodeSatuan = Satuan::orderBy('kode_satuan', 'desc')->first();
        $nextKodeSatuan = $lastKodeSatuan ? str_pad((int)$lastKodeSatuan->kode_satuan + 1, 6, '0', STR_PAD_LEFT) : '000001';
        // $searchableColumns = ['kode_satuan', 'nama_satuan', 'singkatan_satuan', 'deskripsi_satuan'];
        if ($search) {
            $query->where("kode_satuan", "like", "%" . $search . "%")
                ->orWhere("nama_satuan", "like", "%" . $search . "%");
        }

        if ($perPage === 'all') {

            $satuans = $query->orderBy($sortField, $sortDirection)->get();
        } else {
            $perPage = (int) $perPage;

            $satuans = $query->orderBy($sortField, $sortDirection)
                ->paginate($perPage)
                ->onEachSide(1);
        }

        return view('pages.satuan.index', compact('satuans', 'sortField', 'sortDirection', 'perPage', 'nextKodeSatuan'));
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
    public function store(StoreSatuanRequest $request)
    {
        $validation = $request->validate([
            'nama_satuan' => 'required',
            'singkatan_satuan' => 'required',
            'deskripsi_satuan' => 'required|min:12|max:255',
        ]);
        $lastKodeSatuan = Satuan::orderBy('kode_satuan', 'desc')->first();
        $nextKodeSatuan = $lastKodeSatuan ? str_pad((int)$lastKodeSatuan->kode_satuan + 1, 6, '0', STR_PAD_LEFT) : '000001';
        $validation['kode_satuan'] = $nextKodeSatuan;
        Satuan::create($validation);

        return redirect()->route('satuans.index')->with([
            'success' => 'Satuan created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Satuan $satuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Satuan $satuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Satuan $satuan)
    {
        $validation = $request->validate([
            'nama_satuan' => 'required',
            'singkatan_satuan' => 'required',
            'deskripsi_satuan' => 'required|min:12|max:255',
        ]);
        $satuan->update($validation);

        return redirect()->route('satuans.index')->with([
            'success' => 'Satuan updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Satuan $satuan)
    {
        $satuan->delete();
        return redirect()->route('satuans.index')->with('success', 'Satuan deleted successfully');
    }
}
