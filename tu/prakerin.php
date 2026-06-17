<?php
// Auto-create tabel presensi_prakerin jika belum ada
mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `presensi_prakerin` (
  `id_presensi_prakerin` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `tahun` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `id_prakerin` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `sakit` int(11) NOT NULL DEFAULT 0,
  `izin` int(11) NOT NULL DEFAULT 0,
  `alpha` int(11) NOT NULL DEFAULT 0
)");
?>
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
              Data
              Data</a>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importModal">
              <i class="fas fa-file-excel"></i> Import Excel
            </button>
            <button type="button" id="deleteSelected" class="btn btn-danger" style="display:none">
              <i class="fas fa-trash"></i> Hapus Terpilih
            </button>
          </div>
        </div><!-- /.card-header -->
        <div class="card-body table-responsive">
          <form id="deleteForm" method="POST">
            <table id="datatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th><input type="checkbox" id="checkAll"></th>
                  <th>No</th>
                  <th>Mitra DU/DI</th>

                  <th>Guru Pendamping</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php  
                            $nomor=1;
                            
                            // Fetch all Guru Pendamping once to avoid n+1 queries
                            $guru_list = [];
                            $guru_query = mysqli_query($mysqli, "SELECT * FROM users WHERE jabatan='3' ORDER BY nama ASC");
                            while($g = mysqli_fetch_array($guru_query)){
                                $guru_list[] = $g;
                            }

                            $eskul = mysqli_query($mysqli,"SELECT * FROM prakerin WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' ORDER BY id_prakerin ASC");
                            while($reskul = mysqli_fetch_array($eskul)){
                                $tanggalawal = date_create($reskul['tanggal_mulai']);
                                $tanggalakhir = date_create($reskul['tanggal_akhir']);
                                $interval = date_diff($tanggalawal, $tanggalakhir); 
                            ?>
                <tr>
                  <td><input type="checkbox" class="checkbox" name="ids[]"
                      value="<?php echo $reskul['id_prakerin']; ?>"></td>
                  <td><?php echo $nomor++ ?></td>
                  <td><?php echo $reskul['mitra'] ?></td>

                  <td>
                    <select class="form-control form-control-sm guru-dropdown" data-id="<?php echo $reskul['id_prakerin']; ?>" style="min-width: 150px;">
                        <option value="0">- Belum Ditentukan -</option>
                        <?php foreach($guru_list as $g): ?>
                            <option value="<?php echo $g['id_user']; ?>" <?php echo ($reskul['id_user'] == $g['id_user']) ? 'selected' : ''; ?>>
                                <?php echo $g['nama']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                  </td>
                  <td>
                    <button type="button" class="btn btn-info btn-tambah-pd" data-toggle="modal" data-target="#modalTambahPD" data-id="<?php echo $reskul['id_prakerin']; ?>"><i class="fas fa-users"></i> Tambah PD</button>
                    
                    <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo 'edit' ?>&dataID=<?php echo $reskul['id_prakerin'] ?>"
                      class="btn btn-warning"><i class="fa fa-pencil"></i> Detail</a>
                    
                    <a href="?pages=<?php echo $_GET['pages'] ?>&filter=penilaian&dataID=<?php echo $reskul['id_prakerin'] ?>"
                      class="btn btn-success"><i class="fas fa-star"></i> Penilaian</a>

                    <a href="?pages=<?php echo $_GET['pages'] ?>&filter=absensi&dataID=<?php echo $reskul['id_prakerin'] ?>"
                      class="btn btn-secondary"><i class="fas fa-calendar-check"></i> Absensi</a>

                    <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo 'hapus-prakerin' ?>&dataID=<?php echo $reskul['id_prakerin'] ?>"
                      onclick="return confirm('Yakin ?')" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </form>
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
            <small class="text-muted">Download <a href="../assets\format\format_import_prakerin.xlsx">Format
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

<!-- Modal Tambah PD -->
<div class="modal fade" id="modalTambahPD" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Tambah Peserta Didik ke Prakerin</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <input type="hidden" name="id_prakerin" id="modal_id_prakerin" value="">
          
          <div class="form-group">
            <input type="text" id="searchSiswaModal" class="form-control" placeholder="Ketik untuk mencari nama siswa, NISN, atau kelas...">
          </div>
          
          <div style="max-height: 400px; overflow-y: auto;">
            <table class="table table-bordered dt-responsive nowrap datatable-modal" style="width: 100%;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Pilih</th>
                  <th>Nama Peserta Didik</th>
                  <th>NISN</th>
                  <th>Kelas</th>
                </tr>
              </thead>
              <tbody id="siswaModalBody">
              <?php  
              $nomor_modal = 1;
              $siswakelas = mysqli_query($mysqli, "SELECT * FROM siswa_kelas 
                  JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                  JOIN kelas ON siswa_kelas.id_kelas = kelas.id_kelas
                  WHERE siswa_kelas.tahun='$sekolah[tahun]' 
                  AND siswa_kelas.semester='$sekolah[semester]' 
                  AND kelas.id_tingkat > 1 ORDER BY siswa.nama_siswa ASC");
              
              while ($rsiswakelas = mysqli_fetch_array($siswakelas)) {
                  $cekSiswaPrakerin = mysqli_query($mysqli, "SELECT * FROM siswa_prakerin 
                      WHERE tahun='$sekolah[tahun]' 
                      AND semester='$sekolah[semester]' 
                      AND id_siswa='$rsiswakelas[id_siswa]'");
                  
                  if (mysqli_num_rows($cekSiswaPrakerin) == 0) {
              ?>
              <tr>
                <td><?php echo $nomor_modal++ ?></td>
                <td><input type="checkbox" name="siswa[]" value="<?php echo $rsiswakelas['id_siswa'] ?>"></td>
                <td><?php echo $rsiswakelas['nama_siswa'] ?></td>
                <td><?php echo $rsiswakelas['nisn'] ?></td>
                <td><?php echo $rsiswakelas['nama_kelas'] ?></td>
              </tr>
              <?php } } ?>
            </tbody>
          </table>
          </div>
          <div class="modal-footer mt-3">
            <button type="submit" name="tambahpeserta_main" class="btn btn-success">Tambah Peserta</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
if (isset($_POST['tambahpeserta_main'])) {
    if(isset($_POST['siswa']) && !empty($_POST['id_prakerin'])) {
        $siswa = $_POST['siswa'];
        $id_prakerin = $_POST['id_prakerin'];
        $jumlahsiswa = count($siswa);
        $berhasil = 0;
        
        for ($i=0; $i < $jumlahsiswa; $i++) { 
            $simpan = mysqli_query($mysqli,"INSERT INTO siswa_prakerin SET 
                tahun='$sekolah[tahun]', 
                semester='$sekolah[semester]', 
                id_prakerin='$id_prakerin', 
                id_siswa='$siswa[$i]'");
            
            if ($simpan) {
                $berhasil++;
            }
        }
        
        if($berhasil > 0) {
            echo "<script>
                alert('Berhasil menambahkan ".$berhasil." peserta prakerin');
                window.location.href = '?pages=".$_GET['pages']."';
                </script>";
        }
    } else {
        echo "<script>
            alert('Pilih minimal satu siswa!');
            window.location.href = '?pages=".$_GET['pages']."';
            </script>";
    }
}
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality for Modal
    var searchInput = document.getElementById('searchSiswaModal');
    if(searchInput) {
        searchInput.addEventListener('keyup', function() {
            var value = this.value.toLowerCase();
            var rows = document.querySelectorAll('#siswaModalBody tr');
            
            rows.forEach(function(row) {
                var text = row.textContent.toLowerCase();
                row.style.display = text.indexOf(value) > -1 ? '' : 'none';
            });
        });
    }

    document.body.addEventListener('click', function(e) {
        if(e.target && (e.target.classList.contains('btn-tambah-pd') || e.target.parentElement.classList.contains('btn-tambah-pd'))) {
            var btn = e.target.classList.contains('btn-tambah-pd') ? e.target : e.target.parentElement;
            var id = btn.getAttribute('data-id');
            document.getElementById('modal_id_prakerin').value = id;
        }
    });

    document.body.addEventListener('change', function(e) {
        if(e.target && e.target.classList.contains('guru-dropdown')) {
            var id_prakerin = e.target.getAttribute('data-id');
            var id_user = e.target.value;
            
            var formData = new FormData();
            formData.append('id_prakerin', id_prakerin);
            formData.append('id_user', id_user);
            
            fetch('prakerin-update-guru.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(res => {
                if(res.status == 'success') {
                    if(typeof Swal !== 'undefined') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Guru pendamping berhasil diubah'
                        });
                    } else {
                        alert('Guru pendamping berhasil diubah');
                    }
                } else {
                    if(typeof Swal !== 'undefined') Swal.fire('Error', 'Gagal merubah guru pendamping: ' + res.message, 'error');
                    else alert('Gagal merubah guru pendamping: ' + res.message);
                }
            })
            .catch(err => {
                console.error(err);
                if(typeof Swal !== 'undefined') Swal.fire('Error', 'Gagal menghubungi server.', 'error');
                else alert('Gagal menghubungi server.');
            });
        }
    });
});
</script>

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
    <div class="float-right">
      <a href="?pages=<?php echo $_GET['pages'] ?>&filter=penilaian&dataID=<?php echo $_GET['dataID'] ?>"
        class="btn btn-success">
        <i class="fas fa-star"></i> Penilaian Prakerin
      </a>
    </div>
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
    // Fix the typo in semester variable and combine the queries
    $hapus_prakerin = mysqli_query($mysqli, "DELETE FROM prakerin WHERE id_prakerin='$_GET[dataID]'");
    $hapus_siswa_prakerin = mysqli_query($mysqli, "DELETE FROM siswa_prakerin WHERE id_prakerin='$_GET[dataID]'");

    if ($hapus_prakerin && $hapus_siswa_prakerin) {
        ?><script type="text/javascript">
Swal.fire({
  title: "Berhasil!",
  text: "Data prakerin berhasil dihapus",
  icon: "success"
}).then((result) => {
  window.location.href = "?pages=<?php echo $_GET['pages'] ?>";
});
</script><?php
    } else {
        ?><script type="text/javascript">
Swal.fire({
  title: "Gagal!",
  text: "Gagal menghapus data prakerin",
  icon: "error"
});
</script><?php
    }
