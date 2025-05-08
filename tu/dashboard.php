<div class="page-content-wrapper ">

    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Zoogler</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="icon-contain">
                                    <div class="row">
                                        <div class="col-2 align-self-center">
                                            <i class="fas fa-users text-gradient-success"></i>
                                        </div>
                                        <div class="col-10 text-right">
                                            <h5 class="mt-0 mb-1"><?php echo $sekolah['npsn'] ?></h5>
                                            <p class="mb-0 font-12 text-muted">Profil Sekolah</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body justify-content-center">
                                <div class="icon-contain">
                                    <div class="row">
                                        <div class="col-2 align-self-center">
                                            <i class="fas fa-user-graduate text-gradient-primary"></i>
                                        </div>
                                        <div class="col-10 text-right">
                                            <h5 class="mt-0 mb-1">
                                                <?php  
                                                echo
                                                $jumlahguru = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM users "));
                                                ?>
                                            </h5>
                                            <p class="mb-0 font-12 text-muted">Tenaga Pendidik</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="icon-contain">
                                    <div class="row">
                                        <div class="col-2 align-self-center">
                                            <i class="fas fa-users text-gradient-warning"></i>
                                        </div>
                                        <div class="col-10 text-right">
                                            <h5 class="mt-0 mb-1">
                                                <?php  
                                                echo
                                                $jumlahsiswa = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND status='1' "));
                                                ?>
                                            </h5>
                                            <p class="mb-0 font-12 text-muted">Peserta Didik</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card ">
                            <div class="card-body">
                                <div class="icon-contain">
                                    <div class="row">
                                        <div class="col-2 align-self-center">
                                            <i class="fas fa-database text-gradient-primary"></i>
                                        </div>
                                        <div class="col-10 text-right">
                                            <h5 class="mt-0 mb-1">
                                                <?php  
                                                echo
                                                $jumlahkelas = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM kelas "));
                                                ?>
                                            </h5>
                                            <p class="mb-0 font-12 text-muted">Kelas / Rombel</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="icon-contain">
                                    <div class="row">
                                        <div class="col-2 align-self-center">
                                            <i class="fas fa-users text-gradient-success"></i>
                                        </div>
                                        <div class="col-10 text-right">
                                            <h5 class="mt-0 mb-1">
                                                <?php  
	                  	echo
	                  	$jumlahmapel = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM mapel "));
	                  	?>
                                            </h5>
                                            <p class="mb-0 font-12 text-muted">Mata Pelajaran</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body justify-content-center">
                                <div class="icon-contain">
                                    <div class="row">
                                        <div class="col-2 align-self-center">
                                            <i class="fas fa-user-graduate text-gradient-primary"></i>
                                        </div>
                                        <div class="col-10 text-right">
                                            <h5 class="mt-0 mb-1">
                                                <?php  
	                  	echo
	                  	$jumlahmapel = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM prakerin "));
	                  	?>
                                            </h5>
                                            <p class="mb-0 font-12 text-muted">Praktik Kerja Industri</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="icon-contain">
                                    <div class="row">
                                        <div class="col-2 align-self-center">
                                            <i class="fas fa-users text-gradient-warning"></i>
                                        </div>
                                        <div class="col-10 text-right">
                                            <h5 class="mt-0 mb-1">
                                                <?php  
	                  	echo
	                  	$jumlaheskul = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM eskul "));
	                  	?>
                                            </h5>
                                            <p class="mb-0 font-12 text-muted">Ekstra</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card ">
                            <div class="card-body">
                                <div class="icon-contain">
                                    <div class="row">
                                        <div class="col-2 align-self-center">
                                            <i class="fas fa-database text-gradient-primary"></i>
                                        </div>
                                        <div class="col-10 text-right">
                                            <h5 class="mt-0 mb-1">
                                                <?php  
	                  	echo
	                  	$jumlahmasuk= mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM mutasi_masuk "));
	                  	?>
                                            </h5>
                                            <p class="mb-0 font-12 text-muted">Mutasi Masuk</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="icon-contain">
                                    <div class="row">
                                        <div class="col-2 align-self-center">
                                            <i class="fas fa-users text-gradient-success"></i>
                                        </div>
                                        <div class="col-10 text-right">
                                            <h5 class="mt-0 mb-1">
                                                <?php  
                                                    echo $jumlahkeluar= mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM mutasi_keluar "));
                                                ?>
                                            </h5>
                                            <p class="mb-0 font-12 text-muted">Mutasi Keluar</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body justify-content-center">
                                <div class="icon-contain">
                                    <div class="row">
                                        <div class="col-2 align-self-center">
                                            <i class="fas fa-user-graduate text-gradient-primary"></i>
                                        </div>
                                        <div class="col-10 text-right">
                                            <h5 class="mt-0 mb-1">
                                                <?php  
	                  	echo
	                  	$jumlahlulusan= mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM lulusan "));
	                  	?>
                                            </h5>
                                            <p class="mb-0 font-12 text-muted">Lulusan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body justify-content-center">
                                <div class="icon-contain">
                                    <div class="row">
                                        <div class="col-2 align-self-center">
                                            <i class="fas fa-user-graduate text-gradient-primary"></i>
                                        </div>
                                        <div class="col-10 text-right">
                                            <h5 class="mt-0 mb-1">
                                                <?php  
	                  	echo
	                  	$jumlahlulusan= mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM kompetensi_keahlian "));
	                  	?>
                                            </h5>
                                            <p class="mb-0 font-12 text-muted">Jurusan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div><!-- container -->
</div> <!-- Page content Wrapper -->