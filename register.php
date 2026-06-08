<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 350px;">
        <div class="text-center mb-4">
            <h4 class="mt-2 fw-bold">REGISTER</h4>
        </div>
        <form>
            <div class="mb-3">
                <label>Username</label>
                <input type="text" class="form-control" placeholder="Masukkan username">
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" class="form-control" placeholder="Masukkan password">
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select class="form-control">
                    <option>Admin</option>
                    <option>User</option>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" onclick="alert('Tombol register sengaja dimatikan sesuai instruksi soal UTS.')" class="btn btn-dark w-50 me-2">Register</button>
                <button type="reset" class="btn btn-outline-secondary w-50">Reset</button>
            </div>
        </form>
        <div class="mt-3 text-center">
            <small>Sudah punya akun? <a href="login.php" class="text-decoration-none">Masuk disini</a></small>
        </div>
    </div>
</body>
</html>
