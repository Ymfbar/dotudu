<?php
require_once '../db.php';
include '../header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="alert alert-danger container mt-5">ID tidak valid.</div>';
    exit;
}
$id = intval($_GET['id']);

// Ambil data barang masuk sebelum dihapus untuk penyesuaian stok
$stmt = $koneksi->prepare("SELECT barang_id, jumlah FROM barang_masuk WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "<div class='alert alert-danger container mt-5'>Data tidak ditemukan!</div>";
    include '../footer.php';
    exit;
}

$barang_id = $data['barang_id'];
$jumlah = $data['jumlah'];

$koneksi->begin_transaction();
try {
    // 1. Hapus dari barang_masuk
    $stmt1 = $koneksi->prepare("DELETE FROM barang_masuk WHERE id = ?");
    $stmt1->bind_param("i", $id);
    $stmt1->execute();

    // 2. Kurangi stok di data_barang
    $stmt2 = $koneksi->prepare("UPDATE data_barang SET stok = stok - ? WHERE id = ?");
    $stmt2->bind_param("ii", $jumlah, $barang_id);
    $stmt2->execute();

    $koneksi->commit();
    echo '<div class="alert alert-success container mt-5">Data berhasil dihapus. Stok telah disesuaikan.</div>';
    echo '<div class="container mt-2"><a href="index.php" class="btn btn-primary">Kembali</a></div>';

} catch (mysqli_sql_exception $e) {
    $koneksi->rollback();
    echo '<div class="alert alert-danger container mt-5">Gagal menghapus data: ' . $e->getMessage() . '</div>';
}

include '../footer.php';
?>