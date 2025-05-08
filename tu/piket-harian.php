<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
    <h1>
        Jadwal Piket Harian
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header">
                    <div class="card-tools float-right">
                        <a href="?pages=<?php echo $_GET['pages']?>&filter=<?php echo 'tambah' ?>"
                            class="btn btn-primary">
                            Tambah Data
                        </a>
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr style="background-color:orange;">
                                <?php
                      			    $harian = mysqli_query($mysqli,"SELECT * FROM harian ORDER BY id_harian ASC");
                      			    while($rharian = mysqli_fetch_array($harian)){
                      			    ?>
                                <th style="text-align:center;"><?php echo $rharian['harian']?></th>
                                <?php }?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                      			    $harian = mysqli_query($mysqli,"SELECT * FROM harian ORDER BY id_harian ASC");
                      			    while($rharian = mysqli_fetch_array($harian)){
                      			    ?>
                                <th>
                                    <a
                                        href="?pages=<?php echo $_GET['pages']?>&filter=<?php echo 'edit' ?>&orderID=<?php echo $rharian['id_harian']?>">
                                        <ol>
                                            <?php
                              			        $piket = mysqli_query($mysqli,"SELECT * FROM piket_harian WHERE id_harian='$rharian[id_harian]' ORDER BY id_user ASC");
                              			        while($rpiket = mysqli_fetch_array($piket)){
                              			            $users = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$rpiket[id_user]'"));
                              			        ?>
                                            <li><?php echo $users['nama']?></li>
                                            <?php } ?>
                                        </ol>
                                    </a>
                                </th>
                                <?php }?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.row -->

</section><!-- /.content -->



<?php }elseif($_GET['filter']=="tambah"){ ?>
<section class="content-header">
    <h1>
        Form Tambah Piket Harian
    </h1>
</section>

<section class="content-header">
    <a href="?pages=<?php echo $_GET['pages']?>" class="btn btn-primary">Kembali</a>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <form method="POST">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Piket Harian</h3>
                        <div class="card-tools float-right">
                            <button type="submit" name="simpan" class="btn btn-primary">Simpan Piket</button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <input type="hidden" name="kode" value="<?php echo $kode ?>">

                        <table class="table table-striped table-bordered">
                            <tr>
                                <td style="width: 30%;">Pilih Hari</td>
                                <td>
                                    <select name="id_harian" class="form-control" required="">
                                        <option value="" required="">Pilih Hari</option>
                                        <?php
                      			        $harian = mysqli_query($mysqli,"SELECT * FROM harian ORDER BY id_harian ASC");
                      			        while($rharian = mysqli_fetch_array($harian)){
                      			        ?>
                                        <option value="<?php echo $rharian['id_harian']?>">
                                            <?php echo $rharian['harian']?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Pilih Guru </td>
                                <td>
                                    <select name="id_user[]" multiple class="form-control" required="" size="20">
                                        <option value="" required="">Pilih Jenis Kelamin</option>
                                        <?php  
                      					$dataguru = mysqli_query($mysqli,"SELECT * FROM users WHERE jabatan='3' ORDER BY nama ASC");
                      					while ($rguru = mysqli_fetch_array($dataguru)) {
                      					?>
                                        <option value="<?php echo $rguru['id_user'] ?>"><?php echo $rguru['nama'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        </div><!-- /.row -->

</section><!-- /.content -->


<?php  
        if (isset($_POST['simpan'])) {
        	$harian = $_POST['id_harian'];
        	$id_user = $_POST['id_user'];
        	
        	mysqli_query($mysqli,"DELETE FROM piket_harian WHERE id_harian='$harian'");
        	
        	$jumlahuser = count($id_user);
        	for ($i=0; $i <$jumlahuser ; $i++) { 
            	$simpan = mysqli_query($mysqli,"INSERT INTO piket_harian SET id_harian='$harian', id_user='$id_user[$i]'");
            }

        
        	if ($simpan) {
        		?>
<script type="text/javascript">
Swal.fire({
    title: "Berhasil!",
    text: "Data berhasil disimpan",
    icon: "success",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages'] ?>";
});
</script>
<?php
        	}
        }
        ?>


<?php }elseif($_GET['filter']=="edit"){ 
    		$harian = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM harian WHERE id_harian='$_GET[orderID]'"));
    	?>
<section class="content-header">
    <h1>
        Form Edit Piket Harian <?php echo $harian['harian']?>
    </h1>
</section>

<section class="content-header">
    <a href="?pages=<?php echo $_GET['pages']?>" class="btn btn-primary">Kembali</a>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <form method="POST">
                <div class="card border-danger">
                    <div class="card-header text-white">
                        <h3 class="card-title">Form Edit Piket Harian <?php echo $harian['harian']?></h3>
                        <div class="float-right">
                            <button type="submit" name="simpan" class="btn btn-primary">Simpan Piket</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="kode" value="<?php echo $kode ?>">

                        <table class="table table-striped table-bordered">
                            <tr>
                                <td style="width: 30%;">Pilih Hari</td>
                                <td>
                                    <select name="id_harian" class="form-control" required>
                                        <option value="" required="">Pilih Hari</option>
                                        <?php
                                        $harian = mysqli_query($mysqli,"SELECT * FROM harian ORDER BY id_harian ASC");
                                        while($rharian = mysqli_fetch_array($harian)){
                                            if($_GET['orderID']==$rharian['id_harian']){
                                                $sele = "selected";
                                            }else{
                                                $sele = "";
                                            }
                                        ?>
                                        <option value="<?php echo $rharian['id_harian']?>" <?php echo $sele ?>>
                                            <?php echo $rharian['harian']?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">Pilih Guru </td>
                                <td>
                                    <select name="id_user[]" multiple class="form-control select2" required size="20">
                                        <option value="" required="">Pilih Jenis Kelamin</option>
                                        <?php  
                                        $dataguru = mysqli_query($mysqli,"SELECT * FROM users WHERE jabatan='3' ORDER BY nama ASC");
                                        while ($rguru = mysqli_fetch_array($dataguru)) {
                                            $jumlah = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM piket_harian WHERE id_harian='$_GET[orderID]' AND id_user='$rguru[id_user]'"));
                                            if($jumlah==1){
                                                $seleus = "selected";
                                            }else{
                                                $seleus = "";
                                            }
                                        ?>
                                        <option value="<?php echo $rguru['id_user'] ?>" <?php echo $seleus ?>>
                                            <?php echo $rguru['nama'] ?></option>
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
        if (isset($_POST['simpan'])) {
        	$harian = $_POST['id_harian'];
        	$id_user = $_POST['id_user'];
        	
        	mysqli_query($mysqli,"DELETE FROM piket_harian WHERE id_harian='$harian'");
        	
        	$jumlahuser = count($id_user);
        	for ($i=0; $i <$jumlahuser ; $i++) { 
            	$simpan = mysqli_query($mysqli,"INSERT INTO piket_harian SET id_harian='$harian', id_user='$id_user[$i]'");
            }

        
        	if ($simpan) {
        		?>
<script type="text/javascript">
Swal.fire({
    title: "Berhasil!",
    text: "Data berhasil disimpan.",
    icon: "success",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages'] ?>";
});
</script>
<?php
        	}
        }
        ?>



<?php } ?>