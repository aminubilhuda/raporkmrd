<?php  

$dataeskul = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM eskul WHERE id_eskul='$_GET[orderID]'"));
    
?>

<?php if(empty($_GET['filter'])){ ?>

<div class="page-title-box">
    <div class="btn-group float-right">
    </div>
    <h1 class="page-title">Detail Eskul <?php echo $dataeskul['nama_eskul']?></h1>
</div>


<section class="content">

    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header bg-danger">
                    <h3 class="card-title  text-white">Detail Eskul <?php echo $dataeskul['nama_eskul']?></h3>
                    <div class="card-tools float-right">

                    </div>
                </div><!-- /.card-header -->
                <form method="POST">
                    <div class="card-body table-responsive">
                        <p>
                            <button type="submit" name="simpandata" class="btn btn-primary">Update Penilaian
                                Eskul</button>
                        </p>
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr class="bg-danger text-white">
                                    <th style="height: 50px;" class="text-center align-middle">No</th>
                                    <th class="text-center align-middle">NISN</th>
                                    <th class="text-center align-middle">Nama Peserta Didik</th>
                                    <th class="text-center align-middle">Predikat</th>
                                    <th class="text-center align-middle">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                                $nomor=1;
                                $kelas = mysqli_query($mysqli,"SELECT * FROM siswa_eskul 
                                JOIN siswa ON siswa_eskul.id_siswa = siswa.id_siswa
                                WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$_GET[orderID]' ORDER BY nama_siswa ASC");
                                while($rkelas = mysqli_fetch_array($kelas)){
                                ?>
                                <tr>
                                    <td class="text-center align-middle"><?php echo $nomor++ ?></td>
                                    <td class="text-center align-middle"><?php echo $rkelas['nisn'] ?></td>
                                    <td><?php echo $rkelas['nama_siswa'] ?> <input type="hidden" name="siswa[]"
                                            value="<?php echo $rkelas['id_siswa']?>"></td>
                                    <td style="width:15%;">
                                        <select name="predikat[]" class="form-control">
                                            <option value="">Pilih Predikat</option>
                                            <option value="Sangat Baik"
                                                <?php if($rkelas['predikat']=="Sangat Baik"){ echo "selected";}?>>Sangat
                                                Baik</option>
                                            <option value="Baik"
                                                <?php if($rkelas['predikat']=="Baik"){ echo "selected";}?>>Baik</option>
                                            <option value="Cukup"
                                                <?php if($rkelas['predikat']=="Cukup"){ echo "selected";}?>>Cukup
                                            </option>
                                        </select>
                                    </td>
                                    <td style="width:40%;">
                                        <textarea name="keterangan[]" class="form-control"
                                            placeholder="Tuliskan Keterangan Siswa Tentang Eskul ini"><?php echo $rkelas['keterangan']?></textarea>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.row -->

</section><!-- /.content -->


<?php
        if(isset($_POST['simpandata'])){
            $siswa = $_POST['siswa'];
            $predikat = $_POST['predikat'];
            $keterangan = $_POST['keterangan'];
            
            $jumlahsiswa = count($siswa);
            for ($i=0; $i <$jumlahsiswa ; $i++) { 
            	$update = mysqli_query($mysqli,"UPDATE siswa_eskul SET predikat='$predikat[$i]', keterangan='$keterangan[$i]' WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$_GET[orderID]' AND id_siswa='$siswa[$i]' ");
            	if($update){
            	    ?>
<script>
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>";
</script>
<?php
            	}
            }
            
            
        }
        ?>


<?php } ?>