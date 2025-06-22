<?php
$host = "sql303.infinityfree.com";       // Host dari cPanel
$user = "if0_39295605";                  // Username MySQL
$pass = "kelompokbarang";               // Password MySQL
$db   = "if0_39295605_dotudu_db";        // Nama database di InfinityFree

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
