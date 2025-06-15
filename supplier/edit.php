<?php
require_once '../db.php';
include '../header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="alert alert-danger container mt-5">ID tidak valid.</div>';
    exit;
}
$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $kontak = trim($_POST['kontak']);
    $alamat = trim($_POST['alamat']);

    if (!empty($nama) && !empty($kontak) && !empty($alamat)) {
        $stmt = $koneksi->prepare("UPDATE supplier SET nama = ?, kontak = ?, alamat = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nama, $kontak, $alamat, $id);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success container mt-4">Data berhasil diupdate.</div>';
            echo '<div class="container"><a href="index.php" class="btn btn-primary">Kembali</a></div>';
            exit;
        } else {
            $error = "Gagal memperbarui data: " . $stmt->error;
        }
    } else {
        $error = "Semua field wajib diisi.";
    }
}

$stmt = $koneksi->prepare("SELECT * FROM supplier WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo '<div class="alert alert-danger container mt-5">Data tidak ditemukan.</div>';
    exit;
}
?>

<div class="container mt-5">
    <h3>Edit Supplier</h3>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Supplier</label>
            <input type="text" class="form-control" name="nama" id="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="kontak" class="form-label">Telepon</label>
            <input type="text" class="form-control" name="kontak" id="kontak" value="<?= htmlspecialchars($data['kontak']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat" rows="3" required><?= htmlspecialchars($data['alamat']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include '../footer.php'; ?>