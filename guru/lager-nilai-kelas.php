<!-- <section class="content-header">
    <h1>
        Lager Nilai Kelas <?php echo $datakelas['nama_kelas']?>
        <small><i>E-Rapor</i></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Lager Nilai Kelas</li>
    </ol>
</section> -->


<!-- <section class="content-header">
    <a href="?pages=<?php echo $_GET['pages']?>" class="btn btn-primary btn-sm">Lager Nilai</a>
    <a href="?pages=<?php echo $_GET['pages']?>&filter=<?php echo 'dokumen-rapor'?>"
        class="btn btn-primary btn-sm">Dokumen Rapor</a>
</section> -->


<?php if(empty($_GET['filter'])){ 
        $jumlahmapelkelas = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM mapel_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]'"));
        $jumlahsiswakelas = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]'"));
        
        mysqli_query($mysqli,"DELETE FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]'");
        mysqli_query($mysqli,"DELETE FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]'");
        
        $siswakelas = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
        JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
        WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND aktif='1' ORDER BY nama_siswa ASC");
        while($rsiswakelas = mysqli_fetch_array($siswakelas)){
            $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
            JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
            WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' ORDER BY urut ASC");
            while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                $formatif = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai) AS rerata_formatif FROM nilai_formatif WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND id_mapel='$rmapelkelas[id_mapel]' AND id_siswa='$rsiswakelas[id_siswa]' AND nas='1'"));
                $nilai_formatif = round(($formatif['rerata_formatif']),2);
                              			        
                $sumatifph = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai) AS rerata_sumatif_ph FROM nilai_sumatif_ph WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND id_mapel='$rmapelkelas[id_mapel]' AND id_siswa='$rsiswakelas[id_siswa]'"));
                $nilai_sumatif_ph = round(($sumatifph['rerata_sumatif_ph']),2);
                              			        
                $sumatifas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_sumatif_as WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND id_mapel='$rmapelkelas[id_mapel]' AND id_siswa='$rsiswakelas[id_siswa]'"));
                $nilai_as = $sumatifas['nilai'];
                              			        
                $jumlahnilaimapelkelas = $nilai_formatif+$nilai_sumatif_ph+$nilai_as;
                $nilai_mapel_kelas = round(($jumlahnilaimapelkelas/3),2);
                
                mysqli_query($mysqli,"INSERT INTO nilai_mata_pelajaran SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$datakelas[id_kelas]', id_mapel='$rmapelkelas[id_mapel]', id_siswa='$rsiswakelas[id_siswa]', nilai='$nilai_mapel_kelas'");
                
                mysqli_query($mysqli,"DELETE FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND nilai='0'");
            }
            
            $datanilaijumlah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(nilai) AS jumlah_nilai_mata_pelajaran FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND id_siswa='$rsiswakelas[id_siswa]'"));
            
            $jumlahnilai = $datanilaijumlah['jumlah_nilai_mata_pelajaran'];
            
            $datanilairata = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai) AS rata_nilai_mata_pelajaran FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND id_siswa='$rsiswakelas[id_siswa]'"));
            
            $ratanilai = $datanilairata['rata_nilai_mata_pelajaran'];
            
            mysqli_query($mysqli,"INSERT INTO nilai_kelas SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$datakelas[id_kelas]', id_siswa='$rsiswakelas[id_siswa]', jumlah='$jumlahnilai', nilai='$ratanilai'");
        }
        
        
        
        ?>



