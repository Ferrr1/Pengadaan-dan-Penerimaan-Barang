<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPermintaan_Pembelian extends Model
{
    use HasFactory;
    protected $table = 'sub_permintaan_pembelian';
    protected $fillable = [
        'permintaanpembelian_id',
        'sub_anggaran_id',
        'produk_id',
        'spesifikasi_sub_permintaan_pembelian',
        'kuantitas_sub_permintaan_pembelian',
        'harga_sub_permintaan_pembelian',
        'total_sub_permintaan_pembelian',
        'keterangan_sub_permintaan_pembelian',
    ];

    public function permintaanPembelian()
    {
        return $this->belongsTo(Permintaan_Pembelian::class, 'permintaanpembelian_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
    public function subAnggaran()
    {
        return $this->belongsTo(SubAnggaran::class, 'sub_anggaran_id');
    }
}
