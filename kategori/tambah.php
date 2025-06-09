<?php include '../db.php'; include '../header.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $koneksi->query("INSERT INTO kategori (nama) VALUES ('$nama')");
    header("Location: index.php");
}
?>
<h3>Tambah Kategori</h3>
<form method="post">
  <div class="mb-3">
    <label>Nama Kategori</label>
    <input type="text" name="nama" class="form-control" required>
  </div>
  <button class="btn btn-success">Simpan</button>
</form>
<?php include '../footer.php'; ?>
