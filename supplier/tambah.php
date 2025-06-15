<?php
require_once '../db.php';
include '../header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $kontak = trim($_POST['kontak']);
    $alamat = trim($_POST['alamat']);

    if (!empty($nama) && !empty($kontak) && !empty($alamat)) {
        // Ganti 'supplier' dengan nama tabel Anda jika berbeda
        $stmt = $koneksi->prepare("INSERT INTO supplier (nama, kontak, alamat) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $kontak, $alamat);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success container mt-4">Data supplier berhasil ditambahkan.</div>';
            echo '<div class="container"><a href="index.php" class="btn btn-primary">Kembali ke Daftar Supplier</a></div>';
            exit;
        } else {
            $error = "Gagal menyimpan data: " . $stmt->error;
        }
    } else {
        $error = "Semua field wajib diisi.";
    }
}
?>

<div class="container mt-5">
    <h3>Tambah Supplier</h3>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Supplier</label>
            <input type="text" class="form-control" name="nama" id="nama" required>
        </div>
        <div class="mb-3">
            <label for="kontak" class="form-label">Telepon</label>
            <input type="text" class="form-control" name="kontak" id="kontak" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include '../footer.php'; ?>