<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'nama_transaksi',
    ];

    public function permintaanPembelian()
    {
        return $this->hasOne(Permintaan_Pembelian::class, 'transaksi_id');
    }
}
