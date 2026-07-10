<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); min-height: 100vh; }
        .card-custom { border-radius: 20px; box-shadow: 0 10px 25px rgba(2, 132, 199, 0.1); background-color: #ffffff; max-width: 420px; width: 100%; }
        .text-sky { color: #0284c7; }
        .bg-sky-light { background-color: #f0f9ff; }
        .btn-sky { background-color: #0284c7; color: white; border: none; border-radius: 12px; transition: all 0.3s; }
        .btn-sky:hover { background-color: #0369a1; color: white; transform: translateY(-1px); }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center py-5">
    <div class="card card-custom border-0 p-4 mx-3">
        <div class="text-center mb-4">
            <div class="d-inline-flex p-3 rounded-circle mb-2 bg-sky-light text-sky">
                <i class="bi bi-shield-lock fs-3"></i>
            </div>
            <h4 class="fw-bold text-dark m-0">Login Pasien</h4>
            <p class="text-muted small">Sistem Pendukung Keputusan RS</p>
        </div>
        
        <form action="#" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold text-secondary">Email / Username</label>
                <input type="text" class="form-control py-2.5" style="border-radius: 10px;" placeholder="Masukkan akun" required>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-semibold text-secondary">Password</label>
                <input type="password" class="form-control py-2.5" style="border-radius: 10px;" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-sky w-100 fw-bold py-2.5 shadow-sm mb-3">
                Masuk Ke Sistem
            </button>
        </form>
    </div>
</body>
</html>