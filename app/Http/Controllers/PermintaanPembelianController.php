<?php

namespace App\Http\Controllers;

use App\Models\Permintaan_Pembelian;
use App\Http\Requests\StorePermintaan_PembelianRequest;
use App\Http\Requests\UpdatePermintaan_PembelianRequest;
use App\Models\Anggaran;
use App\Models\Project;
use Illuminate\Http\Request;

class PermintaanPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryPermintaanPembelian = Permintaan_Pembelian::query();
        $queryAnggaran = Anggaran::query();
        $queryProject = Project::query();
        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");
        $perPage = $request->input("perPage", 10);
        $search = $request->input('search', '');
        // $searchableColumns = ['kode_permintaan_pembelian', 'nama_permintaan_pembelian'];
        if ($search) {
            $queryPermintaanPembelian->where("kode_project", "like", "%" . $search . "%")
                ->orWhere("nama_project", "like", "%" . $search . "%");
        }

        if ($perPage === 'all') {

            $permintaan_pembelians = $queryPermintaanPembelian->orderBy($sortField, $sortDirection)->get();
        } else {
            $perPage = (int) $perPage;

            $projects = $queryProject->orderBy($sortField, $sortDirection)->get();
            $anggarans = $queryAnggaran->orderBy($sortField, $sortDirection)->get();
            $permintaan_pembelians = $queryPermintaanPembelian->orderBy($sortField, $sortDirection)
                ->paginate($perPage)
                ->onEachSide(1);
        }
        return view('pages.permintaan_pembelian.index', compact('permintaan_pembelians', 'projects', 'anggarans', 'sortField', 'sortDirection', 'perPage'));
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
    public function store(StorePermintaan_PembelianRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Permintaan_Pembelian $permintaan_Pembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permintaan_Pembelian $permintaan_Pembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermintaan_PembelianRequest $request, Permintaan_Pembelian $permintaan_Pembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permintaan_Pembelian $permintaan_Pembelian)
    {
        //
    }
}
