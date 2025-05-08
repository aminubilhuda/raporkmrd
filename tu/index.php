<?php  

include "../config/function_antiinjection.php";
include "../config/koneksi.php";
include "../config/kode.php";
include "../config/function_date.php";
error_reporting(0);

$user = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$_SESSION[id_user]'"));
$sekolah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sekolah WHERE id_sekolah='1'"));
$kepala = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kepala_sekolah WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' "));
$semester = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM semester WHERE id_semester='$sekolah[semester]' "));
$tahun = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tahun_pelajaran WHERE id_tahun_pelajaran='$sekolah[tahun]' "));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>SITU</title>
    <meta content="E-Rapor SMK AN TBN" name="description" />
    <meta content="Mannatthemes" name="Aminu Bil Huda" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- <link rel="shortcut icon" href="assets/images/favicon.ico"> -->
    <link rel="icon" type="img/png" href="https://penggerak-cdn.siap.id/s3/gurupenggerak/icon-logo.png">

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css">
    <!-- sweet alert -->
    <!-- <script src="../assets/js/sweetalert.min.js"></script>
    <script src="../assets/js/sweetalert2@11.js"></script> -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables -->
    <link href="../assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Respons../ive datatable examples -->
    <link href="../assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- select2 -->
    <link href="../assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />

    <!-- Plugins css -->
    <link href="../assets/plugins/timepicker/tempusdominus-bootstrap-4.css" rel="stylesheet" />
    <link href="../assets/plugins/timepicker/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="../assets/plugins/clockpicker/jquery-clockpicker.min.css" rel="stylesheet" />
    <link href="../assets/plugins/colorpicker/asColorPicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />

    <link href="../assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="../assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="../assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <style>
    body {
        width: 100%;
        /* Pastikan lebar tetap penuh */
        zoom: 0.9;
        /* Skala halaman ke 90% */
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        /* Menghindari scroll horizontal jika diperlukan */
    }

    .option-red {
        color: red;
    }
    </style>


</head>


<body class="fixed-left">

    <!-- Loader -->
    <!-- <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div> -->

    <!-- Begin page -->
    <div id="wrapper">

        <!-- ========== Left Sidebar Start ========== -->
        <?php
        include "sidebar.php";
        ?>
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <!-- Top Bar Start -->
                <?php
                    include "topbar.php";
                ?>
                <!-- Top Bar End -->

                <!-- Content -->
                <?php
                    include "content.php";
                ?>
                <!-- End Content -->

            </div>

            <!-- content -->

            <!-- Footer -->
            <?php
            include "footer.php";
            ?>
            <!-- Footer -->

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->


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

    <script src="../assets/plugins/chart.js/chart.min.js"></script>
    <!-- <script src="../assets/pages/dashboard.js"></script> -->

    <!-- App js -->
    <script src="../assets/js/app.js"></script>


    <!-- cloudflare -->
    <!-- <script defer src='https://static.cloudflareinsights.com/beacon.min.js'
        data-cf-beacon='{"token": "c2d24012345678901234567890123456"}'></script> -->

    <!-- Required datatable js -->
    <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="../assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="../assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="../assets/plugins/datatables/jszip.min.js"></script>
    <script src="../assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="../assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="../assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="../assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="../assets/plugins/datatables/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="../assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="../assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
    <!-- Datatable init js -->
    <script src="../assets/pages/datatables.init.js"></script>

    <!-- Plugins js -->
    <script src="../assets/plugins/timepicker/moment.js"></script>
    <script src="../assets/plugins/timepicker/tempusdominus-bootstrap-4.js"></script>
    <script src="../assets/plugins/timepicker/bootstrap-material-datetimepicker.js"></script>
    <script src="../assets/plugins/clockpicker/jquery-clockpicker.min.js"></script>
    <script src="../assets/plugins/colorpicker/jquery-asColor.js"></script>
    <script src="../assets/plugins/colorpicker/jquery-asGradient.js"></script>
    <script src="../assets/plugins/colorpicker/jquery-asColorPicker.min.js"></script>
    <script src="../assets/plugins/select2/select2.min.js"></script>
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> -->


    <script src="../assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="../assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="../assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <script src="../assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>

    <!-- Plugins Init js -->
    <script src="../assets/pages/form-advanced.js"></script>

    <!--Wysiwig js-->
    <script src="../assets/plugins/tinymce/tinymce.min.js"></script>
    <script src="../assets/pages/form-editor.js"></script>


</body>

</html>