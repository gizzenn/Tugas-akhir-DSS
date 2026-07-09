<!DOCTYPE html>
<html>
<head><title>Login Pasien</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-primary-subtle p-5"><div class="container" style="max-width: 400px;"><div class="card p-4 shadow">
    <h4 class="text-center mb-4">Portal Login Pasien</h4>
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
    <form action="{{ url('/login/pasien') }}" method="POST"> @csrf
        <div class="mb-3"><label>Email Pasien</label><input type="email" name="email" class="form-control" required></div>
        <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
        <button class="btn btn-primary w-100">Masuk</button>
    </form>
</div></div></body>
</html>