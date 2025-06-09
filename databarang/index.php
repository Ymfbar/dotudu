<?php
include '../db.php';
include '../header.php';
?>

<h3>Data Barang</h3>
<a href="tambah.php" class="btn btn-primary mb-2">+ Tambah</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $query = $koneksi->query("SELECT data_barang.id, data_barang.nama, data_barang.kategori_id, data_barang.stok, data_barang.harga, kategori.nama AS kategori_nama FROM data_barang LEFT JOIN kategori ON data_barang.kategori_id = kategori.id");
        while ($row = $query->fetch_assoc()):
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['kategori_nama'] ?? '-') ?></td>
            <td><?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td><?= number_format($row['stok'], 0, ',', '.') ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include '../footer.php'; ?>
