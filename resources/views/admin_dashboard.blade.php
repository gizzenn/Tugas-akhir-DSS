<!DOCTYPE html>
<html>
<head>
    <title>Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container">
        <h2>Panel Verifikasi Admin (Antrean Pending)</h2>
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Nama</th><th>Pendapatan</th><th>Tagihan RS</th><th>Skor Fuzzy</th><th>Aksi Hitung</th><th>Keputusan Mutlak</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pasiens as $p)
                <tr>
                    <td>{{ $p->nama_pasien }}</td>
                    <td>Rp {{ number_format($p->pendapatan) }}</td>
                    <td>Rp {{ number_format($p->biaya_pengobatan) }}</td>
                    <td><span class="badge bg-info text-dark">{{ $p->skor_prioritas ? round($p->skor_prioritas, 2) : 'Belum Dihitung' }}</span></td>
                    <td>
                        <form action="{{ route('admin.hitung', $p->id) }}" method="POST">@csrf<button class="btn btn-sm btn-primary">Uji Fuzzy</button></form>
                    </td>
                    <td>
                        <form action="{{ route('admin.keputusan', [$p->id, 'Diterima']) }}" method="POST" style="display:inline;">@csrf<button class="btn btn-sm btn-success">Accept</button></form>
                        <form action="{{ route('admin.keputusan', [$p->id, 'Ditolak']) }}" method="POST" style="display:inline;">@csrf<button class="btn btn-sm btn-danger">Reject</button></form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('pasien.index') }}" class="btn btn-secondary">Kembali ke Form</a>
    </div>
</body>
</html>