?>

<?php }elseif($_GET['filter']=="penilaian"){ 
  $prakerin = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM prakerin WHERE id_prakerin='$_GET[dataID]'"));
?>
<section class="content-header">
  <h1>
    Penilaian Prakerin
    <div class="float-right">
      <a href="?pages=<?php echo $_GET['pages'] ?>&filter=edit&dataID=<?php echo $_GET['dataID'] ?>"
        class="btn btn-primary">Kembali</a>
    </div>
  </h1>
</section>

<section class="content">
  <div class="row">
    <!-- Daftar Siswa -->
    <div class="col-md-4">
      <div class="card border-danger">
        <div class="card-header bg-info text-white">
          <h3 class="card-title">Peserta Prakerin - <?php echo $prakerin['mitra'] ?></h3>
        </div>
        <div class="card-body">
          <div class="list-group">
            <?php  
            $siswaprakerin = mysqli_query($mysqli,"SELECT * FROM siswa_prakerin 
              JOIN siswa ON siswa_prakerin.id_siswa = siswa.id_siswa
              WHERE tahun='$sekolah[tahun]' 
              AND semester='$sekolah[semester]' 
              AND id_prakerin='$_GET[dataID]' 
              ORDER BY nama_siswa ASC");
            
            while ($rsiswaprakerin = mysqli_fetch_array($siswaprakerin)) {
              $datasiswakelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
                WHERE tahun='$sekolah[tahun]' 
                AND semester='$sekolah[semester]' 
                AND id_siswa='$rsiswaprakerin[id_siswa]'"));
              
              $datakelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas 
                WHERE id_kelas='$datasiswakelas[id_kelas]'"));
              
              // Hitung jumlah nilai yang sudah diinput
              $jml_nilai = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM nilai_prakerin 
                WHERE tahun='$sekolah[tahun]' 
                AND semester='$sekolah[semester]' 
                AND id_siswa='$rsiswaprakerin[id_siswa]'"));
              
              // Tentukan active tab
              $active = "";
              if(isset($_GET['siswaID']) && $_GET['siswaID'] == $rsiswaprakerin['id_siswa']) {
                $active = "active";
              }
            ?>
            <a href="?pages=<?php echo $_GET['pages'] ?>&filter=penilaian&dataID=<?php echo $_GET['dataID'] ?>&siswaID=<?php echo $rsiswaprakerin['id_siswa'] ?>"
              class="list-group-item list-group-item-action <?php echo $active ?>">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?php echo $rsiswaprakerin['nama_siswa'] ?></h5>
                <span class="badge badge-info"><?php echo $jml_nilai ?> nilai</span>
              </div>
              <small><?php echo $rsiswaprakerin['nisn'] ?> - <?php echo $datakelas['nama_kelas'] ?></small>
            </a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Form Input Nilai -->
    <?php if(isset($_GET['siswaID'])) { 
      $siswa = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM siswa WHERE id_siswa='$_GET[siswaID]'"));
    ?>
    <div class="col-md-8">
      <div class="card border-danger">
        <div class="card-header bg-success text-white">
          <h3 class="card-title">Input Nilai - <?php echo $siswa['nama_siswa'] ?></h3>
        </div>
        <div class="card-body">
          <form method="POST">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Mata Pelajaran</label>
              <div class="col-sm-9">
                <select name="id_mapel" class="form-control select2" required>
                  <option value="">-- Pilih Mata Pelajaran --</option>
                  <?php
                  $mapel_query = mysqli_query($mysqli, "SELECT * FROM mapel 
                    JOIN kelompok_mapel ON mapel.id_kelompok = kelompok_mapel.id_kelompok
                    WHERE kelompok_mapel.huruf = 'B'
                    ORDER BY mapel.urut ASC");
                  
                  while($mapel = mysqli_fetch_array($mapel_query)) {
                    echo "<option value='".$mapel['id_mapel']."'>".$mapel['nama_mapel']."</option>";
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Nilai</label>
              <div class="col-sm-9">
                <input type="number" name="nilai" class="form-control" min="0" max="100" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Capaian Kompetensi</label>
              <div class="col-sm-9">
                <textarea name="capaian_kompetensi" class="form-control" rows="3" required></textarea>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-9 offset-sm-3">
                <input type="hidden" name="id_siswa" value="<?php echo $_GET['siswaID'] ?>">
                <button type="submit" name="simpan_nilai" class="btn btn-success">Simpan Nilai</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Tabel Nilai -->
      <div class="card border-danger mt-3">
        <div class="card-header bg-info text-white">
          <h3 class="card-title">Daftar Nilai - <?php echo $siswa['nama_siswa'] ?></h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Mata Pelajaran</th>
                  <th>Nilai</th>
                  <th>Capaian Kompetensi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $nilai_query = mysqli_query($mysqli, "SELECT np.*, m.nama_mapel 
                  FROM nilai_prakerin np
                  JOIN mapel m ON np.id_mapel = m.id_mapel
                  WHERE np.tahun='$sekolah[tahun]' 
                  AND np.semester='$sekolah[semester]' 
                  AND np.id_siswa='$_GET[siswaID]'
                  ORDER BY m.urut ASC");
                  
                if(mysqli_num_rows($nilai_query) > 0) {
                  while($nilai = mysqli_fetch_array($nilai_query)) {
                ?>
                <tr>
                  <td><?php echo $no++ ?></td>
                  <td><?php echo $nilai['nama_mapel'] ?></td>
                  <td><?php echo $nilai['nilai'] ?></td>
                  <td><?php echo $nilai['capaian_kompetensi'] ?></td>
                  <td>
                    <a href="?pages=<?php echo $_GET['pages'] ?>&filter=edit-nilai&dataID=<?php echo $_GET['dataID'] ?>&siswaID=<?php echo $_GET['siswaID'] ?>&nilaiID=<?php echo $nilai['id_nilai_prakerin'] ?>"
                      class="btn btn-warning btn-sm">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="?pages=<?php echo $_GET['pages'] ?>&filter=hapus-nilai&dataID=<?php echo $_GET['dataID'] ?>&siswaID=<?php echo $_GET['siswaID'] ?>&nilaiID=<?php echo $nilai['id_nilai_prakerin'] ?>"
                      class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus nilai ini?')">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
                <?php 
                  }
                } else {
                  echo "<tr><td colspan='5' class='text-center'>Belum ada nilai yang diinput</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php } else { ?>
    <div class="col-md-8">
      <div class="alert alert-info">
        <h5><i class="icon fas fa-info"></i> Informasi</h5>
        Pilih siswa dari daftar di sebelah kiri untuk mulai menginput nilai prakerin.
      </div>
    </div>
    <?php } ?>
  </div>
</section>

<?php
// Proses simpan nilai prakerin
if(isset($_POST['simpan_nilai'])) {
    $id_siswa = $_POST['id_siswa'];
    $id_mapel = $_POST['id_mapel'];
    $nilai = $_POST['nilai'];
    $capaian_kompetensi = $_POST['capaian_kompetensi'];
    
    // Cek apakah nilai untuk mapel ini sudah ada
    $cek = mysqli_query($mysqli, "SELECT * FROM nilai_prakerin 
        WHERE tahun='$sekolah[tahun]' 
        AND semester='$sekolah[semester]' 
        AND id_mapel='$id_mapel'
        AND id_siswa='$id_siswa'");
    
    if(mysqli_num_rows($cek) > 0) {
        echo "<script>
            alert('Nilai untuk mata pelajaran ini sudah ada, silahkan edit nilai yang sudah ada');
            window.location.href='?pages=".$_GET['pages']."&filter=penilaian&dataID=".$_GET['dataID']."&siswaID=".$id_siswa."';
        </script>";
    } else {
        $simpan = mysqli_query($mysqli, "INSERT INTO nilai_prakerin SET
            tahun='$sekolah[tahun]',
            semester='$sekolah[semester]',
            id_mapel='$id_mapel',
            id_siswa='$id_siswa',
            nilai='$nilai',
            capaian_kompetensi='$capaian_kompetensi'");
        
        if($simpan) {
            echo "<script>
                alert('Nilai prakerin berhasil disimpan');
                window.location.href='?pages=".$_GET['pages']."&filter=penilaian&dataID=".$_GET['dataID']."&siswaID=".$id_siswa."';
            </script>";
        } else {
            echo "<script>
                alert('Gagal menyimpan nilai prakerin');
                window.location.href='?pages=".$_GET['pages']."&filter=penilaian&dataID=".$_GET['dataID']."&siswaID=".$id_siswa."';
            </script>";
        }
    }
}
?>

<?php }elseif($_GET['filter']=="edit-nilai"){ 
  $nilai = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_prakerin WHERE id_nilai_prakerin='$_GET[nilaiID]'"));
  $siswa = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM siswa WHERE id_siswa='$_GET[siswaID]'"));
?>
<section class="content-header">
  <h1>
    Edit Nilai Prakerin
    <div class="float-right">
      <a href="?pages=<?php echo $_GET['pages'] ?>&filter=penilaian&dataID=<?php echo $_GET['dataID'] ?>&siswaID=<?php echo $_GET['siswaID'] ?>"
        class="btn btn-primary">Kembali</a>
    </div>
  </h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="card border-danger">
        <div class="card-header bg-warning text-white">
          <h3 class="card-title">Edit Nilai - <?php echo $siswa['nama_siswa'] ?></h3>
        </div>
        <div class="card-body">
          <form method="POST">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Mata Pelajaran</label>
              <div class="col-sm-9">
                <select name="id_mapel" class="form-control select2" required>
                  <?php
                  $mapel_query = mysqli_query($mysqli, "SELECT * FROM mapel 
                    JOIN kelompok_mapel ON mapel.id_kelompok = kelompok_mapel.id_kelompok
                    WHERE kelompok_mapel.huruf = 'B'
                    ORDER BY mapel.urut ASC");
                  
                  while($mapel = mysqli_fetch_array($mapel_query)) {
                    $selected = ($mapel['id_mapel'] == $nilai['id_mapel']) ? 'selected' : '';
                    echo "<option value='".$mapel['id_mapel']."' ".$selected.">".$mapel['nama_mapel']."</option>";
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Nilai</label>
              <div class="col-sm-9">
                <input type="number" name="nilai" class="form-control" min="0" max="100"
                  value="<?php echo $nilai['nilai'] ?>" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Capaian Kompetensi</label>
              <div class="col-sm-9">
                <textarea name="capaian_kompetensi" class="form-control" rows="3"
                  required><?php echo $nilai['capaian_kompetensi'] ?></textarea>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-9 offset-sm-3">
                <input type="hidden" name="id_nilai_prakerin" value="<?php echo $nilai['id_nilai_prakerin'] ?>">
                <button type="submit" name="update_nilai" class="btn btn-warning">Update Nilai</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
if(isset($_POST['update_nilai'])) {
    $id_nilai_prakerin = $_POST['id_nilai_prakerin'];
    $id_mapel = $_POST['id_mapel'];
    $nilai = $_POST['nilai'];
    $capaian_kompetensi = $_POST['capaian_kompetensi'];
    
    $update = mysqli_query($mysqli, "UPDATE nilai_prakerin SET
        id_mapel='$id_mapel',
        nilai='$nilai',
        capaian_kompetensi='$capaian_kompetensi'
        WHERE id_nilai_prakerin='$id_nilai_prakerin'");
    
    if($update) {
        echo "<script>
            alert('Nilai prakerin berhasil diupdate');
            window.location.href='?pages=".$_GET['pages']."&filter=penilaian&dataID=".$_GET['dataID']."&siswaID=".$_GET['siswaID']."';
        </script>";
    } else {
        echo "<script>
            alert('Gagal mengupdate nilai prakerin');
            window.location.href='?pages=".$_GET['pages']."&filter=edit-nilai&dataID=".$_GET['dataID']."&siswaID=".$_GET['siswaID']."&nilaiID=".$_GET['nilaiID']."';
        </script>";
    }
}
?>

<?php }elseif($_GET['filter']=="absensi"){ 
  $prakerin = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM prakerin WHERE id_prakerin='$_GET[dataID]'"));
?>
<section class="content-header">
  <h1>
    Absensi Prakerin
    <div class="float-right">
      <a href="?pages=<?php echo $_GET['pages'] ?>" class="btn btn-primary">Kembali</a>
    </div>
  </h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card border-danger">
        <div class="card-header bg-secondary text-white">
          <h3 class="card-title">Absensi Prakerin - <?php echo $prakerin['mitra'] ?></h3>
        </div>
        <div class="card-body">
          <form method="POST">
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Sakit (Hari)</th>
                    <th>Izin (Hari)</th>
                    <th>Alpha (Hari)</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  $siswaprakerin = mysqli_query($mysqli, "SELECT * FROM siswa_prakerin 
                    JOIN siswa ON siswa_prakerin.id_siswa = siswa.id_siswa
                    WHERE tahun='$sekolah[tahun]' 
                    AND semester='$sekolah[semester]' 
                    AND id_prakerin='$_GET[dataID]' 
                    ORDER BY nama_siswa ASC");
                  
                  while ($rsiswaprakerin = mysqli_fetch_array($siswaprakerin)) {
                    $datasiswakelas = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM siswa_kelas 
                      WHERE tahun='$sekolah[tahun]' 
                      AND semester='$sekolah[semester]' 
                      AND id_siswa='$rsiswaprakerin[id_siswa]'"));
                    
                    $datakelas = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM kelas 
                      WHERE id_kelas='$datasiswakelas[id_kelas]'"));
                    
                    // Ambil data presensi yang sudah ada
                    $presensi = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM presensi_prakerin 
                      WHERE tahun='$sekolah[tahun]' 
                      AND semester='$sekolah[semester]' 
                      AND id_prakerin='$_GET[dataID]'
                      AND id_siswa='$rsiswaprakerin[id_siswa]'"));
                    
                    $sakit = isset($presensi['sakit']) ? $presensi['sakit'] : 0;
                    $izin = isset($presensi['izin']) ? $presensi['izin'] : 0;
                    $alpha = isset($presensi['alpha']) ? $presensi['alpha'] : 0;
                  ?>
                  <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $rsiswaprakerin['nama_siswa'] ?></td>
                    <td><?php echo $datakelas['nama_kelas'] ?></td>
                    <td>
                      <input type="number" name="sakit[<?php echo $rsiswaprakerin['id_siswa'] ?>]" 
                        class="form-control" min="0" value="<?php echo $sakit ?>">
                    </td>
                    <td>
                      <input type="number" name="izin[<?php echo $rsiswaprakerin['id_siswa'] ?>]" 
                        class="form-control" min="0" value="<?php echo $izin ?>">
                    </td>
                    <td>
                      <input type="number" name="alpha[<?php echo $rsiswaprakerin['id_siswa'] ?>]" 
                        class="form-control" min="0" value="<?php echo $alpha ?>">
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <input type="hidden" name="id_prakerin" value="<?php echo $_GET['dataID'] ?>">
            <button type="submit" name="simpan_absensi" class="btn btn-success mt-3">
              <i class="fas fa-save"></i> Simpan Absensi
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
// Proses simpan absensi prakerin
if(isset($_POST['simpan_absensi'])) {
    $id_prakerin = $_POST['id_prakerin'];
    $sakit_arr = $_POST['sakit'];
    $izin_arr = $_POST['izin'];
    $alpha_arr = $_POST['alpha'];
    $berhasil = 0;
    
    foreach($sakit_arr as $id_siswa => $sakit_val) {
        $izin_val = isset($izin_arr[$id_siswa]) ? intval($izin_arr[$id_siswa]) : 0;
        $alpha_val = isset($alpha_arr[$id_siswa]) ? intval($alpha_arr[$id_siswa]) : 0;
        $sakit_val = intval($sakit_val);
        
        // Cek apakah sudah ada data
        $cek = mysqli_query($mysqli, "SELECT * FROM presensi_prakerin 
            WHERE tahun='$sekolah[tahun]' 
            AND semester='$sekolah[semester]' 
            AND id_prakerin='$id_prakerin'
            AND id_siswa='$id_siswa'");
        
        if(mysqli_num_rows($cek) > 0) {
            // Update
            $q = mysqli_query($mysqli, "UPDATE presensi_prakerin SET
                sakit='$sakit_val',
                izin='$izin_val',
                alpha='$alpha_val'
                WHERE tahun='$sekolah[tahun]' 
                AND semester='$sekolah[semester]' 
                AND id_prakerin='$id_prakerin'
                AND id_siswa='$id_siswa'");
        } else {
            // Insert
            $q = mysqli_query($mysqli, "INSERT INTO presensi_prakerin SET
                tahun='$sekolah[tahun]',
                semester='$sekolah[semester]',
                id_prakerin='$id_prakerin',
                id_siswa='$id_siswa',
                sakit='$sakit_val',
                izin='$izin_val',
                alpha='$alpha_val'");
        }
        
        if($q) $berhasil++;
    }
    
    if($berhasil > 0) {
        echo "<script>
            alert('Absensi prakerin berhasil disimpan untuk ".$berhasil." siswa');
            window.location.href = '?pages=".$_GET['pages']."&filter=absensi&dataID=".$id_prakerin."';
            </script>";
    }
}
?>

<?php }elseif($_GET['filter']=="hapus-nilai"){ 
    $hapus = mysqli_query($mysqli,"DELETE FROM nilai_prakerin WHERE id_nilai_prakerin='$_GET[nilaiID]'");
    $siswaID = isset($_GET['siswaID']) ? $_GET['siswaID'] : '';
    
    if ($hapus) {
        echo "<script>
            alert('Berhasil menghapus nilai prakerin');
            window.location.href = '?pages=".$_GET['pages']."&filter=penilaian&dataID=".$_GET['dataID']."&siswaID=".$siswaID."';
            </script>";
    }
} ?>

<?php
// Handle multiple delete
if (isset($_POST['delete_selected']) && !empty($_POST['ids'])) {
    $ids = $_POST['ids'];
    $success = true;
    
    foreach ($ids as $id) {
        $id = mysqli_real_escape_string($mysqli, $id);
        $delete_prakerin = mysqli_query($mysqli, "DELETE FROM prakerin WHERE id_prakerin='$id'");
        $delete_siswa_prakerin = mysqli_query($mysqli, "DELETE FROM siswa_prakerin WHERE id_prakerin='$id'");
        
        if (!$delete_prakerin || !$delete_siswa_prakerin) {
            $success = false;
            break;
        }
    }

    if ($success) {
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Data prakerin berhasil dihapus'
        ];
    } else {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => 'Gagal menghapus beberapa data prakerin'
        ];
    }
    
    echo "<script>window.location.href = '?pages=" . $_GET['pages'] . "';</script>";
    exit;
}
?>