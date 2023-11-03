<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Uang extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_petani',
        'saldo',
    ];
    public function user() {
        return $this->belongsTo(User::class,'id_petani');
    }
    public function history_penarikan() {
        return $this->hasMany(HistoryPenarikan::class,'id_uang');
    }
    public function history_pemasukan() {
        return $this->hasMany(HistoryPengiriman::class,'id_uang');
    }
    public function updateSaldoPenarikan($nominal) {
        $this->saldo -= $nominal;
        $this->save();
    }

    public function updateSaldoPemasukan($nominal) {
        $this->saldo += $nominal;
        $this->save();
    }
}