<br>
<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header bg-danger">
                    <h3 class="card-title text-white">Daftar Nilai Kelas <?php echo $datakelas['nama_kelas']?></h3>
                    <div class="card-tools float-right">

                    </div>
                </div><!-- /.card-header -->
                <form method="POST">
                    <div class="card-body table-responsive">
                        <p class="text-left">
                            <a href="../assets/download/lager-nilai-kelas.php" target="_blank"
                                class="btn btn-primary btn-sm">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </p>
                        <table class="table table-striped table-bordered table-sm" style="font-size:12px;">
                            <thead>
                                <tr class="bg-info">
                                    <th rowspan="2" class="text-center align-middle" style="width:5%;">No</th>
                                    <th rowspan="2" class="text-center align-middle">Nama Peserta Didik</th>
                                    <th colspan="<?php echo $jumlahmapelkelas?>" class="text-center align-middle">Mata
                                        Pelajaran</th>
                                    <th rowspan="2" class="text-center align-middle" style="width:3%;">Jumlah Nilai</th>
                                    <th rowspan="2" class="text-center align-middle" style="width:3%;">Rata-rata</th>
                                    <th rowspan="2" class="text-center align-middle" style="width:3%;">Rank</th>
                                    <th colspan="3" class="text-center align-middle bg-warning">
                                        Rekap Presensi
                                        <!-- <button type="submit" name="simpanabsen" class="btn btn-danger btn-xs">Simpan
                                            Absensi</button> -->
                                    </th>
                                </tr>
                                <tr class="bg-info">
                                    <?php
                                    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                                    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' ORDER BY urut ASC");
                                    while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                                    ?>
                                    <th class="text-center align-middle" style="width:4%;">
                                        <?php echo $rmapelkelas['nama_mapel']?></th>
                                    <?php } ?>

                                    <?php
                                    $absen = mysqli_query($mysqli,"SELECT * FROM absen WHERE id_absen >1 ORDER BY id_absen ASC");
                                    while($rabsen = mysqli_fetch_array($absen)){
                                    ?>
                                    <th class="text-center align-middle bg-warning" style="width:5%;">
                                        <?php echo $rabsen['absen']?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                                $nomor=1;
                                $siswakelas = mysqli_query($mysqli,"SELECT * FROM nilai_kelas 
                                JOIN siswa ON nilai_kelas.id_siswa = siswa.id_siswa
                                WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' ORDER BY nama_siswa ASC");
                                while($rsiswakelas = mysqli_fetch_array($siswakelas)){
                                ?>
                                <tr>
                                    <td class="text-center align-middle"><?php echo $nomor++ ?></td>
                                    <td><?php echo $rsiswakelas['nama_siswa'] ?></td>
                                    <?php
                                    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                                    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' ORDER BY urut ASC");
                                    while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                                        $nilaimapel = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND id_mapel='$rmapelkelas[id_mapel]' AND id_siswa='$rsiswakelas[id_siswa]' "));
                                        $nilai_mapel_kelas = round(($nilaimapel['nilai']),2);
                                    ?>
                                    <td class="text-center align-middle" style="width:4%;">
                                        <?php echo $nilai_mapel_kelas?></td>
                                    <?php } ?>
                                    <td class="text-center align-middle"><?php echo $rsiswakelas['jumlah']?></td>
                                    <td class="text-center align-middle"><?php echo $rsiswakelas['nilai']?></td>
                                    <td class="text-center align-middle">
                                        <?php
                                            $rank = mysqli_query($mysqli, "SELECT COUNT(*) + 1 AS rank FROM nilai_kelas WHERE nilai > '$rsiswakelas[nilai]' AND tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]'");
                                            $rankData = mysqli_fetch_array($rank);
                                            echo $rankData['rank'];
                                        ?>
                                    </td>

                                    <!-- Data absensi siswa -->
                                    <!-- HARUS DI PERBAIKI -->
                                    <?php
                                    $absen = mysqli_query($mysqli, "SELECT * FROM absen WHERE id_absen >1 ORDER BY id_absen ASC");
                                    while ($rabsen = mysqli_fetch_array($absen)) {
                                        
                                        $presensiQuery = mysqli_query($mysqli, "SELECT * FROM presensi WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_absen='$rabsen[id_absen]' AND id_siswa='$rsiswakelas[id_siswa]'");
                                        $presensiData = mysqli_fetch_array($presensiQuery);
                                        $jumlah = isset($presensiData['jumlah']) ? $presensiData['jumlah'] : 0;
                                        
                                        $presensiCountQuery = mysqli_query($mysqli, "SELECT * FROM presensi WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_absen='$rabsen[id_absen]' AND id_siswa='$rsiswakelas[id_siswa]'");
                                        $presensiCount = mysqli_num_rows($presensiCountQuery);
                                        $valueToShow = !empty($jumlah) ? $jumlah : $presensiCount;
                                    ?>
                                    <td class="text-center align-middle bg-warning" style="width:5%;">
                                        <input type="text" class="form-control" name="jum[]"
                                            value="<?php echo $valueToShow; ?>">
                                        <input type="hidden" name="ab[]" value="<?php echo $rabsen['id_absen']; ?>">
                                        <input type="hidden" name="siswa[]"
                                            value="<?php echo $rsiswakelas['id_siswa']; ?>">
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>

                                <tr>
                                    <td colspan="2" class="text-center align-middle bg-warning">Nilai Rata-rata</td>
                                    <?php
                                    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                                    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' ORDER BY urut ASC");
                                    while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                                        $nilaimapel = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(nilai) AS jumlah_nilai_rata FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND id_mapel='$rmapelkelas[id_mapel]' "));
                                        $nilai_rata_rata = round(($nilaimapel['jumlah_nilai_rata']/$jumlahsiswakelas),2);
                                    ?>
                                    <td class="text-center align-middle bg-warning"><?php echo $nilai_rata_rata?></td>
                                    <?php } ?>
                                    <td class="text-center align-middle bg-warning">
                                        <?php
                                        $nilaikelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(jumlah) AS jumlah_nilai_rata FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' "));
                                        echo $nilai_jumlah_rata_rata_kelas = round(($nilaikelas['jumlah_nilai_rata']/$jumlahsiswakelas),2);
                                        ?>
                                    </td>
                                    <td class="text-center align-middle bg-warning">
                                        <?php
                                        $nilaikelas2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(nilai) AS nilai_rata_nilai FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' "));
                                        echo $nilai_rata_rata_kelas = round(($nilaikelas2['nilai_rata_nilai']/$jumlahsiswakelas),2);
                                        ?>
                                    </td>
                                </tr>


                                <tr>
                                    <td colspan="2" class="text-center align-middle bg-info">Nilai Terendah</td>
                                    <?php
                                    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                                    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' ORDER BY urut ASC");
                                    while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                                        $nilaimapel = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(nilai) AS nilai_rendah_mapel FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND id_mapel='$rmapelkelas[id_mapel]' "));
                                        $nilai_terendah_mapel = round(($nilaimapel['nilai_rendah_mapel']),2);
                                    ?>
                                    <td class="text-center align-middle bg-info"><?php echo $nilai_terendah_mapel?></td>
                                    <?php } ?>

                                    <td class="text-center align-middle bg-info">
                                        <?php
                                        $nilaikelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(jumlah) AS min_jumlah FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' "));
                                        echo $nilai_jumlah_min = round(($nilaikelas['min_jumlah']),2);
                                        ?>
                                    </td>
                                    <td class="text-center align-middle bg-info">
                                        <?php
                                        $nilaikelas2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(nilai) AS min_nilai FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' "));
                                        echo $nilai_min_kelas = round(($nilaikelas2['min_nilai']),2);
                                        ?>
                                    </td>
                                </tr>


                                <tr>
                                    <td colspan="2" class="text-center align-middle bg-danger">Nilai Tertinggi</td>
                                    <?php
                                    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                                    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' ORDER BY urut ASC");
                                    while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                                        $nilaimapel = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(nilai) AS nilai_tinggi_mapel FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND id_mapel='$rmapelkelas[id_mapel]' "));
                                        $nilai_terendah_mapel = round(($nilaimapel['nilai_tinggi_mapel']),2);
                                    ?>
                                    <td class="text-center align-middle bg-danger"><?php echo $nilai_terendah_mapel?>
                                    </td>
                                    <?php } ?>

                                    <td class="text-center align-middle bg-danger">
                                        <?php
                                        $nilaikelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(jumlah) AS max_jumlah FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' "));
                                        echo $nilai_jumlah_min = round(($nilaikelas['max_jumlah']),2);
                                        ?>
                                    </td>
                                    <td class="text-center align-middle bg-danger">
                                        <?php
                                        $nilaikelas2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(nilai) AS max_nilai FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' "));
                                        echo $nilai_min_kelas = round(($nilaikelas2['max_nilai']),2);
                                        ?>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                </form>
            </div>
        </div>
    </div><!-- /.row -->

