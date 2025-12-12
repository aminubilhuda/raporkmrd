<?php  

$dataeskul = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM eskul WHERE id_eskul='$_GET[orderID]'"));
    
?>

<?php if(empty($_GET['filter'])){ ?>

<div class="page-title-box">
    <div class="btn-group float-right">
    </div>
    <h1 class="page-title">Detail Eskul <?php echo $dataeskul['nama_eskul']?></h1>
</div>


<section class="content">

    <div class="row">
        <div class="col-md-12">
            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header bg-danger">
                    <h3 class="card-title  text-white">Detail Eskul <?php echo $dataeskul['nama_eskul']?></h3>
                    <div class="card-tools float-right">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambahAnggota">
                            <i class="fas fa-plus"></i> Tambah Anggota
                        </button>
                    </div>
                </div><!-- /.card-header -->
                <form method="POST">
                    <div class="card-body table-responsive">
                        <p>
                            <button type="submit" name="simpandata" class="btn btn-primary">Simpan Penilaian Eskul</button>
                        </p>
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr class="bg-danger text-white">
                                    <th style="height: 50px;" class="text-center align-middle">No</th>
                                    <th class="text-center align-middle">NISN</th>
                                    <th class="text-center align-middle">Nama Peserta Didik</th>
                                    <th class="text-center align-middle">Predikat</th>
                                    <th class="text-center align-middle">Keterangan</th>
                                    <th class="text-center align-middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                                $nomor=1;
                                $kelas = mysqli_query($mysqli,"SELECT * FROM siswa_eskul 
                                JOIN siswa ON siswa_eskul.id_siswa = siswa.id_siswa
                                WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$_GET[orderID]' ORDER BY nama_siswa ASC");
                                while($rkelas = mysqli_fetch_array($kelas)){
                                ?>
                                <tr>
                                    <td class="text-center align-middle"><?php echo $nomor++ ?></td>
                                    <td class="text-center align-middle"><?php echo $rkelas['nisn'] ?></td>
                                    <td><?php echo $rkelas['nama_siswa'] ?> <input type="hidden" name="siswa[]"
                                            value="<?php echo $rkelas['id_siswa']?>"></td>
                                    <td style="width:15%;">
                                        <select name="predikat[]" class="form-control">
                                            <option value="">Pilih Predikat</option>
                                            <option value="Sangat Baik"
                                                <?php if($rkelas['predikat']=="Sangat Baik"){ echo "selected";}?>>Sangat
                                                Baik</option>
                                            <option value="Baik"
                                                <?php if($rkelas['predikat']=="Baik"){ echo "selected";}?>>Baik</option>
                                            <option value="Cukup"
                                                <?php if($rkelas['predikat']=="Cukup"){ echo "selected";}?>>Cukup
                                            </option>
                                        </select>
                                    </td>
                                    <td style="width:40%;">
                                        <textarea name="keterangan[]" class="form-control"
                                            placeholder="Tuliskan Keterangan Siswa Tentang Eskul ini"><?php echo $rkelas['keterangan']?></textarea>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button type="submit" name="hapusanggota" value="<?php echo $rkelas['id_siswa_eskul'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus anggota ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.row -->

</section><!-- /.content -->

<!-- Modal Tambah Anggota -->
<div class="modal fade" id="modalTambahAnggota" tabindex="-1" role="dialog" aria-labelledby="modalTambahAnggotaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalTambahAnggotaLabel">Tambah Anggota Eskul</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="datatable2">
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
                                $cek_member = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM siswa_eskul WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$_GET[orderID]' AND id_siswa='$rsiswakelas[id_siswa]'"));
                                
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
<script>
    $(document).ready(function() {
        $('#datatable2').DataTable();
    });
</script>


<?php
        if(isset($_POST['simpandata'])){
            $siswa = $_POST['siswa'];
            $predikat = $_POST['predikat'];
            $keterangan = $_POST['keterangan'];
            
            $jumlahsiswa = count($siswa);
            for ($i=0; $i <$jumlahsiswa ; $i++) { 
            	$update = mysqli_query($mysqli,"UPDATE siswa_eskul SET predikat='$predikat[$i]', keterangan='$keterangan[$i]' WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_eskul='$_GET[orderID]' AND id_siswa='$siswa[$i]' ");
            	if($update){
            	    ?>
<script>
alert('Berhasil Update Penilaian');
window.location.href = "?pages=<?php echo $_GET['pages']?>&orderID=<?php echo $_GET['orderID']?>";
</script>
<?php
            	}
            }
        }

        // Process Add Member
        if(isset($_POST['simpan_anggota'])){
            if(!empty($_POST['pilih_siswa'])){
                $siswa_terpilih = $_POST['pilih_siswa'];
                $jumlah_sukses = 0;
                
                foreach($siswa_terpilih as $id_siswa){
                    $simpan = mysqli_query($mysqli, "INSERT INTO siswa_eskul SET tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_eskul='$_GET[orderID]', id_siswa='$id_siswa', predikat='', keterangan=''");
                    if($simpan) $jumlah_sukses++;
                }
                
                if($jumlah_sukses > 0){
                     echo "<script>alert('Berhasil menambahkan $jumlah_sukses anggota'); window.location.href='?pages=$_GET[pages]&orderID=$_GET[orderID]';</script>";
                }
            } else {
                echo "<script>alert('Tidak ada siswa yang dipilih');</script>";
            }
        }

        // Process Remove Member
        if(isset($_POST['hapusanggota'])){
            $id_siswa_eskul = $_POST['hapusanggota'];
            $hapus = mysqli_query($mysqli, "DELETE FROM siswa_eskul WHERE id_siswa_eskul='$id_siswa_eskul'");
            
            if($hapus){
                echo "<script>alert('Anggota berhasil dihapus'); window.location.href='?pages=$_GET[pages]&orderID=$_GET[orderID]';</script>";
            } else {
                echo "<script>alert('Gagal menghapus anggota');</script>";
            }
        }
        ?>


<?php } ?>