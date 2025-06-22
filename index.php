<?php 
require_once 'db.php';
include 'header.php';
?>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container py-5">
  <h2 class="mb-4 fw-bold text-center">Do Tu Du</h2>
  <h3 class="mb-4 fw-bold text-center">Data Operasional, Tugas, dan Dukungan Unit kelola barang</h3>


  <?php
  // Ambil jumlah data
  $total_kategori = $koneksi->query("SELECT COUNT(*) FROM kategori")->fetch_row()[0];
  $total_barang   = $koneksi->query("SELECT COUNT(*) FROM data_barang")->fetch_row()[0];
  $total_supplier = $koneksi->query("SELECT COUNT(*) FROM supplier")->fetch_row()[0];
  $total_masuk    = $koneksi->query("SELECT COUNT(*) FROM masuk")->fetch_row()[0];
  $total_keluar   = $koneksi->query("SELECT COUNT(*) FROM keluar")->fetch_row()[0];
  ?>

  <!-- Ringkasan Statistik -->
  <div class="row g-4 mb-5">

    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="text-muted mb-1">Kategori</h6>
          <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-semibold mb-0"><?= $total_kategori ?></h4>
            <i class="bi bi-tags fs-4 text-secondary"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="text-muted mb-1">Data Barang</h6>
          <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-semibold mb-0"><?= $total_barang ?></h4>
            <i class="bi bi-box-seam fs-4 text-secondary"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="text-muted mb-1">Supplier</h6>
          <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-semibold mb-0"><?= $total_supplier ?></h4>
            <i class="bi bi-truck fs-4 text-secondary"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="text-muted mb-1">Barang Masuk</h6>
          <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-semibold mb-0"><?= $total_masuk ?></h4>
            <i class="bi bi-box-arrow-in-down fs-4 text-secondary"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="text-muted mb-1">Barang Keluar</h6>
          <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-semibold mb-0"><?= $total_keluar ?></h4>
            <i class="bi bi-box-arrow-up fs-4 text-secondary"></i>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Aktivitas Terbaru -->
  <h5 class="mb-3">Aktivitas Terbaru</h5>

  <ul class="list-group shadow-sm border rounded-3">
    <?php
    $updates = [];

    $result_kat = $koneksi->query("SELECT nama FROM kategori ORDER BY id DESC LIMIT 1");
    if ($row = $result_kat->fetch_assoc()) {
        $updates[] = "Kategori baru: <strong>" . htmlspecialchars($row['nama']) . "</strong>";
    }

    $result_barang = $koneksi->query("SELECT nama FROM data_barang ORDER BY id DESC LIMIT 1");
    if ($row = $result_barang->fetch_assoc()) {
        $updates[] = "Barang baru: <strong>" . htmlspecialchars($row['nama']) . "</strong>";
    }

    $result_supp = $koneksi->query("SELECT nama FROM supplier ORDER BY id DESC LIMIT 1");
    if ($row = $result_supp->fetch_assoc()) {
        $updates[] = "Supplier baru: <strong>" . htmlspecialchars($row['nama']) . "</strong>";
    }

    $result_masuk = $koneksi->query("SELECT tanggal FROM masuk ORDER BY id DESC LIMIT 1");
    if ($row = $result_masuk->fetch_assoc()) {
        $updates[] = "Transaksi masuk pada: <strong>" . $row['tanggal'] . "</strong>";
    }

    $result_keluar = $koneksi->query("SELECT tanggal FROM keluar ORDER BY id DESC LIMIT 1");
    if ($row = $result_keluar->fetch_assoc()) {
        $updates[] = "Transaksi keluar pada: <strong>" . $row['tanggal'] . "</strong>";
    }

    if (empty($updates)) {
        echo "<li class='list-group-item text-muted'>Belum ada aktivitas.</li>";
    } else {
        foreach ($updates as $item) {
            echo "<li class='list-group-item small'>$item</li>";
        }
    }
    ?>
  </ul>

</div>

<?php include 'footer.php'; ?>
