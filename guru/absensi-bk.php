
<section class="content-header">
    <div class="container-fluid rounded shadow-sm">
        <h3 class="font-weight-bold text-center mb-4">
            <span class="text-info"><?php echo $hari ?></span>, Tanggal:
            <span
                class="text-info"><?php echo isset($_GET['tanggal']) ? tgl_indonesia($_GET['tanggal']) : tgl_indonesia(date('Y-m-d'))?></span>
        </h3>
    </div>
</section>


<form method="POST">
    <section class="content-header">
        <div class="container bg-white p-4 mt-3 rounded shadow-sm">
            <div class="row mb-4">
                <!-- Kelas -->
                <div class="col-md-3">
                    <label for="id_kelas" class="font-weight-bold">Kelas</label>
                </div>
                <div class="col-md-7">
                    <select name="id_kelas" id="id_kelas" class="form-control custom-select" required>
                        <option value="">Pilih Kelas</option>
                        <?php
                          $orderID = isset($_GET['orderID']) ? mysqli_real_escape_string($mysqli, $_GET['orderID']) : '';
                          $kelas = mysqli_query($mysqli,"SELECT * FROM kelas ORDER BY id_kelas ASC");
                          while($rkelas = mysqli_fetch_array($kelas)){
                              $sele = ($orderID == $rkelas['id_kelas']) ? "selected" : "";
                        ?>
                        <option value="<?php echo $rkelas['id_kelas']?>" <?php echo $sele ?>>
                            <?php echo $rkelas['nama_kelas']?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Tanggal -->
                <div class="col-md-3">
                    <!-- <label for="tanggal" class="font-weight-bold">Tanggal</label> -->
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="hidden" name="tanggal" id="tanggal" class="form-control datepicker"
                            value="<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d') ?>" required>
                        <div class="input-group-append">
                            <!-- <span class="input-group-text bg-info text-white"><i class="fas fa-calendar-alt"></i></span> -->
                        </div>
                    </div>
                </div> 
            </div>

            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <button type="submit" name="cari" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-search"></i> Tampil Data
                    </button>
                </div>
            </div>
        </div>
    </section>
</form>


<!-- Inisialisasi Datepicker -->
<script>
$(document).ready(function() {
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd', // Format tanggal
        autoclose: true, // Menutup otomatis setelah tanggal dipilih
        todayHighlight: true // Highlight tanggal hari ini
    });
});
</script>





<?php
        if(isset($_POST['cari'])){
            $id_kelas = mysqli_real_escape_string($mysqli, $_POST['id_kelas']);
            $tanggal = mysqli_real_escape_string($mysqli, $_POST['tanggal']);
            ?>
<script>
window.location.href =
    "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $id_kelas?>&tanggal=<?php echo $tanggal?>";
</script>
<?php
        }
?>

