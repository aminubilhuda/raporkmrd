<?php
// Statistik Rapor
$jml_siswa = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM siswa"));
$jml_siswa_aktif = mysqli_num_rows(mysqli_query($mysqli, "SELECT DISTINCT(id_siswa) FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));

$rata_nilai = mysqli_fetch_array(mysqli_query($mysqli, "SELECT ROUND(AVG(nilai),2) AS rata FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));
$rata_nilai_mid = mysqli_fetch_array(mysqli_query($mysqli, "SELECT ROUND(AVG(nilai),2) AS rata FROM nilai_kelas_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));

$jml_nilai = mysqli_num_rows(mysqli_query($mysqli, "SELECT DISTINCT(id_siswa) FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));

$pembagian = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM pembagian_raport WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));
$tgl_rapor = $pembagian['tanggal_rapor'] ? date('d/m/Y', strtotime($pembagian['tanggal_rapor'])) : '-';
$tgl_mid = $pembagian['tanggal_mid'] ? date('d/m/Y', strtotime($pembagian['tanggal_mid'])) : '-';

// Data per kelas untuk chart
$chart_kelas = [];
$chart_rata = [];
$chart_siswa = [];
$chart_mid = [];
$qkelas = mysqli_query($mysqli, "SELECT k.nama_kelas,
    ROUND(AVG(nk.nilai),2) AS rata_rata,
    ROUND(AVG(nkm.nilai),2) AS rata_mid,
    COUNT(DISTINCT nk.id_siswa) AS jml_siswa
    FROM nilai_kelas nk
    JOIN kelas k ON nk.id_kelas = k.id_kelas
    LEFT JOIN nilai_kelas_mid nkm ON nkm.id_kelas = nk.id_kelas AND nkm.id_siswa = nk.id_siswa AND nkm.tahun=nk.tahun AND nkm.semester=nk.semester
    WHERE nk.tahun='$sekolah[tahun]' AND nk.semester='$sekolah[semester]'
    GROUP BY nk.id_kelas
    ORDER BY k.nama_kelas ASC");
while($r = mysqli_fetch_array($qkelas)){
    $chart_kelas[] = $r['nama_kelas'];
    $chart_rata[] = $r['rata_rata'] ?: 0;
    $chart_mid[] = $r['rata_mid'] ?: 0;
    $chart_siswa[] = $r['jml_siswa'] ?: 0;
}
?>

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

                <!-- Baris Statistik Rapor -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h5 class="card-title text-white mb-0">
                                    <i class="fas fa-chart-bar"></i> Statistik Rapor
                                    <small class="float-right text-white-50">Tahun <?php echo $tahun['tahun_pelajaran'] ?> - <?php echo $semester['semester'] ?></small>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                        <div class="border rounded p-3 text-center bg-light">
                                            <div class="text-primary h4 mb-1"><?php echo $jml_siswa_aktif ?>/<?php echo $jml_siswa ?></div>
                                            <small class="text-muted">Siswa Aktif / Total</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                        <div class="border rounded p-3 text-center bg-light">
                                            <div class="text-success h4 mb-1"><?php echo $jml_nilai ?></div>
                                            <small class="text-muted">Sudah Dinilai</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                        <div class="border rounded p-3 text-center bg-light">
                                            <div class="text-warning h4 mb-1"><?php echo $rata_nilai['rata'] ?: '-' ?></div>
                                            <small class="text-muted">Rata-rata Nilai</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                        <div class="border rounded p-3 text-center bg-light">
                                            <div class="text-info h4 mb-1"><?php echo $rata_nilai_mid['rata'] ?: '-' ?></div>
                                            <small class="text-muted">Rata-rata Tengah Semester</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                        <div class="border rounded p-3 text-center bg-light">
                                            <div class="text-danger h4 mb-1"><?php echo $tgl_rapor ?></div>
                                            <small class="text-muted">Pembagian Rapor</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                        <div class="border rounded p-3 text-center bg-light">
                                            <div class="text-secondary h4 mb-1"><?php echo $tgl_mid ?></div>
                                            <small class="text-muted">Pembagian Raport Tengah</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">
                                        <canvas id="chartNilai" height="200"></canvas>
                                    </div>
                                    <div class="col-md-5">
                                        <canvas id="chartSiswa" height="280"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Statistik Rapor Chart scripts moved to index.php -->

            </div>
        </div>
        <!-- end row -->
    </div><!-- container -->
</div> <!-- Page content Wrapper -->