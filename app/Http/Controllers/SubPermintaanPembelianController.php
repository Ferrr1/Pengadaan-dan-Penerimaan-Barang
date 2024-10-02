<?php

namespace App\Http\Controllers;

use App\Models\SubPermintaan_Pembelian;
use App\Http\Requests\StoreSubPermintaan_PembelianRequest;
use App\Http\Requests\UpdateSubPermintaan_PembelianRequest;
use App\Models\Permintaan_Pembelian;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SubAnggaran;
use Illuminate\Http\Request;

class SubPermintaanPembelianController extends Controller
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
    public function store(StoreSubPermintaan_PembelianRequest $request, $id)
    {
        try {
            $permintaan_Pembelian = Permintaan_Pembelian::findOrFail($id);
            $anggaran = $permintaan_Pembelian->anggaran;

            if (!$anggaran) {
                throw new \Exception('Anggaran tidak ditemukan untuk Permintaan Pembelian ini.');
            }

            $validation = $request->validate([
                'sub_anggaran_id' => 'required|exists:sub_anggarans,id',
                'produk_id' => 'required|exists:produks,id',
                'spesifikasi_sub_permintaan_pembelian' => 'required|string',
                'kuantitas_sub_permintaan_pembelian' => 'required|numeric',
                'harga_sub_permintaan_pembelian' => 'required|numeric',
                'keterangan_sub_permintaan_pembelian' => 'nullable|string',
            ]);

            $subAnggaran = SubAnggaran::findOrFail($validation['sub_anggaran_id']);

            if ($subAnggaran->anggaran_id !== $anggaran->id) {
                throw new \Exception('Sub Anggaran tidak sesuai dengan Anggaran Permintaan Pembelian.');
            }

            $validation['permintaanpembelian_id'] = $permintaan_Pembelian->id;
            $validation['total_sub_permintaan_pembelian'] = $validation['kuantitas_sub_permintaan_pembelian'] * $validation['harga_sub_permintaan_pembelian'];

            if ($validation['kuantitas_sub_permintaan_pembelian'] > $subAnggaran->kuantitas_anggaran || $validation['total_sub_permintaan_pembelian'] > $subAnggaran->total_anggaran) {
                throw new \Exception('Kuantitas dan total harga permintaan melebihi kuantitas anggaran yang tersedia.');
            }

            $validation['sub_anggaran_id'] = $subAnggaran->id;
            SubPermintaan_Pembelian::create($validation);
            // Kurangi anggaran
            $subAnggaran->kuantitas_anggaran -= $validation['kuantitas_sub_permintaan_pembelian'];
            $subAnggaran->total_anggaran -= $validation['total_sub_permintaan_pembelian'];
            // Update total anggaran induk
            $subAnggaran->save();


            return redirect()->route('permintaanPembelians.show', $permintaan_Pembelian)->with([
                notyf()->position('y', 'top')->success('Sub Permintaan Pembelian berhasil dibuat dan anggaran diperbarui'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                notyf()->position('y', 'top')->error('Sub Permintaan Pembelian gagal dibuat. ' . $e->getMessage())
            ]);
        }
    }


    public function generatePdfReport($id, Request $request)
    {
        $permintaan_Pembelian = Permintaan_Pembelian::with(['anggaran', 'subPermintaanPembelians.subAnggaran', 'subPermintaanPembelians.produk'])->findOrFail($id);
        $kelompokAnggarans = $permintaan_Pembelian->anggaran->subAnggarans
            ->pluck('kelAnggaran.nama_kel_anggaran')
            ->unique()
            ->values();
        $limit = $request->input('limit', null); // Jumlah sub PP yang akan dicetak, null berarti semua
        $sortField = $request->input("sort_field", 'created_at');
        $sortDirection = $request->input("sort_direction", "desc");

        $querySubPermintaanPembelian = $permintaan_Pembelian->subPermintaanPembelians()
            ->orderBy($sortField, $sortDirection);

        if ($limit) {
            $subPermintaanPembelians = $querySubPermintaanPembelian->take($limit)->get();
        } else {
            $subPermintaanPembelians = $querySubPermintaanPembelian->get();
        }

        $total_harga_satuan = $subPermintaanPembelians->sum('harga_sub_permintaan_pembelian');
        $total_jumlah_harga = $subPermintaanPembelians->sum('total_sub_permintaan_pembelian');

        $data = [
            'permintaan_Pembelian' => $permintaan_Pembelian,
            'subPermintaanPembelians' => $subPermintaanPembelians,
            'total_harga_satuan' => $total_harga_satuan,
            'total_jumlah_harga' => $total_jumlah_harga,
            'kelompokAnggarans' => $kelompokAnggarans
        ];

        $pdf = PDF::loadView('pages.permintaan_pembelian.report.index', $data)->setPaper('a4', 'landscape');

        return $pdf->stream('permintaan_pembelian_report.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubPermintaan_Pembelian $subPermintaan_Pembelian)
    {
        //
    }

    public function edit(SubPermintaan_Pembelian $subPermintaan_Pembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubPermintaan_PembelianRequest $request, $id)
    {
        try {
            $subPermintaan_Pembelian = SubPermintaan_Pembelian::findOrFail($id);
            $permintaan_Pembelian = $subPermintaan_Pembelian->permintaanPembelian;
            if (!$permintaan_Pembelian) {
                throw new \Exception('Permintaan Pembelian tidak ditemukan.');
            }
            $anggaran = $permintaan_Pembelian->anggaran;

            if (!$anggaran) {
                throw new \Exception('Anggaran tidak ditemukan untuk Permintaan Pembelian ini.');
            }

            $validation = $request->validate([
                'sub_anggaran_id' => 'required|exists:sub_anggarans,id',
                'produk_id' => 'required|exists:produks,id',
                'spesifikasi_sub_permintaan_pembelian' => 'required|string',
                'kuantitas_sub_permintaan_pembelian' => 'required|numeric',
                'harga_sub_permintaan_pembelian' => 'required|numeric',
                'keterangan_sub_permintaan_pembelian' => 'nullable|string',
            ]);

            $subAnggaran = SubAnggaran::findOrFail($validation['sub_anggaran_id']);

            if ($subAnggaran->anggaran_id !== $anggaran->id) {
                throw new \Exception('Sub Anggaran tidak sesuai dengan Anggaran Permintaan Pembelian.');
            }

            $validation['permintaanpembelian_id'] = $permintaan_Pembelian->id;
            $validation['total_sub_permintaan_pembelian'] = $validation['kuantitas_sub_permintaan_pembelian'] * $validation['harga_sub_permintaan_pembelian'];

            $kuantitasSubPermintaanPembelianLama = $subPermintaan_Pembelian->kuantitas_sub_permintaan_pembelian;
            $totalHargaSubPermintaanPembelianLama = $subPermintaan_Pembelian->total_sub_permintaan_pembelian;
            $kuantitasSubPermintaanPembelianBaru = $validation['kuantitas_sub_permintaan_pembelian'] - $kuantitasSubPermintaanPembelianLama;
            $totalHargaSubPermintaanPembelianBaru = $validation['total_sub_permintaan_pembelian'] - $totalHargaSubPermintaanPembelianLama;

            // Jika kuantitas dikurangi
            if ($kuantitasSubPermintaanPembelianBaru < 0) {
                // Tambahkan nilai yang dikurangi kembali ke anggaran
                $subAnggaran->kuantitas_anggaran += abs($kuantitasSubPermintaanPembelianBaru);
                $subAnggaran->total_anggaran += abs($totalHargaSubPermintaanPembelianBaru);
            } else {
                // Jika kuantitas ditambah, periksa apakah melebihi anggaran yang tersedia
                if (($subAnggaran->kuantitas_anggaran - $kuantitasSubPermintaanPembelianBaru < 0) ||
                    ($subAnggaran->total_anggaran - $totalHargaSubPermintaanPembelianBaru < 0)
                ) {
                    throw new \Exception('Kuantitas dan total harga permintaan melebihi kuantitas anggaran yang tersedia.');
                }
                // Kurangi anggaran jika kuantitas ditambah
                $subAnggaran->kuantitas_anggaran -= $kuantitasSubPermintaanPembelianBaru;
                $subAnggaran->total_anggaran -= $totalHargaSubPermintaanPembelianBaru;
            }

            $validation['sub_anggaran_id'] = $subAnggaran->id;
            $subPermintaan_Pembelian->update($validation);

            // Simpan perubahan pada anggaran
            $subAnggaran->save();

            return redirect()->route('permintaanPembelians.show', $permintaan_Pembelian)->with([
                notyf()->position('y', 'top')->success('Sub Permintaan Pembelian berhasil diperbarui dan anggaran diperbarui'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                notyf()->position('y', 'top')->error('Sub Permintaan Pembelian gagal diperbarui. ' . $e->getMessage())
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $subPermintaan_Pembelian = SubPermintaan_Pembelian::findOrFail($id);
            $kuantitasSubPermintaanPembelianLama = $subPermintaan_Pembelian->kuantitas_sub_permintaan_pembelian;
            $totalHargaSubPermintaanPembelianLama = $subPermintaan_Pembelian->total_sub_permintaan_pembelian;

            // Mengambil subAnggaran berdasarkan subAnggaran_id dari SubPermintaan_Pembelian
            $subAnggaran = SubAnggaran::findOrFail($subPermintaan_Pembelian->sub_anggaran_id);

            // Memastikan subAnggaran ditemukan
            if (!$subAnggaran) {
                throw new \Exception('Sub Anggaran tidak ditemukan.');
            }

            // Mengembalikan kuantitas dan total harga ke subAnggaran
            $subAnggaran->kuantitas_anggaran += $kuantitasSubPermintaanPembelianLama;
            $subAnggaran->total_anggaran += $totalHargaSubPermintaanPembelianLama;
            $subAnggaran->save();

            // Menghapus SubPermintaan_Pembelian
            $subPermintaan_Pembelian->delete();

            return redirect()->route('permintaanPembelians.show', $subPermintaan_Pembelian->permintaanPembelian)->with([
                notyf()->position('y', 'top')->success('Sub Permintaan Pembelian berhasil dihapus dan anggaran diperbarui'),
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                notyf()->position('y', 'top')->error('Sub Permintaan Pembelian gagal dihapus. ' . $th->getMessage())
            ]);
        }
    }
}
