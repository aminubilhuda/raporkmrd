<?php  
error_reporting(0);
session_start();
include "../config/function_antiinjection.php";
include "../config/koneksi.php";
$sekolah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sekolah WHERE id_sekolah='1'"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Login Tata Usaha</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- <link rel="shortcut icon" href="../assets/images/favicon.ico"> -->
    <link rel="icon" type="img/png" href="https://penggerak-cdn.siap.id/s3/gurupenggerak/icon-logo.png">

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css">

</head>


<body class="fixed-left">

    <!-- <div class="accountbg"></div> -->
    <div class="wrapper-page">

        <div class="card">
            <div class="card-body">

                <div class="text-center m-b-15">
                    <a href="" class="logo logo-admin"><img src="../assets/dist/img/<?php echo $sekolah['logo'] ?>"
                            height="24" alt="logo"></a>
                    <h3>Login TU/Admin</h3>
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
                                <input class="form-control" name="password" type="password" required=""
                                    placeholder="Password">
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Remember me</label>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group text-center row m-t-20">
                            <div class="col-12">
                                <button class="btn btn-danger btn-block waves-effect waves-light" name="login"
                                    type="submit">Masuk</button>
                            </div>
                        </div>
                        <div class="form-group text-center row m-t-20">
                            <div class="col-12">
                                <a href="../" class="btn btn-info">Kembali</a>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- jQuery  -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/modernizr.min.js"></script>
    <script src="../assets/js/detect.js"></script>
    <script src="../assets/js/fastclick.js"></script>
    <script src="../assets/js/jquery.slimscroll.js"></script>
    <script src="../assets/js/jquery.blockUI.js"></script>
    <script src="../assets/js/waves.js"></script>
    <script src="../assets/js/jquery.nicescroll.js"></script>
    <script src="../assets/js/jquery.scrollTo.min.js"></script>
    <!-- cloudflare -->
    <script defer src='https://static.cloudflareinsights.com/beacon.min.js'
        data-cf-beacon='{"token": "c2d24012345678901234567890123456"}'></script>
    <!-- App js -->
    <script src="../assets/js/app.js"></script>
    <!-- Sweet-Alert  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
<?php  
	if (isset($_POST['login'])) {
		$username = strtolower($_POST['username']);
		$password = strtolower($_POST['password']);

		$query = mysqli_query($mysqli,"SELECT * FROM users WHERE username='$username' AND jabatan='2'");
		if (mysqli_num_rows($query)===1) {
			$datalogin = mysqli_fetch_array($query);
			if (password_verify($password, $datalogin['password'])) {
				$_SESSION['id_user'] = $datalogin['id_user'];
				$_SESSION['jabatan'] = $datalogin['jabatan'];

				?>
<script type="text/javascript">
Swal.fire({
    title: "Login Berhasil!",
    // text: "You clicked the button!",
    icon: "success",
    showConfirmButton: false,
    timer: 1500
}).then(() => {
    window.location.href = "index.php";
});
</script>
<?php
			}else{
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
		}else{
			?>
<script type="text/javascript">
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Username atau Password Salah!'
}).then(() => {
    window.location.href = "login.php";
});
</script>
<?php
		}
	}
	?>
<script>