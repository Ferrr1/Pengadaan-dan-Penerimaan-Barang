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
        'kode_anggaran',
        'nama_anggaran',
        'kel_anggaran',
        'satuan_id',
        'kuantitas_anggaran',
        'harga_anggaran',
        'total_anggaran',
    ];

    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class);
    }

    public function kelAnggaran()
    {
        return $this->hasOne(Kel_Anggaran::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
}
