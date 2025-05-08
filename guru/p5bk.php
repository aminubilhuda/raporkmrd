<div class="container-fluid mt-4 bg-white p-4 shadow-sm">
    <h2>P5 SMKS ABDI NEGARA TUBAN</h2>
    <div class="mb-3">
        <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#tambahP5BKModal">Tambah P5BK</button> -->
    </div>
    <div class="table-responsive">
        <table id="datatable" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Tema</th>
                    <th>Pembina</th>
                    <th>Siswa</th>
                    <th>Edit / Nilai / Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $sql = mysqli_query($mysqli, "SELECT * FROM proyek_kelas
                    JOIN kelas ON proyek_kelas.id_kelas = kelas.id_kelas
                    JOIN proyek_tema ON proyek_kelas.id_tema = proyek_tema.id_tema
                    JOIN users ON proyek_kelas.id_user = users.id_user
                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND proyek_kelas.id_user='$_SESSION[id_user]'");
                    $no = 1;
                    while($r = mysqli_fetch_array($sql)){
                ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $r['nama_kelas'] ?></td>
                    <td><?php echo $r['tema'] ?></td>
                    <td><?php echo $r['nama'] ?></td>
                    <td>
                        <?php
                            $siswa = mysqli_query($mysqli, "SELECT * FROM siswa_kelas WHERE id_kelas='$r[id_kelas]' AND tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'");
                            $jumlah = mysqli_num_rows($siswa);
                            echo $jumlah;
                        ?>
                    </td>
                    <td>
                        <!-- <a href="?pages=detail-project&orderID=<?php echo $r['id_proyek_kelas'] ?>"
                            class="btn btn-warning btn-sm">Edit</a> -->
                        <a href="?pages=penilaian-profil-pancasila&orderID=<?php echo $r['id_proyek_kelas'] ?>&dataID=<?php echo $r['id_kelas'] ?>"
                            class="btn btn-success btn-sm">Nilai</a>
                        <!-- <a href="?pages=p5bk&filter=hapus&orderID=<?php echo $r['id_proyek_kelas'] ?>"
                            class="btn btn-danger btn-sm">Hapus</a> -->
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tambahP5BKModal" tabindex="-1" role="dialog" aria-labelledby="tambahP5BKModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahP5BKModalLabel">Tambah P5BK</h5>
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
                        <label for="tema">Tema</label>
                        <select name="id_tema" required id="tema-select" class="form-control" required>
                            <option value="">Pilih Tema</option>
                            <?php
                            $tema = mysqli_query($mysqli, "SELECT * FROM proyek_tema ORDER BY id_tema ASC");
                            while($rtema = mysqli_fetch_array($tema)){
                                $sele = ($_GET['orderID'] == $rtema['id_tema']) ? "selected" : "";
                            ?>
                            <option value="<?php echo $rtema['id_tema']?>" <?php echo $sele ?>>
                                <?php echo $rtema['tema'] ?>
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
                        <label for="subelemen">Judul Proyek</label>
                        <input type="text" name="judul_proyek" required class="form-control" id="judul">
                    </div>
                    <div class="form-group">
                        <label for="subelemen">Deskripsi</label>
                        <textarea name="deskripsi_singkat" required class="form-control"
                            id="deskripsi_singkat"></textarea>
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
    $('#tambahP5BKModal').on('shown.bs.modal', function() {
        $('#kelas').trigger('focus')
    })
});
</script>

<?php
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
?>