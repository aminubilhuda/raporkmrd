<?php  

    $mapelkelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
    JOIN kelas ON mapel_kelas.id_kelas = kelas.id_kelas
    JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
    WHERE id_mapel_kelas='$_GET[orderID]'"));
    
    $id_kelas = $mapelkelas['id_kelas'];
    $id_mapel = $mapelkelas['id_mapel'];
    
    include "../assets/excel_reader/excel_reader.php";
?>

<?php if(empty($_GET['filter'])){ ?>

<section class="content-header">
    <h1>
        Tujuan Pembelajaran <?php echo $mapelkelas['nama_mapel']?> - <?php echo $mapelkelas['nama_kelas']?>
    </h1>
</section>

<form method="POST">

    <section class="content-header">
        <a href="?pages=<?php echo 'kelas-ku'?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i>
            Kembali</a>
        <!-- <a href="" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal">Tambah Data</a>
        <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModalUploadTP">Upload Data</a> -->
        <button type="submit" name="hapustp" class="btn btn-danger btn-sm" id="deleteButton" style="display:none;"
            onclick="return confirm('Yakin akan menghapus TP?')">Hapus TP</button>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- USERS LIST -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Tujuan Pembelajaran <?php echo $mapelkelas['s_mapel']?> -
                            <?php echo $mapelkelas['nama_kelas']?></h3>
                        <div class="card-tools float-right">
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Select</th>
                                    <th>Kode</th>
                                    <th>Tujuan Pembelajaran</th>
                                    <th>KKTP</th>
                                    <!-- <th>Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                      			$nomor=1;
                      			$kelas = mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran
                      			WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$id_kelas' AND id_mapel='$id_mapel' ORDER BY urut ASC");
                      			while($rkelas = mysqli_fetch_array($kelas)){
                      			?>
                                <tr>
                                    <td><?php echo $nomor++ ?></td>
                                    <td>
                                        <input type="checkbox" name="tujuan[]" value="<?php echo $rkelas['id_tujuan']?>"
                                            onchange="toggleDeleteButton()">
                                    </td>
                                    <td><?php echo $rkelas['urut'] ?></td>
                                    <td><?php echo $rkelas['tujuan']?></td>
                                    <td><?php echo $rkelas['kktp']?></td>
                                    <!-- <td>
                                        <a href="" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#myModalEdit<?php echo $rkelas['id_tujuan']?>"><i
                                                class="fas fa-pencil-alt"></i></a>
                                    </td> -->
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="myModalEdit<?php echo $rkelas['id_tujuan']?>"
                                        role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header card-header">
                                                    <h4 class="modal-title">Form Edit Tujuan Pembelajaran</h4>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST">
                                                        <input type="hidden" name="id_tujuan"
                                                            value="<?php echo $rkelas['id_tujuan']?>">
                                                        <div class="form-group">
                                                            <label>Urutan TP</label>
                                                            <input type="text" class="form-control" name="urut"
                                                                required="" value="<?php echo $rkelas['urut']?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tujuan Pembelajaran</label>
                                                            <textarea name="tujuan" class="form-control" rows="5"
                                                                required=""><?php echo $rkelas['tujuan']?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>KKTP</label>
                                                            <input type="number" class="form-control" name="kktp"
                                                                required="" value="<?php echo $rkelas['kktp']?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="updatetujuanedit"
                                                                class="btn btn-success">Update Data</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.row -->
    </section><!-- /.content -->

</form>
<?php
            if(isset($_POST['hapustp'])){

                $tujuan = $_POST['tujuan'];
                $jumlahtujuan = count($tujuan);

                
                if($jumlahtujuan === 0){
                  // print_r($jumlahtujuan);
                    ?>
<script>
swal({
    title: "Tidak Ada Data yang Dipilih",
    icon: "warning",
    button: "OK",
}).then((value) => {
    window.location.href = "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>";
});
</script>
<?php
                }else{
                
                    for ($i=0; $i <$jumlahtujuan ; $i++) { 
                    	// Cek apakah tujuan pembelajaran digunakan di dua tabel lain
                    	$cekPenggunaan1 = mysqli_query($mysqli, "SELECT COUNT(*) as count FROM nilai_formatif WHERE id_tujuan='$tujuan[$i]'");
                    	$dataCek1 = mysqli_fetch_array($cekPenggunaan1);
                    	
                    	$cekPenggunaan2 = mysqli_query($mysqli, "SELECT COUNT(*) as count FROM nilai_sumatif_ph WHERE id_tujuan='$tujuan[$i]'");
                    	$dataCek2 = mysqli_fetch_array($cekPenggunaan2);

                    	if($dataCek1['count'] > 0 || $dataCek2['count'] > 0) {
                    		// Jika digunakan, tampilkan pesan
                    		echo "<script>alert('Tujuan Pembelajaran ini tidak dapat dihapus karena sedang digunakan di tabel lain.');</script>";
                    	} else {
                    		$hapustp = mysqli_query($mysqli,"DELETE FROM tujuan_pembelajaran WHERE id_tujuan='$tujuan[$i]'");
                    		?><script>
swal({
    title: "Tujuan Pembelajaran Berhasil Dihapus",
    icon: "success",
    button: "OK",
}).then((value) => {
    window.location.href = "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>";
});
</script><?php
                    	}          
                    
                    }
                }
            }
        ?>



<?php
            if(isset($_POST['updatetujuanedit'])){
                $urut = $_POST['urut'];
                $tujuan = $_POST['tujuan'];
                $kktp = $_POST['kktp'];
                $id_tujuan = $_POST['id_tujuan'];
                
                
                $simpan = mysqli_query($mysqli,"UPDATE tujuan_pembelajaran SET urut='$urut', tujuan='$tujuan', kktp='$kktp' WHERE id_tujuan='$id_tujuan'");
                
                if($simpan){
                    ?><script>
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>";
</script><?php
                }
            }
        ?>


<div class="modal fade" id="myModalUploadTP" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: green; color: white;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Upload Tujuan Pembelajaran</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Pilih File Excel</label>
                        <input type="file" class="form-control input-sm" name="file" required="">
                    </div>

                    <div class="form-group">
                        <label>
                            <a href="../assets/format/tujuan.xls" target="_blank">Download Format Tujuan
                                Pembelajaran</a>
                        </label>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="uploadtujuan" class="btn btn-success">Upload Data</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php  
    if (isset($_POST['uploadtujuan'])) {
        $target = basename($_FILES['file']['name']) ;
            move_uploaded_file($_FILES['file']['tmp_name'], $target);
                
            // beri permisi agar file xls dapat di baca
            chmod($_FILES['file']['name'],0777);
                
            // mengambil isi file xls
            $data = new Spreadsheet_Excel_Reader($_FILES['file']['name'],false);
            // menghitung jumlah baris data yang ada
            $jumlah_baris = $data->rowcount($sheet_index=0);
                
            // jumlah default data yang berhasil di import
            $berhasil = 0;
            for ($i=2; $i<=$jumlah_baris; $i++){
                
                // menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
                $urutan    = $data->val($i, 2);
                $tujuan = $data->val($i, 3);
                $kktp = $data->val($i, 4);

                mysqli_query($mysqli,"INSERT into tujuan_pembelajaran SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$id_kelas', id_mapel='$id_mapel', urut='$urutan', tujuan='$tujuan', kktp='$kktp'");
            }
            // hapus kembali file .xls yang di upload tadi
            unlink($_FILES['file']['name']);
            // alihkan halaman ke index.php
?>
<script type="text/javascript">
alert('Berhasil Mengupload <?php echo $jumlah_baris-1?> Data');
window.location.href = "?pages=<?php echo $_GET['pages'] ?>&orderID=<?php echo $_GET['orderID'] ?>";
</script>

<?php
    }
?>


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header card-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Tambah Tujuan Pembelajaran</h4>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group">
                        <label>Urutan TP</label><br>
                        <input type="number" class="form-control input-sm" name="urut" required="">
                    </div>

                    <div class="form-group">
                        <label>Tujuan Pembelajaran</label><br>
                        <textarea name="tujuan" class="form-control input-sm" rows="5" required=""></textarea>
                    </div>

                    <div class="form-group">
                        <label>KKTP</label><br>
                        <input type="number" class="form-control input-sm" name="kktp" required="">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="updatetujuan" class="btn btn-success">Update Data</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
            if(isset($_POST['updatetujuan'])){
                $urut = $_POST['urut'];
                $tujuan = $_POST['tujuan'];
                $kktp = $_POST['kktp'];
                
                
                $simpan = mysqli_query($mysqli,"INSERT INTO tujuan_pembelajaran SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$id_kelas', id_mapel='$id_mapel', urut='$urut', tujuan='$tujuan', kktp='$kktp', middle_formatif='1', middle_ph='1', formatif_as='1'");
                
                if($simpan){
                    ?><script>
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>";
</script><?php
                }
            }
            ?>





<?php } ?>

<script>
function toggleDeleteButton() {
    const checkboxes = document.querySelectorAll('input[name="tujuan[]"]');
    const deleteButton = document.getElementById('deleteButton');
    deleteButton.style.display = Array.from(checkboxes).some(checkbox => checkbox.checked) ? 'inline-block' : 'none';
}
</script>