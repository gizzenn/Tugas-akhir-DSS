<!DOCTYPE html>
<html>
<head>
    <title>Form Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container" style="max-width: 600px;">
        <div class="card p-4 shadow">
            <h4 class="mb-4 text-center">Input Data Pasien Mandiri</h4>
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            <form action="{{ route('pasien.store') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin data yang diisi sudah benar? Data yang sudah dikirim akan langsung masuk ke antrean rumah sakit.');">
                @csrf
                <div class="mb-3"><label>Nama Pasien</label><input type="text" name="nama_pasien" class="form-control" required></div>
                <div class="mb-3"><label>Pendapatan Keluarga (Rp)</label><input type="number" name="pendapatan" class="form-control" required></div>
                <div class="mb-3"><label>Tagihan RS (Rp)</label><input type="number" name="biaya_pengobatan" class="form-control" required></div>
                <button type="submit" class="btn btn-primary w-100">Kirim Data</button>
            </form>
            <div class="text-center mt-3"><a href="{{ route('admin.index') }}">Ke Panel Admin</a> | <a href="{{ route('staff.index') }}">Ke Panel Staf</a></div>
        </div>
    </div>
</body>
</html>