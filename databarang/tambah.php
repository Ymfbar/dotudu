<?php
require_once '../db.php';
include '../header.php';

// Ambil data kategori untuk dropdown
$kategori = $koneksi->query("SELECT * FROM kategori");

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $kategori_id = intval($_POST['kategori_id']);
    $harga = floatval($_POST['harga']);
    $stok = intval($_POST['stok']);

    if ($nama && $kategori_id && $harga >= 0 && $stok >= 0) {
        $stmt = $koneksi->prepare("INSERT INTO data_barang (nama, kategori_id, harga, stok) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sidi", $nama, $kategori_id, $harga, $stok);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success container mt-4">Data barang berhasil ditambahkan.</div>';
            echo '<div class="container"><a href="index.php" class="btn btn-primary">Kembali ke Daftar Barang</a></div>';
            exit;
        } else {
            $error = "Gagal menyimpan data: " . $stmt->error;
        }
    } else {
        $error = "Silakan lengkapi semua data dengan benar.";
    }
}
?>

<div class="container mt-5">
    <h3>Tambah Data Barang</h3>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" name="nama" id="nama" required>
        </div>

        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select name="kategori_id" class="form-select" id="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>
                <?php while ($row = $kategori->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nama']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" name="harga" id="harga" min="0" required>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" name="stok" id="stok" min="0" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
