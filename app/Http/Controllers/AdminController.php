<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Services\FuzzyService;

class AdminController extends Controller 
{
    protected $fuzzy;

    public function __construct(FuzzyService $fuzzy) 
    { 
        $this->fuzzy = $fuzzy; 
    }
    
    // 1. FUNGSI UTAMA UNTUK MENAMPILKAN DASHBOARD & DATA PASIEN (WAJIB ADA)
    public function index() 
    {
        // Memanggil semua data pasien, diurutkan dari yang terbaru
        $pasiens = Pasien::query()->orderBy('created_at', 'DESC')->get();
        
        return view('admin_dashboard', compact('pasiens'));
    }

    // 2. FUNGSI UNTUK MENGHITUNG SKOR FUZZY
    public function hitung($id) 
    {
        $pasien = Pasien::findOrFail($id);
        $skor = $this->fuzzy->hitungSkor($pasien->pendapatan, $pasien->biaya_pengobatan);
        $pasien->update(['skor_prioritas' => $skor]);
        
        return redirect()->back()->with('success', 'Skor Fuzzy berhasil dihitung!');
    }

    // 3. FUNGSI UNTUK MENYIMPAN KEPUTUSAN (Diterima / Ditolak)
    public function keputusan($id, $status) 
    {
        Pasien::findOrFail($id)->update(['status_bantuan' => $status]);
        
        return redirect()->back()->with('success', 'Keputusan berhasil disimpan!');
    }

    // Fungsi baru untuk menghapus data pasien
    public function destroy($id) 
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();
        
        return redirect()->back()->with('success', 'Data pasien ' . $pasien->nama_pasien . ' berhasil dihapus dari sistem!');
    }
}