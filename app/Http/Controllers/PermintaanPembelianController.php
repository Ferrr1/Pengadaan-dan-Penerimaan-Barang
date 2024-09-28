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
        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");
        $perPage = $request->input("perPage", 10);
        $search = $request->input('search', '');
        $currentDate = now();
        $currentMonth = $currentDate->format('m');
        $currentYear = $currentDate->format('Y');

        // Fungsi untuk generate kode PP
        $generatePPCode = function () use ($currentMonth, $currentYear) {
            $queryAnggaran = Anggaran::query();
            $lastCode = Permintaan_Pembelian::whereRaw('SUBSTRING_INDEX(nomor_pp, "/", -1) = ?', ["{$currentMonth}.{$currentYear}"])
                ->orderBy('id', 'desc')
                ->first();

            if ($lastCode) {
                $lastCounter = (int)substr($lastCode->nomor_pp, 0, 5);
                $newCounter = $lastCounter + 1;
            } else {
                $newCounter = 1; // Reset to 1 if it's a new month or no previous entries
            }

            $formattedCounter = str_pad($newCounter, 5, '0', STR_PAD_LEFT);
            $projectAnggaran = $queryAnggaran->where('kode_anggaran_project', request('kode_anggaran_project'))->first();
            $projectCode = $projectAnggaran ? $projectAnggaran->kode_anggaran_project : 'XXXXX';
            return "{$formattedCounter}/PP/{$projectCode}/{$currentMonth}.{$currentYear}";
        };
        $newPPCode = $generatePPCode();

        if ($search) {
            $queryPermintaanPembelian->where("kode_project", "like", "%" . $search . "%")
                ->orWhere("nama_project", "like", "%" . $search . "%");
        }

        if ($perPage === 'all') {
            $permintaan_pembelians = $queryPermintaanPembelian->orderBy($sortField, $sortDirection)->get();
        } else {
            $perPage = (int) $perPage;
            $anggarans = $queryAnggaran->orderBy($sortField, $sortDirection)->get();
            $permintaan_pembelians = $queryPermintaanPembelian->orderBy($sortField, $sortDirection)
                ->paginate($perPage)
                ->onEachSide(1);
        }

        return view('pages.permintaan_pembelian.index', compact('permintaan_pembelians', 'anggarans', 'sortField', 'sortDirection', 'perPage', 'newPPCode'));
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
        try {
            $validation = $request->validate([
                'nomor_pp' => 'required|string',
                'tgl_pp' => 'required|date',
                'tandatangan_pp' => 'required',
            ]);
            $kodeAnggaran = $request->input('kode_anggaran');
            $anggaranpembelian = Anggaran::where('kode_anggaran_project', $kodeAnggaran)->firstOrFail();

            $existingPermintaan = Permintaan_Pembelian::where('anggaran_id', $anggaranpembelian->id)->first();
            if ($existingPermintaan) {
                throw new \Exception('Sudah ada permintaan pembelian untuk proyek ini.');
            }
            $validation['anggaran_id'] =  $anggaranpembelian->id;
            Permintaan_Pembelian::create($validation);

            return redirect()->route('permintaanPembelians.index')->with([
                notyf()->position('y', 'top')->success('Permintaan berhasil dibuat'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Permintaan gagal dibuat. Silakan coba lagi.' . ' ' . $e->getMessage())]);
        }
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
    public function destroy($id)
    {
        try {
            $permintaan_Pembelian = Permintaan_Pembelian::findOrFail($id);
            $permintaan_Pembelian->delete();
            return redirect()->route('permintaanPembelians.index')->with([
                notyf()->position('y', 'top')->success('Permintaan berhasil dihapus'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Permintaan gagal dihapus. Silakan coba lagi.')]);
        }
    }
}