</section><!-- /.content -->


<?php
if (isset($_POST['simpanabsen'])) {
    // Mengambil data siswa, jumlah, dan id absen dari form
    $siswa = $_POST['siswa'];
    $jum = $_POST['jum'];
    $ab = $_POST['ab'];
    // Menghitung jumlah siswa yang data absennya di-submit
    $jumlahsiswa = count($siswa);

    // Melakukan iterasi untuk setiap siswa
    for ($i = 0; $i < $jumlahsiswa; $i++) {
        // Validasi untuk memastikan bahwa jumlah bukan string kosong dan bukan 0
        if (isset($jum[$i]) && trim($jum[$i]) !== "" && intval($jum[$i]) != 0) {
            $jumlahInput = intval($jum[$i]); // Make sure this line is correctly converting the value

            // Mengecek apakah sudah ada data presensi untuk siswa dan absen yang spesifik
            $cekabsen = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM presensi WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_absen='$ab[$i]' AND id_siswa='$siswa[$i]'"));

            // Jika tidak ada, maka data baru akan dimasukkan
            if ($cekabsen == 0) {
                $simpan = mysqli_query($mysqli, "INSERT INTO presensi SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$datakelas[id_kelas]', id_siswa='$siswa[$i]', id_absen='$ab[$i]', jumlah='$jumlahInput' ");
            } else {
                // Jika sudah ada, maka data akan diperbarui
                $simpan = mysqli_query($mysqli, "UPDATE presensi SET jumlah='$jumlahInput' WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$siswa[$i]' AND id_absen='$ab[$i]' AND id_kelas='$datakelas[id_kelas]' ");
            }

            // Jika query berhasil, tampilkan pesan berhasil dan redirect ke halaman sebelumnya
            if ($simpan) {
                ?>
<script>
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages']?>";
</script>
<?php
            }
        }
    }
}
?>





<?php } ?>