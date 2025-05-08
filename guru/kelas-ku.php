<?php if(empty($_GET['filter'])){ ?>

<section class="content-header">
    <h1>
        Daftar Mata Pelajaranku
    </h1>
</section>



<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Kelas dan Mata Pelajaran</h3>
                    <div class="card-tools float-right">
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th>Tujuan Pembelajaran</th>
                                <th>Penilaian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                      			$nomor=1;
                      			$kelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                      			JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                      			JOIN kelas ON mapel_kelas.id_kelas = kelas.id_kelas
                      			WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_user='$_SESSION[id_user]' ORDER BY urut ASC");
                      			while($rkelas = mysqli_fetch_array($kelas)){
                      			    $jumlahproyek = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM mapel_proyek WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$rkelas[id_kelas]' AND id_mapel='$rkelas[id_mapel]'"));
                      			?>
                            <tr>
                                <td><?php echo $nomor++ ?></td>
                                <td><?php echo $rkelas['nama_mapel'] ?></td>
                                <td><?php echo $rkelas['nama_kelas'] ?></td>
                                <td>
                                    <a href="?pages=<?php echo 'tujuan-pembelajaran'?>&orderID=<?php echo $rkelas['id_mapel_kelas']?>"
                                        class="btn btn-primary " data-toggle="tooltip" data-placement="top"
                                        title="Lihat Tujuan Pembelajaran"><i class="fas fa-eye"></i>
                                        <?php
                                        $jumlah_tp = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$rkelas[id_kelas]' AND id_mapel='$rkelas[id_mapel]'"));
                                        echo " ".$jumlah_tp;
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="?pages=<?php echo 'penilaian'?>&orderID=<?php echo $rkelas['id_mapel_kelas']?>"
                                        class="btn btn-success "><i class="fas fa-book"></i> Nilai</a>
                                    <?php if($jumlahproyek > 0){ ?>
                                    <a href="?pages=<?php echo 'penilaian-profil-pancasila'?>&orderID=<?php echo $rkelas['id_mapel_kelas']?>"
                                        class="btn btn-danger ">Nilai P5</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.row -->
</section><!-- /.content -->



<?php } ?>