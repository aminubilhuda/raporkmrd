<section class="content-header">
    <h1>
        Laporan Pendidikan
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
        
        $jumlahmapelkelas = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM mapel_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]'"));
        $jumlahsiswakelas = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]'"));
        
        mysqli_query($mysqli,"DELETE FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]'");
        mysqli_query($mysqli,"DELETE FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]'");
        
        $siswakelas = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
        JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
        WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND aktif='1' ORDER BY nama_siswa ASC");
        while($rsiswakelas = mysqli_fetch_array($siswakelas)){
            $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
            JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
            WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ORDER BY urut ASC");
            while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                $formatif = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai) AS rerata_formatif FROM nilai_formatif WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_mapel='$rmapelkelas[id_mapel]' AND id_siswa='$rsiswakelas[id_siswa]' AND nas='1'"));
                $nilai_formatif = round(($formatif['rerata_formatif']),2);
                              			        
                $sumatifph = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai) AS rerata_sumatif_ph FROM nilai_sumatif_ph WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_mapel='$rmapelkelas[id_mapel]' AND id_siswa='$rsiswakelas[id_siswa]'"));
                $nilai_sumatif_ph = round(($sumatifph['rerata_sumatif_ph']),2);
                              			        
                $sumatifas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_sumatif_as WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_mapel='$rmapelkelas[id_mapel]' AND id_siswa='$rsiswakelas[id_siswa]'"));
                $nilai_as = $sumatifas['nilai'];
                              			        
                $jumlahnilaimapelkelas = $nilai_formatif+$nilai_sumatif_ph+$nilai_as;
                $nilai_mapel_kelas = round(($jumlahnilaimapelkelas/3),2);
                
                mysqli_query($mysqli,"INSERT INTO nilai_mata_pelajaran SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$_GET[orderID]', id_mapel='$rmapelkelas[id_mapel]', id_siswa='$rsiswakelas[id_siswa]', nilai='$nilai_mapel_kelas'");
                
                mysqli_query($mysqli,"DELETE FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND nilai='0'");
            }
            
            $datanilaijumlah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(nilai) AS jumlah_nilai_mata_pelajaran FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_siswa='$rsiswakelas[id_siswa]'"));
            
            $jumlahnilai = $datanilaijumlah['jumlah_nilai_mata_pelajaran'];
            
            $datanilairata = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai) AS rata_nilai_mata_pelajaran FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_siswa='$rsiswakelas[id_siswa]'"));
            
            $ratanilai = $datanilairata['rata_nilai_mata_pelajaran'];
            
            mysqli_query($mysqli,"INSERT INTO nilai_kelas SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$_GET[orderID]', id_siswa='$rsiswakelas[id_siswa]', jumlah='$jumlahnilai', nilai='$ratanilai'");
        }
        
?>


<section class="content-header">

    <a href="?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>" class="btn btn-primary">Lager
        Nilai Intra</a>
    <a href="?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&filter=<?php echo 'laporan-p5'?>"
        class="btn btn-success">Lager Nilai Proyek</a>
    <a href="?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&filter=<?php echo 'laporan-middle'?>"
        class="btn btn-danger">Lager Nilai Middle</a>
</section>


