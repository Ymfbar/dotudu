<?php
include '../db.php';
include '../header.php';

// Ambil data barang untuk pilihan dropdown
$data_barang = $koneksi->query("SELECT id, nama FROM data_barang");

// Proses simpan data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $data_barang_id = $_POST['data_barang_id'];
    $qty = $_POST['qty'];
    $keterangan = $_POST['keterangan'];

    // Simpan ke database
    $stmt = $koneksi->prepare("INSERT INTO keluar (tanggal, data_barang_id, qty, keterangan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siis", $tanggal, $data_barang_id, $qty, $keterangan);
    $stmt->execute();

    echo "<script>alert('Data berhasil disimpan!');window.location='index.php';</script>";
}
?>

<h3>Tambah Barang Keluar</h3>
<form method="post">
    <div class="mb-3">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="date" class="form-control" name="tanggal" id="tanggal" required>
    </div>
    <div class="mb-3">
        <label for="data_barang_id" class="form-label">Nama Barang</label>
        <select class="form-control" name="data_barang_id" id="data_barang_id" required>
            <option value="">-- Pilih Barang --</option>
            <?php while ($row = $data_barang->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nama']) ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="qty" class="form-label">Jumlah</label>
        <input type="number" class="form-control" name="qty" id="qty" min="1" required>
    </div>
    <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan</label>
        <input type="text" class="form-control" name="keterangan" id="keterangan">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
</form>
<?php include '../footer.php'; ?>