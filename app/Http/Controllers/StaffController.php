<?php

namespace App\Http\Controllers;

use App\Models\Pasien;

class StaffController extends Controller {
    public function index() {
        // Menambahkan filter where agar hanya status 'Diterima' yang muncul di staf
        $pasiens = Pasien::where('status_bantuan', 'Diterima')
                         ->orderBy('skor_prioritas', 'DESC')
                         ->get();

        return view('staff_dashboard', compact('pasiens'));
    }
}