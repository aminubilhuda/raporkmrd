<?php
// Create table if not exists
mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `deskripsi_kokurikuler` (
  `id_deskripsi` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `kriteria` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `contoh` varchar(255) NOT NULL,
  `nilai` int(11) NOT NULL
)");

// Check if data exists before inserting
$cek_data = mysqli_query($mysqli, "SELECT id_deskripsi FROM deskripsi_kokurikuler LIMIT 1");
if (mysqli_num_rows($cek_data) == 0) {
    // input data 
    mysqli_query($mysqli,"INSERT INTO `deskripsi_kokurikuler` (`id_deskripsi`, `kriteria`, `keterangan`, `contoh`, `nilai`) VALUES
    (1, 'Kurang', 'Kurang', '', 1),
    (2, 'Cukup', 'Cukup', '', 2),
    (3, 'Baik', 'Baik', '', 3),
    (4, 'Sangat Baik', 'Sangat baik', '', 4);");
}

// Create table if not exists
mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `dimensi_kokurikuler` (
  `id_dimensi` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `dimensi` varchar(255) NOT NULL
)");

// Check if data exists before inserting
$cek_data = mysqli_query($mysqli, "SELECT id_dimensi FROM dimensi_kokurikuler LIMIT 1");
if (mysqli_num_rows($cek_data) == 0) {
    // input data 
    mysqli_query($mysqli,"INSERT INTO `dimensi_kokurikuler` (`id_dimensi`, `dimensi`) VALUES
(1, 'Keimanan dan Ketakwaan terhadap Tuhan Yang Maha Esa'),
(2, 'Kewarganegara'),
(3, 'Penalaran Kritis'),
(4, 'Kreativitas'),
(5, 'Kolaborasi'),
(6, 'Kemandirian'),
(7, 'Kesehatan'),
(8, 'Komunikasi');");
}

// Salin kegiatan kokurikuler
if (isset($_POST['salin_kegiatan'])) {
    $id_proyek_asli = $_POST['id_proyek_kelas_salin'];
    $id_kelas_baru = $_POST['id_kelas_salin'];
    $id_user_baru = $_POST['id_user_salin'];

    $proyek_asli = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM proyek_kelas WHERE id_proyek_kelas='$id_proyek_asli'"));
    $kode_baru = randomString(6);

    $insert = mysqli_query($mysqli, "INSERT INTO proyek_kelas (kode, tahun, semester, id_kelas, id_tema, id_user, judul_proyek, deskripsi_singkat)
        VALUES ('$kode_baru', '$sekolah[tahun]', '$sekolah[semester]', '$id_kelas_baru', '$proyek_asli[id_tema]', '$id_user_baru', '$proyek_asli[judul_proyek]', '$proyek_asli[deskripsi_singkat]')");

    if ($insert) {
        $id_proyek_baru = mysqli_insert_id($mysqli);

        // Copy proyek_tujuan
        $tujuan = mysqli_query($mysqli, "SELECT * FROM proyek_tujuan WHERE id_proyek_kelas='$id_proyek_asli'");
        while ($rtujuan = mysqli_fetch_array($tujuan)) {
            mysqli_query($mysqli, "INSERT INTO proyek_tujuan (id_proyek_kelas, id_dimensi, deskripsi)
                VALUES ('$id_proyek_baru', '$rtujuan[id_dimensi]', '$rtujuan[deskripsi]')");
        }

        echo "<script>alert('Berhasil menyalin kegiatan'); window.location.href='?pages=kokurikuler';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menyalin kegiatan: " . mysqli_real_escape_string($mysqli, mysqli_error($mysqli)) . "');</script>";
        exit;
    }
}
?>

<div class="container-fluid mt-4 bg-white p-4 shadow-sm">
  <h2>KOKURIKULER SMKS ABDI NEGARA TUBAN</h2>
  <div class="mb-3">
    <button class="btn btn-primary" data-toggle="modal" data-target="#tambahKokurikulerModal">Tambah Kegiatan</button>
  </div>
  <div class="table-responsive">
    <table id="datatable" class="table table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Kelas</th>
          <th>Judul Kegiatan</th>
          <th>Pembina</th>
          <th>Siswa</th>
          <th>Edit / Nilai / Salin / Hapus</th>
        </tr>
      </thead>
      <tbody>
        <?php  
                    $sql = mysqli_query($mysqli, "SELECT * FROM proyek_kelas
                    JOIN kelas ON proyek_kelas.id_kelas = kelas.id_kelas
                    JOIN users ON proyek_kelas.id_user = users.id_user
                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'");
                    $no = 1;
                    while($r = mysqli_fetch_array($sql)){
                ?>
        <tr>
          <td><?php echo $no++ ?></td>
          <td><?php echo $r['nama_kelas'] ?></td>
          <td><?php echo $r['judul_proyek'] ?></td>
          <td><?php echo $r['nama'] ?></td>
          <td>
            <?php
                            $siswa = mysqli_query($mysqli, "SELECT * FROM siswa_kelas WHERE id_kelas='$r[id_kelas]' AND tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'");
                            $jumlah = mysqli_num_rows($siswa);
                            echo $jumlah;
                        ?>
          </td>
          <td>
            <a href="?pages=detail-kokurikuler&orderID=<?php echo $r['id_proyek_kelas'] ?>"
              class="btn btn-warning btn-sm">Edit</a>
            <a href="?pages=penilaian-kokurikuler&orderID=<?php echo $r['id_proyek_kelas'] ?>&dataID=<?php echo $r['id_kelas'] ?>"
              class="btn btn-success btn-sm">Nilai</a>
            <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#salinModal"
              data-id="<?php echo $r['id_proyek_kelas'] ?>">Salin</a>
            <a href="?pages=kokurikuler&filter=hapus&orderID=<?php echo $r['id_proyek_kelas'] ?>"
              class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tambahKokurikulerModal" tabindex="-1" role="dialog" aria-labelledby="tambahKokurikulerModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahKokurikulerModalLabel">Tambah Kegiatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Add your form fields here -->
        <form method="POST">
          <div class="form-group">
            <label for="kelas">Kelas</label>
            <select name="id_kelas" required id="kelas-select" class="form-control" required>
              <option value="">Pilih Kelas</option>
              <?php
                            $kelas = mysqli_query($mysqli, "SELECT * FROM kelas ORDER BY id_tingkat, id_kelas ASC");
                            while($rkelas = mysqli_fetch_array($kelas)){
                                $sele = ($_GET['orderID'] == $rkelas['id_kelas']) ? "selected" : "";
                            ?>
              <option value="<?php echo $rkelas['id_kelas']?>" <?php echo $sele ?>>
                <?php echo $rkelas['nama_kelas'] ?>
              </option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="subelemen">Pembina Proyek</label>
            <select name="id_user" required class="form-control" style="width:100%;">
              <option value="">Pilih Pembina</option>
              <?php
                                $guru = mysqli_query($mysqli, "SELECT * FROM users WHERE jabatan='3' ORDER BY id_user ASC");
                                while ($rguru = mysqli_fetch_array($guru)) {
                                    $jumlahdata = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM kelas_wali WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$rkelas[id_kelas]' AND id_user='$rguru[id_user]'"));
                                    $sele = ($jumlahdata == 1) ? "selected" : "";
                            ?>
              <option value="<?php echo $rguru['id_user'] ?>" <?php echo $sele ?>>
                <?php echo $rguru['nama'] ?>
              </option>
              <?php } ?>
            </select>
            <input type="hidden" name="kode" required value="<?php echo $kode ?>">
          </div>
          <div class="form-group">
            <label for="subelemen">Judul Kegiatan</label>
            <input type="text" name="judul_proyek" required class="form-control" id="judul">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" name="simpan-tema" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script>
(function() {
  function initTambah() {
    if (typeof $ === 'undefined') { setTimeout(initTambah, 50); return; }
    $(document).ready(function() {
      $('#tambahKokurikulerModal').on('shown.bs.modal', function() {
        $('#kelas').trigger('focus')
      });
    });
  }
  initTambah();
})();
</script>

<!-- Modal Salin -->
<div class="modal fade" id="salinModal" tabindex="-1" role="dialog" aria-labelledby="salinModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="salinModalLabel">Salin Kegiatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST">
        <div class="modal-body">
          <input type="hidden" name="id_proyek_kelas_salin" id="idProyekSalin">
          <div class="form-group">
            <label>Kelas</label>
            <select name="id_kelas_salin" id="kelasSalin" class="form-control" required>
              <option value="">Pilih Kelas</option>
              <?php
              $kelas_salin = mysqli_query($mysqli, "SELECT * FROM kelas ORDER BY id_tingkat, id_kelas ASC");
              while($rkelas_salin = mysqli_fetch_array($kelas_salin)) {
              ?>
              <option value="<?php echo $rkelas_salin['id_kelas'] ?>"><?php echo $rkelas_salin['nama_kelas'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Pembina Kegiatan</label>
            <select name="id_user_salin" id="guruSalin" class="form-control" required>
              <option value="">Pilih Pembina</option>
              <?php
              $guru_salin = mysqli_query($mysqli, "SELECT * FROM users WHERE jabatan='3' ORDER BY id_user ASC");
              while ($rguru_salin = mysqli_fetch_array($guru_salin)) {
              ?>
              <option value="<?php echo $rguru_salin['id_user'] ?>"><?php echo $rguru_salin['nama'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" name="salin_kegiatan" class="btn btn-primary">Salin</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
(function() {
  function initSalin() {
    if (typeof $ === 'undefined') { setTimeout(initSalin, 50); return; }
    $(document).ready(function() {
      var dataWaliKelas = {
        <?php
        $q_wali = mysqli_query($mysqli, "SELECT kelas_wali.id_kelas, users.id_user
                                          FROM kelas_wali
                                          JOIN users ON kelas_wali.id_user = users.id_user
                                          WHERE kelas_wali.tahun='$sekolah[tahun]'
                                          AND kelas_wali.semester='$sekolah[semester]'");
        $first = true;
        while ($rw = mysqli_fetch_array($q_wali)) {
            if (!$first) echo ",\n";
            echo $rw['id_kelas'] . ": " . $rw['id_user'];
            $first = false;
        }
        ?>
      };

      $('#salinModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var idProyek = button.data('id');
        $('#idProyekSalin').val(idProyek);
        $('#kelasSalin').val('');
        $('#guruSalin').val('');
      });

      $('#kelasSalin').on('change', function() {
        var idKelas = parseInt($(this).val());
        if (idKelas && dataWaliKelas[idKelas]) {
          $('#guruSalin').val(dataWaliKelas[idKelas]);
        } else {
          $('#guruSalin').val('');
        }
      });
    });
  }
  initSalin();
})();
</script>

<?php
    // Sebelum mengakses orderID
    if (isset($_POST['orderID'])) {
        $orderID = $_POST['orderID'];
    } else {
        $orderID = null; // atau nilai default lainnya
    }

    if (isset($_POST['simpan-tema'])) {
        $kode = $_POST['kode'];
        $tahun = $sekolah['tahun'];
        $semester = $sekolah['semester'];
        $id_kelas = $_POST['id_kelas'];
        $id_tema = $_POST['id_tema'];
        $id_user = $_POST['id_user'];
        $judul_proyek = $_POST['judul_proyek'];
        $deskripsi_singkat = $_POST['deskripsi_singkat'];

        $sql = "INSERT INTO proyek_kelas VALUES (NULL, '$kode', '$tahun', '$semester', '$id_kelas', '$id_tema', '$id_user', '$judul_proyek', '$deskripsi_singkat')";
        if (mysqli_query($mysqli, $sql)) {
            ?>
<script>
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages']?>";
</script>
<?php
        }
        else {
        ?>
<script>
alert('Gagal');
</script>
<?php
        }
    }

    if (isset($_GET['filter']) && $_GET['filter'] == 'hapus' && isset($_GET['orderID'])) {
        $id_proyek_kelas = $_GET['orderID'];
        $delete = mysqli_query($mysqli, "DELETE FROM proyek_kelas WHERE id_proyek_kelas='$id_proyek_kelas'");
        if ($delete) {
            ?>
            <script>
            alert('Berhasil menghapus data');
            window.location.href = "?pages=kokurikuler";
            </script>
            <?php
        } else {
             ?>
            <script>
            alert('Gagal menghapus data');
            window.location.href = "?pages=kokurikuler";
            </script>
            <?php
        }
    }

    // Sebelum mengakses array
    if ($data !== null && is_array($data)) {
        // proses array
    }
?>