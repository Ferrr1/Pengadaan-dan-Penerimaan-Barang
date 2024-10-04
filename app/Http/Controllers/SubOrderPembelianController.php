<?php

namespace App\Http\Controllers;

use App\Models\SubOrderPembelian;
use App\Http\Requests\StoreSubOrderPembelianRequest;
use App\Http\Requests\UpdateSubOrderPembelianRequest;
use App\Models\OrderPembelian;
use App\Models\SubPermintaan_Pembelian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SubOrderPembelianController extends Controller
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
    public function store(StoreSubOrderPembelianRequest $request, $id)
    {
        try {
            $OrderPembelian = OrderPembelian::findOrFail($id);
            $AnggaranPP = $OrderPembelian->permintaanPembelian->subPermintaanPembelians;

            if (!$AnggaranPP) {
                throw new \Exception('Sub Permintaan tidak ditemukan untuk Permintaan Pembelian ini.');
            }

            $validation = $request->validate([
                'sub_permintaanpembelian_id' => 'required|exists:sub_permintaan_pembelian,id',
                'ppn_sub_order_pembelian' => 'required|numeric',
                'kuantitas_sub_order_pembelian' => 'required|numeric',
                'catatan_sub_order_pembelian' => 'nullable|string',
            ]);

            $subPermintaanPembelian = SubPermintaan_Pembelian::findOrFail($validation['sub_permintaanpembelian_id']);

            if (!$AnggaranPP->contains('id', $subPermintaanPembelian->id)) {
                throw new \Exception('Sub Anggaran tidak sesuai dengan Anggaran Permintaan Pembelian.');
            }
            // $PPN = (($subPermintaanPembelian->harga_sub_permintaan_pembelian * ($validation['kuantitas_sub_order_pembelian'])) * ($validation['ppn_sub_order_pembelian'] / 100));
            // $totalWithPPN = ((($subPermintaanPembelian->harga_sub_permintaan_pembelian) * ($validation['kuantitas_sub_order_pembelian'])) + $PPN);
            $totalWithoutPPN = (($subPermintaanPembelian->harga_sub_permintaan_pembelian) * ($validation['kuantitas_sub_order_pembelian']));
            $validation['orderpembelian_id'] = $OrderPembelian->id;
            $validation['total_sub_order_pembelian'] = $totalWithoutPPN;
            if ($request->input('kuantitas_sub_order_pembelian') > $subPermintaanPembelian->kuantitas_sub_permintaan_pembelian) {
                throw new \Exception('Kuantitas dan total harga order pembelian melebihi kuantitas permintaan yang tersedia.');
            }

            $validation['sub_permintaanpembelian_id'] = $subPermintaanPembelian->id;
            SubOrderPembelian::create($validation);
            // Kurangi PP
            $subPermintaanPembelian->kuantitas_sub_permintaan_pembelian -= $validation['kuantitas_sub_order_pembelian'];
            $subPermintaanPembelian->total_sub_permintaan_pembelian -= $totalWithoutPPN;
            // Update total pp
            $subPermintaanPembelian->save();


            return redirect()->route('orderPembelians.show', $OrderPembelian)->with([
                notyf()->position('y', 'top')->success('Sub Order Pembelian berhasil dibuat dan permintaan diperbarui'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                notyf()->position('y', 'top')->error('Sub Order Pembelian gagal dibuat. ' . $e->getMessage())
            ]);
        }
    }


    public function generatePdfReport($id, Request $request)
    {
        $orderPembelian = OrderPembelian::with(['rekanan', 'subOrderPembelians', 'subOrderPembelians.subPermintaanPembelian'])
            ->findOrFail($id);
        $limit = $request->input('limit', null); // Jumlah sub PP yang akan dicetak, null berarti semua
        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");

        $total_jumlah_harga = $orderPembelian->subOrderPembelians()->sum('total_sub_order_pembelian');
        $avg_ppn = $orderPembelian->subOrderPembelians->avg('ppn_sub_order_pembelian');
        // $first_ppn = $orderPembelian->subOrderPembelians->first()->ppn_sub_order_pembelian;
        $ppn_jumlah_harga = ($total_jumlah_harga * ($avg_ppn / 100));
        $totalWithPPN = $total_jumlah_harga + $ppn_jumlah_harga;
        $querySubPermintaanPembelian = $orderPembelian->subOrderPembelians()
            ->orderBy($sortField, $sortDirection);

        if ($limit) {
            $subOrderPembelians = $querySubPermintaanPembelian->take($limit)->get();
        } else {
            $subOrderPembelians = $querySubPermintaanPembelian->get();
        }

        $total_jumlah_harga = $subOrderPembelians->sum('total_sub_order_pembelian');

        $data = [
            'orderPembelian' => $orderPembelian,
            'subOrderPembelians' => $subOrderPembelians,
            'total_jumlah_harga' => $total_jumlah_harga,
            'ppn_jumlah_harga' => $ppn_jumlah_harga,
            'totalWithPPN' => $totalWithPPN,
        ];

        $pdf = PDF::loadView('pages.order_pembelian.report.index', $data)->setPaper('a4', 'potrait');

        return $pdf->stream('order_pembelian_report.pdf');
    }
    /**
     * Display the specified resource.
     */
    public function show(SubOrderPembelian $subOrderPembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubOrderPembelian $subOrderPembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubOrderPembelianRequest $request, $id)
    {
        try {
            $subOrderPembelian = SubOrderPembelian::findOrFail($id);
            $AnggaranPP = $subOrderPembelian->orderPembelian;

            if (!$subOrderPembelian) {
                throw new \Exception('Order Pembelian tidak ditemukan.');
            }

            $validation = $request->validate([
                'sub_permintaanpembelian_id' => 'required|exists:sub_permintaan_pembelian,id',
                'ppn_sub_order_pembelian' => 'required|numeric',
                'kuantitas_sub_order_pembelian' => 'required|numeric',
                'catatan_sub_order_pembelian' => 'nullable|string',
            ]);

            $subPermintaanPembelian = SubPermintaan_Pembelian::findOrFail($validation['sub_permintaanpembelian_id']);
            if (!$AnggaranPP->permintaanPembelian->subPermintaanPembelians()->where('id', $subPermintaanPembelian->id)->exists()) {
                throw new \Exception('Sub Anggaran tidak sesuai dengan Anggaran Permintaan Pembelian.');
            }
            $PPN = (($subPermintaanPembelian->harga_sub_permintaan_pembelian * ($validation['kuantitas_sub_order_pembelian'])) * ($validation['ppn_sub_order_pembelian'] / 100));
            $totalWithPPN = ((($subPermintaanPembelian->harga_sub_permintaan_pembelian) * ($validation['kuantitas_sub_order_pembelian'])) + $PPN);
            $totalWithoutPPN = (($subPermintaanPembelian->harga_sub_permintaan_pembelian) * ($validation['kuantitas_sub_order_pembelian']));
            $validation['orderpembelian_id'] = $AnggaranPP->id;
            $validation['total_sub_order_pembelian'] = $totalWithPPN;

            $kuantitasSubOrderPembelianLama = $subOrderPembelian->kuantitas_sub_order_pembelian;
            $totalHargaSubOrderPembelianLama = $subOrderPembelian->total_sub_order_pembelian;
            $kuantitasSubPermintaanPembelianBaru = $validation['kuantitas_sub_order_pembelian'] - $kuantitasSubOrderPembelianLama;
            $totalHargaSubPermintaanPembelianBaru = $validation['total_sub_order_pembelian'] - $totalHargaSubOrderPembelianLama;
            // Jika kuantitas dikurangi
            if ($kuantitasSubPermintaanPembelianBaru < 0) {
                // Tambahkan nilai yang dikurangi kembali ke anggaran
                $subPermintaanPembelian->kuantitas_sub_permintaan_pembelian += abs($kuantitasSubPermintaanPembelianBaru);
                $subPermintaanPembelian->total_sub_permintaan_pembelian += abs($totalHargaSubPermintaanPembelianBaru);
            } else {
                // Jika kuantitas ditambah, periksa apakah melebihi anggaran yang tersedia
                if (($subPermintaanPembelian->kuantitas_sub_permintaan_pembelian - $kuantitasSubPermintaanPembelianBaru < 0) ||
                    ($subPermintaanPembelian->total_sub_permintaan_pembelian - $totalHargaSubPermintaanPembelianBaru < 0)
                ) {
                    throw new \Exception('Kuantitas dan total harga permintaan melebihi kuantitas anggaran yang tersedia.');
                }
                // Kurangi PP
                $subPermintaanPembelian->kuantitas_sub_permintaan_pembelian -= $kuantitasSubPermintaanPembelianBaru;
                $subPermintaanPembelian->total_sub_permintaan_pembelian -= $totalWithoutPPN;
                // Update total pp
            }

            $validation['sub_permintaanpembelian_id'] = $subPermintaanPembelian->id;

            $subOrderPembelian->update($validation);
            $subPermintaanPembelian->save();


            return redirect()->route('orderPembelians.show', $AnggaranPP)->with([
                notyf()->position('y', 'top')->success('Sub Order Pembelian berhasil diupdate dan permintaan diperbarui'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                notyf()->position('y', 'top')->error('Sub Order Pembelian gagal diupdate. ' . $e->getMessage())
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $subOrderPembelian = SubOrderPembelian::findOrFail($id);
            $kuantitasSubOrderPembelianLama = $subOrderPembelian->kuantitas_sub_order_pembelian;
            $totalHargaSubOrderPembelianLama = (($subOrderPembelian->total_sub_order_pembelian) - (($subOrderPembelian->kuantitas_sub_order_pembelian * $subOrderPembelian->subPermintaanPembelian->harga_sub_permintaan_pembelian) * ($subOrderPembelian->ppn_sub_order_pembelian / 100)));

            // Mengambil SubPermintaan_Pembelian berdasarkan sub_permintaanpembelian_id dari SubOrderPembelian
            $subPermintaanPembelian = SubPermintaan_Pembelian::findOrFail($subOrderPembelian->sub_permintaanpembelian_id);

            // Memastikan SubPermintaan_Pembelian ditemukan
            if (!$subPermintaanPembelian) {
                throw new \Exception('Sub Permintaan Pembelian tidak ditemukan.');
            }

            // Mengembalikan kuantitas dan total harga ke subPermintaanPembelian
            $subPermintaanPembelian->kuantitas_sub_permintaan_pembelian += $kuantitasSubOrderPembelianLama;
            $subPermintaanPembelian->total_sub_permintaan_pembelian += $totalHargaSubOrderPembelianLama;
            $subPermintaanPembelian->save();

            // Menghapus SubPermintaan_Pembelian
            $subOrderPembelian->delete();

            return redirect()->route('orderPembelians.show', $subOrderPembelian->orderPembelian)->with([
                notyf()->position('y', 'top')->success('Sub Order Pembelian berhasil dihapus dan permintaan diperbarui'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                notyf()->position('y', 'top')->error('Sub Order Pembelian gagal dihapus. ' . $th->getMessage())
            ]);
        }
    }
}
