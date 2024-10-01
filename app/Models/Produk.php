<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'harga_produk',
        'satuan_id',
    ];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }

    public function subPermintaanPembelian()
    {
        return $this->hasMany(SubPermintaan_Pembelian::class, 'produk_id');
    }

    public function subAnggarans()
    {
        return $this->hasMany(SubAnggaran::class, 'produk_id');
    }
}
