<?php

namespace App\Models;

use App\Models\Permintaan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_permintaan',
        'keterangan',
        'tgl_perubahan',
        'status',
    ];
    public function permintaan() {
        return $this->belongsTo(Permintaan::class,'id_permintaan','id');
    }
    public function jumlahPermintaanDiterima()
    {
        return $this->permintaan()->where('status', 'diterima')->count();
    }

    public function jumlahPermintaanDiproses()
    {
        return $this->permintaan()->where('status', 'diproses')->count();
    }
}
