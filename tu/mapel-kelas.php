<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
    <h1>
        Mata Pelajaran Kelas
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card border-danger">
                <div class="card-header text-white">
                    <h3 class="card-title">Daftar Pembelajaran Kelas</h3>
                    <div class="float-right">
                        <!-- Placeholder for additional tools if needed -->
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kelas</th>
                                <th>Tingkat</th>
                                <th>Kompetensi Keahlian</th>
                                <th>Fase</th>
                                <th>Wali Kelas</th>
                                <th>Total Mapel</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                                $nomor=1;
                                $kelas = mysqli_query($mysqli, "SELECT * FROM kelas ORDER BY id_tingkat, id_kelas ASC");
                                while($rkelas = mysqli_fetch_array($kelas)){
                                    $tingkat = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tingkat WHERE id_tingkat='$rkelas[id_tingkat]'"));
                                    $kompetensi = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM kompetensi_keahlian WHERE id_kompetensi_keahlian='$rkelas[id_kompetensi_keahlian]'"));
                                    $guru = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM kelas_wali 
                                    JOIN users ON kelas_wali.id_user = users.id_user
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$rkelas[id_kelas]'"));
                                ?>
                            <tr>
                                <td><?php echo $nomor++ ?></td>
                                <td><?php echo $rkelas['nama_kelas'] ?></td>
                                <td><?php echo $tingkat['tingkat'] ?></td>
                                <td><?php echo $kompetensi['kompetensi_keahlian'] ?></td>
                                <td><?php echo $tingkat['fase'] ?></td>
                                <td><?php echo $guru['nama'] ?></td>
                                <td>
                                    <?php  
                                        echo 
                                        $jumlahanggota = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM mapel_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$rkelas[id_kelas]'"));
                                        ?>
                                </td>
                                <td>
                                    <a href="?pages=mapel-kelas&filter=<?php echo 'edit' ?>&dataID=<?php echo $rkelas['id_kelas'] ?>"
                                        class="btn btn-warning">Detail</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.row -->
</section><!-- /.content -->




<?php }elseif($_GET['filter']=="edit"){ 
    	$kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE id_kelas='$_GET[dataID]'"));
    	?>
<section class="content-header">
    <h1>
        Daftar Pembelajaran Kelas
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <form method="POST">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Pembelajaran Kelas <?php echo $kelas['nama_kelas'] ?></h3>
                        <div class="card-tools float-right">
                            <a href="?pages=mapel-kelas" class="btn btn-primary">Kembali</a>
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#myModal">Tambah Data</button>
                            <?php if($sekolah['semester'] == 2){ ?>
                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                data-target="#myModalSalinData">Salin Data</button>
                            <?php } ?>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="modal fade" id="myModalSalinData" tabindex="-1" role="dialog"
                        aria-labelledby="myModalSalinDataLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="myModalSalinDataLabel">Konfirmasi Salin Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST">
                                        <?php  
                                        $kelasbaru = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[dataID]'"));
                                        $kelaslama = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE tahun='$sekolah[tahun]' AND semester='1' AND nama_kelas='$kelasbaru[nama_kelas]'"));
                                        $jumlahmapellama = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM mapel_kelas WHERE tahun='$sekolah[tahun]' AND semester='1' AND id_kelas='$kelaslama[id_kelas]'"));
                                        ?>
                                        <input type="text" name="kelasID" value="<?php echo $kelas['id_kelas'] ?>">

                                        <div class="form-group text-center">
                                            <label>
                                                <h4>Yakin akan malakukan Salin Data Semester?</h4>
                                            </label>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" name="salinmapel" class="btn btn-success">Salin
                                                Mapel</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php  
                        if (isset($_POST['salinmapel'])) {
                            $datakelaslama = $_POST['kelasID'];
                            
                            // Ambil data kelas baru untuk mendapatkan id_tingkat
                            $kelas = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM kelas WHERE id_kelas='$_GET[dataID]'"));
                            $id_tingkat = $kelas['id_tingkat'];
                            
                            // Ambil semua mapel dari kelas lama
                            $kelasdatamapelkelas = mysqli_query($mysqli, "SELECT * FROM mapel_kelas WHERE tahun='$sekolah[tahun]' AND semester='1' AND id_kelas='$datakelaslama'");
                            
                            // Ambil semua siswa di kelas baru
                            $siswa_kelas = mysqli_query($mysqli, "SELECT id_siswa FROM siswa_kelas WHERE id_kelas='$_GET[dataID]' AND tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'");
                            
                            if (mysqli_num_rows($siswa_kelas) > 0) {
                                $berhasil = true;
                                
                                // Mulai transaction
                                mysqli_begin_transaction($mysqli);
                                
                                try {
                                    // Proses setiap mapel
                                    while($rkelas = mysqli_fetch_array($kelasdatamapelkelas)){
                                        $id_mapel = $rkelas['id_mapel'];
                                        $id_user = $rkelas['id_user'];
                                        
                                        // Cek apakah mapel sudah ada di kelas baru
                                        $cekdata = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM mapel_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[dataID]' AND id_mapel='$id_mapel'")); 

                                        if ($cekdata == 0) {
                                            // Insert ke mapel_kelas
                                            $insert_mapel_kelas = mysqli_query($mysqli, "INSERT INTO mapel_kelas SET 
                                                tahun='$sekolah[tahun]', 
                                                semester='$sekolah[semester]', 
                                                id_kelas='$_GET[dataID]', 
                                                id_mapel='$id_mapel', 
                                                id_user='$id_user'");
                                            
                                            if (!$insert_mapel_kelas) {
                                                throw new Exception("Gagal insert ke mapel_kelas");
                                            }
                                            
                                            // Insert ke mapel_siswa untuk setiap siswa
                                            mysqli_data_seek($siswa_kelas, 0); // Reset pointer siswa_kelas
                                            while ($rsiswa = mysqli_fetch_array($siswa_kelas)) {
                                                $id_siswa = $rsiswa['id_siswa'];
                                                
                                                // Cek apakah data sudah ada di mapel_siswa
                                                $cek_mapel_siswa = mysqli_num_rows(mysqli_query($mysqli, 
                                                    "SELECT * FROM mapel_siswa 
                                                    WHERE tahun='$sekolah[tahun]' 
                                                    AND semester='$sekolah[semester]' 
                                                    AND id_kelas='$_GET[dataID]' 
                                                    AND id_mapel='$id_mapel' 
                                                    AND id_siswa='$id_siswa'"
                                                ));
                                                
                                                if ($cek_mapel_siswa == 0) {
                                                    $insert_mapel_siswa = mysqli_query($mysqli, 
                                                        "INSERT INTO mapel_siswa SET 
                                                        tahun='$sekolah[tahun]', 
                                                        semester='$sekolah[semester]', 
                                                        id_tingkat='$id_tingkat',
                                                        id_kelas='$_GET[dataID]', 
                                                        id_mapel='$id_mapel', 
                                                        id_siswa='$id_siswa',
                                                        aktif='1'"
                                                    );
                                                    
                                                    if (!$insert_mapel_siswa) {
                                                        throw new Exception("Gagal insert ke mapel_siswa");
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    
                                    // Commit transaction jika semua berhasil
                                    mysqli_commit($mysqli);
                        ?>
                    <script type="text/javascript">
                    alert('Berhasil menyalin data mapel ke kelas baru dan ke semua siswa');
                    window.location.href =
                        "?pages=mapel-kelas&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>";
                    </script>
                    <?php
                                } catch (Exception $e) {
                                    // Rollback jika terjadi error
                                    mysqli_rollback($mysqli);
                        ?>
                    <script type="text/javascript">
                    alert('Gagal menyalin data: <?php echo $e->getMessage() ?>');
                    window.location.href =
                        "?pages=mapel-kelas&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>";
                    </script>
                    <?php
                                }
                            } else {
                        ?>
                    <script type="text/javascript">
                    alert('Tidak ada siswa di kelas ini.');
                    window.location.href =
                        "?pages=mapel-kelas&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>";
                    </script>
                    <?php
                            }
                        }
                        ?>

                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="myModalLabel">Select Mapel Kelas</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th><input type="checkbox" id="selectAll"
                                                            onclick="toggleNewItems(this)"></th>
                                                    <th>Mata Pelajaran</th>
                                                    <th>Kelompok Mata Pelajaran</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php  
                                                $no = 1;
                                                $mapel = mysqli_query($mysqli, "SELECT * FROM mapel ORDER BY urut ASC");
                                                while ($rmapel = mysqli_fetch_array($mapel)) {
                                                    // Cek apakah mapel sudah ada di mapel_kelas untuk kelas tersebut
                                                    $cek_keanggotaan = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM mapel_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[dataID]' AND id_mapel='$rmapel[id_mapel]'"));
                                                    
                                                    $kelompok = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM kelompok_mapel WHERE id_kelompok='$rmapel[id_kelompok]'"));
                                                ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td>
                                                        <input type="checkbox" name="mapel[]" class="mapel-checkbox"
                                                            value="<?php echo $rmapel['id_mapel'] ?>" <?php 
                                                            if ($cek_keanggotaan > 0) {
                                                                echo 'checked disabled'; 
                                                            }
                                                            ?>>
                                                    </td>
                                                    <td><?php echo $rmapel['nama_mapel'] ?></td>
                                                    <td><?php echo $kelompok['kelompok'] ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>

                                        <div class="modal-footer">
                                            <button type="submit" name="tambahmapel" class="btn btn-success">Tambah
                                                Mapel</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                    function toggleNewItems(source) {
                        var checkboxes = document.getElementsByClassName('mapel-checkbox');
                        for (var i = 0; i < checkboxes.length; i++) {
                            if (!checkboxes[i].disabled) { // Hanya toggle checkbox yang tidak disabled
                                checkboxes[i].checked = source.checked;
                            }
                        }
                    }
                    </script>

                    <?php  
                    if (isset($_POST['tambahmapel'])) {
                        $mapel = isset($_POST['mapel']) ? $_POST['mapel'] : array();
                        $jumlahmapel = count($mapel);
                        
                        if ($jumlahmapel == 0) {
                            ?>
                    <script type="text/javascript">
                    alert('No Data');
                    window.location.href =
                        "?pages=mapel-kelas&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>";
                    </script>
                    <?php
                        } else {
                            // Validasi untuk memastikan mapel yang dipilih belum ada
                            $valid = true;
                            foreach($mapel as $mp) {
                                $cek = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM mapel_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[dataID]' AND id_mapel='$mp'"));
                                if($cek > 0) {
                                    $valid = false;
                                    break;
                                }
                            }

                            if(!$valid) {
                                ?>
                    <script type="text/javascript">
                    alert('Beberapa mapel yang dipilih sudah ada dalam kelas ini!');
                    window.location.href =
                        "?pages=mapel-kelas&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>";
                    </script>
                    <?php
                                exit;
                            }

                            // Ambil data kelas, termasuk id_tingkat
                            $kelas = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM kelas WHERE id_kelas='$_GET[dataID]'"));
                            $id_tingkat = $kelas['id_tingkat'];

                            // Ambil semua siswa di kelas tersebut
                            $siswa_kelas = mysqli_query($mysqli, "SELECT id_siswa FROM siswa_kelas WHERE id_kelas='$_GET[dataID]' AND tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'");

                            if (mysqli_num_rows($siswa_kelas) > 0) {
                                while ($rsiswa = mysqli_fetch_array($siswa_kelas)) {
                                    $id_siswa = $rsiswa['id_siswa'];

                                    for ($i = 0; $i < $jumlahmapel; $i++) { 
                                        $simpan_mapel_siswa = mysqli_query($mysqli, "INSERT INTO mapel_siswa (tahun, semester, id_tingkat, id_kelas, id_mapel, id_siswa, aktif) VALUES ('$sekolah[tahun]', '$sekolah[semester]', '$id_tingkat', '$_GET[dataID]', '$mapel[$i]', '$id_siswa','1')");
                                    }
                                }

                                for ($i = 0; $i < $jumlahmapel; $i++) {
                                    $simpan_mapel_kelas = mysqli_query($mysqli, "INSERT INTO mapel_kelas (tahun, semester, id_kelas, id_mapel) VALUES ('$sekolah[tahun]', '$sekolah[semester]', '$_GET[dataID]', '$mapel[$i]')");
                                }
                                ?>
                    <script type="text/javascript">
                    alert('Berhasil menambahkan <?php echo $jumlahmapel ?> ke dalam kelas dan mapel_siswa');
                    window.location.href =
                        "?pages=mapel-kelas&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>";
                    </script>
                    <?php
                            } else {
                                ?>
                    <script type="text/javascript">
                    alert('Tidak ada siswa di kelas ini.');
                    window.location.href =
                        "?pages=mapel-kelas&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>";
                    </script>
                    <?php
                            }
                        }
                    }
                    ?>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Mata Pelajaran</th>
                                                <th>Kode</th>
                                                <th>Kelompok Mata Pelajaran</th>
                                                <th>Guru Pengampuh
                                                    <button type="submit" name="updateguru"
                                                        class="btn btn-success btn-xs">Update Guru</button>
                                                </th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php  
                                            $nomor = 1;
                                            $mapel = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                                                JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                                                JOIN kelompok_mapel ON mapel.id_kelompok = kelompok_mapel.id_kelompok
                                                WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[dataID]' ORDER BY urut ASC");
                                            while ($rmapel = mysqli_fetch_array($mapel)) {
                                                $guru = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$rmapel[id_user]'"));
                                            ?>
                                            <tr>
                                                <td><?php echo $nomor++ ?></td>
                                                <td><?php echo $rmapel['nama_mapel'] ?>
                                                    <input type="hidden" name="id_mapel_kelas[]"
                                                        value="<?php echo $rmapel['id_mapel_kelas'] ?>">
                                                </td>
                                                <td><?php echo $rmapel['s_mapel'] ?></td>
                                                <td><?php echo $rmapel['kelompok'] ?></td>
                                                <td>
                                                    <select name="id_user[]" class="form-control select2"
                                                        style="width: 100%;">
                                                        <option value="">Pilih Guru Pengampuh</option>
                                                        <?php  
                                                        $dataguru = mysqli_query($mysqli,"SELECT * FROM users WHERE jabatan='3' ORDER BY id_user ASC");
                                                        while ($rdataguru = mysqli_fetch_array($dataguru)) {
                                                            $selguru = ($rmapel['id_user'] == $rdataguru['id_user']) ? "selected" : "";
                                                        ?>
                                                        <option value="<?php echo $rdataguru['id_user'] ?>"
                                                            <?php echo $selguru ?>><?php echo $rdataguru['nama'] ?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <a href="?pages=mapel-kelas&filter=<?php echo 'hapus' ?>&dataID=<?php echo $_GET['dataID'] ?>&mapelID=<?php echo $rmapel['id_mapel'] ?>&id=<?php echo $rmapel['id_mapel_kelas'] ?>"
                                                        class="btn btn-danger" onclick="return confirm('Yakin')"><i
                                                            class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.row -->
</section><!-- /.content -->


<?php  
    if (isset($_POST['updateguru'])) {
    $id_mapel_kelas = $_POST['id_mapel_kelas'];
    $id_user = $_POST['id_user'];
    
    $jumlahmapelkelas = count($id_mapel_kelas);
    for ($i=0; $i <$jumlahmapelkelas ; $i++) { 
        $simpan = mysqli_query($mysqli,"UPDATE mapel_kelas SET id_user='$id_user[$i]' WHERE id_mapel_kelas='$id_mapel_kelas[$i]'");
    }
    if ($simpan) {
        ?>

<script type="text/javascript">
Swal.fire({
    title: 'Sukses!',
    text: 'Update Guru berhasil.',
    icon: 'success',
    confirmButtonText: 'OK'
}).then((result) => {
    if (result.isConfirmed) {
        window.location.href =
            "?pages=mapel-kelas&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>";
    }
});
</script>
<?php
                                    }else {
?>
<script type="text/javascript">
Swal.fire({
    title: 'Gagal!',
    text: 'Update Guru gagal.',
    icon: 'error',
    confirmButtonText: 'OK'
});
</script>
<?php
    }
 } 
 ?>

<?php }elseif($_GET['filter']=="hapus"){ 

    // Pastikan id_tingkat diambil dari kelas
    $tingkat = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tingkat WHERE id_tingkat='$_GET[dataID]'"));
    $id_tingkat = $tingkat['id_tingkat']; // Mendapatkan id_tingkat dari kelas

    // Query untuk menghapus dari tabel mapel_kelas
    $hapus_mapel_k = mysqli_query($mysqli, "DELETE FROM mapel_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[dataID]' AND id_mapel='$_GET[mapelID]' AND id_mapel_kelas='$_GET[id]'");

    // Query untuk menghapus dari tabel mapel_siswa (koneksi harus $mysqli, bukan $mysql)
    $hapus_mapel_s = mysqli_query($mysqli, "DELETE FROM mapel_siswa WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[dataID]' AND id_mapel='$_GET[mapelID]'");

    // Periksa apakah kedua query berhasil
    if ($hapus_mapel_k && $hapus_mapel_s) {
?>
<script type="text/javascript">
alert('Berhasil');
window.location.href = "?pages=mapel-kelas&filter=<?php echo 'edit'?>&dataID=<?php echo $_GET['dataID'] ?>";
</script>
<?php
    } else {
        // Jika ada kegagalan, tampilkan error untuk debugging
        $error_message_k = mysqli_error($mysqli); // Error dari query pertama
        $error_message_s = mysqli_error($mysqli); // Error dari query kedua
?>
<script type="text/javascript">
alert('Gagal menghapus: <?php echo $error_message_k; ?> <?php echo $error_message_s; ?>');
</script>
<?php
    }
?>

<?php } ?>

<script>
document.getElementById('selectAll').onclick = function() {
    var checkboxes = document.getElementsByName('mapel[]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
};
</script>