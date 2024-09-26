<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kel_Anggaran extends Model
{
    use HasFactory;
    protected $table = 'kel_anggarans';
    protected $fillable = [
        'kode_kel_anggaran',
        'nama_kel_anggaran',
    ];

    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class);
    }
}
