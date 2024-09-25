<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_project',
        'nama_project',
        'tgl_mulai',
        'status_project',
    ];

    public function anggaran()
    {
        return $this->hasOne(Anggaran::class);
    }
}
