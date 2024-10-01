<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan_Pembelian extends Model
{
    use HasFactory;
    protected $table = 'permintaan_pembelians';

    protected $fillable = [
        'anggaran_id',
        'nomor_pp',
        'tgl_pp',
        'tandatangan_pp',
    ];
    protected $casts = [
        'tandatangan_pp' => 'array',
    ];


    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class, 'anggaran_id');
    }

    public function subPermintaanPembelians()
    {
        return $this->hasMany(SubPermintaan_Pembelian::class, 'permintaanpembelian_id');
    }
}
