<?php  
date_default_timezone_set("Asia/Bangkok");

include "../bot/wa/functionbot.php";
?>

<?php if(empty($_GET['filter'])){ ?>
<section class="content-header">
    <h1>
        Pengingat
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
                    <form method="post">
                        <a href="?pages=pengingat&filter=<?php echo 'tambah' ?>" class="btn btn-primary btn-sm">Tambah
                            Data</a>
                        <?php 
                        $pengingat = mysqli_query($mysqli, "SELECT * FROM pengingat JOIN users ON pengingat.user_id=users.id_user");
                        if (mysqli_num_rows($pengingat) > 0) { 
                        ?>
                        <button type="submit" name="kirimPesan" class="btn btn-success btn-sm float-right">Jalankan
                            Jadwal</button>
                        <?php } ?>
                    </form>

                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th style="width: auto">#</th>
                                <th style="width: auto">Nama</th>
                                <th style="width: auto">Nama Pengingat</th>
                                <th style="width: auto">Jadwal</th>
                                <th style="width: auto">Dijalankan</th>
                                <th style="width: 100px">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            date_default_timezone_set("Asia/Bangkok");
                            $nomor = 1;
                            $pengingat = mysqli_query($mysqli,"SELECT * FROM pengingat JOIN users ON pengingat.user_id=users.id_user");
                            while ($data = mysqli_fetch_array($pengingat)) { ?>
                            <tr>
                                <td><?= $nomor++; ?></td>
                                <td><?= $data['nama']; ?></td>
                                <td><?= $data['nama_pengingat']; ?></td>
                                <td><?= date('d-m-Y H:i:s', strtotime($data['waktu_pengingat'])); ?></td>
                                <td>
                                    <?php 
                                    if($data['aktif'] == 1) {
                                        echo '<span class="badge badge-success">Iya</span>';
                                    } else {
                                        echo '<span class="badge badge-danger">Tidak</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="?pages=pengingat&filter=<?php echo 'edit' ?>&kode=<?php echo $data['id_pengingat'] ?>"
                                        class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo 'hapus' ?>&kode=<?php echo $data['id_pengingat'] ?>"
                                        onclick="return confirm('Yakin Hapus Data?')" class="btn btn-danger btn-sm"><i
                                            class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kirim Pesan Personal</h3>
                </div>

                <div class="card-body">
                    <p>Kirimkan Pesan Kepada Seseorang</p>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="nomorTujuan">Nomor Tujuan:</label>
                            <select class="form-control select2" name="nomorTujuan[]" multiple="multiple"
                                data-placeholder="Pilih Kontak" style="width: 100%;" required>
                                <option value="">Pilih Kontak</option>
                                <?php
                                $kontakQuery = mysqli_query($mysqli, "SELECT id_user, nama, kontak FROM users");
                                while ($kontak = mysqli_fetch_array($kontakQuery)) {
                                    echo '<option value="' . htmlspecialchars($kontak['kontak']) . '">' . htmlspecialchars($kontak['nama']) . ' (' . htmlspecialchars($kontak['kontak']) . ')</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pesan">Pesan:</label>
                            <textarea class="form-control" name="pesan" rows="4" placeholder="Masukkan pesan"
                                required></textarea>
                        </div>
                        <input type="submit" name="kirimPesanPersonal" class="btn btn-success" value="Kirim Pesan">
                    </form>

                    <?php
                    if (isset($_POST['kirimPesanPersonal'])) {
                        $nomorTujuan = $_POST['nomorTujuan'];
                        $pesan = $_POST['pesan'];
                        $responseJson = kirimPesanBroadcast($nomorTujuan, $pesan);
                        tampilkanNotifikasi($responseJson);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Form Tambah Pengingat -->
<?php }elseif($_GET['filter']=="tambah"){ ?>


<section class="content-header">
    <h1>
        Form Tambah Pengingat
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form method="POST">
                <div class="card border-danger">
                    <div class="card-header text-white">
                        <h3 class="card-title">Form Tambah Pengingat</h3>
                        <div class="float-right">
                            <a href="?pages=pengingat" class="btn btn-primary btn-sm">Kembali</a>
                            <button type="submit" name="simpandata" class="btn btn-success btn-sm">Simpan Data</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="kode" value="<?php echo $kode ?>">

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td>Nama Pengingat</td>
                                        <td><input type="text" name="nama_pengingat"
                                                class="form-control form-control-sm" required autocomplete="off"
                                                autofocus></td>
                                    </tr>
                                    <tr>
                                        <td>Jadwal</td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <th class="text-center">Tanggal</th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="datetime-local"
                                                            class="form-control form-control-sm" name="tanggal"
                                                            style="width: 200px;" required>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pesan</td>
                                        <td>
                                            <textarea name="pesan" class="form-control" rows="3"
                                                placeholder="Tulis ..."></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Aktif</td>
                                        <td>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="aktif1" name="aktif" value="1"
                                                    class="custom-control-input" checked>
                                                <label class="custom-control-label" for="aktif1">Aktif</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="aktif0" name="aktif" value="0"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="aktif0">Tidak</label>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', (event) => {
        if (event.target.checked) {
            document.querySelectorAll('input[type="radio"]:not(:checked)').forEach(r => {
                r.checked = false;
            });
        }
    });
});
</script>

<!-- simpan pengingat  -->
<?php
date_default_timezone_set("Asia/Bangkok");

    if (isset($_POST['simpandata'])) {
        $nama_pengingat = $_POST['nama_pengingat'];
        $tanggal = $_POST['tanggal'];
        $user_id = $_SESSION['id_user'];
        $pesan = $_POST['pesan'];
        $aktif = $_POST['aktif'];
        $query = mysqli_query($mysqli, "INSERT INTO pengingat (user_id, nama_pengingat, waktu_pengingat, pesan, aktif) VALUES ('$user_id','$nama_pengingat', '$tanggal', '$pesan', '$aktif')");
        if ($query) { ?>
<script>
Swal.fire({
    title: 'Sukses!',
    text: 'Data pengingat berhasil ditambah.',
    icon: 'success',
    confirmButtonText: 'OK'
}).then(function() {
    window.location.href = "?pages=pengingat";
});
</script>
<?php
} else {?>
<script>
Swal.fire({
    title: "Gagal!",
    text: "Data Gagal Ditambahkan!",
    icon: "error",
    confirmButtonText: 'OK'
});
</script>
<?php
}
}
?>
<?php }elseif($_GET['filter']=="edit"){ 
    	$pengingat = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM pengingat WHERE id_pengingat='$_GET[kode]'"));
        $datetime = $pengingat['waktu_pengingat'];
        list($tanggal, $time) = explode(' ', $datetime);
        list($jam, $menit, $detik) = explode(':', $time);
    	?>

<section class="content-header">
    <h1>
        Form Edit Pengingat
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form method="POST">
                <div class="card border-danger">
                    <div class="card-header text-white">
                        <h3 class="card-title">Form Edit Pengingat</h3>
                        <div class="float-right">
                            <a href="?pages=pengingat" class="btn btn-primary btn-sm">Kembali</a>
                            <button type="submit" name="simpandata" class="btn btn-success btn-sm">Simpan Data</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="kode" value="<?php echo $kode ?>">

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td>Nama Pengingat</td>
                                        <td><input type="text" name="nama_pengingat"
                                                class="form-control form-control-sm" required autocomplete="off"
                                                value="<?= $pengingat['nama_pengingat'] ?>" autofocus></td>
                                    </tr>
                                    <tr>
                                        <td>Jadwal</td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <th class="text-center">Tanggal</th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="datetime-local"
                                                            class="form-control form-control-sm" name="tanggal"
                                                            value="<?php echo $tanggal?>" style="width: 200px;"
                                                            required>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pesan</td>
                                        <td>
                                            <textarea name="pesan" class="form-control" rows="3"
                                                placeholder="Tulis ..."><?= $pengingat['pesan'] ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Aktif</td>
                                        <td>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="aktif1" name="aktif" value="1"
                                                    class="custom-control-input"
                                                    <?php echo ($pengingat['aktif'] == '1') ? 'checked' : ''; ?>>
                                                <label class="custom-control-label" for="aktif1">Aktif</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="aktif0" name="aktif" value="0"
                                                    class="custom-control-input"
                                                    <?php echo ($pengingat['aktif'] == '0') ? 'checked' : ''; ?>>
                                                <label class="custom-control-label" for="aktif0">Tidak</label>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
const radios = document.querySelectorAll('input[type="radio"]');
radios.forEach(radio => {
    radio.addEventListener('change', (event) => {
        if (event.target.checked) {
            radios.forEach(r => {
                if (r !== event.target) {
                    r.checked = false;
                }
            });
        }
    });
});
</script>

<!-- simpan pengingat  -->
<?php
date_default_timezone_set("Asia/Bangkok");

    if (isset($_POST['simpandata'])) {
        $nama_pengingat = $_POST['nama_pengingat'];
        $tanggal = $_POST['tanggal'];
        $user_id = $_SESSION['id_user'];
        $pesan = $_POST['pesan'];
        $aktif = $_POST['aktif'];
        $query = mysqli_query($mysqli, "UPDATE pengingat SET nama_pengingat='$nama_pengingat', waktu_pengingat='$tanggal', pesan='$pesan', aktif='$aktif' WHERE id_pengingat='$_GET[kode]'");
        if ($query) { ?>
<script>
Swal.fire({
    title: 'Sukses!',
    text: 'Data berhasil dirubah.',
    icon: 'success',
    confirmButtonText: 'OK'
}).then(function() {
    window.location.href = "?pages=pengingat";
});
</script>
<?php
} else { ?>
<script>
Swal.fire({
    title: "Gagal!",
    text: "Data Gagal Ditambahkan!",
    icon: "error",
});
</script>
<?php
}
}
?>

<?php }elseif($_GET['filter']=="hapus"){ 

    	$hapus_pengingat = mysqli_query($mysqli,"DELETE FROM pengingat WHERE id_pengingat='$_GET[kode]'");

    	if ($hapus_pengingat) { ?>
<script type="text/javascript">
Swal.fire({
    title: 'Sukses!',
    text: 'Hapus Pengingat Berhasil.',
    icon: 'success',
    confirmButtonText: 'OK'
}).then(function() {
    window.location.href = "?pages=pengingat";
});
</script>
<?php } ?>

<?php } ?>

<!-- Jalankan Jadwal -->
<?php
if(isset($_POST['kirimPesan'])) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_website."/bot/wa/kirim_pesan.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    echo "<script>alert('" . ($response ? "Pesan berhasil dikirim!" : "Pesan gagal dikirim!") . "');</script>";
}
 ?>