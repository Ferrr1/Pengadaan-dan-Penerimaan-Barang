<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'permintaanpembelian_id',
        'rekanan_id',
        'nomor_op',
        'tgl_op',
        'tandatangan_op',
    ];

    protected $casts = [
        'tandatangan_op' => 'array',
    ];

    public function rekanan()
    {
        return $this->belongsTo(Rekanan::class, "rekanan_id");
    }

    public function permintaanpembelian()
    {
        return $this->belongsTo(Permintaan_Pembelian::class, "permintaanpembelian_id");
    }

    public function subOrderPembelians()
    {
        return $this->hasMany(SubOrderPembelian::class, 'orderpembelian_id');
    }
}
