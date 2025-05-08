<section class="content-header">
    <h1>
        Deskripsi Rapor
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card border-danger">
                <div class="card-header bg-danger">
                    <h3 class="card-title  text-white">Daftar Deskripsi Rapor</h3>
                    <div class="float-right">
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <div class="form-group">
                        <form action="" method="post">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr style="background-color: #007bff; color: white;">
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Kriteria</th>
                                        <th style="text-align: center;">Awalan Deskripsi Rapor</th>
                                        <th style="text-align: center;">Contoh Deskripsi Rapor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                $no = 1;
                                $query_deskripsi = mysqli_query($mysqli, "SELECT * FROM deskripsi_rapor ORDER BY id_deskripsi DESC");
                                while ($data = mysqli_fetch_array($query_deskripsi)) {
                            ?>
                                    <tr>
                                        <td style="text-align: center;"><?=$no++;?></td>
                                        <td style="text-align: center;">
                                            <input type="text" name="kriteria[]" value="<?=$data['kriteria']?>"
                                                class="form-control" readonly>
                                        </td>
                                        <td width="70%">
                                            <input type="text" name="keterangan[]" value="<?=$data['keterangan']?>"
                                                class="form-control">
                                        </td>
                                        <td style="text-align: center;">
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#exampleModal<?=$data['id_deskripsi']?>">
                                                Contoh Deskripsi
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal<?=$data['id_deskripsi']?>"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <!-- Mengubah ukuran modal menjadi lebih kecil -->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Contoh
                                                                Deskripsi Rapor</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>
                                                                <b><?=$data['keterangan']?></b>
                                                                <?=$data['contoh']?>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal -->
                                            <input type="hidden" name="id[]" value="<?=$data['id_deskripsi']?>">
                                            <input type="hidden" name="contoh[]" value="<?=$data['contoh']?>"
                                                class="form-control">

                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <button type="submit" name="edit-deskripsi" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
if (isset($_POST['edit-deskripsi'])) {
    // Loop through each record
    foreach ($_POST['id'] as $index => $id) {
        // Get the corresponding kriteria, keterangan, and contoh values
        $kriteria = $_POST['kriteria'][$index];
        $keterangan = $_POST['keterangan'][$index];
        $contoh = $_POST['contoh'][$index];

        // Update each record
        $query = mysqli_query($mysqli, "UPDATE deskripsi_rapor SET kriteria='$kriteria', keterangan='$keterangan', contoh='$contoh' WHERE id_deskripsi='$id'");
    }

    if ($query) {
        echo "
            <script>
                Swal.fire({
                    title: 'Deskripsi Rapor Berhasil Diedit!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                    }).then(() => {
                    window.location.href = '?pages=deskripsi-rapor';
                    });
            </script>
        ";
    } else {
        echo "
            <script>
                Swal.fire({
                    title: 'Terjadi Kesalahan!',
                    text: 'Kesalahan dalam Pengeditan!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
        ";
    }
}
?>