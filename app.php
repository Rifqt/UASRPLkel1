<?php

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "laporan");

// Cek koneksi berhasil atau tidak
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Fungsi untuk tambah aduan
function tambahAduan($data)
{
    global $conn;

    $tgl = htmlspecialchars($data["tgl_pengaduan"]);
    $nik = htmlspecialchars($data["nik"]);
    $isi = htmlspecialchars($data["isi_laporan"]);
    $foto = htmlspecialchars($data["foto"]);
    $status = htmlspecialchars($data["status"]);

    $query = "INSERT INTO pengaduan VALUES ('', '$tgl', '$nik', '$isi', '$foto', '$status')";

    if (!mysqli_query($conn, $query)) {
        echo "Error tambahAduan: " . mysqli_error($conn);
        return 0;
    }

    return mysqli_affected_rows($conn);
}

// Fungsi untuk verifikasi aduan
function verify($data)
{
    global $conn;

    $id = htmlspecialchars($data["id_pengaduan"]);
    $tgl = htmlspecialchars($data["tgl_pengaduan"]);
    $nik = htmlspecialchars($data["nik"]);
    $isi = htmlspecialchars($data["isi_laporan"]);
    $foto = htmlspecialchars($data["foto"]);
    $status = htmlspecialchars($data["status"]);

    $query = "UPDATE pengaduan SET
                tgl_pengaduan = '$tgl',
                nik = '$nik',
                isi_laporan = '$isi',
                foto = '$foto',
                status = '$status'
              WHERE id_pengaduan = '$id'";

    if (!mysqli_query($conn, $query)) {
        echo "Error verify: " . mysqli_error($conn);
        return 0;
    }

    return mysqli_affected_rows($conn);
}

// Fungsi untuk memberi tanggapan dan update status pengaduan
function tanggapan($data)
{
    global $conn;

    $id_pengaduan = htmlspecialchars($data["id_pengaduan"]);
    $tgl_tanggapan = htmlspecialchars($data["tgl_tanggapan"]);
    $tanggapan = htmlspecialchars($data["tanggapan"]);
    $id_petugas = htmlspecialchars($data["id_petugas"]);

    // Cek status pengaduan, apakah sudah ditanggapi
    $cek = mysqli_query($conn, "SELECT status FROM pengaduan WHERE id_pengaduan = '$id_pengaduan'");
    if (!$cek) {
        echo "Error cek status pengaduan: " . mysqli_error($conn);
        return 0;
    }

    $row = mysqli_fetch_assoc($cek);
    if ($row['status'] == 'ditanggapi' || $row['status'] == 'selesai') {
        // Sudah ditanggapi, tidak bisa menambah tanggapan lagi
        return 0;
    }

    // Insert tanggapan ke tabel tanggapan
    $query1 = "INSERT INTO tanggapan VALUES ('', '$id_pengaduan', '$tgl_tanggapan', '$tanggapan', '$id_petugas')";
    $insert = mysqli_query($conn, $query1);

    if (!$insert) {
        echo "Error insert tanggapan: " . mysqli_error($conn);
        return 0;
    }

    // Update status pengaduan jadi 'ditanggapi'
    $query2 = "UPDATE pengaduan SET status = 'ditanggapi' WHERE id_pengaduan = '$id_pengaduan'";
    $update = mysqli_query($conn, $query2);

    if (!$update) {
        echo "Error update status pengaduan: " . mysqli_error($conn);
        return 0;
    }

    return mysqli_affected_rows($conn);
}

// Fungsi registrasi user masyarakat
function regisUser($data)
{
    global $conn;

    $nik = htmlspecialchars($data["nik"]);
    $nama = htmlspecialchars($data["nama"]);
    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);
    $telp = htmlspecialchars($data["telp"]);

    $query = "INSERT INTO masyarakat VALUES ('$nik', '$nama', '$username', '$password', '$telp')";

    if (!mysqli_query($conn, $query)) {
        echo "Error regisUser: " . mysqli_error($conn);
        return 0;
    }

    return mysqli_affected_rows($conn);
}

// Fungsi tambah petugas
function addPetugas($data)
{
    global $conn;

    $nama = htmlspecialchars($data["nama_petugas"]);
    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);
    $telp = htmlspecialchars($data["telp"]);
    $level = htmlspecialchars($data["level"]);

    $query = "INSERT INTO petugas VALUES ('', '$nama', '$username', '$password', '$telp', '$level')";

    if (!mysqli_query($conn, $query)) {
        echo "Error addPetugas: " . mysqli_error($conn);
        return 0;
    }

    return mysqli_affected_rows($conn);
}

// Fungsi edit petugas
function editPetugas($data)
{
    global $conn;

    $id = htmlspecialchars($data["id_petugas"]);
    $nama = htmlspecialchars($data["nama_petugas"]);
    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);
    $telp = htmlspecialchars($data["telp"]);
    $level = htmlspecialchars($data["level"]);

    $query = "UPDATE petugas SET
                nama_petugas = '$nama',
                username = '$username',
                password = '$password',
                telp = '$telp',
                level = '$level'
              WHERE id_petugas = '$id'";

    if (!mysqli_query($conn, $query)) {
        echo "Error editPetugas: " . mysqli_error($conn);
        return 0;
    }

    return mysqli_affected_rows($conn);
}

// Fungsi hapus petugas
function deletePetugas($id)
{
    global $conn;

    $query = "DELETE FROM petugas WHERE id_petugas = $id";

    if (!mysqli_query($conn, $query)) {
        echo "Error deletePetugas: " . mysqli_error($conn);
        return 0;
    }

    return mysqli_affected_rows($conn);
}

?>
