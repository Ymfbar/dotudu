<?php
require_once '../db.php';
include '../header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="alert alert-danger container mt-5">ID tidak valid.</div>';
    exit;
}
$id = intval($_GET['id']);

$stmt = $koneksi->prepare("SELECT * FROM keluar WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
if (!$data) {
    echo "<div class='alert alert-danger container mt-5'>Data tidak ditemukan!</div>";
    exit;
}
$qty_lama = $data['qty'];
$barang_id_lama = $data['barang_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $barang_id_baru = intval($_POST['barang_id']);
    $qty_baru = intval($_POST['qty']);
    $no_seri = trim($_POST['no_seri']); // BARIS BARU: Mengambil data no_seri dari form
    $keterangan = trim($_POST['keterangan']);

    // Cek stok
    $cek_stok_res = $koneksi->query("SELECT stok FROM data_barang WHERE id = $barang_id_baru");
    $stok_saat_ini = $cek_stok_res->fetch_assoc()['stok'];

    if (($stok_saat_ini + $qty_lama) < $qty_baru) {
        $error = "Stok tidak mencukupi untuk jumlah yang baru.";
    } else {
        $koneksi->begin_transaction();
        try {
            // 1. Kembalikan stok lama
            $koneksi->query("UPDATE data_barang SET stok = stok + $qty_lama WHERE id = $barang_id_lama");
            
            // 2. Update data keluar (query diubah)
            $stmt = $koneksi->prepare("UPDATE keluar SET tanggal=?, barang_id=?, qty=?, no_seri=?, keterangan=? WHERE id=?");
            $stmt->bind_param("siissi", $tanggal, $barang_id_baru, $qty_baru, $no_seri, $keterangan, $id);
            $stmt->execute();
            
            // 3. Kurangi stok baru
            $koneksi->query("UPDATE data_barang SET stok = stok - $qty_baru WHERE id = $barang_id_baru");
            
            $koneksi->commit();
            echo '<div class="alert alert-success container mt-4">Data berhasil diupdate. Stok telah disesuaikan.</div>';
            echo '<div class="container"><a href="index.php" class="btn btn-primary">Kembali</a></div>';
            exit;
        } catch (mysqli_sql_exception $e) {
            $koneksi->rollback();
            $error = "Gagal memperbarui data: " . $e->getMessage();
        }
    }
}
$data_barang = $koneksi->query("SELECT id, nama FROM data_barang");
?>
<div class="container mt-5">
    <h3>Edit Barang Keluar</h3>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" value="<?= $data['tanggal'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="barang_id" class="form-label">Nama Barang</label>
            <select class="form-control" name="barang_id" required>
                <?php mysqli_data_seek($data_barang, 0); ?>
                <?php while ($row = $data_barang->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>" <?= ($data['barang_id'] == $row['id']) ? 'selected' : '' ?>><?= htmlspecialchars($row['nama']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="qty" class="form-label">Jumlah</label>
            <input type="number" class="form-control" name="qty" value="<?= $data['qty'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="no_seri" class="form-label">No Seri</label>
            <input type="text" class="form-control" name="no_seri" value="<?= htmlspecialchars($data['no_seri'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" class="form-control" name="keterangan" value="<?= htmlspecialchars($data['keterangan'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?php include '../footer.php'; ?>