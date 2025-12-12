<?php  
$proyek = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM proyek_kelas WHERE id_proyek_kelas='$_GET[orderID]'"));
$kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE id_kelas='$proyek[id_kelas]'"));

// Create table if not exists
mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS proyek_tujuan (
    id_proyek_tujuan INT AUTO_INCREMENT PRIMARY KEY,
    id_proyek_kelas INT,
    id_dimensi INT,
    deskripsi TEXT,
    FOREIGN KEY (id_proyek_kelas) REFERENCES proyek_kelas(id_proyek_kelas) ON DELETE CASCADE
)");

// Handle Add Tujuan
if(isset($_POST['simpan_tujuan'])){
    $id_dimensi = $_POST['id_dimensi'];
    $deskripsi = $_POST['deskripsi'];
    $insert = mysqli_query($mysqli, "INSERT INTO proyek_tujuan (id_proyek_kelas, id_dimensi, deskripsi) VALUES ('$_GET[orderID]', '$id_dimensi', '$deskripsi')");
    if($insert){
        echo "<script>alert('Berhasil menambahkan tujuan'); window.location.href='?pages=$_GET[pages]&orderID=$_GET[orderID]';</script>";
    } else {
        echo "<script>alert('Gagal: ".mysqli_error($mysqli)."');</script>";
    }
}

// Handle Delete Tujuan
if(isset($_GET['hapus_tujuan'])){
    $delete = mysqli_query($mysqli, "DELETE FROM proyek_tujuan WHERE id_proyek_tujuan='$_GET[hapus_tujuan]'");
    if($delete){
        echo "<script>alert('Berhasil menghapus tujuan'); window.location.href='?pages=$_GET[pages]&orderID=$_GET[orderID]';</script>";
    }
}

// Handle Update Project Info and Goals
if(isset($_POST['simpan_proyek'])){
    $judul = $_POST['judul'];
    $id_user = $_POST['id_user'];
    
    // Update Project Info
    $update_proyek = mysqli_query($mysqli,"UPDATE proyek_kelas SET judul_proyek='$judul', id_user='$id_user' WHERE id_proyek_kelas='$_GET[orderID]'");
    
    // Update Goals (Tujuan)
    if(isset($_POST['tujuan'])){
        foreach($_POST['tujuan'] as $id_tujuan => $data){
            $id_dimensi = $data['id_dimensi'];
            $deskripsi = $data['deskripsi'];
            mysqli_query($mysqli, "UPDATE proyek_tujuan SET id_dimensi='$id_dimensi', deskripsi='$deskripsi' WHERE id_proyek_tujuan='$id_tujuan'");
        }
    }

    if($update_proyek){
        echo "<script>alert('Berhasil update data proyek dan tujuan'); window.location.href='?pages=$_GET[pages]&orderID=$_GET[orderID]';</script>";
    }
}
?>

<section class="content-header">
  <h1>Project <?php echo $proyek['judul_proyek']?></h1>
</section>

<section class="content-header">
  <a href="?pages=<?php echo 'kokurikuler'?>" class="btn btn-primary btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <br><br>

