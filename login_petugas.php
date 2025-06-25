<?php
session_start();

$title = 'Login | Petugas';

require '../../public/app.php';
require '../layouts/header.php';

// Logic backend
if (isset($_POST['submit'])) {
  // Amankan inputan
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // Ambil data user
  $result = mysqli_query($conn, "SELECT * FROM petugas WHERE username = '$username'");

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    // Verifikasi password (kalau di-hash pakai password_verify, kalau tidak langsung bandingkan)
    if ($row['password'] === $password) { // Ganti dengan password_verify jika pakai hash
      // Set session login
      $_SESSION['user_id'] = $row['id_petugas'];
      $_SESSION['level'] = $row['level'];

      // Redirect sesuai level
      if ($row['level'] === 'admin') {
        header("Location: ../admin/dashboard.php");
        exit;
      } elseif ($row['level'] === 'petugas') {
        header("Location: dashboard.php");
        exit;
      }
    } else {
      $error = true;
    }
  } else {
    $error = true;
  }
}
?>

<!-- FORM LOGIN UI -->
<div class="d-flex justify-content-center py-5 mt-5">
  <div class="card shadow mt-3 border-bottom-primary bg-gray-100 w-50" data-aos="fade-down">
    <div class="card-body">

      <?php if (isset($error)) : ?>
        <div class="alert alert-dismissible fade show" style="background-color: #b52d2d;" role="alert">
          <h6 class="text-gray-100 mt-2">Maaf username atau password anda salah</h6>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" class="text-light">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <h3 class="text-center text-primary text-uppercase text-bold">Login</h3>
      <hr class="bg-gradient-primary">
      <div class="row">
        <div class="col-6">
          <form action="" method="post">
            <div class="form-group text-center">
              <label for="exampleInputEmail1">Username</label>
              <input type="text" class="form-control shadow" style="border: none; border-radius:20px;" id="exampleInputEmail1" name="username" required>
            </div>
            <div class="form-group text-center">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control shadow" style="border: none; border-radius:20px;" id="exampleInputPassword1" name="password" required>
            </div>
            <div class="mt-4">
              <button type="submit" name="submit" class="btn btn-primary shadow-lg col-12" style="border-radius:20px;">Masuk</button>
            </div>
          </form>
        </div>
        <div class="col-6">
          <div class="image">
            <img src="../../assets/img/officer.svg" width="320" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require '../layouts/footer.php'; ?>
