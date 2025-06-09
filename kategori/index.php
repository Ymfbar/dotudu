<?php include '../db.php';
include '../header.php';
?>
<h3>Kategori Barang</h3>
<a href="tambah.php" class="btn btn-primary mb-2">+ Tambah</a>
<table class="table table-bordered">
  <thead>
    <tr><th>No</th><th>Nama Kategori</th><th>Aksi</th></tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $query = $koneksi->query("SELECT * FROM kategori");
    while ($row = $query->fetch_assoc()):
    ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= $row['nama'] ?></td>
      <td>
        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php include '../footer.php'; ?>
