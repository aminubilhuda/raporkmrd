<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
    <h1>
        Mata Pelajaran Pilihan
    </h1>
</section>
<section class="content-header">
    <form method="POST">
        <div class="form-group">
            <label for="kelas-select" class="sr-only">Pilih Kelas</label>
            <div class="input-group" style="max-width: 300px;">
                <select name="id_kelas" id="kelas-select" class="form-control" required>
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
        $id_kelas = $_POST['id_kelas'];
    ?>
    <script>
    window.location.href = "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $id_kelas ?>";
    </script>
    <?php
    }
    ?>
</section>

<?php if(!empty($_GET['orderID']) and empty($_GET['filter'])){ 
        $kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE id_kelas='$_GET[orderID]'"));
        
        // Ambil daftar mata pelajaran dari tabel mapel_kelas berdasarkan kelas
        $mapel_kelas = mysqli_query($mysqli,"SELECT mapel.id_mapel, mapel.nama_mapel, mapel.s_mapel
                                              FROM mapel_kelas 
                                              JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel 
                                              WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND mapel_kelas.id_kelas = '$_GET[orderID]'");

        $siswakelas = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
        JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
        JOIN agama ON siswa.agama = agama.id_agama
        WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND aktif='1' ORDER BY nama_siswa ASC");
        
        
?>
<!-- Tambahkan form di sini untuk update -->
<form method="POST" action="">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-danger">
                    <div class="card-header text-white">
                        <h3 class="card-title">Mapel Pilihan Siswa</h3>
                        <button type="submit" name="update_mapel_siswa" class="btn btn-primary">Update</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Agama</th>
                                        <?php
                                            // Loop untuk menampilkan header mata pelajaran
                                            $mapel_array = []; // Simpan data mapel di array untuk digunakan di tbody
                                            while($rmapel = mysqli_fetch_array($mapel_kelas)){
                                                echo "<th title='" . $rmapel['nama_mapel'] . "' data-toggle='tooltip' data-placment='top'>" . $rmapel['s_mapel'] . " <br><input type='checkbox' class='select-all'></th>";
                                                $mapel_array[] = $rmapel; // Simpan mapel di array
                                            }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while($rsiswakelas = mysqli_fetch_array($siswakelas)){
                                    ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $rsiswakelas['nama_siswa'] ?></td>
                                        <td><?php echo $rsiswakelas['agama'] ?></td>
                                        <?php
                                        // Loop untuk menampilkan checkbox untuk setiap mapel di setiap siswa
                                        foreach ($mapel_array as $mapel) {
                                            // Cek apakah siswa sudah terdaftar dalam mapel ini dengan aktif = 1
                                            $cek_mapel_siswa = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM mapel_siswa 
                                                WHERE id_siswa = '{$rsiswakelas['id_siswa']}' AND id_mapel = '{$mapel['id_mapel']}' 
                                                AND tahun = '$sekolah[tahun]' AND semester = '$sekolah[semester]' AND aktif = '1'"));

                                            // Jika terdaftar, tandai checkbox sebagai checked
                                            $checked = $cek_mapel_siswa > 0 ? "checked" : "";
                                        ?>
                                        <td>
                                            <input type="checkbox"
                                                name="mapel[<?php echo $rsiswakelas['id_siswa'] ?>][<?php echo $mapel['id_mapel'] ?>]"
                                                <?php echo $checked; ?>>
                                        </td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

<!-- Tambahkan JavaScript untuk fungsi Select All -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pilih semua checkbox dengan class 'select-all'
    document.querySelectorAll('.select-all').forEach(function(selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            // Dapatkan index kolom checkbox saat ini
            let columnIndex = Array.from(selectAllCheckbox.parentElement.parentElement.children)
                .indexOf(selectAllCheckbox.parentElement);

            // Pilih semua checkbox di kolom yang sama
            document.querySelectorAll('.table tbody tr').forEach(function(row) {
                let checkBox = row.children[columnIndex].querySelector(
                    'input[type="checkbox"]');
                checkBox.checked = selectAllCheckbox.checked;
            });
        });
    });
});
</script>

<?php
// Proses update mapel siswa
if (isset($_POST['update_mapel_siswa'])) {
    // Ambil data mapel siswa dari form, periksa jika ada data atau tidak
    $mapel_data = isset($_POST['mapel']) ? $_POST['mapel'] : [];

    // Loop melalui setiap siswa dalam kelas
    $siswakelas = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
    JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
    JOIN kelas ON siswa_kelas.id_kelas = kelas.id_kelas
    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND siswa_kelas.id_kelas='$_GET[orderID]' AND aktif='1' ORDER BY nama_siswa ASC");
    
    while ($rsiswakelas = mysqli_fetch_array($siswakelas)) {
        $id_siswa = $rsiswakelas['id_siswa'];
        $id_tingkat = $rsiswakelas['id_tingkat'];

        // Loop setiap mapel yang mungkin
        $mapel_kelas = mysqli_query($mysqli,"SELECT mapel.id_mapel FROM mapel_kelas 
                                              JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel 
                                              WHERE mapel_kelas.id_kelas = '$_GET[orderID]'");

        while ($rmapel = mysqli_fetch_array($mapel_kelas)) {
            $id_mapel = $rmapel['id_mapel'];

            // Cek apakah mapel dicentang dalam form
            $is_checked = isset($mapel_data[$id_siswa][$id_mapel]);

            if ($is_checked) {
                // Jika dicentang, periksa apakah siswa sudah terdaftar di mapel ini
                $cek = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM mapel_siswa 
                    WHERE id_siswa='$id_siswa' AND id_mapel='$id_mapel' AND tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));
                
                if ($cek == 0) {
                    // Jika belum ada di database, tambahkan
                    mysqli_query($mysqli, "INSERT INTO mapel_siswa (id_siswa, id_mapel, tahun, semester, id_tingkat, id_kelas, aktif) 
                        VALUES ('$id_siswa', '$id_mapel', '$sekolah[tahun]', '$sekolah[semester]', '$id_tingkat', '$_GET[orderID]', '1')");
                } else {
                    // Jika sudah ada, update status aktif menjadi 1
                    mysqli_query($mysqli, "UPDATE mapel_siswa 
                        SET aktif = '1', id_kelas = '$_GET[orderID]'
                        WHERE id_siswa='$id_siswa' AND id_mapel='$id_mapel' AND tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'");
                }
            } else {
                // Jika tidak dicentang, nonaktifkan mapel siswa ini
                $cek = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM mapel_siswa 
                    WHERE id_siswa='$id_siswa' AND id_mapel='$id_mapel' AND tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));
                
                if ($cek > 0) {
                    // Update status aktif menjadi 0 untuk menonaktifkan
                    mysqli_query($mysqli, "UPDATE mapel_siswa 
                        SET aktif = '0' 
                        WHERE id_siswa='$id_siswa' AND id_mapel='$id_mapel' AND tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'");
                }
            }
        }
    }

    // Setelah selesai, beri notifikasi dan redirect ulang
    echo "<script>alert('Data mapel siswa berhasil diupdate.'); window.location.href='?pages=$_GET[pages]&orderID=$_GET[orderID]';</script>";
}
?>



<?php } ?>

<?php } ?>