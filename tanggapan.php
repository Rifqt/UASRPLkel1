<?php

$title = 'Tanggapan';

require '../../public/app.php';

require '../layouts/header.php';

require '../layouts/navAdmin.php';

// Tampilkan notifikasi berdasarkan parameter URL
if (isset($_GET['success'])) {
    if ($_GET['success'] == 'deleted') {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Tanggapan berhasil dihapus.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}

if (isset($_GET['error'])) {
    $error_message = '';
    switch ($_GET['error']) {
        case 'invalid_id':
            $error_message = 'ID tanggapan tidak valid.';
            break;
        case 'not_found':
            $error_message = 'Tanggapan tidak ditemukan.';
            break;
        case 'delete_failed':
            $error_message = 'Gagal menghapus tanggapan. Silakan coba lagi.';
            break;
        default:
            $error_message = 'Terjadi kesalahan.';
    }
    
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> ' . $error_message . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}

// logic backend
$query = "SELECT * FROM ( ( tanggapan INNER JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan )
          INNER JOIN petugas ON tanggapan.id_petugas = petugas.id_petugas ) ORDER BY id_tanggapan DESC";

$result = mysqli_query($conn, $query);

?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-reply"></i> Data Tanggapan
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" data-aos="fade-up" data-aos-duration="900">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">NIK</th>
                                    <th scope="col" class="text-center">Tanggal Laporan</th>
                                    <th scope="col" class="text-center">Laporan</th>
                                    <th scope="col" class="text-center">Tanggal Tanggapan</th>
                                    <th scope="col" class="text-center">Tanggapan</th>
                                    <th scope="col" class="text-center">Nama Petugas</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <th scope="row" class="text-center"><?= $i; ?>.</th>
                                    <td class="text-center"><?= htmlspecialchars($row["nik"]); ?></td>
                                    <td class="text-center"><?= date('d-m-Y', strtotime($row["tgl_pengaduan"])); ?></td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($row["isi_laporan"]); ?>">
                                            <?= htmlspecialchars($row["isi_laporan"]); ?>
                                        </div>
                                    </td>
                                    <td class="text-center"><?= date('d-m-Y', strtotime($row["tgl_tanggapan"])); ?></td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($row["tanggapan"]); ?>">
                                            <?= htmlspecialchars($row["tanggapan"]); ?>
                                        </div>
                                    </td>
                                    <td class="text-center"><?= htmlspecialchars($row["nama_petugas"]); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="detail_tanggapan.php?id_tanggapan=<?= $row['id_tanggapan']; ?>" 
                                               class="btn btn-info btn-sm" 
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="edit_tanggapan.php?id_tanggapan=<?= $row['id_tanggapan']; ?>" 
                                               class="btn btn-warning btn-sm" 
                                               title="Edit Tanggapan">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="hapus_tanggapan.php?id_tanggapan=<?= $row['id_tanggapan']; ?>" 
                                               onclick="return confirmDelete('<?= htmlspecialchars($row['tanggapan']); ?>')" 
                                               class="btn btn-danger btn-sm" 
                                               title="Hapus Tanggapan">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada tanggapan</h5>
                        <p class="text-muted">Data tanggapan akan muncul di sini setelah petugas memberikan tanggapan.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(tanggapan) {
    // Potong teks tanggapan jika terlalu panjang
    let displayText = tanggapan.length > 50 ? tanggapan.substring(0, 50) + '...' : tanggapan;
    
    return confirm('Apakah Anda yakin ingin menghapus tanggapan berikut?\n\n"' + displayText + '"\n\nTindakan ini tidak dapat dibatalkan dan akan mengubah status pengaduan menjadi belum ditanggapi.');
}

// Auto hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>

<style>
.btn-group .btn {
    margin: 0 1px;
}

.table td, .table th {
    vertical-align: middle;
}

.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.alert {
    margin-bottom: 1rem;
}
</style>

<?php require '../layouts/footer.php'; ?>