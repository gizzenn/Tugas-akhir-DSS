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
        <div class="d-flex justify-content-between align-items-center mb-4">
    <span>Login sebagai: <strong>{{ auth()->user()->name }}</strong></span>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-sm btn-dark">Logout</button>
    </form>
    </div>
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
        
        <td>
            <span class="badge bg-info text-dark">
                {{ $p->skor_prioritas !== null ? round($p->skor_prioritas, 2) : 'Belum Dihitung' }}
            </span>
        </td>
        
        <td>
            @if($p->status_bantuan == 'Pending')
                <form action="{{ route('admin.hitung', $p->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-primary">Uji Fuzzy</button>
                </form>
            @else
                <span class="text-muted fw-bold">Selesai</span>
            @endif
        </td>
        
        <td>
            @if($p->status_bantuan == 'Pending')
                <form action="{{ route('admin.keputusan', [$p->id, 'Diterima']) }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-sm btn-success">Accept</button>
                </form>
                <form action="{{ route('admin.keputusan', [$p->id, 'Ditolak']) }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-sm btn-danger">Reject</button>
                </form>
            @else
                @if($p->status_bantuan == 'Diterima')
                    <span class="badge bg-success">Diterima</span>
                @else
                    <span class="badge bg-danger">Ditolak</span>
                @endif
            @endif
        </td>
    </tr>
@endforeach
</tbody>
        </table>
    </div>
</body>
</html>