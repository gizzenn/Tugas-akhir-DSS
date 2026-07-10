<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Pasien Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); min-height: 100vh; }
        .card-custom { border-radius: 20px; box-shadow: 0 10px 25px rgba(2, 132, 199, 0.1); background-color: #ffffff; width: 100%; max-width: 520px; }
        .text-sky { color: #0284c7; }
        .bg-sky-light { background-color: #f0f9ff; }
        .btn-sky { background-color: #0284c7; color: white; border: none; border-radius: 10px; transition: all 0.3s; }
        .btn-sky:hover { background-color: #0369a1; color: white; }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center py-4">
    <div class="card card-custom border-0 p-4 m-3">
        <div class="text-center mb-4">
            <div class="d-inline-flex p-3 rounded-circle mb-2 bg-sky-light text-sky">
                <i class="bi bi-file-earmark-medical fs-3"></i>
            </div>
            <h4 class="fw-bold text-dark m-0">Input Data Pasien Mandiri</h4>
            <p class="text-muted small">Isi data kriteria ekonomi untuk pengajuan bantuan</p>
        </div>
        
        <!-- 1. MEMPERBAIKI ACTION MENUJU ROUTE STORE -->
        <form action="{{ route('pasien.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label small fw-semibold text-secondary">Nama Pasien</label>
                <!-- 2. MENAMBAHKAN name="nama_pasien" -->
                <input type="text" name="nama_pasien" class="form-control py-2.5" style="border-radius: 10px;" placeholder="Masukkan nama lengkap" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label small fw-semibold text-secondary">Pendapatan Keluarga (Rp)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary border-end-0" style="border-radius: 10px 0 0 10px;">Rp</span>
                    <!-- 3. MENAMBAHKAN name="pendapatan" -->
                    <input type="number" name="pendapatan" class="form-control border-start-0 py-2.5" style="border-radius: 0 10px 10px 0;" placeholder="Contoh angka: 1500000" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label small fw-semibold text-secondary">Tagihan RS / Biaya Pengobatan (Rp)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary border-end-0" style="border-radius: 10px 0 0 10px;">Rp</span>
                    <!-- 4. MENAMBAHKAN name="biaya_pengobatan" -->
                    <input type="number" name="biaya_pengobatan" class="form-control border-start-0 py-2.5" style="border-radius: 0 10px 10px 0;" placeholder="Contoh angka: 12000000" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-sky w-100 fw-bold py-2.5 shadow-sm">
                <i class="bi bi-send-fill me-2"></i>Kirim Data Pasien
            </button>
        </form>
        
        <div class="text-center pt-3 border-top border-light mt-4">
            <a href="{{ route('login.admin') }}" class="mx-2 small text-decoration-none fw-medium" style="color: #0284c7;">
                <i class="bi bi-shield-lock me-1"></i>Ke Panel Admin
            </a>
            <span class="text-muted">|</span>
            <a href="{{ route('login.staff') }}" class="mx-2 small text-decoration-none fw-medium" style="color: #0284c7;">
                <i class="bi bi-people me-1"></i>Ke Panel Staf
            </a>
        </div>
    </div>
</body>
</html>