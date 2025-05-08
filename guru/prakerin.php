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
          <h3 class="card-title">Data Prakerin yang Saya Bimbing</h3>
        </div><!-- /.card-header -->
        <div class="card-body table-responsive">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Mitra DU/DI</th>
                <th>Lokasi</th>
                <th>Lamanya (Bulan)</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php  
              $nomor=1;
              $prakerin = mysqli_query($mysqli,"SELECT * FROM prakerin WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_user='$_SESSION[id_user]' ORDER BY id_prakerin ASC");
              while($rprakerin = mysqli_fetch_array($prakerin)){
                $tanggalawal = date_create($rprakerin['tanggal_mulai']);
                $tanggalakhir = date_create($rprakerin['tanggal_akhir']);
                $interval = date_diff($tanggalawal, $tanggalakhir); 
              ?>
              <tr>
                <td><?php echo $nomor++ ?></td>
                <td><?php echo $rprakerin['mitra'] ?></td>
                <td><?php echo $rprakerin['lokasi'] ?></td>
                <td><?php echo $interval->m . ' Bulan' ?></td>
                <td>
                  <a href="?pages=<?php echo $_GET['pages'] ?>&filter=detail&dataID=<?php echo $rprakerin['id_prakerin'] ?>"
                    class="btn btn-warning"><i class="fa fa-pencil"></i> Detail</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div><!-- /.row -->
</section><!-- /.content -->

<?php }elseif($_GET['filter']=="detail"){ 
  $prakerin = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM prakerin WHERE id_prakerin='$_GET[dataID]'"));
?>
<section class="content-header">
  <h1>
    Detail Prakerin
    <div class="float-right">
      <a href="?pages=<?php echo $_GET['pages'] ?>" class="btn btn-primary">Kembali</a>
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
          <h3 class="card-title">Data Prakerin</h3>
        </div>
        <div class="card-body">
          <table class="table table-striped table-bordered">
            <tr>
              <td>Mitra DU/DI</td>
              <td><?php echo $prakerin['mitra'] ?></td>
            </tr>
            <tr>
              <td>Lokasi</td>
              <td><?php echo $prakerin['lokasi'] ?></td>
            </tr>
            <tr>
              <td>Tanggal Mulai</td>
              <td><?php echo date('d-m-Y', strtotime($prakerin['tanggal_mulai'])) ?></td>
            </tr>
            <tr>
              <td>Tanggal Selesai</td>
              <td><?php echo date('d-m-Y', strtotime($prakerin['tanggal_akhir'])) ?></td>
            </tr>
            <?php
            $tanggalawal = date_create($prakerin['tanggal_mulai']);
            $tanggalakhir = date_create($prakerin['tanggal_akhir']);
            $interval = date_diff($tanggalawal, $tanggalakhir); 
            ?>
            <tr>
              <td>Lama Prakerin</td>
              <td><?php echo $interval->m ?> Bulan</td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card border-danger">
        <div class="card-header bg-info text-white">
          <h3 class="card-title">Daftar Peserta Didik Prakerin</h3>
          <div class="float-right">
            <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Tambah Peserta
              Didik</a>
          </div>
        </div>
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
                  <a href="?pages=<?php echo $_GET['pages'] ?>&filter=hapus-siswa&dataID=<?php echo $_GET['dataID'] ?>&orderID=<?php echo $rsiswaprakerin['id_siswa_prakerin'] ?>"
                    onclick="return confirm('Yakin ingin menghapus siswa ini dari prakerin?')"
                    class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal Tambah Siswa -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-lg">
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
                      JOIN kelas ON siswa_kelas.id_kelas = kelas.id_kelas
                      WHERE siswa_kelas.tahun='$sekolah[tahun]' 
                      AND siswa_kelas.semester='$sekolah[semester]' 
                      AND kelas.id_tingkat > 1 
                      ORDER BY siswa.nama_siswa ASC");
                  
                  while ($rsiswakelas = mysqli_fetch_array($siswakelas)) {
                      // Cek apakah siswa sudah terdaftar di prakerin manapun
                      $cekSiswaPrakerin = mysqli_query($mysqli, "SELECT * FROM siswa_prakerin 
                          WHERE tahun='$sekolah[tahun]' 
                          AND semester='$sekolah[semester]' 
                          AND id_siswa='$rsiswakelas[id_siswa]'");
                      
                      // Tampilkan hanya siswa yang belum terdaftar prakerin
                      if (mysqli_num_rows($cekSiswaPrakerin) == 0) {
                  ?>
                  <tr>
                    <td><?php echo $nomor++ ?></td>
                    <td><input type="checkbox" name="siswa[]" value="<?php echo $rsiswakelas['id_siswa'] ?>"></td>
                    <td><?php echo $rsiswakelas['nama_siswa'] ?></td>
                    <td><?php echo $rsiswakelas['nisn'] ?></td>
                    <td><?php echo $rsiswakelas['nama_kelas'] ?></td>
                  </tr>
                  <?php 
                      }
                  } 
                  ?>
                </tbody>
              </table>
              <div class="modal-footer">
                <button type="submit" name="tambahpeserta" class="btn btn-success">Tambah Peserta</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
if (isset($_POST['tambahpeserta'])) {
    if(isset($_POST['siswa'])) {
        $siswa = $_POST['siswa'];
        $jumlahsiswa = count($siswa);
        $berhasil = 0;
        
        for ($i=0; $i < $jumlahsiswa; $i++) { 
            $simpan = mysqli_query($mysqli,"INSERT INTO siswa_prakerin SET 
                tahun='$sekolah[tahun]', 
                semester='$sekolah[semester]', 
                id_prakerin='$_GET[dataID]', 
                id_siswa='$siswa[$i]'");
            
            if ($simpan) {
                $berhasil++;
            }
        }
        
        if($berhasil > 0) {
            echo "<script>
                alert('Berhasil menambahkan ".$berhasil." peserta prakerin');
                window.location.href = '?pages=".$_GET['pages']."&filter=detail&dataID=".$_GET['dataID']."';
                </script>";
        }
    } else {
        echo "<script>
            alert('Pilih minimal satu siswa!');
            window.location.href = '?pages=".$_GET['pages']."&filter=detail&dataID=".$_GET['dataID']."';
            </script>";
    }
}
?>

<?php }elseif($_GET['filter']=="penilaian"){ 
  $prakerin = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM prakerin WHERE id_prakerin='$_GET[dataID]'"));
?>
<section class="content-header">
  <h1>
    Penilaian Prakerin
    <div class="float-right">
      <a href="?pages=<?php echo $_GET['pages'] ?>&filter=detail&dataID=<?php echo $_GET['dataID'] ?>"
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

<?php }elseif($_GET['filter']=="hapus-siswa"){ 
    $hapus = mysqli_query($mysqli,"DELETE FROM siswa_prakerin WHERE id_siswa_prakerin='$_GET[orderID]'");
    
    if ($hapus) {
        echo "<script>
            alert('Berhasil menghapus peserta prakerin');
            window.location.href = '?pages=".$_GET['pages']."&filter=detail&dataID=".$_GET['dataID']."';
            </script>";
    }
} elseif($_GET['filter']=="hapus-nilai"){ 
    $hapus = mysqli_query($mysqli,"DELETE FROM nilai_prakerin WHERE id_nilai_prakerin='$_GET[nilaiID]'");
    $siswaID = isset($_GET['siswaID']) ? $_GET['siswaID'] : '';
    
    if ($hapus) {
        echo "<script>
            alert('Berhasil menghapus nilai prakerin');
            window.location.href = '?pages=".$_GET['pages']."&filter=penilaian&dataID=".$_GET['dataID']."&siswaID=".$siswaID."';
            </script>";
    }
} ?>