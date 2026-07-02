<?php
namespace App\Http\Controllers;
use App\Models\Pasien;

class StaffController extends Controller {
    public function index() {
        $pasiens = Pasien::orderBy('skor_prioritas', 'DESC')->get();
        return view('staff_dashboard', compact('pasiens'));
    }
}