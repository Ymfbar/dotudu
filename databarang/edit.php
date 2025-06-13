<?php
require_once '../db.php';
include '../header.php';

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="alert alert-danger container mt-5">ID tidak valid.</div>';
    exit;
}

$id = intval($_GET['id']);

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $kategori_id = intval($_POST['kategori_id']);
    $harga = floatval($_POST['harga']);
    $stok = intval($_POST['stok']);

    if ($nama && $kategori_id && $harga >= 0 && $stok >= 0) {
        $stmt = $koneksi->prepare("UPDATE data_barang SET nama = ?, kategori_id = ?, harga = ?, stok = ? WHERE id = ?");
        $stmt->bind_param("sidii", $nama, $kategori_id, $harga, $stok, $id);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success container mt-4">Data barang berhasil diupdate.</div>';
            echo '<div class="container"><a href="index.php" class="btn btn-primary">Kembali ke Daftar Barang</a></div>';
            include '../footer.php';
            exit;
        } else {
            $error = "Gagal mengupdate data: " . $stmt->error;
        }
    } else {
        $error = "Silakan lengkapi semua data dengan benar.";
    }
}

// Ambil data barang dari DB
$stmt = $koneksi->prepare("SELECT * FROM data_barang WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo '<div class="alert alert-danger container mt-5">Data tidak ditemukan.</div>';
    exit;
}

// Ambil data kategori untuk dropdown
$kategori = $koneksi->query("SELECT * FROM kategori");
?>

<div class="container mt-5">
    <h3>Edit Data Barang</h3>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" name="nama" id="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select name="kategori_id" class="form-select" id="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>
                <?php while ($row = $kategori->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>" <?= ($data['kategori_id'] == $row['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['nama']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" name="harga" id="harga" value="<?= htmlspecialchars($data['harga']) ?>" min="0" required>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" name="stok" id="stok" value="<?= htmlspecialchars($data['stok']) ?>" min="0" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include '../footer.php'; ?>