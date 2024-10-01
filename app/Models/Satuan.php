<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_satuan',
        'nama_satuan',
        'singkatan_satuan',
        'deskripsi_satuan',
    ];

    public function produks()
    {
        return $this->hasMany(Produk::class, 'satuan_id');
    }
}
