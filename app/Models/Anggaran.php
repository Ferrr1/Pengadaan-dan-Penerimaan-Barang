<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'kel_anggaran_id',
        'kode_anggaran_project',
        'nama_anggaran_project',
        'kel_anggaran_project',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function kelAnggaran()
    {
        return $this->hasOne(Kel_Anggaran::class);
    }

    public function subAnggarans()
    {
        return $this->hasMany(SubAnggaran::class);
    }
}
