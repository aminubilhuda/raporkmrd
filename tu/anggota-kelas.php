<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
    <h1>
        Rombongan Belajar Sekolah
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card border-danger">
                <div class="card-header text-white">
                    <h3 class="card-title">Daftar Rombongan Belajar Sekolah</h3>
                    <div class="card-tools float-right">
                        <!-- Placeholder for additional tools if needed -->
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body table-responsive-sm">
                    <table id="datatable" class="table table-striped table-bordered ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kelas</th>
                                <th>Tingkat</th>
                                <th>Program Keahlian</th>
                                <th>Fase</th>
                                <th>Wali Kelas</th>
                                <th>Total Anggota</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                                $nomor=1;
                                $kelas = mysqli_query($mysqli,"SELECT * FROM kelas ORDER BY id_tingkat, id_kelas ASC");
                                while($rkelas = mysqli_fetch_array($kelas)){
                                    $tingkat = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tingkat WHERE id_tingkat='$rkelas[id_tingkat]'"));
                                    $keahlian = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kompetensi_keahlian WHERE id_kompetensi_keahlian='$rkelas[id_kompetensi_keahlian]'"));
                                    $guru = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas_wali 
                                    JOIN users ON kelas_wali.id_user = users.id_user
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$rkelas[id_kelas]'"));
                                ?>
                            <tr>
                                <td><?php echo $nomor++ ?></td>
                                <td><?php echo $rkelas['nama_kelas'] ?></td>
                                <td><?php echo $tingkat['tingkat'] ?></td>
                                <td><?php echo $keahlian['kompetensi_keahlian'] ?></td>
                                <td><?php echo $tingkat['fase'] ?></td>
                                <td><?php echo $guru['nama'] ?></td>
                                <td>
                                    <?php  
                                        echo 
                                        $jumlahanggota = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$rkelas[id_kelas]' AND status='1'"));
                                        ?>
                                </td>
                                <td>
                                    <a href="?pages=anggota-kelas&filter=<?php echo 'edit' ?>&dataID=<?php echo $rkelas['id_kelas'] ?>"
                                        class="btn btn-warning" data-toggle="tooltip" title="Detail">
                                        <i class="fas fa-info"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.row -->
</section><!-- /.content -->




<?php }elseif($_GET['filter']=="edit"){ 
    	$kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE id_kelas='$_GET[dataID]'"));
    	?>
<section class="content-header">
    <h1>
        Daftar Keanggotaan Kelas
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <form method="POST">
                <div class="card border-danger">
                    <div class="card-header text-white">
                        <h3 class="card-title">Daftar Keanggotaan Kelas <?php echo $kelas['nama_kelas'] ?></h3>
                        <div class="float-right">
                            <a href="?pages=anggota-kelas" class="btn btn-primary ">Kembali</a>
                            <button type="button" class="btn btn-success " data-toggle="modal"
                                data-target="#myModal">Tambah Data</button>
                            <?php if($sekolah['semester'] == 2){ ?>
                            <button type="button" class="btn btn-warning " data-toggle="modal"
                                data-target="#myModalSalinData">Salin Data</button>
                            <?php } ?>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="modal fade" id="myModalSalinData" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h5 class="modal-title">Konfirmasi Salin Data</h5>
                                </div>
                                <div class="modal-body">
                                    <form method="POST">
                                        <?php  
                                        $kelasbaru = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[dataID]'"));
                                        $kelaslama = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM kelas WHERE tahun='$sekolah[tahun]' AND semester='1' AND nama_kelas='$kelasbaru[nama_kelas]'"));
                                        ?>
                                        <input type="hidden" name="kelasID" value="<?php echo $kelas['id_kelas'] ?>">
                                        <div class="form-group text-center">
                                            <label>
                                                <h5>Yakin akan malakukan Salin Data Semester?</h5>
                                            </label>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="salinanggota" class="btn btn-success">Salin
                                                Anggota Kelas</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php  
                    if (isset($_POST['salinanggota'])) {
                        $kelaslama = $_POST['kelasID'];
                        $kelas = mysqli_query($mysqli, "SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='1' AND id_kelas='$kelaslama' AND status='1'");
                        while ($rkelas = mysqli_fetch_array($kelas)) {
                            $id_siswa = $rkelas['id_siswa'];
                            $id_tingkat = $rkelas['id_tingkat'];

                            $cekdata = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_tingkat='$id_tingkat' AND id_siswa='$id_siswa'"));

                            if ($cekdata == 0) {
                                mysqli_query($mysqli, "INSERT INTO siswa_kelas SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_tingkat='$id_tingkat', id_kelas='$_GET[dataID]', id_siswa='$id_siswa', status='1'");
                            }
                        }
                        ?><script type="text/javascript">
                    window.location.href =
                        "?pages=anggota-kelas&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>";
                    </script><?php
                    }
                    ?>

                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title">Select Anggota Kelas</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST">
                                        <!-- Tabel responsif -->
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                                style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th><input type="checkbox" id="selectAll"></th>
                                                        <th>Nama Peserta Didik</th>
                                                        <!-- <th>Tempat, Tanggal Lahir</th> -->
                                                        <th>Terima Di</th>
                                                        <th>Jurusan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php  
                                $no=1;
                                $siswa = mysqli_query($mysqli, "SELECT * FROM siswa WHERE jenis_siswa < 3 AND aktif='1' ORDER BY nama_siswa ASC");
                                while ($rsiswa = mysqli_fetch_array($siswa)) {
                                    $jumlahkeanggotaan = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$rsiswa[id_siswa]'"));
                                ?>
                                                    <?php if ($jumlahkeanggotaan == 0) { ?>
                                                    <tr>
                                                        <td><?php echo $no++ ?></td>
                                                        <td><input type="checkbox" name="siswa[]"
                                                                value="<?php echo $rsiswa['id_siswa'] ?>"></td>
                                                        <td><?php echo $rsiswa['nama_siswa'] ?></td>
                                                        <!-- <td><?php echo $rsiswa['tempat_lahir'] ?>,
                                                            <?php echo $rsiswa['tanggal_lahir'] ?></td> -->
                                                        <td><?php echo $rsiswa['terima_kelas'] ?></td>
                                                        <td><?php echo $rsiswa['jurusan'] ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="tambahanggota" class="btn btn-success">Tambah
                                                Anggota</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php  
                    if (isset($_POST['tambahanggota'])) {
                        $siswa = $_POST['siswa'];
                        $jumlahsiswa = count($siswa);

                        if ($jumlahsiswa == 0) {
                            ?><script type="text/javascript">
                    alert('No Data');
                    window.location.href =
                        "?pages=anggota-kelas&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>";
                    </script><?php
                        } else {
                            for ($i = 0; $i < $jumlahsiswa; $i++) {
                                $simpan = mysqli_query($mysqli, "INSERT INTO siswa_kelas SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_tingkat='$kelas[id_tingkat]', id_kelas='$_GET[dataID]', id_siswa='$siswa[$i]', status='1'");
                                if ($simpan) {
                                    ?><script type="text/javascript">
                    alert('Berhasil menambahkan <?php echo $jumlahsiswa ?> ke dalam kelas');
                    window.location.href =
                        "?pages=anggota-kelas&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>";
                    </script><?php
                                }
                            }
                        }
                    }
                    ?>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Peserta Didik</th>
                                            <th>NIS / NISN</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Agama</th>
                                            <th>Tempat, Tanggal Lahir</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  
                                        $nomor=1;
                                        $anggota = mysqli_query($mysqli, "SELECT * FROM siswa_kelas 
                                        JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                                        WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[dataID]' AND status='1' ORDER BY nama_siswa ASC");
                                        while ($ranggota = mysqli_fetch_array($anggota)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $nomor++ ?></td>
                                            <td><?php echo $ranggota['nama_siswa'] ?></td>
                                            <td><?php echo $ranggota['nis'] ?> / <?php echo $ranggota['nisn'] ?></td>
                                            <td><?php echo $ranggota['kelamin'] == 1 ? "Laki-laki" : "Perempuan"; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                switch ($ranggota['agama']) {
                                                    case 1: echo "Islam"; break;
                                                    case 2: echo "Katholik"; break;
                                                    case 3: echo "Kristen"; break;
                                                    case 4: echo "Hindu"; break;
                                                    case 5: echo "Budha"; break;
                                                    case 6: echo "Kong Hu Chu"; break;
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $ranggota['tempat_lahir'] ?>,
                                                <?php echo $ranggota['tanggal_lahir'] ?></td>
                                            <td>
                                                <button type="button" class="btn btn-danger "
                                                    onclick="confirmDelete('<?php echo $_GET['dataID'] ?>', '<?php echo $ranggota['id_siswa_kelas'] ?>')"><i
                                                        class="fa fa-trash"></i> </button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.row -->
</section><!-- /.content -->





<?php }elseif($_GET['filter']=="hapus"){ 

    	$hapusanggota = mysqli_query($mysqli,"DELETE FROM siswa_kelas WHERE id_siswa_kelas='$_GET[siswaID]'");

    	if ($hapusanggota) {
        	?><script type="text/javascript">
alert('Berhasil');
window.location.href = "?pages=anggota-kelas&filter=<?php echo 'edit'?>&dataID=<?php echo $_GET['dataID'] ?>";
</script><?php
        }

    	?>




<?php } ?>



<script>
document.getElementById('selectAll').onclick = function() {
    var checkboxes = document.getElementsByName('siswa[]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
};
</script>
<script>
function confirmDelete(dataID, siswaID) {
    if (confirm('Yakin ingin menghapus anggota ini?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET',
            '?pages=anggota-kelas&filter=hapus&dataID=' +
            dataID + '&siswaID=' + siswaID, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert('Berhasil menghapus anggota');
                location.reload();
            }
        };
        xhr.send();
    }
}
</script>