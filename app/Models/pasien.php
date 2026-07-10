<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    // Pastikan array ini ditutup dengan rapi menggunakan ]; tanpa ada karakter <
    protected $fillable = [
        'nama_pasien',
        'pendapatan',
        'biaya_pengobatan',
        'skor_prioritas',
        'status_bantuan'
    ];
}