<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
  <h1>
    Manajemen Tema Proyek
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
      <!-- USERS LIST -->
      <div class="card border-danger">
        <div class="card-header text-white">
          <h3 class="card-title">Daftar Tema Proyek</h3>
          <div class="float-right">
            <a href="?pages=managemen-tema&filter=<?php echo 'tambah' ?>" class="btn btn-primary">Tambah Tema</a>
          </div>
        </div><!-- /.card-header -->

        <div class="card-body table-responsive">
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>Tema</th>
                <th width="15%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php  
                            $nomor = 1;
                            $tema_query = mysqli_query($mysqli, "SELECT * FROM proyek_tema ORDER BY id_tema ASC");
                            while($data_tema = mysqli_fetch_array($tema_query)) {
                            ?>
              <tr>
                <td><?php echo $nomor++ ?></td>
                <td><?php echo $data_tema['tema'] ?></td>
                <td>
                  <a href="?pages=managemen-tema&filter=edit&dataID=<?php echo $data_tema['id_tema'] ?>"
                    class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                  <a href="?pages=managemen-tema&filter=hapus&dataID=<?php echo $data_tema['id_tema'] ?>"
                    onclick="return confirm('Yakin ingin menghapus tema ini?')" class="btn btn-danger btn-sm"><i
                      class="fa fa-trash"></i> Hapus</a>
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
    Form Tambah Tema Proyek
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
            <h3 class="card-title">Form Tambah Tema Proyek</h3>
            <div class="float-right">
              <a href="?pages=managemen-tema" class="btn btn-primary">Kembali</a>
              <button type="submit" name="simpan" class="btn btn-success">Simpan Data</button>
            </div>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <table class="table table-striped table-bordered">
                  <tr>
                    <td style="width: 30%;">Tema Proyek</td>
                    <td><input type="text" name="tema" class="form-control" required="" autocomplete="off" autofocus="">
                    </td>
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
        $tema = $mysqli->real_escape_string($_POST['tema']);
        
        $simpan = mysqli_query($mysqli,"INSERT INTO proyek_tema (tema) VALUES ('$tema')");
        if ($simpan) {
?>
<script type="text/javascript">
alert('Data tema berhasil ditambahkan');
window.location.href = "?pages=managemen-tema";
</script>
<?php
        }
    }
?>

<?php } elseif($_GET['filter'] == "edit") { 
    $tema = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM proyek_tema WHERE id_tema='$_GET[dataID]'"));
?>
<section class="content-header">
  <h1>
    Form Edit Tema Proyek
  </h1>
</section>

<section class="content-header">
  <a href="?pages=managemen-tema" class="btn btn-primary">Kembali</a>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- USERS LIST -->
      <div class="card border-danger">
        <div class="card-header text-white">
          <h3 class="card-title">Form Edit Tema Proyek</h3>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <form method="POST">
                <table class="table table-striped table-bordered">
                  <tr>
                    <td style="width: 30%;">Tema Proyek</td>
                    <td><input type="text" name="tema" class="form-control" required="" autocomplete="off" autofocus=""
                        value="<?php echo $tema['tema'] ?>"></td>
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
                            $tema_baru = $mysqli->real_escape_string($_POST['tema']);

                            $update = mysqli_query($mysqli,"UPDATE proyek_tema SET tema='$tema_baru' WHERE id_tema='$_GET[dataID]'");
                            if ($update) {
                        ?>
            <script type="text/javascript">
            alert('Data tema berhasil diperbarui');
            window.location.href = "?pages=managemen-tema";
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
    $hapus = mysqli_query($mysqli,"DELETE FROM proyek_tema WHERE id_tema='$_GET[dataID]'");
    
    if ($hapus) {
?>
<script type="text/javascript">
alert('Data tema berhasil dihapus');
window.location.href = "?pages=managemen-tema";
</script>
<?php
    }
?>

<?php } ?>

<?php
// Create table if not exists
$check_table = mysqli_query($mysqli, "SHOW TABLES LIKE 'proyek_tema'");
if(mysqli_num_rows($check_table) == 0) {
    $create_table = "CREATE TABLE IF NOT EXISTS proyek_tema (
        id_tema INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        tema VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    mysqli_query($mysqli, $create_table);
}
?>