<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_petani',
        'id_koperasi',
        'name',
        'description',
        'kategori',
        'harga',
        'berat',
        'jumlah',
        'durasi_tahan',
        'foto',
    ];
    public function status() {
        return $this->hasMany(Status::class,'id_permintaan');
    }
    public function petani()
    {
        return $this->belongsTo(User::class, 'id_petani', 'id');
    }
    public function koperasi()
    {
        return $this->belongsTo(User::class, 'id_koperasi', 'id');
    }
 
}
