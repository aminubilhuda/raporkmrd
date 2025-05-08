<?php
    $jumlahsubelemen = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]'"));
    $kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE id_kelas='$_GET[dataID]'"));
?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Proyek Profil Pancasila</h3>
                    <div class="card-tools">
                        <!-- You can add tools here if needed -->
                    </div>
                </div><!-- /.card-header -->
                <form method="POST">
                    <div class="card-body table-responsive">
                        <p>
                            <button type="submit" name="simpandata" class="btn btn-warning btn-sm">Simpan Data</button>
                        </p>
                        <table class="table table-striped table-bordered table-sm" style="font-size:12px;">
                            <thead style="background-color:#fee8d0;">
                                <tr>
                                    <th rowspan="3" class="text-center align-middle">No</th>
                                    <th rowspan="3" class="text-center align-middle">NISN</th>
                                    <th rowspan="3" class="text-center align-middle">Nama Peserta Didik</th>
                                    <th colspan="<?php echo $jumlahsubelemen ?>" class="text-center align-middle">
                                        Dimensi, Sub Elemen</th>
                                    <th rowspan="3" class="text-center align-middle">Nilai Kelas</th>
                                </tr>
                                <tr style="background-color:#fee8d0;">
                                    <?php
                                    $subelemen = mysqli_query($mysqli,"SELECT DISTINCT(id_dimensi) FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]' ORDER BY id_dimensi ASC");
                                    while($rsubelemen = mysqli_fetch_array($subelemen)){
                                        $jumlahsub = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]' AND id_dimensi='$rsubelemen[id_dimensi]'"));
                                        $dimensi = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM dimensi WHERE id_dimensi='$rsubelemen[id_dimensi]'"));
                                    ?>
                                    <th colspan="<?php echo $jumlahsub ?>" class="text-center align-middle"
                                        style="width:7%;">
                                        <?php echo substr($dimensi['dimensi'], 0, 30) . '...';?></th>
                                    <?php } ?>
                                </tr>
                                <tr style="background-color:#fee8d0;">
                                    <?php
                                    $subelemen = mysqli_query($mysqli,"SELECT DISTINCT(id_dimensi) FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]' ORDER BY id_dimensi ASC");
                                    while($rsubelemen = mysqli_fetch_array($subelemen)){
                                        $datasubelemen = mysqli_query($mysqli,"SELECT * FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]' AND id_dimensi='$rsubelemen[id_dimensi]' ORDER BY id_sub_elemen ASC");
                                        while($rdatasubelemen = mysqli_fetch_array($datasubelemen)){
                                            $datasub = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sub_elemen WHERE id_sub_elemen='$rdatasubelemen[id_sub_elemen]'"));
                                    ?>
                                    <th class="text-center align-middle" style="width:7%;">
                                        <?php echo substr($datasub['sub_elemen'], 0, 30) . '...';?></th>
                                    <?php } ?>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            $nomor = 1;
                            $siswakelas = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
                            JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                            WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[dataID]' ORDER BY nama_siswa ASC");
                            while($rsiswakelas = mysqli_fetch_array($siswakelas)){
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $nomor++?></td>
                                    <td class="text-center"><?php echo $rsiswakelas['nisn']?></td>
                                    <td><?php echo $rsiswakelas['nama_siswa']?> </td>
                                    <?php
                                $subelemen = mysqli_query($mysqli,"SELECT DISTINCT(id_dimensi) FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]' ORDER BY id_dimensi ASC");
                                while($rsubelemen = mysqli_fetch_array($subelemen)){
                                    $datasubelemen = mysqli_query($mysqli,"SELECT * FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]' AND id_dimensi='$rsubelemen[id_dimensi]' ORDER BY id_sub_elemen ASC");
                                    while($rdatasubelemen = mysqli_fetch_array($datasubelemen)){
                                        $datasub = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sub_elemen WHERE id_sub_elemen='$rdatasubelemen[id_sub_elemen]'"));
                                        $datanilai = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_proyek WHERE proyek='$_GET[orderID]' AND id_sub_elemen='$rdatasubelemen[id_sub_elemen]' AND id_siswa='$rsiswakelas[id_siswa]'"));
                                    ?>
                                    <td class="text-center align-middle">
                                        <select name="nilai[]" class="form-control form-control-sm">
                                            <option value="">Pilih Data</option>
                                            <option value="1" <?php if($datanilai['nilai']==1){ echo "selected";}?>>BB
                                            </option>
                                            <option value="2" <?php if($datanilai['nilai']==2){ echo "selected";}?>>MB
                                            </option>
                                            <option value="3" <?php if($datanilai['nilai']==3){ echo "selected";}?>>BSH
                                            </option>
                                            <option value="4" <?php if($datanilai['nilai']==4){ echo "selected";}?>>SB
                                            </option>
                                        </select>
                                        <input type="hidden" name="subelemen[]"
                                            value="<?php echo $rdatasubelemen['id_sub_elemen']?>">
                                        <input type="hidden" name="siswa[]"
                                            value="<?php echo $rsiswakelas['id_siswa']?>">
                                    </td>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php 
                                    $jumlahniali = mysqli_fetch_array(mysqli_query($mysqli,"SELECT SUM(nilai) AS jumlah_nilai FROM nilai_proyek WHERE proyek='$_GET[orderID]' AND id_siswa='$rsiswakelas[id_siswa]'"));
                                    $datajumlah = $jumlahniali['jumlah_nilai'];
                                    
                                    $rerata = round(($datajumlah/$jumlahsubelemen));
                                    if($rerata == 0){
                                        $ket = "BB";
                                    }elseif($rerata==1){
                                        $ket = "BB";
                                    }elseif($rerata==2){
                                        $ket = "MB";
                                    }elseif($rerata==3){
                                        $ket = "BSH";
                                    }elseif($rerata==4){
                                        $ket = "SB";
                                    }
                                    ?>
                                    <td class="text-center align-middle"><?php echo $ket ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div><!-- /.col-md-12 -->
    </div><!-- /.row -->
</section><!-- /.content -->

<?php
    if(isset($_POST['simpandata'])){
        $subelemen = $_POST['subelemen'];
        $siswa= $_POST['siswa'];
        $nilai = $_POST['nilai'];

        $jumlahsiswa = count($siswa);
        for ($i=0; $i <$jumlahsiswa ; $i++) { 

            $ceknilai = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM nilai_proyek WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND proyek='$_GET[orderID]' AND id_kelas='$_GET[dataID]' AND id_sub_elemen='$subelemen[$i]' AND id_siswa='$siswa[$i]'"));
            if($ceknilai == 0){
                $datasub = mysqli_query($mysqli,"SELECT * FROM sub_elemen WHERE id_sub_elemen='$subelemen[$i]'");
                while($rdatasub = mysqli_fetch_array($datasub)){
                    $id_dimensi = $rdatasub['id_dimensi'];
                    $id_elemen = $rdatasub['id_elemen'];
                    $id_sub_elemen = $rdatasub['id_sub_elemen'];

                    $simpan = mysqli_query($mysqli,"INSERT INTO nilai_proyek SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', proyek='$_GET[orderID]', id_kelas='$_GET[dataID]', id_dimensi='$id_dimensi', id_elemen='$id_elemen', id_sub_elemen='$id_sub_elemen', id_siswa='$siswa[$i]', nilai='$nilai[$i]'"); 
                }
            }else{
                $datasub = mysqli_query($mysqli,"SELECT * FROM sub_elemen WHERE id_sub_elemen='$subelemen[$i]'");
                while($rdatasub = mysqli_fetch_array($datasub)){
                    $id_dimensi = $rdatasub['id_dimensi'];
                    $id_elemen = $rdatasub['id_elemen'];
                    $id_sub_elemen = $rdatasub['id_sub_elemen'];

                    $simpan = mysqli_query($mysqli,"UPDATE nilai_proyek SET nilai='$nilai[$i]', id_dimensi='$id_dimensi', id_elemen='$id_elemen' WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND proyek='$_GET[orderID]' AND id_kelas='$_GET[dataID]' AND id_sub_elemen='$id_sub_elemen' AND id_siswa='$siswa[$i]'");
                }
            }
        }

        if($simpan){
            ?><script>
alert('Berhasil');
window.location.href =
    "?pages=<?php echo $_GET['pages']?>&filter=<?php echo $_GET['filter']?>&orderID=<?php echo $_GET['orderID']?>&dataID=<?php echo $_GET['dataID']?>";
</script><?php
        }
    }
?>