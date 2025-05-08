<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
    <h1>
        Kompetensi Keahlian
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card border-danger">
                <div class="card-header text-white">
                    <h3 class="card-title">Daftar Kompetensi Keahlian Sekolah</h3>
                    <div class="float-right">
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#myModalSalin">Tambah
                            Data
                        </a>
                    </div>
                </div><!-- /.card-header -->

                <div class="modal fade" id="myModalSalin" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title">Form Tambah Kompetensi Keahlian</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label>Kompetensi Keahlian</label>
                                        <input type="text" name="kompetensi" class="form-control " required="">
                                    </div>

                                    <div class="form-group">
                                        <label>Deskripsi Kompetensi Keahlian</label>
                                        <textarea name="deskripsi" class="form-control " rows="5"
                                            required=""></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Foto Banner</label>
                                        <input type="file" name="file" class="form-control " required="">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" name="Tambah" class="btn btn-success">Update
                                            Kompetensi Keahlian</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php  
                if (isset($_POST['Tambah'])) {
                    $kompetensi = $_POST['kompetensi'];
                    $deskripsi = $_POST['deskripsi'];
                    
                    $ekstensi_diperbolehkan = array('png','jpg', 'jpeg');
                    $nama = $_FILES['file']['name'];
                    $x = explode('.', $nama);
                    $ekstensi = strtolower(end($x));
                    $ukuran = $_FILES['file']['size'];
                    $file_tmp = $_FILES['file']['tmp_name'];	

                    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                        if ($ukuran < 1044070) {			
                            move_uploaded_file($file_tmp, '../../assets/img/kompetensi/'.$nama);
                            $query = mysqli_query($mysqli, "INSERT INTO kompetensi_keahlian SET kompetensi_keahlian='$kompetensi', deskripsi='$deskripsi', banner='$nama'");
                            if ($query) {
                                ?>
                <script type="text/javascript">
                alert('Berhasil');
                window.location.href = "?pages=<?php echo $_GET['pages']?>";
                </script>
                <?php
                            } else {
                                ?>
                <script type="text/javascript">
                alert('Gagal');
                window.location.href = "?pages=<?php echo $_GET['pages']?>";
                </script>
                <?php
                            }
                        } else {
                            ?>
                <script type="text/javascript">
                alert('Gambar Kegedeaan');
                window.location.href = "?pages=<?php echo $_GET['pages']?>";
                </script>
                <?php
                        }
                    } else {
                        ?>
                <script type="text/javascript">
                alert('Ekstensi Tidak Diperbolehkan');
                window.location.href = "?pages=<?php echo $_GET['pages']?>";
                </script>
                <?php
                    }
                }
                ?>
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kompetensi Keahlian</th>
                                <th>Deskripsi Kompetensi Keahlian</th>
                                <th>Foto Banner</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                            $nomor = 1;
                            $eskul = mysqli_query($mysqli, "SELECT * FROM kompetensi_keahlian ORDER BY id_kompetensi_keahlian ASC");
                            while ($reskul = mysqli_fetch_array($eskul)) {
                            ?>
                            <tr>
                                <td><?php echo $nomor++ ?></td>
                                <td><?php echo $reskul['kompetensi_keahlian'] ?></td>
                                <td><?php echo $reskul['deskripsi'] ?></td>
                                <td><img src="../../assets/img/kompetensi/<?php echo $reskul['banner']?>"
                                        alt="banner kompetensi" style="width:50%;"></td>
                                <td>
                                    <a href="?pages=kompetensi&filter=edit&dataID=<?php echo $reskul['id_kompetensi_keahlian'] ?>"
                                        class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Detail</a>

                                    <a href="?pages=<?php echo $_GET['pages']?>&filter=hapus&dataID=<?php echo $reskul['id_kompetensi_keahlian'] ?>"
                                        onclick="return confirm('Yakin ?')" class="btn btn-danger btn-xs"><i
                                            class="fa fa-trash"></i> Hapus</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.row -->
</section><!-- /.content -->


<?php }elseif($_GET['filter']=="edit"){ 
    	$kompetensi = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kompetensi_keahlian WHERE id_kompetensi_keahlian='$_GET[dataID]'"));
    	?>

<section class="content-header">
    <h1>
        Form Edit Kompetensi Sekolah
    </h1>
</section>

<section class="content-header">
    <a href="?pages=kompetensi" class="btn btn-primary btn-sm">Kembali</a>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->

            <div class="card border-danger">
                <div class="card-header text-white">
                    <h3 class="card-title">Form Edit Kompetensi Sekolah</h3>
                    <div class="float-right">
                        <!-- Optional tools -->
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <input type="hidden" name="kode" value="<?php echo $kode ?>">

                    <div class="row">
                        <div class="col-md-12">
                            <form method="POST">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Nama Kompetensi</td>
                                        <td><input type="text" name="kompetensi_keahlian" class="form-control "
                                                required="" autocomplete="off" autofocus=""
                                                value="<?php echo $kompetensi['kompetensi_keahlian'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">
                                            <button type="submit" name="editdata" class="btn btn-success">Simpan
                                                Data</button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <?php  
                        if (isset($_POST['editdata'])) {
                            $nama_kompetensi_keahlian = $_POST['kompetensi_keahlian'];

                            $simpan = mysqli_query($mysqli, "UPDATE kompetensi_keahlian SET kompetensi_keahlian='$nama_kompetensi_keahlian' WHERE id_kompetensi_keahlian='$_GET[dataID]'");
                            if ($simpan) {
                                ?>
                        <script type="text/javascript">
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = '?pages=kompetensi';
                        });
                        </script>
                        <?php
                            }
                        }
                        ?>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>&action=pembina"
                                    class="btn btn-warning">Wali Kelas</a>
                                <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo $_GET['filter'] ?>&dataID=<?php echo $_GET['dataID'] ?>&action=anggota"
                                    class="btn btn-success">Anggota</a>
                            </p>

                            <?php if(empty($_GET['action']) || $_GET['action'] == "pembina"){ ?>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Wali Kelas</th>
                                        <th>NIP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    $nomor = 1;
                                    $pembina = mysqli_query($mysqli, "SELECT * FROM pembina_eskul 
                                    JOIN users ON pembina_eskul.id_user = users.id_user
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$_GET[dataID]' ORDER BY id_pembina_eskul ASC");
                                    while ($rpembina = mysqli_fetch_array($pembina)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $nomor++ ?></td>
                                        <td><?php echo $rpembina['nama'] ?></td>
                                        <td><?php echo $rpembina['nip'] ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <?php } elseif ($_GET['action'] == "anggota"){ ?>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama PD</th>
                                        <th>NISN</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    $nomor = 1;
                                    $anggota = mysqli_query($mysqli, "SELECT * FROM siswa_eskul 
                                    JOIN siswa ON siswa_eskul.id_siswa = siswa.id_siswa
                                    JOIN jenis_kelamin ON siswa.kelamin = jenis_kelamin.id_jenis_kelamin
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$_GET[dataID]' ORDER BY nama_siswa ASC");
                                    while ($ranggota = mysqli_fetch_array($anggota)) {
                                        $datakelas = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$ranggota[id_siswa]'"));
                                        $kelas = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]'"));
                                    ?>
                                    <tr>
                                        <td><?php echo $nomor++ ?></td>
                                        <td><?php echo $ranggota['nama_siswa'] ?></td>
                                        <td><?php echo $ranggota['nisn'] ?></td>
                                        <td><?php echo $ranggota['jenis_kelamin'] ?></td>
                                        <td><?php echo $kelas['nama_kelas'] ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
</section><!-- /.content -->




<?php }elseif($_GET['filter']=="hapus"){ 

    	$hapuseskul = mysqli_query($mysqli,"DELETE FROM kompetensi_keahlian WHERE id_kompetensi_keahlian='$_GET[dataID]'");

    	if ($hapuseskul ) {
        	?><script type="text/javascript">
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages']?>";
</script><?php
        }

    	?>


<?php } ?>