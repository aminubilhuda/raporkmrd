<?php if(empty($_GET['filter'])){ 
        $jumlahmapelkelas = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM mapel_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]'"));
        
        $query = mysqli_query($mysqli,"SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]'");
        if ($query) {
            $jumlahsiswakelas = mysqli_num_rows($query);
        } else {
            // Menampilkan error jika query gagal
            echo "Error: " . mysqli_error($mysqli);
        }
        
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
                
                $cek_data = mysqli_query($mysqli, "SELECT * FROM nilai_mata_pelajaran 
                WHERE tahun='$sekolah[tahun]' 
                AND semester='$sekolah[semester]' 
                AND id_kelas='$datakelas[id_kelas]' 
                AND id_mapel='$rmapelkelas[id_mapel]' 
                AND id_siswa='$rsiswakelas[id_siswa]'");

                if(mysqli_num_rows($cek_data) > 0){
                    // Jika data sudah ada, lakukan update
                    mysqli_query($mysqli,"UPDATE nilai_mata_pelajaran 
                        SET nilai='$nilai_mapel_kelas' 
                        WHERE tahun='$sekolah[tahun]' 
                        AND semester='$sekolah[semester]' 
                        AND id_kelas='$datakelas[id_kelas]' 
                        AND id_mapel='$rmapelkelas[id_mapel]' 
                        AND id_siswa='$rsiswakelas[id_siswa]'");
                } else {
                
                mysqli_query($mysqli,"INSERT INTO nilai_mata_pelajaran SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$datakelas[id_kelas]', id_mapel='$rmapelkelas[id_mapel]', id_siswa='$rsiswakelas[id_siswa]', nilai='$nilai_mapel_kelas'");

                }
                
                mysqli_query($mysqli,"DELETE FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND nilai='0'");
            }
            
            $datanilaijumlah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(nilai) AS jumlah_nilai_mata_pelajaran FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND id_siswa='$rsiswakelas[id_siswa]'"));
            
            $jumlahnilai = $datanilaijumlah['jumlah_nilai_mata_pelajaran'];
            
            $datanilairata = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai) AS rata_nilai_mata_pelajaran FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND id_siswa='$rsiswakelas[id_siswa]'"));
            
            $ratanilai = $datanilairata['rata_nilai_mata_pelajaran'];
            
            mysqli_query($mysqli,"INSERT INTO nilai_kelas SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$datakelas[id_kelas]', id_siswa='$rsiswakelas[id_siswa]', jumlah='$jumlahnilai', nilai='$ratanilai'");
        }

?>

