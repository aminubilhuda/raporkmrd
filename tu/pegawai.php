<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
    <h1>
        Pegawai Sekolah
        <small><i>E-Rapor</i></small>
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card border-danger">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pegawai Sekolah</h3>
                    <div class="float-left">
                        <a href="?pages=pegawai&filter=<?php echo 'tambah' ?>" class="btn btn-primary">Tambah
                            Data</a>
                        <a href="?pages=pegawai&filter=<?php echo 'upload' ?>" class="btn btn-warning">Upload
                            Data</a>
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body">


                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Guru</th>
                                <th>NIP</th>
                                <th>NUPTK</th>
                                <th>Penugasan</th>
                                <th>Tugas Tambahan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                            $nomor=1;
                            $guru = mysqli_query($mysqli,"SELECT * FROM users ORDER BY jabatan, id_user ASC");
                            while($rguru = mysqli_fetch_array($guru)){
                                $jabatan = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM jabatan WHERE id_jabatan='$rguru[jabatan]'"));
                                $tugastambahan = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tugas_tambahan WHERE id_tugas_tambahan='$rguru[id_tugas_tambahan]'"));
                            ?>
                            <tr>
                                <td><?php echo $nomor++ ?></td>
                                <td><?php echo $rguru['nama'] ?></td>
                                <td><?php echo $rguru['nip'] ?></td>
                                <td><?php echo $rguru['nuptk'] ?></td>
                                <td><?php echo $jabatan['jabatan'] ?></td>
                                <td><?php echo $tugastambahan['tugas_tambahan'] ?></td>
                                <td>
                                    <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo 'edit' ?>&dataID=<?php echo $rguru['id_user'] ?>"
                                        class="btn btn-warning " data-toggle="tooltip" title="Edit"><i
                                            class="fas fa-edit"></i></a>

                                    <a href="../assets/download/login-pendidik.php?dataID=<?php echo $rguru['id_user'] ?>"
                                        target="_blank" class="btn btn-success" data-toggle="tooltip" title="Print"><i
                                            class="fas fa-print"></i></a>

                                    <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo 'hapus' ?>&dataID=<?php echo $rguru['id_user'] ?>"
                                        onclick="return confirm('Yakin ?')" class="btn btn-danger" data-toggle="tooltip"
                                        title="Hapus"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div><!-- /.col-md-12 -->
    </div><!-- /.row -->


</section><!-- /.content -->


<?php }elseif($_GET['filter']=="tambah"){ ?>
<section class="content-header">
    <h1>
        Form Tambah Pegawai Sekolah
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <form method="POST">
                <div class="card border-danger">
                    <div class="card-header text-white">
                        <h3 class="card-title">Form Tambah Pegawai Sekolah</h3>
                        <div class="float-right">
                            <a href="?pages=pegawai" class="btn btn-primary ">Kembali</a>
                            <input type="submit" name="simpandata" value="Simpan Data" class="btn btn-success ">
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="kode" value="<?php echo $kode ?>">

                        <table class="table table-striped table-bordered">
                            <tr>
                                <td style="width: 30%;">Nama Guru</td>
                                <td>
                                    <input type="text" name="nama_guru" class="form-control " required
                                        autocomplete="off" autofocus>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Jenis Kelamin</td>
                                <td>
                                    <select name="id_jenis_kelamin" class="form-control " required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <?php  
                                        $kelamin = mysqli_query($mysqli, "SELECT * FROM jenis_kelamin ORDER BY id_jenis_kelamin ASC");
                                        while ($rkelamin = mysqli_fetch_array($kelamin)) {
                                        ?>
                                        <option value="<?php echo $rkelamin['id_jenis_kelamin'] ?>">
                                            <?php echo $rkelamin['jenis_kelamin'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Agama</td>
                                <td>
                                    <select name="id_agama" class="form-control " required>
                                        <option value="">Pilih Agama</option>
                                        <?php  
                                        $agama = mysqli_query($mysqli, "SELECT * FROM agama ORDER BY id_agama ASC");
                                        while ($ragama = mysqli_fetch_array($agama)) {
                                        ?>
                                        <option value="<?php echo $ragama['id_agama'] ?>">
                                            <?php echo $ragama['agama'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Pendidikan Terakhir</td>
                                <td>
                                    <select name="id_pendidikan" class="form-control " required>
                                        <option value="">Pilih Pendidikan Terakhir</option>
                                        <?php  
                                        $pendidikan = mysqli_query($mysqli, "SELECT * FROM pendidikan ORDER BY id_pendidikan ASC");
                                        while ($rpendidikan = mysqli_fetch_array($pendidikan)) {
                                        ?>
                                        <option value="<?php echo $rpendidikan['id_pendidikan'] ?>">
                                            <?php echo $rpendidikan['pendidikan'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Kepegawaian</td>
                                <td>
                                    <select name="id_kepegawaian" class="form-control " required>
                                        <option value="">Pilih Jenis Kepegawaian</option>
                                        <?php  
                                        $kepegawaian = mysqli_query($mysqli, "SELECT * FROM kepegawaian ORDER BY id_kepegawaian ASC");
                                        while ($rkepegawaian = mysqli_fetch_array($kepegawaian)) {
                                        ?>
                                        <option value="<?php echo $rkepegawaian['id_kepegawaian'] ?>">
                                            <?php echo $rkepegawaian['kepegawaian'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">NIP Guru</td>
                                <td>
                                    <input type="text" name="nip" class="form-control " required autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">NUPTK Guru</td>
                                <td>
                                    <input type="text" name="nuptk" class="form-control " required autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Kontak Guru</td>
                                <td>
                                    <input type="text" name="kontak" class="form-control " required autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Username Guru</td>
                                <td>
                                    <input type="text" name="username" class="form-control " required
                                        autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Password Guru</td>
                                <td>
                                    <input type="text" name="password" class="form-control " required
                                        autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Tugas Pokok</td>
                                <td>
                                    <select name="id_jabatan" class="form-control " required>
                                        <option value="">Pilih Tugas Pokok</option>
                                        <?php  
                                        $jab = mysqli_query($mysqli, "SELECT * FROM jabatan ORDER BY id_jabatan ASC");
                                        while ($rjab = mysqli_fetch_array($jab)) {
                                        ?>
                                        <option value="<?php echo $rjab['id_jabatan'] ?>">
                                            <?php echo $rjab['jabatan'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Tugas Tambahan</td>
                                <td>
                                    <select name="id_tugas_tambahan" class="form-control " required>
                                        <option value="">Pilih Tugas Tambahan</option>
                                        <?php  
                                        $tugastambahan = mysqli_query($mysqli, "SELECT * FROM tugas_tambahan ORDER BY id_tugas_tambahan ASC");
                                        while ($rtugastambahan = mysqli_fetch_array($tugastambahan)) {
                                        ?>
                                        <option value="<?php echo $rtugastambahan['id_tugas_tambahan'] ?>">
                                            <?php echo $rtugastambahan['tugas_tambahan'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<?php  
        
        if (isset($_POST['simpandata'])) {
        	$nama = $_POST['nama_guru'];
        	$id_jenis_kelamin = $_POST['id_jenis_kelamin'];
        	$id_agama = $_POST['id_agama'];
        	$id_kepegawaian = $_POST['id_kepegawaian'];
        	$nip = $_POST['nip'];
        	$nuptk = $_POST['nuptk'];
        	$kontak = $_POST['kontak'];
        	$pass = $_POST['password'];
        	$username = $_POST['username'];
        	$id_jabatan = $_POST['id_jabatan'];
        	$id_pendidikan = $_POST['id_pendidikan'];
        	$id_tugas_tambahan = $_POST['id_tugas_tambahan'];
        	$password = password_hash($pass, PASSWORD_DEFAULT);

        	$simpan = mysqli_query($mysqli,"INSERT INTO users SET jabatan='$id_jabatan', 
            nama='$nama', 
            kelamin='$id_jenis_kelamin', 
            agama='$id_agama', 
            nip='$nip', 
            nuptk='$nuptk', 
            kontak='$kontak', 
            id_kepegawaian='$id_kepegawaian', 
            ijazah='$id_pendidikan', 
            id_tugas_tambahan='$id_tugas_tambahan', 
            username='$username', 
            pass='$pass', 
            password='$password'");
        	if ($simpan) {
        		?>
<script type="text/javascript">
swal.fire({
    title: "Berhasil!",
    text: "Data berhasil disimpan",
    icon: "success",
    button: "OK",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages'] ?>";
});
</script>
<?php
        	}
        }
        ?>


<?php }elseif($_GET['filter']=="edit"){ 
    		$guru = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$_GET[dataID]'"));
    	?>
<section class="content-header">
    <h1>
        Form Edit Pegawai Sekolah
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
                    <div class="card-header text-white">
                        <h3 class="card-title">Form Edit Pegawai Sekolah</h3>
                        <div class="float-right">
                            <a href="?pages=pegawai" class="btn btn-primary">Kembali</a>
                            <button type="submit" name="editdata" class="btn btn-success">Simpan Data</button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <td style="width: 30%;">Nama Guru</td>
                                <td><input type="text" name="nama_guru" class="form-control " required=""
                                        autocomplete="off" autofocus="" value="<?php echo $guru['nama']?>"></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Jenis Kelamin</td>
                                <td>
                                    <select name="id_jenis_kelamin" class="form-control " required="">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <?php  
                                        $kelamin = mysqli_query($mysqli,"SELECT * FROM jenis_kelamin ORDER BY id_jenis_kelamin ASC");
                                        while ($rkelamin = mysqli_fetch_array($kelamin)) {
                                            $selekel = ($guru['kelamin'] == $rkelamin['id_jenis_kelamin']) ? "selected" : "";
                                        ?>
                                        <option value="<?php echo $rkelamin['id_jenis_kelamin'] ?>"
                                            <?php echo $selekel ?>>
                                            <?php echo $rkelamin['jenis_kelamin'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Agama</td>
                                <td>
                                    <select name="id_agama" class="form-control " required="">
                                        <option value="">Pilih Agama</option>
                                        <?php  
                                        $agama = mysqli_query($mysqli,"SELECT * FROM agama ORDER BY id_agama ASC");
                                        while ($ragama = mysqli_fetch_array($agama)) {
                                            $seleagama = ($guru['agama'] == $ragama['id_agama']) ? "selected" : "";
                                        ?>
                                        <option value="<?php echo $ragama['id_agama'] ?>" <?php echo $seleagama ?>>
                                            <?php echo $ragama['agama'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Pendidikan Terakhir</td>
                                <td>
                                    <select name="id_pendidikan" class="form-control " required="">
                                        <option value="">Pilih Pendidikan Terakhir</option>
                                        <?php  
                                        $pendidikan = mysqli_query($mysqli,"SELECT * FROM pendidikan ORDER BY id_pendidikan ASC");
                                        while ($rpendidikan = mysqli_fetch_array($pendidikan)) {
                                            $seleijazah = ($guru['ijazah'] == $rpendidikan['id_pendidikan']) ? "selected" : "";
                                        ?>
                                        <option value="<?php echo $rpendidikan['id_pendidikan'] ?>"
                                            <?php echo $seleijazah ?>>
                                            <?php echo $rpendidikan['pendidikan'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Kepegawaian</td>
                                <td>
                                    <select name="id_kepegawaian" class="form-control " required="">
                                        <option value="">Pilih Jenis Kepegawaian</option>
                                        <?php  
                                        $kepegawaian = mysqli_query($mysqli,"SELECT * FROM kepegawaian ORDER BY id_kepegawaian ASC");
                                        while ($rkepegawaian = mysqli_fetch_array($kepegawaian)) {
                                            $selepeg = ($guru['id_kepegawaian'] == $rkepegawaian['id_kepegawaian']) ? "selected" : "";
                                        ?>
                                        <option value="<?php echo $rkepegawaian['id_kepegawaian'] ?>"
                                            <?php echo $selepeg ?>>
                                            <?php echo $rkepegawaian['kepegawaian'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">NIP Guru</td>
                                <td><input type="text" name="nip" class="form-control " required="" autocomplete="off"
                                        autofocus="" value="<?php echo $guru['nip']?>"></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">NUPTK Guru</td>
                                <td><input type="text" name="nuptk" class="form-control " required="" autocomplete="off"
                                        autofocus="" value="<?php echo $guru['nuptk']?>"></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Kontak Guru</td>
                                <td><input type="text" name="kontak" class="form-control " required=""
                                        autocomplete="off" autofocus="" value="<?php echo $guru['kontak']?>"></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Username Guru</td>
                                <td><input type="text" name="username" class="form-control " required=""
                                        autocomplete="off" autofocus="" value="<?php echo $guru['username']?>"></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Password Guru</td>
                                <td><input type="text" name="pass" class="form-control " required="" autocomplete="off"
                                        autofocus="" value="<?php echo $guru['pass']?>"></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Tugas Pokok</td>
                                <td>
                                    <select name="id_jabatan" class="form-control " required="">
                                        <option value="">Pilih Tugas Pokok</option>
                                        <?php  
                                        $jab = mysqli_query($mysqli,"SELECT * FROM jabatan ORDER BY id_jabatan ASC");
                                        while ($rjab = mysqli_fetch_array($jab)) {
                                            $selejab = ($guru['jabatan'] == $rjab['id_jabatan']) ? "selected" : "";
                                        ?>
                                        <option value="<?php echo $rjab['id_jabatan'] ?>" <?php echo $selejab ?>>
                                            <?php echo $rjab['jabatan'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Tugas Tambahan</td>
                                <td>
                                    <select name="id_tugas_tambahan" class="form-control " required="">
                                        <option value="">Pilih Tugas Tambahan</option>
                                        <?php  
                                        $tugastambahan = mysqli_query($mysqli,"SELECT * FROM tugas_tambahan ORDER BY id_tugas_tambahan ASC");
                                        while ($rtugastambahan = mysqli_fetch_array($tugastambahan)) {
                                            $seletugas = ($guru['id_tugas_tambahan'] == $rtugastambahan['id_tugas_tambahan']) ? "selected" : "";
                                        ?>
                                        <option value="<?php echo $rtugastambahan['id_tugas_tambahan'] ?>"
                                            <?php echo $seletugas ?>>
                                            <?php echo $rtugastambahan['tugas_tambahan'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        </div><!-- /.col-md-12 -->
    </div><!-- /.row -->
</section><!-- /.content -->


<?php  
        if (isset($_POST['editdata'])) {
        	$nama = $_POST['nama_guru'];
        	$id_jenis_kelamin = $_POST['id_jenis_kelamin'];
        	$id_agama = $_POST['id_agama'];
        	$id_kepegawaian = $_POST['id_kepegawaian'];
        	$nip = $_POST['nip'];
        	$nuptk = $_POST['nuptk'];
        	$kontak = $_POST['kontak'];
        	$id_jabatan = $_POST['id_jabatan'];
        	$id_pendidikan = $_POST['id_pendidikan'];
        	$id_tugas_tambahan = $_POST['id_tugas_tambahan'];
        	$username = $_POST['username'];
        	$pass = $_POST['pass'];
            $password = password_hash($pass, PASSWORD_DEFAULT);

        	$simpan = mysqli_query($mysqli,"UPDATE users SET jabatan='$id_jabatan', 
            nama='$nama', 
            kelamin='$id_jenis_kelamin', 
            agama='$id_agama', 
            nip='$nip', 
            nuptk='$nuptk', 
            kontak='$kontak', 
            id_kepegawaian='$id_kepegawaian', 
            ijazah='$id_pendidikan', 
            username='$username', 
            pass='$pass',
            password='$password',
            id_tugas_tambahan='$id_tugas_tambahan' WHERE id_user='$_GET[dataID]'");
        	if ($simpan) {
        		?>
<script type="text/javascript">
swal.fire({
    title: "Berhasil!",
    text: "Data berhasil disimpan",
    icon: "success",
    button: "OK",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages'] ?>";
});
</script>
<?php
        	}
        }
        ?>


<?php }elseif($_GET['filter']=="hapus"){ 

    	$hapusguru = mysqli_query($mysqli,"DELETE FROM users WHERE id_user='$_GET[dataID]'");

    	if ($hapusguru) {
        	?>
<script type="text/javascript">
swal.fire({
    title: "Berhasil!",
    text: "Data berhasil dihapus",
    icon: "success",
    button: "OK",
}).then(function() {
    window.location.href = "?pages=pegawai";
});
</script>
<?php
        }

    	?>


<?php }elseif($_GET['filter']=="upload"){ ?>
<section class="content-header">
    <h1>
        Form Upload Pegawai Sekolah
        <small><i>E-Rapor</i></small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <form method="POST" enctype="multipart/form-data">
                <div class="card border-danger">
                    <div class="card-header text-white">
                        <h3 class="card-title">Form Upload Pegawai Sekolah</h3>
                        <div class="float-right">
                            <a href="?pages=pegawai" class="btn btn-primary">Kembali</a>
                            <button type="submit" name="uploaddata" class="btn btn-success">Simpan Data</button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <td style="width: 30%;">Pilih File Excel</td>
                                <td>
                                    <input type="file" name="file" class="form-control " required="" autocomplete="off"
                                        autofocus="">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Format Excel Data Guru</td>
                                <td>
                                    <a href="../assets/format/format-data-guru.xls" target="_blank"
                                        class="btn btn-danger">Download Format</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        </div><!-- /.col-md-12 -->
    </div><!-- /.row -->
</section><!-- /.content -->


<?php  
        if (isset($_POST['uploaddata'])) {
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
				for ($i=4; $i<=$jumlah_baris; $i++){
				 
					// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
					$id_jabatan     = $data->val($i, 2);
					$nama     = $data->val($i, 3);
					$id_jenis_kelamin = $data->val($i,4);
					$id_agama = $data->val($i,5);
					$id_kepegawaian = $data->val($i,6);
					$id_pendidikan = $data->val($i,7);
					$id_tugas_tambahan = $data->val($i,8);
					$nip = $data->val($i, 9);
					$nuptk = $data->val($i, 10);
					$kontak = $data->val($i, 11);
					$email = htmlspecialchars(addslashes($data->val($i,12)));
					$pass  = $data->val($i, 13);
					$password = password_hash($pass, PASSWORD_DEFAULT); // Menghash password menggunakan algoritma default

					mysqli_query($mysqli,"INSERT INTO users SET jabatan='$id_jabatan', 
                    nama='$nama', 
                    kelamin='$id_jenis_kelamin', 
                    agama='$id_agama', 
                    nip='$nip', 
                    nuptk='$nuptk', 
                    kontak='$kontak', 
                    id_kepegawaian='$id_kepegawaian', 
                    ijazah='$id_pendidikan', 
                    id_tugas_tambahan='$id_tugas_tambahan', 
                    username='$email', 
                    pass='$pass', 
                    password='$password'");

				}
				// hapus kembali file .xls yang di upload tadi
				unlink($_FILES['file']['name']);
				// alihkan halaman ke index.php
				?>
<script type="text/javascript">
swal.fire({
    title: "Berhasil!",
    text: "Data berhasil diupload",
    icon: "success",
    button: "OK",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages'] ?>";
});
</script>
<?php
        }
        ?>


<?php } ?>