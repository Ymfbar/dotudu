<?php
require_once '../db.php';
include '../header.php';

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="alert alert-danger container mt-5">ID tidak valid.</div>';
    exit;
}

$id = intval($_GET['id']);

// Ambil data dari DB
$stmt = $koneksi->prepare("SELECT * FROM kategori WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// if (!$data) {
//     echo '<div class="alert alert-danger container mt-5">Data tidak ditemukan.</div>';
//     exit;
// }

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);

    if ($nama == '') {
        $error = "Nama kategori tidak boleh kosong.";
    } else {
        $update = $koneksi->prepare("UPDATE kategori SET nama = ? WHERE id = ?");
        $update->bind_param("si", $nama, $id);
        if ($update->execute()) {
            echo '<div class="alert alert-success container mt-4">Data berhasil diupdate.</div>';
            echo '<div class="container"><a href="index.php" class="btn btn-primary">Kembali</a></div>';
            exit;
        } else {
            $error = "Gagal memperbarui data: " . $update->error;
        }
    }
}
?>

<div class="container mt-5">
    <h3>Edit Kategori</h3>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" name="nama" id="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
