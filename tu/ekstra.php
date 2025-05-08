<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
    <h1>
        Ekstrakurikuler Sekolah
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card border-danger">
                <div class="card-header text-white">
                    <h3 class="card-title">Daftar Ekstrakurikuler Sekolah</h3>
                    <div class="float-right">
                        <a href="?pages=ekstra&filter=<?php echo 'tambah' ?>" class="btn btn-primary ">Tambah
                            Data</a>
                        <?php if($sekolah['semester'] == 2){ ?>
                        <button type="button" class="btn btn-warning " data-toggle="modal"
                            data-target="#myModalSalin">Salin Data</button>
                        <?php } ?>
                    </div>
                </div><!-- /.card-header -->


                <div class="modal fade" id="myModalSalin" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5 class="modal-title">Konfirmasi Salin Penugasan Eskul</h5>
                            </div>
                            <div class="modal-body">
                                <form method="POST">

                                    <div class="form-group">
                                        <label>
                                            <h5>Yakin akan melakukan Salin Semester Penugasan dan Keanggotaan Eskul?
                                            </h5>
                                        </label>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" name="salineskul" class="btn btn-success">Salin Penugasan
                                            Eskul</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php  
                      if (isset($_POST['salineskul'])) {
                          $ambildata = mysqli_query($mysqli,"SELECT * FROM pembina_eskul WHERE tahun='$sekolah[tahun]' AND semester='1'");
                          while ($rambildata = mysqli_fetch_array($ambildata)) {
                            $id_eskul = $rambildata['id_eskul'];
                            $id_user = $rambildata['id_user'];

                            $cekdata = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM pembina_eskul WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$id_eskul' AND id_user='$id_user'"));
                            if ($cekdata == 0) {
                                mysqli_query($mysqli,"INSERT INTO pembina_eskul SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_eskul='$id_eskul', id_user='$id_user'");
                            }
                          }

                            $ambildatasiswaeskul = mysqli_query($mysqli,"SELECT * FROM siswa_eskul WHERE tahun='$sekolah[tahun]' AND semester='1'");
                            while ($rambildataeskul = mysqli_fetch_array($ambildatasiswaeskul)) {
                            $id_eskul = $rambildataeskul['id_eskul'];
                            $id_siswa = $rambildataeskul['id_siswa'];

                            $cekdata = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM siswa_eskul WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$id_eskul' AND id_siswa='$id_siswa'"));
                            if ($cekdata == 0) {
                                mysqli_query($mysqli,"INSERT INTO siswa_eskul SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_eskul='$id_eskul', id_siswa='$id_siswa'");
                            }
                          }
                            ?>
                <script type="text/javascript">
                window.location.href = "?pages=ekstra";
                </script>
                <?php

                      }
                      ?>


                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ekstrakurikuler</th>
                                <th>Pembina Eskul</th>
                                <th>Total Anggota</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                $nomor=1;
                $eskul = mysqli_query($mysqli,"SELECT * FROM eskul ORDER BY id_eskul ASC");
                while($reskul = mysqli_fetch_array($eskul)){
                    $jumlahpembina = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM pembina_eskul WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$reskul[id_eskul]'"));
                    $jumlahsiswa = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM siswa_eskul WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$reskul[id_eskul]'"));
            ?>
                            <tr>
                                <td><?php echo $nomor++ ?></td>
                                <td><?php echo $reskul['nama_eskul'] ?></td>
                                <td>
                                    <a href="" class="btn btn-primary " data-toggle="modal"
                                        data-target="#myModalPilihPembina<?php echo $reskul['id_eskul']?>">
                                        <?php if($jumlahpembina==0){ ?>
                                        Pilih Pembina
                                        <?php } else { 
                                            $no=1; 
                                            $pembina = mysqli_query($mysqli,"SELECT * FROM pembina_eskul 
                                                JOIN users ON pembina_eskul.id_user = users.id_user
                                                WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$reskul[id_eskul]'");
                                            while($rpembina = mysqli_fetch_array($pembina)){
                                        ?>
                                        <?php echo $no++.". ".$rpembina['nama']."<br>"; ?>
                                        <?php } } ?>
                                    </a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="myModalPilihPembina<?php echo $reskul['id_eskul']?>"
                                        role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title">Pilih Pembina
                                                        <?php echo $reskul['nama_eskul'] ?></h5>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST">
                                                        <input type="hidden" name="id_eskul"
                                                            value="<?php echo $reskul['id_eskul'] ?>">
                                                        <table id="datatable"
                                                            class="table table-striped table-bordered">
                                                            <tr>
                                                                <td style="text-align: center;">No</td>
                                                                <td style="text-align: center;">Select</td>
                                                                <td style="text-align: center;">Nama Pendidik</td>
                                                                <td style="text-align: center;">NIP</td>
                                                            </tr>
                                                            <?php  
                                                                $nou = 1;
                                                                $users = mysqli_query($mysqli,"SELECT * FROM users WHERE jabatan='3' ORDER BY id_user ASC");
                                                                while ($rusers = mysqli_fetch_array($users)) {
                                                                    $jumlahpembinacek = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM pembina_eskul WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$reskul[id_eskul]' AND id_user='$rusers[id_user]'"));
                                                                    $ceke = ($jumlahpembinacek == 1) ? "checked" : "";
                                                            ?>
                                                            <tr>
                                                                <td style="text-align: center;"><?php echo $nou++ ?>
                                                                </td>
                                                                <td style="text-align: center;">
                                                                    <input type="checkbox" name="user[]"
                                                                        value="<?php echo $rusers['id_user']?>"
                                                                        <?php echo $ceke ?>>
                                                                </td>
                                                                <td><?php echo $rusers['nama'] ?></td>
                                                                <td><?php echo $rusers['nip'] ?></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </table>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="simpanpembina"
                                                                class="btn btn-success">Update Pembina</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php  
                                        if (isset($_POST['simpanpembina'])) {
                                            $id_eskul = $_POST['id_eskul'];
                                            $id_user = $_POST['user'];

                                            mysqli_query($mysqli,"DELETE FROM pembina_eskul WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$id_eskul'");

                                            $jumlahuser = count($id_user); 
                                            for ($i=0; $i < $jumlahuser; $i++) { 
                                                $simpan = mysqli_query($mysqli,"INSERT INTO pembina_eskul SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_eskul='$id_eskul', id_user='$id_user[$i]' ");
                                                ?><script type="text/javascript">
                                    alert('Berhasil');
                                    window.location.href = "?pages=<?php echo $_GET['pages'] ?>";
                                    </script><?php
                                            }
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo 'daftar-anggota-eskul' ?>&orderID=<?php echo $reskul['id_eskul'] ?>"
                                        class="btn btn-primary ">
                                        <?php echo ($jumlahsiswa==0) ? "Pilih Anggota" : $jumlahsiswa." Anggota"; ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="?pages=ekstra&filter=edit&dataID=<?php echo $reskul['id_eskul'] ?>"
                                        class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Detail</a>
                                    <a href="?pages=ekstra&filter=hapus&dataID=<?php echo $reskul['id_eskul'] ?>"
                                        onclick="return confirm('Yakin ?')" class="btn btn-danger btn-xs"><i
                                            class="fa fa-trash"></i> Hapus</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div><!-- /.row -->

</section><!-- /.content -->

<?php }elseif($_GET['filter']=="daftar-anggota-eskul"){ 
      $dataeskul = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM eskul WHERE id_eskul='$_GET[orderID]'"));
      ?>
<section class="content-header">
    <h1>
        Daftar Anggota <?php echo $dataeskul['nama_eskul'] ?>
    </h1>
</section>
<form method="POST">
    <section class="content-header">
        <a href="?pages=<?php echo $_GET['pages'] ?>" class="btn btn-primary ">Kembali</a>
        <a href="" class="btn btn-success " data-toggle="modal" data-target="#myModal">Tambah Anggota</a>
        <button type="submit" name="hapusanggota" class="btn btn-danger " onclick="return confirm('Yakin?')">Hapus
            Anggota</button>
    </section>



    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-danger">
                    <div class="card-header text-white">
                        <h3 class="card-title">Daftar Anggota <?php echo $dataeskul['nama_eskul'] ?></h3>
                        <div class="float-right">
                            <!-- Optionally, add buttons here if needed -->
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th><input type="checkbox" id="selectAll">Pilih</th>
                                    <th>Nama PD</th>
                                    <th>NISN</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                            $nomor=1;
                            $siswa = mysqli_query($mysqli,"SELECT * FROM siswa_eskul 
                            JOIN siswa ON siswa_eskul.id_siswa = siswa.id_siswa
                            WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$_GET[orderID]' ORDER BY nama_siswa ASC");
                            while ($rsiswa = mysqli_fetch_array($siswa)) {
                              $datakelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$rsiswa[id_siswa]'"));
                              $kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE id_kelas='$datakelas[id_kelas]'"));
                            ?>
                                <tr>
                                    <td><?php echo $nomor++ ?></td>
                                    <td><input type="checkbox" name="siswa[]"
                                            value="<?php echo $rsiswa['id_siswa_eskul'] ?>"></td>
                                    <td><?php echo $rsiswa['nama_siswa'] ?></td>
                                    <td><?php echo $rsiswa['nisn'] ?></td>
                                    <td><?php echo $kelas['nama_kelas'] ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</form>

<?php  
          if (isset($_POST['hapusanggota'])) {
              $siswa = $_POST['siswa'];
              $jumlahsiswa = count($siswa);

              for ($i=0; $i <$jumlahsiswa ; $i++) { 
                  $hapus = mysqli_query($mysqli,"DELETE FROM siswa_eskul WHERE id_siswa_eskul='$siswa[$i]'");

                  ?>
<script type="text/javascript">
alert('Berhasil');
window.location.href =
    "?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo $_GET['filter'] ?>&orderID=<?php echo $_GET['orderID'] ?>";
</script>
<?php
              }
          }
          ?>



<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Pilih Anggota Eskul</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST">

                    <table id="datatable" class="table table-bordered table-striped" data-page-length="50">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>Nama PD</th>
                                <th>NISN</th>
                                <th>Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                            $nomor=1;
                            $siswakelas = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
                            JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                            WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' ORDER BY id_tingkat, id_kelas, nama_siswa ASC");
                            while ($rsiswakelas = mysqli_fetch_array($siswakelas)) {
                                $kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE id_kelas='$rsiswakelas[id_kelas]'"));
                                $jumlahsiswaeskul = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM siswa_eskul WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$_GET[orderID]' AND id_siswa='$rsiswakelas[id_siswa]'"));
                            ?>
                            <?php if($jumlahsiswaeskul == 0){ ?>
                            <tr>
                                <td><?php echo $nomor++ ?></td>
                                <td><input type="checkbox" name="siswa[]"
                                        value="<?php echo $rsiswakelas['id_siswa'] ?>"></td>
                                <td><?php echo $rsiswakelas['nama_siswa'] ?></td>
                                <td><?php echo $rsiswakelas['nisn'] ?></td>
                                <td><?php echo $kelas['nama_kelas'] ?></td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>

                    <div class="modal-footer">
                        <button type="submit" name="updateanggota" class="btn btn-success">Update Anggota</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('selectAll').onclick = function() {
    var checkboxes = document.getElementsByName('siswa[]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
};
</script>


<?php  
          if (isset($_POST['updateanggota'])) {
              $siswa = $_POST['siswa'];
              $jumlahsiswa2 = count($siswa);

              for ($k=0; $k <$jumlahsiswa2 ; $k++) { 
                  mysqli_query($mysqli,"INSERT INTO siswa_eskul SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_eskul='$_GET[orderID]', id_siswa='$siswa[$k]'");

                  ?><script type="text/javascript">
alert('Berhasil');
window.location.href =
    "?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo $_GET['filter'] ?>&orderID=<?php echo $_GET['orderID'] ?>";
</script><?php
              }
          }
          ?>










<?php }elseif($_GET['filter']=="tambah"){ ?>
<section class="content-header">
    <h1>
        Form Tambah Ekstrakurikuler Sekolah
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
                        <h3 class="card-title">Form Tambah Ekstrakurikuler Sekolah</h3>
                        <div class="float-right">
                            <a href="?pages=ekstra" class="btn btn-primary ">Kembali</a>
                            <button type="submit" name="simpandata" class="btn btn-success ">Simpan Data</button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <input type="hidden" name="kode" value="<?php echo $kode ?>">

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Nama Ekstrakurikuler</td>
                                        <td><input type="text" name="nama_eskul" class="form-control" required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.row -->
</section><!-- /.content -->


<?php  
    if (isset($_POST['simpandata'])) {
        $nama_eskul = $_POST['nama_eskul'];
        $kode = $_POST['kode'];
        
            $simpan = mysqli_query($mysqli,"INSERT INTO eskul SET kode='$kode', id_sekolah='$sekolah[id_sekolah]', nama_eskul='$nama_eskul'");
            if ($simpan) {
?>
<script type="text/javascript">
alert('Berhasil');
window.location.href = "?pages=ekstra";
</script>
<?php
            }
    }
?>


<?php }elseif($_GET['filter']=="edit"){ 
    	$eskul = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM eskul WHERE id_eskul='$_GET[dataID]'"));
    	?>
<section class="content-header">
    <h3>
        Form Edit Ekstrakurikuler Sekolah
    </h3>
</section>

<section class="content-header">
    <a href="?pages=ekstra" class="btn btn-primary">Kembali</a>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->

            <div class="card border-danger">
                <div class="card-header text-white">
                    <h3 class="card-title">Form Edit Ekstrakurikuler Sekolah</h3>
                    <div class="float-right">
                        <!-- Optional tools -->
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <input type="hidden" name="kode" value="<?php echo $kode ?>">

                    <div class="row">
                        <div class="col-md-12">
                            <form method="POST">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Nama Ekstrakurikuler</td>
                                        <td><input type="text" name="nama_eskul" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $eskul['nama_eskul'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">
                                            <button type="submit" name="editdata" class="btn btn-success ">Simpan
                                                Data</button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <?php  
                        if (isset($_POST['editdata'])) {
                            $nama_eskul = $_POST['nama_eskul'];

                            $simpan = mysqli_query($mysqli,"UPDATE eskul SET nama_eskul='$nama_eskul' WHERE id_eskul='$_GET[dataID]'");
                            if ($simpan) {
                                ?>
                        <script type="text/javascript">
                        alert('Berhasil');
                        window.location.href = "?pages=ekstra";
                        </script>
                        <?php
                            }
                        }
                        ?>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>&action=pembina"
                                    class="btn btn-warning ">Pembina</a>
                                <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>&action=anggota"
                                    class="btn btn-success ">Anggota</a>
                            </p>

                            <?php if(empty($_GET['action']) || $_GET['action'] == "pembina"){ ?>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pembina</th>
                                        <th>NIP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    $nomor=1;
                                    $pembina = mysqli_query($mysqli,"SELECT * FROM pembina_eskul 
                                    JOIN users ON pembina_eskul.id_user = users.id_user
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$_GET[dataID]' ORDER BY id_pembina_eskul ASC");
                                    while ($rpembina = mysqli_fetch_array($pembina)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $nomor++ ?></td>
                                        <td><?php echo $rpembina['nama'] ?></td>
                                        <td><?php echo $rpembina['nip'] ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <?php } elseif ($_GET['action'] == "anggota"){ ?>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama PD</th>
                                        <th>NISN</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    $nomor=1;
                                    $anggota = mysqli_query($mysqli,"SELECT * FROM siswa_eskul 
                                    JOIN siswa ON siswa_eskul.id_siswa = siswa.id_siswa
                                    JOIN jenis_kelamin ON siswa.kelamin = jenis_kelamin.id_jenis_kelamin
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$_GET[dataID]' ORDER BY nama_siswa ASC");
                                    while ($ranggota = mysqli_fetch_array($anggota)) {
                                      $datakelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$ranggota[id_siswa]'"));
                                      $kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]'"));
                                    ?>
                                    <tr>
                                        <td><?php echo $nomor++ ?></td>
                                        <td><?php echo $ranggota['nama_siswa'] ?></td>
                                        <td><?php echo $ranggota['nisn'] ?></td>
                                        <td><?php echo $ranggota['jenis_kelamin'] ?></td>
                                        <td><?php echo $kelas['nama_kelas'] ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
</section><!-- /.content -->





<?php }elseif($_GET['filter']=="hapus"){ 

    	$hapuseskul = mysqli_query($mysqli,"DELETE FROM eskul WHERE id_eskul='$_GET[dataID]'");
    	$hapuspembina = mysqli_query($mysqli,"DELETE FROM pembina_eskul WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$_GET[dataID]'");
    	$hapusanggota = mysqli_query($mysqli,"DELETE FROM anggota_eskul WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$_GET[dataID]'");

    	if ($hapuseskul || $hapuspembina || $hapusanggota ) {
        	?><script type="text/javascript">
alert('Berhasil');
window.location.href = "?pages=ekstra";
</script><?php
        }

    	?>

<?php }elseif($_GET['filter']=="hapuspembina"){ 

      $hapuspembina = mysqli_query($mysqli,"DELETE FROM pembina_eskul WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_pembina='$_GET[orderID]'");
      

      if ($hapuspembina) {
          ?><script type="text/javascript">
alert('Berhasil');
window.location.href = "?pages=ekstra&filter=<?php echo 'edit' ?>&dataID=<?php echo $_GET['dataID'] ?>";
</script><?php
        }

      ?>




<?php } ?>