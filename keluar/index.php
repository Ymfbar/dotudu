<?php
include '../db.php';
include '../header.php';
?>
<h3>Data Barang Keluar</h3>
<a href="tambah.php" class="btn btn-primary mb-2">+ Tambah</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Tanggal Keluar</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        // Query diperbaiki untuk mengambil 'keterangan' dan urutan kolom disesuaikan
        $query = $koneksi->query("SELECT keluar.id, keluar.tanggal, keluar.qty, keluar.keterangan, data_barang.nama AS nama_barang 
                                  FROM keluar 
                                  LEFT JOIN data_barang ON keluar.barang_id = data_barang.id 
                                  ORDER BY keluar.tanggal DESC");
        while ($row = $query->fetch_assoc()):
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama_barang'] ?? '-') ?></td>
            <td><?= htmlspecialchars($row['tanggal']) ?></td>
            <td><?= $row['qty'] ?></td>
            <td><?= htmlspecialchars($row['keterangan'] ?? '-') ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include '../footer.php'; ?>