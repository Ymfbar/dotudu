<?php
require_once '../db.php';
include '../header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="alert alert-danger container mt-5">ID tidak valid.</div>';
    exit;
}

$id = intval($_GET['id']);
$table = "supplier"; // Nama tabel

$stmt = $koneksi->prepare("DELETE FROM `$table` WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo '<div class="alert alert-success container mt-5">Data berhasil dihapus.</div>';
    echo '<div class="container mt-2"><a href="index.php" class="btn btn-primary">Kembali</a></div>';
} else {
    echo '<div class="alert alert-danger container mt-5">Gagal menghapus data: ' . $stmt->error . '</div>';
}

include '../footer.php';
?>