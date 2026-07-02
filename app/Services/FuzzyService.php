<?php

namespace App\Services;

class FuzzyService
{
    public function muPendapatan($nilai) {
        $mu = ['rendah' => 0, 'sedang' => 0, 'tinggi' => 0];
        if ($nilai <= 1000000) $mu['rendah'] = 1;
        elseif ($nilai > 1000000 && $nilai < 2500000) $mu['rendah'] = (2500000 - $nilai) / (2500000 - 1000000);
        if ($nilai > 1500000 && $nilai <= 2500000) $mu['sedang'] = ($nilai - 1500000) / (2500000 - 1500000);
        elseif ($nilai > 2500000 && $nilai < 3500000) $mu['sedang'] = (3500000 - $nilai) / (3500000 - 2500000);
        if ($nilai > 2500000 && $nilai < 4000000) $mu['tinggi'] = ($nilai - 2500000) / (4000000 - 2500000);
        elseif ($nilai >= 4000000) $mu['tinggi'] = 1;
        return $mu;
    }

    public function muBiaya($nilai) {
        $mu = ['kecil' => 0, 'sedang' => 0, 'besar' => 0];
        if ($nilai <= 3000000) $mu['kecil'] = 1;
        elseif ($nilai > 3000000 && $nilai < 5000000) $mu['kecil'] = (5000000 - $nilai) / (5000000 - 3000000);
        if ($nilai > 3000000 && $nilai <= 6000000) $mu['sedang'] = ($nilai - 3000000) / (6000000 - 3000000);
        elseif ($nilai > 6000000 && $nilai < 9000000) $mu['sedang'] = (9000000 - $nilai) / (9000000 - 6000000);
        if ($nilai > 7000000 && $nilai < 10000000) $mu['besar'] = ($nilai - 7000000) / (10000000 - 7000000);
        elseif ($nilai >= 10000000) $mu['besar'] = 1;
        return $mu;
    }

    public function hitungSkor($pendapatan, $biaya) {
        $muP = $this->muPendapatan($pendapatan);
        $muB = $this->muBiaya($biaya);
        $rules = [];

        // R1 s/d R9 Sesuai Aturan di Bab 2 & 3 Laporan
        $a1 = min($muP['tinggi'], $muB['kecil']); $rules[] = ['alpha' => $a1, 'z' => 50 - ($a1 * 50)];
        $a2 = min($muP['tinggi'], $muB['sedang']); $rules[] = ['alpha' => $a2, 'z' => 50 - ($a2 * 50)];
        $a3 = min($muP['tinggi'], $muB['besar']); $rules[] = ['alpha' => $a3, 'z' => 50 + ($a3 * 50)];
        $a4 = min($muP['sedang'], $muB['kecil']); $rules[] = ['alpha' => $a4, 'z' => 50 - ($a4 * 50)];
        $a5 = min($muP['sedang'], $muB['sedang']); $rules[] = ['alpha' => $a5, 'z' => 50 + ($a5 * 50)];
        $a6 = min($muP['sedang'], $muB['besar']); $rules[] = ['alpha' => $a6, 'z' => 50 + ($a6 * 50)];
        $a7 = min($muP['rendah'], $muB['kecil']); $rules[] = ['alpha' => $a7, 'z' => 50 - ($a7 * 50)];
        $a8 = min($muP['rendah'], $muB['sedang']); $rules[] = ['alpha' => $a8, 'z' => 50 + ($a8 * 50)];
        $a9 = min($muP['rendah'], $muB['besar']); $rules[] = ['alpha' => $a9, 'z' => 50 + ($a9 * 50)];

        $total_alpha = 0; $total_az = 0;
        foreach ($rules as $r) {
            $total_alpha += $r['alpha'];
            $total_az += ($r['alpha'] * $r['z']);
        }
        return $total_alpha == 0 ? 50 : $total_az / $total_alpha;
    }
}