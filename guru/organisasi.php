<?php  
// Fetch organization data
$dataorganisasi = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM organisasi WHERE id_organisasi='$_GET[orderID]'"));

// Security check: Ensure the logged-in user is a pembina of this organization
$cekpembina = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM pembina_organisasi 
WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_organisasi='$_GET[orderID]' AND id_user='$_SESSION[id_user]'"));

if ($cekpembina == 0) {
    echo "<script>window.location.href='?pages=dashboard';</script>";
    exit;
}
?>

<div class="page-title-box">
    <div class="btn-group float-right">
    </div>
    <h1 class="page-title">Anggota Organisasi <?php echo $dataorganisasi['nama_organisasi']?></h1>
</div>


<section class="content">

    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">Daftar Anggota <?php echo $dataorganisasi['nama_organisasi']?></h3>
                    <div class="card-tools float-right">
                         <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahAnggota">
                            <i class="fas fa-plus"></i> Tambah Anggota
                        </button>
                    </div>
                </div><!-- /.card-header -->
                
                <div class="card-body table-responsive">
                    <form method="POST">
                        <table class="table table-striped table-bordered table-sm" id="datatable">
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th style="height: 50px;" class="text-center align-middle">No</th>
                                    <th class="text-center align-middle">NISN</th>
                                    <th class="text-center align-middle">Nama Peserta Didik</th>
                                    <th class="text-center align-middle">Kelas</th>
                                    <!-- Only show delete action if needed, or maybe just list -->
                                    <th class="text-center align-middle">Aksi</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                                $nomor=1;
                                $anggota = mysqli_query($mysqli,"SELECT * FROM siswa_organisasi 
                                JOIN siswa ON siswa_organisasi.id_siswa = siswa.id_siswa
                                WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_organisasi='$_GET[orderID]' ORDER BY nama_siswa ASC");
                                while($ranggota = mysqli_fetch_array($anggota)){
                                    $datakelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$ranggota[id_siswa]'"));
                                    $kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE id_kelas='$datakelas[id_kelas]'"));
                                ?>
                                <tr>
                                    <td class="text-center align-middle"><?php echo $nomor++ ?></td>
                                    <td class="text-center align-middle"><?php echo $ranggota['nisn'] ?></td>
                                    <td><?php echo $ranggota['nama_siswa'] ?></td>
                                    <td class="text-center align-middle"><?php echo $kelas['nama_kelas'] ?></td>
                                    <td class="text-center align-middle">
                                        <button type="submit" name="hapusanggota" value="<?php echo $ranggota['id_siswa_organisasi'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus anggota ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- /.row -->

</section><!-- /.content -->

<!-- Modal Tambah Anggota -->
<div class="modal fade" id="modalTambahAnggota" tabindex="-1" role="dialog" aria-labelledby="modalTambahAnggotaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalTambahAnggotaLabel">Tambah Anggota Organisasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="datatable2"> <!-- Use a different ID or re-init datatable if needed -->
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pilih</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no_tambah = 1;
                            // List all students active in this semester
                            $siswakelas = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
                            JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                            WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' ORDER BY id_tingkat, id_kelas, nama_siswa ASC");
                            
                            while ($rsiswakelas = mysqli_fetch_array($siswakelas)) {
                                $kelas_siswa = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE id_kelas='$rsiswakelas[id_kelas]'"));
                                
                                // Check if already a member
                                $cek_member = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM siswa_organisasi WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_organisasi='$_GET[orderID]' AND id_siswa='$rsiswakelas[id_siswa]'"));
                                
                                if ($cek_member == 0) {
                            ?>
                            <tr>
                                <td><?php echo $no_tambah++; ?></td>
                                <td class="text-center">
                                    <input type="checkbox" name="pilih_siswa[]" value="<?php echo $rsiswakelas['id_siswa']; ?>">
                                </td>
                                <td><?php echo $rsiswakelas['nama_siswa']; ?></td>
                                <td><?php echo $kelas_siswa['nama_kelas']; ?></td>
                            </tr>
                            <?php 
                                } 
                            } 
                            ?>
                        </tbody>
                    </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="simpan_anggota" class="btn btn-success">Simpan Anggota Terpilih</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Process Remove Member
if(isset($_POST['hapusanggota'])){
    $id_siswa_organisasi = $_POST['hapusanggota'];
    $hapus = mysqli_query($mysqli, "DELETE FROM siswa_organisasi WHERE id_siswa_organisasi='$id_siswa_organisasi'");
    
    if($hapus){
        echo "<script>alert('Anggota berhasil dihapus'); window.location.href='?pages=organisasi&orderID=$_GET[orderID]';</script>";
    } else {
        echo "<script>alert('Gagal menghapus anggota');</script>";
    }
}

// Process Add Member
if(isset($_POST['simpan_anggota'])){
    if(!empty($_POST['pilih_siswa'])){
        $siswa_terpilih = $_POST['pilih_siswa'];
        $jumlah_sukses = 0;
        
        foreach($siswa_terpilih as $id_siswa){
            $simpan = mysqli_query($mysqli, "INSERT INTO siswa_organisasi SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_organisasi='$_GET[orderID]', id_siswa='$id_siswa'");
            if($simpan) $jumlah_sukses++;
        }
        
        if($jumlah_sukses > 0){
             echo "<script>alert('Berhasil menambahkan $jumlah_sukses anggota'); window.location.href='?pages=organisasi&orderID=$_GET[orderID]';</script>";
        }
    } else {
        echo "<script>alert('Tidak ada siswa yang dipilih');</script>";
    }
}
?>

<script>
    $(document).ready(function() {
        // Initialize datatables if not already handled comprehensively by app.js for #datatable
        // If app.js handles #datatable automatically, we might need to be careful with #datatable2
        // Assuming standard admin template often auto-inits #datatable.
        // We'll init #datatable2 manually if needed or rely on user to search.
        $('#datatable2').DataTable();
    });
</script>
