<?php
require_once '../db.php'; //
include '../header.php'; //

// Validasi ID dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="alert alert-danger container mt-5">ID tidak valid.</div>';
    exit;
}
$id = intval($_GET['id']);

// Ambil data (jumlah dan id barang) dari record yang akan dihapus
// Ini diperlukan untuk menyesuaikan stok
$stmt = $koneksi->prepare("SELECT barang_id, qty FROM keluar WHERE id = ?"); //
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
$qty = $data['qty'];

// Mulai transaksi untuk memastikan kedua query berhasil atau keduanya gagal
$koneksi->begin_transaction();

try {
    // 1. Hapus record dari tabel 'keluar'
    $stmt1 = $koneksi->prepare("DELETE FROM keluar WHERE id = ?"); //
    $stmt1->bind_param("i", $id);
    $stmt1->execute();

    // 2. Kembalikan (tambahkan) stok ke tabel 'data_barang'
    $stmt2 = $koneksi->prepare("UPDATE data_barang SET stok = stok + ? WHERE id = ?");
    $stmt2->bind_param("ii", $qty, $barang_id);
    $stmt2->execute();

    // Jika semua query berhasil, commit transaksi
    $koneksi->commit();
    
    echo '<div class="alert alert-success container mt-5">Data berhasil dihapus. Stok telah dikembalikan.</div>';
    echo '<div class="container mt-2"><a href="index.php" class="btn btn-primary">Kembali</a></div>';

} catch (mysqli_sql_exception $e) {
    // Jika ada kesalahan, batalkan semua perubahan (rollback)
    $koneksi->rollback();
    echo '<div class="alert alert-danger container mt-5">Gagal menghapus data: ' . $e->getMessage() . '</div>';
}

include '../footer.php';
?>