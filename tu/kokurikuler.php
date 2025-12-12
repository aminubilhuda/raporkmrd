<?php
// Create table if not exists
mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `deskripsi_kokurikuler` (
  `id_deskripsi` int(11) NOT NULL PRIMARY KEY,
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
  `id_dimensi` int(11) NOT NULL PRIMARY KEY,
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
          <th>Edit / Nilai / Hapus</th>
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
$(document).ready(function() {
  $('#tambahKokurikulerModal').on('shown.bs.modal', function() {
    $('#kelas').trigger('focus')
  })
});
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