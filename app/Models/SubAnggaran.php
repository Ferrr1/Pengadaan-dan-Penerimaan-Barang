<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAnggaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'anggaran_id',
        'kel_anggaran_id',
        'no_detail',
        'produk_id',
        'kuantitas_anggaran',
        'harga_anggaran',
        'total_anggaran',
    ];

    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class, 'anggaran_id');
    }

    public function kelAnggaran()
    {
        return $this->belongsTo(Kel_Anggaran::class, 'kel_anggaran_id');
    }

    public function subPermintaanPembelians()
    {
        return $this->hasOne(SubPermintaan_Pembelian::class, 'sub_anggaran_id');
    }

    public function produks()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
