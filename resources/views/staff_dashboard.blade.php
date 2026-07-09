<!DOCTYPE html>
<html>
<head>
    <title>Panel Staf</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container">
        <h2>Panel Pemantauan Staf (Perankingan DSS)</h2>
        <div class="d-flex justify-content-between align-items-center mb-4">
    <span>Login sebagai: <strong>{{ auth()->user()->name }}</strong></span>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-sm btn-dark">Logout</button>
    </form>
    </div>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Rank</th><th>Nama Pasien</th><th>Pendapatan</th><th>Tagihan RS</th><th>Skor Sistem</th><th>Status Bantuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pasiens as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->nama_pasien }}</td>
                    <td>Rp {{ number_format($p->pendapatan) }}</td>
                    <td>Rp {{ number_format($p->biaya_pengobatan) }}</td>
                    <td><strong>{{ $p->skor_prioritas ? round($p->skor_prioritas, 2) : '-' }}</strong></td>

                    <td><strong>{{ $p->skor_prioritas !== null ? round($p->skor_prioritas, 2) : '-' }}</strong></td>
                    <td>
                        @if($p->status_bantuan == 'Diterima') <span class="badge bg-success">Menerima Bantuan</span>
                        @elseif($p->status_bantuan == 'Ditolak') <span class="badge bg-danger">Tidak Menerima</span>
                        @else <span class="badge bg-warning text-dark">Antrean Seleksi</span> @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>