<?php if(empty($_GET['filter'])){ ?>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
            
            <!-- Top Button -->
            <div class="mb-3">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalTujuan">
                    Buat Tujuan Pembelajaran
                </button>
            </div>

            <form method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pembina Kegiatan</label>
                            <select name="id_user" required class="form-control">
                                <option value="">Pilih Pembina</option>
                                <?php
                                $guru = mysqli_query($mysqli, "SELECT * FROM users WHERE jabatan='3' ORDER BY id_user ASC");
                                while ($rguru = mysqli_fetch_array($guru)) {
                                    $sele = ($proyek['id_user'] == $rguru['id_user']) ? "selected" : "";
                                ?>
                                <option value="<?php echo $rguru['id_user'] ?>" <?php echo $sele ?>>
                                    <?php echo $rguru['nama'] ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Nama Kegiatan</label>
                            <input type="text" name="judul" class="form-control" required autocomplete="off" value="<?php echo $proyek['judul_proyek']?>">
                        </div>
                    </div>
                </div>

                <!-- Table Tujuan -->
                <table class="table table-striped table-bordered">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th style="width: 50px">No</th>
                            <th style="width: 300px">Dimensi</th>
                            <th>Deskripsi</th>
                            <th style="width: 200px">Contoh Deskripsi Rapor</th>
                            <th style="width: 100px">Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        // Fetch all dimensions for the dropdown
                        $all_dimensi = [];
                        $q_dimensi = mysqli_query($mysqli, "SELECT * FROM dimensi_kokurikuler ORDER BY id_dimensi ASC");
                        while($d = mysqli_fetch_array($q_dimensi)){
                            $all_dimensi[] = $d;
                        }

                        $tujuan = mysqli_query($mysqli, "SELECT * FROM proyek_tujuan WHERE id_proyek_kelas='$_GET[orderID]'");
                        if(mysqli_num_rows($tujuan) > 0){
                            while($r = mysqli_fetch_array($tujuan)){
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>
                                <select name="tujuan[<?php echo $r['id_proyek_tujuan']; ?>][id_dimensi]" class="form-control">
                                    <?php foreach($all_dimensi as $dim): ?>
                                        <option value="<?php echo $dim['id_dimensi']; ?>" <?php echo ($r['id_dimensi'] == $dim['id_dimensi']) ? 'selected' : ''; ?>>
                                            <?php echo $dim['dimensi']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <textarea name="tujuan[<?php echo $r['id_proyek_tujuan']; ?>][deskripsi]" class="form-control" rows="2"><?php echo $r['deskripsi']; ?></textarea>
                            </td>
                            <td class="text-center">
                                <?php
                                $nama_dimensi = "";
                                foreach($all_dimensi as $ad){
                                    if($ad['id_dimensi'] == $r['id_dimensi']){
                                        $nama_dimensi = $ad['dimensi'];
                                        break;
                                    }
                                }
                                ?>
                                <button style="cursor: pointer;" data-toggle="tooltip" data-container="body"
                                    data-placement="right" title="Sangat baik dalam <?php echo htmlspecialchars($nama_dimensi); ?> yang terlihat dari ..." type="button" class="btn btn-info btn-sm">Contoh</button>
                            </td>
                            <td class="text-center">
                                <a href="?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&hapus_tujuan=<?php echo $r['id_proyek_tujuan']?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>No data available in table</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <div class="mt-3">
                    <button type="submit" name="simpan_proyek" class="btn btn-info">Simpan Data</button>
                </div>
            </form>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal Buat Tujuan -->
<div class="modal fade" id="modalTujuan" tabindex="-1" role="dialog" aria-labelledby="modalTujuanLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTujuanLabel">Buat Tujuan Pembelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST">
          <div class="modal-body">
            <div class="form-group">
                <label>Dimensi</label>
                <select name="id_dimensi" id="id_dimensi_modal" class="form-control" required>
                    <option value="">Pilih Dimensi</option>
                    <?php
                    $dimensi = mysqli_query($mysqli, "SELECT * FROM dimensi_kokurikuler ORDER BY id_dimensi ASC");
                    while($rd = mysqli_fetch_array($dimensi)){
                        echo "<option value='$rd[id_dimensi]' data-nama='$rd[dimensi]'>$rd[dimensi]</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label>Contoh Deskripsi Rapor</label>
                <p id="contoh_deskripsi_modal" class="text-muted font-italic"> Sangat baik dalam <span id="nama_dimensi_modal">[Dimensi]</span> terlihat dari ... </p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="simpan_tujuan" class="btn btn-primary">Simpan</button>
          </div>
      </form>
    </div>
  </div>
</div>


<?php }elseif($_GET['filter']=="sub-elemen"){ ?>
<div class="container-fluid mt-4">
  <div class="row">
    <div class="col-12">
      <div class="card border-danger">
        <div class="card-header bg-white border-danger d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Sub Elemen Sasaran Project</h5>
        </div>

        <form method="POST">
          <div class="card-body">
            <div class="mb-3">
              <button type="submit" name="simpandata" class="btn btn-primary">
                Simpan Data
              </button>
            </div>

            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="text-center align-middle" style="width: 60px">No</th>
                    <th class="text-center align-middle" style="width: 80px">Select</th>
                    <th class="align-middle">Dimensi</th>
                    <th class="align-middle">Sub Elemen</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                                    $nomor=1;
                                    $subelemen = mysqli_query($mysqli,"SELECT * FROM sub_elemen ORDER BY id_dimensi, id_sub_elemen ASC");
                                    while($rsubelemen = mysqli_fetch_array($subelemen)){
                                        $dimensi = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM dimensi WHERE id_dimensi='$rsubelemen[id_dimensi]'"));
                                        
                                        $jumlahsub = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]' AND id_sub_elemen='$rsubelemen[id_sub_elemen]'"));
                                        $selesub = ($jumlahsub==1) ? "checked" : "";
                                    ?>
                  <tr>
                    <td class="text-center align-middle"><?php echo $nomor++ ?></td>
                    <td class="text-center align-middle">
                      <div class="d-flex justify-content-center">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input"
                            id="sub_elemen_<?php echo $rsubelemen['id_sub_elemen']?>" name="sub_elemen[]"
                            value="<?php echo $rsubelemen['id_sub_elemen']?>" <?php echo $selesub?>>
                          <label class="custom-control-label"
                            for="sub_elemen_<?php echo $rsubelemen['id_sub_elemen']?>"></label>
                        </div>
                      </div>
                    </td>
                    <td class="align-middle"><?php echo $dimensi['dimensi']?></td>
                    <td class="align-middle"><?php echo $rsubelemen['sub_elemen']?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
        if(isset($_POST['simpandata'])){
            $subelemen = $_POST['sub_elemen'];
            $julahsubelemen = count($subelemen);
            
            mysqli_query($mysqli,"DELETE FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]'");
            
            for ($i=0; $i <$julahsubelemen ; $i++) { 
            	$ambildata = mysqli_query($mysqli,"SELECT * FROM sub_elemen WHERE id_sub_elemen='$subelemen[$i]'");
            	while($rambildata = mysqli_fetch_array($ambildata)){
            	    $id_dimensi = $rambildata['id_dimensi'];
            	    $id_elemen = $rambildata['id_elemen'];
            	    $id_sub_elemen = $rambildata['id_sub_elemen'];
            	    $simpan = mysqli_query($mysqli,"INSERT INTO proyek_subelemen SET id_proyek_kelas='$_GET[orderID]', id_dimensi='$id_dimensi', id_elemen='$id_elemen', id_sub_elemen='$id_sub_elemen'");
            	}
            }
            if($simpan){
                ?><script>
alert('Berhasil');
window.location.href =
  "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&filter=<?php echo $_GET['filter']?>";
</script><?php
            }
        }
        ?>



<?php }elseif($_GET['filter']=="rekap-nilai"){ 
        $jumlahsubelemen = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]'"));
        ?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- USERS LIST -->
      <div class="card border-danger">
        <div class="card-header bg-danger ">
          <h3 class="card-title text-white">Rekap Nilai Project</h3>
          <div class="float-right">

          </div>
        </div><!-- /.card-header -->
        <form method="POST">
          <div class="card-body table-responsive">
            <table class="table table-striped table-bordered table-sm" style="font-size:12px;">
              <tr style="background-color:#fee8d0;">
                <th rowspan="3" class="text-center align-middle">No</th>
                <th rowspan="3" class="text-center align-middle">NISN</th>
                <th rowspan="3" class="text-center align-middle">Nama Peserta Didik</th>
                <th colspan="<?php echo $jumlahsubelemen ?>" class="text-center align-middle">Dimensi,
                  Sub Elemen</th>
                <!-- <th rowspan="3" class="text-center align-middle">Nilai Kelas</th> -->
              </tr>
              <tr style="background-color:#fee8d0;">
                <?php
                                $subelemen = mysqli_query($mysqli,"SELECT DISTINCT(id_dimensi) FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]' ORDER BY id_dimensi ASC");
                                while($rsubelemen = mysqli_fetch_array($subelemen)){
                                    $jumlahsub = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]' AND id_dimensi='$rsubelemen[id_dimensi]'"));
                                    $dimensi = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM dimensi WHERE id_dimensi='$rsubelemen[id_dimensi]'"));
                                ?>
                <th colspan="<?php echo $jumlahsub ?>" class="text-center align-middle" style="width:7%;">
                  <?php echo substr($dimensi['dimensi'], 0, 30) . '...';?></th>
                <?php } ?>
              </tr>
              <tr style="background-color:#fee8d0;">
                <?php
                                $subelemen = mysqli_query($mysqli,"SELECT DISTINCT(id_dimensi) FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]' ORDER BY id_dimensi ASC");
                                while($rsubelemen = mysqli_fetch_array($subelemen)){
                                    $datasubelemen = mysqli_query($mysqli,"SELECT * FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]' AND id_dimensi='$rsubelemen[id_dimensi]' ORDER BY id_sub_elemen ASC");
                                    while($rdatasubelemen = mysqli_fetch_array($datasubelemen)){
                                        $datasub = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sub_elemen WHERE id_sub_elemen='$rdatasubelemen[id_sub_elemen]'"));
                                ?>
                <th class="text-center align-middle" style="width:7%;">
                  <?php echo substr($datasub['sub_elemen'], 0, 30) . '...';?></th>
                <?php } ?>
                <?php } ?>
              </tr>
              <?php
                            $nomor=1;
                            $siswakelas = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
                            JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                            WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$proyek[id_kelas]' ORDER BY nama_siswa ASC");
                            while($rsiswakelas = mysqli_fetch_array($siswakelas)){
                            ?>
              <tr>
                <td class="text-center"><?php echo $nomor++?></td>
                <td class="text-center"><?php echo $rsiswakelas['nisn']?></td>
                <td><?php echo $rsiswakelas['nama_siswa']?></td>
                <?php
                                $subelemen = mysqli_query($mysqli,"SELECT DISTINCT(id_dimensi) FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]' ORDER BY id_dimensi ASC");
                                while($rsubelemen = mysqli_fetch_array($subelemen)){
                                    $datasubelemen = mysqli_query($mysqli,"SELECT * FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]' AND id_dimensi='$rsubelemen[id_dimensi]' ORDER BY id_sub_elemen ASC");
                                    while($rdatasubelemen = mysqli_fetch_array($datasubelemen)){
                                        $datasub = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sub_elemen WHERE id_sub_elemen='$rdatasubelemen[id_sub_elemen]'"));
                                        $jumlahnialisub = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(nilai) AS jumlah_nilai FROM nilai_proyek WHERE proyek='$_GET[orderID]' AND id_sub_elemen='$rdatasubelemen[id_sub_elemen]' AND id_siswa='$rsiswakelas[id_siswa]'"));
                                        $rata2nilaisub = round(($jumlahnialisub['jumlah_nilai']));
                                        
                                        if($rata2nilaisub==0){
                                            $ket = "BB";
                                        }elseif($rata2nilaisub==1){
                                            $ket = "BB";
                                        }elseif($rata2nilaisub==2){
                                            $ket = "MB";
                                        }elseif($rata2nilaisub==3){
                                            $ket = "BSH";
                                        }elseif($rata2nilaisub==4){
                                            $ket = "SB";
                                        }
                                ?>
                <td class="text-center align-middle" style="width:7%;"><?php echo $ket ?></td>
                <?php } ?>
                <?php } ?>
              </tr>
              <?php } ?>
            </table>
          </div>
      </div>
    </div><!-- /.row -->
</section><!-- /.content -->



<?php } ?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips if jQuery is available (Bootstrap 4 requires jQuery)
    if (typeof $ !== 'undefined') {
        $('[data-toggle="tooltip"]').tooltip();
    }

    // Update Modal Example Text (Vanilla JS)
    var dimensiSelect = document.getElementById('id_dimensi_modal');
    var namaDimensiSpan = document.getElementById('nama_dimensi_modal');

    if (dimensiSelect) {
        dimensiSelect.addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var namaDimensi = selectedOption.getAttribute('data-nama');
            
            if (namaDimensi) {
                namaDimensiSpan.textContent = '"' + namaDimensi + '"';
            } else {
                namaDimensiSpan.textContent = '[Dimensi]';
            }
        });
    }
  });
</script>