<div class="page-title-box">
    <div class="btn-group float-right">
    </div>
    <h4 class="page-title">Catatan Rapor Semester Siswa</h4>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card border-danger">
                <div class="card-header bg-danger d-flex justify-content-between">
                    <h3 class="card-title text-white">Halaman Dokumen Rapor <?php echo $datakelas['nama_kelas'] ?></h3>
                </div>

                <form method="POST">
                    <div class="card-body table-responsive">
                        <p>
                            <button type="submit" name="simpancatatan" class="btn btn-danger">
                                <i class="fa fa-save"></i> Simpan Catatan
                            </button>
                            <button type="button" class="btn btn-danger float-right" data-toggle="modal"
                                data-target="#lihatContohCatatan">
                                <i class="far fa-eye"></i> Lihat Contoh Catatan
                            </button>
                        </p>

                        <table class="table table-striped table-bordered table-sm" style="font-size:12px;">
                            <thead class="bg-danger text-white">
                                <tr>
                                    <th rowspan="2" class="text-center align-middle" style="width:5%;">No</th>
                                    <th rowspan="2" class="text-center align-middle" style="width:7%;">NISN</th>
                                    <th rowspan="2" class="text-center align-middle">Nama Peserta Didik</th>
                                    <th rowspan="2" class="text-center align-middle" style="width:45%;">Catatan Wali
                                        Kelas</th>
                                    <th class="text-center align-middle" style="width:10%; height: 40px;">Rapor Tengah
                                        Semester</th>
                                    <th class="text-center align-middle" style="width:10%;">Rapor Semester</th>
                                    <th class="text-center align-middle" style="width:10%;">Rapor Pelajar Pancasila</th>
                                </tr>
                                <tr class="bg-danger text-white">
                                    <th class="text-center">
                                        <a href="../assets/download/intrakurikuler-ts-all.php?kelas=<?php echo $datakelas['id_kelas']; ?>"
                                            target="_blank" class="btn btn-primary btn-xs">
                                            <i class="fa fa-print"></i> Cetak Serentak
                                        </a>
                                    </th>
                                    <th class="text-center">
                                        <a href="../assets/download/intrakurikuler-all.php?kelas=<?php echo $datakelas['id_kelas']; ?>"
                                            target="_blank" class="btn btn-success">
                                            <i class="fa fa-print"></i> Cetak Serentak
                                        </a>
                                    </th>
                                    <th class="text-center">
                                        <a href="../assets/download/profil-pancasila-all.php?kelas=<?php echo $datakelas['id_kelas']; ?>"
                                            target="_blank" class="btn btn-info">
                                            <i class="fa fa-print"></i> Cetak Serentak
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                                    $nomor = 1;
                                    $siswakelas = mysqli_query($mysqli, "SELECT * FROM nilai_kelas 
                                        JOIN siswa ON nilai_kelas.id_siswa = siswa.id_siswa
                                        WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' 
                                        ORDER BY nama_siswa ASC");
                                    while($rsiswakelas = mysqli_fetch_array($siswakelas)) {
                                        $catatan = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM catatan_wali 
                                            WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' 
                                            AND id_kelas='$datakelas[id_kelas]' AND id_siswa='$rsiswakelas[id_siswa]'"));
                                ?>
                                <tr>
                                    <td class="text-center align-middle"><?php echo $nomor++ ?></td>
                                    <td class="text-center align-middle"><?php echo $rsiswakelas['nisn'] ?></td>
                                    <td class="align-middle">
                                        <?php echo $rsiswakelas['nama_siswa'] ?>
                                        <input type="hidden" name="siswa[]"
                                            value="<?php echo $rsiswakelas['id_siswa'] ?>">
                                    </td>
                                    <td class="text-center">
                                        <textarea name="catatan[]" class="form-control"
                                            placeholder="Masukan Catatan Semester Untuk <?=$rsiswakelas['nama_siswa'] ?>"
                                            rows="3"><?php echo $catatan['catatan'] ?></textarea>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="../assets/download/intrakurikuler-ts.php?orderID=<?php echo $rsiswakelas['id_siswa'] ?>"
                                            target="_blank" class="btn btn-primary btn-sm">
                                            <i class="fa fa-print"></i> Tengah Semester
                                        </a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="../assets/download/intrakurikuler.php?orderID=<?php echo $rsiswakelas['id_siswa'] ?>"
                                            target="_blank" class="btn btn-success btn-sm">
                                            <i class="fa fa-print"></i> Semester
                                        </a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="../assets/download/profil-pancasila.php?orderID=<?php echo $rsiswakelas['id_siswa'] ?>"
                                            target="_blank" class="btn btn-info btn-sm">
                                            <i class="fa fa-print"></i> P5BK
                                        </a>
                                    </td>
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


<!-- Modal -->
<div class="modal fade" id="lihatContohCatatan" tabindex="-1" role="dialog" aria-labelledby="lihatContohCatatanLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lihatContohCatatanLabel">Contoh Catatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-sm">
                    <tr>
                        <th>No</th>
                        <th>Contoh Catatan</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Tetap semangat dan jangan mudah patah semangat, karena kunci kesuksesan ada pada usaha
                            kerasmu yang tidak
                            pernah padam.
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Kesuksesan tidak datang secara instan. Tingkatkan terus motivasimu dalam belajar agar kamu
                            bisa menjadi siswa yang
                            mencapai prestasi dan membuat kedua orang tuamu bangga.
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td> Terus belajar ya. Raih terus keinginanmu di masa depan hingga kamu bisa mendapatkannya!
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    Swal.fire({
      title: "Catatan Wali...?",
      text: "Jangan Lupa Mengisi Catatan Walinyaa....!!      Sebelum Mencetak Rapor Semester",
      icon: "question"
    });
</script>



<?php
        if(isset($_POST['simpancatatan'])){
            $catatan = $_POST['catatan'];
            $siswa = $_POST['siswa'];
            $jumlahsiswa = count($siswa);
            
            for ($i=0; $i <$jumlahsiswa ; $i++) { 
            	$cekdata = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM catatan_wali WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND id_siswa='$siswa[$i]'"));
            	if($cekdata==0){
            	    $simpan = mysqli_query($mysqli,"INSERT INTO catatan_wali SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$datakelas[id_kelas]', id_siswa='$siswa[$i]', catatan='$catatan[$i]'");
            	}else{
            	    $simpan = mysqli_query($mysqli,"UPDATE catatan_wali SET catatan='$catatan[$i]' WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND id_siswa='$siswa[$i]' ");
            	}
            	
            	if($simpan){
            	    ?><script>
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages']?>&filter=<?php echo $_GET['filter']?>";
</script><?php
            	}
            }
        }
        ?>

<?php } ?>