<?php
// Ensure table exists (Keep this check for safety, although TU should have created it)
$check = mysqli_query($mysqli, "SHOW TABLES LIKE 'nilai_kokurikuler'");
if(mysqli_num_rows($check) == 0){
    mysqli_query($mysqli, "CREATE TABLE nilai_kokurikuler (
        id_nilai_kokurikuler INT AUTO_INCREMENT PRIMARY KEY,
        id_proyek_kelas INT,
        semester INT,
        tahun INT,
        id_siswa INT,
        id_proyek_tujuan INT,
        nilai INT,
        nama_panggilan VARCHAR(100)
    )");
}

$id_proyek_kelas = $_GET['orderID'];
$id_kelas = $_GET['dataID'];

// Security check: Ensure this project belongs to the logged-in teacher
$cek_hak_akses = mysqli_query($mysqli, "SELECT id_user FROM proyek_kelas WHERE id_proyek_kelas='$id_proyek_kelas'");
$data_proyek = mysqli_fetch_array($cek_hak_akses);
if($data_proyek['id_user'] != $_SESSION['id_user']){
    echo "<div class='alert alert-danger'>Anda tidak memiliki hak akses untuk menilai kegiatan ini.</div>";
    exit;
}

// Save Data
if(isset($_POST['simpandata'])){
    $siswa_ids = $_POST['siswa_id'];
    $nama_panggilan = $_POST['nama_panggilan'];
    $nilai_data = $_POST['nilai']; // [siswa_id][tp_id]

    foreach($siswa_ids as $id_siswa){
        $panggilan = mysqli_real_escape_string($mysqli, $nama_panggilan[$id_siswa]);
        
        foreach($nilai_data[$id_siswa] as $id_tp => $nilai){
            $nilai = (int)$nilai;
            
            // Check existing
            $cek = mysqli_query($mysqli, "SELECT * FROM nilai_kokurikuler WHERE id_proyek_kelas='$id_proyek_kelas' AND id_siswa='$id_siswa' AND id_proyek_tujuan='$id_tp'");
            
            if(mysqli_num_rows($cek) > 0){
                mysqli_query($mysqli, "UPDATE nilai_kokurikuler SET nilai='$nilai', nama_panggilan='$panggilan' WHERE id_proyek_kelas='$id_proyek_kelas' AND id_siswa='$id_siswa' AND id_proyek_tujuan='$id_tp'");
            } else {
                mysqli_query($mysqli, "INSERT INTO nilai_kokurikuler SET id_proyek_kelas='$id_proyek_kelas', tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_siswa='$id_siswa', id_proyek_tujuan='$id_tp', nilai='$nilai', nama_panggilan='$panggilan'");
            }
        }
    }
    echo "<script>
    Swal.fire({
        title: 'Berhasil!',
        text: 'Data Berhasil Disimpan',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        window.location.href='?pages=penilaian-kokurikuler&orderID=$id_proyek_kelas&dataID=$id_kelas';
    });
    </script>";
}

// Fetch TPs
$tps = [];
$q_tp = mysqli_query($mysqli, "SELECT * FROM proyek_tujuan JOIN dimensi_kokurikuler ON proyek_tujuan.id_dimensi = dimensi_kokurikuler.id_dimensi WHERE id_proyek_kelas='$id_proyek_kelas'");
while($r = mysqli_fetch_array($q_tp)){
    $tps[] = $r;
}

// Fetch Students
$siswakelas = mysqli_query($mysqli, "SELECT * FROM siswa_kelas JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa WHERE id_kelas='$id_kelas' AND tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' ORDER BY nama_siswa ASC");

?>
<div class="container-fluid">
    <h1>Penilaian Kokurikuler</h1>
    <div class="mb-3">
        <a href="?pages=<?php echo 'kokurikuler'?>" class="btn btn-primary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