<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Nilai Intrakurikuler kelas <?php echo $kelas['nama_kelas']?></h3>
                    <div class="card-tools float-right">
                        <a href="../assets/download/lager-nilai-kelas-admin.php?orderID=<?php echo $_GET['orderID']?>"
                            target="_blank" class="btn btn-primary btn-sm">Download</a>
                    </div>
                </div><!-- /.card-header -->

                <div class="card-body table-responsive">

                    <table class="table table-striped table-bordered" style="font-size:12px;">
                        <thead>
                            <tr style="background-color:#e0b9fb;">
                                <th rowspan="2" style="text-align:center; vertical-align:middle; width:5%;">No</th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle; width:5%;">Aksi</th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle; width:7%;">NISN</th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle;">Nama Peserta Didik
                                </th>
                                <th colspan="<?php echo $jumlahmapelkelas?>"
                                    style="text-align:center; vertical-align:middle;">Mata Pelajaran</th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle; width:3%;">Jumlah <br>
                                    Nilai</th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle; width:3%;">Rata-rata
                                </th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle; width:3%;">Rank</th>
                                <th colspan="4"
                                    style="text-align:center; vertical-align:middle; background-color:#fbecb9;">Rekap
                                    Presensi</th>
                            </tr>
                            <tr style="background-color:#e0b9fb;">
                                <?php
                                    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                                    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ORDER BY urut ASC");
                                    while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                                ?>
                                <th style="text-align:center; vertical-align:middle; width:4%;" data-toggle="tooltip"
                                    data-placement="top" title="<?php echo $rmapelkelas['nama_mapel']?>">
                                    <?php echo $rmapelkelas['s_mapel']?></th>
                                <?php } ?>

                                <?php
                                    $absen = mysqli_query($mysqli,"SELECT * FROM absen ORDER BY id_absen ASC");
                                    while($rabsen = mysqli_fetch_array($absen)){
                                ?>
                                <th
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbecb9;">
                                    <?php echo $rabsen['absen']?></th>
                                <?php } ?>


                            </tr>

                        </thead>
                        <tbody>
                            <?php  
                                $nomor=1;
                                $nomorrank=1;
                                $siswakelas = mysqli_query($mysqli,"SELECT * FROM nilai_kelas 
                                JOIN siswa ON nilai_kelas.id_siswa = siswa.id_siswa
                                WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ORDER BY nilai DESC");
                                while($rsiswakelas = mysqli_fetch_array($siswakelas)){
                            ?>
                            <tr>
                                <td style="text-align:center;"><?php echo $nomor++ ?></td>
                                <td style="text-align:center;"><a
                                        href="../assets/download/intrakurikuler.php?orderID=<?php echo $rsiswakelas['id_siswa']?>"
                                        target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-print"></i></a>
                                </td>

                                <td style="text-align:center;"><?php echo $rsiswakelas['nisn'] ?></td>
                                <td><?php echo $rsiswakelas['nama_siswa'] ?></td>
                                <?php
                                    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                                    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ORDER BY urut ASC");
                                    while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                                        
                                        $nilaimapel = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_mapel='$rmapelkelas[id_mapel]' AND id_siswa='$rsiswakelas[id_siswa]' "));
                                        
                                        $nilai_mapel_kelas = round(($nilaimapel['nilai']),2);
                                        
                                        
                                        
                                    ?>
                                <td style="text-align:center; vertical-align:middle; width:4%;">
                                    <?php echo $nilai_mapel_kelas?></td>
                                <?php } ?>
                                <td style="text-align:center; vertical-align:middle; width:3%;">
                                    <?php echo $rsiswakelas['jumlah']?></td>
                                <td style="text-align:center; vertical-align:middle; width:3%;">
                                    <?php echo $rsiswakelas['nilai']?></td>
                                <td style="text-align:center; vertical-align:middle; width:3%;">
                                    <?php echo $nomorrank++?></td>
                                <?php
                                    $absen = mysqli_query($mysqli,"SELECT * FROM absen ORDER BY id_absen ASC");
                                    while($rabsen = mysqli_fetch_array($absen)){
                                        $presensi = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM presensi WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_absen='$rabsen[id_absen]' AND id_siswa='$rsiswakelas[id_siswa]'"));
                                    ?>
                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbecb9;">
                                    <input type="text" style="width:100%;" name="jum[]" value="<?php echo $presensi?>">
                                    <input type="hidden" style="width:100%;" name="ab[]"
                                        value="<?php echo $rabsen['id_absen']?>">
                                    <input type="hidden" style="width:100%;" name="siswa[]"
                                        value="<?php echo $rsiswakelas['id_siswa']?>">
                                </td>
                                <?php } ?>
                            </tr>
                            <?php } ?>

                            <tr>
                                <td colspan="4"
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbecb9;">
                                    Nilai Rata-rata</td>
                                <?php
                                    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                                    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ORDER BY urut ASC");
                                    while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                                        $nilaimapel = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(nilai) AS jumlah_nilai_rata FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_mapel='$rmapelkelas[id_mapel]' "));
                                        $nilai_rata_rata = round(($nilaimapel['jumlah_nilai_rata']/$jumlahsiswakelas),2);
                                    ?>
                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbecb9;">
                                    <?php echo $nilai_rata_rata?></td>
                                <?php } ?>
                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbecb9;">
                                    <?php
                                        $nilaikelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(jumlah) AS jumlah_nilai_rata FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' "));
                                        echo $nilai_jumlah_rata_rata_kelas = round(($nilaikelas['jumlah_nilai_rata']/$jumlahsiswakelas),2);
                                        ?>
                                </td>
                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbecb9;">
                                    <?php
                                        $nilaikelas2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(nilai) AS nilai_rata_nilai FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' "));
                                        echo $nilai_rata_rata_kelas = round(($nilaikelas2['nilai_rata_nilai']/$jumlahsiswakelas),2);
                                        ?>
                                </td>
                            </tr>


                            <tr>
                                <td colspan="4"
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#b9e8fb;">
                                    Nilai Terendah</td>
                                <?php
                                    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                                    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ORDER BY urut ASC");
                                    while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                                        $nilaimapel = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(nilai) AS nilai_rendah_mapel FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_mapel='$rmapelkelas[id_mapel]' "));
                                        $nilai_terendah_mapel = round(($nilaimapel['nilai_rendah_mapel']),2);
                                    ?>
                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#b9e8fb;">
                                    <?php echo $nilai_terendah_mapel?></td>
                                <?php } ?>

                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#b9e8fb;">
                                    <?php
                                        $nilaikelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(jumlah) AS min_jumlah FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' "));
                                        echo $nilai_jumlah_min = round(($nilaikelas['min_jumlah']),2);
                                        ?>
                                </td>
                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#b9e8fb;">
                                    <?php
                                        $nilaikelas2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(nilai) AS min_nilai FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' "));
                                        echo $nilai_min_kelas = round(($nilaikelas2['min_nilai']),2);
                                        ?>
                                </td>
                            </tr>


                            <tr>
                                <td colspan="4"
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbb9bc;">
                                    Nilai Tertinggi</td>
                                <?php
                                    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                                    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ORDER BY urut ASC");
                                    while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                                        $nilaimapel = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(nilai) AS nilai_tinggi_mapel FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_mapel='$rmapelkelas[id_mapel]' "));
                                        $nilai_terendah_mapel = round(($nilaimapel['nilai_tinggi_mapel']),2);
                                    ?>
                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbb9bc;">
                                    <?php echo $nilai_terendah_mapel?></td>
                                <?php } ?>

                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbb9bc;">
                                    <?php
                                        $nilaikelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(jumlah) AS max_jumlah FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' "));
                                        echo $nilai_jumlah_min = round(($nilaikelas['max_jumlah']),2);
                                        ?>
                                </td>
                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbb9bc;">
                                    <?php
                                        $nilaikelas2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(nilai) AS max_nilai FROM nilai_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' "));
                                        echo $nilai_min_kelas = round(($nilaikelas2['max_nilai']),2);
                                        ?>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.row -->

