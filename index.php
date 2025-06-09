<?php 
require_once 'db.php';
include 'header.php';
?>

<div class="container mt-5">
  <div class="text-center mb-4">
    <h2 class="fw-bold">Do Tu Du</h2>
    <p class="text-muted">Kelola data barang dengan mudah</p>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="list-group shadow-sm">
        <a href="kategori/" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
          <i class="bi bi-tags me-2"></i> Kategori Barang
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="databarang/" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
          <i class="bi bi-box-seam me-2"></i> Data Barang
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="supplier/" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
          <i class="bi bi-truck me-2"></i> Supplier
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="masuk/" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
          <i class="bi bi-box-arrow-in-down me-2"></i> Barang Masuk
          <i class="bi bi-chevron-right"></i>
        </a>
        <a href="keluar/" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
          <i class="bi bi-box-arrow-up me-2"></i> Barang Keluar
          <i class="bi bi-chevron-right"></i>
        </a>
      </div>
    </div>
  </div>
</div>
