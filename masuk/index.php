<?php
include '../db.php';
include '../header.php';
?>

<div class="container mt-5">
    <h3>Data Barang Masuk</h3>
    <hr>
    <a href="tambah.php" class="btn btn-primary mb-3">+ Tambah Data Barang Masuk</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead class="table-dark">
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Tanggal Masuk</th>
              <th scope="col">Jumlah</th>
              <th scope="col">No Seri</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            // Query SQL disesuaikan: kolom 'keterangan' dihapus
            $query = $koneksi->query("
                SELECT 
                    barang_masuk.id, 
                    barang_masuk.tanggal, 
                    barang_masuk.jumlah, 
                    barang_masuk.no_seri, 
                    data_barang.nama AS nama_barang 
                FROM barang_masuk 
                LEFT JOIN data_barang ON barang_masuk.barang_id = data_barang.id
                ORDER BY barang_masuk.tanggal DESC, barang_masuk.id DESC
            ");

            if ($query->num_rows > 0):
                while ($row = $query->fetch_assoc()):
            ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['nama_barang'] ?? 'Barang Dihapus') ?></td>
              <td><?= htmlspecialchars(date('d F Y', strtotime($row['tanggal']))) ?></td>
              <td><?= htmlspecialchars($row['jumlah']) ?></td>
              <td><?= htmlspecialchars($row['no_seri'] ?? '-') ?></td>
              <td>
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini? Stok barang akan dikembalikan.')">Hapus</a>
              </td>
            </tr>
            <?php 
                endwhile;
            else: 
            ?>
            <tr>
                <td colspan="6" class="text-center">Belum ada data barang masuk.</td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
    </div>
</div>

<?php include '../footer.php'; ?>