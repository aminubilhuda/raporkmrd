<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
  <h1>
    Praktek Kerja Industri
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- USERS LIST -->
      <div class="card border-danger">
        <div class="card-header text-white">
          <h3 class="card-title">Praktek Kerja Industri</h3>
          <div class="float-left">
            <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo 'tambah' ?>" class="btn btn-primary">Tambah
              Data</a>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importModal">
              <i class="fas fa-file-excel"></i> Import Excel
            </button>
          </div>
        </div><!-- /.card-header -->
        <div class="card-body table-responsive">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Mitra DU/DI</th>
                <th>Lokasi</th>
                <th>Lamanya (Bulan)</th>
                <th>Guru Pendamping</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php  
                            $nomor=1;
                            $eskul = mysqli_query($mysqli,"SELECT * FROM prakerin WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' ORDER BY id_prakerin ASC");
                            while($reskul = mysqli_fetch_array($eskul)){

                                $pendamping = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$reskul[id_user]'"));

                                $tanggalawal = date_create($reskul['tanggal_mulai']);
                                $tanggalakhir = date_create($reskul['tanggal_akhir']);

                                $interval = date_diff($tanggalawal, $tanggalakhir); 
                              
                            ?>
              <tr>
                <td><?php echo $nomor++ ?></td>
                <td><?php echo $reskul['mitra'] ?></td>
                <td><?php echo $reskul['lokasi'] ?></td>
                <td><?php echo $interval->m . ' Bulan' ?></td>
                <td><?php echo $pendamping['nama'] ?></td>
                <td>
                  <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo 'edit' ?>&dataID=<?php echo $reskul['id_prakerin'] ?>"
                    class="btn btn-warning"><i class="fa fa-pencil"></i> Detail</a>

                  <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo 'hapus-prakerin' ?>&dataID=<?php echo $reskul['id_prakerin'] ?>"
                    onclick="return confirm('Yakin ?')" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div><!-- /.row -->
</section><!-- /.content -->

<?php
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    ?>
    <script>
        Swal.fire({
            title: '<?php echo $flash['type'] === 'success' ? 'Berhasil!' : 'Perhatian!'; ?>',
            text: '<?php echo str_replace("\n", "\\n", addslashes($flash['message'])); ?>',
            icon: '<?php echo $flash['type']; ?>',
            width: '600px',
            padding: '3em'
        });
    </script>
    <?php
}
?>

<!-- Modal Import Excel -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Import Data Prakerin</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form method="POST" action="prakerin-upload.php" enctype="multipart/form-data">
          <div class="form-group">
            <label>Pilih File Excel (Format: .xlsx)</label>
            <input type="file" name="file_excel" class="form-control" required accept=".xlsx">
            <small class="text-muted">Download <a href="assets/format/format_import_prakerin.xlsx">Format
                Excel</a></small>
          </div>
          <div class="modal-footer">
            <button type="submit" name="import" class="btn btn-success">Import</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php }elseif($_GET['filter']=="tambah"){ ?>
<section class="content-header">
  <h1>
    Form Tambah Data
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
            <h3 class="card-title">Form Tambah Data Prakerin</h3>
            <div class="float-left">
              <a href="?pages=<?php echo $_GET['pages'] ?>" class="btn btn-primary">Kembali</a>
              <button type="submit" name="simpandata" class="btn btn-success">Simpan Data</button>
            </div>
          </div><!-- /.card-header -->
          <div class="card-body">
            <input type="hidden" name="kode" value="<?php echo $kode ?>">

            <div class="row">
              <div class="col-md-12">
                <table class="table table-striped table-bordered">
                  <tr>
                    <td style="width: 30%;">Mitra DU/DI</td>
                    <td><input type="text" name="mitra" class="form-control" required="" autocomplete="off"
                        autofocus=""></td>
                  </tr>

                  <tr>
                    <td style="width: 30%;">Lokasi</td>
                    <td><input type="text" name="lokasi" class="form-control" required="" autocomplete="off"
                        autofocus=""></td>
                  </tr>

                  <tr>
                    <td style="width: 30%;">Tanggal Mulai</td>
                    <td><input type="date" name="tanggal_mulai" class="form-control" required="" autocomplete="off"
                        autofocus=""></td>
                  </tr>

                  <tr>
                    <td style="width: 30%;">Tanggal Akhir</td>
                    <td><input type="date" name="tanggal_akhir" class="form-control" required="" autocomplete="off"
                        autofocus=""></td>
                  </tr>

                  <tr>
                    <td style="width: 30%;">Guru Pendamping</td>
                    <td>
                      <select name="id_user" class="form-control" required="">
                        <option value="" required="">Pilih Pendamping</option>
                        <?php  
                                                $pendamping = mysqli_query($mysqli,"SELECT * FROM users WHERE jabatan='3' ORDER BY id_user ASC");
                                                while ($rpendamping = mysqli_fetch_array($pendamping)) {
                                                ?>
                        <option value="<?php echo $rpendamping['id_user'] ?>">
                          <?php echo $rpendamping['nama'] ?></option>
                        <?php } ?>
                      </select>
                    </td>
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
          $mitra = $_POST['mitra'];
          $lokasi = $_POST['lokasi'];
          $tanggal_mulai = $_POST['tanggal_mulai'];
          $tanggal_akhir = $_POST['tanggal_akhir'];
          $id_user = $_POST['id_user'];
          

            $simpan = mysqli_query($mysqli,"INSERT INTO prakerin SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', mitra='$mitra', lokasi='$lokasi', tanggal_mulai='$tanggal_mulai', tanggal_akhir='$tanggal_akhir', id_user='$id_user'");
            if ($simpan) {
              ?>
<script type="text/javascript">
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages'] ?>";
</script>
<?php
            }
          
        }
        ?>


