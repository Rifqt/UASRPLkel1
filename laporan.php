<?php

$title = 'Laporan Masyarakat';

require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navPetugas.php';

// Ambil semua laporan yang berstatus "proses"
$result = mysqli_query($conn, "SELECT * FROM pengaduan WHERE status = 'proses' ORDER BY id_pengaduan DESC");

?>

<div class="row" data-aos="fade-up">
  <div class="col-6">
    <h3 class="text-gray-800">Daftar Laporan Masyarakat</h3>
  </div>
  <div class="col-6 d-flex justify-content-end">
    <form class="form-inline">
      <input class="form-control mr-1 col-8" type="search" placeholder="Cari NIK" aria-label="Search">
      <button class="btn btn-success my-2 my-sm-0" type="submit">
        <i class="fas fa-search"></i>
      </button>
    </form>
  </div>
</div>

<hr>

<table class="table table-bordered shadow-sm text-center" data-aos="fade-up" data-aos-duration="700">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Tanggal</th>
      <th scope="col">NIK</th>
      <th scope="col">Isi Laporan</th>
      <th scope="col">Foto</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    if (mysqli_num_rows($result) > 0) :
      while ($row = mysqli_fetch_assoc($result)) :
    ?>
        <tr>
          <th scope="row"><?= $no++; ?>.</th>
          <td><?= $row["tgl_pengaduan"]; ?></td>
          <td><?= $row["nik"]; ?></td>
          <td><?= $row["isi_laporan"]; ?></td>
          <td>
            <?php if (!empty($row["foto"])) : ?>
              <img src="../../assets/img/<?= $row["foto"]; ?>" width="50">
            <?php else : ?>
              <span class="text-muted">Tidak ada foto</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="verify.php?id_pengaduan=<?= $row["id_pengaduan"]; ?>" class="btn btn-success">Verifikasi</a>
          </td>
        </tr>
    <?php
      endwhile;
    else :
    ?>
      <tr>
        <td colspan="6" class="text-center text-muted">Tidak ada laporan dengan status <strong>proses</strong>.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

<?php require '../layouts/footer.php'; ?>
