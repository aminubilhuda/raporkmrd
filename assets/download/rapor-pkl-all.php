<?php  
include "../../config/function_antiinjection.php";
include "../../config/koneksi.php";
include "../../config/kode.php";
include "../../config/function_date.php";
error_reporting(0);

$user = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$_GET[dataID]'"));
$sekolah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sekolah WHERE id_sekolah='1'"));
$guru = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$_GET[dataID]'"));
$tahun = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tahun_pelajaran WHERE id_tahun_pelajaran='$sekolah[tahun]'"));
$semester = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM semester WHERE id_semester='$sekolah[semester]'"));
$pembagian = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM pembagian_raport WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));

$kepala = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE jabatan='1'"));
$kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas 
JOIN tingkat ON kelas.id_tingkat = tingkat.id_tingkat
WHERE id_kelas='$_GET[kelasID]'"));

$tingkatsekarang = $kelas['id_tingkat'];
$tingkatnaik = $tingkatsekarang+1;
$datatingkat = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tingkat WHERE id_tingkat='$tingkatnaik'"));

// Mengambil semua siswa di kelas
$all_siswa = mysqli_query($mysqli, "SELECT DISTINCT s.* 
    FROM siswa s
    JOIN siswa_kelas sk ON s.id_siswa = sk.id_siswa
    JOIN siswa_prakerin sp ON s.id_siswa = sp.id_siswa
    WHERE sk.tahun='$sekolah[tahun]' 
    AND sk.semester='$sekolah[semester]'
    AND sk.id_kelas='$_GET[kelasID]'
    ORDER BY s.nama_siswa ASC");

ob_start();
?>

<style type="text/css">
table.page_header {
  width: 780px;
  border: none;
  padding: 2mm;
  margin-top: -50px;
  font-size: 10px;
  margin-left: -10px;
}

table.page_footer {
  width: 780px;
  border: none;
  background-color: #fba4c7;
  border-top: solid 1mm red;
  padding: 1mm;
  margin-left: -10px;
}

h1 {
  color: #000033
}

h2 {
  color: #000055
}

h3 {
  color: #000077
}
</style>

<?php
// Loop melalui semua siswa
while($siswa = mysqli_fetch_array($all_siswa)) {
    $siswakelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$siswa[id_siswa]'"));
?>

<page backtop="37mm" backbottom="7mm" backleft="7mm" backright="10mm">
  <page_header width="750" align="center">
    <table style="width: 96%; border-collapse: collapse; margin-top: 20px; margin-left:23px;">
      <tr>
        <td style="width: 25%; text-align: left; height: 15px; font-size: 12px;">Nama</td>
        <td style="width: 3%; text-align: center;">:</td>
        <td style="width: 37%; text-align: left; font-size: 12px;">
          <?php echo strtoupper($siswa['nama_siswa']) ?></td>
        <td style="width: 5%; text-align: center;"></td>
        <td style="width: 17%; text-align: left; font-size: 12px;">Kelas</td>
        <td style="width: 3%; text-align: center;">:</td>
        <td style="width: 17%; text-align: left; font-size: 12px;">
          <?php echo strtoupper($kelas['nama_kelas']) ?></td>
      </tr>
      <tr>
        <td style="width: 25%; text-align: left; height: 15px; font-size: 12px;">NIS / NISN</td>
        <td style="width: 3%; text-align: center;">:</td>
        <td style="width: 37%; text-align: left; font-size: 12px;">
          <?php echo strtoupper($siswa['nis']." / ".$siswa['nisn']) ?>
        </td>
        <td style="width: 5%; text-align: center;"></td>
        <td style="width: 17%; text-align: left; font-size: 12px;">Fase</td>
        <td style="width: 3%; text-align: center;">:</td>
        <td style="width: 17%; text-align: left; font-size: 12px;"><?php echo strtoupper($kelas['fase']) ?></td>
      </tr>
      <tr>
        <td style="width: 25%; text-align: left; height: 15px; font-size: 12px;">Nama Sekolah</td>
        <td style="width: 3%; text-align: center;">:</td>
        <td style="width: 37%; text-align: left; font-size: 12px;">
          <?php echo strtoupper($sekolah['nama_sekolah']) ?></td>
        <td style="width: 5%; text-align: center;"></td>
        <td style="width: 17%; text-align: left; font-size: 12px;">Semester</td>
        <td style="width: 3%; text-align: center;">:</td>
        <td style="width: 17%; text-align: left; font-size: 12px;">
          <?php echo strtoupper($semester['semester']) ?></td>
      </tr>
      <tr>
        <td style="width: 25%; text-align: left; height: 15px; font-size: 12px;">Alamat</td>
        <td style="width: 3%; text-align: center;">:</td>
        <td style="width: 37%; text-align: left; font-size: 12px;"><?php echo strtoupper($sekolah['alamat']) ?>
        </td>
        <td style="width: 5%; text-align: center;"></td>
        <td style="width: 17%; text-align: left; font-size: 12px;">Tahun Pelajaran</td>
        <td style="width: 3%; text-align: center;">:</td>
        <td style="width: 17%; text-align: left; font-size: 12px;">
          <?php echo strtoupper($tahun['tahun_pelajaran']) ?></td>
      </tr>
    </table>
    <hr style="margin-left:23px; width:87%; margin-right:23px;">

  </page_header>
  <page_footer width="750">
    <hr style="margin-left:23px; width:85%; color:#f1efef;">
    <table style="margin-left:23px; width:100%;">
      <tr>
        <td style="width: 50%; text-align: left; font-size: 10px;"><?php echo $kelas['nama_kelas']?> /
          <?php echo $siswa['nama_siswa']?> / <?php echo $siswa['nisn']?></td>
        <td style="width: 50%; text-align: right; font-size: 10px;">Halaman [[page_cu]] </td>
      </tr>
    </table>
  </page_footer>

  <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    <tr>
      <td style="width: 100%; text-align: center; font-size:18px;"><b>LAPORAN HASIL BELAJAR</b></td>
    </tr>
  </table>

  <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    <tr>
      <td style="width: 100%; text-align: left;"><b></b></td>
    </tr>
  </table>

  <!-- baris nilai intrakurikuler -->

  <table style="width: 100%; border-collapse: collapse; margin-top: 10px;" border="1">
    <tr style="background-color:#f5f3f3;">
      <td style="width: 5%; text-align: center; vertical-align: middle; height: 30px;"><b>No</b></td>
      <td style="width: 30%; text-align: center; vertical-align: middle; height: 30px;"><b>Mata Pelajaran</b></td>
      <td style="width: 15%; text-align: center; vertical-align: middle; height: 30px;"><b>Nilai</b></td>
      <td style="width: 50%; text-align: center; vertical-align: middle; height: 30px;"><b>Capaian Kompetensi</b>
      </td>
    </tr>
    <?php
    	$kelompokmapel = mysqli_query($mysqli,"SELECT * FROM kelompok_mapel WHERE huruf='B' ORDER BY id_kelompok ASC");
    	while($rkelompok = mysqli_fetch_array($kelompokmapel)){
    	?>
    <tr>
      <td style="width: 100%; text-align: left; padding:5px; height: 10px;" colspan="4">
        <b><?php echo $rkelompok['huruf'].". ".$rkelompok['kelompok']?></b>
      </td>
    </tr>

    <?php  
    	$nomor=1;
        // Mengambil data dari tabel nilai_prakerin dan mapel berdasarkan kelompok mapel
    	$mapel = mysqli_query($mysqli, "
            SELECT DISTINCT np.id_mapel, m.nama_mapel, np.nilai, np.capaian_kompetensi, m.urut
            FROM nilai_prakerin np
            JOIN mapel m ON np.id_mapel = m.id_mapel
            WHERE np.tahun = '$sekolah[tahun]' 
            AND np.semester = '$sekolah[semester]'
            AND np.id_siswa = '$siswa[id_siswa]'
            AND m.id_kelompok = '$rkelompok[id_kelompok]'
            ORDER BY m.urut ASC
        ");
    	
        while ($rmapel = mysqli_fetch_array($mapel)) {
    	?>

    <tr>
      <td style="width: 5%; text-align: center; vertical-align: middle;"><?php echo $nomor++ ?></td>
      <td style="width: 30%; text-align: left; padding: 3px; vertical-align: middle;">
        <?php echo $rmapel['nama_mapel'] ?></td>
      <td style="width: 15%; text-align: center; vertical-align: middle;">
        <?php echo round($rmapel['nilai'],0) ?>
      </td>
      <td style="width: 50%; padding: 5px; vertical-align: top; text-align: justify;">
        <div style="width:100%; display:inline-block; word-wrap:break-word;">
          <?php echo nl2br($rmapel['capaian_kompetensi']); ?>
        </div>
      </td>
    </tr>
    <?php } ?>

    <?php } ?>
  </table>

  <div style="page-break-inside: avoid;">
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
      <tr>
        <td style="width: 100%; text-align: left;"><b>Ekstrakurikuler</b></td>
      </tr>
    </table>
    <!-- data Ekstrakurikuler yang digeluti -->

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;" border="1">
      <tr>
        <td style="width: 5%; text-align: center;">No</td>
        <td style="width: 30%; text-align: center;">Ekstrakurikuler</td>
        <td style="width: 15%; text-align: center; vertical-align: middle; height: 20px;">Predikat</td>
        <td style="width: 50%; text-align: center; vertical-align: middle; height: 20px;">Keterangan</td>
      </tr>
      <?php  
        $nomor = 1;
        $eskul = mysqli_query($mysqli,"SELECT * FROM siswa_eskul WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$siswa[id_siswa]' ORDER BY id_eskul ASC");
        $jumlah_eskul = mysqli_num_rows($eskul); // menghitung jumlah data yang diambil

        if ($jumlah_eskul > 0) {
            while ($reskul = mysqli_fetch_array($eskul)) {
                $dataeskul = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM eskul WHERE id_eskul='$reskul[id_eskul]'"));
    ?>
      <tr>
        <td style="width: 5%; text-align: center;"><?php echo $nomor++ ?></td>
        <td style="width: 30%; text-align: left; padding: 3px;"><?php echo $dataeskul['nama_eskul'] ?></td>
        <td style="width: 15%; text-align: center; vertical-align: middle; padding: 3px;">
          <?php echo $reskul['predikat'] ?></td>
        <td style="width: 50%; text-align: left; padding: 3px; vertical-align: middle;">
          <?php echo $reskul['keterangan'] ?></td>
      </tr>
      <?php 
            }
        } else {
            // Jika tidak ada data ekstrakurikuler, tampilkan baris kosong
    ?>
      <tr>
        <td style='width: 5%; text-align: center;'>-</td>
        <td style='width: 30%; text-align: center; padding: 3px;'>-</td>
        <td style='width: 15%; text-align: center; vertical-align: middle; padding: 3px;'>-</td>
        <td style='width: 50%; text-align: center; padding: 3px; vertical-align: middle;'>-</td>
      </tr>
      <?php } ?>
    </table>
  </div>

  <div style="page-break-inside: avoid;">
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
      <tr>
        <td style="width: 100%; text-align: left;"><b>Ketidakhadiran</b></td>
      </tr>
    </table>

    <!-- data absensi yang digeluti -->

    <table style="width: 50%; border-collapse: collapse; margin-top: 10px;" border="1">
      <?php  
            // Ambil semua data dari tabel absen di mana id_absen > 1
            $absen = mysqli_query($mysqli,"SELECT * FROM absen WHERE id_absen > 1 ORDER BY id_absen ASC");
            
            // Iterasi setiap data absen
            while ($rabsen = mysqli_fetch_array($absen)) {
                
                // Query untuk mengecek presensi berdasarkan tahun, semester, id_absen dan id_siswa
                $presensi_result = mysqli_query($mysqli,"SELECT * FROM presensi 
                WHERE tahun='$sekolah[tahun]' 
                AND semester='$sekolah[semester]' 
                AND id_absen='$rabsen[id_absen]' 
                AND id_siswa='$siswa[id_siswa]'");

                // Hitung jumlah data presensi yang ditemukan
                $presensi_count = mysqli_num_rows($presensi_result);

                // Ambil data presensi jika ada
                $presensi_data = mysqli_fetch_array($presensi_result);
            ?>
      <tr>
        <td style="width: 35%; text-align: left; padding: 3px;">
          <?php echo $rabsen['absen'] ?>
        </td>
        <td style="width: 65%; text-align: left; padding: 3px;">
          <?php 
                // Jika tidak ada presensi, tampilkan "-"
                if ($presensi_count == 0) {
                    echo "-";
                } else {
                    // Cek apakah kolom 'jumlah' memiliki nilai dan tidak kosong
                    if (isset($presensi_data['jumlah']) && $presensi_data['jumlah'] != "") {
                       
                        echo $presensi_data['jumlah'];
                       
                    } else {
                        // Jika 'jumlah' tidak ada, langsung tampilkan presensi_count
                        echo $presensi_count;
                    }
                }
                ?> Hari
        </td>
      </tr>
      <?php } ?>
    </table>
  </div>

  <div style="page-break-inside: avoid;">
    <table style="width: 100%; border-collapse: collapse; margin-top: 25px;">
      <tr>
        <td style="width: 40%; text-align: center; padding: 5px;">Mengetahui, </td>
        <td style="width: 20%; text-align: left; padding: 5px;"></td>
        <td style="width: 40%; text-align: center; padding: 5px;">
          <?php if($sekolah['lokasi']==1){ echo $sekolah['kabupaten'];}elseif($sekolah['lokasi']==2){ echo $sekolah['kecamatan']; }elseif($sekolah['lokasi']==3){ echo $sekolah['desa'];} ?>,
          <?php echo tgl_indonesia($pembagian['tanggal_rapor']) ?>
        </td>
      </tr>
      <tr>
        <td style="width: 40%; text-align: center; padding: 5px;">Orang Tua / Wali Peserta Didik</td>
        <td style="width: 20%; text-align: left; padding: 5px;"></td>
        <td style="width: 40%; text-align: center; padding: 5px;">Wali Kelas </td>
      </tr>
      <tr>
        <td style="width: 40%; text-align: center; padding: 5px; height: 40px;"></td>
        <td style="width: 20%; text-align: left; padding: 5px; height: 40px;"></td>
        <td style="width: 40%; text-align: center; padding: 5px; height: 40px;"></td>
      </tr>
      <tr>
        <td style="width: 40%; text-align: center; padding: 5px;">
          (....................................................)</td>
        <td style="width: 20%; text-align: left; padding: 5px;"></td>
        <td style="width: 40%; text-align: center; padding: 5px;"><b><u><?php echo $user['nama'] ?></u></b></td>
      </tr>
      <tr>
        <td style="width: 40%; text-align: center; padding: 5px;"></td>
        <td style="width: 20%; text-align: left; padding: 5px;"></td>
        <td style="width: 40%; text-align: center; padding: 5px;">NIP. <?php echo $user['nip'] ?></td>
      </tr>

      <tr>
        <td style="width: 40%; text-align: center; padding: 5px; height: 15px;"></td>
        <td style="width: 20%; text-align: left; padding: 5px; height: 15px;"></td>
        <td style="width: 40%; text-align: center; padding: 5px; height: 15px;"></td>
      </tr>
      <tr>
        <td style="width: 100%; text-align: center; padding: 5px;" colspan="3">Mengesahkan,</td>
      </tr>
      <tr>
        <td style="width: 100%; text-align: center; padding: 5px;" colspan="3">Kepala Sekolah,</td>
      </tr>
      <tr>
        <td style="width: 100%; text-align: center; padding: 5px; height: 55px;" colspan="3"></td>
      </tr>
      <tr>
        <td style="width: 100%; text-align: center; padding: 5px;" colspan="3">
          <b><u><?php echo $kepala['nama'] ?></u></b>
        </td>
      </tr>

      <tr>
        <td style="width: 100%; text-align: center; padding: 5px;" colspan="3">NIP. <?php echo $kepala['nip'] ?>
        </td>
      </tr>

    </table>
  </div>
</page>

<?php
} // Akhir dari looping siswa
?>

<?php  
require_once('../html2pdf/html2pdf.class.php');
$content = ob_get_clean();
$html2pdf = new HTML2PDF('P', array(215, 330), 'en', false, 'UTF-8', array(2, 2, 2, 2));
$html2pdf->WriteHTML($content);
$html2pdf->Output('Rapor PKL Kelas '.$kelas['nama_kelas'].'.pdf');
?>