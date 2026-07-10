<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Staff</title>
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
                <h4 class="fw-bold text-dark m-0">Dashboard Staf</h4>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge badge-sky px-3 py-2 fs-6 fw-semibold rounded-pill">Menu Verifikasi</span>
                
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1 px-3 py-2 fw-medium" style="border-radius: 50px;">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- KARTU UTAMA TABEL -->
        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
            <h6 class="fw-bold text-dark mb-4 d-flex align-items-center">
                <span class="p-1.5 rounded-2 bg-success bg-opacity-10 text-success me-2 d-inline-flex">
                    <i class="bi bi-trophy"></i>
                </span>
                Hasil Perankingan & Keputusan Akhir
            </h6>
            
            <div class="table-responsive">
                <table class="table align-middle" style="border-color: #f1f5f9;">
                    <thead style="background-color: #f8fafc;">
                        <tr class="text-secondary small text-uppercase">
                            <th class="py-3 px-3 text-center" style="width: 100px;">Peringkat</th>
                            <th class="py-3">Nama Pasien</th>
                            <th class="py-3">Pendapatan</th>
                            <th class="py-3">Biaya Pengobatan</th>
                            <th class="py-3 text-center" style="width: 150px;">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark">
                        @forelse($pasiens as $index => $pasien)
                            <tr>
                                <td class="px-3 text-center fw-semibold text-secondary">{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $pasien->nama_pasien }}</td>
                                <td>Rp {{ number_format($pasien->pendapatan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($pasien->biaya_pengobatan, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($pasien->status_bantuan == 'Diterima')
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 fw-semibold rounded-pill d-inline-block w-100">Diterima</span>
                                    @elseif($pasien->status_bantuan == 'Ditolak')
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 fw-semibold rounded-pill d-inline-block w-100">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 fw-semibold rounded-pill d-inline-block w-100">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">
                                    Belum ada data pasien di dalam database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>