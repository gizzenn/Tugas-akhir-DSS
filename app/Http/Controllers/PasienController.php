<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pasien;

class PasienController extends Controller {
    public function index() { return view('form_pasien'); }
    public function store(Request $request) {
        $request->validate([
            'nama_pasien' => 'required',
            'pendapatan' => 'required|numeric',
            'biaya_pengobatan' => 'required|numeric',
        ]);
        Pasien::create($request->all());
        return redirect()->back()->with('success', 'Data berhasil dikirim ke antrean Admin!');
    }
}