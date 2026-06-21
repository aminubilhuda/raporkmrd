<?php
// Pastikan user sudah login dan session tersedia
$id_user_guru = $_SESSION['id_user']; // Asumsi session id_user menyimpan ID guru yang login
?>
<div class="container-fluid mt-4 bg-white p-4 shadow-sm">
  <h2>KEGIATAN KOKURIKULER</h2>
  <div class="table-responsive">
    <table id="datatable" class="table table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Kelas</th>
          <th>Judul Kegiatan</th>
          <th>Pembina</th>
          <th>Siswa</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php  
            // Filter proyek berdasarkan id_user pembina
            $sql = mysqli_query($mysqli, "SELECT * FROM proyek_kelas
            JOIN kelas ON proyek_kelas.id_kelas = kelas.id_kelas
            JOIN users ON proyek_kelas.id_user = users.id_user
            WHERE proyek_kelas.tahun='$sekolah[tahun]' 
            AND proyek_kelas.semester='$sekolah[semester]'
            AND proyek_kelas.id_user='$id_user_guru'");
            
            $no = 1;
            while($r = mysqli_fetch_array($sql)){
        ?>
        <tr>
          <td><?php echo $no++ ?></td>
          <td><?php echo $r['nama_kelas'] ?></td>
          <td><?php echo $r['judul_proyek'] ?></td>
          <td><?php echo $r['nama'] ?></td>
          <td>
            <?php
                $siswa = mysqli_query($mysqli, "SELECT * FROM siswa_kelas WHERE id_kelas='$r[id_kelas]' AND tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'");
                $jumlah = mysqli_num_rows($siswa);
                echo $jumlah;
            ?>
          </td>
          <td>
            <a href="?pages=penilaian-kokurikuler&orderID=<?php echo $r['id_proyek_kelas'] ?>&dataID=<?php echo $r['id_kelas'] ?>"
              class="btn btn-success btn-sm">Nilai</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
