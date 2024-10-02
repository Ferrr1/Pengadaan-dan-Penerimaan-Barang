<?php

namespace App\Http\Controllers;

use App\Models\Permintaan_Pembelian;
use App\Http\Requests\StorePermintaan_PembelianRequest;
use App\Http\Requests\UpdatePermintaan_PembelianRequest;
use App\Models\Anggaran;
use App\Models\Produk;
use Illuminate\Http\Request;

class PermintaanPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryPermintaanPembelian = Permintaan_Pembelian::query()->with('anggaran');
        $queryAnggaran = Anggaran::query()->with('project');
        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");
        $perPage = $request->input("perPage", 10);
        $search = $request->input('search', '');
        $currentDate = now();
        $currentMonth = $currentDate->format('m');
        $currentYear = $currentDate->format('Y');

        // Fungsi untuk generate kode PP
        $generatePPCode = function () use ($currentMonth, $currentYear) {
            $queryAnggaran = Anggaran::query()->with('project');
            $lastCode = Permintaan_Pembelian::whereRaw('SUBSTRING_INDEX(nomor_pp, "/", -1) = ?', ["{$currentMonth}.{$currentYear}"])
                ->orderBy('id', 'desc')
                ->first();

            if ($lastCode) {
                $lastCounter = (int)substr($lastCode->nomor_pp, 0, 5);
                $newCounter = $lastCounter + 1;
            } else {
                $newCounter = 1; // Reset to 1 if it's a new month or no previous entries
            }

            $projectAnggaran = $queryAnggaran->where('id', request('anggaran_id'))->first();
            $projectCode = $projectAnggaran && $projectAnggaran->project ? $projectAnggaran->project->kode_project : 'XXXXX';
            $formattedCounter = str_pad($newCounter, 5, '0', STR_PAD_LEFT);
            return "{$formattedCounter}/PP/{$projectCode}/{$currentMonth}.{$currentYear}";
        };
        $newPPCode = $generatePPCode();

        if ($search) {
            // dd($queryPermintaanPembelian);
            $queryPermintaanPembelian->where("nomor_pp", "like", "%" . $search . "%");
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
                'tandatangan_pp' => 'required|array',
                'tandatangan_pp.*.tanda_tangan' => 'required|string',
                'tandatangan_pp.*.posisi_jabatan' => 'required|string',
            ]);

            $anggaranpembelian = Anggaran::where('project_id', $request->input('anggaran_id'))->firstOrFail();
            $existingPermintaan = Permintaan_Pembelian::where('anggaran_id', $anggaranpembelian->id)->first();
            if ($existingPermintaan) {
                throw new \Exception('Sudah ada permintaan pembelian untuk proyek ini.');
            }
            $tandaTanganData = [];
            foreach ($request->input('tandatangan_pp') as $item) {
                $tandaTanganData[] = [
                    'tanda_tangan' => $item['tanda_tangan'],
                    'posisi_jabatan' => $item['posisi_jabatan'],
                ];
            }
            $validation['tandatangan_pp'] = $tandaTanganData;
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
    public function show($id, Request $request)
    {
        $permintaan_Pembelian = Permintaan_Pembelian::with(['anggaran', 'subPermintaanPembelians.subAnggaran', 'subPermintaanPembelians.produk'])->findOrFail($id);
        $queryPermintaanPembelian = $permintaan_Pembelian->subPermintaanPembelians();
        $queryProduk = Produk::query();

        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");
        $search = $request->input('search', '');
        $perPage = $request->input("perPage", 10);

        $total_harga_satuan = $queryPermintaanPembelian->sum('harga_sub_permintaan_pembelian');
        $total_jumlah_harga = $queryPermintaanPembelian->sum('total_sub_permintaan_pembelian');

        if ($search) {
            $queryPermintaanPembelian->WhereHas('produk', function ($q) use ($search) {
                $q->where("kode_produk", "like", "%" . $search . "%")->orWhere("nama_produk", "like", "%" . $search . "%");
            });
        }

        $subPermintaanPembelians = $queryPermintaanPembelian->orderBy($sortField, $sortDirection);

        if ($perPage !== 'all') {
            $subPermintaanPembelians = $subPermintaanPembelians->paginate($perPage)->onEachSide(1);
        } else {
            $subPermintaanPembelians = $subPermintaanPembelians->get();
        }

        $anggaranpembelians = $permintaan_Pembelian->anggaran;
        $produks = $queryProduk->orderBy($sortField, $sortDirection)->get();

        $subAnggarans = $permintaan_Pembelian->anggaran->subAnggarans;

        return view("pages.permintaan_pembelian.show_sub_pp")->with([
            "permintaan_Pembelian" => $permintaan_Pembelian,
            "subPermintaanPembelians" => $subPermintaanPembelians,
            "anggaranpembelians" => $anggaranpembelians,
            "sortField" => $sortField,
            "sortDirection" => $sortDirection,
            "perPage" => $perPage,
            "search" => $search,
            "total_jumlah_harga" => $total_jumlah_harga,
            "total_harga_satuan" => $total_harga_satuan,
            "produks" => $produks,
            "subAnggarans" => $subAnggarans,
            "canPrintPdf" => true,
        ]);
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
