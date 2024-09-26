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
        try {
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
                notyf()->position('y', 'top')->success('Satuan berhasil dibuat'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Satuan gagal dibuat. Silakan coba lagi.')]);
        }
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
        try {
            $validation = $request->validate([
                'nama_satuan' => 'required',
                'singkatan_satuan' => 'required',
                'deskripsi_satuan' => 'required|min:12|max:255',
            ]);
            $satuan->update($validation);

            return redirect()->route('satuans.index')->with([
                notyf()->position('y', 'top')->success('Satuan berhasil diupdate'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Satuan gagal diupdate. Silakan coba lagi.')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Satuan $satuan)
    {
        try {
            $satuan->delete();
            return redirect()->route('satuans.index')->with([
                notyf()->position('y', 'top')->success('Satuan berhasil di hapus'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Satuan gagal di hapus. Silakan coba lagi.')]);
        }
    }
}
