<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $status = $_POST['status'];

    // Cek apakah data ada di gudang database
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password' AND status='$status'");
    
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['status'] = $status;
        header("Location: dashboard.php"); // Masuk ke dashboard jika benar
    } else {
        echo "<script>alert('Yah, Username, Password, atau Status salah!');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 350px;">
        <div class="text-center mb-4">
            <h4 class="mt-2 fw-bold">LOGIN</h4>
        </div>
        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" name="login" class="btn btn-dark w-50 me-2">Login</button>
                <button type="reset" class="btn btn-outline-secondary w-50">Reset</button>
            </div>
        </form>
        <div class="mt-3 text-center">
            <small>Belum punya akun? <a href="register.php" class="text-decoration-none">Daftar disini</a></small>
        </div>
    </div>
</body>
</html>
