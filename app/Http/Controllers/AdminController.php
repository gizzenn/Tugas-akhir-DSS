<?php
namespace App\Http\Controllers;
use App\Models\Pasien;
use App\Services\FuzzyService;

class AdminController extends Controller {
    protected $fuzzy;
    public function __construct(FuzzyService $fuzzy) { $this->fuzzy = $fuzzy; }
    
    public function index() {
        $pasiens = Pasien::where('status_bantuan', 'Pending')->get();
        return view('admin_dashboard', compact('pasiens'));
    }
    public function hitung($id) {
        $pasien = Pasien::findOrFail($id);
        $skor = $this->fuzzy->hitungSkor($pasien->pendapatan, $pasien->biaya_pengobatan);
        $pasien->update(['skor_prioritas' => $skor]);
        return redirect()->back()->with('success', 'Skor Fuzzy berhasil dihitung!');
    }
    public function keputusan($id, $status) {
        Pasien::findOrFail($id)->update(['status_bantuan' => $status]);
        return redirect()->back()->with('success', 'Keputusan berhasil disimpan!');
    }
}