<?php }elseif($_GET['filter']=="edit"){ 
      $prakerin = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM prakerin WHERE id_prakerin='$_GET[dataID]'"));
      ?>
<section class="content-header">
  <h1>
    Form Edit Prakerin
  </h1>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-4">
      <!-- USERS LIST -->
      <div class="card border-danger">
        <div class="card-header bg-success text-white">
          <h3 class="card-title">Form Edit Data</h3>
          <div class="float-left"><a href="?pages=<?php echo $_GET['pages'] ?>" class="btn btn-primary">Kembali</a>
          </div>
        </div><!-- /.card-header -->
        <div class="card-body">

          <div class="row">
            <div class="col-md-12">
              <form method="POST">
                <table class="table table-striped table-bordered" style="font-size: 11px;">
                  <tr>
                    <td style="width: 30%;">Mitra DU/DI</td>
                    <td><input type="text" name="mitra" class="form-control form-control-sm" required=""
                        autocomplete="off" autofocus="" value="<?php echo $prakerin['mitra'] ?>"></td>
                  </tr>

                  <tr>
                    <td style="width: 30%;">Lokasi</td>
                    <td><input type="text" name="lokasi" class="form-control form-control-sm" required=""
                        autocomplete="off" autofocus="" value="<?php echo $prakerin['lokasi'] ?>"></td>
                  </tr>

                  <tr>
                    <td style="width: 30%;">Tanggal Mulai</td>
                    <td><input type="date" name="tanggal_mulai" class="form-control form-control-sm" required=""
                        autocomplete="off" autofocus="" value="<?php echo $prakerin['tanggal_mulai'] ?>"></td>
                  </tr>

                  <tr>
                    <td style="width: 30%;">Tanggal Akhir</td>
                    <td><input type="date" name="tanggal_akhir" class="form-control form-control-sm" required=""
                        autocomplete="off" autofocus="" value="<?php echo $prakerin['tanggal_akhir'] ?>"></td>
                  </tr>

                  <tr>
                    <td style="width: 30%;">Guru Pendamping</td>
                    <td>
                      <select name="id_user" class="form-control form-control-sm" required="">
                        <option value="" required="">Pilih Pendamping</option>
                        <?php  
                                                $pendamping = mysqli_query($mysqli,"SELECT * FROM users WHERE jabatan='3' ORDER BY id_user ASC");
                                                while ($rpendamping = mysqli_fetch_array($pendamping)) {
                                                    $seleuser = ($prakerin['id_user'] == $rpendamping['id_user']) ? "selected" : "";
                                                ?>
                        <option value="<?php echo $rpendamping['id_user'] ?>" <?php echo $seleuser ?>>
                          <?php echo $rpendamping['nama'] ?></option>
                        <?php } ?>
                      </select>
                    </td>
                  </tr>
                </table>
                <div class="body-footer text-center">
                  <button type="submit" name="simpanedit" class="btn btn-success">Simpan Data</button>
                </div>
            </div>
            </form>
          </div>
          <?php  
                    if (isset($_POST['simpanedit'])) {
                        $mitra = $_POST['mitra'];
                        $lokasi = $_POST['lokasi'];
                        $tanggal_mulai = $_POST['tanggal_mulai'];
                        $tanggal_akhir = $_POST['tanggal_akhir'];
                        $id_user = $_POST['id_user'];

                        $simpan = mysqli_query($mysqli, "UPDATE prakerin SET mitra='$mitra', lokasi='$lokasi', tanggal_mulai='$tanggal_mulai', tanggal_akhir='$tanggal_akhir', id_user='$id_user' WHERE id_prakerin='$_GET[dataID]'");
                        if ($simpan) {
                            ?><script type="text/javascript">
          alert('Berhasil');
          window.location.href = "?pages=<?php echo $_GET['pages'] ?>";
          </script><?php
                        }
                    }
                    ?>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card border-danger">
        <div class="card-header bg-info text-white">
          <h3 class="card-title">Daftar PD Prakerin</h3>
          <div class="float-left">
            <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Tambah
              PD</a>
          </div>
        </div><!-- /.card-header -->
        <div class="card-body">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Peserta Didik</th>
                <th>NISN</th>
                <th>Kelas</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php  
                            $nomor=1;
                            $siswaprakerin = mysqli_query($mysqli,"SELECT * FROM siswa_prakerin 
                            JOIN siswa ON siswa_prakerin.id_siswa = siswa.id_siswa
                            WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_prakerin='$_GET[dataID]' ORDER BY nama_siswa ASC");
                            while ($rsiswaprakerin = mysqli_fetch_array($siswaprakerin)) {
                                $datasiswakelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$rsiswaprakerin[id_siswa]'"));
                                $datakelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE id_kelas='$datasiswakelas[id_kelas]'"));
                            ?>
              <tr>
                <td><?php echo $nomor++ ?></td>
                <td><?php echo $rsiswaprakerin['nama_siswa'] ?></td>
                <td><?php echo $rsiswaprakerin['nisn'] ?></td>
                <td><?php echo $datakelas['nama_kelas'] ?></td>
                <td>
                  <a href="?pages=<?php echo $_GET['pages'] ?>&filter=hapus-siswa-prakerin&dataID=<?php echo $_GET['dataID'] ?>&orderID=<?php echo $rsiswaprakerin['id_siswa_prakerin'] ?>"
                    class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')"><i class="fas fa-trash"></i></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>

          </table>

        </div>
      </div>
    </div>

    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title">Pilih Peserta Prakerin</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="POST">

              <table id="datatable" class="table table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;" data-page-length="25">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Select</th>
                    <th>Nama Peserta Didik</th>
                    <th>NISN</th>
                    <th>Kelas</th>
                  </tr>
                </thead>
                <tbody>
                  <?php  
                                        $nomor = 1;
                                        $siswakelas = mysqli_query($mysqli, "SELECT * FROM siswa_kelas 
                                            JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                                            WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_tingkat > 1 ORDER BY nama_siswa ASC");
                                        
                                        while ($rsiswakelas = mysqli_fetch_array($siswakelas)) {
                                            $datakelas = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM kelas WHERE id_kelas='$rsiswakelas[id_kelas]'"));
                                            $jumlahdatasiswaprakerin = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM siswa_prakerin WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_prakerin='$_GET[dataID]' AND id_siswa='$rsiswakelas[id_siswa]'"));
                                    ?>
                  <?php if ($jumlahdatasiswaprakerin == 0) { ?>
                  <tr>
                    <td><?php echo $nomor++ ?></td>
                    <td><input type="checkbox" name="siswa[]" value="<?php echo $rsiswakelas['id_siswa'] ?>"></td>
                    <td><?php echo $rsiswakelas['nama_siswa'] ?></td>
                    <td><?php echo $rsiswakelas['nisn'] ?></td>
                    <td><?php echo $datakelas['nama_kelas'] ?></td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                </tbody>
              </table>


              <div class="modal-footer">
                <button type="submit" name="tambahpeserta" class="btn btn-success">Tambah
                  Anggota</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.row -->
</section><!-- /.content -->


<?php  
        if (isset($_POST['tambahpeserta'])) {
        	$siswa = $_POST['siswa'];
        	$jumlahsiswa = count($siswa);
        	for ($i=0; $i <$jumlahsiswa ; $i++) { 
        		$simpan = mysqli_query($mysqli,"INSERT INTO siswa_prakerin SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_prakerin='$_GET[dataID]', id_siswa='$siswa[$i]'");
        		if ($simpan) {
        			?><script type="text/javascript">
alert('Berhasil');
window.location.href =
  "?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>";
</script><?php
        		}
        	}
        }
        ?>




<?php }elseif($_GET['filter']=="hapus-siswa-prakerin"){ 

      $hapuseskul = mysqli_query($mysqli,"DELETE FROM siswa_prakerin WHERE id_siswa_prakerin='$_GET[orderID]'");


      if ($hapuseskul) {
          ?><script type="text/javascript">
alert('Berhasil');
window.location.href =
  "?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo 'edit' ?>&dataID=<?php echo $_GET['dataID'] ?>";
</script><?php
        }

      ?>

<?php }elseif($_GET['filter']=="hapus-prakerin"){ 

      $hapuspembina = mysqli_query($mysqli,"DELETE FROM prakerin WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_prakerin='$_GET[dataID]'");
      $hapusprakerin = mysqli_query($mysqli,"DELETE FROM siswa_prakerin WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_prakerin='$_GET[dataID]'");
      

      if ($hapuspembina || $hapusprakerin) {
          ?><script type="text/javascript">
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages'] ?>";
</script><?php
        }

      ?>

<?php } ?>