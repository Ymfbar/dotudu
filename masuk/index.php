<?php
include '../db.php';
include '../header.php';
?>

<h3>Data Barang Masuk</h3>
<a href="tambah.php" class="btn btn-primary mb-2">+ Tambah</a>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Barang</th>
      <th>Tanggal Masuk</th>
      <th>Jumlah</th>
      <th>Keterangan</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $query = $koneksi->query("SELECT barang_masuk.id, barang_masuk.tanggal, barang_masuk.jumlah, data_barang.nama AS nama_barang 
                              FROM barang_masuk 
                              LEFT JOIN data_barang ON barang_masuk.barang_id = data_barang.id");
    while ($row = $query->fetch_assoc()):
    ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= htmlspecialchars($row['nama_barang']) ?></td>
      <td><?= htmlspecialchars($row['tanggal']) ?></td>
      <td><?= $row['jumlah'] ?></td>
      <td>
        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include '../footer.php'; ?>
