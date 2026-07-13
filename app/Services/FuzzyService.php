<?php

namespace App\Services;

class FuzzyService 
{
    // ==========================================
    // 1. FUZZIFIKASI PENDAPATAN PASIEN (BAB 2.1)
    // ==========================================
    public function muPendapatan($nilai) {
        $mu = ['rendah' => 0, 'sedang' => 0, 'tinggi' => 0];
        
        // Rendah: Rp 0 - Rp 2.500.000 (Kurva Turun)
        if ($nilai <= 1000000) $mu['rendah'] = 1;
        elseif ($nilai > 1000000 && $nilai < 2500000) $mu['rendah'] = (2500000 - $nilai) / (2500000 - 1000000);
        
        // Sedang: Rp 2.500.000 - Rp 5.500.000 (Kurva Segitiga)
        if ($nilai > 2500000 && $nilai <= 4000000) $mu['sedang'] = ($nilai - 2500000) / (4000000 - 2500000);
        elseif ($nilai > 4000000 && $nilai < 5500000) $mu['sedang'] = (5500000 - $nilai) / (5500000 - 4000000);
        
        // Tinggi: Lebih dari Rp 5.500.000 (Kurva Naik)
        if ($nilai > 5500000 && $nilai < 7000000) $mu['tinggi'] = ($nilai - 5500000) / (7000000 - 5500000);
        elseif ($nilai >= 7000000) $mu['tinggi'] = 1;
        
        return $mu;
    }

    // ==========================================
    // 2. REVISI DI SINI: FUZZIFIKASI BIAYA PENGOBATAN (BAB 2.2)
    // ==========================================
    public function muBiaya($nilai) {
        $mu = ['kecil' => 0, 'sedang' => 0, 'besar' => 0];
        
        // Kecil: Rp 0 - Rp 3.000.000 (Kurva Turun)
        if ($nilai <= 1500000) $mu['kecil'] = 1;
        elseif ($nilai > 1500000 && $nilai < 3000000) $mu['kecil'] = (3000000 - $nilai) / (3000000 - 1500000);
        
        // Sedang: Rp 3.000.000 - Rp 7.000.000 (Kurva Segitiga Berubah Rentang)
        if ($nilai > 3000000 && $nilai <= 5000000) $mu['sedang'] = ($nilai - 3000000) / (5000000 - 3000000);
        elseif ($nilai > 5000000 && $nilai < 7000000) $mu['sedang'] = (7000000 - $nilai) / (7000000 - 5000000);
        
        // Besar: Lebih dari Rp 8.000.000 (Mulai Naik dari Rp 8 Juta)
        if ($nilai > 8000000 && $nilai < 12000000) $mu['besar'] = ($nilai - 8000000) / (12000000 - 8000000);
        elseif ($nilai >= 12000000) $mu['besar'] = 1;
        
        return $mu;
    }

    // =======================================================
    // 3. INFERENSI & DEFUZZIFIKASI SKOR PRIORITAS (BAB 2.3)
    // =======================================================
    public function hitungSkor($pendapatan, $biaya) {
        $muP = $this->muPendapatan($pendapatan);
        $muB = $this->muBiaya($biaya);
        $rules = [];

        // Penyesuaian Formula Z berdasarkan Rentang Skor Baru (Rendah: skala 30, Cukup: skala 40-70, Sangat: skala 80-100)
        
        // R1: Tinggi & Kecil -> Rendah (0-30)
        $a1 = min($muP['tinggi'], $muB['kecil']);  $rules[] = ['alpha' => $a1, 'z' => 30 - ($a1 * 30)];
        // R2: Tinggi & Sedang -> Rendah (0-30)
        $a2 = min($muP['tinggi'], $muB['sedang']); $rules[] = ['alpha' => $a2, 'z' => 30 - ($a2 * 30)];
        // R3: Tinggi & Besar -> Cukup Prioritas (40-70)
        $a3 = min($muP['tinggi'], $muB['besar']);  $rules[] = ['alpha' => $a3, 'z' => 40 + ($a3 * 30)]; 
        
        // R4: Sedang & Kecil -> Rendah (0-30)
        $a4 = min($muP['sedang'], $muB['kecil']);  $rules[] = ['alpha' => $a4, 'z' => 30 - ($a4 * 30)];
        // R5: Sedang & Sedang -> Cukup Prioritas (40-70)
        $a5 = min($muP['sedang'], $muB['sedang']); $rules[] = ['alpha' => $a5, 'z' => 40 + ($a5 * 30)];
        // R6: Sedang & Besar -> Sangat Prioritas (80-100)
        $a6 = min($muP['sedang'], $muB['besar']);  $rules[] = ['alpha' => $a6, 'z' => 80 + ($a6 * 20)]; 
        
        // R7: Rendah & Kecil -> Cukup Prioritas (40-70)
        $a7 = min($muP['rendah'], $muB['kecil']);  $rules[] = ['alpha' => $a7, 'z' => 40 + ($a7 * 30)]; 
        // R8: Rendah & Sedang -> Sangat Prioritas (80-100)
        $a8 = min($muP['rendah'], $muB['sedang']); $rules[] = ['alpha' => $a8, 'z' => 80 + ($a8 * 20)];
        // R9: Rendah & Besar -> Sangat Prioritas (80-100)
        $a9 = min($muP['rendah'], $muB['besar']);  $rules[] = ['alpha' => $a9, 'z' => 80 + ($a9 * 20)];

        $total_alpha = 0; $total_az = 0;
        foreach ($rules as $r) {
            $total_alpha += $r['alpha'];
            $total_az += ($r['alpha'] * $r['z']);
        }
        
        return $total_alpha == 0 ? 50 : $total_az / $total_alpha;
    }
}