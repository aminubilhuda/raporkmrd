<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
    <h1>
        Mata Pelajaran Sekolah
        <small><i>E-Rapor</i></small>
    </h1>
</section>

<section class="content-header">
    <a href="?pages=mapel&filter=<?php echo 'tambah' ?>" class="btn btn-primary">Tambah Data</a>
</section>



<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card border-danger">
                <div class="card-header text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Mata Pelajaran Sekolah</h3>
                    <div class="card-tools">
                        <!-- Additional buttons can be placed here if needed -->
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table id="example1" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Mata Pelajaran</th>
                                <th>Kode</th>
                                <th>Kelompok</th>
                                <th>Urut</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                      			$nomor=1;
                      			$mapel = mysqli_query($mysqli,"SELECT * FROM mapel ORDER BY urut ASC");
                      			while($rmapel = mysqli_fetch_array($mapel)){
                      				$kelompok = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelompok_mapel WHERE id_kelompok='$rmapel[id_kelompok]'"));
                      			?>
                            <tr>
                                <td><?php echo $nomor++ ?></td>
                                <td><?php echo $rmapel['nama_mapel'] ?></td>
                                <td><?php echo $rmapel['s_mapel'] ?></td>
                                <td><?php echo $kelompok['kelompok'] ?></td>
                                <td><?php echo $rmapel['urut'] ?></td>
                                <td>
                                    <a href="?pages=mapel&filter=<?php echo 'edit' ?>&dataID=<?php echo $rmapel['id_mapel'] ?>"
                                        class="btn btn-warning "><i class="fas fa-pencil-alt"></i></a>

                                    <a href="?pages=mapel&filter=<?php echo 'hapus' ?>&dataID=<?php echo $rmapel['id_mapel'] ?>"
                                        onclick="return confirm('Yakin ?')" class="btn btn-danger "><i
                                            class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.col-md-12 -->
    </div><!-- /.row -->
</section><!-- /.content -->



<?php }elseif($_GET['filter']=="tambah"){ ?>
<section class="content-header">
    <h1>
        Form Tambah Mata Pelajaran Sekolah
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
                        <h3 class="card-title">Form Tambah Mata Pelajaran Sekolah</h3>
                        <div>
                            <a href="?pages=mapel" class="btn btn-primary ">Kembali</a>
                            <button type="submit" name="simpandata" class="btn btn-success ">Simpan Data</button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <input type="hidden" name="kode" value="<?php echo $kode ?>">

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Nama Mata Pelajaran</td>
                                        <td><input type="text" name="nama_mapel" class="form-control " required
                                                autocomplete="off" autofocus></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Kategori</td>
                                        <td>
                                            <select name="id_kelompok" class="form-control " required>
                                                <option value="">Pilih Kelompok Mapel</option>
                                                <?php  
		                      					$kelompok = mysqli_query($mysqli,"SELECT * FROM kelompok_mapel ORDER BY id_kelompok ASC");
		                      					while ($rkelompok = mysqli_fetch_array($kelompok)) {
		                      					?>
                                                <option value="<?php echo $rkelompok['id_kelompok'] ?>">
                                                    <?php echo $rkelompok['kelompok'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Kode Mapel</td>
                                        <td><input type="text" name="s_mapel" class="form-control " required
                                                autocomplete="off" autofocus></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Urutan Mapel</td>
                                        <td><input type="number" name="urut" class="form-control " required
                                                autocomplete="off" autofocus></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </form>
        </div><!-- /.col-md-12 -->
    </div><!-- /.row -->
</section><!-- /.content -->


<?php  
        if (isset($_POST['simpandata'])) {
        	$nama_mapel = $_POST['nama_mapel'];
        	$id_kelompok = $_POST['id_kelompok'];
        	$s_mapel = $_POST['s_mapel'];
        	$urut = $_POST['urut'];
        	

        		$simpan = mysqli_query($mysqli,"INSERT INTO mapel SET id_sekolah='1', nama_mapel='$nama_mapel', id_kelompok='$id_kelompok', s_mapel='$s_mapel', urut='$urut'");
	        	if ($simpan) {
	        		?><script type="text/javascript">
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages'] ?>";
</script><?php
	        	}
        	
        }
        ?>


<?php }elseif($_GET['filter']=="edit"){ 
    	$mapel = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM mapel WHERE id_mapel='$_GET[dataID]'"));
    	?>
<section class="content-header">
    <h1>
        Form Tambah Mata Pelajaran Sekolah
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
                        <h3 class="card-title">Form Tambah Mata Pelajaran Sekolah</h3>
                        <div>
                            <a href="?pages=mapel" class="btn btn-primary ">Kembali</a>
                            <button type="submit" name="editdata" class="btn btn-success ">Simpan Data</button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <input type="hidden" name="kode" value="<?php echo $kode ?>">

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Nama Mata Pelajaran</td>
                                        <td><input type="text" name="nama_mapel" class="form-control " required
                                                autocomplete="off" autofocus value="<?php echo $mapel['nama_mapel'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Kategori</td>
                                        <td>
                                            <select name="id_kelompok" class="form-control " required>
                                                <option value="">Pilih Kelompok Mapel</option>
                                                <?php  
		                      					$kelompok = mysqli_query($mysqli,"SELECT * FROM kelompok_mapel ORDER BY id_kelompok ASC");
		                      					while ($rkelompok = mysqli_fetch_array($kelompok)) {
		                      						if ($mapel['id_kelompok']==$rkelompok['id_kelompok']) {
		                      							$selmapel = "selected";
		                      						}else{
		                      							$selmapel = "";
		                      						}
		                      					?>
                                                <option value="<?php echo $rkelompok['id_kelompok'] ?>"
                                                    <?php echo $selmapel ?>><?php echo $rkelompok['kelompok'] ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Kode Mapel</td>
                                        <td><input type="text" name="s_mapel" class="form-control " required
                                                autocomplete="off" autofocus value="<?php echo $mapel['s_mapel'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Urutan Mapel</td>
                                        <td><input type="number" name="urut" class="form-control " required
                                                autocomplete="off" autofocus value="<?php echo $mapel['urut'] ?>">
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </form>
        </div><!-- /.col-md-12 -->
    </div><!-- /.row -->
</section><!-- /.content -->


<?php  
        if (isset($_POST['editdata'])) {
        	$nama_mapel = $_POST['nama_mapel'];
        	$id_kelompok = $_POST['id_kelompok'];
        	$s_mapel = $_POST['s_mapel'];
        	$urut = $_POST['urut'];
        	

        		$simpan = mysqli_query($mysqli,"UPDATE mapel SET nama_mapel='$nama_mapel', id_kelompok='$id_kelompok', s_mapel='$s_mapel', urut='$urut' WHERE id_mapel='$_GET[dataID]'");
	        	if ($simpan) {
	        		?><script type="text/javascript">
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages'] ?>";
</script><?php
	        	}

        	
        }
        ?>


<?php }elseif($_GET['filter']=="hapus"){ 

    	$hapusmapel = mysqli_query($mysqli,"DELETE FROM mapel WHERE id_mapel='$_GET[dataID]'");

    	$hapuspembelajaran = mysqli_query($mysqli,"DELETE FROM pembelajaran_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_mapel='$_GET[dataID]'");

    	if ($hapusmapel || $hapuspembelajaran ) {
        	?><script type="text/javascript">
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages'] ?>";
</script><?php
        }

    	?>




<?php } ?>