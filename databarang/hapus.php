<?php
require_once '../db.php'; // sesuaikan path jika perlu
include '../header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="alert alert-danger container mt-5">ID tidak valid.</div>';
    exit;
}

$id = intval($_GET['id']);
$table = "data_barang"; // Hardcode nama tabel sesuai permintaan

// ✅ Tambahkan 'databarang' ke whitelist
$allowed_tables = ['kategori', 'data_barang', 'supplier', 'masuk', 'keluar'];
if (!in_array($table, $allowed_tables)) {
    echo '<div class="alert alert-danger container mt-5">Tabel tidak diizinkan.</div>';
    exit;
}

// Jalankan query hapus
$stmt = $koneksi->prepare("DELETE FROM `$table` WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo '<div class="alert alert-success container mt-5">Data berhasil dihapus.</div>';
    echo '<div class="container mt-2"><a href="index.php" class="btn btn-primary">Kembali</a></div>';
} else {
    echo '<div class="alert alert-danger container mt-5">Gagal menghapus data: ' . $stmt->error . '</div>';
}
?>
