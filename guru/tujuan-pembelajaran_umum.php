<section class="content-header">
    <h1>
        Daftar Mata Pelajaran
    </h1>
</section>
<section class="content-header">
    <form method="POST">
        <div class="form-group">
            <label for="kelas-select" class="sr-only">Pilih Kelas</label>
            <div class="input-group" style="max-width: 600px;">
                <select name="mapel_tingkat" id="kelas-select" class="form-control" onchange="redirectToPage()"
                    required>
                    <option value="">Pilih Mapel dan Kelas</option>
                    <?php
                    $kelas = mysqli_query($mysqli, "
                        SELECT DISTINCT kelas.id_tingkat, mapel.id_mapel, mapel.nama_mapel
                        FROM mapel_kelas
                        JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                        JOIN kelas ON mapel_kelas.id_kelas = kelas.id_kelas
                        WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_user = '$_SESSION[id_user]'
                        ORDER BY kelas.id_tingkat ASC, mapel.nama_mapel ASC
                    ");

                    while ($data_mapel = mysqli_fetch_array($kelas)) {
                        $value = $data_mapel['id_mapel'] . '-' . $data_mapel['id_tingkat'];
                        $sele = (isset($_GET['orderID'], $_GET['tingkatID']) &&
                            $_GET['orderID'] . '-' . $_GET['tingkatID'] === $value) ? "selected" : "";
                    ?>
                    <option value="<?php echo $value; ?>" <?php echo $sele; ?>>
                        <?php echo $data_mapel['nama_mapel']; ?> (Kelas-
                        <?php echo ($data_mapel['id_tingkat'] == 1) ? "X" :
                            (($data_mapel['id_tingkat'] == 2) ? "XI" :
                            (($data_mapel['id_tingkat'] == 3) ? "XII" : "KELAS SALAH")); ?>)
                    </option>
                    <?php } ?>
                </select>

                <div class="input-group-append">
                    <button type="submit" name="cari" class="btn btn-primary"
                        style="background-color: #6f42c1; border-color: #6f42c1;">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </div>

    </form>

    <?php
    if (isset($_POST['cari'])) {
       list($id_mapel, $id_tingkat) = explode('-', $_POST['mapel_tingkat']);
    ?>
    <script>
    window.location.href =
        "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $id_mapel ?>&tingkatID=<?php echo $id_tingkat ?>";
    </script>
    <?php
    }
    ?>
</section>
<script>
function redirectToPage() {
    const select = document.getElementById('kelas-select');
    const selectedValue = select.value;

    if (selectedValue) {
        const [id_mapel, id_tingkat] = selectedValue.split('-');
        const url = `?pages=<?php echo $_GET['pages']; ?>&orderID=${id_mapel}&tingkatID=${id_tingkat}`;
        window.location.href = url;
    }
}
</script>

<?php if(!empty($_GET['orderID']) && !empty($_GET['tingkatID']) && empty($_GET['filter'])){ 
        
        $mapel_kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM mapel_kelas
        JOIN kelas ON mapel_kelas.id_kelas=kelas.id_kelas
        join mapel ON mapel_kelas.id_mapel=mapel.id_mapel
        WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND mapel.id_mapel='$_GET[orderID]' AND mapel_kelas.id_user='$_SESSION[id_user]' AND id_tingkat='$_GET[tingkatID]'"));
        
        
        
?>

<section class="content-header">
    <div class="form-group">
        <div style="margin-top: 10px;">
            <button type="button" class="btn btn-primary" data-toggle="modal"
                data-target="#tambahTPModal<?=$mapel_kelas['id_mapel']?>-<?=$mapel_kelas['id_tingkat']?>">Tambah
                Tujuan Pembelajaran</button>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="tambahTPModal<?=$mapel_kelas['id_mapel']?>-<?=$mapel_kelas['id_tingkat']?>" tabindex="-1"
    role="dialog" aria-labelledby="tambahTPModalLabel" aria-hidden="true">
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
                            <input type="hidden" name="s_mapel" autocomplete="off" value="<?=$mapel_kelas['s_mapel']?>"
                                class="form-control col-sm-2" readonly>
                            <input type="hidden" name="id_tingkat" autocomplete="off"
                                value="<?= ($_GET['tingkatID'] == 1 ? "X" : ($_GET['tingkatID'] == 2 ? "XI" : ($_GET['tingkatID'] == 3 ? "XII" : "KELAS SALAH"))) ?>"
                                class="form-control col-sm-2" readonly>
                            <input type="text" id="no_urut" name="no_urut" autofocus autocomplete="off" class="form-control" required
                                placeholder="Contoh : 1">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="tujuan_pembelajaran">Tujuan Pembelajaran:</label>
                        <textarea name="tujuan_pembelajaran" class="form-control" required placeholder="Masukkan Tujuan Pembelajaran"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kktp">KKTP Angka:</label>
                        <input type="number" name="kktp" class="form-control" value='75' required>
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas Terkait:</label>
                        <div>
                            <?php
                            // Query untuk mengambil kelas terkait berdasarkan id_mapel yang dipilih
                            $kelas_terkait = mysqli_query($mysqli, "
                                SELECT kelas.id_kelas, kelas.nama_kelas 
                                FROM mapel_kelas 
                                JOIN kelas ON mapel_kelas.id_kelas = kelas.id_kelas 
                                WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND mapel_kelas.id_mapel = '$mapel_kelas[id_mapel]' AND kelas.id_tingkat='$_GET[tingkatID]' AND mapel_kelas.id_user='$_SESSION[id_user]'
                            ");

                            // Loop untuk menampilkan setiap kelas terkait
                            while ($data_kelas = mysqli_fetch_assoc($kelas_terkait)) { ?>
                            <div class="form-check">
                                <input type="checkbox" name="kelas[]" class="form-check-input"
                                    value="<?php echo $data_kelas['id_kelas']; ?>"
                                    id="kelas_<?php echo $data_kelas['id_kelas']; ?>" checked>
                                <label class="form-check-label" for="kelas_<?php echo $data_kelas['id_kelas']; ?>">
                                    <?php echo $data_kelas['nama_kelas']; ?>
                                </label>
                                <!-- Ambil id_mapel dari $mapel_kelas, bukan dari $data_kelas -->
                                <input type="hidden" name="id_mapel" id="id_mapel"
                                    value="<?php echo $mapel_kelas['id_mapel']; ?>">
                                <input type="hidden" name="id_tingkat" id="id_mapel"
                                    value="<?php echo $_GET['tingkatID']; ?>">
                                <input type="hidden" name="id_kelas" id="id_mapel"
                                    value="<?php echo $data_kelas['id_kelas']; ?>">
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="simpanTP" class="btn btn-success" value="Simpan TP">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Menampilkan tujuan pembelajaran yang terkait dalam bentuk form edit -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header bg-danger">
                    <h3 class="card-title text-white">Daftar Tujuan Pembelajaran <?=$mapel_kelas['nama_mapel']?>
                        Kelas
                        <?= ($mapel_kelas['id_tingkat'] == 1 ? "X" : ($mapel_kelas['id_tingkat'] == 2 ? "XI" : ($mapel_kelas['id_tingkat'] == 3 ? "XII" : "KELAS SALAH"))) ?>
                    </h3>
                    <div class="card-tools float-right">
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body table-responsive">
                    <div class="form-group">
                        <form action="" method="post">
                            <ul class="list-group">
                                <!--Menampilkan tujuan pembelajaran umum-->
                                <?php
                                $tujuan_query = mysqli_query($mysqli, "SELECT * 
                                    FROM tujuan_pembelajaran 
                                    WHERE id_mapel = '$mapel_kelas[id_mapel]'  AND tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' 
                                    AND id_kelas IN (SELECT id_kelas FROM mapel_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_mapel = '$mapel_kelas[id_mapel]' AND id_tingkat='$_GET[tingkatID]' AND id_kelas='$mapel_kelas[id_kelas]' AND id_user='$_SESSION[id_user]') 
                                    GROUP BY urut 
                                    ORDER BY id_tujuan ASC
                                    ");
                                if (mysqli_num_rows($tujuan_query) > 0) { ?>
                                <?php
                                $no = 1;
                                    while ($rtujuan = mysqli_fetch_array($tujuan_query)) {
                                ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <tr>
                                            <th class="table-dark" width="10" style="vertical-align: middle;">No</th>
                                            <th class="table-info" width="20%" style="vertical-align: middle;">Tujuan
                                                Pembelajaran</th>
                                            <td class="table-warning">
                                                <textarea name="tujuan[]" class="form-control"
                                                    id="tujuan_<?php echo $rtujuan['id_tujuan']; ?>"
                                                    required><?php echo $rtujuan['tujuan']; ?></textarea>
                                                <input type="hidden" name="id_tujuan[]"
                                                    value="<?php echo $rtujuan['id_tujuan']; ?>">
                                            </td>
                                            <td rowspan='2' class="align-middle table-success" style="width: 100px;">
                                                <a href="?pages=<?php echo $_GET['pages']; ?>&orderID=<?php echo $_GET['orderID']; ?>&tingkatID=<?php echo $_GET['tingkatID']; ?>&hapus=<?php echo $rtujuan['urut']; ?>"
                                                    class="btn btn-danger d-flex align-items-center justify-content-center"
                                                    style="height: 100%; width: 100%;">
                                                    Hapus
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= $no++; ?></td>
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
                                </div>
                                <?php 
                                    } 
                                } else {
                                    echo "
                                    <div class='alert alert-warning' role='alert' style='margin-top: 20px; 
                                        background-color: #fff3cd; 
                                        border: 1px solid #ffeeba; 
                                        color: #856404; 
                                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
                                        border-radius: 8px; 
                                        padding: 15px;'>
                                        <i class='fas fa-exclamation-triangle'></i> 
                                        Tidak ada tujuan pembelajaran yang tersedia. Silakan tambahkan tujuan pembelajaran baru!
                                    </div>";
                                }
                                if (mysqli_num_rows($tujuan_query) > 0) { ?>

                                <input type="submit" name="update_tp" class="btn-gradient mt-2 btn-lg"
                                    value="Simpan Perubahan TP">
                                <?php } ?>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
</section>



<?php } ?>


<?php
if (isset($_POST['simpanTP'])) {
    $kelas = isset($_POST['kelas']) ? $_POST['kelas'] : []; // Mengambil kelas sebagai array
    $s_mapel = $_POST['s_mapel'];
    $no_urut = $_POST['no_urut'];
    $tingkat = $_POST['id_tingkat'];
    $id_tingkat = $_GET['tingkatID'];

    // Menggabungkan kelas menjadi string
    $kelas_string = implode(",", $kelas); // Mengubah array kelas menjadi string

    // Membuat urut dengan kelas_string
    $urut = $s_mapel . "." . $tingkat . "-" . $kelas_string ."-" . $no_urut. "-" . rand(100, 999);

    $tujuan = addslashes($_POST['tujuan_pembelajaran']);
    $id_mapel = $_POST['id_mapel'];
    $id_user = $_SESSION['id_user'];
    $kktp = $_POST['kktp'];

    $success = true;

    foreach ($kelas as $id_kelas) {
        $query = "INSERT INTO tujuan_pembelajaran 
                  (tahun, semester, id_tingkat, id_kelas, id_mapel, id_user, urut, tujuan, kktp, middle_formatif, middle_ph, formatif_as) 
                  VALUES ('$sekolah[tahun]', '$sekolah[semester]', '$id_tingkat', '$id_kelas', '$id_mapel','$id_user', '$urut', '$tujuan', '$kktp', '1', '1', '1')";
        if (!mysqli_query($mysqli, $query)) {
            $success = false;
        }
    }

    if ($success) {
        echo "
        <script>
                alert('Tujuan Pembelajaran berhasil disimpan!');
                window.location.href = '?pages=$_GET[pages]&orderID=$id_mapel&tingkatID=$id_tingkat';
        </script>";
    } else {
    echo "
        <script>
            alert('Gagal menyimpan data!');
        </script>";
    }
}

?>

<?php
if (isset($_POST['update_tp'])) {
    $tujuan = $_POST['tujuan'];
    $urut = $_POST['urut'];
    $kktp = $_POST['kktp'];
    

    // Eksekusi update untuk setiap record dalam loop
    for ($i = 0; $i < count($urut); $i++) {
        $query = "
            UPDATE tujuan_pembelajaran 
            SET 
                tujuan = '{$tujuan[$i]}', 
                kktp = '{$kktp[$i]}'
            WHERE 
                urut = '{$urut[$i]}'
        ";

        // Eksekusi query untuk setiap record
        if (mysqli_query($mysqli, $query)) {
            continue;
        } else {
            echo "<script>alert('Gagal memperbarui pada urut {$urut[$i]}: " . mysqli_error($mysqli) . "');</script>";
        }
    }

    // Redirect setelah selesai semua proses update
    echo "<script>alert('Tujuan Pembelajaran berhasil diperbarui.');</script>";
    echo "<script>window.location.href = '?pages=" . $_GET['pages'] . "&orderID=" . $_GET['orderID'] . "&tingkatID=" . $_GET['tingkatID'] . "';</script>";
}
?>

<?php
if (isset($_GET['hapus'])) {
    $urut_hapus = $_GET['hapus']; // Mengambil urut_hapus dari URL

    // Membuat query untuk menghapus berdasarkan urut
    $query = "DELETE FROM tujuan_pembelajaran WHERE urut = '$urut_hapus' AND id_user = '{$_SESSION['id_user']}'";

    // Eksekusi query
    if (mysqli_query($mysqli, $query)) {
        echo "<script>alert('Tujuan Pembelajaran berhasil dihapus!');</script>";
    } else {
        echo "<script>alert('Gagal menghapus tujuan pembelajaran dengan urut: $urut_hapus');</script>";
    }

    // Redirect setelah penghapusan
    echo "<script>window.location.href = '?pages=" . $_GET['pages'] . "&orderID=" . $_GET['orderID'] . "&tingkatID=" . $_GET['tingkatID'] . "';</script>";
}
?>