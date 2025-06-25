<?php
session_start(); // Pastikan sesi aktif jika pakai login
$title = 'Verifikasi Pengaduan';

require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navPetugas.php';

// Validasi parameter id_pengaduan
if (!isset($_GET['id_pengaduan']) || empty($_GET['id_pengaduan'])) {
    echo "<div class='alert alert-danger m-4'>ID pengaduan tidak ditemukan.</div>";
    require '../layouts/footer.php';
    exit;
}

$id = intval($_GET['id_pengaduan']);

// Ambil data pengaduan
$verify = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_pengaduan = $id");

// Jika data tidak ditemukan
if (!$verify || mysqli_num_rows($verify) == 0) {
    echo "<div class='alert alert-warning m-4'>Data pengaduan tidak ditemukan.</div>";
    require '../layouts/footer.php';
    exit;
}

// Proses saat submit
if (isset($_POST['submit'])) {
    if (verify($_POST) > 0) {
        $sukses = true;
    } else {
        $error = true;
    }
}
?>

<div class="d-flex justify-content-center mt-5">
  <div class="card shadow w-50" data-aos="fade-up">
    <div class="card-body">

      <?php if (isset($sukses)) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Berhasil!</strong> Laporan telah diverifikasi.
          <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <?php if (isset($error)) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Gagal!</strong> Verifikasi laporan gagal dilakukan.
          <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <h4 class="text-center text-primary">Verifikasi Laporan Masyarakat</h4>
      <hr>

      <form action="" method="POST">
        <?php while ($row = mysqli_fetch_assoc($verify)) : ?>
          <input type="hidden" name="id_pengaduan" value="<?= $row['id_pengaduan']; ?>">
          <input type="hidden" name="foto" value="<?= $row['foto']; ?>">
          <input type="hidden" name="status" value="selesai">

          <div class="form-group">
            <label for="tgl">Tanggal Pengaduan</label>
            <input type="text" class="form-control" id="tgl" name="tgl_pengaduan" value="<?= $row['tgl_pengaduan']; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="nik">NIK</label>
            <input type="number" class="form-control" id="nik" name="nik" value="<?= $row['nik']; ?>" readonly>
          </div>
          <div class="form-group">
            <label for="isi">Isi Laporan</label>
            <textarea class="form-control" id="isi" name="isi_laporan" rows="3" readonly><?= $row['isi_laporan']; ?></textarea>
          </div>
          <button type="submit" name="submit" class="btn btn-success btn-block">Verifikasi Laporan</button>
        <?php endwhile; ?>
      </form>
    </div>
  </div>
</div>

<?php require '../layouts/footer.php'; ?>
