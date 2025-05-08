<?php  
session_start();
if (empty($_SESSION['id_user']) || empty($_SESSION['jabatan'])) {
    echo "<script type='text/javascript'>
            alert('Login Terlebih Dahulu!');
            window.location.href = 'login.php';
          </script>";
} else {
    include "../assets/excel_reader/excel_reader.php";
?>

<section class="content-header">
    <h1>Tujuan Pembelajaran </h1>
    <form method="POST" id="mapelForm">
        <div class="form-group">
            <div class="card">
                <div class="card-body">
                    <label for="mapel" class="control-label">Pilih Mapel:</label>
                    <select name="mapel" class="form-control" onchange="this.form.submit()">
                        <option value="" disabled selected>Pilih Mapel</option>
                        <?php
                        $mapel = mysqli_query($mysqli, "SELECT * FROM mapel_kelas 
                                                        JOIN mapel ON mapel_kelas.id_mapel=mapel.id_mapel 
                                                        WHERE id_user='$_SESSION[id_user]' 
                                                        GROUP BY nama_mapel ASC");
                        while ($rmapel = mysqli_fetch_array($mapel)) {
                            $selected = (isset($_POST['mapel']) && $_POST['mapel'] == $rmapel['id_mapel']) ? 'selected' : '';
                            echo "<option value='{$rmapel['id_mapel']}' $selected>{$rmapel['nama_mapel']}</option>";
                        }
                    ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <?php
            if (isset($_POST['mapel']) && !empty($_POST['mapel'])) {
            $id_mapel = $_POST['mapel'];
            $kelas_query = mysqli_query($mysqli, "SELECT * FROM kelas 
                                                  JOIN mapel_kelas ON kelas.id_kelas=mapel_kelas.id_kelas
                                                  WHERE id_mapel='$id_mapel' 
                                                  ORDER BY nama_kelas ASC");
            if (mysqli_num_rows($kelas_query) > 0) { ?>
        <div class="form-group">
            <div style="margin-top: 10px;">
                <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#tambahTPModal<?=$id_mapel?>">Tambah
                    Tujuan Pembelajaran</button>
            </div>
        </div>


</section>

<!-- Menampilkan tujuan pembelajaran yang terkait dalam bentuk form edit -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Tujuan Pembelajaran</h3>
                    <div class="card-tools float-right">
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body table-responsive">
                    <div class="form-group">
                        <form action="" method="post">
                            <ul class="list-group">
                                <?php
                                $tujuan_query = mysqli_query($mysqli, "SELECT * 
                                                                        FROM tujuan_pembelajaran 
                                                                        WHERE id_mapel = '$id_mapel' 
                                                                        AND id_kelas IN (SELECT id_kelas FROM mapel_kelas WHERE id_mapel = '$id_mapel') 
                                                                        GROUP BY urut 
                                                                        ORDER BY id_tujuan ASC");
                                if (mysqli_num_rows($tujuan_query) > 0) {
                                    while ($rtujuan = mysqli_fetch_array($tujuan_query)) {
                                ?>
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th class="table-info" width="20%" style="vertical-align: middle;">Tujuan
                                            Pembelajaran</th>
                                        <td class="table-warning">
                                            <textarea name="tujuan[]" class="form-control"
                                                id="tujuan_<?php echo $rtujuan['id_tujuan']; ?>"
                                                required><?php echo $rtujuan['tujuan']; ?></textarea>
                                            <input type="hidden" name="id_tujuan[]"
                                                value="<?php echo $rtujuan['id_tujuan']; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%" style="vertical-align: middle;">KKTP Angka</th>
                                        <td>
                                            <input type="number" name="kktp[]" class="form-control"
                                                id="kktp_<?php echo $rtujuan['id_tujuan']; ?>"
                                                value="<?php echo $rtujuan['kktp']; ?>" required>
                                            <!-- hidden urut -->
                                            <input type="hidden" name="urut[]" class="form-control"
                                                id="urut_<?php echo $rtujuan['id_tujuan']; ?>"
                                                value="<?php echo $rtujuan['urut']; ?>" required>
                                        </td>
                                    </tr>
                                </table>
                                <?php 
                                    } 
                                } else {
                                    echo "<div class='alert alert-warning' role='alert' style='margin-top: 20px;'>Tidak ada tujuan pembelajaran yang tersedia. Silakan tambahkan tujuan pembelajaran baru!</div>";
                                }
                                if (mysqli_num_rows($tujuan_query) > 0) { ?>
                                <input type="submit" name="update_tp" class="btn btn-success mt-2" value="Update TP">
                                <?php } ?>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
</section>


<!-- Modal -->
<div class="modal fade" id="tambahTPModal<?=$id_mapel?>" tabindex="-1" role="dialog"
    aria-labelledby="tambahTPModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahTPModalLabel"> Tambah Tujuan
                    Pembelajaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="tujuanPembelajaranForm">
                    <div class="form-group">
                        <label for="no_urut">No Urut: </label>
                        <div class="d-flex justify-content-between">

                            <?php $query_s_mapel = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM mapel WHERE id_mapel='$id_mapel'"))['s_mapel'] ?>
                            <input type="text" name="s_mapel" autocomplete="off" value="<?=$query_s_mapel?>"
                                class="form-control col-sm-2" readonly>
                            <input type="text" name="no_urut" autocomplete="off" class="form-control">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="tujuan_pembelajaran">Tujuan Pembelajaran:</label>
                        <textarea name="tujuan_pembelajaran" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kktp">KKTP Angka:</label>
                        <input type="number" name="kktp" class="form-control" value='75' required>
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas Terkait:</label>
                        <div>
                            <?php 
                            while ($rkelas = mysqli_fetch_array($kelas_query)) { ?>
                            <div class="form-check">
                                <input type="checkbox" name="kelas[]" class="form-check-input"
                                    value="<?php echo $rkelas['id_kelas']; ?>"
                                    id="kelas_<?php echo $rkelas['id_kelas']; ?>" checked>
                                <label class="form-check-label"
                                    for="kelas_<?php echo $rkelas['id_kelas']; ?>"><?php echo $rkelas['nama_kelas']; ?></label>
                                <input type="hidden" name="id_mapel" id="id_mapel" value="<?= $rkelas['id_mapel'] ?>">
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <input type="submit" name="simpanTP" class="btn btn-success" value="Simpan TP">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<?php if (mysqli_num_rows($kelas_query) == 0) { ?>
<p>Tidak ada kelas terkait untuk mapel ini.</p>
<?php } ?>
<?php } ?>
<?php } ?>

</form>

<?php
if (isset($_POST['simpanTP'])) {
    $kelas = isset($_POST['kelas']) ? $_POST['kelas'] : [];
    $s_mapel = $_POST['s_mapel'];
    $no_urut = $_POST['no_urut'];
    $urut = $s_mapel.".".$no_urut;
    $tujuan = $_POST['tujuan_pembelajaran'];
    $id_mapel = $_POST['id_mapel'];
    $kktp = $_POST['kktp'];

    // Simpan tujuan pembelajaran ke dalam tabel
    foreach ($kelas as $id_kelas) {
        $query = "INSERT INTO tujuan_pembelajaran (tahun, semester, id_tingkat, id_kelas, id_mapel, urut, tujuan, kktp,middle_formatif, middle_ph, formatif_as) VALUES ('$sekolah[tahun]', '$sekolah[semester]', '$id_tingkat', '$id_kelas', '$id_mapel', '$urut', '$tujuan', '$kktp','1','1','1')";
        mysqli_query($mysqli, $query);
    }
    echo "
    <script>
        window.alert('Tujuan Pembelajaran berhasil disimpan!');
        window.location.href = '?pages=tpu';
    </script>
    "; 
}

?>

<?php
    if (isset($_POST['update_tp'])) {
        $tujuan = $_POST['tujuan'];
        $urut = $_POST['urut'];
        $id_kelas = $_POST['id_kelas'];
        $kktp = $_POST['kktp'];
        $id_tujuan = $_POST['id_tujuan'];

        for ($i = 0; $i < count($tujuan); $i++) {
            $update_query = mysqli_query($mysqli, "UPDATE tujuan_pembelajaran SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', tujuan='$tujuan[$i]', kktp='$kktp[$i]' WHERE id_mapel='$id_mapel' AND urut='$urut[$i]'");
        }

        if ($update_query) {
            echo "<script>alert('Tujuan Pembelajaran berhasil diperbarui.');</script>";
            echo "<script>window.location.href = '?pages=" . $_GET['pages'] . "&orderID=" . $_GET['orderID'] . "';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui Tujuan Pembelajaran.');</script>";
        }
    }
?>


<?php } ?>