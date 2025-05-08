<?php  

    $orderID = htmlspecialchars($_GET['orderID']);
    $stmt = $mysqli->prepare("SELECT * FROM mapel_kelas 
    JOIN kelas ON mapel_kelas.id_kelas = kelas.id_kelas
    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
    WHERE id_mapel_kelas=?");
    $stmt->bind_param("s", $orderID);
    $stmt->execute();
    $mapelkelas = $stmt->get_result()->fetch_array();
    
    $id_kelas = $mapelkelas['id_kelas'];
    $id_mapel = $mapelkelas['id_mapel'];
    
    $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=?");
    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
    $stmt->execute();
    $jumlahtp = $stmt->get_result()->num_rows;
    
    
    include "../bot/wa/functionbot.php";

?>


<section class="content-header">
    <h1>
        Tujuan Pembelajaran <?php echo $mapelkelas['nama_mapel']?> - <?php echo $mapelkelas['nama_kelas']?>
    </h1>
</section>

<section class="content-header">
    <a href="?pages=<?php echo 'kelas-ku'?>" class="btn btn-primary">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>
    <a href="?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo 'formatif'?>"
        class="btn btn-success">
        <i class="fa fa-file-text"></i> Formatif
    </a>
    <a href="?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo 'sumatif-harian'?>"
        class="btn btn-info">
        <i class="fa fa-calendar-check-o"></i> Sumatif
    </a>
    <a href="?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo 'sumatif-ts'?>"
        class="btn btn-danger">
        <i class="fa fa-clock-o"></i> Sumatif TS
    </a>
    <a href="?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo 'sumatif-as'?>"
        class="btn btn-warning">
        <i class="fa fa-check-square-o"></i> Sumatif AS
    </a>
</section>



<?php if(empty($_GET['detail']) or $_GET['detail']=='formatif'){ ?>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                </div>
                <form method="POST">
                    <div class="card-body table-responsive">
                        <div class="d-flex justify-content-between align-items-center">
                            <p>
                                <button type="submit" name="simpannilai" class="btn btn-success">Simpan Nilai
                                    Formatif</button>
                            <h3 class="mx-auto" style="padding-right: 140px;">Penilaian <i
                                    class="text-danger">Formatif</i>
                                <?php echo $mapelkelas['nama_mapel']?> -
                                <?php echo $mapelkelas['nama_kelas']?></h3>
                            </p>
                        </div>
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr class="bg-warning">
                                    <th rowspan="2" style="text-align:center; vertical-align:middle;">No</th>
                                    <th rowspan="2" style="text-align:center; vertical-align:middle;">Nama Peserta
                                        Didik
                                    </th>
                                    <th colspan="<?php echo $jumlahtp ?>"
                                        style="text-align:center; vertical-align:middle;">Tujuan Pembelajaran</th>
                                    <th rowspan="2" style="text-align:center; vertical-align:middle;">Jumlah Nilai <br>
                                        Formatif</th>
                                    <th rowspan="2" style="text-align:center; vertical-align:middle;">Rata-rata
                                        Nilai
                                        Formatif</th>
                                </tr>
                                <tr class="bg-warning">
                                    <?php
                                    $nomor=1;
                                    $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? ORDER BY urut ASC");
                                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                    $stmt->execute();
                                    $datatujuan = $stmt->get_result();
                                    while($rdatatujuan = $datatujuan->fetch_array()){
                                    ?>
                                    <th class="fixed-table"
                                        style="text-align:center; vertical-align:middle; width:70px;">
                                        <a href="" data-toggle="tooltip" data-placement="top"
                                            title="<?php echo $rdatatujuan['tujuan']; ?>">F.
                                            <?php echo $nomor++?></a> <br>
                                        <form method="POST">
                                            <a href="" class="btn btn-success btn-custom btn-sm" data-toggle="modal"
                                                data-placement="top" data-toggle="tooltip"
                                                title="Inputkan Angka Serentak" data-target="#myModalAdd" title="Add"
                                                onclick="setActiveColumn(this)">
                                                <i class="fas fa-th-list"></i>
                                            </a>
                                            <input type="hidden" name="id_tujuan"
                                                value="<?php echo $rdatatujuan['id_tujuan']; ?>">
                                            <button type="submit" name="delete_tujuan"
                                                class="btn btn-danger btn-custom btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus nilai tujuan pembelajaran ini dengan nama: <?php echo $rdatatujuan['tujuan']; ?> ?');">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody id="student-table-body">
                                <?php
                                $stmt = $mysqli->prepare("SELECT siswa_kelas.*, siswa.nama_siswa, mapel_siswa.aktif 
                                FROM siswa_kelas 
                                JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                                JOIN mapel_siswa ON siswa_kelas.id_siswa = mapel_siswa.id_siswa
                                WHERE siswa_kelas.tahun=? AND siswa_kelas.semester=? AND siswa_kelas.id_kelas=? AND mapel_siswa.id_mapel=? AND mapel_siswa.aktif=1
                                ORDER BY siswa.nama_siswa ASC");
                                $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                $stmt->execute();
                                $siswakelas = $stmt->get_result();

                                $nomor=1;
                                while($rsiswakelas = $siswakelas->fetch_array()){
                                ?>
                                <tr>
                                    <td style="text-align:center;"><?php echo $nomor++?></td>
                                    <td><?php echo $rsiswakelas['nama_siswa']?></td>
                                    <?php
                                    $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? ORDER BY urut ASC");
                                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                    $stmt->execute();
                                    $datatujuan = $stmt->get_result();
                                    $colIndex = 0;
                                    while($rdatatujuan = $datatujuan->fetch_array()){
                                        $stmt = $mysqli->prepare("SELECT * FROM nilai_formatif WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND id_tujuan=?");
                                        $stmt->bind_param("ssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa'], $rdatatujuan['id_tujuan']);
                                        $stmt->execute();
                                        $nilaiformatif = $stmt->get_result()->fetch_array();
                                    ?>
                                    <td style="text-align:center; vertical-align:middle; width:5%;" class="input-column"
                                        data-col-index="<?php echo $colIndex++; ?>">
                                        <input type="text" name="nilai[]" class="form-control"
                                            style="width:50px; text-align:center;" autocomplete="off" placeholder="-"
                                            value="<?php echo $nilaiformatif['nilai']?>">
                                        <input type="hidden" name="siswa[]"
                                            value="<?php echo $rsiswakelas['id_siswa']?>">
                                        <input type="hidden" name="tujuan[]"
                                            value="<?php echo $rdatatujuan['id_tujuan']?>">
                                    </td>
                                    <?php } ?>
                                    <td style="text-align:center; vertical-align:middle;">
                                        <?php
                                        $stmt = $mysqli->prepare("SELECT SUM(nilai) AS jumlah_nilai FROM nilai_formatif WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=?");
                                        $stmt->bind_param("sssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa']);
                                        $stmt->execute();
                                        $jumlahnilai = $stmt->get_result()->fetch_array();
                                        echo $datajumlah = $jumlahnilai['jumlah_nilai'];
                                        ?>
                                    </td>
                                    <td style="text-align:center; vertical-align:middle;">
                                        <?php echo $datarata = round(($datajumlah/$jumlahtp),2) ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div><!-- /.row -->
</section><!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="myModalAdd" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Masukkan Nilai Dipisah Enter</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form>
                    <textarea name="nilai_batch" id="nilai_batch" class="form-control" style="height: 300px;"
                        placeholder="Masukkan nilai siswa, pisahkan dengan enter..."></textarea>
                    <div class="modal-footer">
                        <button type="button" id="insertValues" class="btn btn-success">Masukkan Nilai</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
let activeColumnIndex;

function setActiveColumn(element) {
    // Set column index dari kolom yang diklik (menggunakan 'data-col-index')
    let column = element.closest('th');
    let columns = Array.from(column.parentElement.children);
    activeColumnIndex = columns.indexOf(column); // Mendapatkan index kolom TP yang diklik
}

document.getElementById('insertValues').addEventListener('click', function() {
    let values = document.getElementById('nilai_batch').value.trim().split('\n');
    let studentRows = document.querySelectorAll('#student-table-body tr');

    // Loop through each row and fill the correct input field in the active column
    values.forEach((value, index) => {
        if (index < studentRows.length) {
            let inputField = studentRows[index].querySelectorAll('.input-column')[activeColumnIndex];
            inputField.querySelector('input').value = value.trim();
        }
    });

    $('#myModalAdd').modal('hide'); // Close the modal after inserting values
});
</script>



<?php
    if (isset($_POST['delete_tujuan'])) {
        $id_tujuan = $_POST['id_tujuan'];
        $stmt = $mysqli->prepare("SELECT COUNT(*) as count FROM `nilai_formatif` WHERE id_tujuan=?");
        $stmt->bind_param("s", $id_tujuan);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_array();

        if ($result['count'] == 0) {
            echo "<script>alert('Tidak ada nilai dengan ID tujuan ini.'); window.location.href='index.php?pages=penilaian&orderID=$orderID';</script>";
        } else {
            $stmt = $mysqli->prepare("DELETE FROM `nilai_formatif` WHERE id_tujuan=?");
            $stmt->bind_param("s", $id_tujuan);
            if ($stmt->execute()) {
                echo "<script>alert('Tujuan pembelajaran berhasil dihapus.'); window.location.href='index.php?pages=penilaian&orderID=$orderID';</script>";
            } else {
                echo "<script>alert('Gagal menghapus tujuan pembelajaran.'); window.location.href='index.php?pages=penilaian&orderID=$orderID';</script>";
            }
        }
    }
?>

<?php
    if(isset($_POST['simpannilai'])){
    $nilai = $_POST['nilai'];
    $siswa = $_POST['siswa'];
    $tujuan = $_POST['tujuan'];
    
    $jumlahsiswa = count($siswa);
    $nilaiBerubah = false; // Flag untuk mengecek apakah ada nilai yang berubah

    for ($i=0; $i < $jumlahsiswa ; $i++) { 
        $stmt = $mysqli->prepare("SELECT * FROM nilai_formatif WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND id_tujuan=?");
        $stmt->bind_param("ssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $siswa[$i], $tujuan[$i]);
        $stmt->execute();
        $ceknilai = $stmt->get_result()->num_rows;
        
        if($ceknilai == 0){
            $stmt = $mysqli->prepare("INSERT INTO nilai_formatif SET tahun=?, semester=?, id_kelas=?, id_mapel=?, id_siswa=?, id_tujuan=?, nilai=?, middle=?, nas=?");
            $stmt->bind_param("sssssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $siswa[$i], $tujuan[$i], $nilai[$i], $middle='1', $nas='1');
            $stmt->execute();
            $nilaiBerubah = true; // Ada nilai baru yang ditambahkan
        }else{
            $stmt = $mysqli->prepare("UPDATE nilai_formatif SET nilai=? WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND id_tujuan=?");
            $stmt->bind_param("sssssss", $nilai[$i], $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $siswa[$i], $tujuan[$i]);
            $stmt->execute();
            if($stmt->affected_rows > 0) {
                $nilaiBerubah = true; // Ada nilai yang diupdate
            }
        }
    }

    if($nilaiBerubah) {
        // Mengirimkan notifikasi ke wali kelas jika ada nilai yang berubah
        $kontakWaliKelas = getKontakWaliKelas($id_kelas);
        $pesan = "Nilai Formatif untuk mata pelajaran " . $mapelkelas['nama_mapel'] . " di kelas " . $mapelkelas['nama_kelas'] . " telah diinput oleh guru.";
        kirimPesanWali($kontakWaliKelas, $pesan);
?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: 'Berhasil menyimpan nilai dan mengirim notifikasi.'
}).then(() => {
    window.location.href =
        "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo $_GET['detail']?>";
});
</script>
<?php
    } else {
?>
<script>
Swal.fire({
    icon: 'warning',
    title: 'Tidak Ada Perubahan',
    text: 'Tidak ada perubahan pada nilai.'
}).then(() => {
    window.location.href =
        "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo $_GET['detail']?>";
});
</script>
<?php
    }
}
?>


<?php }elseif($_GET['detail']=="sumatif-harian") {?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header">

                    <div class="card-tools float-right">
                    </div>
                </div><!-- /.card-header -->
                <form method="POST">
                    <div class="card-body table-responsive">
                        <div class="d-flex justify-content-between align-items-center">
                            <p>
                                <button type="submit" name="simpannilai" class="btn btn-success">Simpan Nilai
                                    Sumatif</button>
                            <h3 class="mx-auto" style="padding-right: 140px;">Penilaian <i
                                    class="text-danger">Sumatif</i>
                                <?php echo $mapelkelas['nama_mapel']?> -
                                <?php echo $mapelkelas['nama_kelas']?></h3>
                            </p>
                        </div>
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr class="bg-info">
                                    <th rowspan="2" style="text-align:center; vertical-align:middle;">No</th>
                                    <th rowspan="2" style="text-align:center; vertical-align:middle;">Nama Peserta Didik
                                    </th>
                                    <th colspan="<?php echo $jumlahtp ?>"
                                        style="text-align:center; vertical-align:middle;">Tujuan Pembelajaran</th>
                                    <th rowspan="2" style="text-align:center; vertical-align:middle;">Jumlah Nilai <br>
                                        Sumatif</th>
                                    <th rowspan="2" style="text-align:center; vertical-align:middle;">Rata-rata
                                        <br>Nilai Sumatif
                                    </th>
                                </tr>
                                <tr class="bg-info">
                                    <?php
                                    $nomor=1;
                                    $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? ORDER BY urut ASC");
                                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                    $stmt->execute();
                                    $datatujuan = $stmt->get_result();
                                    while($rdatatujuan = $datatujuan->fetch_array()){
                                    ?>
                                    <th style="text-align:center; vertical-align:middle; width:70px;"
                                        data-col-index="<?php echo $nomor; ?>">
                                        <a href="" title="<?php echo $rdatatujuan['tujuan']; ?>" data-toggle="tooltip"
                                            data-placement="top">S.
                                            <?php echo $nomor++?></a> <br>
                                        <form method="POST">
                                            <a href="" class="btn btn-success btn-custom btn-sm" data-toggle="modal"
                                                data-placement="top" data-toggle="tooltip"
                                                title="Inputkan Angka Serentak" data-target="#myModalAddSumatif"
                                                onclick="setActiveColumn(<?php echo $nomor - 1; ?>)">
                                                <i class="fas fa-th-list"></i>
                                            </a>
                                            <input type="hidden" name="id_tujuan"
                                                value="<?php echo $rdatatujuan['id_tujuan']; ?>">
                                            <button type="submit" name="hapus_nilai_s"
                                                class="btn btn-danger btn-custom btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus nilai tujuan pembelajaran ini dengan nama: <?php echo $rdatatujuan['tujuan']; ?> ?');">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody id="student-table-body">
                                <?php
                               $stmt = $mysqli->prepare("SELECT siswa_kelas.*, siswa.nama_siswa, mapel_siswa.aktif 
                                FROM siswa_kelas 
                                JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                                JOIN mapel_siswa ON siswa_kelas.id_siswa = mapel_siswa.id_siswa
                                WHERE siswa_kelas.tahun=? AND siswa_kelas.semester=? AND siswa_kelas.id_kelas=? AND mapel_siswa.id_mapel=? AND mapel_siswa.aktif=1
                                ORDER BY siswa.nama_siswa ASC");
                                $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                $stmt->execute();
                                $siswakelas = $stmt->get_result();
                                $nomor=1;
                                while($rsiswakelas = $siswakelas->fetch_array()){
                                ?>
                                <tr>
                                    <td style="text-align:center;"><?php echo $nomor++?></td>
                                    <td><?php echo $rsiswakelas['nama_siswa']?></td>
                                    <?php
                                    $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? ORDER BY urut ASC");
                                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                    $stmt->execute();
                                    $datatujuan = $stmt->get_result();
                                    $colIndex = 0;
                                    while($rdatatujuan = $datatujuan->fetch_array()){
                                        $stmt = $mysqli->prepare("SELECT * FROM nilai_sumatif_ph WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND id_tujuan=?");
                                        $stmt->bind_param("ssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa'], $rdatatujuan['id_tujuan']);
                                        $stmt->execute();
                                        $nilaisumatifph = $stmt->get_result()->fetch_array();
                                    ?>
                                    <td style="text-align:center; vertical-align:middle; width:5%;" class="input-column"
                                        data-col-index="<?php echo $colIndex++; ?>">
                                        <input type="text" name="nilai[]" style="width:50px; text-align:center;"
                                            class="form-control" placeholder="-" autocomplete="off"
                                            value="<?php echo $nilaisumatifph['nilai']?>">
                                        <input type="hidden" name="siswa[]" style="width:100%;" autocomplete="off"
                                            value="<?php echo $rsiswakelas['id_siswa']?>">
                                        <input type="hidden" name="tujuan[]" style="width:100%;" autocomplete="off"
                                            value="<?php echo $rdatatujuan['id_tujuan']?>">
                                    </td>
                                    <?php } ?>
                                    <td style="text-align:center; vertical-align:middle;">
                                        <?php
                                        $stmt = $mysqli->prepare("SELECT SUM(nilai) AS jumlah_nilai FROM nilai_sumatif_ph WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=?");
                                        $stmt->bind_param("sssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa']);
                                        $stmt->execute();
                                        $jumlahnilai = $stmt->get_result()->fetch_array();
                                        echo $datajumlah = $jumlahnilai['jumlah_nilai'];
                                        ?>
                                    </td>
                                    <td style="text-align:center; vertical-align:middle;">
                                        <?php echo $datarata = round(($datajumlah/$jumlahtp),2) ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div><!-- /.row -->
</section><!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="myModalAddSumatif" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Masukkan Nilai Dipisah Enter</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form>
                    <textarea name="nilai_batch" id="nilai_batch" class="form-control" style="height: 300px;"
                        placeholder="Masukkan nilai siswa, pisahkan dengan enter..."></textarea>
                    <div class="modal-footer">
                        <button type="button" id="insertValues" class="btn btn-success">Masukkan Nilai</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let activeColumnIndex = 0;

function setActiveColumn(colIndex) {
    // Set index kolom yang diklik
    activeColumnIndex = colIndex;
}

document.getElementById('insertValues').addEventListener('click', function() {
    let values = document.getElementById('nilai_batch').value.trim().split('\n');
    let studentRows = document.querySelectorAll('#student-table-body tr');

    // Loop through each row and fill the correct input field in the active column
    values.forEach((value, index) => {
        if (index < studentRows.length) {
            let inputField = studentRows[index].querySelectorAll('.input-column')[activeColumnIndex -
                1];
            inputField.querySelector('input').value = value.trim();
        }
    });

    $('#myModalAddSumatif').modal('hide'); // Close the modal after inserting values
});
</script>





<?php
    if (isset($_POST['hapus_nilai_s'])) {
        $id_tujuan = $_POST['id_tujuan'];
        $stmt = $mysqli->prepare("SELECT COUNT(*) as count FROM `nilai_sumatif_ph` WHERE id_tujuan=?");
        $stmt->bind_param("s", $id_tujuan);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_array();

        if ($result['count'] == 0) {
            echo "<script>alert('Tidak ada nilai dengan ID tujuan ini.'); window.location.href='index.php?pages=penilaian&orderID=$orderID';</script>";
        } else {
            $stmt = $mysqli->prepare("DELETE FROM `nilai_sumatif_ph` WHERE id_tujuan=?");
            $stmt->bind_param("s", $id_tujuan);
            if ($stmt->execute()) {
                echo "<script>alert('Tujuan pembelajaran berhasil dihapus.'); window.location.href='index.php?pages=penilaian&orderID=$orderID&detail=$_GET[detail]';
</script>";
} else {
echo "<script>
alert('Gagal menghapus tujuan pembelajaran.');
window.location.href = 'index.php?pages=penilaian&orderID=$orderID&detail=$_GET[detail]';
</script>";
}
}
}
?>
<?php
    if(isset($_POST['simpannilai'])){
        $nilai = $_POST['nilai'];
        $siswa = $_POST['siswa'];
        $tujuan = $_POST['tujuan'];
        
        $jumlahsiswa = count($siswa);
        $nilaiBerubah = false; // Flag untuk mengecek apakah ada nilai yang berubah
        for ($i=0; $i <$jumlahsiswa ; $i++) { 
            $stmt = $mysqli->prepare("SELECT * FROM nilai_sumatif_ph WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND id_tujuan=?");
            $stmt->bind_param("ssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $siswa[$i], $tujuan[$i]);
            $stmt->execute();
            $ceknilai = $stmt->get_result()->num_rows;
            
            if($ceknilai == 0){
                $stmt = $mysqli->prepare("INSERT INTO nilai_sumatif_ph SET tahun=?, semester=?, id_kelas=?, id_mapel=?, id_siswa=?, id_tujuan=?, nilai=?, middle=?");
                $stmt->bind_param("ssssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $siswa[$i], $tujuan[$i], $nilai[$i], $middle='1');
                $stmt->execute();
                $nilaiBerubah = true; // Ada nilai baru yang ditambahkan
            }else{
                $stmt = $mysqli->prepare("UPDATE nilai_sumatif_ph SET nilai=? WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND id_tujuan=?");
                $stmt->bind_param("sssssss", $nilai[$i], $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $siswa[$i], $tujuan[$i]);
                $stmt->execute();
            if($stmt->affected_rows > 0) {
                    $nilaiBerubah = true; // Ada nilai yang diupdate
                }
            }
        }

    if($nilaiBerubah) {
        // Mengirimkan notifikasi ke wali kelas jika ada nilai yang berubah
        $kontakWaliKelas = getKontakWaliKelas($id_kelas);
       $pesan = "Nilai Sumatif untuk mata pelajaran " . $mapelkelas['nama_mapel'] . " di kelas " . $mapelkelas['nama_kelas'] . " telah diinput oleh guru.";
        kirimPesanWali($kontakWaliKelas, $pesan);
?>
<script>
alert('Berhasil menyimpan nilai dan mengirim notifikasi.');
window.location.href =
    "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo $_GET['detail']?>";
</script>
<?php
        } else {
            ?>
<script>
alert('Tidak ada perubahan pada nilai.');
window.location.href =
    "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo $_GET['detail']?>";
</script>
<?php
        }
    }
?>

<!-- sumatif tengah semester -->
<?php }elseif($_GET['detail']=="sumatif-ts") { 
        $jumlahtpmiddleformatif = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$id_kelas' AND id_mapel='$id_mapel' AND middle_formatif='1'"));
        $jumlahtpmiddleph = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$id_kelas' AND id_mapel='$id_mapel' AND middle_ph='1'"));
        
?>

<section cljass="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header">
                    <div class="card-tools float-right">
                    </div>
                </div><!-- /.card-header -->
                <form method="POST">
                    <div class="card-body table-responsive">
                        <div class="d-flex justify-content-between align-items-center">
                            <p>
                                <button type="submit" name="simpannilai" class="btn btn-success">Simpan Nilai
                                    UTS</button>
                            <h3 class="mx-auto" style="padding-right: 140px;">Penilaian <i class="text-danger">Tengah
                                    Semester </i>
                                <?php echo $mapelkelas['nama_mapel']?> -
                                <?php echo $mapelkelas['nama_kelas']?></h3>
                            </p>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center align-middle table-warning">No</th>
                                    <th rowspan="2" class="text-center align-middle table-warning">Nama Peserta Didik
                                    </th>
                                    <th colspan="<?php echo $jumlahtpmiddleformatif ?>"
                                        class="text-center align-middle table-warning">
                                        Nilai Formatif
                                        <a href="" class="btn btn-success" data-toggle="modal"
                                            data-target="#myModal">Tambah TP F</a>
                                    </th>
                                    <th rowspan="2" class="text-center align-middle  table-info" data-toggle="tooltip"
                                        data-placement="top" title="Nilai Akhir FORMATIF">NAF
                                    </th>
                                    <th colspan="<?php echo $jumlahtpmiddleph ?>"
                                        class="text-center align-middle table-warning">
                                        Nilai Sumatif
                                        <a href="" class="btn btn-primary" data-toggle="modal"
                                            data-target="#myModalPh">Tambah TP S</a>
                                    </th>
                                    <th rowspan="2" class="text-center align-middle table-info" data-toggle="tooltip"
                                        data-placement="top" title="Nilai Akhir SUMATIF">NAS</th>
                                    <th rowspan="2" class="text-center align-middle table-info">Nilai UTS</th>
                                    <th rowspan="2" class="text-center align-middle table-warning">Jumlah <br>Nilai
                                        Sumatif</th>
                                    <th rowspan="2" class="text-center align-middle table-info">
                                        Nilai Akhir <br>Rapor UTS</th>
                                </tr>
                                <tr>
                                    <?php
                                    $nomor=1;
                                    $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND middle_formatif='1' ORDER BY urut ASC");
                                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                    $stmt->execute();
                                    $datatujuan = $stmt->get_result();
                                    while($rdatatujuan = $datatujuan->fetch_array()){
                                    ?>
                                    <th style="text-align:center; vertical-align:middle; width:5%;"
                                        class="table-warning" title="<?php echo $rdatatujuan['tujuan']?>"
                                        data-toggle="tooltip" data-placment="top">
                                        <a href="">TP.
                                            <?php echo $nomor++?></a>
                                    </th>
                                    <?php } ?>
                                    <?php
                                    $nomor=1;
                                    $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND middle_ph='1' ORDER BY urut ASC");
                                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                    $stmt->execute();
                                    $datatujuan2 = $stmt->get_result();
                                    while($rdatatujuan2 = $datatujuan2->fetch_array()){
                                    ?>
                                    <th class="text-center align-middle table-warning" style="width:5%;"
                                        data-toggle="tooltip" data-placment="top"
                                        title="<?php echo $rdatatujuan2['tujuan']?>"><a href="">TP.
                                            <?php echo $nomor++?></a></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $mysqli->prepare("SELECT siswa_kelas.*, siswa.nama_siswa, mapel_siswa.aktif 
                                    FROM siswa_kelas 
                                    JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                                    JOIN mapel_siswa ON siswa_kelas.id_siswa = mapel_siswa.id_siswa
                                    WHERE siswa_kelas.tahun=? AND siswa_kelas.semester=? AND siswa_kelas.id_kelas=? AND mapel_siswa.id_mapel=? AND mapel_siswa.aktif=1
                                    ORDER BY siswa.nama_siswa ASC");
                                $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                $stmt->execute();
                                $siswakelas = $stmt->get_result();

                                $nomor=1;
                                while($rsiswakelas = $siswakelas->fetch_array()){
                                    $stmt = $mysqli->prepare("SELECT * FROM nilai_sumatif_ts WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=?");
                                    $stmt->bind_param("sssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa']);
                                    $stmt->execute();
                                    $nilaisumatifts = $stmt->get_result()->fetch_array();
                                    $data_nnilai_sumatif_ts = $nilaisumatifts['nilai'];
                                ?>
                                <tr>
                                    <td style="text-align:center;"><?php echo $nomor++?></td>
                                    <td><?php echo $rsiswakelas['nama_siswa']?></td>
                                    <?php if($jumlahtpmiddleformatif==0){ ?>
                                    <td style="text-align:center; vertical-align:middle; width:5%;"></td>
                                    <?php }else{ ?>
                                    <?php
                                        $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND middle_formatif='1' ORDER BY urut ASC");
                                        $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                        $stmt->execute();
                                        $datatujuan = $stmt->get_result();
                                        while($rdatatujuan = $datatujuan->fetch_array()){
                                            $stmt = $mysqli->prepare("SELECT * FROM nilai_formatif WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND id_tujuan=?");
                                            $stmt->bind_param("ssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa'], $rdatatujuan['id_tujuan']);
                                            $stmt->execute();
                                            $nilaiformatif = $stmt->get_result()->fetch_array();
                                    ?>
                                    <td style="text-align:center; vertical-align:middle; width:5%;">
                                        <?php echo $nilaiformatif['nilai']?></td>
                                    <?php } ?>
                                    <?php } ?>

                                    <!-- Rata-rata nilai dari TP formatif-->
                                    <td class="text-center align-middle table-info">
                                        <?php
                                        // $stmt = $mysqli->prepare("SELECT SUM(nilai) AS jumlah_nilai_formatif_ts FROM nilai_formatif WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND middle='1'");
                                        // $stmt->bind_param("sssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa']);
                                        // $stmt->execute();
                                        // $nilaisumatifformatifTS = $stmt->get_result()->fetch_array();
                                        // $datajumlahsumatifformatifTS = $nilaisumatifformatifTS['jumlah_nilai_formatif_ts'];
                                        // echo "<b>" . $ratanilaisumaitfformatifTS = round(($datajumlahsumatifformatifTS/$jumlahtpmiddleformatif),2) . "</b>";

                                        $totalNilaiFormatif = 0;
                                        $jumlahTPValidFormatif = 0;

                                        $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND middle_formatif='1' ORDER BY urut ASC");
                                        $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                        $stmt->execute();
                                        $datatujuan = $stmt->get_result();

                                        while ($rdatatujuan = $datatujuan->fetch_array()) {
                                            $stmtNilai = $mysqli->prepare("SELECT nilai FROM nilai_formatif WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND id_tujuan=?");
                                            $stmtNilai->bind_param("ssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa'], $rdatatujuan['id_tujuan']);
                                            $stmtNilai->execute();
                                            $nilaiformatif = $stmtNilai->get_result()->fetch_array();

                                            // Cek apakah nilai valid
                                            if (!is_null($nilaiformatif['nilai'])) {
                                                $totalNilaiFormatif += $nilaiformatif['nilai'];
                                                $jumlahTPValidFormatif++;
                                            }
                                        }

                                        if ($jumlahTPValidFormatif > 0) {
                                            echo "<b>" . $ratanilaisumaitfformatifTS = round(($totalNilaiFormatif / $jumlahTPValidFormatif), 2) . "</b>";
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>

                                    <?php if($jumlahtpmiddleph==0){ ?>
                                    <td style="text-align:center; vertical-align:middle; width:5%;"></td>
                                    <?php }else{ ?>
                                    <?php
                                        $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND middle_ph='1' ORDER BY urut ASC");
                                        $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                        $stmt->execute();
                                        $datatujuan1 = $stmt->get_result();
                                        while($rdatatujuan1 = $datatujuan1->fetch_array()){
                                            $stmt = $mysqli->prepare("SELECT * FROM nilai_sumatif_ph WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND id_tujuan=?");
                                            $stmt->bind_param("ssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa'], $rdatatujuan1['id_tujuan']);
                                            $stmt->execute();
                                            $nilaisumatifph = $stmt->get_result()->fetch_array();
                                    ?>
                                    <td style="text-align:center; vertical-align:middle; width:5%;">
                                        <?php echo $nilaisumatifph['nilai']?></td>
                                    <?php } ?>
                                    <?php } ?>

                                    <!-- Rata-rata nilai dari TP sumatif PH -->
                                    <td class="text-center align-middle table-info">
                                        <?php
                                        // $stmt = $mysqli->prepare("SELECT SUM(nilai) AS jumlah_nilai_ph_ts FROM nilai_sumatif_ph WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND middle='1'");
                                        // $stmt->bind_param("sssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa']);
                                        // $stmt->execute();
                                        // $nilaisumatifphTS = $stmt->get_result()->fetch_array();
                                        // $datajumlahsumatifphTS = $nilaisumatifphTS['jumlah_nilai_ph_ts'];
                                        // echo "<b>" . $ratanilaisumaitfphTS = round(($datajumlahsumatifphTS/$jumlahtpmiddleph),2) . "</b>";
                                        
                                        $totalNilaiSumatifPH = 0;
                                        $jumlahTPValidSumatifPH = 0;

                                        $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND middle_ph='1' ORDER BY urut ASC");
                                        $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                        $stmt->execute();
                                        $datatujuan1 = $stmt->get_result();

                                        while ($rdatatujuan1 = $datatujuan1->fetch_array()) {
                                            $stmtNilai = $mysqli->prepare("SELECT nilai FROM nilai_sumatif_ph WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND id_tujuan=?");
                                            $stmtNilai->bind_param("ssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa'], $rdatatujuan1['id_tujuan']);
                                            $stmtNilai->execute();
                                            $nilaisumatifph = $stmtNilai->get_result()->fetch_array();

                                            // Cek apakah nilai valid
                                            if (!is_null($nilaisumatifph['nilai'])) {
                                                $totalNilaiSumatifPH += $nilaisumatifph['nilai'];
                                                $jumlahTPValidSumatifPH++;
                                            }
                                        }

                                        if ($jumlahTPValidSumatifPH > 0) {
                                            echo "<b>" . $ratanilaisumaitfphTS = round(($totalNilaiSumatifPH / $jumlahTPValidSumatifPH), 2) . "</b>";
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>

                                    <td style="width:10%;" class="text-center align-middle table-info">
                                        <input type="text" name="nilai[]" style="width:50px; text-align:center;"
                                            placeholder="-" class="form-control" autocomplete="off"
                                            value="<?php echo $data_nnilai_sumatif_ts ?>">
                                        <input type="hidden" name="siswa[]" style="width:100%;" autocomplete="off"
                                            value="<?php echo $rsiswakelas['id_siswa']?>">
                                    </td>

                                    <td class="text-center align-middle">

                                        <?php
                                        echo $jumlah = (float)$data_nnilai_sumatif_ts + (float)$ratanilaisumaitfformatifTS + (float)$ratanilaisumaitfphTS;
                                        ?>
                                    </td>
                                    <td class="text-center align-middle table-info">
                                        <?php echo "<b>" . $datarata = round(($jumlah / 3), 2) . "</b>" ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div><!-- /.row -->
</section><!-- /.content -->


<?php
        if(isset($_POST['simpannilai'])){
            $nilai = $_POST['nilai'];
            $siswa = $_POST['siswa'];
            
            $jumlahsiswa = count($siswa);
            $nilaiBerubah = false; // Flag untuk mengecek apakah ada nilai yang berubah
            for ($i=0; $i <$jumlahsiswa ; $i++) { 
                $stmt = $mysqli->prepare("SELECT * FROM nilai_sumatif_ts WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=?");
                $stmt->bind_param("sssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $siswa[$i]);
                $stmt->execute();
                $ceknilai = $stmt->get_result()->num_rows;
                
                if($ceknilai == 0){
                    $stmt = $mysqli->prepare("INSERT INTO nilai_sumatif_ts SET tahun=?, semester=?, id_kelas=?, id_mapel=?, id_siswa=?, nilai=?");
                    $stmt->bind_param("ssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $siswa[$i], $nilai[$i]);
                    $stmt->execute();
                    $nilaiBerubah = true; // Ada nilai baru yang ditambahkan
                }else{
                    $stmt = $mysqli->prepare("UPDATE nilai_sumatif_ts SET nilai=? WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=?");
                    $stmt->bind_param("ssssss", $nilai[$i], $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $siswa[$i]);
                    $stmt->execute();
                if($stmt->affected_rows > 0) {
                $nilaiBerubah = true; // Ada nilai yang diupdate
            }
        }
    }

    if($nilaiBerubah) {
        // Mengirimkan notifikasi ke wali kelas jika ada nilai yang berubah
        $kontakWaliKelas = getKontakWaliKelas($id_kelas);
       $pesan = "Nilai Sumatif-TS untuk mata pelajaran " . $mapelkelas['nama_mapel'] . " di kelas " . $mapelkelas['nama_kelas'] . " telah diinput oleh guru.";
        kirimPesanWali($kontakWaliKelas, $pesan);
        ?>
<script>
alert('Berhasil menyimpan nilai dan mengirim notifikasi.');
window.location.href =
    "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo $_GET['detail']?>";
</script>
<?php
        } else {
            ?>
<script>
alert('Tidak ada perubahan pada nilai.');
window.location.href =
    "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo $_GET['detail']?>";
</script>
<?php
        }
    }
?>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select TP Formatif To Middle</h4>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <table class="table table-striped table-bordered table-sm">
                        <tr>
                            <td>No</td>
                            <td>Select</td>
                            <td>Kode TP</td>
                            <td>Tujuan Pembelajaran</td>
                        </tr>
                        <?php
                            $nomor=1;
                            $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? ORDER BY urut ASC");
                            $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                            $stmt->execute();
                            $tujuan = $stmt->get_result();
                            while($rtujuan = $tujuan->fetch_array()){
                                $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_tujuan=? AND middle_formatif='1'");
                                $stmt->bind_param("sssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rtujuan['id_tujuan']);
                                $stmt->execute();
                                $jumlahmiddleformatif = $stmt->get_result()->num_rows;
                                if($jumlahmiddleformatif == 1){
                                    $cekedformatif = "checked";
                                }else{
                                    $cekedformatif = "";
                                }
                            ?>
                        <tr>
                            <td><?php echo $nomor++?></td>
                            <td><input type="checkbox" name="tujuanpilih[]" value="<?php echo $rtujuan['id_tujuan']?>"
                                    <?php echo $cekedformatif?>></td>
                            <td><?php echo "TP. ". $rtujuan['urut']?></td>
                            <td><?php echo $rtujuan['tujuan']?></td>
                        </tr>
                        <?php } ?>
                    </table>

                    <div class="modal-footer">
                        <button type="submit" name="updatetpmiddle" class="btn btn-success">Update TP Formatif</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
            if(isset($_POST['updatetpmiddle'])){
                $tujuanpilih = $_POST['tujuanpilih'];
                
                $jumlahtujuan = count($tujuanpilih);
                if($jumlahtujuan==0){
                    $stmt = $mysqli->prepare("UPDATE tujuan_pembelajaran SET middle_formatif='0' WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=?");
                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                    $stmt->execute();
                }else{
                    $stmt = $mysqli->prepare("UPDATE tujuan_pembelajaran SET middle_formatif='0' WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=?");
                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                    $stmt->execute();
                    $stmt = $mysqli->prepare("UPDATE nilai_formatif SET middle='0' WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=?");
                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                    $stmt->execute();
                    
                    for ($i=0; $i <$jumlahtujuan ; $i++) { 
                        $stmt = $mysqli->prepare("UPDATE tujuan_pembelajaran SET middle_formatif='1' WHERE id_tujuan=?");
                        $stmt->bind_param("s", $tujuanpilih[$i]);
                        $stmt->execute();
                        $stmt = $mysqli->prepare("UPDATE nilai_formatif SET middle='1' WHERE id_tujuan=?");
                        $stmt->bind_param("s", $tujuanpilih[$i]);
                        $stmt->execute();
                    }
                }
                ?><script>
alert('Berhasil');
window.location.href =
    "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo $_GET['detail']?>";
</script><?php
                
            }
            ?>


<div class="modal fade" id="myModalPh" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select TP Sumatif PH To Middle</h4>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <table class="table table-striped table-bordered table-sm">
                        <tr>
                            <td>No</td>
                            <td>Select</td>
                            <td>Kode TP</td>
                            <td>Tujuan Pembelajaran</td>
                        </tr>
                        <?php
                            $nomor=1;
                            $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? ORDER BY urut ASC");
                            $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                            $stmt->execute();
                            $tujuan = $stmt->get_result();
                            while($rtujuan = $tujuan->fetch_array()){
                                $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_tujuan=? AND middle_ph='1'");
                                $stmt->bind_param("sssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rtujuan['id_tujuan']);
                                $stmt->execute();
                                $jumlahmiddleph = $stmt->get_result()->num_rows;
                                if($jumlahmiddleph == 1){
                                    $cekedph = "checked";
                                }else{
                                    $cekedph = "";
                                }
                            ?>
                        <tr>
                            <td><?php echo $nomor++?></td>
                            <td><input type="checkbox" name="tujuanpilih[]" value="<?php echo $rtujuan['id_tujuan']?>"
                                    <?php echo $cekedph?>></td>
                            <td><?php echo "TP. ". $rtujuan['urut']?></td>
                            <td><?php echo $rtujuan['tujuan']?></td>
                        </tr>
                        <?php } ?>
                    </table>

                    <div class="modal-footer">
                        <button type="submit" name="updatetpmiddleph" class="btn btn-success">Update TP
                            Formatif</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
            if(isset($_POST['updatetpmiddleph'])){
                $tujuanpilih = $_POST['tujuanpilih'];
                
                $jumlahtujuan = count($tujuanpilih);
                if($jumlahtujuan==0){
                    $stmt = $mysqli->prepare("UPDATE tujuan_pembelajaran SET middle_ph='0' WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=?");
                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                    $stmt->execute();
                }else{
                    $stmt = $mysqli->prepare("UPDATE tujuan_pembelajaran SET middle_ph='0' WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=?");
                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                    $stmt->execute();
                    $stmt = $mysqli->prepare("UPDATE nilai_sumatif_ph SET middle='0' WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=?");
                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                    $stmt->execute();
                    for ($i=0; $i <$jumlahtujuan ; $i++) { 
                        $stmt = $mysqli->prepare("UPDATE tujuan_pembelajaran SET middle_ph='1' WHERE id_tujuan=?");
                        $stmt->bind_param("s", $tujuanpilih[$i]);
                        $stmt->execute();
                        $stmt = $mysqli->prepare("UPDATE nilai_sumatif_ph SET middle='1' WHERE id_tujuan=?");
                        $stmt->bind_param("s", $tujuanpilih[$i]);
                        $stmt->execute();
                    }
                }
                ?><script>
alert('Berhasil');
window.location.href =
    "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo $_GET['detail']?>";
</script><?php
                
            }
            ?>


<?php }elseif($_GET['detail']=="sumatif-as") { 
        $jumlahtpmiddleformatifas = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$id_kelas' AND id_mapel='$id_mapel' AND formatif_as='1'"));
        $jumlahtpmiddleph = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$id_kelas' AND id_mapel='$id_mapel' AND middle_ph='1'"));
        
        ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card ">
                <div class="card-header">
                    <div class="card-tools float-right"></div>
                </div><!-- /.card-header -->
                <form method="POST">
                    <div class="card-body table-responsive">
                        <div class="d-flex justify-content-between align-items-center">
                            <p>
                                <button type="submit" name="simpannilai" class="btn btn-success">Simpan Nilai
                                    Sumatif AS</button>
                            <h3 class="mx-auto" style="padding-right: 140px;">Penilaian <i class="text-danger">Akhir
                                    Semester </i>
                                <?php echo $mapelkelas['nama_mapel']?> -
                                <?php echo $mapelkelas['nama_kelas']?></h3>
                            </p>
                        </div>
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr style="background-color:#fae696;">
                                    <th rowspan="2" class="text-center align-middle">No</th>
                                    <th rowspan="2" class="text-center align-middle">Nama Peserta Didik</th>
                                    <!-- Kolom untuk Nilai Formatif -->
                                    <?php
                                    // Cek apakah ada TP Formatif yang tersedia
                                    $stmt = $mysqli->prepare("SELECT COUNT(*) AS total FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND formatif_as='1'");
                                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                    $stmt->execute();
                                    $result = $stmt->get_result()->fetch_assoc();
                                    $totalTPFormatif = $result['total'];

                                    // Jika tidak ada TP Formatif, tampilkan kolom kosong
                                    if ($totalTPFormatif == 0) { ?>
                                    <th class="text-center align-middle" colspan="1">Belum Ada TP Formatif</th>
                                    <?php } else { ?>
                                    <th colspan="<?php echo $totalTPFormatif ?>" class="text-center align-middle">Nilai
                                        Formatif <a href="" class="btn btn-primary" data-toggle="modal"
                                            data-placment="top" title="Tambah Nilai Formatif"
                                            data-target="#myModal">Tambah TP
                                            F</a></th>
                                    <?php } ?>
                                    <th rowspan="2" class="text-center align-middle table-dark"
                                        title="Nilai Akhir FORMATIF">NAF</th>
                                    <th colspan="<?php echo $jumlahtp; ?>" class="text-center align-middle">Nilai
                                        Sumatif</th>
                                    <th rowspan="2" class="text-center align-middle table-dark"
                                        title="Nilai Akhir SUMATIF">NAS</th>
                                    <th rowspan="2" class="text-center align-middle table-dark">Nilai Sumatif (UAS)</th>
                                    <th rowspan="2" class="text-center align-middle">Jumlah <br> Nilai Sumatif</th>
                                    <th rowspan="2" class="text-center align-middle table-dark" data-toggle="tooltip"
                                        data-placment="top" title="Nilai Akhir Rapor Semester">Nilai Akhir <br>
                                        Rapor Semester</th>
                                </tr>
                                <tr style="background-color:#fae696;">
                                    <?php
                                    // Menampilkan header untuk nilai formatif jika ada
                                    if ($totalTPFormatif > 0) {
                                        $nomor=1;
                                        $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND formatif_as='1' ORDER BY urut ASC");
                                        $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                        $stmt->execute();
                                        $datatujuan = $stmt->get_result();
                                        while($rdatatujuan = $datatujuan->fetch_array()){
                                    ?>
                                    <th class="text-center align-middle" style="width:5%;" data-toggle="tooltip"
                                        data-placment="top" title="<?php echo $rdatatujuan['tujuan']?>"><a href="">TP.
                                            <?php echo $nomor++?></a></th>
                                    <?php } } ?>

                                    <!-- Menampilkan header untuk nilai sumatif PH -->
                                    <?php
                                    $nomor=1;
                                    $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? ORDER BY urut ASC");
                                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                    $stmt->execute();
                                    $datatujuan2 = $stmt->get_result();
                                    while($rdatatujuan2 = $datatujuan2->fetch_array()){
                                    ?>
                                    <th class="text-center align-middle" style="width:5%;" data-toggle="tooltip"
                                        title="<?php echo $rdatatujuan2['tujuan']?>"><a href="">TP.
                                            <?php echo $nomor++?></a></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $mysqli->prepare("SELECT siswa_kelas.*, siswa.nama_siswa, mapel_siswa.aktif 
                                    FROM siswa_kelas 
                                    JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                                    JOIN mapel_siswa ON siswa_kelas.id_siswa = mapel_siswa.id_siswa
                                    WHERE siswa_kelas.tahun=? AND siswa_kelas.semester=? AND siswa_kelas.id_kelas=? AND mapel_siswa.id_mapel=? AND mapel_siswa.aktif=1
                                    ORDER BY siswa.nama_siswa ASC");
                                $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                $stmt->execute();
                                $siswakelas = $stmt->get_result();

                                $nomor=1;
                                while($rsiswakelas = $siswakelas->fetch_array()){
                                    $stmt = $mysqli->prepare("SELECT * FROM nilai_sumatif_as WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=?");
                                    $stmt->bind_param("sssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa']);
                                    $stmt->execute();
                                    $nilaisumatifas = $stmt->get_result()->fetch_array();
                                    $data_nnilai_sumatif_as = $nilaisumatifas['nilai'];
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $nomor++?></td>
                                    <td><?php echo $rsiswakelas['nama_siswa']?></td>

                                    <!-- Menampilkan nilai formatif untuk siswa -->
                                    <?php
                                    if ($totalTPFormatif > 0) {
                                        $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND formatif_as='1' ORDER BY urut ASC");
                                        $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                        $stmt->execute();
                                        $datatujuan = $stmt->get_result();
                                        while($rdatatujuan = $datatujuan->fetch_array()){
                                            $stmt = $mysqli->prepare("SELECT * FROM nilai_formatif WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND id_tujuan=?");
                                            $stmt->bind_param("ssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa'], $rdatatujuan['id_tujuan']);
                                            $stmt->execute();
                                            $nilaiformatif = $stmt->get_result()->fetch_array();
                                    ?>
                                    <td class="text-center align-middle" style="width:5%;">
                                        <?php echo $nilaiformatif['nilai']?></td>
                                    <?php } 
                                    } else { ?>
                                    <td class="text-center align-middle" style="width:5%;">-</td>
                                    <?php } ?>

                                    <!-- Rata-rata nilai formatif -->
                                    <td class="text-center align-middle table-dark" style="width:5%;">
                                        <?php
                                        // if ($totalTPFormatif > 0) {
                                        //     $stmt = $mysqli->prepare("SELECT SUM(nilai) AS jumlah_nilai_formatif_ts FROM nilai_formatif WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND nas='1'");
                                        //     $stmt->bind_param("sssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa']);
                                        //     $stmt->execute();
                                        //     $nilaisumatifformatifTS = $stmt->get_result()->fetch_array();
                                        //     $datajumlahsumatifformatifTS = $nilaisumatifformatifTS['jumlah_nilai_formatif_ts'];
                                        //     echo "<b>" . $rata_nilai_sumaitf_formatif_as = round(($datajumlahsumatifformatifTS/$totalTPFormatif),2) . "</b>";
                                        // } else {
                                        //     echo "-";
                                        // }
                                        if ($totalTPFormatif > 0) {
                                                // Menginisialisasi variabel untuk menghitung nilai formatif yang valid
                                                $totalNilaiFormatif = 0;
                                                $jumlahTPValidFormatif = 0;
                                                
                                                // Mendapatkan data tujuan pembelajaran formatif
                                                $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND formatif_as='1' ORDER BY urut ASC");
                                                $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                                $stmt->execute();
                                                $datatujuan = $stmt->get_result();
                                                
                                                while ($rdatatujuan = $datatujuan->fetch_array()) {
                                                    // Mendapatkan nilai formatif per tujuan pembelajaran
                                                    $stmt = $mysqli->prepare("SELECT nilai FROM nilai_formatif WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND id_tujuan=? AND nas='1'");
                                                    $stmt->bind_param("ssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa'], $rdatatujuan['id_tujuan']);
                                                    $stmt->execute();
                                                    $nilaiformatif = $stmt->get_result()->fetch_array();
                                                    
                                                    // Jika nilai tidak NULL dan tidak 0, masukkan ke perhitungan
                                                    if (!is_null($nilaiformatif['nilai'])) {
                                                        $totalNilaiFormatif += $nilaiformatif['nilai'];
                                                        $jumlahTPValidFormatif++;
                                                    }
                                                }
                                                
                                                // Hitung rata-rata nilai formatif jika ada TP yang valid
                                                if ($jumlahTPValidFormatif > 0) {
                                                    echo "<b>" . $rata_nilai_sumaitf_formatif_as = round(($totalNilaiFormatif / $jumlahTPValidFormatif), 2) . "</b>";
                                                } else {
                                                    echo "-";
                                                }
                                            } else {
                                                echo "-";
                                            }
                                        ?>
                                    </td>

                                    <!-- Menampilkan nilai sumatif PH untuk siswa -->
                                    <?php
                                    $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? ORDER BY urut ASC");
                                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                    $stmt->execute();
                                    $datatujuan1 = $stmt->get_result();
                                    while($rdatatujuan1 = $datatujuan1->fetch_array()){
                                        $stmt = $mysqli->prepare("SELECT * FROM nilai_sumatif_ph WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND id_tujuan=?");
                                        $stmt->bind_param("ssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa'], $rdatatujuan1['id_tujuan']);
                                        $stmt->execute();
                                        $nilaisumatifph = $stmt->get_result()->fetch_array();
                                    ?>
                                    <td class="text-center align-middle" style="width:5%;">
                                        <?php echo $nilaisumatifph['nilai']?></td>
                                    <?php } ?>

                                    <!-- Rata-rata nilai sumatif PH -->
                                    <td class="text-center align-middle table-dark" style="width:5%;">
                                        <?php
                                            // $stmt = $mysqli->prepare("SELECT SUM(nilai) AS jumlah_nilai_ph_ts FROM nilai_sumatif_ph WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=?");
                                            // $stmt->bind_param("sssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa']);
                                            // $stmt->execute();
                                            // $nilaisumatifphTS = $stmt->get_result()->fetch_array();
                                            // $datajumlahsumatifphTS = $nilaisumatifphTS['jumlah_nilai_ph_ts'];
                                            // echo "<b>".$ratanilaisumaitfphTS = round(($datajumlahsumatifphTS/$jumlahtp),2) ."</b>";
                                            // Menginisialisasi variabel untuk menghitung nilai sumatif PH yang valid
                                            $totalNilaiSumatifPH = 0;
                                            $jumlahTPValidSumatifPH = 0;
                                            
                                            $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? ORDER BY urut ASC");
                                            $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                                            $stmt->execute();
                                            $datatujuan1 = $stmt->get_result();
                                            
                                            while ($rdatatujuan1 = $datatujuan1->fetch_array()) {
                                                // Mendapatkan nilai sumatif PH per tujuan pembelajaran
                                                $stmt = $mysqli->prepare("SELECT nilai FROM nilai_sumatif_ph WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=? AND id_tujuan=?");
                                                $stmt->bind_param("ssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rsiswakelas['id_siswa'], $rdatatujuan1['id_tujuan']);
                                                $stmt->execute();
                                                $nilaisumatifph = $stmt->get_result()->fetch_array();
                                                
                                                // Jika nilai tidak NULL dan tidak 0, masukkan ke perhitungan
                                                if (!is_null($nilaisumatifph['nilai'])) {
                                                    $totalNilaiSumatifPH += $nilaisumatifph['nilai'];
                                                    $jumlahTPValidSumatifPH++;
                                                }
                                            }
                                            
                                            // Hitung rata-rata nilai sumatif PH jika ada TP yang valid
                                            if ($jumlahTPValidSumatifPH > 0) {
                                                echo "<b>".$ratanilaisumaitfphTS = round(($totalNilaiSumatifPH / $jumlahTPValidSumatifPH), 2) ."</b>";
                                            } else {
                                                echo "-";
                                            }
                                        ?>
                                    </td>

                                    <!-- Input nilai sumatif AS -->
                                    <td class="text-center align-middle table-dark" style="width:5%;">
                                        <input type="text" name="nilai[]" style="width:100%; text-align:center;"
                                            placeholder="-" class="form-control" autocomplete="off"
                                            value="<?php echo $data_nnilai_sumatif_as ?>">
                                        <input type="hidden" name="siswa[]" style="width:100%;" autocomplete="off"
                                            value="<?php echo $rsiswakelas['id_siswa']?>">
                                    </td>

                                    <!-- Jumlah dan rata-rata nilai sumatif -->
                                    <td class="text-center align-middle">
                                        <?php
                                            echo $jumlah = (float)$data_nnilai_sumatif_as + (float)$rata_nilai_sumaitf_formatif_as + (float)$ratanilaisumaitfphTS;
                                        ?>
                                    </td>
                                    <td class="text-center align-middle table-dark">
                                        <?php echo "<b>" . $datarata = round(($jumlah / 3), 2) . "</b>"; ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div><!-- /.row -->
</section><!-- /.content -->



<?php
        if(isset($_POST['simpannilai'])){
            $nilai = $_POST['nilai'];
            $siswa = $_POST['siswa'];
            
            $jumlahsiswa = count($siswa);
            $nilaiBerubah = false; // Flag untuk mengecek apakah ada nilai yang berubah
            for ($i=0; $i <$jumlahsiswa ; $i++) { 
                $stmt = $mysqli->prepare("SELECT * FROM nilai_sumatif_as WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=?");
                $stmt->bind_param("sssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $siswa[$i]);
                $stmt->execute();
                $ceknilai = $stmt->get_result()->num_rows;
                
                if($ceknilai == 0){
                    $stmt = $mysqli->prepare("INSERT INTO nilai_sumatif_as SET tahun=?, semester=?, id_kelas=?, id_mapel=?, id_siswa=?, nilai=?");
                    $stmt->bind_param("ssssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $siswa[$i], $nilai[$i]);
                    $stmt->execute();
                    $nilaiBerubah = true; // Ada nilai baru yang ditambahkan
                }else{
                    $stmt = $mysqli->prepare("UPDATE nilai_sumatif_as SET nilai=? WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_siswa=?");
                    $stmt->bind_param("ssssss", $nilai[$i], $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $siswa[$i]);
                    $stmt->execute();
                if($stmt->affected_rows > 0) {
                $nilaiBerubah = true; // Ada nilai yang diupdate
            }
        }
    }

    if($nilaiBerubah) {
        // Mengirimkan notifikasi ke wali kelas jika ada nilai yang berubah
        $kontakWaliKelas = getKontakWaliKelas($id_kelas);
       $pesan = "Nilai Sumatif-AS untuk mata pelajaran " . $mapelkelas['nama_mapel'] . " di kelas " . $mapelkelas['nama_kelas'] . " telah diinput oleh guru.";
        kirimPesanWali($kontakWaliKelas, $pesan);
        ?>
<script>
alert('Berhasil menyimpan nilai dan mengirim notifikasi.');
window.location.href =
    "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo $_GET['detail']?>";
</script>
<?php
        } else {
            ?>
<script>
alert('Tidak ada perubahan pada nilai.');
window.location.href =
    "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo $_GET['detail']?>";
</script>
<?php
        }
    }
?>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: green; color: white;">
                <h4 class="modal-title">Select TP Formatif To AS</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <table class="table table-striped table-bordered table-sm">
                        <tr>
                            <td>No</td>
                            <td>Select</td>
                            <td>Kode TP</td>
                            <td>Tujuan Pembelajaran</td>
                        </tr>
                        <?php
                            $nomor=1;
                            $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? ORDER BY urut ASC");
                            $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                            $stmt->execute();
                            $tujuan = $stmt->get_result();
                            while($rtujuan = $tujuan->fetch_array()){
                                $stmt = $mysqli->prepare("SELECT * FROM tujuan_pembelajaran WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=? AND id_tujuan=? AND formatif_as='1'");
                                $stmt->bind_param("sssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel, $rtujuan['id_tujuan']);
                                $stmt->execute();
                                $jumlahmiddleformatif = $stmt->get_result()->num_rows;
                                if($jumlahmiddleformatif == 1){
                                    $cekedformatif = "checked";
                                }else{
                                    $cekedformatif = "";
                                }
                            ?>
                        <tr>
                            <td><?php echo $nomor++?></td>
                            <td><input type="checkbox" name="tujuanpilih[]" value="<?php echo $rtujuan['id_tujuan']?>"
                                    <?php echo $cekedformatif?>></td>
                            <td><?php echo "TP. ". $rtujuan['urut']?></td>
                            <td><?php echo $rtujuan['tujuan']?></td>
                        </tr>
                        <?php } ?>
                    </table>

                    <div class="modal-footer">
                        <button type="submit" name="updatetpmiddle" class="btn btn-success">Update TP Formatif</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
            if(isset($_POST['updatetpmiddle'])){
                $tujuanpilih = $_POST['tujuanpilih'];
                
                $jumlahtujuan = count($tujuanpilih);
                if($jumlahtujuan==0){
                    $stmt = $mysqli->prepare("UPDATE tujuan_pembelajaran SET formatif_as='0' WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=?");
                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                    $stmt->execute();
                }else{
                    $stmt = $mysqli->prepare("UPDATE tujuan_pembelajaran SET formatif_as='0' WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=?");
                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                    $stmt->execute();
                    $stmt = $mysqli->prepare("UPDATE nilai_formatif SET nas='0' WHERE tahun=? AND semester=? AND id_kelas=? AND id_mapel=?");
                    $stmt->bind_param("ssss", $sekolah['tahun'], $sekolah['semester'], $id_kelas, $id_mapel);
                    $stmt->execute();
                    
                    for ($i=0; $i <$jumlahtujuan ; $i++) { 
                        $stmt = $mysqli->prepare("UPDATE tujuan_pembelajaran SET formatif_as='1' WHERE id_tujuan=?");
                        $stmt->bind_param("s", $tujuanpilih[$i]);
                        $stmt->execute();
                        $stmt = $mysqli->prepare("UPDATE nilai_formatif SET nas='1' WHERE id_tujuan=?");
                        $stmt->bind_param("s", $tujuanpilih[$i]);
                        $stmt->execute();
                    }
                }
                ?><script>
alert('Berhasil');
window.location.href =
    "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo $_GET['detail']?>";
</script><?php
                
            }
            ?>


<div class="modal fade" id="myModalPh" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: green; color: white;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select TP Sumatif PH To Middle</h4>
            </div>
            <div class="modal-content">
                <div class="modal-header" style="background-color: green; color: white;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Select TP Sumatif PH To Middle</h4>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <table class="table table-striped table-bordered table-sm">
                            <tr>
                                <td>No</td>
                                <td>Select</td>
                                <td>Kode TP</td>
                                <td>Tujuan Pembelajaran</td>
                            </tr>
                            <?php
                            $nomor=1;
                            $tujuan = mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$id_kelas' AND id_mapel='$id_mapel' ORDER BY urut ASC");
                            while($rtujuan = mysqli_fetch_array($tujuan)){
                                $jumlahmiddleph = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$id_kelas' AND id_mapel='$id_mapel' AND id_tujuan='$rtujuan[id_tujuan]' AND middle_ph='1'"));
                                if($jumlahmiddleph == 1){
                                    $cekedph = "checked";
                                }else{
                                    $cekedph = "";
                                }
                            ?>
                            <tr>
                                <td><?php echo $nomor++?></td>
                                <td><input type="checkbox" name="tujuanpilih[]"
                                        value="<?php echo $rtujuan['id_tujuan']?>" <?php echo $cekedph?>></td>
                                <td><?php echo "TP. ". $rtujuan['urut']?></td>
                                <td><?php echo $rtujuan['tujuan']?></td>
                            </tr>
                            <?php } ?>
                        </table>

                        <div class="modal-footer">
                            <button type="submit" name="updatetpmiddleph" class="btn btn-success">Update TP
                                Formatif</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
            if(isset($_POST['updatetpmiddleph'])){
                $tujuanpilih = $_POST['tujuanpilih'];
                
                $jumlahtujuan = count($tujuanpilih);
                if($jumlahtujuan==0){
                    mysqli_query($mysqli,"UPDATE tujuan_pembelajaran SET middle_ph='0' WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$id_kelas' AND id_mapel='$id_mapel' ");
                }else{
                    mysqli_query($mysqli,"UPDATE tujuan_pembelajaran SET middle_ph='0' WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$id_kelas' AND id_mapel='$id_mapel' ");
                    mysqli_query($mysqli,"UPDATE nilai_sumatif_ph SET middle='0' WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$id_kelas' AND id_mapel='$id_mapel' ");
                    for ($i=0; $i <$jumlahtujuan ; $i++) { 
                    	mysqli_query($mysqli,"UPDATE tujuan_pembelajaran SET middle_ph='1' WHERE id_tujuan='$tujuanpilih[$i]'");
                    	mysqli_query($mysqli,"UPDATE nilai_sumatif_ph SET middle='1' WHERE id_tujuan='$tujuanpilih[$i]'");
                    }
                }
                ?><script>
alert('Berhasil');
window.location.href =
    "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&detail=<?php echo $_GET['detail']?>";
</script><?php
                
            }
            ?>




<?php } ?>