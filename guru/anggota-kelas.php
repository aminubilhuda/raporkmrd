<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
    <h1>
        Anggota Kelas
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card border-danger">
                <div class="card-header bg-danger">
                    <h3 class="card-title text-white">Daftar Rombongan Belajar Sekolah</h3>
                    <div class="float-right">
                        <!-- Tempat untuk button atau tools jika diperlukan -->
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered table-sm" data-page-length="50">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">NIS</th>
                                <th scope="col" class="text-center">NISN</th>
                                <th scope="col">Nama Peserta Didik</th>
                                <th scope="col">Jenis Kelamin</th>
                                <th scope="col">Agama</th>
                                <th scope="col">Tempat, Tanggal Lahir</th>
                                <th scope="col">Kontak PD</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                                $nomor=1;
                                $kelas = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
                                JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                                JOIN jenis_kelamin ON siswa.kelamin = jenis_kelamin.id_jenis_kelamin
                                JOIN agama ON siswa.agama = agama.id_agama
                                WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND aktif='1' ORDER BY nama_siswa ASC");
                                while($rkelas = mysqli_fetch_array($kelas)){
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $nomor++ ?></td>
                                <td class="text-center"><?php echo $rkelas['nis'] ?></td>
                                <td class="text-center"><?php echo $rkelas['nisn'] ?></td>
                                <td><?php echo $rkelas['nama_siswa'] ?></td>
                                <td><?php echo $rkelas['jenis_kelamin'] ?></td>
                                <td><?php echo $rkelas['agama'] ?></td>
                                <td><?php echo $rkelas['tempat_lahir'].", ".$rkelas['tanggal_lahir'] ?></td>
                                <td><?php echo $rkelas['kontak'] ?></td>
                                <td class="text-center">
                                    <a href="../assets/download/identitas-siswa.php?dataID=<?php echo $rkelas['id_siswa'] ?>"
                                        target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print"></i></a>
                                    <a href="?pages=<?php echo $_GET['pages']?>&filter=<?php echo 'edit' ?>&dataID=<?php echo $rkelas['id_siswa'] ?>"
                                        class="btn btn-warning btn-sm">Detail</a>
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




<?php }elseif($_GET['filter']=="edit"){ 
    	$siswa = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM siswa WHERE id_siswa='$_GET[dataID]'"));
    	?>
<section class="content-header">
    <h1>
        Form Edit Anggota Kelas
    </h1>
</section>

<section class="content-header">
    <a href="?pages=<?php echo $_GET['pages']?>" class="btn btn-primary btn-sm">Kembali</a>
</section>
<br>

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
                                        <td>
                                            <select name="jurusan" class="form-control " required="">
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




<?php } ?>