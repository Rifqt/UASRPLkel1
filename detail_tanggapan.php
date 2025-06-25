<?php

$title = 'Detail Tanggapan';

require '../../public/app.php';

require '../layouts/header.php';

require '../layouts/navAdmin.php';

// Cek apakah ada parameter id_tanggapan
if (!isset($_GET['id_tanggapan']) || empty($_GET['id_tanggapan'])) {
    header('Location: tanggapan.php?error=invalid_id');
    exit;
}

$id_tanggapan = mysqli_real_escape_string($conn, $_GET['id_tanggapan']);

// Query untuk mengambil detail tanggapan
$query = "SELECT t.*, p.*, pt.nama_petugas, pt.level, m.nama, m.telp 
          FROM tanggapan t
          INNER JOIN pengaduan p ON t.id_pengaduan = p.id_pengaduan
          INNER JOIN petugas pt ON t.id_petugas = pt.id_petugas
          INNER JOIN masyarakat m ON p.nik = m.nik
          WHERE t.id_tanggapan = '$id_tanggapan'";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header('Location: tanggapan.php?error=not_found');
    exit;
}

$data = mysqli_fetch_assoc($result);

?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4><i class="fas fa-eye"></i> Detail Tanggapan</h4>
                <a href="tanggapan.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Detail Pengaduan -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt"></i> Detail Pengaduan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-4"><strong>ID Pengaduan:</strong></div>
                        <div class="col-8"><?= htmlspecialchars($data['id_pengaduan']); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>NIK Pelapor:</strong></div>
                        <div class="col-8"><?= htmlspecialchars($data['nik']); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Nama Pelapor:</strong></div>
                        <div class="col-8"><?= htmlspecialchars($data['nama']); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>No. Telepon:</strong></div>
                        <div class="col-8"><?= htmlspecialchars($data['telp']); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Tanggal Laporan:</strong></div>
                        <div class="col-8"><?= date('d F Y', strtotime($data['tgl_pengaduan'])); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Status:</strong></div>
                        <div class="col-8">
                            <?php
                            $status_class = '';
                            $status_text = '';
                            switch($data['status']) {
                                case '0':
                                    $status_class = 'bg-warning text-dark';
                                    $status_text = 'Menunggu';
                                    break;
                                case 'proses':
                                    $status_class = 'bg-info text-white';
                                    $status_text = 'Diproses';
                                    break;
                                case 'selesai':
                                    $status_class = 'bg-success text-white';
                                    $status_text = 'Selesai';
                                    break;
                            }
                            ?>
                            <span class="badge <?= $status_class; ?>"><?= $status_text; ?></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Isi Laporan:</strong></div>
                        <div class="col-8">
                            <div class="border p-3 bg-light rounded">
                                <?= nl2br(htmlspecialchars($data['isi_laporan'])); ?>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($data['foto'])): ?>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Foto:</strong></div>
                        <div class="col-8">
                            <img src="../../public/img/<?= htmlspecialchars($data['foto']); ?>" 
                                 alt="Foto Pengaduan" 
                                 class="img-fluid rounded border"
                                 style="max-height: 200px;">
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Detail Tanggapan -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-reply"></i> Detail Tanggapan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-4"><strong>ID Tanggapan:</strong></div>
                        <div class="col-8"><?= htmlspecialchars($data['id_tanggapan']); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Tanggal Tanggapan:</strong></div>
                        <div class="col-8"><?= date('d F Y', strtotime($data['tgl_tanggapan'])); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Petugas:</strong></div>
                        <div class="col-8">
                            <?= htmlspecialchars($data['nama_petugas']); ?>
                            <span class="badge bg-<?= $data['level'] == 'admin' ? 'danger' : 'primary'; ?> ms-2">
                                <?= ucfirst($data['level']); ?>
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Isi Tanggapan:</strong></div>
                        <div class="col-8">
                            <div class="border p-3 bg-light rounded">
                                <?= nl2br(htmlspecialchars($data['tanggapan'])); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-cogs"></i> Aksi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="edit_tanggapan.php?id_tanggapan=<?= $data['id_tanggapan']; ?>" 
                           class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Tanggapan
                        </a>
                        <a href="hapus_tanggapan.php?id_tanggapan=<?= $data['id_tanggapan']; ?>" 
                           onclick="return confirmDelete('<?= htmlspecialchars($data['tanggapan']); ?>')"
                           class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus Tanggapan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(tanggapan) {
    let displayText = tanggapan.length > 50 ? tanggapan.substring(0, 50) + '...' : tanggapan;
    
    return confirm('Apakah Anda yakin ingin menghapus tanggapan berikut?\n\n"' + displayText + '"\n\nTindakan ini tidak dapat dibatalkan dan akan mengubah status pengaduan menjadi belum ditanggapi.');
}
</script>

<?php require '../layouts/footer.php'; ?>