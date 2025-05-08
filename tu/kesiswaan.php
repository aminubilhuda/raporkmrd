<?php  
require '../vendor/autoload.php'; // Include PhpSpreadsheet autoloader

use PhpOffice\PhpSpreadsheet\IOFactory;
// include "../assets/excel_reader/excel_reader.php";
?>

<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
    <h1>
        Kesiswaan Sekolah
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
                                <th>Kelas</th>
                                <th>Jurusan</th>
                                <th>Terima Kelas</th>
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
                                JOIN kompetensi_keahlian ON siswa.jurusan=kompetensi_keahlian.id_kompetensi_keahlian
                                -- LEFT JOIN siswa_kelas ON siswa.id_siswa = siswa_kelas.id_siswa
                                -- LEFT JOIN kelas ON siswa_kelas.id_kelas = kelas.id_kelas
                                WHERE aktif='1' ORDER BY siswa.id_siswa ASC");
                            while($rsiswa = mysqli_fetch_array($siswa)) {
                            ?>
                            <tr>
                                <td><?php echo $nomor++ ?></td>
                                <td><?php echo $rsiswa['nama_siswa'] ?></td>
                                <td><?php echo $rsiswa['nis'] ?></td>
                                <td><?php echo $rsiswa['nisn'] ?></td>
                                <td><?php echo ($rsiswa['nama_kelas']) =="" ? "Belum Bergabung Di Anggota Kelas" : "$rsiswa[nama_kelas]" ?>
                                </td>
                                <td><?php echo $rsiswa['kompetensi_keahlian'] ?></td>
                                <td><?php echo $rsiswa['terima_kelas'] ?></td>
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
        Form Tambah Siswa sekolah
    </h1>
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
                        <h3 class="card-title">Tambah Siswa</h3>
                        <div class="float-right">
                            <!-- Optional tools/buttons can be added here -->
                            <button type="submit" name="simpandata" class="btn btn-success ">Simpan
                                Data</button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <input type="hidden" name="kode" value="<?php echo $kode ?>">

                        <div class="row">
                            <div class="col-md-4">
                                <h4>Biodata</h4>

                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td colspan="2" class="table-info"> <b>
                                                <h4>Data Siswa</h4>
                                            </b></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Nama Siswa</td>
                                        <td><input type="text" name="nama_siswa" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">NIK Siswa</td>
                                        <td><input type="text" name="nik_pd" class="form-control " required=""
                                                autocomplete="off" autofocus="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">No KK</td>
                                        <td><input type="text" name="nkk" class="form-control " required=""
                                                autocomplete="off" autofocus="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">NISN</td>
                                        <td><input type="number" name="nisn" class="form-control " required=""
                                                autocomplete="off" autofocus="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">NIS</td>
                                        <td><input type="text" name="nis" class="form-control " required=""
                                                autocomplete="off" autofocus="">
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
                                        <td style="width: 30%;">Jenis Kelamin</td>
                                        <td>
                                            <select name="kelamin" class="form-control " required="">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="1">
                                                    Laki-laki</option>
                                                <option value="2">
                                                    Perempuan</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Agama</td>
                                        <td>
                                            <select name="agama" class="form-control " required="">
                                                <option value="">Pilih Agama</option>
                                                <option value="1">
                                                    Islam</option>
                                                <option value="2">
                                                    Katholik</option>
                                                <option value="3">
                                                    Kristen</option>
                                                <option value="4">
                                                    Hindu</option>
                                                <option value="5">
                                                    Budha</option>
                                                <option value="6">
                                                    Kong Hu Chu</option>
                                            </select>
                                        </td>
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
                                                <option value="1">Anak
                                                    Kandung</option>
                                                <option value="2">Anak Tiri
                                                </option>
                                                <option value="3">Anak
                                                    Angkat</option>
                                                <option value="4">Anak Piara
                                                </option>
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
                                                autocomplete="off" autofocus="">
                                        </td>
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
                                        <td style="width: 30%;">Diterima Pada Tingkat</td>
                                        <td>
                                            <select name="terima_tingkat" class="form-control " required="">
                                                <option value="">Pilih Kelas Saat Diterima Masuk</option>
                                                <?php
                                                $kelas = mysqli_query($mysqli, "SELECT * FROM tingkat ORDER BY id_tingkat ASC");
                                                while ($rkelas = mysqli_fetch_array($kelas)) { ?>
                                                <option value="<?php echo $rkelas['id_tingkat'] ?>">
                                                    <?php echo $rkelas['tingkat'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Jurusan</td>
                                        <td><select name="jurusan" class="form-control " required="">
                                                <option value="">Pilih Jurusan</option>
                                                <?php
                                            // Hanya mengambil data dari tabel kompetensi_keahlian.
                                            $jurusan = mysqli_query($mysqli, "SELECT * FROM kompetensi_keahlian ORDER BY kompetensi_keahlian ASC");

                                            while ($rjurusan = mysqli_fetch_array($jurusan)) {
                                            ?>
                                                <option value="<?php echo $rjurusan['id_kompetensi_keahlian'] ?>">
                                                    <?php echo $rjurusan['kompetensi_keahlian']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Terima Kelas</td>
                                        <td><input type="text" name="terima_kelas" class="form-control " required=""
                                                autocomplete="off" autofocus="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Alamat</td>
                                        <td><input type="text" name="alamat" class="form-control " required=""
                                                autocomplete="off" autofocus="">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <h4>Data Orang Tua</h4>
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td colspan="2" class="table-info"> <b>
                                                <h4>Data Ayah</h4>
                                            </b></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Nama Ayah</td>
                                        <td><input type="text" name="nama_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Nik Ayah</td>
                                        <td><input type="text" name="nik_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Tahun Lahir Ayah</td>
                                        <td><input type="text" name="tahun_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Pendidikan Ayah</td>
                                        <td><input type="text" name="pendidikan_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">No. Telepon Ayah</td>
                                        <td><input type="text" name="kontak_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Pekerjaan Ayah</td>
                                        <td><input type="text" name="pekerjaan_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="table-info"> <b>
                                                <h4>Data Ibu</h4>
                                            </b></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Nama Ibu</td>
                                        <td><input type="text" name="nama_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Nik Ibu</td>
                                        <td><input type="text" name="nik_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Tahun Lahir Ibu</td>
                                        <td><input type="text" name="tahun_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Pendidikan Ibu</td>
                                        <td><input type="text" name="pendidikan_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">No. Telepon Ayah</td>
                                        <td><input type="text" name="kontak_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Pekerjaan Ibu</td>
                                        <td><input type="text" name="pekerjaan_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Alamat Orang Tua</td>
                                        <td><input type="text" name="alamat_orang_tua" class="form-control " required=""
                                                autocomplete="off" autofocus=""></td>
                                    </tr>

                                </table>
                            </div>
                            <div class="col-md-4">
                                <h4>Data Wali</h4>
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td colspan="2" class="table-info"> <b>
                                                <h4>Data Wali</h4>
                                            </b></td>
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
    // Ambil data dari form
    $nama_siswa = $_POST['nama_siswa'];
    $nik_pd = $_POST['nik_pd'];
    $nkk = $_POST['nkk'];
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
    $sekolah_asal = $_POST['sekolah_asal'];
    $terima_tanggal = $_POST['terima_tanggal'];
    $terima_tingkat = $_POST['terima_tingkat'];
    $terima_kelas = $_POST['terima_kelas'];
    $jurusan = $_POST['jurusan'];

    // Data orang tua
    $nama_ayah = $_POST['nama_ayah'];
    $nik_ayah = $_POST['nik_ayah'];
    $tahun_ayah = $_POST['tahun_ayah'];
    $pendidikan_ayah = $_POST['pendidikan_ayah'];
    $kontak_ayah = $_POST['kontak_ayah'];
    $pekerjaan_ayah = $_POST['pekerjaan_ayah'];

    $nama_ibu = $_POST['nama_ibu'];
    $nik_ibu = $_POST['nik_ibu'];
    $tahun_ibu = $_POST['tahun_ibu'];
    $pendidikan_ibu = $_POST['pendidikan_ibu'];
    $kontak_ibu = $_POST['kontak_ibu'];
    $pekerjaan_ibu = $_POST['pekerjaan_ibu'];
    $alamat_orang_tua = $_POST['alamat_orang_tua'];

    // Data wali
    $nama_wali = $_POST['nama_wali'];
    $pekerjaan_wali = $_POST['pekerjaan_wali'];
    $kontak_wali = $_POST['kontak_wali'];
    $alamat_wali = $_POST['alamat_wali'];

    // Hash password berdasarkan tanggal lahir
    $password = password_hash($tanggal_lahir, PASSWORD_DEFAULT);

    // Query menggunakan INSERT INTO ... SET
    $query = "
        INSERT INTO siswa SET 
            nama_siswa = '$nama_siswa',
            nik_pd = '$nik_pd',
            nkk = '$nkk',
            nisn = '$nisn',
            nis = '$nis',
            tempat_lahir = '$tempat_lahir',
            tanggal_lahir = '$tanggal_lahir',
            kelamin = '$kelamin',
            agama = '$agama',
            kontak_siswa = '$kontak_siswa',
            hub_keluarga = '$hub_keluarga',
            jumlah_saudara = '$jumlah_saudara',
            anak_ke = '$anak_ke',
            nama_ayah = '$nama_ayah',
            nik_ayah = '$nik_ayah',
            tahun_ayah = '$tahun_ayah',
            pendidikan_ayah = '$pendidikan_ayah',
            pekerjaan_ayah = '$pekerjaan_ayah',
            kontak_ayah = '$kontak_ayah',
            nama_ibu = '$nama_ibu',
            nik_ibu = '$nik_ibu',
            tahun_ibu = '$tahun_ibu',
            pendidikan_ibu = '$pendidikan_ibu',
            pekerjaan_ibu = '$pekerjaan_ibu',
            kontak_ibu = '$kontak_ibu',
            alamat = '$alamat',
            alamat_orang_tua = '$alamat_orang_tua',
            nama_wali = '$nama_wali',
            alamat_wali = '$alamat_wali',
            pekerjaan_wali = '$pekerjaan_wali',
            kontak_wali = '$kontak_wali',
            terima_tingkat = '$terima_tingkat',
            jurusan = '$jurusan',
            sekolah_asal = '$sekolah_asal',
            terima_tanggal = '$terima_tanggal',
            terima_kelas = '$terima_kelas',
            username = '$nisn',
            pass = '$tanggal_lahir',
            password = '$password',
            jenis_siswa = 1,
            aktif = 1
    ";

    // Eksekusi query dan cek apakah berhasil
    $simpan = mysqli_query($mysqli, $query);

    if ($simpan) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data berhasil disimpan',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location.href = '?pages=" . $_GET['pages'] . "';
            });
        </script>";
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }
}
?>




