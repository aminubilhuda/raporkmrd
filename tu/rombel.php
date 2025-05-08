<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
    <h1>
        Rombongan Belajar Sekolah
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card border-danger">
                <div class="card-header text-white">
                    <h3 class="card-title">Daftar Rombongan Belajar Sekolah</h3>
                    <div class="float-right">
                        <a href="?pages=rombel&filter=<?php echo 'tambah' ?>" class="btn btn-primary ">
                            Tambah Data
                        </a>
                        <?php if($sekolah['semester'] == 2) { ?>
                        <a href="#" class="btn btn-warning " data-toggle="modal" data-target="#myModal">
                            Salin Data
                        </a>
                        <?php } ?>
                    </div>
                </div><!-- /.card-header -->

                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title">Salin Semester [Rombel]</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form method="POST">
                                    <div class="form-group text-center">
                                        <label>
                                            <h4>Yakin akan menyalin Data Semester Ganjil Ke Semester Genap?</h4>
                                        </label>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="salinData" class="btn btn-success">
                                            Salin Data
                                        </button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Close
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php  
                    if (isset($_POST['salinData'])) {
                        $kelas = mysqli_query($mysqli, "SELECT * FROM kelas_wali WHERE tahun='$sekolah[tahun]' AND semester='1'");
                        
                        $counter = 0;
                        
                        while ($rkelas = mysqli_fetch_array($kelas)) {
                            $id_kelas = $rkelas['id_kelas'];
                            $id_user = $rkelas['id_user'];

                            $cekdata = mysqli_num_rows(mysqli_query($mysqli, 
                                "SELECT * FROM kelas_wali 
                                WHERE tahun='$sekolah[tahun]' 
                                AND semester='$sekolah[semester]' 
                                AND id_kelas='$id_kelas'")); 

                            if ($cekdata == 0) {
                                mysqli_query($mysqli, "INSERT INTO kelas_wali SET 
                                    tahun='$sekolah[tahun]', 
                                    semester='$sekolah[semester]', 
                                    id_kelas='$id_kelas', 
                                    id_user='$id_user'");
                            } else {
                                mysqli_query($mysqli, "UPDATE kelas_wali SET 
                                    id_user='$id_user' 
                                    WHERE tahun='$sekolah[tahun]' 
                                    AND semester='$sekolah[semester]' 
                                    AND id_kelas='$id_kelas'");
                            }
                            
                            $counter++;
                        }
                        
                        // Menggunakan SweetAlert2
                        echo "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Total " . $counter . " data berhasil disalin',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = '?pages=rombel';
                            });
                        </script>";
                    }
                ?>

                <div class="card-body">
                    <form method="POST">
                        <table id="example1" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Tingkat</th>
                                    <th>Fase</th>
                                    <th>Program Keahlian <button type="submit" name="updateprogram"
                                            class="btn btn-success btn-xs">Simpan Program</button></th>
                                    <th>Wali Kelas <button type="submit" name="updatewali"
                                            class="btn btn-success btn-xs">Simpan Wali</button></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                                $nomor = 1;
                                $kelas = mysqli_query($mysqli, "SELECT * FROM kelas ORDER BY id_tingkat, id_kelas ASC");
                                while ($rkelas = mysqli_fetch_array($kelas)) {
                                    $tingkat = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tingkat WHERE id_tingkat='$rkelas[id_tingkat]'"));
                                    // $user = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM users WHERE id_user='$rkelas[id_user]'"));
                                ?>
                                <tr>
                                    <td><?php echo $nomor++ ?></td>
                                    <td><?php echo $rkelas['nama_kelas'] ?>
                                        <input type="hidden" name="id_kelas[]"
                                            value="<?php echo $rkelas['id_kelas'] ?>">
                                    </td>
                                    <td><?php echo $tingkat['tingkat'] ?></td>
                                    <td><?php echo $tingkat['fase'] ?></td>
                                    <td>
                                        <select name="id_kompetensi_keahlian[]" class="form-control "
                                            style="width:100%;">
                                            <option value="">Pilih Program Keahlian</option>
                                            <?php
                                            $program = mysqli_query($mysqli, "SELECT * FROM kompetensi_keahlian ORDER BY id_kompetensi_keahlian ASC");
                                            while ($rprogram = mysqli_fetch_array($program)) {
                                                $seleprogram = ($rkelas['id_kompetensi_keahlian'] == $rprogram['id_kompetensi_keahlian']) ? "selected" : "";
                                            ?>
                                            <option value="<?php echo $rprogram['id_kompetensi_keahlian'] ?>"
                                                <?php echo $seleprogram ?>>
                                                <?php echo $rprogram['kompetensi_keahlian'] ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="id_user[]" class="form-control " style="width:100%;">
                                            <option value="">Pilih Wali Kelas</option>
                                            <?php
                                            $guru = mysqli_query($mysqli, "SELECT * FROM users WHERE jabatan='3' ORDER BY id_user ASC");
                                            while ($rguru = mysqli_fetch_array($guru)) {
                                                $jumlahdata = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM kelas_wali WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$rkelas[id_kelas]' AND id_user='$rguru[id_user]'"));
                                                $sele = ($jumlahdata == 1) ? "selected" : "";
                                            ?>
                                            <option value="<?php echo $rguru['id_user'] ?>" <?php echo $sele ?>>
                                                <?php echo $rguru['nama'] ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo 'edit' ?>&dataID=<?php echo $rkelas['id_kelas'] ?>"
                                            class="btn btn-warning ">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo 'hapus' ?>&dataID=<?php echo $rkelas['id_kelas'] ?>"
                                            onclick="return confirm('Yakin ?')" class="btn btn-danger ">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div><!-- /.col-md-12 -->
    </div><!-- /.row -->
</section><!-- /.content -->


<?php
        if(isset($_POST['updatewali'])){
            $id_user = $_POST['id_user'];
            $id_kelas = $_POST['id_kelas'];
            
            $jumlahkelas = count($id_kelas);
            for ($i=0; $i <$jumlahkelas ; $i++) { 
            	$cekkelaswali = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM kelas_wali WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$id_kelas[$i]'"));
            	if($cekkelaswali == 0){
            	    $simpan = mysqli_query($mysqli,"INSERT INTO kelas_wali SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$id_kelas[$i]', id_user='$id_user[$i]'");
            	}else{
            	    $simpan = mysqli_query($mysqli,"UPDATE kelas_wali SET id_user='$id_user[$i]' WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$id_kelas[$i]' ");
            	}
            	
            	if($simpan){
            	    ?>
<script>
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages']?>"
</script>
<?php
            	}
            }
        }
?>

<?php
        if(isset($_POST['updateprogram'])){
            $id_kompetensi_keahlian = $_POST['id_kompetensi_keahlian'];
            $id_kelas = $_POST['id_kelas'];
            
            $jumlahkelas2 = count($id_kelas);
            for ($i=0; $i <$jumlahkelas2 ; $i++) { 
            
            	
            	$simpan = mysqli_query($mysqli,"UPDATE kelas SET id_kompetensi_keahlian='$id_kompetensi_keahlian[$i]' WHERE id_kelas='$id_kelas[$i]' ");
         
            	
            	if($simpan){
            	    ?>
<script>
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages']?>"
</script>
<?php
            	}
            }
        }
        ?>



<?php }elseif($_GET['filter']=="tambah"){ ?>
<section class="content-header">
    <div class="row">
        <h1>
            Form Tambah Rombongan Belajar Sekolah
            <small><i>E-Rapor</i></small>
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <form method="POST">
                <div class="card border-danger">
                    <div class="card-header text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Form Tambah Rombongan Belajar Sekolah</h3>
                        <div>
                            <a href="?pages=rombel" class="btn btn-primary">Kembali</a>
                            <button type="submit" name="simpandata" class="btn btn-success">Simpan Data</button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <input type="hidden" name="kode" value="<?php echo $kode ?>">

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Nama Kelas</td>
                                        <td><input type="text" name="nama_kelas" class="form-control " required
                                                autocomplete="off" autofocus></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Tingkat</td>
                                        <td>
                                            <select name="id_tingkat" class="form-control " required>
                                                <option value="">Pilih Tingkat</option>
                                                <?php  
		                      					$tingkat = mysqli_query($mysqli,"SELECT * FROM tingkat ORDER BY id_tingkat ASC");
		                      					while ($rtingkat = mysqli_fetch_array($tingkat)) {
		                      					?>
                                                <option value="<?php echo $rtingkat['id_tingkat'] ?>">
                                                    <?php echo $rtingkat['tingkat'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Kompetensi Keahlian</td>
                                        <td>
                                            <select name="id_kompetensi_keahlian" class="form-control select2"
                                                style="width:100%;">
                                                <option value="">Pilih Program Keahlian</option>
                                                <?php
                          				       $program = mysqli_query($mysqli,"SELECT * FROM kompetensi_keahlian ORDER BY id_kompetensi_keahlian ASC");
                          				       while($rprogram = mysqli_fetch_array($program)){
                          				       ?>
                                                <option value="<?php echo $rprogram['id_kompetensi_keahlian']?>">
                                                    <?php echo $rprogram['kompetensi_keahlian']?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.row -->
</section><!-- /.content -->


<?php  
        if (isset($_POST['simpandata'])) {
        	$nama_kelas = $_POST['nama_kelas'];
        	$id_tingkat = $_POST['id_tingkat'];
        	$id_kompetensi_keahlian = $_POST['id_kompetensi_keahlian'];
        	// $id_user = $_POST['id_user'];
        	
        	$cekwali = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM kelas WHERE nama_kelas='$nama_kelas' "));
        	if($cekwali==0){
        		$simpan = mysqli_query($mysqli,"INSERT INTO kelas SET id_tingkat='$id_tingkat', id_kompetensi_keahlian='$id_kompetensi_keahlian', nama_kelas='$nama_kelas'");
	        	if ($simpan) {
	        		?><script type="text/javascript">
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages'] ?>";
</script><?php
	        	}
        	}else{
        		?><script type="text/javascript">
alert('Gagal, Nama Kelas ini sudah ada');
window.location.href = "?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo 'tambah' ?>";
</script><?php
        	}

        	
        }
        ?>


<?php }elseif($_GET['filter']=="edit"){ 
    	$kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE id_kelas='$_GET[dataID]'"));
    	$kelas_wali = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas_wali WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[dataID]'"));
    	
    	?>
<section class="content-header">
    <h1>
        Form Edit Rombongan Belajar Sekolah
        <small><i>E-Rapor</i></small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <form method="POST">
                <div class="card border-danger">
                    <div class="card-header text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Form Edit Rombongan Belajar Sekolah</h3>
                        <div>
                            <a href="?pages=<?php echo $_GET['pages'] ?>" class="btn btn-primary">Kembali</a>
                            <button type="submit" name="editdata" class="btn btn-success">Simpan Data</button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Nama Kelas</td>
                                        <td><input type="text" name="nama_kelas" class="form-control " required
                                                autocomplete="off" autofocus value="<?php echo $kelas['nama_kelas'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Tingkat</td>
                                        <td>
                                            <select name="id_tingkat" class="form-control " required>
                                                <option value="">Pilih Tingkat</option>
                                                <?php  
		                      					$tingkat = mysqli_query($mysqli,"SELECT * FROM tingkat ORDER BY id_tingkat ASC");
		                      					while ($rtingkat = mysqli_fetch_array($tingkat)) {
		                      						if($kelas['id_tingkat']==$rtingkat['id_tingkat']){
		                      							$seltingkat = "selected";
		                      						}else{
		                      							$seltingkat = "";
		                      						}
		                      					?>
                                                <option value="<?php echo $rtingkat['id_tingkat'] ?>"
                                                    <?php echo $seltingkat ?>><?php echo $rtingkat['tingkat'] ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="width: 30%;">Wali Kelas</td>
                                        <td>
                                            <select name="id_user" class="form-control " required>
                                                <option value="">Pilih Wali Kelas</option>
                                                <?php  
		                      					$guru = mysqli_query($mysqli,"SELECT * FROM users ORDER BY id_user ASC");
		                      					while ($rguru = mysqli_fetch_array($guru)) {
		                      						if($kelas_wali['id_user']==$rguru['id_user']){
		                      							$selguru = "selected";
		                      						}else{
		                      							$selguru = "";
		                      						}
		                      						
		                      					?>
                                                <option value="<?php echo $rguru['id_user'] ?>" <?php echo $selguru ?>>
                                                    <?php echo $rguru['nama'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.row -->
</section><!-- /.content -->


<?php  
        if (isset($_POST['editdata'])) {
        	$nama_kelas = $_POST['nama_kelas'];
        	$id_tingkat = $_POST['id_tingkat'];
        	$id_guru = $_POST['id_user'];
        	

        		$simpan = mysqli_query($mysqli,"UPDATE kelas SET nama_kelas='$nama_kelas', id_tingkat='$id_tingkat' WHERE id_kelas='$_GET[dataID]'");
        		$simpan2 = mysqli_query($mysqli,"UPDATE kelas_wali SET id_user='$id_guru' WHERE id_kelas='$_GET[dataID]'");
	        	if ($simpan) {
	        		?><script type="text/javascript">
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages']?>";
</script><?php
	        	}
        }
        ?>


<?php }elseif($_GET['filter']=="hapus"){ 

    	$hapuskelas = mysqli_query($mysqli,"DELETE FROM kelas WHERE id_kelas='$_GET[dataID]'");
    	$hapussiswakelas = mysqli_query($mysqli,"DELETE FROM siswa_kelas WHERE id_kelas='$_GET[dataID]'");
    	$hapuspembelajaran = mysqli_query($mysqli,"DELETE FROM pembelajaran_kelas WHERE id_kelas='$_GET[dataID]'");

    	if ($hapuskelas || $hapussiswakelas || $hapuspembelajaran) {
        	?><script type="text/javascript">
alert('Berhasil');
window.location.href = "?pages=rombel";
</script><?php
        }

    	?>

<?php } ?>