<!-- Content -->
<section class="content">
    
    <p><strong>Petunjuk Penilaian</strong></p>
    <div class="row no-gutters text-center text-white font-weight-bold mb-3">
        <?php
        $deskripsi = mysqli_query($mysqli, "SELECT * FROM deskripsi_kokurikuler ORDER BY nilai DESC");
        while($d = mysqli_fetch_array($deskripsi)){
            $label = "";
            if($d['nilai']==4) $label = "SB - Sangat Baik";
            elseif($d['nilai']==3) $label = "B - Baik";
            elseif($d['nilai']==2) $label = "C - Cukup";
            elseif($d['nilai']==1) $label = "K - Kurang";
            echo "<div class='col-md-3 p-2' style='background-color:#9dcdc9; border-right:1px solid white;'>$label</div>";
        }
        ?>
    </div>

    <p><strong>Daftar Tujuan Pembelajaran</strong></p>
    <table class="table table-bordered mb-4">
        <thead class="text-white" style="background-color:#f58666;">
            <tr>
                <th style="width: 20%;">Tujuan Pembelajaran</th>
                <th style="width: 30%;">Dimensi</th>
                <th style="width: 50%;">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tps as $i => $tp): ?>
            <tr>
                <td style="background-color:#fcece6; font-weight:bold;">TP <?php echo $i+1; ?></td>
                <td style="background-color:#fcece6;"><?php echo $tp['dimensi']; ?></td>
                <td style="background-color:#fcece6;"><?php echo $tp['deskripsi']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Form Penilaian -->
    <form method="POST">
        <table class="table table-bordered table-striped">
            <thead class="text-white" style="background-color:#f58666;">
                <tr>
                    <th class="text-center align-middle" style="width:50px;">No</th>
                    <th class="align-middle">Nama Lengkap</th>
                    <th class="align-middle d-none d-md-table-cell" style="width:250px;">Nama Panggilan</th>
                    <?php foreach($tps as $i => $tp): ?>
                    <th class="text-center align-middle" style="width:100px;">TP <?php echo $i+1; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($s = mysqli_fetch_array($siswakelas)){
                    // Get existing nickname (just take from first TP record found)
                    $q_exist = mysqli_query($mysqli, "SELECT nama_panggilan FROM nilai_kokurikuler WHERE id_proyek_kelas='$id_proyek_kelas' AND id_siswa='$s[id_siswa]' LIMIT 1");
                    $d_exist = mysqli_fetch_array($q_exist);
                    $panggilan = $d_exist['nama_panggilan'] ?? '';
                    if(empty($panggilan)){
                        $ex = explode(' ', $s['nama_siswa']);
                        $panggilan = $ex[0];
                    }
                ?>
                <tr>
                    <td class="text-center"><?php echo $no++; ?></td>
                    <td><?php echo $s['nama_siswa']; ?></td>
                    <td class="d-none d-md-table-cell">
                        <input type="hidden" name="siswa_id[]" value="<?php echo $s['id_siswa']; ?>">
                        <input type="text" name="nama_panggilan[<?php echo $s['id_siswa']; ?>]" class="form-control" value="<?php echo $panggilan; ?>">
                    </td>
                    <?php foreach($tps as $tp): ?>
                    <td width="250px">
                        <?php
                        // Get grade
                        $q_nilai = mysqli_query($mysqli, "SELECT nilai FROM nilai_kokurikuler WHERE id_proyek_kelas='$id_proyek_kelas' AND id_siswa='$s[id_siswa]' AND id_proyek_tujuan='$tp[id_proyek_tujuan]'");
                        $d_nilai = mysqli_fetch_array($q_nilai);
                        $nilai = $d_nilai['nilai'] ?? '';
                        ?>
                        <select name="nilai[<?php echo $s['id_siswa']; ?>][<?php echo $tp['id_proyek_tujuan']; ?>]" class="form-control">
                            <option value="">-</option>
                            <option value="4" <?php if($nilai==4) echo 'selected'; ?>>SB</option>
                            <option value="3" <?php if($nilai==3) echo 'selected'; ?>>B</option>
                            <option value="2" <?php if($nilai==2) echo 'selected'; ?>>C</option>
                            <option value="1" <?php if($nilai==1) echo 'selected'; ?>>K</option>
                        </select>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="text-right">
            <button type="submit" name="simpandata" class="btn btn-primary">Simpan Data</button>
        </div>
    </form>
</section>
</div>
