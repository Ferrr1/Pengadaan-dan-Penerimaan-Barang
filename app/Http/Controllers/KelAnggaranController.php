<?php

namespace App\Http\Controllers;

use App\Models\Kel_Anggaran;
use App\Http\Requests\StoreKel_AnggaranRequest;
use App\Http\Requests\UpdateKel_AnggaranRequest;
use Illuminate\Http\Request;

class KelAnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kel_Anggaran::query();
        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");
        $perPage = $request->input("perPage", 10);
        $perStatus = $request->input("perStatus", 'all');
        $search = $request->input('search', '');
        $lastKodeKelAnggaran = Kel_Anggaran::orderBy('kode_kel_anggaran', 'desc')->first();
        $nextKodeKelAnggaran = $lastKodeKelAnggaran ? str_pad((int)$lastKodeKelAnggaran->kode_kel_anggaran + 1, 4, '0', STR_PAD_LEFT) : '0001';

        // $searchableColumns = ['kode_kel_anggaran', 'nama_kel_anggaran'];
        if ($search) {
            $query->where("nama_kel_anggaran", "like", "%" . $search . "%")
                ->orWhere("kode_kel_anggaran", "like", "%" . $search . "%");
        }

        if ($perStatus !== 'all') {
            $query->where('status_kel_anggaran', $perStatus);
        }

        if ($perPage === 'all') {

            $kel_anggarans = $query->orderBy($sortField, $sortDirection)->get();
        } else {
            $perPage = (int) $perPage;

            $kel_anggarans = $query->orderBy($sortField, $sortDirection)
                ->paginate($perPage)
                ->onEachSide(1);
        }

        return view('pages.kel_anggaran.index', compact('kel_anggarans', 'sortField', 'sortDirection', 'perPage', 'perStatus', 'nextKodeKelAnggaran'));
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
    public function store(StoreKel_AnggaranRequest $request)
    {
        try {
            $validation = $request->validate([
                'nama_kel_anggaran' => 'required',
            ]);
            $lastKodeKelAnggaran = Kel_Anggaran::orderBy('kode_kel_anggaran', 'desc')->first();
            $nextKodeKelAnggaran = $lastKodeKelAnggaran ? str_pad((int)$lastKodeKelAnggaran->kode_kel_anggaran + 1, 4, '0', STR_PAD_LEFT) : '0001';

            // Add the next kode_kel_anggaran to the validated data
            $validation['kode_kel_anggaran'] = $nextKodeKelAnggaran;
            // dd($validation);
            Kel_Anggaran::create($validation);

            return redirect()->route('kelAnggarans.index')->with([
                notyf()->position('y', 'top')->success('Kelompok Anggaran berhasil dibuat'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Kelompok Anggaran gagal dibuat. Silakan coba lagi.')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kel_Anggaran $kel_Anggaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kel_Anggaran $kel_Anggaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKel_AnggaranRequest $request, $id)
    {
        try {
            $kel_Anggaran = Kel_Anggaran::findOrFail($id);
            $validation = $request->validate([
                'nama_kel_anggaran' => 'required',
            ]);
            $kel_Anggaran->update($validation);

            return redirect()->route('kelAnggarans.index')->with([
                notyf()->position('y', 'top')->success('Kelompok Anggaran berhasil diupdate'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Kelompok Anggaran gagal diupdate. Silakan coba lagi.')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $kel_Anggaran = Kel_Anggaran::findOrFail($id);
            $kel_Anggaran->delete();
            return redirect()->route('kelAnggarans.index')->with([
                notyf()->position('y', 'top')->success('Kelompok Anggaran berhasil di hapus'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Kelompok Anggaran gagal di hapus. Silakan coba lagi.')]);
        }
    }
}
