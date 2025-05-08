<section class="content-header">
    <h1>
        Profil Sekolah
        <small><i>E-Rapor</i></small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Logo Sekolah</h3>
                    <div class="float-right">
                        <!-- Optional tools can go here -->
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <img src="../assets/dist/img/<?php echo $sekolah['logo'] ?>" style="width: 30%;">
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#myModal">Change Photos</button>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <img src="../assets/dist/img/<?php echo $sekolah['logo_prov'] ?>" style="width: 30%;">
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#myModalProv">Change Logo Prov</button>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" required=""
                                        value="<?php echo $user['username'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="text" name="pass" class="form-control" required=""
                                        value="<?php echo $user['pass'] ?>">
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" name="updatpassword" class="btn btn-primary btn-sm">Update
                                        Account</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Add your PHP logic here for updating the password -->
                    <?php  
                      	if (isset($_POST['updatpassword'])) {
                      		$username = $_POST['username'];
                      		$pass = $_POST['pass'];
                      		$password = password_hash($pass, PASSWORD_DEFAULT);

                      		$simpan = mysqli_query($mysqli,"UPDATE users SET username='$username', pass='$pass', password='$password' WHERE id_user='$_SESSION[id_user]'");
                      		if ($simpan) {
                      			?>
                    <script type="text/javascript">
                    alert('Silahkan Login Kembali dengan Informasi Akun Baru');
                    window.location.href = "logout.php";
                    </script>
                    <?php
                      		}
                      	}
                      	?>

                    <hr>
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tahun Pelajaran</label>
                                    <select name="id_tahun_pelajaran" class="form-control" required="">
                                        <option value="">Pilih Tahun Pelajaran</option>
                                        <?php  
                      					$tahun = mysqli_query($mysqli,"SELECT * FROM tahun_pelajaran ORDER BY id_tahun_pelajaran ASC");
                      					while($rtahun = mysqli_fetch_array($tahun)){
                      						if ($sekolah['tahun']==$rtahun['id_tahun_pelajaran']) {
                      							$seltahun = "selected";
                      						}else{
                      							$seltahun = "";
                      						}
                      					?>
                                        <option value="<?php echo $rtahun['id_tahun_pelajaran'] ?>"
                                            <?php echo $seltahun ?>><?php echo $rtahun['tahun_pelajaran'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Semester</label>
                                    <select name="id_semester" class="form-control" required="">
                                        <option value="">Pilih Semester</option>
                                        <?php  
                      					$semester = mysqli_query($mysqli,"SELECT * FROM semester ORDER BY id_semester ASC");
                      					while($rsemester = mysqli_fetch_array($semester)){
                      						if ($sekolah['semester']==$rsemester['id_semester']) {
                      							$selecsemester = "selected";
                      						}else{
                      							$selecsemester = "";
                      						}
                      					?>
                                        <option value="<?php echo $rsemester['id_semester'] ?>"
                                            <?php echo $selecsemester ?>><?php echo $rsemester['semester'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" name="updatetahun" class="btn btn-primary btn-sm">Update Data
                                        Pelaksanaan</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Add your PHP logic here for updating the year and semester -->
                    <?php  
                      	if (isset($_POST['updatetahun'])) {
                      		$id_tahun_pelajaran = $_POST['id_tahun_pelajaran'];
                      		$id_semester = $_POST['id_semester'];

                      		$simpan = mysqli_query($mysqli,"UPDATE sekolah SET tahun='$id_tahun_pelajaran', semester='$id_semester' WHERE id_sekolah='1'");
                      		if ($simpan) {
                        ?>
                    <script type="text/javascript">
                    swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Berhasil Login',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = "?pages=profil";
                    });
                    </script>
                    <?php
                      		}
                      	}
                      	?>

                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.col -->

        <div class="col-md-9">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Induk Sekolah</h3>
                    <div class="float-right">
                        <!-- Optional tools can go here -->
                    </div>
                </div><!-- /.card-header -->
                <form method="POST">
                    <div class="card-body bootstrap-select-1">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-striped">
                                    <tr>
                                        <td style="width: 30%;">NPSN</td>
                                        <td><input type="number" name="npsn" class="form-control"
                                                value="<?php echo $sekolah['npsn'] ?>" required=""></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Sekolah</td>
                                        <td><input type="text" name="nama_sekolah" class="form-control"
                                                value="<?php echo $sekolah['nama_sekolah'] ?>" required=""></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Sekolah</td>
                                        <td><input type="text" name="alamat" class="form-control"
                                                value="<?php echo $sekolah['alamat'] ?>" required=""></td>
                                    </tr>
                                    <tr>
                                        <td>Kontak Sekolah</td>
                                        <td><input type="text" name="kontak" class="form-control"
                                                value="<?php echo $sekolah['kontak'] ?>" required=""></td>
                                    </tr>
                                    <tr>
                                        <td>Email Sekolah</td>
                                        <td><input type="text" name="email" class="form-control"
                                                value="<?php echo $sekolah['email'] ?>" required=""></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table table-striped">
                                    <tr>
                                        <td>Website Sekolah</td>
                                        <td><input type="text" name="website" class="form-control"
                                                value="<?php echo $sekolah['website'] ?>" required=""></td>
                                    </tr>
                                    <tr>
                                        <td>Desa / Kelurahan</td>
                                        <td><input type="text" name="desa" class="form-control"
                                                value="<?php echo $sekolah['desa'] ?>" required=""></td>
                                    </tr>
                                    <tr>
                                        <td>Kecamatan</td>
                                        <td><input type="text" name="kecamatan" class="form-control"
                                                value="<?php echo $sekolah['kecamatan'] ?>" required=""></td>
                                    </tr>
                                    <tr>
                                        <td>Kabupaten</td>
                                        <td><input type="text" name="kabupaten" class="form-control"
                                                value="<?php echo $sekolah['kabupaten'] ?>" required=""></td>
                                    </tr>
                                    <tr>
                                        <td>Provinsi</td>
                                        <td><input type="text" name="provinsi" class="form-control"
                                                value="<?php echo $sekolah['provinsi'] ?>" required=""></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                    <div class="card-footer text-center">
                        <button type="submit" name="simpanprofil" class="btn btn-primary btn-sm">Perbaharui
                            Data</button>
                    </div>
                </form>

                <!-- Add your PHP logic here for updating the school data -->
                <?php  
	        	if (isset($_POST['simpanprofil'])) {
	        		$npsn = $_POST['npsn'];
	        		$nama_sekolah = $_POST['nama_sekolah'];
	        		$alamat = $_POST['alamat'];
	        		$kontak = $_POST['kontak'];
	        		$email = $_POST['email'];
	        		$website = $_POST['website'];
	        		$desa = $_POST['desa'];
	        		$kecamatan = $_POST['kecamatan'];
	        		$kabupaten = $_POST['kabupaten'];
	        		$provinsi = $_POST['provinsi'];

	        		$simpan = mysqli_query($mysqli,"UPDATE sekolah SET npsn='$npsn', nama_sekolah='$nama_sekolah', alamat='$alamat', kontak='$kontak', email='$email', website='$website', desa='$desa', kecamatan='$kecamatan', kabupaten='$kabupaten', provinsi='$provinsi' WHERE id_sekolah='1'");
	        		if ($simpan) {
	        			?>
                <script type="text/javascript">
                swal.fire({
                    title: "Berhasil!",
                    text: "Data Sekolah Berhasil Di Ubah",
                    icon: "success",
                    button: "OK",
                }).then(function() {
                    window.location.href = "?pages=profil";
                });
                </script>
                <?php
	        		}
	        	}
	        	?>
            </div><!-- /.card -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->


<div class="modal fade" id="myModalProv" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: green; color: white;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Photos</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label>Select Picture</label>
                        <input type="file" name="file" class="form-control" value="<?php echo $row['nama']; ?>">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="uploadfotoprov" class="btn btn-success">Update Photos</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php  
            if (isset($_POST['uploadfotoprov'])) {
            	$ekstensi_diperbolehkan	= array('png','jpg');
      				$nama = $_FILES['file']['name'];
      				$x = explode('.', $nama);
      				$ekstensi = strtolower(end($x));
      				$ukuran	= $_FILES['file']['size'];
      				$file_tmp = $_FILES['file']['tmp_name'];
      				$fotobaru = $sekolah['npsn'].'-'.$nama;
      				$fotolama = $sekolah['logo_prov'];	

      				unlink('../assets/dist/img/'.$fotolama);
      	 
      				if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
      					if($ukuran < 1044070){			
      						move_uploaded_file($file_tmp, '../assets/dist/img/'.$fotobaru);
      						$query = mysqli_query($mysqli, "UPDATE sekolah SET logo_prov='$fotobaru' WHERE id_sekolah='1'");
      						if($query){
      							?>

<script type="text/javascript">
swal.fire({
    title: "Berhasil!",
    text: "Foto berhasil diperbarui",
    icon: "success",
    button: "OK",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script>
<?php
      						}else{
      							?>
<script type="text/javascript">
swal.fire({
    title: "Gagal!",
    text: "Terjadi kesalahan saat memperbarui foto",
    icon: "error",
    button: "OK",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script>
<?php
      						}
      					}else{
      						?>
<script type="text/javascript">
swal.fire({
    title: "Gagal!",
    text: "Ukuran file terlalu besar",
    icon: "error",
    button: "OK",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script>
<?php
      					}
      				}else{
      					?>
<script type="text/javascript">
swal.fire({
    title: "Gagal!",
    text: "Ekstensi file tidak diizinkan",
    icon: "error",
    button: "OK",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script>
<?php
      				}
      	        }
            ?>




<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: green; color: white;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Photos</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label>Select Picture</label>
                        <input type="file" name="file" class="form-control" value="<?php echo $row['nama']; ?>">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="uploadfoto" class="btn btn-success">Update Photos</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php  
            if (isset($_POST['uploadfoto'])) {
            	$ekstensi_diperbolehkan	= array('png','jpg');
      				$nama = $_FILES['file']['name'];
      				$x = explode('.', $nama);
      				$ekstensi = strtolower(end($x));
      				$ukuran	= $_FILES['file']['size'];
      				$file_tmp = $_FILES['file']['tmp_name'];
      				$fotobaru = $sekolah['npsn'].'-'.$nama;
      				$fotolama = $sekolah['logo'];	

      				unlink('../assets/dist/img/'.$fotolama);
      	 
      				if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
      					if($ukuran < 1044070){			
      						move_uploaded_file($file_tmp, '../assets/dist/img/'.$fotobaru);
      						$query = mysqli_query($mysqli, "UPDATE sekolah SET logo='$fotobaru' WHERE id_sekolah='1'");
      						if($query){
      							?>
<script type="text/javascript">
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: 'Foto berhasil diperbarui',
    showConfirmButton: false,
    timer: 1500
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script>
<?php
      						}else{
      							?>
<script type="text/javascript">
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Terjadi kesalahan saat memperbarui foto',
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script>
<?php
      						}
      					}else{
      						?>
<script type="text/javascript">
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Ukuran Terlalu Besar',
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script>
<?php
      					}
      				}else{
      					?><script type="text/javascript">
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Ekstensi Tidak Diizinkan',
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script><?php
      				}
      	        }
            ?>