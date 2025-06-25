<?php
session_start();
header('Content-Type: application/json');

// Cek apakah user sudah login dan memiliki akses admin/petugas
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['level'], ['admin', 'petugas'])) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Akses ditolak. Hanya admin atau petugas yang dapat menghapus tanggapan.'
    ]);
    exit;
}

// Include koneksi database
require_once 'koneksi.php';

// Pastikan method adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan. Gunakan POST.'
    ]);
    exit;
}

// Ambil data dari request
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['id_tanggapan'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'ID tanggapan tidak ditemukan.'
    ]);
    exit;
}

$id_tanggapan = intval($input['id_tanggapan']);

try {
    // Mulai transaction
    $pdo->beginTransaction();
    
    // Cek apakah tanggapan ada dan ambil detail untuk log
    $stmt = $pdo->prepare("
        SELECT t.id_tanggapan, t.id_pengaduan, t.tanggapan, t.id_petugas, 
               p.nik, pt.nama_petugas
        FROM tanggapan t
        JOIN pengaduan p ON t.id_pengaduan = p.id_pengaduan
        JOIN petugas pt ON t.id_petugas = pt.id_petugas
        WHERE t.id_tanggapan = ?
    ");
    $stmt->execute([$id_tanggapan]);
    $tanggapan = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$tanggapan) {
        $pdo->rollBack();
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Tanggapan tidak ditemukan.'
        ]);
        exit;
    }
    
    // Cek apakah user berhak menghapus tanggapan ini
    // Admin bisa hapus semua tanggapan, petugas hanya bisa hapus tanggapannya sendiri
    if ($_SESSION['level'] === 'petugas' && $tanggapan['id_petugas'] != $_SESSION['user_id']) {
        $pdo->rollBack();
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'message' => 'Anda hanya dapat menghapus tanggapan yang Anda buat sendiri.'
        ]);
        exit;
    }
    
    // Hapus tanggapan dari database
    $stmt = $pdo->prepare("DELETE FROM tanggapan WHERE id_tanggapan = ?");
    $stmt->execute([$id_tanggapan]);
    
    // Update status pengaduan kembali ke 'proses' jika tidak ada tanggapan lain
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tanggapan WHERE id_pengaduan = ?");
    $stmt->execute([$tanggapan['id_pengaduan']]);
    $jumlah_tanggapan = $stmt->fetchColumn();
    
    if ($jumlah_tanggapan == 0) {
        // Jika tidak ada tanggapan lagi, ubah status pengaduan kembali ke 'proses'
        $stmt = $pdo->prepare("UPDATE pengaduan SET status = 'proses' WHERE id_pengaduan = ?");
        $stmt->execute([$tanggapan['id_pengaduan']]);
    }
    
    // Log aktivitas
    $aktivitas = $_SESSION['level'] === 'admin' ? 'Hapus Tanggapan (Admin)' : 'Hapus Tanggapan (Petugas)';
    $detail = "Menghapus tanggapan ID: {$id_tanggapan}, Pengaduan NIK: {$tanggapan['nik']}, Petugas: {$tanggapan['nama_petugas']}";
    
    $stmt = $pdo->prepare("INSERT INTO log_aktivitas (id_admin, aktivitas, detail, tanggal) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$_SESSION['user_id'], $aktivitas, $detail]);
    
    // Commit transaction
    $pdo->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Tanggapan berhasil dihapus.',
        'deleted_id' => $id_tanggapan,
        'id_pengaduan' => $tanggapan['id_pengaduan'],
        'nik' => $tanggapan['nik'],
        'petugas' => $tanggapan['nama_petugas'],
        'status_updated' => $jumlah_tanggapan == 0 ? 'Status pengaduan dikembalikan ke proses' : 'Status pengaduan tetap selesai'
    ]);
    
} catch (PDOException $e) {
    // Rollback jika ada error
    $pdo->rollBack();
    
    error_log("Error hapus tanggapan: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
        'error' => $e->getMessage()
    ]);
} catch (Exception $e) {
    $pdo->rollBack();
    
    error_log("Error hapus tanggapan: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan tidak terduga.',
        'error' => $e->getMessage()
    ]);
}
?>