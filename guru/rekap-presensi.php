<div class="page-title-box">
    <div class="btn-group float-right">
    </div>
    <h1 class="page-title">Rekap Presensi Kelas <?php echo $datakelas['nama_kelas']?></h1>
</div>

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card border-danger">
                <div class="card-header bg-danger">
                    <h3 class="card-title  text-white">Rekap Presensi Semester</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="font-size: 12px;">
                            <thead>
                                <tr class="bg-warning">
                                    <th class="text-center align-middle" rowspan="2">No</th>
                                    <th class="text-center align-middle" rowspan="2">NISN</th>
                                    <th class="text-center align-middle" rowspan="2">Nama Peserta Didik</th>
                                    <?php
                                    $bulanan = mysqli_query($mysqli,"SELECT * FROM bulanan WHERE semester='$sekolah[semester]' ORDER BY id_bulanan ASC");
                                    while($rbulanan = mysqli_fetch_array($bulanan)){
                                    ?>
                                    <th class="text-center align-middle" colspan="4">
                                        <?php echo $rbulanan['bulanan']?> [<?php echo $rbulanan['id_bulanan']?>]
                                    </th>
                                    <?php } ?>
                                </tr>
                                <tr class="bg-warning">
                                    <?php
                                    $bulanan = mysqli_query($mysqli,"SELECT * FROM bulanan WHERE semester='$sekolah[semester]' ORDER BY id_bulanan ASC");
                                    while($rbulanan = mysqli_fetch_array($bulanan)){
                                    
                                    $absen = mysqli_query($mysqli,"SELECT * FROM absen ORDER BY id_absen ASC");
                                    while($rabsen = mysqli_fetch_array($absen)){
                                    ?>
                                    <th class="text-center align-middle"><?php echo $rabsen['sort']?></th>
                                    <?php } ?>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                                $nomor=1;
                                $kelas = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
                                JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                                WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]'  ORDER BY nama_siswa ASC");
                                while($rkelas = mysqli_fetch_array($kelas)){
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $nomor++ ?></td>
                                    <td class="text-center">
                                        <?php echo $rkelas['nisn'] ?>
                                        <input type="hidden" name="siswa[]" multiple
                                            value="<?php echo $rkelas['id_siswa']?>" />
                                    </td>
                                    <td><?php echo $rkelas['nama_siswa'] ?></td>
                                    <?php
                                    $bulanan = mysqli_query($mysqli,"SELECT * FROM bulanan WHERE semester='$sekolah[semester]' ORDER BY id_bulanan ASC");
                                    while($rbulanan = mysqli_fetch_array($bulanan)){
                                    
                                    $absen = mysqli_query($mysqli,"SELECT * FROM absen ORDER BY id_absen ASC");
                                    while($rabsen = mysqli_fetch_array($absen)){
                                        
                                        $jumlahdata = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM presensi WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND bulan=LPAD('$rbulanan[id_bulanan]', 2, '0') AND  id_absen='$rabsen[id_absen]' AND id_siswa='$rkelas[id_siswa]' "));
                                    
                                    ?>
                                    <td class="text-center align-middle">
                                        <?php if($jumlahdata==0){ echo "";}else{ echo $jumlahdata;} ?>
                                    </td>
                                    <?php } ?>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>