<?php  

$pembagian = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM pembagian_raport WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));
?>
<section class="content-header">
    <h1>
        Pengaturan
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-header text-white">
                    <h3 class="card-title">Pengaturan</h3>
                </div>
                <form method="POST">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tanggal Pembagian Rapor</label>
                            <input type="date" name="tanggal_rapor" class="form-control" id="mdate"
                                value="<?php echo $pembagian['tanggal_rapor'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pembagian Middle</label>
                            <input type="date" name="tanggal_mid" class="form-control"
                                value="<?php echo $pembagian['tanggal_mid'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Lokasi TTD Rapor</label>
                            <select name="lokasi" class="form-control" required>
                                <option value="" required="">Pilih Lokasi</option>
                                <option value="1" <?php if($sekolah['lokasi']==1){ echo "selected";} ?>>Kabupaten
                                </option>
                                <option value="2" <?php if($sekolah['lokasi']==2){ echo "selected";} ?>>Kecamatan
                                </option>
                                <option value="3" <?php if($sekolah['lokasi']==3){ echo "selected";} ?>>Desa / Kelurahan
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" name="simpanpengaturan" class="btn btn-primary btn-sm">Simpan
                            Data</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-header text-white">
                    <h3 class="card-title">Tahun Pelajaran</h3>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary btn-sm mb-3" data-toggle="modal"
                        data-target="#myModal">Tambah</button>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun Pelajaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nomor=1;
                            $tahun = mysqli_query($mysqli,"SELECT * FROM tahun_pelajaran ORDER BY id_tahun_pelajaran ASC");
                            while($rtahun = mysqli_fetch_array($tahun)){
                            ?>
                            <tr>
                                <td><?php echo $nomor++?></td>
                                <td><?php echo $rtahun['tahun_pelajaran']?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#myModalEdit<?php echo $rtahun['id_tahun_pelajaran']?>"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#myModalHapus<?php echo $rtahun['id_tahun_pelajaran']?>"><i
                                            class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="myModalLabel">Form Tambah Tahun Pelajaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tahun Pelajaran</label>
                            <input type="text" name="tahun_pelajaran" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updatetahun" class="btn btn-success">Update Tahun Pelajaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    $tahun = mysqli_query($mysqli,"SELECT * FROM tahun_pelajaran ORDER BY id_tahun_pelajaran ASC");
    while($rtahun = mysqli_fetch_array($tahun)){
    ?>
    <!-- Edit Modal -->
    <div class="modal fade" id="myModalEdit<?php echo $rtahun['id_tahun_pelajaran']?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalEditLabel<?php echo $rtahun['id_tahun_pelajaran']?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="myModalEditLabel<?php echo $rtahun['id_tahun_pelajaran']?>">Edit Tahun
                        Pelajaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_tahun_pelajaran"
                            value="<?php echo $rtahun['id_tahun_pelajaran']?>">
                        <div class="form-group">
                            <label>Tahun Pelajaran</label>
                            <input type="text" name="tahun_pelajaran" class="form-control"
                                value="<?php echo $rtahun['tahun_pelajaran']?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updatetahunedit" class="btn btn-warning">Update Tahun
                            Pelajaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="myModalHapus<?php echo $rtahun['id_tahun_pelajaran']?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalHapusLabel<?php echo $rtahun['id_tahun_pelajaran']?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="myModalHapusLabel<?php echo $rtahun['id_tahun_pelajaran']?>">Konfirmasi
                        Hapus Tahun Pelajaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_tahun_pelajaran"
                            value="<?php echo $rtahun['id_tahun_pelajaran']?>">
                        <p class="text-center">Yakin akan menghapus Tahun Pelajaran ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updatetahunhapus" class="btn btn-danger">Hapus Tahun
                            Pelajaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php } ?>
</section>


<?php  
    if (isset($_POST['simpanpengaturan'])) {
        $tanggal_rapor = $_POST['tanggal_rapor'];
        $tanggal_mid = $_POST['tanggal_mid'];
        $lokasi = $_POST['lokasi'];

        mysqli_query($mysqli,"UPDATE sekolah SET lokasi='$lokasi' WHERE id_sekolah='$sekolah[id_sekolah]' ");

        $cekpembagian = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM pembagian_raport WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));
        if ($cekpembagian==0) {
            mysqli_query($mysqli,"INSERT INTO pembagian_raport SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', tanggal_mid='$tanggal_mid', tanggal_rapor='$tanggal_rapor'");
        }else{
        mysqli_query($mysqli,"UPDATE pembagian_raport SET tanggal_mid='$tanggal_mid', tanggal_rapor='$tanggal_rapor' WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' ");
        }

