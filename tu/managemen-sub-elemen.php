<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
  <h1>
    Manajemen Sub Elemen
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
      <!-- USERS LIST -->
      <div class="card border-danger">
        <div class="card-header text-white">
          <h3 class="card-title">Daftar Sub Elemen</h3>
          <div class="float-right">
            <a href="?pages=managemen-sub-elemen&filter=<?php echo 'tambah' ?>" class="btn btn-primary">Tambah Sub
              Elemen</a>
          </div>
        </div><!-- /.card-header -->

        <div class="card-body table-responsive">
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th width="3%">No</th>
                <th width="10%">Kode</th>
                <th width="15%">Dimensi</th>
                <th width="15%">Elemen</th>
                <th>Sub Elemen</th>
                <th>Capaian</th>
                <th width="12%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php  
                            $nomor = 1;
                            $sub_elemen_query = mysqli_query($mysqli, "SELECT se.*, d.dimensi, e.elemen, e.kode_elemen
                                FROM sub_elemen se
                                JOIN dimensi d ON se.id_dimensi = d.id_dimensi
                                JOIN elemen e ON se.id_elemen = e.id_elemen
                                ORDER BY se.kode ASC");
                            while($data = mysqli_fetch_array($sub_elemen_query)) {
                            ?>
              <tr>
                <td><?php echo $nomor++ ?></td>
                <td><?php echo $data['kode'] ?></td>
                <td><?php echo $data['dimensi'] ?></td>
                <td><?php echo $data['elemen'] ?></td>
                <td><?php echo $data['sub_elemen'] ?></td>
                <td><?php echo $data['capaianE'] ?></td>
                <td>
                  <a href="?pages=managemen-sub-elemen&filter=edit&dataID=<?php echo $data['id_sub_elemen'] ?>"
                    class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                  <a href="?pages=managemen-sub-elemen&filter=hapus&dataID=<?php echo $data['id_sub_elemen'] ?>"
                    onclick="return confirm('Yakin ingin menghapus sub elemen ini?')" class="btn btn-danger btn-sm"><i
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
    Form Tambah Sub Elemen
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
            <h3 class="card-title">Form Tambah Sub Elemen</h3>
            <div class="float-right">
              <a href="?pages=managemen-sub-elemen" class="btn btn-primary">Kembali</a>
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
                      <select name="id_dimensi" id="dimensi" class="form-control" required="">
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
                    <td>Elemen</td>
                    <td>
                      <select name="id_elemen" id="elemen" class="form-control" required="">
                        <option value="">--Pilih Elemen--</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Kode Sub Elemen</td>
                    <td>
                      <input type="text" name="kode" class="form-control" required="" autocomplete="off">
                      <small class="text-muted">Format: 01.01.01 (Dimensi.Elemen.SubElemen)</small>
                    </td>
                  </tr>
                  <tr>
                    <td>Sub Elemen</td>
                    <td>
                      <input type="text" name="sub_elemen" class="form-control" required="" autocomplete="off">
                    </td>
                  </tr>
                  <tr>
                    <td>Capaian</td>
                    <td>
                      <textarea name="capaianE" class="form-control" rows="4" required=""></textarea>
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

<!-- jQuery first, then our custom script -->
<script type="text/javascript">
// Wait for document to be fully loaded and jQuery to be available
document.addEventListener('DOMContentLoaded', function() {
  // Set up the onChange event for dimensi dropdown
  document.getElementById('dimensi').addEventListener('change', function() {
    var dimensiId = this.value;
    var elemenSelect = document.getElementById('elemen');

    // Reset elemen dropdown
    elemenSelect.innerHTML = '<option value="">--Pilih Elemen--</option>';

    if (dimensiId !== '') {
      console.log("Fetching elemen for dimensi ID: " + dimensiId);

      // Use vanilla JavaScript fetch API instead of jQuery
      fetch('index.php?pages=managemen-sub-elemen&action=get_elemen&id_dimensi=' + dimensiId)
        .then(function(response) {
          return response.json();
        })
        .then(function(data) {
          console.log("Data received:", data);

          // Populate elemen dropdown
          if (data && data.length > 0) {
            for (var i = 0; i < data.length; i++) {
              var option = document.createElement('option');
              option.value = data[i].id_elemen;
              option.text = data[i].kode_elemen + ' - ' + data[i].elemen;
              elemenSelect.appendChild(option);
            }
            console.log("Elemen dropdown populated with " + data.length + " items");
          } else {
            console.log("No elemen data returned for dimensi ID: " + dimensiId);
          }
        })
        .catch(function(error) {
          console.error("Fetch error:", error);
        });
    }
  });
});
</script>

<?php
// Move AJAX handler to the top of the PHP code so it executes before any HTML output
if (isset($_GET['action']) && $_GET['action'] == 'get_elemen') {
    $id_dimensi = $_GET['id_dimensi'];
    $elemen_query = mysqli_query($mysqli, "SELECT * FROM elemen WHERE id_dimensi = $id_dimensi ORDER BY kode_elemen ASC");
    
    $elemen_list = array();
    while ($elemen = mysqli_fetch_assoc($elemen_query)) {
        $elemen_list[] = $elemen;
    }
    
    // Send proper JSON headers
    header('Content-Type: application/json');
    echo json_encode($elemen_list);
    exit;
}

// Handle form submission
if (isset($_POST['simpan'])) {
    $id_dimensi = $mysqli->real_escape_string($_POST['id_dimensi']);
    $id_elemen = $mysqli->real_escape_string($_POST['id_elemen']);
    $kode = $mysqli->real_escape_string($_POST['kode']);
    $sub_elemen = $mysqli->real_escape_string($_POST['sub_elemen']);
    $capaianE = $mysqli->real_escape_string($_POST['capaianE']);
    
    $simpan = mysqli_query($mysqli, "INSERT INTO sub_elemen (id_dimensi, id_elemen, kode, sub_elemen, capaianE) 
                                     VALUES ('$id_dimensi', '$id_elemen', '$kode', '$sub_elemen', '$capaianE')");
    if ($simpan) {
?>
<script type="text/javascript">
alert('Data sub elemen berhasil ditambahkan');
window.location.href = "?pages=managemen-sub-elemen";
</script>
<?php
    } else {
?>
<script type="text/javascript">
alert('Gagal menambahkan data: <?php echo mysqli_error($mysqli); ?>');
</script>
<?php
    }
}
?>

<?php } elseif($_GET['filter'] == "edit") { 
    $sub_elemen = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM sub_elemen WHERE id_sub_elemen='$_GET[dataID]'"));
?>
<section class="content-header">
  <h1>
    Form Edit Sub Elemen
  </h1>
</section>

<section class="content-header">
  <a href="?pages=managemen-sub-elemen" class="btn btn-primary">Kembali</a>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- USERS LIST -->
      <div class="card border-danger">
        <div class="card-header text-white">
          <h3 class="card-title">Form Edit Sub Elemen</h3>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <form method="POST">
                <table class="table table-striped table-bordered">
                  <tr>
                    <td style="width: 30%;">Dimensi</td>
                    <td>
                      <select name="id_dimensi" id="dimensi_edit" class="form-control" required=""
                        onchange="getElemenEdit()">
                        <?php
                                                $dimensi_query = mysqli_query($mysqli, "SELECT * FROM dimensi ORDER BY id_dimensi ASC");
                                                while($data_dimensi = mysqli_fetch_array($dimensi_query)) {
                                                    $selected = ($data_dimensi['id_dimensi'] == $sub_elemen['id_dimensi']) ? "selected" : "";
                                                    echo "<option value='".$data_dimensi['id_dimensi']."' $selected>".$data_dimensi['dimensi']."</option>";
                                                }
                                                ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Elemen</td>
                    <td>
                      <select name="id_elemen" id="elemen_edit" class="form-control" required="">
                        <?php
                                                $elemen_query = mysqli_query($mysqli, "SELECT * FROM elemen WHERE id_dimensi = '".$sub_elemen['id_dimensi']."' ORDER BY kode_elemen ASC");
                                                while($data_elemen = mysqli_fetch_array($elemen_query)) {
                                                    $selected = ($data_elemen['id_elemen'] == $sub_elemen['id_elemen']) ? "selected" : "";
                                                    echo "<option value='".$data_elemen['id_elemen']."' $selected>".$data_elemen['kode_elemen']." - ".$data_elemen['elemen']."</option>";
                                                }
                                                ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Kode Sub Elemen</td>
                    <td>
                      <input type="text" name="kode" class="form-control" required=""
                        value="<?php echo $sub_elemen['kode'] ?>">
                      <small class="text-muted">Format: 01.01.01 (Dimensi.Elemen.SubElemen)</small>
                    </td>
                  </tr>
                  <tr>
                    <td>Sub Elemen</td>
                    <td>
                      <input type="text" name="sub_elemen" class="form-control" required=""
                        value="<?php echo $sub_elemen['sub_elemen'] ?>">
                    </td>
                  </tr>
                  <tr>
                    <td>Capaian</td>
                    <td>
                      <textarea name="capaianE" class="form-control" rows="4"
                        required=""><?php echo $sub_elemen['capaianE'] ?></textarea>
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

            <script>
            // Wait for document to be fully loaded
            document.addEventListener('DOMContentLoaded', function() {
              // Set up the onChange event for dimensi dropdown
              document.getElementById('dimensi_edit').addEventListener('change', function() {
                getElemenEdit();
              });
            });

            function getElemenEdit() {
              var dimensiId = document.getElementById('dimensi_edit').value;
              var elemenSelect = document.getElementById('elemen_edit');

              // Reset elemen dropdown
              elemenSelect.innerHTML = '<option value="">--Pilih Elemen--</option>';

              if (dimensiId !== '') {
                console.log("Edit page: Fetching elemen for dimensi ID: " + dimensiId);

                // Use vanilla JavaScript fetch API instead of jQuery
                fetch('index.php?pages=managemen-sub-elemen&action=get_elemen&id_dimensi=' + dimensiId)
                  .then(function(response) {
                    return response.json();
                  })
                  .then(function(data) {
                    console.log("Edit page data received:", data);

                    // Populate elemen dropdown
                    if (data && data.length > 0) {
                      for (var i = 0; i < data.length; i++) {
                        var option = document.createElement('option');
                        option.value = data[i].id_elemen;
                        option.text = data[i].kode_elemen + ' - ' + data[i].elemen;
                        elemenSelect.appendChild(option);
                      }
                      console.log("Edit page: Elemen dropdown populated with " + data.length + " items");
                    } else {
                      console.log("Edit page: No elemen data returned for dimensi ID: " + dimensiId);
                    }
                  })
                  .catch(function(error) {
                    console.error("Edit page fetch error:", error);
                  });
              }
            }
            </script>

            <?php  
                        if (isset($_POST['update'])) {
                            $id_dimensi = $mysqli->real_escape_string($_POST['id_dimensi']);
                            $id_elemen = $mysqli->real_escape_string($_POST['id_elemen']);
                            $kode = $mysqli->real_escape_string($_POST['kode']);
                            $sub_elemen_baru = $mysqli->real_escape_string($_POST['sub_elemen']);
                            $capaianE = $mysqli->real_escape_string($_POST['capaianE']);

                            $update = mysqli_query($mysqli, "UPDATE sub_elemen SET 
                                id_dimensi = '$id_dimensi',
                                id_elemen = '$id_elemen',
                                kode = '$kode',
                                sub_elemen = '$sub_elemen_baru',
                                capaianE = '$capaianE'
                                WHERE id_sub_elemen = '$_GET[dataID]'");
                                
                            if ($update) {
                        ?>
            <script type="text/javascript">
            alert('Data sub elemen berhasil diperbarui');
            window.location.href = "?pages=managemen-sub-elemen";
            </script>
            <?php
                            } else {
                        ?>
            <script type="text/javascript">
            alert('Gagal memperbarui data: <?php echo mysqli_error($mysqli); ?>');
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
    $hapus = mysqli_query($mysqli,"DELETE FROM sub_elemen WHERE id_sub_elemen='$_GET[dataID]'");
    
    if ($hapus) {
?>
<script type="text/javascript">
alert('Data sub elemen berhasil dihapus');
window.location.href = "?pages=managemen-sub-elemen";
</script>
<?php
    } else {
?>
<script type="text/javascript">
alert('Gagal menghapus data: <?php echo mysqli_error($mysqli); ?>');
window.location.href = "?pages=managemen-sub-elemen";
</script>
<?php
    }
?>

<?php } ?>

<?php
// Create table if not exists
$check_table = mysqli_query($mysqli, "SHOW TABLES LIKE 'sub_elemen'");
if(mysqli_num_rows($check_table) == 0) {
    $create_table = "CREATE TABLE IF NOT EXISTS sub_elemen (
        id_sub_elemen INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        id_dimensi INT(11) NOT NULL,
        id_elemen INT(11) NOT NULL,
        kode VARCHAR(20) NOT NULL,
        sub_elemen VARCHAR(255) NOT NULL,
        capaianE TEXT NOT NULL,
        FOREIGN KEY (id_dimensi) REFERENCES dimensi(id_dimensi) ON DELETE CASCADE,
        FOREIGN KEY (id_elemen) REFERENCES elemen(id_elemen) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    mysqli_query($mysqli, $create_table);
}
?>