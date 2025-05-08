<?php if(empty($_GET['act'])){ ?>
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h4 class="page-title">Cetak Rapor Prakerin</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-4 text-right">
                    <a href="../assets/download/rapor-pkl-all.php?kelasID=<?php echo $datakelas['id_kelas']?>&dataID=<?php echo $_SESSION['id_user']?>" 
                       target="_blank" class="btn btn-primary">
                        <i class="fa fa-print"></i> Cetak Semua
                    </a>
                </div>
                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" 
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">NISN</th>
                            <th>Nama Lengkap</th>
                            <th width="10%">Cetak</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        $siswa = mysqli_query($mysqli, "SELECT DISTINCT sw.* 
                            FROM siswa_prakerin sp 
                            JOIN siswa sw ON sp.id_siswa = sw.id_siswa
                            JOIN siswa_kelas sk ON sw.id_siswa = sk.id_siswa
                            WHERE sk.tahun='$sekolah[tahun]' 
                            AND sk.semester='$sekolah[semester]'
                            AND sk.id_kelas='$datakelas[id_kelas]'
                            ORDER BY sw.nama_siswa ASC");
                        
                        while($data = mysqli_fetch_array($siswa)){
                        ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $data['nisn'] ?></td>
                            <td><?php echo $data['nama_siswa'] ?></td>
                            <td class="text-center">
                                <a href="../assets/download/rapor-pkl.php?orderID=<?php echo $data['id_siswa']?>" 
                                   target="_blank" class="btn btn-primary btn-sm">
                                    <i class="fa fa-print"></i> Cetak
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php } ?>