<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f9ff; min-height: 100vh; }
        .text-sky { color: #0284c7; }
        .badge-sky { background-color: #e0f2fe; color: #0369a1; }
    </style>
</head>
<body class="p-4">
    <div class="container-fluid p-0">
        <!-- HEADER DASHBOARD -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <i class="bi bi-speedometer2 text-sky fs-3 me-2"></i>
                <h4 class="fw-bold text-dark m-0">Dashboard Admin</h4>
            </div>
          
                
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1 px-3 py-2 fw-medium" style="border-radius: 50px;">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- NOTIFIKASI SUKSES -->
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4 text-success fw-medium" style="border-radius: 12px; background-color: #f0fdf4;">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- KARTU UTAMA TABEL -->
        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
            <h6 class="fw-bold text-dark mb-4 d-flex align-items-center">
                <span class="p-1.5 rounded-2 bg-warning bg-opacity-10 text-warning me-2 d-inline-flex">
                    <i class="bi bi-clock-history"></i>
                </span>
                Tabel Antrean Pasien
            </h6>
            
            <table class="table align-middle" style="border-color: #f1f5f9;">
                <thead style="background-color: #f8fafc;">
                    <tr class="text-secondary small text-uppercase">
                        <th class="py-3 px-3">No</th>
                        <th class="py-3">Nama Pasien</th>
                        <th class="py-3">Pendapatan</th>
                        <th class="py-3">Biaya Pengobatan</th>
                        <th class="py-3">Status</th>
                        <th class="py-3 text-center" style="width: 180px;">Analisis Fuzzy</th>
                        <th class="py-3 text-center" style="width: 200px;">Aksi Keputusan</th>
                    </tr>
                </thead>
                <tbody class="text-dark">
                    {{-- 1. MEMBUNGKUS BARIS TABEL DENGAN DATA ASLI DARI DATABASE --}}
                    @forelse($pasiens as $index => $pasien)
                        <tr>
                            <td class="px-3 fw-semibold text-secondary">{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $pasien->nama_pasien }}</td>
                            <td>Rp {{ number_format($pasien->pendapatan, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($pasien->biaya_pengobatan, 0, ',', '.') }}</td>
                            <td>
                                @if($pasien->status_bantuan == 'Diterima')
                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1.5 rounded">Diterima</span>
                                @elseif($pasien->status_bantuan == 'Ditolak')
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1.5 rounded">Ditolak</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1.5 rounded">Pending</span>
                                @endif
                            </td>
                            
                            <!-- KOLOM ANALISIS FUZZY -->
                            <td class="text-center">
                                @if($pasien->skor_prioritas !== null)
                                    <div class="d-flex flex-column align-items-center gap-1">
                                        <span class="badge px-3 py-2 fs-6 fw-bold text-sky" style="background-color: #e0f2fe; border-radius: 8px;">
                                            <i class="bi bi-cpu-fill me-1"></i> {{ number_format($pasien->skor_prioritas, 3) }}
                                        </span>
                                        <small class="text-muted" style="font-size: 0.75rem;">Skor Terhitung</small>
                                    </div>
                                @else
                                    <form action="{{ route('admin.hitung', ['id' => $pasien->id]) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-dark fw-medium px-3 py-1.5 rounded-3 w-100 shadow-sm">
                                            <i class="bi bi-cpu me-1"></i> Uji Cerdas Fuzzy
                                        </button>
                                    </form>
                                @endif
                            </td>
<!-- KOLOM AKSI KEPUTUSAN -->
<td class="text-center">
    <div class="d-flex gap-2 justify-content-center align-items-center">
        <!-- Form Tombol Accept -->
        <form action="{{ route('admin.keputusan', ['id' => $pasien->id, 'status' => 'Diterima']) }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-sm btn-success fw-medium px-3 py-1.5 rounded-3">Accept</button>
        </form>

        <!-- Form Tombol Reject -->
        <form action="{{ route('admin.keputusan', ['id' => $pasien->id, 'status' => 'Ditolak']) }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger fw-medium px-3 py-1.5 rounded-3">Reject</button>
        </form>
        
        <!-- TOMBOL HAPUS (BARU) -->
        <form action="{{ route('admin.pasien.hapus', ['id' => $pasien->id]) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pasien {{ $pasien->nama_pasien }} ini?')">
            @csrf
            @method('DELETE') {{-- Wajib menggunakan method DELETE sesuai standar Laravel --}}
            <button type="submit" class="btn btn-sm btn-danger fw-medium px-2.5 py-1.5 rounded-3" title="Hapus Pasien">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
</td>
                        </tr>
                    @empty
                        {{-- JIKA DATA DI DATABASE MASIH KOSONG --}}
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted small">
                                <i class="bi bi-folder-x fs-2 d-block mb-2 text-secondary"></i>
                                Belum ada data antrean pasien.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>