<?php
session_start();


// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, alihkan ke halaman login
    header("Location: /dotudu/login/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Do Tu Du</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      width: 60px;
      background-color: #343a40;
      color: #fff;
      transition: width 0.3s;
      overflow-x: hidden;
    }

    .sidebar:hover {
      width: 200px;
    }

    .sidebar h4 {
      display: none;
    }

    .sidebar:hover h4 {
      display: block;
      text-align: center;
      padding: 16px 0;
      border-bottom: 1px solid #495057;
    }

    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 12px 20px;
      white-space: nowrap;
    }

    .sidebar a:hover {
      background-color: #495057;
    }

    .main {
      flex-grow: 1;
      padding: 20px;
      background: #f8f9fa;
    }

    /* Optional: icons or placeholders when collapsed */
    .sidebar a span {
      display: inline-block;
      width: 100%;
    }

    .sidebar:not(:hover) a span.text {
      display: none;
    }

    .sidebar a i {
      width: 20px;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <h4>Do Tu Du</h4>
  <a href="/dotudu/"><i class="bi bi-house"></i> <span class="text">Dashboard</span></a>
  <a href="/dotudu/kategori/"><i class="bi bi-tags"></i> <span class="text">Kategori</span></a>
  <a href="/dotudu/databarang/"><i class="bi bi-handbag"></i> <span class="text">Data Barang</span></a>
  <a href="/dotudu/supplier/"><i class="bi bi-truck"></i> <span class="text">Supplier</span></a>
  <a href="/dotudu/masuk/"><i class="bi bi-box-arrow-in-down"></i> <span class="text">Barang Masuk</span></a>
  <a href="/dotudu/keluar/"><i class="bi bi-box-arrow-up"></i> <span class="text">Barang Keluar</span></a>
  <a href="/dotudu/logout.php/"><i class="bi bi-arrow-left-square"></i> <span class="text">Log Out</span></a>

</div>

<div class="main">
