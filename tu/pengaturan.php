<?php  

$pembagian = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM pembagian_raport WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));
?>
<section class="content-header">
    <h1>
        Pengaturan
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-header text-white">
                    <h3 class="card-title">Pengaturan</h3>
                </div>
                <form method="POST">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tanggal Pembagian Rapor</label>
                            <input type="date" name="tanggal_rapor" class="form-control" id="mdate"
                                value="<?php echo $pembagian['tanggal_rapor'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pembagian Middle</label>
                            <input type="date" name="tanggal_mid" class="form-control"
                                value="<?php echo $pembagian['tanggal_mid'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Lokasi TTD Rapor</label>
                            <select name="lokasi" class="form-control" required>
                                <option value="" required="">Pilih Lokasi</option>
                                <option value="1" <?php if($sekolah['lokasi']==1){ echo "selected";} ?>>Kabupaten
                                </option>
                                <option value="2" <?php if($sekolah['lokasi']==2){ echo "selected";} ?>>Kecamatan
                                </option>
                                <option value="3" <?php if($sekolah['lokasi']==3){ echo "selected";} ?>>Desa / Kelurahan
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" name="simpanpengaturan" class="btn btn-primary btn-sm">Simpan
                            Data</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-header text-white">
                    <h3 class="card-title">Tahun Pelajaran</h3>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary btn-sm mb-3" data-toggle="modal"
                        data-target="#myModal">Tambah</button>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun Pelajaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nomor=1;
                            $tahun = mysqli_query($mysqli,"SELECT * FROM tahun_pelajaran ORDER BY id_tahun_pelajaran ASC");
                            while($rtahun = mysqli_fetch_array($tahun)){
                            ?>
                            <tr>
                                <td><?php echo $nomor++?></td>
                                <td><?php echo $rtahun['tahun_pelajaran']?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#myModalEdit<?php echo $rtahun['id_tahun_pelajaran']?>"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#myModalHapus<?php echo $rtahun['id_tahun_pelajaran']?>"><i
                                            class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="myModalLabel">Form Tambah Tahun Pelajaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tahun Pelajaran</label>
                            <input type="text" name="tahun_pelajaran" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updatetahun" class="btn btn-success">Update Tahun Pelajaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    $tahun = mysqli_query($mysqli,"SELECT * FROM tahun_pelajaran ORDER BY id_tahun_pelajaran ASC");
    while($rtahun = mysqli_fetch_array($tahun)){
    ?>
    <!-- Edit Modal -->
    <div class="modal fade" id="myModalEdit<?php echo $rtahun['id_tahun_pelajaran']?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalEditLabel<?php echo $rtahun['id_tahun_pelajaran']?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="myModalEditLabel<?php echo $rtahun['id_tahun_pelajaran']?>">Edit Tahun
                        Pelajaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_tahun_pelajaran"
                            value="<?php echo $rtahun['id_tahun_pelajaran']?>">
                        <div class="form-group">
                            <label>Tahun Pelajaran</label>
                            <input type="text" name="tahun_pelajaran" class="form-control"
                                value="<?php echo $rtahun['tahun_pelajaran']?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updatetahunedit" class="btn btn-warning">Update Tahun
                            Pelajaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="myModalHapus<?php echo $rtahun['id_tahun_pelajaran']?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalHapusLabel<?php echo $rtahun['id_tahun_pelajaran']?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="myModalHapusLabel<?php echo $rtahun['id_tahun_pelajaran']?>">Konfirmasi
                        Hapus Tahun Pelajaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_tahun_pelajaran"
                            value="<?php echo $rtahun['id_tahun_pelajaran']?>">
                        <p class="text-center">Yakin akan menghapus Tahun Pelajaran ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updatetahunhapus" class="btn btn-danger">Hapus Tahun
                            Pelajaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php } ?>
</section>


<?php  
    if (isset($_POST['simpanpengaturan'])) {
        $tanggal_rapor = $_POST['tanggal_rapor'];
        $tanggal_mid = $_POST['tanggal_mid'];
        $lokasi = $_POST['lokasi'];

        mysqli_query($mysqli,"UPDATE sekolah SET lokasi='$lokasi' WHERE id_sekolah='$sekolah[id_sekolah]' ");

        $cekpembagian = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM pembagian_raport WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));
        if ($cekpembagian==0) {
            mysqli_query($mysqli,"INSERT INTO pembagian_raport SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', tanggal_mid='$tanggal_mid', tanggal_rapor='$tanggal_rapor'");
        }else{
        mysqli_query($mysqli,"UPDATE pembagian_raport SET tanggal_mid='$tanggal_mid', tanggal_rapor='$tanggal_rapor' WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' ");
        }

?>
<script type="text/javascript">
Swal.fire({
    title: "Berhasil!",
    text: "Data berhasil disimpan.",
    icon: "success",
}).then(function() {
    window.location.href = "?pages=pengaturan";
});
</script>
<?php

    }
?>

<?php
    if(isset($_POST['updatetahun'])){
        $tahun_pelajaran = $_POST['tahun_pelajaran'];
        
        $cek = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM tahun_pelajaran WHERE tahun_pelajaran='$tahun_pelajaran'"));
        if($cek == 0){
            $simpan = mysqli_query($mysqli,"INSERT INTO tahun_pelajaran SET tahun_pelajaran='$tahun_pelajaran'");
            if($simpan){
?>
<script>
Swal.fire({
    title: "Berhasil!",
    text: "Data berhasil disimpan.",
    icon: "success",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script>
<?php
    }
}else{
    ?>
<script>
Swal.fire({
    title: "Gagal!",
    text: "Tahun Sudah Ada!",
    icon: "error",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script><?php
                            }
                        }
                        ?>

<?php  
    if (isset($_POST['updatetahunedit'])) {
        $id_tahun_pelajaran = $_POST['id_tahun_pelajaran'];
        $tahun_pelajaran = $_POST['tahun_pelajaran'];

        
        $simpan = mysqli_query($mysqli,"UPDATE tahun_pelajaran SET tahun_pelajaran='$tahun_pelajaran' WHERE id_tahun_pelajaran='$id_tahun_pelajaran'");
        if($simpan){
?>
<script>
Swal.fire({
    title: "Berhasil!",
    text: "Data berhasil disimpan.",
    icon: "success",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script>
<?php
        }

    }
?>

<?php  
    if (isset($_POST['updatetahunhapus'])) {
        $id_tahun_pelajaran = $_POST['id_tahun_pelajaran'];

        
        $simpan = mysqli_query($mysqli,"DELETE FROM tahun_pelajaran WHERE id_tahun_pelajaran='$id_tahun_pelajaran'");
        if($simpan){
?>
<script>
Swal.fire({
    title: "Berhasil!",
    text: "Data tahun berhasil dihapus.",
    icon: "success",
}).then(function() {
    window.location.href = "?pages=<?php echo $_GET['pages']?>";
});
</script>
<?php
        }
                
    }
?>