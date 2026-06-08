<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['status'] == 'Admin') {
    if(isset($_GET['hapus'])){
        $id_hapus = $_GET['hapus'];
        mysqli_query($koneksi, "DELETE FROM users WHERE id='$id_hapus'");
        header("Location: dashboard.php");
    }

    if(isset($_POST['tambah_user'])){
        $user_baru = $_POST['username_baru'];
        $pass_baru = $_POST['password_baru'];
        $status_baru = $_POST['status_baru'];
        
        mysqli_query($koneksi, "INSERT INTO users (username, password, status) VALUES ('$user_baru', '$pass_baru', '$status_baru')");
        header("Location: dashboard.php");
    }

    if(isset($_POST['ubah_user'])){
        $id_ubah = $_POST['id_user'];
        $user_ubah = $_POST['username_ubah'];
        $pass_ubah = $_POST['password_ubah'];
        $status_ubah = $_POST['status_ubah'];
        
        mysqli_query($koneksi, "UPDATE users SET username='$user_ubah', password='$pass_ubah', status='$status_ubah' WHERE id='$id_ubah'");
        header("Location: dashboard.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm px-4 py-3 mb-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="#">SISTEM APLIKASI</a>
            <div class="d-flex align-items-center">
                <span class="me-3 fw-semibold">Halo, <?= $_SESSION['username']; ?> (<?= $_SESSION['status']; ?>)</span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="p-4 mb-4 bg-white rounded shadow-sm border">
            <h4 class="fw-bold">Selamat datang, <?= $_SESSION['username']; ?>!</h4>
            <p class="text-muted mb-0">
                <?php if($_SESSION['status'] == 'Admin') { ?>
                    Kelola data pengguna dengan mudah. Anda memiliki akses penuh.
                <?php } else { ?>
                    Anda login sebagai User biasa. Anda hanya dapat melihat data ini.
                <?php } ?>
            </p>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold text-primary">Data Users</h5>
                
                <?php if($_SESSION['status'] == 'Admin') { ?>
                <button class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#formTambah">
                    + Tambah User
                </button>
                <?php } ?>
            </div>
            
            <div class="card-body">
                <?php if($_SESSION['status'] == 'Admin') { ?>
                <div class="collapse mb-4" id="formTambah">
                    <div class="card card-body bg-light border-0">
                        <h6 class="fw-bold mb-3 text-success">Form Tambah User</h6>
                        <form method="POST" class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="username_baru" class="form-control" placeholder="Username Baru" required>
                            </div>
                            <div class="col-md-3">
                                <input type="password" name="password_baru" class="form-control" placeholder="Password Baru" required>
                            </div>
                            <div class="col-md-3">
                                <select name="status_baru" class="form-select" required>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" name="tambah_user" class="btn btn-success w-100">Simpan User</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php } ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Dibuat Pada</th>
                                <?php if($_SESSION['status'] == 'Admin') { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $data_users = mysqli_query($koneksi, "SELECT * FROM users");
                            while($u = mysqli_fetch_array($data_users)) { 
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $u['username']; ?></td>
                                <td>
                                    <?php if($u['status'] == 'Admin') { ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-3 py-2 rounded-pill">Admin</span>
                                    <?php } else { ?>
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-3 py-2 rounded-pill">User</span>
                                    <?php } ?>
                                </td>
                                <td class="text-muted"><?= $u['dibuat_pada']; ?></td>
                                
                                <?php if($_SESSION['status'] == 'Admin') { ?>
                                <td>
                                    <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $u['id']; ?>">Edit</button>
                                    <a href="?hapus=<?= $u['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah kamu yakin ingin menghapus user ini?')">Hapus</a>
                                </td>
                                <?php } ?>
                            </tr>

                            <?php if($_SESSION['status'] == 'Admin') { ?>
                            <div class="modal fade" id="modalEdit<?= $u['id']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Ubah Data User</h5>
                                            <button type="button" class="btn-close" data-bs-shadow="none" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_user" value="<?= $u['id']; ?>">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Username</label>
                                                    <input type="text" name="username_ubah" class="form-control" value="<?= $u['username']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Password Baru</label>
                                                    <input type="password" name="password_ubah" class="form-control" value="<?= $u['password']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status_ubah" class="form-select">
                                                        <option value="Admin" <?= $u['status'] == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                                                        <option value="User" <?= $u['status'] == 'User' ? 'selected' : ''; ?>>User</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" name="ubah_user" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
