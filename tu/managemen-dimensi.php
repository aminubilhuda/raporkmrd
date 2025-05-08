<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
    <h1>
        Manajemen Dimensi
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card border-danger">
                <div class="card-header text-white">
                    <h3 class="card-title">Daftar Dimensi</h3>
                    <div class="float-right">
                        <a href="?pages=managemen-dimensi&filter=<?php echo 'tambah' ?>" class="btn btn-primary">Tambah Dimensi</a>
                    </div>
                </div><!-- /.card-header -->

                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Dimensi</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                            $nomor = 1;
                            $dimensi_query = mysqli_query($mysqli, "SELECT * FROM dimensi ORDER BY id_dimensi ASC");
                            while($data_dimensi = mysqli_fetch_array($dimensi_query)) {
                            ?>
                            <tr>
                                <td><?php echo $nomor++ ?></td>
                                <td><?php echo $data_dimensi['dimensi'] ?></td>
                                <td>
                                    <a href="?pages=managemen-dimensi&filter=edit&dataID=<?php echo $data_dimensi['id_dimensi'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                                    <a href="?pages=managemen-dimensi&filter=hapus&dataID=<?php echo $data_dimensi['id_dimensi'] ?>" onclick="return confirm('Yakin ingin menghapus dimensi ini?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>
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

<?php } elseif($_GET['filter'] == "tambah") { ?>
<section class="content-header">
    <h1>
        Form Tambah Dimensi
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
                        <h3 class="card-title">Form Tambah Dimensi</h3>
                        <div class="float-right">
                            <a href="?pages=managemen-dimensi" class="btn btn-primary">Kembali</a>
                            <button type="submit" name="simpan" class="btn btn-success">Simpan Data</button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Dimensi</td>
                                        <td><input type="text" name="dimensi" class="form-control" required="" autocomplete="off" autofocus=""></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- /.row -->
</section><!-- /.content -->

<?php  
    if (isset($_POST['simpan'])) {
        $dimensi = $mysqli->real_escape_string($_POST['dimensi']);
        
        $simpan = mysqli_query($mysqli,"INSERT INTO dimensi (dimensi) VALUES ('$dimensi')");
        if ($simpan) {
?>
<script type="text/javascript">
alert('Data dimensi berhasil ditambahkan');
window.location.href = "?pages=managemen-dimensi";
</script>
<?php
        }
    }
?>

<?php } elseif($_GET['filter'] == "edit") { 
    $dimensi = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM dimensi WHERE id_dimensi='$_GET[dataID]'"));
?>
<section class="content-header">
    <h1>
        Form Edit Dimensi
    </h1>
</section>

<section class="content-header">
    <a href="?pages=managemen-dimensi" class="btn btn-primary">Kembali</a>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card border-danger">
                <div class="card-header text-white">
                    <h3 class="card-title">Form Edit Dimensi</h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="POST">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td style="width: 30%;">Dimensi</td>
                                        <td><input type="text" name="dimensi" class="form-control" required="" autocomplete="off" autofocus="" value="<?php echo $dimensi['dimensi'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">
                                            <button type="submit" name="update" class="btn btn-success">Simpan Data</button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <?php  
                        if (isset($_POST['update'])) {
                            $dimensi_baru = $mysqli->real_escape_string($_POST['dimensi']);

                            $update = mysqli_query($mysqli,"UPDATE dimensi SET dimensi='$dimensi_baru' WHERE id_dimensi='$_GET[dataID]'");
                            if ($update) {
                        ?>
                        <script type="text/javascript">
                        alert('Data dimensi berhasil diperbarui');
                        window.location.href = "?pages=managemen-dimensi";
                        </script>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.row -->
</section><!-- /.content -->

<?php } elseif($_GET['filter'] == "hapus") { 
    $hapus = mysqli_query($mysqli,"DELETE FROM dimensi WHERE id_dimensi='$_GET[dataID]'");
    
    if ($hapus) {
?>
<script type="text/javascript">
alert('Data dimensi berhasil dihapus');
window.location.href = "?pages=managemen-dimensi";
</script>
<?php
    }
?>

<?php } ?>

<?php
// Create table if not exists
$check_table = mysqli_query($mysqli, "SHOW TABLES LIKE 'dimensi'");
if(mysqli_num_rows($check_table) == 0) {
    $create_table = "CREATE TABLE IF NOT EXISTS dimensi (
        id_dimensi INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        dimensi VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    mysqli_query($mysqli, $create_table);
}
?>