</section><!-- /.content -->



<?php }elseif(!empty($_GET['orderID']) and $_GET['filter']=='laporan-p5'){ 
        
    $proyek = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM proyek_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]'"));
    $id_proyek_kelas = $proyek['id_proyek_kelas'];
    
    $jumlahsubelemen = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM proyek_subelemen WHERE id_proyek_kelas='$id_proyek_kelas'"));
    $jumlahmapel = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM mapel_proyek WHERE id_proyek_kelas='$id_proyek_kelas'"));
        
?>

<section class="content-header">

    <a href="?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>" class="btn btn-primary">Lager
        Nilai Intra</a>
    <a href="?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&filter=<?php echo 'laporan-p5'?>"
        class="btn btn-success">Lager Nilai Proyek</a>
    <a href="?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&filter=<?php echo 'laporan-middle'?>"
        class="btn btn-danger">Lager Nilai Middle</a>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Rekap Nilai Project</h3>
                    <div class="card-tools float-right">
                    </div>
                </div><!-- /.card-header -->
                <form method="POST">
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-bordered" style="font-size:12px;">
                            <tr style="background-color:#5DD099;">
                                <td rowspan="3" style="text-align:center; vertical-align:middle;">No</td>
                                <td rowspan="3" style="text-align:center; vertical-align:middle;">Aksi</td>
                                <td rowspan="3" style="text-align:center; vertical-align:middle;">NISN</td>
                                <td rowspan="3" style="text-align:center; vertical-align:middle;">Nama Peserta Didik
                                </td>
                                <td colspan="<?php echo $jumlahsubelemen ?>"
                                    style="text-align:center; vertical-align:middle;">Dimensi, Sub Elemen</td>
                                <td rowspan="3" style="text-align:center; vertical-align:middle;">Nilai Kelas</td>
                            </tr>
                            <tr style="background-color:#fee8d0;">
                                <?php
                                $subelemen = mysqli_query($mysqli,"SELECT DISTINCT(id_dimensi) FROM proyek_subelemen WHERE id_proyek_kelas='$id_proyek_kelas' ORDER BY id_dimensi ASC");
                                while($rsubelemen = mysqli_fetch_array($subelemen)){
                                    $jumlahsub = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM proyek_subelemen WHERE id_proyek_kelas='$id_proyek_kelas' AND id_dimensi='$rsubelemen[id_dimensi]'"));
                                    $dimensi = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM dimensi WHERE id_dimensi='$rsubelemen[id_dimensi]'"));
                                ?>
                                <td colspan="<?php echo $jumlahsub ?>"
                                    style="text-align:center; vertical-align:middle; width:7%;">
                                    <?php echo substr($dimensi['dimensi'], 0, 20) . '...';?></td>
                                <?php } ?>
                            </tr>
                            <tr style="background-color:#fee8d0;">
                                <?php
                                $subelemen = mysqli_query($mysqli,"SELECT DISTINCT(id_dimensi) FROM proyek_subelemen WHERE id_proyek_kelas='$id_proyek_kelas' ORDER BY id_dimensi ASC");
                                while($rsubelemen = mysqli_fetch_array($subelemen)){
                                
                                $datasubelemen = mysqli_query($mysqli,"SELECT * FROM proyek_subelemen WHERE id_proyek_kelas='$id_proyek_kelas' AND id_dimensi='$rsubelemen[id_dimensi]' ORDER BY id_sub_elemen ASC");
                                while($rdatasubelemen = mysqli_fetch_array($datasubelemen)){
                                    $datasub = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sub_elemen WHERE id_sub_elemen='$rdatasubelemen[id_sub_elemen]'"));
                                
                                ?>
                                <td style="text-align:center; vertical-align:middle; width:7%;">
                                    <?php echo substr($datasub['sub_elemen'], 0, 20) . '...';?></td>
                                <?php } ?>
                                <?php } ?>
                            </tr>
                            <?php
                            $nomor=1;
                            $siswakelas = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
                            JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                            WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ORDER BY nama_siswa ASC");
                            while($rsiswakelas = mysqli_fetch_array($siswakelas)){
                            ?>
                            <tr>
                                <td style="text-align:center;"><?php echo $nomor++?></td>
                                <td style="text-align:center;"><a
                                        href="../assets/download/profil-pancasila.php?orderID=<?php echo $rsiswakelas['id_siswa']?>"
                                        target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-print"></i></a>
                                </td>
                                <td style="text-align:center;"><?php echo $rsiswakelas['nisn']?></td>
                                <td><?php echo $rsiswakelas['nama_siswa']?></td>
                                <?php
                                $subelemen = mysqli_query($mysqli,"SELECT DISTINCT(id_dimensi) FROM proyek_subelemen WHERE id_proyek_kelas='$id_proyek_kelas' ORDER BY id_dimensi ASC");
                                while($rsubelemen = mysqli_fetch_array($subelemen)){
                                
                                $datasubelemen = mysqli_query($mysqli,"SELECT * FROM proyek_subelemen WHERE id_proyek_kelas='$id_proyek_kelas' AND id_dimensi='$rsubelemen[id_dimensi]' ORDER BY id_sub_elemen ASC");
                                while($rdatasubelemen = mysqli_fetch_array($datasubelemen)){
                                    $datasub = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sub_elemen WHERE id_sub_elemen='$rdatasubelemen[id_sub_elemen]'"));
                                    
                                    $jumlahnialisub = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(nilai) AS jumlah_nilai FROM nilai_proyek WHERE proyek='$id_proyek_kelas' AND id_sub_elemen='$rdatasubelemen[id_sub_elemen]' AND id_siswa='$rsiswakelas[id_siswa]'"));
                                    $rata2nilaisub = round(($jumlahnilaisub['jumlah_nilai']/$jumlahmapel));
                                    if($rata2nilaisub==0){
                                        $ket = "BB";
                                    }elseif($rata2nilaisub==1){
                                        $ket = "BB";
                                    }elseif($rata2nilaisub==2){
                                        $ket = "MB";
                                    }elseif($rata2nilaisub==3){
                                        $ket = "BSH";
                                    }elseif($rata2nilaisub==4){
                                        $ket = "SB";
                                    }
                                    
                                ?>
                                <td style="text-align:center; vertical-align:middle; width:7%;"><?php echo $ket ?></td>
                                <?php } ?>
                                <?php } ?>
                                <td style="text-align:center; vertical-align:middle; width:7%;">
                                    <?php
                                    $jumlahnialisub = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(nilai) AS jumlah_nilai FROM nilai_proyek WHERE proyek='$id_proyek_kelas' AND id_siswa='$rsiswakelas[id_siswa]'"));
                                    $jumnilaisub = $jumlahnilaisub['jumlah_nilai'];
                                    $rata2kelas = round(((($jumnilaisub/$jumlahsubelemen)/$jumlahmapel)));
                                    if($rata2kelas==0){
                                        echo $ketkelas = "BB";
                                    }elseif($rata2kelas==1){
                                        echo $ketkelas = "BB";
                                    }elseif($rata2kelas==2){
                                        echo $ketkelas = "MB";
                                    }elseif($rata2kelas==3){
                                        echo $ketkelas = "BSH";
                                    }elseif($rata2kelas==4){
                                        echo $ketkelas = "SB";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
            </div>
        </div><!-- /.row -->

</section><!-- /.content -->




<?php }elseif(!empty($_GET['orderID']) and $_GET['filter']=='laporan-middle'){ 
        
        $kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE id_kelas='$_GET[orderID]'"));
        
        $jumlahmapelkelas = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM mapel_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]'"));
        $jumlahsiswakelas = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]'"));
        
        mysqli_query($mysqli,"DELETE FROM nilai_mapel_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ");
        mysqli_query($mysqli,"DELETE FROM nilai_kelas_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ");
        
        $siswakelas = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
        JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
        WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND aktif='1' ORDER BY nama_siswa ASC");
        while($rsiswakelas = mysqli_fetch_array($siswakelas)){
            
            $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
            JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
            WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ORDER BY urut ASC");
            while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                
                
                $formatif = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai) AS rerata_formatif FROM nilai_formatif WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_mapel='$rmapelkelas[id_mapel]' AND id_siswa='$rsiswakelas[id_siswa]' AND middle='1'"));
                
                $nilai_formatif = round(($formatif['rerata_formatif']),2);
                              			        
                $sumatifph = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai) AS rerata_sumatif_ph FROM nilai_sumatif_ph WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_mapel='$rmapelkelas[id_mapel]' AND id_siswa='$rsiswakelas[id_siswa]' AND middle='1'"));
                $nilai_sumatif_ph = round(($sumatifph['rerata_sumatif_ph']),2);
                
                              			        
                $sumatifas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_sumatif_ts WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_mapel='$rmapelkelas[id_mapel]' AND id_siswa='$rsiswakelas[id_siswa]'"));
                
                $nilai_ts = $sumatifas['nilai'];
                              			        
                // $jumlahnilaimapelkelas = $nilai_formatif+$nilai_sumatif_ph+$nilai_as;
                $jumlahnilaimapelkelas = $nilai_ts;
                $nilai_mapel_kelas = round(($jumlahnilaimapelkelas),2);
                
                mysqli_query($mysqli,"INSERT INTO nilai_mapel_mid SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$_GET[orderID]', id_mapel='$rmapelkelas[id_mapel]', id_siswa='$rsiswakelas[id_siswa]', jumlah='$jumlahnilaimapelkelas', nilai='$nilai_mapel_kelas'");
                
            }
            
            $datanilaijumlah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(nilai) AS jumlah_nilai_mata_pelajaran FROM nilai_mapel_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_siswa='$rsiswakelas[id_siswa]'"));
            
            $jumlahnilai = $datanilaijumlah['jumlah_nilai_mata_pelajaran'];
            
            $datanilairata = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai) AS rata_nilai_mata_pelajaran FROM nilai_mapel_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_siswa='$rsiswakelas[id_siswa]'"));
            
            $ratanilai = $datanilairata['rata_nilai_mata_pelajaran'];
            
            mysqli_query($mysqli,"INSERT INTO nilai_kelas_mid SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$_GET[orderID]', id_siswa='$rsiswakelas[id_siswa]', jumlah='$jumlahnilai', nilai='$ratanilai'");
            
           
        }
        
        
        ?>