<?php 
if(empty($_GET['filter']) && !empty($orderID)){ 
    $kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE id_kelas='$orderID'"));
    
    // Mengambil tanggal dari URL jika ada, jika tidak gunakan tanggal hari ini
    $tanggal_presensi = isset($_GET['tanggal']) ? mysqli_real_escape_string($mysqli, $_GET['tanggal']) : date('Y-m-d');

    // Ambil nilai bulan dari tanggal presensi
    $bulan_presensi = date('m', strtotime($tanggal_presensi)); // Ekstraksi bulan dengan PHP

    // Cek apakah absensi sudah ada untuk kelas pada tanggal ini
    $cek_absen = mysqli_query($mysqli, "SELECT * FROM presensi WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$orderID' AND tanggal='$tanggal_presensi'");
    if(mysqli_num_rows($cek_absen) > 0){
        // Jika absensi sudah ada, tampilkan notifikasi menggunakan SweetAlert
        ?><script>
Swal.fire({
    icon: 'info',
    title: 'Absensi Sudah Dilakukan',
    text: 'Absensi untuk kelas <?php echo $kelas['nama_kelas'] ?> pada tanggal <?php echo tgl_indonesia($tanggal_presensi) ?> sudah dilakukan.',
    confirmButtonText: 'OK'
});
</script><?php
    }
?>

<br>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-danger">
                    <h3 class="card-title text-white ">Daftar Siswa Kelas <?php echo $kelas['nama_kelas']?></h3>
                </div>
                <form method="POST">
                    <div class="card-body">
                        <p>
                            <button type="submit" name="simpan" class="btn btn-primary btn-sm">Simpan Absen</button>
                        </p>
                        <table class="table table-striped table-bordered table-hover" data-page-length="50">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Nama Peserta Didik</th>
                                    <?php
                                    // Ambil semua kolom absen yang lebih dari 1
                                    $absen = mysqli_query($mysqli, "SELECT * FROM absen WHERE id_absen > 1 ORDER BY id_absen ASC");
                                    while($rabsen = mysqli_fetch_array($absen)) {
                                    ?>
                                    <th style="text-align:center;"><?php echo $rabsen['absen']; ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                                    $nomor = 1;
                                    $kelas = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
                                    JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$orderID' ORDER BY nama_siswa ASC");
                                    
                                    $presensi_today_query = mysqli_query($mysqli, "SELECT p.*, COUNT(p.id_siswa) as presensi_count 
                                    FROM presensi p 
                                    WHERE p.tahun='$sekolah[tahun]' AND p.semester='$sekolah[semester]' AND p.id_kelas='$orderID'
                                    GROUP BY p.id_siswa, p.id_absen");
                                    
                                    $presensi_today = [];
                                    while($rpresensi = mysqli_fetch_array($presensi_today_query)){
                                        $presensi_today[$rpresensi['id_siswa']][$rpresensi['id_absen']] = [
                                            'jumlah' => $rpresensi['jumlah'],
                                            'count' => $rpresensi['presensi_count']
                                        ];
                                    }

                                    while($rkelas = mysqli_fetch_array($kelas)){
                                ?>
                                <tr>
                                    <td style="text-align:center;"><?php echo $nomor++ ?></td>
                                    <td><?php echo $rkelas['nama_siswa'] ?></td>

                                    <?php
                                    $absen = mysqli_query($mysqli, "SELECT * FROM absen WHERE id_absen > 1 ORDER BY id_absen ASC");
                                    while($rabsen = mysqli_fetch_array($absen)) {
                                        $presensi_data = isset($presensi_today[$rkelas['id_siswa']][$rabsen['id_absen']]) ? $presensi_today[$rkelas['id_siswa']][$rabsen['id_absen']] : ['jumlah' => 0, 'count' => 0];
                                        $display_value = $presensi_data['jumlah'] == 0 ? $presensi_data['count'] : $presensi_data['jumlah'];
                                    ?>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="jum[<?php echo $rkelas['id_siswa']?>][<?php echo $rabsen['id_absen']?>]"
                                            value="<?php echo $display_value; ?>">
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
        if(isset($_POST['simpan'])){
            $siswa = $_POST['jum'];  // Mengambil data presensi per siswa dan absen
            
            // Loop melalui setiap siswa dan absen untuk menyimpan presensi
            foreach ($siswa as $id_siswa => $absensi) {
                foreach ($absensi as $id_absen => $jumlahInput) {
                    // Hanya masukkan presensi jika jumlahnya bukan kosong dan lebih dari 0
                    if (!empty($jumlahInput) && intval($jumlahInput) > 0) {
                        $id_siswa = mysqli_real_escape_string($mysqli, $id_siswa);
                        $id_absen = mysqli_real_escape_string($mysqli, $id_absen);
                        $jumlahInput = mysqli_real_escape_string($mysqli, $jumlahInput);

                        // Mengecek apakah sudah ada data presensi untuk siswa dan absen yang spesifik
                        $cekabsen = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM presensi WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_absen='$id_absen' AND id_kelas='$orderID' AND id_siswa='$id_siswa'
                        -- AND tanggal='$tanggal_presensi'
                        "));

                        // Jika tidak ada, maka data baru akan dimasukkan
                        if ($cekabsen == 0) {
                            mysqli_query($mysqli, "INSERT INTO presensi SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$orderID', id_siswa='$id_siswa', id_absen='$id_absen', jumlah='$jumlahInput',
                            -- tanggal='$tanggal_presensi',
                            -- bulan='$bulan_presensi'
                            ");
                        } else {
                            // Jika sudah ada, maka data akan diperbarui
                            mysqli_query($mysqli, "UPDATE presensi SET jumlah='$jumlahInput', bulan='$bulan_presensi' WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$id_siswa' AND id_absen='$id_absen' AND id_kelas='$orderID'
                            -- AND tanggal='$tanggal_presensi'
                            ");
                        }
                    }
                }
            }
            
            ?><script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: 'Absensi berhasil disimpan.',
    confirmButtonText: 'OK'
});
window.location.href =
    "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $orderID ?>&tanggal=<?php echo $tanggal_presensi ?>";
</script><?php
        }
}
?>