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

    public static function boot()
    {
        parent::boot();

        // Event before creating a new model
        static::creating(function ($produk) {
            // Get the last Kode_Satuan from the database
            $lastKodeProduk = Produk::max('kode_produk');

            if ($lastKodeProduk) {
                // Increment and format as 6-digit string
                $nextKodeProduk = str_pad((int) $lastKodeProduk + 1, 6, '0', STR_PAD_LEFT);
            } else {
                // Start from 000001 if no records exist
                $nextKodeProduk = '000001';
            }

            // Assign it to the model
            $produk->kode_produk = $nextKodeProduk;
        });
    }
}
