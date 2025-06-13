<?php
require_once '../db.php';
include '../header.php';

$data_barang = $koneksi->query("SELECT id, nama FROM data_barang");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $barang_id = intval($_POST['barang_id']);
    $jumlah = intval($_POST['jumlah']);
    $keterangan = trim($_POST['keterangan']);

    if ($barang_id && $jumlah > 0 && !empty($tanggal)) {
        $koneksi->begin_transaction();
        try {
            // Insert ke tabel barang_masuk
            $stmt1 = $koneksi->prepare("INSERT INTO barang_masuk (tanggal, barang_id, jumlah, keterangan) VALUES (?, ?, ?, ?)");
            $stmt1->bind_param("siis", $tanggal, $barang_id, $jumlah, $keterangan);
            $stmt1->execute();

            // Update stok di data_barang
            $stmt2 = $koneksi->prepare("UPDATE data_barang SET stok = stok + ? WHERE id = ?");
            $stmt2->bind_param("ii", $jumlah, $barang_id);
            $stmt2->execute();

            $koneksi->commit();
            echo '<div class="alert alert-success container mt-4">Data barang masuk berhasil disimpan. Stok telah diperbarui.</div>';
            echo '<div class="container"><a href="index.php" class="btn btn-primary">Kembali</a></div>';
            exit;
        } catch (mysqli_sql_exception $exception) {
            $koneksi->rollback();
            $error = "Gagal menyimpan data: " . $exception->getMessage();
        }
    } else {
        $error = "Data tidak lengkap atau tidak valid.";
    }
}
?>

<div class="container mt-5">
    <h3>Tambah Barang Masuk</h3>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Masuk</label>
            <input type="date" class="form-control" name="tanggal" id="tanggal" required>
        </div>
        <div class="mb-3">
            <label for="barang_id" class="form-label">Nama Barang</label>
            <select class="form-control" name="barang_id" id="barang_id" required>
                <option value="">-- Pilih Barang --</option>
                <?php while ($row = $data_barang->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nama']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" name="jumlah" id="jumlah" min="1" required>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" class="form-control" name="keterangan" id="keterangan">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include '../footer.php'; ?>