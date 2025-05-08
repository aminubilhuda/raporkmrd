<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
  <h1>
    Manajemen Elemen
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
      <!-- USERS LIST -->
      <div class="card border-danger">
        <div class="card-header text-white">
          <h3 class="card-title">Daftar Elemen</h3>
          <div class="float-right">
            <a href="?pages=managemen-elemen&filter=<?php echo 'tambah' ?>" class="btn btn-primary">Tambah Elemen</a>
          </div>
        </div><!-- /.card-header -->

        <div class="card-body table-responsive">
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Elemen</th>
                <th width="25%">Dimensi</th>
                <th>Elemen</th>
                <th width="15%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php  
                            $nomor = 1;
                            $elemen_query = mysqli_query($mysqli, "SELECT e.*, d.dimensi 
                                FROM elemen e
                                JOIN dimensi d ON e.id_dimensi = d.id_dimensi
                                ORDER BY e.kode_elemen ASC");
                            while($data_elemen = mysqli_fetch_array($elemen_query)) {
                            ?>
              <tr>
                <td><?php echo $nomor++ ?></td>
                <td><?php echo $data_elemen['kode_elemen'] ?></td>
                <td><?php echo $data_elemen['dimensi'] ?></td>
                <td><?php echo $data_elemen['elemen'] ?></td>
                <td>
                  <a href="?pages=managemen-elemen&filter=edit&dataID=<?php echo $data_elemen['id_elemen'] ?>"
                    class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                  <a href="?pages=managemen-elemen&filter=hapus&dataID=<?php echo $data_elemen['id_elemen'] ?>"
                    onclick="return confirm('Yakin ingin menghapus elemen ini?')" class="btn btn-danger btn-sm"><i
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
    Form Tambah Elemen
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
            <h3 class="card-title">Form Tambah Elemen</h3>
            <div class="float-right">
              <a href="?pages=managemen-elemen" class="btn btn-primary">Kembali</a>
              <button type="submit" name="simpan" class="btn btn-success">Simpan Data</button>
            </div>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <table class="table table-striped table-bordered">
                  <tr>
                    <td style="width: 30%;">Dimensi</td>
                    <td>
                      <select name="id_dimensi" class="form-control" required="">
                        <option value="">--Pilih Dimensi--</option>
                        <?php
                                                $dimensi_query = mysqli_query($mysqli, "SELECT * FROM dimensi ORDER BY id_dimensi ASC");
                                                while($data_dimensi = mysqli_fetch_array($dimensi_query)) {
                                                    echo "<option value='".$data_dimensi['id_dimensi']."'>".$data_dimensi['dimensi']."</option>";
                                                }
                                                ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Kode Elemen</td>
                    <td>
                      <input type="text" name="kode_elemen" class="form-control" required="" autocomplete="off">
                      <small class="text-muted">Contoh: 1.1, 1.2, 1.3, dst</small>
                    </td>
                  </tr>
                  <tr>
                    <td>Elemen</td>
                    <td>
                      <input type="text" name="elemen" class="form-control" required="" autocomplete="off">
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
    // Handle form submission
    if (isset($_POST['simpan'])) {
        $id_dimensi = $mysqli->real_escape_string($_POST['id_dimensi']);
        $kode_elemen = $mysqli->real_escape_string($_POST['kode_elemen']);
        $elemen = $mysqli->real_escape_string($_POST['elemen']);
        
        $simpan = mysqli_query($mysqli,"INSERT INTO elemen (id_dimensi, kode_elemen, elemen) VALUES ('$id_dimensi', '$kode_elemen', '$elemen')");
        if ($simpan) {
?>
<script type="text/javascript">
alert('Data elemen berhasil ditambahkan');
window.location.href = "?pages=managemen-elemen";
</script>
<?php
        }
    }
?>

<?php } elseif($_GET['filter'] == "edit") { 
    $elemen = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM elemen WHERE id_elemen='$_GET[dataID]'"));
?>
<section class="content-header">
  <h1>
    Form Edit Elemen
  </h1>
</section>

<section class="content-header">
  <a href="?pages=managemen-elemen" class="btn btn-primary">Kembali</a>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- USERS LIST -->
      <div class="card border-danger">
        <div class="card-header text-white">
          <h3 class="card-title">Form Edit Elemen</h3>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <form method="POST">
                <table class="table table-striped table-bordered">
                  <tr>
                    <td style="width: 30%;">Dimensi</td>
                    <td>
                      <select name="id_dimensi" class="form-control" required="" id="dimensi_select">
                        <?php
                                                $dimensi_query = mysqli_query($mysqli, "SELECT * FROM dimensi ORDER BY id_dimensi ASC");
                                                while($data_dimensi = mysqli_fetch_array($dimensi_query)) {
                                                    $selected = ($data_dimensi['id_dimensi'] == $elemen['id_dimensi']) ? "selected" : "";
                                                    echo "<option value='".$data_dimensi['id_dimensi']."' $selected>".$data_dimensi['dimensi']."</option>";
                                                }
                                                ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Kode Elemen</td>
                    <td>
                      <input type="text" name="kode_elemen" class="form-control" required=""
                        value="<?php echo $elemen['kode_elemen'] ?>">
                    </td>
                  </tr>
                  <tr>
                    <td>Elemen</td>
                    <td>
                      <input type="text" name="elemen" class="form-control" required="" autocomplete="off"
                        value="<?php echo $elemen['elemen'] ?>">
                    </td>
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
                            $id_dimensi = $mysqli->real_escape_string($_POST['id_dimensi']);
                            $kode_elemen = $mysqli->real_escape_string($_POST['kode_elemen']);
                            $elemen_baru = $mysqli->real_escape_string($_POST['elemen']);

                            $update = mysqli_query($mysqli,"UPDATE elemen SET id_dimensi='$id_dimensi', kode_elemen='$kode_elemen', elemen='$elemen_baru' WHERE id_elemen='$_GET[dataID]'");
                            if ($update) {
                        ?>
            <script type="text/javascript">
            alert('Data elemen berhasil diperbarui');
            window.location.href = "?pages=managemen-elemen";
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
    $hapus = mysqli_query($mysqli,"DELETE FROM elemen WHERE id_elemen='$_GET[dataID]'");
    
    if ($hapus) {
?>
<script type="text/javascript">
alert('Data elemen berhasil dihapus');
window.location.href = "?pages=managemen-elemen";
</script>
<?php
    }
?>

<?php } ?>

<?php
// Create table if not exists
$check_table = mysqli_query($mysqli, "SHOW TABLES LIKE 'elemen'");
if(mysqli_num_rows($check_table) == 0) {
    $create_table = "CREATE TABLE IF NOT EXISTS elemen (
        id_elemen INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        id_dimensi INT(11) NOT NULL,
        kode_elemen VARCHAR(20) NOT NULL,
        elemen VARCHAR(255) NOT NULL,
        FOREIGN KEY (id_dimensi) REFERENCES dimensi(id_dimensi) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    mysqli_query($mysqli, $create_table);
}
?>