<section class="content-header">

    <a href="?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>" class="btn btn-primary">Lager
        Nilai Intra</a>
    <a href="?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&filter=<?php echo 'laporan-p5'?>"
        class="btn btn-success">Lager Nilai Proyek</a>
    <a href="?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>&filter=<?php echo 'laporan-middle'?>"
        class="btn btn-danger">Lager Nilai Middle</a>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Rekap Nilai Tengah Semester</h3>
                    <div class="card-tools float-right">

                    </div>
                </div><!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered" style="font-size:12px;">
                        <thead>
                            <tr style="background-color:#F66D5D;">
                                <th rowspan="2" style="text-align:center; vertical-align:middle; width:5%;">No</th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle; width:5%;">Aksi</th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle; width:7%;">NISN</th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle;">Nama Peserta Didik
                                </th>
                                <th colspan="<?php echo $jumlahmapelkelas?>"
                                    style="text-align:center; vertical-align:middle;">Mata Pelajaran</th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle; width:3%;">Jumlah <br>
                                    Nilai</th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle; width:3%;">Rata-rata
                                </th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle; width:3%;">Rank</th>
                            </tr>
                            <tr style="background-color:#F66D5D;">
                                <?php
                      			    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                      			    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                      			    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ORDER BY urut ASC");
                      			    while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                      			    ?>
                                <th style="text-align:center; vertical-align:middle; width:4%;" data-toggle="tooltip"
                                    data-placement="top" title="<?php echo $rmapelkelas['nama_mapel']?>">
                                    <?php echo $rmapelkelas['s_mapel']?></th>
                                <?php } ?>

                            </tr>

                        </thead>
                        <tbody>
                            <?php  
                      			$nomor=1;
                      			$nomorrank=1;
                      			$siswakelas = mysqli_query($mysqli,"SELECT * FROM nilai_kelas_mid 
                      			JOIN siswa ON nilai_kelas_mid.id_siswa = siswa.id_siswa
                      			WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ORDER BY nilai DESC");
                      			while($rsiswakelas = mysqli_fetch_array($siswakelas)){
                      			?>
                            <tr>
                                <td style="text-align:center;"><?php echo $nomor++ ?></td>
                                <td style="text-align:center;"><a
                                        href="../assets/download/intrakurikuler-ts.php?orderID=<?php echo $rsiswakelas['id_siswa']?>"
                                        target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-print"></i></a>
                                </td>

                                <td style="text-align:center;"><?php echo $rsiswakelas['nisn'] ?></td>
                                <td><?php echo $rsiswakelas['nama_siswa'] ?></td>
                                <?php
                      			    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                      			    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                      			    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ORDER BY urut ASC");
                      			    while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                      			        
                      			        $nilaiMapelMid = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_mapel_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_mapel='$rmapelkelas[id_mapel]' AND id_siswa='$rsiswakelas[id_siswa]' "));
                      			        
                      			        $nilai_mapel_kelas = round(($nilaiMapelMid['nilai']),2);
                      			        
                      			    ?>
                                <td style="text-align:center; vertical-align:middle; width:4%;">
                                    <?php echo $nilai_mapel_kelas?></td>
                                <?php } ?>
                                <td style="text-align:center; vertical-align:middle; width:3%;">
                                    <?php echo $rsiswakelas['jumlah']?></td>
                                <td style="text-align:center; vertical-align:middle; width:3%;">
                                    <?php echo round($rsiswakelas['nilai'],2)?></td>
                                <td style="text-align:center; vertical-align:middle; width:3%;">
                                    <?php echo $nomorrank++?></td>

                            </tr>
                            <?php } ?>

                            <tr>
                                <td colspan="4"
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbecb9;">
                                    Nilai Rata-rata</td>
                                <?php
                      			    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                      			    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                      			    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ORDER BY urut ASC");
                      			    while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                      			        $nilaimapel = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(nilai) AS jumlah_nilai_rata FROM nilai_mapel_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_mapel='$rmapelkelas[id_mapel]' "));
                      			        
                      			        $nilai_rata_rata = round(($nilaimapel['jumlah_nilai_rata']/$jumlahsiswakelas),2);
                      			    ?>
                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbecb9;">
                                    <?php echo $nilai_rata_rata?></td>
                                <?php } ?>
                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbecb9;">
                                    <?php
                      			        $nilaikelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(jumlah) AS jumlah_nilai_rata FROM nilai_kelas_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' "));
                      			        echo $nilai_jumlah_rata_rata_kelas = round(($nilaikelas['jumlah_nilai_rata']/$jumlahsiswakelas),2);
                      			        ?>
                                </td>
                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbecb9;">
                                    <?php
                      			        $nilaikelas2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(nilai) AS nilai_rata_nilai FROM nilai_kelas_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' "));
                      			        echo $nilai_rata_rata_kelas = round(($nilaikelas2['nilai_rata_nilai']/$jumlahsiswakelas),2);
                      			        ?>
                                </td>
                            </tr>


                            <tr>
                                <td colspan="4"
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#b9e8fb;">
                                    Nilai Terendah</td>
                                <?php
                      			    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                      			    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                      			    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ORDER BY urut ASC");
                      			    while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                      			        $nilaimapel = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(nilai) AS nilai_rendah_mapel FROM nilai_mapel_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_mapel='$rmapelkelas[id_mapel]' "));
                      			        $nilai_terendah_mapel = round(($nilaimapel['nilai_rendah_mapel']),2);
                      			    ?>
                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#b9e8fb;">
                                    <?php echo $nilai_terendah_mapel?></td>
                                <?php } ?>

                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#b9e8fb;">
                                    <?php
                      			        $nilaikelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(jumlah) AS min_jumlah FROM nilai_kelas_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' "));
                      			        echo $nilai_jumlah_min = round(($nilaikelas['min_jumlah']),2);
                      			        ?>
                                </td>
                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#b9e8fb;">
                                    <?php
                      			        $nilaikelas2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(nilai) AS min_nilai FROM nilai_kelas_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' "));
                      			        echo $nilai_min_kelas = round(($nilaikelas2['min_nilai']),2);
                      			        ?>
                                </td>
                            </tr>


                            <tr>
                                <td colspan="4"
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbb9bc;">
                                    Nilai Tertinggi</td>
                                <?php
                      			    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                      			    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                      			    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' ORDER BY urut ASC");
                      			    while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                      			        $nilaimapel = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(nilai) AS nilai_tinggi_mapel FROM nilai_mapel_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' AND id_mapel='$rmapelkelas[id_mapel]' "));
                      			        $nilai_terendah_mapel = round(($nilaimapel['nilai_tinggi_mapel']),2);
                      			    ?>
                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbb9bc;">
                                    <?php echo $nilai_terendah_mapel?></td>
                                <?php } ?>

                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbb9bc;">
                                    <?php
                      			        $nilaikelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(jumlah) AS max_jumlah FROM nilai_kelas_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' "));
                      			        echo $nilai_jumlah_min = round(($nilaikelas['max_jumlah']),2);
                      			        ?>
                                </td>
                                <td
                                    style="text-align:center; vertical-align:middle; width:5%; background-color:#fbb9bc;">
                                    <?php
                      			        $nilaikelas2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(nilai) AS max_nilai FROM nilai_kelas_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]' "));
                      			        echo $nilai_min_kelas = round(($nilaikelas2['max_nilai']),2);
                      			        ?>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.row -->

</section><!-- /.content -->


<?php } ?>