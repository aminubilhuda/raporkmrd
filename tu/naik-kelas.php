<?php
require_once "../config/koneksi.php";

// Ambil informasi sekolah
$sekolah = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM sekolah WHERE id_sekolah='1'"));

// Cek apakah sudah dipilih filter
if(empty($_GET['filter'])){ 
?>
<section class="content-header">
  <h1>
    Kenaikan Kelas Siswa
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Card untuk proses kenaikan kelas -->
      <div class="card border-info">
        <div class="card-header text-white bg-info">
          <h3 class="card-title">Kenaikan Kelas Tahun Ajaran <?php echo $sekolah['tahun']; ?></h3>
        </div>
        <div class="card-body">
          <div class="alert alert-warning">
            <strong>Peringatan!</strong> Proses kenaikan kelas akan memindahkan siswa dari tingkat sekarang ke tingkat
            berikutnya.
            Proses ini akan membuat data siswa_kelas baru untuk tahun ajaran berikutnya berdasarkan kenaikan tingkat.
          </div>

          <form method="POST">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Tahun Ajaran Tujuan</label>
              <div class="col-sm-10">
                <select name="tahun_tujuan" class="form-control" required>
                  <option value="">Pilih Tahun Ajaran Tujuan</option>
                  <?php
                                    // Ambil semua tahun ajaran yang ada
                                    $tahun_query = mysqli_query($mysqli, "SELECT id_tahun_pelajaran, tahun_pelajaran FROM tahun_pelajaran ORDER BY id_tahun_pelajaran DESC");
                                    while($tahun = mysqli_fetch_array($tahun_query)){
                                        echo "<option value='$tahun[id_tahun_pelajaran]'>$tahun[tahun_pelajaran]</option>";
                                    }
                                    ?>
                </select>
                <small class="form-text text-muted">
                  Pilih tahun ajaran yang akan datang sebagai tujuan kenaikan kelas.
                </small>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Semester Tujuan</label>
              <div class="col-sm-10">
                <select name="semester_tujuan" class="form-control" required>
                  <option value="1">Ganjil (Semester 1)</option>
                  <option value="2">Genap (Semester 2)</option>
                </select>
                <small class="form-text text-muted">
                  Pilih semester tujuan (biasanya Ganjil/1 untuk awal tahun ajaran baru).
                </small>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-10 offset-sm-2">
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#konfirmasiModal">
                  <i class="fas fa-arrow-up"></i> Proses Kenaikan Kelas
                </button>
              </div>
            </div>

            <!-- Modal Konfirmasi -->
            <div class="modal fade" id="konfirmasiModal" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Konfirmasi Kenaikan Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                    <p>Anda akan melakukan proses kenaikan kelas/tingkat untuk semua siswa aktif.</p>
                    <p><strong>Peringatan:</strong> Proses ini tidak dapat dibatalkan. Data kelas tahun sekarang akan
                      diarsipkan dan dibuatkan data kelas baru untuk tahun tujuan.</p>
                    <p>Apakah Anda yakin ingin melanjutkan?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="kenaikan_kelas" class="btn btn-success">
                      <i class="fas fa-check"></i> Ya, Proses Sekarang
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Card untuk menampilkan ringkasan kenaikan kelas -->
      <div class="card border-info">
        <div class="card-header text-white bg-info">
          <h3 class="card-title">Ringkasan Kenaikan Kelas</h3>
        </div>
        <div class="card-body">
          <?php
                    // Hitung jumlah siswa berdasarkan tingkat
                    $ringkasan_kelas = mysqli_query($mysqli, "
                        SELECT 
                            t.tingkat,
                            t.akhir as tingkat_akhir,
                            COUNT(s.id_siswa) as jumlah_siswa
                        FROM siswa_kelas sk
                        JOIN siswa s ON sk.id_siswa = s.id_siswa
                        JOIN tingkat t ON sk.id_tingkat = t.id_tingkat
                        WHERE sk.tahun='$sekolah[tahun]' 
                        AND sk.semester='$sekolah[semester]' 
                        AND sk.status='1' 
                        AND s.aktif='1'
                        GROUP BY t.id_tingkat
                        ORDER BY t.id_tingkat
                    ");
                    ?>
          <div class="row">
            <?php while($r_ringkasan = mysqli_fetch_array($ringkasan_kelas)) { 
                            $keterangan = $r_ringkasan['tingkat_akhir'] == 1 ? "Tingkat Akhir (Akan Lulus)" : "Akan Naik Kelas";
                            $kelas_status = $r_ringkasan['tingkat_akhir'] == 1 ? "danger" : "primary";
                        ?>
            <div class="col-md-4 mb-3">
              <div class="card border-<?php echo $kelas_status; ?> h-100">
                <div class="card-body text-center">
                  <h5 class="card-title">Kelas <?php echo $r_ringkasan['tingkat']; ?></h5>
                  <h3 class="text-<?php echo $kelas_status; ?>"><?php echo $r_ringkasan['jumlah_siswa']; ?> Siswa</h3>
                  <p class="card-text mt-2">
                    <span class="badge badge-<?php echo $kelas_status; ?>">
                      <?php echo $keterangan; ?>
                    </span>
                  </p>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>

      <!-- Card untuk menampilkan daftar siswa per kelas -->
      <div class="card border-info">
        <div class="card-header text-white bg-info">
          <h3 class="card-title">Daftar Kelas dan Siswa</h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="width:100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Kelas</th>
                  <th>Tingkat</th>
                  <th>Program Keahlian</th>
                  <th>Jumlah Siswa</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                                $nomor = 1;
                                // Ambil daftar kelas dengan jumlah siswa di dalamnya
                                $kelas_list = mysqli_query($mysqli, "
                                    SELECT 
                                        k.id_kelas,
                                        k.nama_kelas,
                                        t.tingkat,
                                        t.akhir as tingkat_akhir,
                                        kk.kompetensi_keahlian,
                                        COUNT(sk.id_siswa) as jumlah_siswa
                                    FROM kelas k
                                    JOIN tingkat t ON k.id_tingkat = t.id_tingkat
                                    JOIN kompetensi_keahlian kk ON k.id_kompetensi_keahlian = kk.id_kompetensi_keahlian
                                    LEFT JOIN siswa_kelas sk ON k.id_kelas = sk.id_kelas AND sk.tahun='$sekolah[tahun]' AND sk.semester='$sekolah[semester]' AND sk.status='1'
                                    LEFT JOIN siswa s ON sk.id_siswa = s.id_siswa AND s.aktif='1'
                                    GROUP BY k.id_kelas
                                    ORDER BY t.id_tingkat, k.nama_kelas
                                ");
                                
                                while($r_kelas = mysqli_fetch_array($kelas_list)){
                                    $keterangan = $r_kelas['tingkat_akhir'] == 1 ? "Tingkat Akhir (Akan Lulus)" : "Akan Naik Kelas";
                                    $kelas_status = $r_kelas['tingkat_akhir'] == 1 ? "danger" : "primary";
                                ?>
                <tr class="<?php echo $r_kelas['tingkat_akhir'] == 1 ? 'table-danger' : ''; ?>">
                  <td><?php echo $nomor++; ?></td>
                  <td><?php echo $r_kelas['nama_kelas']; ?></td>
                  <td><?php echo $r_kelas['tingkat']; ?></td>
                  <td><?php echo $r_kelas['kompetensi_keahlian']; ?></td>
                  <td><?php echo $r_kelas['jumlah_siswa']; ?></td>
                  <td><span class="badge badge-<?php echo $kelas_status; ?>"><?php echo $keterangan; ?></span></td>
                  <td>
                    <a href="?pages=naik-kelas&filter=detail_kelas&kelas_id=<?php echo $r_kelas['id_kelas']; ?>"
                      class="btn btn-info btn-sm" data-toggle="tooltip" title="Lihat Detail Siswa">
                      <i class="fas fa-list"></i> Detail
                    </a>
                  </td>
                </tr>
                <?php
                                }
                                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
$(document).ready(function() {
  $('#datatable').DataTable();
});
</script>

<?php
}elseif($_GET['filter']=="detail_kelas"){
    // Menampilkan detail kenaikan kelas per kelas
    $kelas_id = $_GET['kelas_id'];
    $kelas = mysqli_fetch_array(mysqli_query($mysqli, "
        SELECT k.nama_kelas, t.tingkat, kk.kompetensi_keahlian 
        FROM kelas k 
        JOIN tingkat t ON k.id_tingkat = t.id_tingkat 
        JOIN kompetensi_keahlian kk ON k.id_kompetensi_keahlian = kk.id_kompetensi_keahlian 
        WHERE k.id_kelas = '$kelas_id'
    "));
?>
<section class="content-header">
  <h1>
    Detail Kenaikan Kelas - <?php echo $kelas['nama_kelas']; ?>
  </h1>
  <a href="?pages=naik-kelas" class="btn btn-primary">Kembali</a>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card border-info">
        <div class="card-header text-white bg-info">
          <h3 class="card-title">Daftar Siswa Kelas <?php echo $kelas['nama_kelas']; ?></h3>
        </div>
        <div class="card-body">
          <table id="datatable" class="table table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Tingkat Saat Ini</th>
                <th>Tingkat Tujuan</th>
                <th>Status Kenaikan</th>
              </tr>
            </thead>
            <tbody>
              <?php
                            $nomor = 1;
                            $siswa_kelas = mysqli_query($mysqli, "
                                SELECT 
                                    s.id_siswa,
                                    s.nama_siswa,
                                    s.nisn,
                                    t.tingkat as tingkat_sekarang,
                                    CASE 
                                        WHEN t.akhir = 1 THEN 'Tidak Naik (Lulus)'
                                        ELSE (t.tingkat + 1)
                                    END as tingkat_tujuan,
                                    CASE 
                                        WHEN t.akhir = 1 THEN 'Lulus'
                                        ELSE 'Akan Naik'
                                    END as status
                                FROM siswa_kelas sk
                                JOIN siswa s ON sk.id_siswa = s.id_siswa
                                JOIN tingkat t ON sk.id_tingkat = t.id_tingkat
                                WHERE sk.id_kelas = '$kelas_id'
                                AND sk.tahun='$sekolah[tahun]' 
                                AND sk.semester='$sekolah[semester]' 
                                AND sk.status='1'
                                AND s.aktif='1'
                                ORDER BY s.nama_siswa
                            ");
                            
                            while($r_siswa = mysqli_fetch_array($siswa_kelas)){
                            ?>
              <tr>
                <td><?php echo $nomor++; ?></td>
                <td><?php echo $r_siswa['nama_siswa']; ?></td>
                <td><?php echo $r_siswa['nisn']; ?></td>
                <td><?php echo $r_siswa['tingkat_sekarang']; ?></td>
                <td><?php echo $r_siswa['tingkat_tujuan']; ?></td>
                <td>
                  <span class="badge badge-<?php echo $r_siswa['status'] == 'Lulus' ? 'danger' : 'success'; ?>">
                    <?php echo $r_siswa['status']; ?>
                  </span>
                </td>
              </tr>
              <?php
                            }
                            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
$(document).ready(function() {
  $('#datatable').DataTable();
});
</script>

<?php
}

// Proses kenaikan kelas
if(isset($_POST['kenaikan_kelas'])){
    $tahun_tujuan = $_POST['tahun_tujuan'];
    $semester_tujuan = $_POST['semester_tujuan'];
    
    if(empty($tahun_tujuan) || empty($semester_tujuan)){
        echo "<script>alert('Tahun dan semester tujuan harus diisi!');</script>";
    } else {
        // Mulai transaksi untuk memastikan integritas data
        mysqli_autocommit($mysqli, FALSE);
        
        try {
            // Ambil semua data siswa_kelas aktif saat ini
            $siswa_kelas_aktif = mysqli_query($mysqli, "
                SELECT 
                    sk.id_siswa_kelas,
                    sk.id_siswa,
                    sk.id_kelas,
                    sk.id_tingkat,
                    s.jurusan,
                    t.akhir as tingkat_akhir
                FROM siswa_kelas sk
                JOIN siswa s ON sk.id_siswa = s.id_siswa
                JOIN tingkat t ON sk.id_tingkat = t.id_tingkat
                WHERE sk.tahun='$sekolah[tahun]' AND sk.semester='$sekolah[semester]' AND sk.status='1' AND s.aktif='1'
            ");
            
            $jumlah_berhasil = 0;
            $jumlah_lulus = 0;
            
            while($r_siswa = mysqli_fetch_array($siswa_kelas_aktif)){
                if($r_siswa['tingkat_akhir'] == 1){
                    // Jika ini tingkat akhir (XII), maka siswa dianggap lulus
                    // Update status siswa_kelas saat ini menjadi 2 (tidak aktif)
                    // mysqli_query($mysqli, "UPDATE siswa_kelas SET status='2' WHERE id_siswa_kelas='$r_siswa[id_siswa_kelas]'");
                    // $jumlah_lulus++;
                } else {
                    // Jika bukan tingkat akhir, maka naik ke tingkat berikutnya
                    // 1. Update status siswa_kelas saat ini menjadi 2 (tidak aktif)
                    // mysqli_query($mysqli, "UPDATE siswa_kelas SET status='2' WHERE id_siswa_kelas='$r_siswa[id_siswa_kelas]'");
                    
                    // 2. Cari kelas tujuan berdasarkan tingkat+1 dan jurusan
                    $tingkat_baru = $r_siswa['id_tingkat'] + 1;
                    $kelas_baru = mysqli_query($mysqli, "
                        SELECT id_kelas 
                        FROM kelas 
                        WHERE id_tingkat='$tingkat_baru' AND id_kompetensi_keahlian='$r_siswa[jurusan]'
                        LIMIT 1
                    ");
                    
                    $kelas_baru_data = mysqli_fetch_array($kelas_baru);
                    if($kelas_baru_data){
                        $id_kelas_baru = $kelas_baru_data['id_kelas'];
                        
                        // 3. Insert data siswa_kelas baru untuk tahun ajaran tujuan
                        $insert_kelas_baru = mysqli_query($mysqli, "
                            INSERT INTO siswa_kelas 
                            SET 
                                tahun='$tahun_tujuan',
                                semester='$semester_tujuan',
                                id_tingkat='$tingkat_baru',
                                id_kelas='$id_kelas_baru',
                                id_siswa='$r_siswa[id_siswa]',
                                status='1'
                        ");
                        
                        if($insert_kelas_baru) {
                            $jumlah_berhasil++;
                        }
                    } else {
                        // Jika tidak ditemukan kelas dengan kombinasi tingkat+1 dan jurusan yang sama
                        // Tambahkan error handling atau default kelas
                        $message = "Kelas untuk tingkat $tingkat_baru dan jurusan $r_siswa[jurusan] tidak ditemukan";
                        echo "<script>alert('$message');</script>";
                    }
                }
            }
            
            // Commit transaksi jika semua berhasil
            mysqli_commit($mysqli);
            mysqli_autocommit($mysqli, TRUE);
            
            echo "<script>
                alert('Proses kenaikan kelas berhasil!\\nJumlah siswa yang naik kelas: $jumlah_berhasil\\nJumlah siswa yang lulus: $jumlah_lulus');
                window.location.href = '?pages=naik-kelas';
            </script>";
            
        } catch(Exception $e) {
            // Rollback jika terjadi kesalahan
            mysqli_rollback($mysqli);
            mysqli_autocommit($mysqli, TRUE);
            
            echo "<script>
                alert('Terjadi kesalahan saat proses kenaikan kelas: " . mysqli_error($mysqli) . "');
                window.location.href = '?pages=naik-kelas';
            </script>";
        }
    }
}
?>
</content>