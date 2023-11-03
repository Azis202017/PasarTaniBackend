<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPengiriman extends Model
{
    use HasFactory;
    protected $table = 'history_pengiriman';
    protected $fillable = [
        'id_uang',
        'nominal_pengiriman',
        'waktu_pengiriman',
    ];
}
