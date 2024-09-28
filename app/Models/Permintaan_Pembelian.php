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

    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class);
    }
}
