<?php
ob_start(); // Hindari header error

$title = 'Edit Petugas';

require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navAdmin.php';

// Validasi id_petugas
if (!isset($_GET['id_petugas']) || empty($_GET['id_petugas'])) {
  header("Location: list_petugas.php");
  exit;
}

$id = intval($_GET["id_petugas"]);

$result = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas = $id");

// Jika data tidak ditemukan
if (!$result || mysqli_num_rows($result) === 0) {
  header("Location: list_petugas.php?notfound=1");
  exit;
}

if (isset($_POST["submit"])) {
  if (editPetugas($_POST) > 0) {
    $sukses = true;
  } else {
    $error = true;
  }
}
?>

<?php if (isset($sukses)) : ?>
  <div class="alert alert-success">Petugas berhasil diubah!</div>
<?php endif; ?>

<?php if (isset($error)) : ?>
  <div class="alert alert-danger">Gagal mengubah data petugas.</div>
<?php endif; ?>

<div class="p-5">
  <div class="row">
    <div class="col-md-6">
      <img src="../../assets/img/officer.svg" alt="Ilustrasi" width="100%">
    </div>
    <div class="col-md-6">
      <form action="" method="POST">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
          <input type="hidden" name="id_petugas" value="<?= $row['id_petugas']; ?>">
          <div class="form-group">
            <label>Nama Petugas</label>
            <input type="text" name="nama_petugas" class="form-control" value="<?= $row['nama_petugas']; ?>">
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?= $row['username']; ?>">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="<?= $row['password']; ?>">
          </div>
          <div class="form-group">
            <label>No Telepon</label>
            <input type="number" name="telp" class="form-control" value="<?= $row['telp']; ?>">
          </div>
          <input type="hidden" name="level" value="<?= $row['level']; ?>">
          <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <?php endwhile; ?>
      </form>
    </div>
  </div>
</div>

<?php require '../layouts/footer.php'; ?>
<?php ob_end_flush(); ?>