<?php }elseif($_GET['filter']=="edit"){ 
    	$siswa = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM siswa WHERE id_siswa='$_GET[dataID]'"));

    	$hubungan_keluarga = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM hubungan_keluarga WHERE id_hubungan_keluarga='$datalulusan[hub_keluarga]'"));

    	$terima_tingkat = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE id_kelas='$datalulusan[terima_tingkat]'"));
    	$tahunkelulusan = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tahun_pelajaran WHERE id_tahun_pelajaran='$datalulusan[tahun]'"));
    	$lanjutan = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tingat_lanjut WHERE id_tingkat_lanjut='$datalulusan[tingkat_lanjut]'"));

    	?>
<section class="content-header">
    <h1>
        Form Edit Siswa
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
                            <button type="submit" name="editdata" class="btn btn-success ">Simpan
                                Data</button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <input type="hidden" name="kode" value="<?php echo $kode ?>">

                        <div class="row">
                            <div class="col-md-4">
                                <h4>Biodata</h4>

                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td colspan="2" class="table-info"> <b>
                                                <h4>Data Siswa</h4>
                                            </b></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Nama Siswa</td>
                                        <td><input type="text" name="nama_siswa" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['nama_siswa'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">NIK Siswa</td>
                                        <td><input type="text" name="nik_pd" class="form-control " required=""
                                                autocomplete="off" autofocus="" value="<?php echo $siswa['nik_pd'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">No KK</td>
                                        <td><input type="text" name="nkk" class="form-control " required=""
                                                autocomplete="off" autofocus="" value="<?php echo $siswa['nkk'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">NISN</td>
                                        <td><input type="number" name="nisn" class="form-control " required=""
                                                autocomplete="off" autofocus="" value="<?php echo $siswa['nisn'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">NIS</td>
                                        <td><input type="text" name="nis" class="form-control " required=""
                                                autocomplete="off" autofocus="" value="<?php echo $siswa['nis'] ?>">
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
                                        <td style="width: 30%;">Diterima Pada Tingkat</td>
                                        <td>
                                            <select name="terima_tingkat" class="form-control " required="">
                                                <option value="">Pilih Kelas Saat Diterima Masuk</option>
                                                <?php
                                                $kelas = mysqli_query($mysqli, "SELECT * FROM tingkat ORDER BY id_tingkat ASC");
                                                while ($rkelas = mysqli_fetch_array($kelas)) {
                                                    $selkelas = $siswa['terima_tingkat'] == $rkelas['id_tingkat'] ? "selected" : "";
                                                ?>
                                                <option value="<?php echo $rkelas['id_tingkat'] ?>"
                                                    <?php echo $selkelas ?>><?php echo $rkelas['tingkat'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Jurusan</td>
                                        <td><select name="jurusan" class="form-control " required="">
                                                <option value="">Pilih Jurusan</option>
                                                <?php
                                            // Hanya mengambil data dari tabel kompetensi_keahlian.
                                            $jurusan = mysqli_query($mysqli, "SELECT * FROM kompetensi_keahlian ORDER BY kompetensi_keahlian ASC");

                                            while ($rjurusan = mysqli_fetch_array($jurusan)) {
                                                // Cek apakah jurusan siswa cocok dengan jurusan yang diambil dari kompetensi_keahlian
                                                $seljurusan = $siswa['jurusan'] == $rjurusan['id_kompetensi_keahlian'] ? "selected" : "";
                                            ?>
                                                <option value="<?php echo $rjurusan['id_kompetensi_keahlian'] ?>"
                                                    <?php echo $seljurusan; ?>>
                                                    <?php echo $rjurusan['kompetensi_keahlian']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Terima Kelas</td>
                                        <td><input type="text" name="terima_kelas" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['terima_kelas'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Alamat</td>
                                        <td><input type="text" name="alamat" class="form-control " required=""
                                                autocomplete="off" autofocus="" value="<?php echo $siswa['alamat'] ?>">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <h4>Data Orang Tua</h4>
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td colspan="2" class="table-info"> <b>
                                                <h4>Data Ayah</h4>
                                            </b></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Nama Ayah</td>
                                        <td><input type="text" name="nama_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['nama_ayah'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Nik Ayah</td>
                                        <td><input type="text" name="nik_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['nik_ayah'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Tahun Lahir Ayah</td>
                                        <td><input type="text" name="tahun_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['tahun_ayah'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Pendidikan Ayah</td>
                                        <td><input type="text" name="pendidikan_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['pendidikan_ayah'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">No. Telepon Ayah</td>
                                        <td><input type="text" name="kontak_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['kontak_ayah'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Pekerjaan Ayah</td>
                                        <td><input type="text" name="pekerjaan_ayah" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['pekerjaan_ayah'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="table-info"> <b>
                                                <h4>Data Ibu</h4>
                                            </b></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Nama Ibu</td>
                                        <td><input type="text" name="nama_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['nama_ibu'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Nik Ibu</td>
                                        <td><input type="text" name="nik_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus="" value="<?php echo $siswa['nik_ibu'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Tahun Lahir Ibu</td>
                                        <td><input type="text" name="tahun_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['tahun_ibu'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Pendidikan Ibu</td>
                                        <td><input type="text" name="pendidikan_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['pendidikan_ibu'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">No. Telepon Ayah</td>
                                        <td><input type="text" name="kontak_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['kontak_ibu'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Pekerjaan Ibu</td>
                                        <td><input type="text" name="pekerjaan_ibu" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['pekerjaan_ibu'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Alamat Orang Tua</td>
                                        <td><input type="text" name="alamat_orang_tua" class="form-control " required=""
                                                autocomplete="off" autofocus=""
                                                value="<?php echo $siswa['alamat_orang_tua'] ?>"></td>
                                    </tr>

                                </table>
                            </div>
                            <div class="col-md-4">
                                <h4>Data Wali</h4>
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td colspan="2" class="table-info"> <b>
                                                <h4>Data Wali</h4>
                                            </b></td>
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
        // Ambil data dari input form
        $nama = $_POST['nama_siswa'];
        $nik_pd = $_POST['nik_pd'];
        $nkk = $_POST['nkk'];
        $nisn = $_POST['nisn'];
        $nis = $_POST['nis'];
        $tempat_lahir = $_POST['tempat_lahir'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $kelamin = $_POST['kelamin'];
        $agama = $_POST['agama'];
        $alamat = $_POST['alamat'];
        $kontak_siswa = $_POST['kontak_siswa'];

        $hub_keluarga = $_POST['hub_keluarga'];
        $jumlah_saudara = $_POST['jumlah_saudara'];
        $anak_ke = $_POST['anak_ke'];

        // Data orang tua
        $nama_ayah = $_POST['nama_ayah'];
        $nik_ayah = $_POST['nik_ayah'];
        $tahun_ayah = $_POST['tahun_ayah'];
        $pendidikan_ayah = $_POST['pendidikan_ayah'];
        $pekerjaan_ayah = $_POST['pekerjaan_ayah'];
        $kontak_ayah = $_POST['kontak_ayah'];

        $nama_ibu = $_POST['nama_ibu'];
        $nik_ibu = $_POST['nik_ibu'];
        $tahun_ibu = $_POST['tahun_ibu'];
        $pendidikan_ibu = $_POST['pendidikan_ibu'];
        $pekerjaan_ibu = $_POST['pekerjaan_ibu'];
        $kontak_ibu = $_POST['kontak_ibu'];
        
        // Alamat orang tua
        $alamat_orang_tua = $_POST['alamat_orang_tua'];
        
        // Data wali
        $nama_wali = $_POST['nama_wali'];
        $alamat_wali = $_POST['alamat_wali'];
        $pekerjaan_wali = $_POST['pekerjaan_wali'];
        $kontak_wali = $_POST['kontak_wali'];

        // Data sekolah
        $terima_tingkat = $_POST['terima_tingkat'];
        $jurusan = $_POST['jurusan'];
        $sekolah_asal = $_POST['sekolah_asal'];
        $terima_tanggal = $_POST['terima_tanggal'];
        $terima_kelas = $_POST['terima_kelas'];

        // Buat password dari tanggal lahir
        $password = password_hash($tanggal_lahir, PASSWORD_DEFAULT);

        // Query untuk update data siswa
        $simpan = mysqli_query($mysqli, "UPDATE siswa SET 
            nama_siswa='$nama', 
            nik_pd='$nik_pd',
            nkk='$nkk',
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
            nik_ayah='$nik_ayah',
            tahun_ayah='$tahun_ayah', 
            pendidikan_ayah='$pendidikan_ayah', 
            pekerjaan_ayah='$pekerjaan_ayah', 
            kontak_ayah='$kontak_ayah', 
            nama_ibu='$nama_ibu', 
            nik_ibu='$nik_ibu',
            tahun_ibu='$tahun_ibu',
            pendidikan_ibu='$pendidikan_ibu',
            pekerjaan_ibu='$pekerjaan_ibu',
            kontak_ibu='$kontak_ibu',
            alamat_orang_tua='$alamat_orang_tua',
            nama_wali='$nama_wali', 
            pekerjaan_wali='$pekerjaan_wali', 
            alamat_wali='$alamat_wali', 
            kontak_wali='$kontak_wali', 
            sekolah_asal='$sekolah_asal', 
            terima_tanggal='$terima_tanggal', 
            terima_tingkat='$terima_tingkat', 
            terima_kelas='$terima_kelas', 
            jurusan='$jurusan', 
            username='$nisn', 
            pass='$tanggal_lahir', 
            password='$password' 
            WHERE id_siswa='$_GET[dataID]'");

        // Cek apakah data berhasil disimpan
        if ($simpan) {
?>
<script type="text/javascript">
swal.fire({
    title: "Berhasil!",
    text: "Data berhasil disimpan",
    icon: "success",
    button: "OK",
}).then(function() {
    window.location.href =
        "?pages=<?php echo $_GET['pages'] ?>&filter=<?=$_GET['filter']?>&dataID=<?=$_GET['dataID']?>";
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
    $target = basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $target);
    
    // Give permission to read the uploaded file
    chmod($_FILES['file']['name'], 0777);
    
    // Load the spreadsheet file
    $spreadsheet = IOFactory::load($_FILES['file']['name']);
    $sheet = $spreadsheet->getActiveSheet();
    $jumlah_baris = $sheet->getHighestRow(); // Get the highest row number

    // Default counts for successful and failed imports
    $berhasil = 0;
    $gagal = []; // Array for storing failed inputs
    for ($i = 2; $i <= $jumlah_baris; $i++) {
        $nama_pd = htmlspecialchars(addslashes($sheet->getCell("B$i")->getValue()));
        $nik_pd = $sheet->getCell("C$i")->getValue();
        $nkk = $sheet->getCell("D$i")->getValue();
        $nisn = $sheet->getCell("E$i")->getValue();
        $nis = $sheet->getCell("F$i")->getValue();
        $tempat_lahir = $sheet->getCell("G$i")->getValue();
        $tanggal_lahir = $sheet->getCell("H$i")->getValue();
        $kelamin = $sheet->getCell("I$i")->getValue();
        $agama = $sheet->getCell("J$i")->getValue();
        $kontak_siswa = $sheet->getCell("K$i")->getValue();
        $hub_keluarga = $sheet->getCell("L$i")->getValue();
        $jumlah_saudara = $sheet->getCell("M$i")->getValue();
        $anak_ke = $sheet->getCell("N$i")->getValue();
        $nama_ayah = htmlspecialchars(addslashes($sheet->getCell("O$i")->getValue()));
        $nik_ayah = $sheet->getCell("P$i")->getValue();
        $tahun_ayah = $sheet->getCell("Q$i")->getValue();
        $pendidikan_ayah = $sheet->getCell("R$i")->getValue();
        $pekerjaan_ayah = $sheet->getCell("S$i")->getValue();
        $kontak_ayah = $sheet->getCell("T$i")->getValue();
        $nama_ibu = htmlspecialchars(addslashes($sheet->getCell("U$i")->getValue()));
        $nik_ibu = $sheet->getCell("V$i")->getValue();
        $tahun_ibu = $sheet->getCell("W$i")->getValue();
        $pendidikan_ibu = $sheet->getCell("X$i")->getValue();
        $pekerjaan_ibu = $sheet->getCell("Y$i")->getValue();
        $kontak_ibu = $sheet->getCell("Z$i")->getValue();
        $alamat = htmlspecialchars(addslashes($sheet->getCell("AA$i")->getValue()));
        $alamat_orang_tua = htmlspecialchars(addslashes($sheet->getCell("AB$i")->getValue()));
        $nama_wali = htmlspecialchars(addslashes($sheet->getCell("AC$i")->getValue()));
        $alamat_wali = $sheet->getCell("AD$i")->getValue();
        $pekerjaan_wali = $sheet->getCell("AE$i")->getValue();
        $kontak_wali = $sheet->getCell("AF$i")->getValue();
        $terima_tingkat = $sheet->getCell("AG$i")->getValue();
        $jurusan = $sheet->getCell("AH$i")->getValue();
        $sekolah_asal = mysqli_real_escape_string($mysqli, $sheet->getCell("AI$i")->getValue());
        $terima_tanggal = $sheet->getCell("AJ$i")->getValue();
        $terima_kelas = $sheet->getCell("AK$i")->getValue();

        $pass = $nisn;
        $password = password_hash($pass, PASSWORD_DEFAULT);

        // Check for NISN
        $query = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM siswa WHERE aktif='1' AND nisn='$nisn'"));
        if ($query == 0) {
            if (!mysqli_query($mysqli, "INSERT INTO siswa 
            SET nama_siswa='$nama_pd', 
            nik_pd='$nik_pd', 
            nkk='$nkk', 
            nisn='$nisn', 
            nis='$nis', 
            tempat_lahir='$tempat_lahir', 
            tanggal_lahir='$tanggal_lahir', 
            kelamin='$kelamin', 
            agama='$agama', 
            kontak_siswa='$kontak_siswa', 
            hub_keluarga='$hub_keluarga', 
            jumlah_saudara='$jumlah_saudara', 
            anak_ke='$anak_ke', 
            nama_ayah='$nama_ayah', 
            nik_ayah='$nik_ayah', 
            tahun_ayah='$tahun_ayah', 
            pendidikan_ayah='$pendidikan_ayah', 
            pekerjaan_ayah='$pekerjaan_ayah', 
            kontak_ayah='$kontak_ayah', 
            nama_ibu='$nama_ibu', 
            nik_ibu='$nik_ibu', 
            tahun_ibu='$tahun_ibu', 
            pendidikan_ibu='$pendidikan_ibu', 
            pekerjaan_ibu='$pekerjaan_ibu', 
            kontak_ibu='$kontak_ibu',
            alamat='$alamat', 
            alamat_orang_tua='$alamat_orang_tua', 
            nama_wali='$nama_wali', 
            alamat_wali='$alamat_wali', 
            pekerjaan_wali='$pekerjaan_wali', 
            kontak_wali='$kontak_wali', 
            terima_tingkat='$terima_tingkat', 
            jurusan='$jurusan',
            sekolah_asal='$sekolah_asal', 
            terima_tanggal='$terima_tanggal', 
            terima_kelas='$terima_kelas', 
            username='$nisn', 
            pass='$pass', 
            password='$password', 
            foto='', 
            jenis_siswa='1', 
            aktif='1'")) {
                $gagal[] = "Baris $i: NISN Gagal ditambah $nisn. Detail : " . mysqli_error($mysqli);
            }
        } else {
            if (!mysqli_query($mysqli, "UPDATE siswa 
            SET nama_siswa='$nama_pd', 
            nik_pd='$nik_pd', 
            nkk='$nkk', 
            nis='$nis', 
            tempat_lahir='$tempat_lahir', 
            tanggal_lahir='$tanggal_lahir', 
            kelamin='$kelamin', 
            agama='$agama', 
            kontak_siswa='$kontak_siswa', 
            hub_keluarga='$hub_keluarga', 
            jumlah_saudara='$jumlah_saudara', 
            anak_ke='$anak_ke', 
            nama_ayah='$nama_ayah', 
            nik_ayah='$nik_ayah', 
            tahun_ayah='$tahun_ayah', 
            pendidikan_ayah='$pendidikan_ayah', 
            pekerjaan_ayah='$pekerjaan_ayah', 
            kontak_ayah='$kontak_ayah', 
            nama_ibu='$nama_ibu', 
            nik_ibu='$nik_ibu', 
            tahun_ibu='$tahun_ibu', 
            pendidikan_ibu='$pendidikan_ibu', 
            pekerjaan_ibu='$pekerjaan_ibu', 
            kontak_ibu='$kontak_ibu',
            alamat='$alamat', 
            alamat_orang_tua='$alamat_orang_tua', 
            nama_wali='$nama_wali', 
            alamat_wali='$alamat_wali', 
            pekerjaan_wali='$pekerjaan_wali', 
            kontak_wali='$kontak_wali', 
            terima_tingkat='$terima_tingkat', 
            jurusan='$jurusan',
            sekolah_asal='$sekolah_asal', 
            terima_tanggal='$terima_tanggal', 
            terima_kelas='$terima_kelas', 
            username='$nisn', 
            pass='$pass', 
            password='$password', 
            foto='', 
            jenis_siswa='1' 
            WHERE nisn='$nisn'")) {
                $gagal[] = "Baris $i: NISN Gagal diupdate $nisn. Detail : " . mysqli_error($mysqli);
            }
        }
    }
    
    // Delete the uploaded XLS file
    unlink($_FILES['file']['name']);
    // Redirect to index.php
    ?>
<script type="text/javascript">
let message = "Berhasil Mengupload <?php echo $jumlah_baris - 1 ?> Data";
<?php if (!empty($gagal)) { ?>
message += "\ndan Data yang gagal diinput:\n<?php echo implode('\n', $gagal); ?>";
<?php } ?>
swal.fire({
    title: "Berhasil!",
    text: message,
    icon: "success",
    width: '600px', // Increase sweet alert modal width
    padding: '3em', // Add padding for a larger modal
}).then(function() {
    window.location.href = "?pages=kesiswaan";
});
</script>
<?php
}
?>


<?php } ?>