<?php  
session_set_cookie_params([
    'lifetime' => 7200, // 2 hour
    'path' => '/',
    'domain' => 'km.abdinegara.com', // Set the correct domain
    'secure' => true, // If using HTTPS
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
error_reporting(0);
include "config/function_antiinjection.php";
include "config/koneksi.php";
include "bot/wa/functionbot.php";
$sekolah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sekolah WHERE id_sekolah='1'"));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>E-Rapor SMK Abdi Negara Tuban</title>
    <meta content="E-Rapor SMK AN TBN" name="description" />
    <meta content="Mannatthemes" name="Aminu Bil Huda" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" type="img/png" href="https://penggerak-cdn.siap.id/s3/gurupenggerak/icon-logo.png">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
</head>

<body class="fixed-left">
    <div class="wrapper-page">
        <div class="card">
            <div class="card-body">
                <div class="text-center m-b-15">
                    <a href="" class="logo logo-admin">
                        <img src="assets/dist/img/<?php echo $sekolah['logo'] ?>" height="24" alt="logo">
                    </a>
                    <h3>Login</h3>
                </div>
                <div class="p-3">
                    <form class="form-horizontal m-t-20" action="" method="POST">
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" name="username" type="text" required=""
                                    placeholder="Username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="input-group">
                                    <input class="form-control" name="password" type="password" id="password"
                                        required="" placeholder="Password">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tambahkan margin-bottom ke tombol login -->
                        <div class="form-group text-center row mt-4">
                            <div class="col-12">
                                <button class="btn btn-danger btn-block waves-effect waves-light" name="login"
                                    type="submit">
                                    Login
                                </button>
                            </div>
                        </div>
                        <!-- Tambahkan margin-top ke tombol kembali -->
                        <div class="form-group text-center row mt-3">
                            <div class="col-12">
                                <a href="" class="btn btn-info">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function(e) {
        // Toggle the type attribute between password and text
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
    </script>
</body>

</html>

<?php  
    if (isset($_POST['login'])) {
        $username = strtolower($_POST['username']);
        $password = strtolower($_POST['password']);

        // Fetch user based on username
        $query = mysqli_query($mysqli,"SELECT * FROM users WHERE username='$username'");
        
        if (mysqli_num_rows($query) === 1) {
            $datalogin = mysqli_fetch_array($query);

            // Verify the password
            if (password_verify($password, $datalogin['password'])) {
                // Set session data
                $_SESSION['id_user'] = $datalogin['id_user'];
                $_SESSION['jabatan'] = $datalogin['jabatan'];

                // Check role and redirect accordingly
                if ($datalogin['jabatan'] == '2') { // Admin role
                    ?>
<script type="text/javascript">
Swal.fire({
    title: "Login Berhasil!",
    icon: "success",
    showConfirmButton: false,
    timer: 1500
}).then(() => {
    window.location.href = "tu/index.php";
});
</script>
<?php
} elseif ($datalogin['jabatan'] == '3') { // Teacher role
?>
<script type="text/javascript">
Swal.fire({
    title: "Login Berhasil!",
    icon: "success",
    showConfirmButton: false,
    timer: 1500
}).then(() => {
    window.location.href = "guru/index.php";
});
</script>
<?php
                } else {
                    ?>
<script type="text/javascript">
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Invalid role. Please contact the administrator!',
}).then(() => {
    window.location.href = "login.php";
});
</script>
<?php
                }
            } else {
                // Incorrect password
                ?>
<script type="text/javascript">
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Username atau Password Salah!',
}).then(() => {
    window.location.href = "login.php";
});
</script>
<?php
            }
        } else {
            // User not found
            ?>
<script type="text/javascript">
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Username atau Password Salah!',
}).then(() => {
    window.location.href = "login.php";
});
</script>
<?php
        }
    }
?>