?>
<script type="text/javascript">
Swal.fire({
    title: "Berhasil!",
    text: "Data berhasil disimpan.",
    icon: "success",
}).then(function() {
    window.location.href = "?pages=pengaturan";
});
</script>
<?php

    }
?>

<?php
    if(isset($_POST['updatetahun'])){
        $tahun_pelajaran = $_POST['tahun_pelajaran'];
        
        $cek = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM tahun_pelajaran WHERE tahun_pelajaran='$tahun_pelajaran'"));
        if($cek == 0){
            $simpan = mysqli_query($mysqli,"INSERT INTO tahun_pelajaran SET tahun_pelajaran='$tahun_pelajaran'");
            if($simpan){
?>
<script>
Swal.fire({
    title: "Berhasil!",
    text: "Data berhasil disimpan.",
    icon: "success",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script>
<?php
    }
}else{
    ?>
<script>
Swal.fire({
    title: "Gagal!",
    text: "Tahun Sudah Ada!",
    icon: "error",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script><?php
                            }
                        }
                        ?>

<?php  
    if (isset($_POST['updatetahunedit'])) {
        $id_tahun_pelajaran = $_POST['id_tahun_pelajaran'];
        $tahun_pelajaran = $_POST['tahun_pelajaran'];

        
        $simpan = mysqli_query($mysqli,"UPDATE tahun_pelajaran SET tahun_pelajaran='$tahun_pelajaran' WHERE id_tahun_pelajaran='$id_tahun_pelajaran'");
        if($simpan){
?>
<script>
Swal.fire({
    title: "Berhasil!",
    text: "Data berhasil disimpan.",
    icon: "success",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script>
<?php
        }

    }
?>

<?php  
    if (isset($_POST['updatetahunhapus'])) {
        $id_tahun_pelajaran = $_POST['id_tahun_pelajaran'];

        
        $simpan = mysqli_query($mysqli,"DELETE FROM tahun_pelajaran WHERE id_tahun_pelajaran='$id_tahun_pelajaran'");
        if($simpan){
?>
<script>
Swal.fire({
    title: "Berhasil!",
    text: "Data tahun berhasil dihapus.",
    icon: "success",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script>
<?php
        }
                
    }
?>

    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-header text-white">
                <h3 class="card-title">Backup Database</h3>
            </div>
            <div class="card-body">
                <p>Gunakan fitur ini untuk membuat cadangan database sistem.</p>
                <form method="POST">
                    <div class="form-group">
                        <label>Catatan Backup (Opsional)</label>
                        <input type="text" name="backup_note" class="form-control" placeholder="Contoh: Sebelum update sistem">
                    </div>
                    <button type="submit" name="backup_database" class="btn btn-success btn-block">Buat Backup</button>
                </form>
                
                <!-- Daftar File Backup -->
                <hr>
                <h5>File Backup Tersedia:</h5>
                <?php
                // Tampilkan daftar file backup
                $backup_dir = "../backup/";
                if (is_dir($backup_dir)) {
                    $backup_files = array_diff(scandir($backup_dir), array('..', '.'));
                    if (count($backup_files) > 0) {
                        echo '<div class="backup-list" style="max-height: 200px; overflow-y: auto;">';
                        foreach ($backup_files as $file) {
                            if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                                $file_path = $backup_dir . $file;
                                $file_date = date("d/m/Y H:i:s", filemtime($file_path));
                                $file_size = number_format(filesize($file_path) / (1024 * 1024), 2); // Ukuran dalam MB
                                
                                echo '<div class="backup-item mb-2 p-2 border rounded" style="background-color: #f8f9fa;">';
                                echo '<div class="d-flex justify-content-between align-items-center">';
                                echo '<div>';
                                echo '<strong>' . htmlspecialchars($file) . '</strong><br>';
                                echo '<small class="text-muted">Tanggal: ' . $file_date . ' | Ukuran: ' . $file_size . ' MB</small>';
                                echo '</div>';
                                echo '<a href="' . $file_path . '" class="btn btn-primary btn-sm" download>Download</a>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        echo '</div>';
                    } else {
                        echo '<p class="text-muted">Belum ada file backup.</p>';
                    }
                } else {
                    echo '<p class="text-muted">Folder backup tidak ditemukan.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
// Fungsi untuk membuat backup database
if (isset($_POST['backup_database'])) {
    $backup_note = isset($_POST['backup_note']) ? $_POST['backup_note'] : '';
    
    // Set timezone ke Asia/Jakarta (WIB)
    date_default_timezone_set('Asia/Jakarta');
    
    // Buat nama file backup berdasarkan tanggal dan waktu
    $date = date('Y-m-d_H-i-s');
    $filename = 'backup_rapor_' . $date . '.sql';
    $backup_dir = '../backup/';
    
    // Buat direktori backup jika belum ada
    if (!is_dir($backup_dir)) {
        mkdir($backup_dir, 0755, true);
    }
    
    $filepath = $backup_dir . $filename;
    
    // Ambil konfigurasi koneksi dari file koneksi.php
    $koneksi_content = file_get_contents('../config/koneksi.php');
    
    // Ekstrak detail koneksi dari file koneksi.php
    preg_match("/\\\$host\s*=\s*'([^']+)'/", $koneksi_content, $host_match);
    preg_match("/\\\$user\s*=\s*'([^']+)'/", $koneksi_content, $user_match);
    preg_match("/\\\$pass\s*=\s*'([^']+)'/", $koneksi_content, $pass_match);
    preg_match("/\\\$db\s*=\s*'([^']+)'/", $koneksi_content, $db_match);
    
    $host = isset($host_match[1]) ? $host_match[1] : 'localhost';
    $username = isset($user_match[1]) ? $user_match[1] : 'root';
    $password = isset($pass_match[1]) ? $pass_match[1] : '';
    $database = isset($db_match[1]) ? $db_match[1] : 'abdinega_db_raporkm';
    
    // Fungsi untuk membuat backup SQL
    function backup_tables($host, $username, $password, $database, $tables = '*') {
        $return = '';
        
        // Koneksi ke database
        $link = new mysqli($host, $username, $password, $database);
        
        // Periksa koneksi
        if ($link->connect_error) {
            die('Koneksi gagal: ' . $link->connect_error);
        }
        
        $link->set_charset('utf8');
        
        // Membuat komentar header
        $return .= "-- E-Rapor Backup Database\n";
        $return .= "-- Tanggal: " . date('Y-m-d H:i:s') . "\n";
        $return .= "-- Catatan: " . (isset($GLOBALS['backup_note']) ? addslashes($GLOBALS['backup_note']) : 'Tidak ada catatan') . "\n";
        $return .= "-- --------------------------------------------------------\n\n";
        
        if ($tables == '*') {
            $tables = array();
            $result = mysqli_query($link, 'SHOW TABLES');
            while ($row = mysqli_fetch_row($result)) {
                $tables[] = $row[0];
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }
        
        foreach ($tables as $table) {
            // Dapatkan struktur tabel
            $result = mysqli_query($link, 'SELECT * FROM `' . $table . '`');
            $num_fields = mysqli_num_fields($result);
            
            $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE `' . $table . '`'));
            $return .= "\n\n-- --------------------------------------------------------\n";
            $return .= "-- Struktur tabel untuk `" . $table . "`\n";
            $return .= "-- --------------------------------------------------------\n\n";
            $return .= $row2[1] . ";\n\n";
            
            $return .= "-- --------------------------------------------------------\n";
            $return .= "-- Data untuk tabel `" . $table . "`\n";
            $return .= "-- --------------------------------------------------------\n\n";
            
            // Ambil data dari tabel
            while ($row = mysqli_fetch_row($result)) {
                $return .= 'INSERT INTO `' . $table . '` VALUES(';
                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_replace("\n", "\\n", $row[$j]);
                    if (isset($row[$j]) && $row[$j] !== null) {
                        $return .= '"' . $row[$j] . '"';
                    } else {
                        $return .= 'NULL';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return .= ',';
                    }
                }
                $return .= ");\n";
            }
            $return .= "\n";
        }
        
        mysqli_close($link);
        return $return;
    }
    
    // Buat backup
    $backup_content = backup_tables($host, $username, $password, $database);
    
    // Tambahkan catatan ke dalam file backup jika ada
    if (!empty($backup_note)) {
        $backup_content = "-- Catatan: " . addslashes($backup_note) . "\n\n" . $backup_content;
    }
    
    // Simpan file backup
    if (file_put_contents($filepath, $backup_content)) {
        ?>
        <script>
        Swal.fire({
            title: "Berhasil!",
            text: "Database telah dibackup ke file <?php echo $filename; ?>",
            icon: "success",
        }).then(function() {
            window.location.href = "?pages=<?php echo $_GET['pages']?>";
        });
        </script>
        <?php
    } else {
        ?>
        <script>
        Swal.fire({
            title: "Gagal!",
            text: "Gagal membuat file backup.",
            icon: "error",
        }).then(function() {
            window.location.href = "?pages=<?php echo $_GET['pages']?>";
        });
        </script>
        <?php
    }
}
?>