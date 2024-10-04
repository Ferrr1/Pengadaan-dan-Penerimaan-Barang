<?php

namespace App\Http\Controllers;

use App\Models\OrderPembelian;
use App\Http\Requests\StoreOrderPembelianRequest;
use App\Http\Requests\UpdateOrderPembelianRequest;
use App\Models\Anggaran;
use App\Models\Permintaan_Pembelian;
use App\Models\Rekanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class OrderPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryOrderPembelian = OrderPembelian::query()->with(['rekanan', 'permintaanpembelian', 'permintaanpembelian.transaksi', 'subOrderPembelians.subPermintaanPembelian']);
        $queryRekanan = Rekanan::query();
        $queryPP = Permintaan_Pembelian::query()->with(['anggaran', 'anggaran.project', 'transaksi']);
        // dd($queryPP->toArray(), $queryOrderPembelian);
        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");
        $perPage = $request->input("perPage", 10);
        $search = $request->input('search', '');
        $currentDate = now();
        $currentMonth = $currentDate->format('m');
        $currentYear = $currentDate->format('Y');

        // Fungsi untuk generate kode OP
        $generateOPCode = function () use ($currentMonth, $currentYear) {
            $queryPP = Anggaran::query()->with('project');
            $lastCode = OrderPembelian::whereRaw('SUBSTRING_INDEX(nomor_op, "/", -1) = ?', ["{$currentMonth}.{$currentYear}"])
                ->orderBy('id', 'desc')
                ->first();

            if ($lastCode) {
                $lastCounter = (int)substr($lastCode->nomor_op, 0, 5);
                $newCounter = $lastCounter + 1;
            } else {
                $newCounter = 1; // Reset to 1 if it's a new month or no previous entries
            }

            $projectAnggaran = $queryPP->where('id', request('anggaran_id'))->first();
            $projectCode = $projectAnggaran && $projectAnggaran->project ? $projectAnggaran->project->kode_project : 'XXXXX';
            $formattedCounter = str_pad($newCounter, 5, '0', STR_PAD_LEFT);
            return "{$formattedCounter}/OP/{$projectCode}/{$currentMonth}.{$currentYear}";
        };
        $newOPCode = $generateOPCode();

        if ($search) {
            // dd($queryOrderPembelian);
            $queryOrderPembelian->where("nomor_op", "like", "%" . $search . "%");
        }

        if ($perPage === 'all') {
            $order_pembelians = $queryOrderPembelian->orderBy($sortField, $sortDirection)->get();
        } else {
            $perPage = (int) $perPage;
            $rekanans = $queryRekanan->orderBy($sortField, $sortDirection)->get();
            $permintaan_pembelians = $queryPP->orderBy($sortField, $sortDirection)->get();
            $order_pembelians = $queryOrderPembelian->orderBy($sortField, $sortDirection)
                ->paginate($perPage)
                ->onEachSide(1);
        }

        return view('pages.order_pembelian.index', compact('order_pembelians', 'rekanans', 'permintaan_pembelians', 'sortField', 'sortDirection', 'perPage', 'newOPCode'));
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
    public function store(StoreOrderPembelianRequest $request)
    {
        try {
            $validation = $request->validate([
                'rekanan_id' => 'required|exists:rekanans,id',
                'nomor_op' => 'required|string',
                'tgl_op' => 'required|date',
                'tandatangan_op' => 'required|array',
                'tandatangan_op.*.tanda_tangan' => 'required|string',
                'tandatangan_op.*.posisi_jabatan' => 'required|string',
            ]);
            $orderPembelian = Permintaan_Pembelian::where('anggaran_id', $request->input('permintaanpembelian_id'))->firstOrFail();
            $existingPermintaan = OrderPembelian::where('permintaanpembelian_id', $orderPembelian->id)->first();
            if ($existingPermintaan) {
                throw new \Exception('Sudah ada Order Pembelian untuk proyek ini.');
            }
            $tandaTanganData = [];
            foreach ($request->input('tandatangan_op') as $item) {
                $tandaTanganData[] = [
                    'tanda_tangan' => $item['tanda_tangan'],
                    'posisi_jabatan' => $item['posisi_jabatan'],
                ];
            }
            $validation['tandatangan_op'] = $tandaTanganData;
            $validation['permintaanpembelian_id'] =  $orderPembelian->id;

            OrderPembelian::create($validation);

            return redirect()->route('orderPembelians.index')->with([
                notyf()->position('y', 'top')->success('Order pembelian berhasil dibuat'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Order pembelian gagal dibuat. Silakan coba lagi.' . ' ' . $e->getMessage())]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        $order_pembelians = OrderPembelian::query()->with(['rekanan', 'subOrderPembelians.subPermintaanPembelian'])->findOrFail($id)->first();
        // dd($order_pembelians);
        $queryOrderPembelian = $order_pembelians->subOrderPembelians();
        // $queryProduk = Produk::query();

        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");
        $search = $request->input('search', '');
        $perPage = $request->input("perPage", 10);

        $total_jumlah_harga = $queryOrderPembelian->sum('total_sub_order_pembelian');
        $avg_ppn = $order_pembelians->subOrderPembelians->avg('ppn_sub_order_pembelian');
        $ppn_jumlah_harga = ($total_jumlah_harga * ($avg_ppn / 100));
        $totalWithPPN = $total_jumlah_harga + $ppn_jumlah_harga;

        if ($search) {
            $queryOrderPembelian->WhereHas('produk', function ($q) use ($search) {
                $q->where("kode_produk", "like", "%" . $search . "%")->orWhere("nama_produk", "like", "%" . $search . "%");
            });
        }

        $subOrderPembelians = $queryOrderPembelian->orderBy($sortField, $sortDirection);

        if ($perPage !== 'all') {
            $subOrderPembelians = $subOrderPembelians->paginate($perPage)->onEachSide(1);
        } else {
            $subOrderPembelians = $subOrderPembelians->get();
        }

        $anggaranOrders = $order_pembelians->permintaanpembelian->anggaran;
        // $produks = $queryProduk->orderBy($sortField, $sortDirection)->get();

        $subPermintaans = $order_pembelians->permintaanPembelian->subPermintaanPembelians;

        return view("pages.order_pembelian.show_sub_op")->with([
            "order_pembelians" => $order_pembelians,
            "subOrderPembelians" => $subOrderPembelians,
            "anggaranOrders" => $anggaranOrders,
            "sortField" => $sortField,
            "sortDirection" => $sortDirection,
            "perPage" => $perPage,
            "search" => $search,
            "total_jumlah_harga" => $total_jumlah_harga,
            "ppn_jumlah_harga" => $ppn_jumlah_harga,
            "totalWithPPN" => $totalWithPPN,
            "subPermintaans" => $subPermintaans,
            "canPrintPdf" => true,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderPembelian $orderPembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderPembelianRequest $request, OrderPembelian $orderPembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderPembelian $orderPembelian)
    {
        try {
            $orderPembelian->delete();
            return redirect()->route('orderPembelians.index')->with([
                notyf()->position('y', 'top')->success('Order pembelian berhasil dihapus'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([notyf()->position('y', 'top')->error('Order pembelian gagal dihapus. Silakan coba lagi.')]);
        }
    }
}
