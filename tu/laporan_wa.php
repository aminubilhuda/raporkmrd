<?php  

date_default_timezone_set("Asia/Bangkok");
include "../bot/wa/functionbot.php";
?>
<section class="content-header">
    <h1>
        Laporan Pengiriman Pesan
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pengingat</h3>
                </div>
                <div class="card-body">
                    <form action="" method="post" class="mb-3">
                        <div class="col-md-12">
                            <input type="submit" name="kosongkan_laporan" class="btn btn-danger"
                                value="Kosongkan Laporan">
                        </div>
                    </form>
                    <table id="example1" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: auto">#</th>
                                <th style="width: auto">Nomor Wa</th>
                                <th style="width: auto">Status Pengiriman</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            $query = mysqli_query($mysqli, "SELECT * FROM laporan_wa ORDER BY status_pengiriman DESC");
                            while ($data_laporan = mysqli_fetch_assoc($query)){ 
                                $no++;
                                ?>
                            <tr>
                                <td><?=$no?></td>
                                <td><?=$data_laporan['kontak']?></td>
                                <td>
                                    <span
                                        class="badge <?=($data_laporan['status_pengiriman'] == 'true' ? 'badge-success' : 'badge-danger')?>">
                                        <?=($data_laporan['status_pengiriman'] == 'true' ? 'Berhasil' : 'Gagal')?>
                                    </span>
                                </td>
                            </tr>
                            <?php }; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
    if (isset($_POST['kosongkan_laporan'])) {
        mysqli_query($mysqli, "TRUNCATE TABLE laporan_wa"); ?>
<script>
Swal.fire({
    title: 'Sukses!',
    text: 'Laporan berhasil dikosongkan.',
    icon: 'success',
    confirmButtonText: 'OK'
}).then(function() {
    window.location.href = '';
});
</script>";
<?php } ?>