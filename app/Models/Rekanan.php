<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_rekanan',
        'nama_rekanan',
        'alamat_rekanan',
        'telepon_rekanan',
        'email_rekanan',
        'status_rekanan',
        'tgl_bergabung',
        'tgl_akhir',
        'project_id',
    ];
}
