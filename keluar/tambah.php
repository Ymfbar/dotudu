<?php
require_once '../db.php';
include '../header.php';

$data_barang = $koneksi->query("SELECT id, nama, stok FROM data_barang");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $barang_id = intval($_POST['barang_id']);
    $qty = intval($_POST['qty']);
    $no_seri = trim($_POST['no_seri']); // BARIS BARU: Mengambil data no_seri dari form
    $keterangan = trim($_POST['keterangan']);

    if ($barang_id && $qty > 0 && !empty($tanggal)) {
        // Cek stok cukup
        $cek_stok_res = $koneksi->query("SELECT stok FROM data_barang WHERE id = $barang_id");
        $stok_saat_ini = $cek_stok_res->fetch_assoc()['stok'];

        if ($stok_saat_ini >= $qty) {
            $koneksi->begin_transaction();
            try {
                // Insert ke tabel keluar (query telah diubah)
                $stmt1 = $koneksi->prepare("INSERT INTO keluar (tanggal, barang_id, qty, no_seri, keterangan) VALUES (?, ?, ?, ?, ?)");
                $stmt1->bind_param("siiss", $tanggal, $barang_id, $qty, $no_seri, $keterangan); // Bind parameter baru
                $stmt1->execute();

                // Kurangi stok di data_barang
                $stmt2 = $koneksi->prepare("UPDATE data_barang SET stok = stok - ? WHERE id = ?");
                $stmt2->bind_param("ii", $qty, $barang_id);
                $stmt2->execute();

                $koneksi->commit();
                echo '<div class="alert alert-success container mt-4">Data barang keluar berhasil disimpan. Stok telah diperbarui.</div>';
                echo '<div class="container"><a href="index.php" class="btn btn-primary">Kembali</a></div>';
                exit;
            } catch (mysqli_sql_exception $exception) {
                $koneksi->rollback();
                $error = "Gagal menyimpan data: " . $exception->getMessage();
            }
        } else {
            $error = "Gagal, stok barang tidak mencukupi. Stok saat ini: " . $stok_saat_ini;
        }
    } else {
        $error = "Data tidak lengkap atau tidak valid.";
    }
}
?>

<div class="container mt-5">
    <h3>Tambah Barang Keluar</h3>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Keluar</label>
            <input type="date" class="form-control" name="tanggal" id="tanggal" required>
        </div>
        <div class="mb-3">
            <label for="barang_id" class="form-label">Nama Barang</label>
            <select class="form-control" name="barang_id" id="barang_id" required>
                <option value="">-- Pilih Barang --</option>
                <?php while ($row = $data_barang->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nama']) ?> (Stok: <?= $row['stok'] ?>)</option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="qty" class="form-label">Jumlah</label>
            <input type="number" class="form-control" name="qty" id="qty" min="1" required>
        </div>
        <div class="mb-3">
            <label for="no_seri" class="form-label">No Seri</label>
            <input type="text" class="form-control" name="no_seri" id="no_seri">
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