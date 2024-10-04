<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubOrderPembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'orderpembelian_id',
        'sub_permintaanpembelian_id',
        'ppn_sub_order_pembelian',
        'kuantitas_sub_order_pembelian',
        'total_sub_order_pembelian',
        'catatan_sub_order_pembelian',
    ];

    public function orderPembelian()
    {
        return $this->belongsTo(OrderPembelian::class, 'orderpembelian_id');
    }

    public function subPermintaanPembelian()
    {
        return $this->belongsTo(SubPermintaan_Pembelian::class, 'sub_permintaanpembelian_id');
    }
}
