<?php  
session_start();
if (empty($_SESSION['id_user']) or empty($_SESSION['jabatan'])) {
	?><script type="text/javascript">
alert('Login Terlebih Dahulu!');
window.location.href = "login.php";
</script><?php
}else{
include "../assets/excel_reader/excel_reader.php";
?>

<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
    <h1>
        Kesiswaan Sekolah
        <small><i>E-Rapor</i></small>
    </h1>
</section>


<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card border-danger">
                <div class="card-header text-white">
                    <h3 class="card-title">Daftar Kesiswaan Sekolah</h3>
                    <a href="?pages=kesiswaan&filter=<?php echo 'tambah' ?>" class="btn btn-primary ">Tambah
                        Data</a>
                    <a href="?pages=kesiswaan&filter=<?php echo 'upload' ?>" class="btn btn-warning ">Uploda
                        Data</a>
                    <a href="kesiswaan_export.php" target="_blank" class="btn btn-success ">Export</a>
                    <div class="float-left">
                        <!-- Optional tools/buttons can be added here -->
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>NIS</th>
                                <th>NISN</th>
                                <th>Jurusan</th>
                                <th>Kelamin</th>
                                <th>Agama</th>
                                <th>Tempat, Tanggal Lahir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                            $nomor=1;
                            $siswa = mysqli_query($mysqli, "SELECT * FROM siswa 
                                JOIN jenis_kelamin ON siswa.kelamin = jenis_kelamin.id_jenis_kelamin
                                JOIN agama ON siswa.agama = agama.id_agama
                                WHERE aktif='1' ORDER BY id_siswa ASC");
                            while($rsiswa = mysqli_fetch_array($siswa)) {
                            ?>
                            <tr>
                                <td><?php echo $nomor++ ?></td>
                                <td><?php echo $rsiswa['nama_siswa'] ?></td>
                                <td><?php echo $rsiswa['nis'] ?></td>
                                <td><?php echo $rsiswa['nisn'] ?></td>
                                <td><?php echo $rsiswa['jurusan'] ?></td>
                                <td><?php echo $rsiswa['jenis_kelamin'] ?></td>
                                <td><?php echo $rsiswa['agama'] ?></td>
                                <td><?php echo $rsiswa['tempat_lahir'] ?>, <?php echo $rsiswa['tanggal_lahir'] ?></td>
                                <td>
                                    <a href="?pages=kesiswaan&filter=edit&dataID=<?php echo $rsiswa['id_siswa'] ?>"
                                        class="btn btn-warning " data-toggle="tooltip" title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <a href="../assets/download/identitas-siswa.php?dataID=<?php echo $rsiswa['id_siswa'] ?>"
                                        target="_blank" class="btn btn-success " data-toggle="tooltip" title="Print">
                                        <i class="fa fa-print"></i>
                                    </a>
                                    <a href="?pages=kesiswaan&filter=hapus&dataID=<?php echo $rsiswa['id_siswa'] ?>"
                                        onclick="return confirm('Yakin ?')" class="btn btn-danger "
                                        data-toggle="tooltip" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.row -->
    </div>
</section><!-- /.content -->



<?php }elseif($_GET['filter']=="tambah"){ ?>
<section class="content-header">
    <h1>
        Form Tambah Siswa Sekolah
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
                        <h3 class="card-title">Form Tambah Kesiswaan Sekolah</h3>
                        <div class="float-left">
                            <a href="?pages=kesiswaan" class="btn btn-primary">Kembali</a>
                            <button type="submit" name="simpandata" class="btn btn-success">Simpan Data</button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <input type="hidden" name="kode" value="<?php echo $kode ?>">

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Nama Siswa</td>
                                        <td><input type="text" name="nama_siswa" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">NIS</td>
                                        <td><input type="text" name="nis" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">NISN</td>
                                        <td><input type="number" name="nisn" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Jenis Kelamin</td>
                                        <td>
                                            <select name="kelamin" class="form-control " required="">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="1">Laki-laki</option>
                                                <option value="2">Perempuan</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Agama</td>
                                        <td>
                                            <select name="agama" class="form-control " required="">
                                                <option value="">Pilih Agama</option>
                                                <option value="1">Islam</option>
                                                <option value="2">Katholik</option>
                                                <option value="3">Kristen</option>
                                                <option value="4">Hindu</option>
                                                <option value="5">Budha</option>
                                                <option value="6">Kong Hu Chu</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Tempat Lahir</td>
                                        <td><input type="text" name="tempat_lahir" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Tanggal Lahir</td>
                                        <td><input type="date" name="tanggal_lahir" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Alamat</td>
                                        <td><input type="text" name="alamat" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">No. Telepon</td>
                                        <td><input type="number" name="kontak_siswa" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Hubungan Dalam Keluarga</td>
                                        <td>
                                            <select name="hub_keluarga" class="form-control " required="">
                                                <option value="">Pilih Jenis Hubungan</option>
                                                <option value="1">Anak Kandung</option>
                                                <option value="2">Anak Tiri</option>
                                                <option value="3">Anak Angkat</option>
                                                <option value="4">Anak Piara</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Jumlah Saudara</td>
                                        <td><input type="number" name="jumlah_saudara" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Anak Ke</td>
                                        <td><input type="number" name="anak_ke" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Nama Ayah</td>
                                        <td><input type="text" name="nama_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Nama Ibu</td>
                                        <td><input type="text" name="nama_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Pekerjaan Ayah</td>
                                        <td><input type="text" name="pekerjaan_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Pekerjaan Ibu</td>
                                        <td><input type="text" name="pekerjaan_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">No. Telepon Orang Tua</td>
                                        <td><input type="number" name="kontak_ortu" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Alamat Orang Tua</td>
                                        <td><input type="text" name="alamat_ortu" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Nama Wali</td>
                                        <td><input type="text" name="nama_wali" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Pekerjaan Wali</td>
                                        <td><input type="text" name="pekerjaan_wali" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">No. Telepon Wali</td>
                                        <td><input type="text" name="kontak_wali" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Alamat Wali</td>
                                        <td><input type="text" name="alamat_wali" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Sekolah Asal</td>
                                        <td><input type="text" name="sekolah_asal" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Diterima Pada Tanggal</td>
                                        <td><input type="date" name="terima_tanggal" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Diterima Pada Kelas</td>
                                        <td>
                                            <select name="terima_kelas" class="form-control " required="">
                                                <option value="">Pilih Kelas Saat Diterima Masuk</option>
                                                <?php
                                                $kelas = mysqli_query($mysqli, "SELECT * FROM tingkat ORDER BY id_tingkat ASC");
                                                while ($rkelas = mysqli_fetch_array($kelas)) {
                                                ?>
                                                <option value="<?php echo $rkelas['id_tingkat'] ?>">
                                                    <?php echo $rkelas['tingkat'] ?></option>
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
        	$nama = $_POST['nama_siswa'];
        	$nis = $_POST['nis'];
        	$nisn = $_POST['nisn'];
        	$kelamin = $_POST['kelamin'];
        	$agama = $_POST['agama'];
        	$tempat_lahir = $_POST['tempat_lahir'];
        	$tanggal_lahir = $_POST['tanggal_lahir'];
        	$alamat = $_POST['alamat'];
        	$kontak_siswa = $_POST['kontak_siswa'];

        	$hub_keluarga = $_POST['hub_keluarga'];
        	$jumlah_saudara = $_POST['jumlah_saudara'];
        	$anak_ke = $_POST['anak_ke'];
        	$nama_ayah = $_POST['nama_ayah'];
        	$nama_ibu = $_POST['nama_ibu'];
        	$alamat_ortu = $_POST['alamat_ortu'];
        	$kontak_ortu = $_POST['kontak_ortu'];
        	$pekerjaan_ayah = $_POST['pekerjaan_ayah'];
        	$pekerjaan_ibu = $_POST['pekerjaan_ibu'];
        	$nama_wali = $_POST['nama_wali'];
        	$pekerjaan_wali = $_POST['pekerjaan_wali'];
        	$alamat_wali = $_POST['alamat_wali'];
        	$kontak_wali = $_POST['kontak_wali'];

        	$sekolah_asal = $_POST['sekolah_asal'];
        	$terima_tanggal = $_POST['terima_tanggal'];
        	$terima_kelas = $_POST['terima_kelas'];


        	$password = password_hash($tanggal_lahir, PASSWORD_DEFAULT);


        	$simpan = mysqli_query($mysqli,"INSERT INTO siswa SET nama_siswa='$nama', nis='$nis', nisn='$nisn', kelamin='$kelamin', agama='$agama', tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', alamat='$alamat', kontak_siswa='$kontak_siswa', hub_keluarga='$hub_keluarga', jumlah_saudara='$jumlah_saudara', anak_ke='$anak_ke', nama_ayah='$nama_ayah', nama_ibu='$nama_ibu', alamat_ortu='$alamat_ortu', kontak_ortu='$kontak_ortu', pekerjaan_ayah='$pekerjaan_ayah', pekerjaan_ibu='$pekerjaan_ibu', nama_wali='$nama_wali', pekerjaan_wali='$pekerjaan_wali', alamat_wali='$alamat_wali', kontak_wali='$kontak_wali', sekolah_asal='$sekolah_asal', terima_tanggal='$terima_tanggal', terima_kelas='$terima_kelas', username='$nisn', pass='$tanggal_lahir', password='$password', jenis_siswa='1', aktif='1'");
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
        	} else {
                // Tambahkan error handling
                echo "Error: " . mysqli_error($mysqli);
            }
        }
        ?>


<?php }elseif($_GET['filter']=="edit"){ 
    	$siswa = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM siswa WHERE id_siswa='$_GET[dataID]'"));

    	$hubungan_keluarga = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM hubungan_keluarga WHERE id_hubungan_keluarga='$datalulusan[hub_keluarga]'"));

    	$terima_kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE id_kelas='$datalulusan[terima_kelas]'"));
    	$tahunkelulusan = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tahun_pelajaran WHERE id_tahun_pelajaran='$datalulusan[tahun]'"));
    	$lanjutan = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tingat_lanjut WHERE id_tingkat_lanjut='$datalulusan[tingkat_lanjut]'"));

    	?>
<section class="content-header">
    <h1>
        Form Edit Anggota Kelas
        <small><i>E-Rapor</i></small>
    </h1>
</section>

<section class="content-header">
    <a href="?pages=<?php echo $_GET['pages']?>" class="btn btn-primary ">Kembali</a>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <form method="POST">
                <div class="card border-danger">
                    <div class="card-header text-white">
                        <h3 class="card-title"><?php echo $siswa['nama_siswa'] ?></h3>
                        <div class="float-right">
                            <!-- Optional tools/buttons can be added here -->
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <input type="hidden" name="kode" value="<?php echo $kode ?>">

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Nama Siswa</td>
                                        <td><input type="text" name="nama_siswa" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['nama_siswa'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">NIS</td>
                                        <td><input type="text" name="nis" class="form-control " required=""
                                                autocomplete="off" autofocus="" value="<?php echo $siswa['nis'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">NISN</td>
                                        <td><input type="number" name="nisn" class="form-control " required=""
                                                autocomplete="off" autofocus="" value="<?php echo $siswa['nisn'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Jenis Kelamin</td>
                                        <td>
                                            <select name="kelamin" class="form-control " required="">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="1" <?php if($siswa['kelamin']==1){ echo "selected";} ?>>
                                                    Laki-laki</option>
                                                <option value="2" <?php if($siswa['kelamin']==2){ echo "selected";} ?>>
                                                    Perempuan</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Agama</td>
                                        <td>
                                            <select name="agama" class="form-control " required="">
                                                <option value="">Pilih Agama</option>
                                                <option value="1" <?php if($siswa['agama']==1){ echo "selected";} ?>>
                                                    Islam</option>
                                                <option value="2" <?php if($siswa['agama']==2){ echo "selected";} ?>>
                                                    Katholik</option>
                                                <option value="3" <?php if($siswa['agama']==3){ echo "selected";} ?>>
                                                    Kristen</option>
                                                <option value="4" <?php if($siswa['agama']==4){ echo "selected";} ?>>
                                                    Hindu</option>
                                                <option value="5" <?php if($siswa['agama']==5){ echo "selected";} ?>>
                                                    Budha</option>
                                                <option value="6" <?php if($siswa['agama']==6){ echo "selected";} ?>>
                                                    Kong Hu Chu</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Tempat Lahir</td>
                                        <td><input type="text" name="tempat_lahir" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['tempat_lahir'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Tanggal Lahir</td>
                                        <td><input type="date" name="tanggal_lahir" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['tanggal_lahir'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Alamat</td>
                                        <td><input type="text" name="alamat" class="form-control " required=""
                                                autocomplete="off" autofocus="" value="<?php echo $siswa['alamat'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">No. Telepon</td>
                                        <td><input type="number" name="kontak_siswa" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['kontak_siswa'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Hubungan Dalam Keluarga</td>
                                        <td>
                                            <select name="hub_keluarga" class="form-control " required="">
                                                <option value="">Pilih Jenis Hubungan</option>
                                                <option value="1"
                                                    <?php if($siswa['hub_keluarga']==1){ echo "selected";} ?>>Anak
                                                    Kandung</option>
                                                <option value="2"
                                                    <?php if($siswa['hub_keluarga']==2){ echo "selected";} ?>>Anak Tiri
                                                </option>
                                                <option value="3"
                                                    <?php if($siswa['hub_keluarga']==3){ echo "selected";} ?>>Anak
                                                    Angkat</option>
                                                <option value="4"
                                                    <?php if($siswa['hub_keluarga']==4){ echo "selected";} ?>>Anak Piara
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Jumlah Saudara</td>
                                        <td><input type="number" name="jumlah_saudara" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['jumlah_saudara'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Anak Ke</td>
                                        <td><input type="number" name="anak_ke" class="form-control " required=""
                                                autocomplete="off" autofocus="" value="<?php echo $siswa['anak_ke'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Nama Ayah</td>
                                        <td><input type="text" name="nama_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['nama_ayah'] ?>"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Nama Ibu</td>
                                        <td><input type="text" name="nama_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['nama_ibu'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Pekerjaan Ayah</td>
                                        <td><input type="text" name="pekerjaan_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['pekerjaan_ayah'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Pekerjaan Ibu</td>
                                        <td><input type="text" name="pekerjaan_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['pekerjaan_ibu'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">No. Telepon Orang Tua</td>
                                        <td><input type="number" name="kontak_ortu" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['kontak_ortu'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Alamat Orang Tua</td>
                                        <td><input type="text" name="alamat_ortu" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['alamat_ortu'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Nama Wali</td>
                                        <td><input type="text" name="nama_wali" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['nama_wali'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Pekerjaan Wali</td>
                                        <td><input type="text" name="pekerjaan_wali" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['pekerjaan_wali'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">No. Telepon Wali</td>
                                        <td><input type="text" name="kontak_wali" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['kontak_wali'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Alamat Wali</td>
                                        <td><input type="text" name="alamat_wali" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['alamat_wali'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Sekolah Asal</td>
                                        <td><input type="text" name="sekolah_asal" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['sekolah_asal'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Diterima Pada Tanggal</td>
                                        <td><input type="date" name="terima_tanggal" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['terima_tanggal'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Diterima Pada Kelas</td>
                                        <td>
                                            <select name="terima_kelas" class="form-control " required="">
                                                <option value="">Pilih Kelas Saat Diterima Masuk</option>
                                                <?php
                                                $kelas = mysqli_query($mysqli, "SELECT * FROM tingkat ORDER BY id_tingkat ASC");
                                                while ($rkelas = mysqli_fetch_array($kelas)) {
                                                    $selkelas = $siswa['terima_kelas'] == $rkelas['id_tingkat'] ? "selected" : "";
                                                ?>
                                                <option value="<?php echo $rkelas['id_tingkat'] ?>"
                                                    <?php echo $selkelas ?>><?php echo $rkelas['tingkat'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <button type="submit" name="editdata" class="btn btn-success ">Simpan
                                                Data</button>
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
        	$nama = $_POST['nama_siswa'];
        	$nis = $_POST['nis'];
        	$nisn = $_POST['nisn'];
        	$kelamin = $_POST['kelamin'];
        	$agama = $_POST['agama'];
        	$tempat_lahir = $_POST['tempat_lahir'];
        	$tanggal_lahir = $_POST['tanggal_lahir'];
        	$alamat = $_POST['alamat'];
        	$kontak_siswa = $_POST['kontak_siswa'];

        	$hub_keluarga = $_POST['hub_keluarga'];
        	$jumlah_saudara = $_POST['jumlah_saudara'];
        	$anak_ke = $_POST['anak_ke'];
        	$nama_ayah = $_POST['nama_ayah'];
        	$nama_ibu = $_POST['nama_ibu'];
        	$alamat_ortu = $_POST['alamat_ortu'];
        	$kontak_ortu = $_POST['kontak_ortu'];
        	$pekerjaan_ayah = $_POST['pekerjaan_ayah'];
        	$pekerjaan_ibu = $_POST['pekerjaan_ibu'];
        	$nama_wali = $_POST['nama_wali'];
        	$pekerjaan_wali = $_POST['pekerjaan_wali'];
        	$alamat_wali = $_POST['alamat_wali'];
        	$kontak_wali = $_POST['kontak_wali'];

        	$sekolah_asal = $_POST['sekolah_asal'];
        	$terima_tanggal = $_POST['terima_tanggal'];
        	$terima_kelas = $_POST['terima_kelas'];


        	$password = password_hash($tanggal_lahir, PASSWORD_DEFAULT);

        	$simpan = mysqli_query($mysqli,"UPDATE siswa SET nama_siswa='$nama', nis='$nis', nisn='$nisn', kelamin='$kelamin', agama='$agama', tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', alamat='$alamat', kontak_siswa='$kontak_siswa', hub_keluarga='$hub_keluarga', jumlah_saudara='$jumlah_saudara', anak_ke='$anak_ke', nama_ayah='$nama_ayah', nama_ibu='$nama_ibu', alamat_ortu='$alamat_ortu', kontak_ortu='$kontak_ortu', pekerjaan_ayah='$pekerjaan_ayah', pekerjaan_ibu='$pekerjaan_ibu', nama_wali='$nama_wali', pekerjaan_wali='$pekerjaan_wali', alamat_wali='$alamat_wali', kontak_wali='$kontak_wali', sekolah_asal='$sekolah_asal', terima_tanggal='$terima_tanggal', terima_kelas='$terima_kelas', username='$nisn', pass='$tanggal_lahir', password='$password' WHERE id_siswa='$_GET[dataID]'");
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
        	} else {
                // Tambahkan error handling
                echo "Error: " . mysqli_error($mysqli);
            }
        }
        ?>




<?php }elseif($_GET['filter']=="hapus"){ 

    	$hapussiswa = mysqli_query($mysqli,"UPDATE siswa_kelas SET status='2' WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$_GET[dataID]'");

    	$hapussiswa2 = mysqli_query($mysqli,"UPDATE siswa SET aktif='0' WHERE id_siswa='$_GET[dataID]'");

    	if ($hapussiswa || $hapussiswa2) {
        	?>
<script type="text/javascript">
swal.fire({
    title: "Berhasil!",
    text: "Data berhasil diproses",
    icon: "success",
    button: "OK",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages'] ?>";
});
</script>
<?php
        }

    	?>


<?php }elseif($_GET['filter']=="upload"){ ?>
<section class="content-header">
    <h1>
        Form Upload Kesiswaan Sekolah
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
                        <h3 class="card-title">Form Upload Kesiswaan Sekolah</h3>
                        <div class="float-right">
                            <a href="?pages=kesiswaan" class="btn btn-primary ">Kembali</a>
                            <button type="submit" name="uploaddata" class="btn btn-success ">Simpan Data</button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <td style="width: 30%;">Pilih File Excel</td>
                                <td><input type="file" name="file" class="form-control " required="" autocomplete="off"
                                        autofocus=""></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Format Excel Data Siswa</td>
                                <td>
                                    <a href="../assets/format/format-data-siswa.xls" class="btn btn-danger ">Download
                                        Format</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        </div><!-- /.row -->
    </div>
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
        $gagal = []; // array untuk menyimpan data yang gagal diinput
        for ($i=4; $i<=$jumlah_baris; $i++){
            
            $nama = htmlspecialchars(addslashes($data->val($i,2)));
            $nis = $data->val($i, 3);
            $nisn = $data->val($i, 4);
            $kelamin = $data->val($i, 5);
            $agama = $data->val($i, 6);
            $tempat_lahir = $data->val($i, 7);
            $tanggal_lahir = $data->val($i, 8);
            $alamat = $data->val($i, 9);
            $kontak_siswa = $data->val($i, 10);

            $hub_keluarga = $data->val($i, 11);
            $jumlah_saudara = $data->val($i, 12);
            $anak_ke = $data->val($i, 13);
            $nama_ayah = htmlspecialchars(addslashes($data->val($i,14)));
            $nama_ibu = htmlspecialchars(addslashes($data->val($i,15)));
            $alamat_ortu = $data->val($i, 16);
            $kontak_ortu = $data->val($i, 17);
            $pekerjaan_ayah = $data->val($i, 18);
            $pekerjaan_ibu = $data->val($i, 19);
            $nama_wali = htmlspecialchars(addslashes($data->val($i,20)));
            $alamat_wali = $data->val($i, 22);
            $pekerjaan_wali = $data->val($i, 21);
            $kontak_wali = $data->val($i, 23);

            $sekolah_asal = mysqli_real_escape_string($mysqli, $data->val($i, 24)); // Menggunakan mysqli_real_escape_string untuk menghindari masalah tanda '
            $terima_tanggal = $data->val($i, 25);
            $terima_kelas = $data->val($i, 26);
            $jurusan = $data->val($i, 27);
            $nik = $data->val($i, 28);

            $pass  = $nisn;
            $password = password_hash($pass, PASSWORD_DEFAULT);

            //ceknisn
            $query = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM siswa WHERE aktif='1' AND nisn='$nisn'"));
            if ($query==0) {
                if (!mysqli_query($mysqli,"INSERT INTO siswa 
                SET nama_siswa='$nama', 
                nis='$nis', nisn='$nisn', 
                kelamin='$kelamin', 
                agama='$agama', 
                tempat_lahir='$tempat_lahir', 
                tanggal_lahir='$tanggal_lahir', 
                alamat='$alamat', 
                kontak_siswa='$kontak_siswa', 
                hub_keluarga='$hub_keluarga', 
                jumlah_saudara='$jumlah_saudara', 
                anak_ke='$anak_ke', 
                nama_ayah='$nama_ayah', 
                nama_ibu='$nama_ibu', 
                alamat_ortu='$alamat_ortu', 
                kontak_ortu='$kontak_ortu', 
                pekerjaan_ayah='$pekerjaan_ayah', 
                pekerjaan_ibu='$pekerjaan_ibu', 
                nama_wali='$nama_wali', 
                alamat_wali='$alamat_wali', 
                pekerjaan_wali='$pekerjaan_wali', 
                kontak_wali='$kontak_wali', 
                sekolah_asal='$sekolah_asal', 
                terima_kelas='$terima_kelas', 
                jurusan='$jurusan', 
                nik='$nik', 
                terima_tanggal='$terima_tanggal', 
                username='$nisn', 
                pass='$pass', 
                password='$password', 
                foto='', 
                jenis_siswa='1', 
                aktif='1'")) {
                    $gagal[] = "Baris $i: NISN Gagal ditambah $nisn. Detail : " . mysqli_error($mysqli);
                }
            } else {
                if (!mysqli_query($mysqli,"UPDATE siswa SET nama_siswa='$nama', 
                nis='$nis', 
                nisn='$nisn', 
                kelamin='$kelamin', 
                agama='$agama', 
                tempat_lahir='$tempat_lahir', 
                tanggal_lahir='$tanggal_lahir', 
                alamat='$alamat', 
                kontak_siswa='$kontak_siswa', 
                hub_keluarga='$hub_keluarga', 
                jumlah_saudara='$jumlah_saudara', 
                anak_ke='$anak_ke', 
                nama_ayah='$nama_ayah', 
                nama_ibu='$nama_ibu', 
                alamat_ortu='$alamat_ortu', 
                kontak_ortu='$kontak_ortu', 
                pekerjaan_ayah='$pekerjaan_ayah', 
                pekerjaan_ibu='$pekerjaan_ibu', 
                nama_wali='$nama_wali', 
                pekerjaan_wali='$pekerjaan_wali', 
                alamat_wali='$alamat_wali', 
                kontak_wali='$kontak_wali', 
                sekolah_asal='$sekolah_asal', 
                terima_tanggal='$terima_tanggal', 
                terima_kelas='$terima_kelas', 
                jurusan='$jurusan',
                nik='$nik',
                username='$nisn', 
                pass='$pass', 
                password='$password', 
                foto='', 
                jenis_siswa='1' WHERE nisn='$nisn'")) {
                    $gagal[] = "Baris $i: NISN Gagal diupdate $nisn. Detail : " . mysqli_error($mysqli);
                }
            }

        }
        // hapus kembali file .xls yang di upload tadi
        unlink($_FILES['file']['name']);
        // alihkan halaman ke index.php
        ?>
<script type="text/javascript">
let message = "Berhasil Mengupload <?php echo $jumlah_baris-3?> Data";
<?php if (!empty($gagal)) { ?>
message += "\ndan Data yang gagal diinput:\n<?php echo implode('\n', $gagal); ?>";
<?php } ?>
swal.fire({
    title: "Berhasil!",
    text: message,
    icon: "success",
    width: '600px', // Perbesar modal sweet alert
    padding: '3em', // Tambahkan padding untuk memperbesar modal
}).then(function() {
    window.location.href = "?pages=kesiswaan";
});
</script>
<?php } ?>

<?php } ?>

<?php } ?>