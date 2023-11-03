<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPenarikan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_uang',
        'nominal_penarikan',
        'waktu_penarikan',
    ];
    
}
