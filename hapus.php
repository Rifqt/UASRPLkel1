<?php

$title = 'Hapus';
require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navAdmin.php';

$id = $_GET["id_petugas"];

// Cek apakah id_petugas ini masih digunakan di tabel tanggapan
$cekTanggapan = mysqli_query($conn, "SELECT COUNT(*) as total FROM tanggapan WHERE id_petugas = $id");
$data = mysqli_fetch_assoc($cekTanggapan);

if ($data['total'] > 0) {
    $error = "Petugas tidak bisa dihapus karena sudah memiliki tanggapan.";
} else {
    if (deletePetugas($id) > 0) {
        $sukses = true;
    } else {
        $error = mysqli_error($conn);
    }
}
?>

<?php if (isset($sukses)) : ?>
    <div class="d-flex justify-content-center py-5 mt-5">
        <div class="card shadow bg-success">
            <div class="card-body">
                <h4 class="text-center text-light">Data Berhasil dihapus!</h4>
                <hr>
                <img src="../../assets/img/sukses.svg" width="250" alt="" data-aos="zoom-in" data-aos-duration="700">
                <div class="button mt-3">
                    <a href="petugas.php" class="btn btn-primary text-light shadow">OK!</a>
                </div>
            </div>
        </div>
    </div>
<?php elseif (isset($error)) : ?>
    <div class="d-flex justify-content-center py-5 mt-5">
        <div class="card shadow bg-danger">
            <div class="card-body">
                <h4 class="text-center text-light">Gagal Menghapus Data!</h4>
                <p class="text-center text-light"><?= $error; ?></p>
                <hr>
                <img src="../../assets/img/error.svg" width="250" alt="" data-aos="zoom-in" data-aos-duration="700">
                <div class="button mt-3 text-center">
                    <a href="petugas.php" class="btn btn-light text-danger shadow">Kembali</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require '../layouts/footer.php'; ?>
