<?php  


include "../../config/function_antiinjection.php";
include "../../config/koneksi.php";
include "../../config/kode.php";
include "../../config/function_date.php";


$user = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$_SESSION[id_user]'"));
$sekolah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sekolah WHERE id_sekolah='1'"));
$guru = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$_GET[dataID]'"));
$tahun = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tahun_pelajaran WHERE id_tahun_pelajaran='$sekolah[tahun]'"));
$semester = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM semester WHERE id_semester='$sekolah[semester]'"));
$pembagian = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM pembagian_raport WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));

$kepala = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE jabatan='1'"));

$siswa = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM siswa WHERE id_siswa='$_GET[orderID]'"));
$siswakelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$_GET[orderID]'"));

$kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas 
JOIN tingkat ON kelas.id_tingkat = tingkat.id_tingkat
WHERE id_kelas='$siswakelas[id_kelas]'"));

$tingkatsekarang = $kelas['id_tingkat'];

$tingkatnaik = $tingkatsekarang+1;

$datatingkat = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tingkat WHERE id_tingkat='$tingkatnaik'"));


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
    padding: 2mm;
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

<page backtop="37mm" backbottom="7mm" backleft="7mm" backright="10mm">
    <page_header width="750" align="center">

        <table style="width: 96%; border-collapse: collapse; margin-top: 20px; margin-left:23px;">
            <tr>
                <td style="width: 25%; text-align: left; height: 15px;">NAMA SEKOLAH</td>
                <td style="width: 3%; text-align: center;">:</td>
                <td style="width: 37%; text-align: left;"><?php echo strtoupper($sekolah['nama_sekolah']) ?></td>
                <td style="width: 5%; text-align: center;"></td>
                <td style="width: 17%; text-align: left;">KELAS</td>
                <td style="width: 3%; text-align: center;">:</td>
                <td style="width: 17%; text-align: left;"><?php echo strtoupper($kelas['nama_kelas']) ?></td>
            </tr>
            <tr>
                <td style="width: 25%; text-align: left; height: 15px;">ALAMAT</td>
                <td style="width: 3%; text-align: center;">:</td>
                <td style="width: 37%; text-align: left;"><?php echo strtoupper($sekolah['alamat']) ?></td>
                <td style="width: 5%; text-align: center;"></td>
                <td style="width: 17%; text-align: left;">FASE</td>
                <td style="width: 3%; text-align: center;">:</td>
                <td style="width: 17%; text-align: left;"><?php echo strtoupper($kelas['fase']) ?></td>
            </tr>
            <tr>
                <td style="width: 25%; text-align: left; height: 15px;">NAMA PESERTA DIDIK</td>
                <td style="width: 3%; text-align: center;">:</td>
                <td style="width: 37%; text-align: left;"><?php echo strtoupper($siswa['nama_siswa']) ?></td>
                <td style="width: 5%; text-align: center;"></td>
                <td style="width: 17%; text-align: left;">SEMESTER</td>
                <td style="width: 3%; text-align: center;">:</td>
                <td style="width: 17%; text-align: left;"><?php echo strtoupper($semester['semester']) ?></td>
            </tr>
            <tr>
                <td style="width: 25%; text-align: left; height: 15px;">NIS / NISN</td>
                <td style="width: 3%; text-align: center;">:</td>
                <td style="width: 37%; text-align: left;"><?php echo strtoupper($siswa['nis']." / ".$siswa['nisn']) ?>
                </td>
                <td style="width: 5%; text-align: center;"></td>
                <td style="width: 17%; text-align: left;">T. PELAJARAN</td>
                <td style="width: 3%; text-align: center;">:</td>
                <td style="width: 17%; text-align: left;"><?php echo strtoupper($tahun['tahun_pelajaran']) ?></td>
            </tr>
        </table>
        <hr style="margin-left:23px; width:87%;">

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
            <td style="width: 100%; text-align: center; font-size:18px;"><b>LAPORAN HASIL BELAJAR <br> TENGAH
                    SEMESTER</b></td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <tr>
            <td style="width: 100%; text-align: left;"><b></b></td>
        </tr>
    </table>

    <!-- baris nilai intrakurikuler -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size:12px;" border="1">
        <tr style="background-color:#f5f3f3;">
            <td style="width: 5%; text-align: center; vertical-align: middle; height: 50px;">No</td>
            <td style="width: 25%; text-align: center; vertical-align: middle; height: 50px;">Mata Pelajaran</td>
            <td style="width: 8%; text-align: center; vertical-align: middle; height: 50px;">RT <br>Formatif</td>
            <td style="width: 8%; text-align: center; vertical-align: middle; height: 50px;">RT <br>Sumatif <br> PH</td>
            <td style="width: 8%; text-align: center; vertical-align: middle; height: 50px;">Nilai <br> Sumatif <br> TS
            </td>
            <td style="width: 8%; text-align: center; vertical-align: middle; height: 50px;">Nilai <br> Akhir</td>
        </tr>

        <?php
    	$kelompokmapel = mysqli_query($mysqli,"SELECT * FROM kelompok_mapel ORDER BY id_kelompok ASC");
    	while($rkelompok = mysqli_fetch_array($kelompokmapel)){
    	?>
        <tr>
            <td style="width: 100%; text-align: left; padding:5px; height: 10px;" colspan="6">
                <b><?php echo $rkelompok['huruf'].". ".$rkelompok['kelompok']?></b>
            </td>
        </tr>


        <?php  
    	$nomor=1;
    	$mapel = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
    	JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
    	WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$siswakelas[id_kelas]' AND id_kelompok='$rkelompok[id_kelompok]' ORDER BY urut ASC");
    	while ($rmapel = mysqli_fetch_array($mapel)) {
    		$nilai = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_mapel_mid WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$kelas[id_kelas]' AND id_mapel='$rmapel[id_mapel]' AND id_siswa='$_GET[orderID]'"));
    		$nilaits = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_sumatif_ts WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$kelas[id_kelas]' AND id_mapel='$rmapel[id_mapel]' AND id_siswa='$_GET[orderID]'"));
    	?>
        <tr>
            <td style="width: 5%; text-align: center; vertical-align: middle; "><?php echo $nomor++ ?></td>
            <td style="width: 25%; text-align: left; padding: 3px; vertical-align: middle; ">
                <?php echo $rmapel['nama_mapel'] ?></td>
            <td style="width: 4%; text-align: center; vertical-align: middle; height: 30px;"></td>
            <td style="width: 4%; text-align: center; vertical-align: middle; height: 30px;"></td>
            <td style="width: 4%; text-align: center; vertical-align: middle; height: 30px;">
                <?php echo $nilaits['nilai']?></td>
            <td style="width: 4%; text-align: center; vertical-align: middle; height: 30px;">
                <?php echo $nilai['nilai']?></td>
        </tr>
        <?php } ?>

        <?php } ?>






    </table>



    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="width: 100%; text-align: left;"><b>KETIDAKHADIRAN</b></td>
        </tr>
    </table>

    <!-- data absensi yang digeluti -->

    <table style="width: 50%; border-collapse: collapse; margin-top: 10px;" border="1">
        <?php  
    	$absen = mysqli_query($mysqli,"SELECT * FROM absen WHERE id_absen > 1 ORDER BY id_absen ASC");
    	while ($rabsen = mysqli_fetch_array($absen)) {
    		$presensi = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM presensi WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_absen='$rabsen[id_absen]' AND id_siswa='$_GET[orderID]'"));
    	?>
        <tr>
            <td style="width: 35%; text-align: left; padding: 3px;"><?php echo $rabsen['absen'] ?></td>
            <td style="width: 65%; text-align: left; padding: 3px;">
                <?php if($presensi=='0'){ echo "-"; }else{ echo $presensi;}  ?> Hari</td>
        </tr>
        <?php } ?>
    </table>




    <table style="width: 100%; border-collapse: collapse; margin-top: 25px;">
        <tr>
            <td style="width: 40%; text-align: center; padding: 5px;">Mengetahui, </td>
            <td style="width: 20%; text-align: left; padding: 5px;"></td>
            <td style="width: 40%; text-align: center; padding: 5px;">
                <?php if($sekolah['lokasi']==1){ echo $sekolah['kabupaten'];}elseif($sekolah['lokasi']==2){ echo $sekolah['kecamatan']; }elseif($sekolah['lokasi']==3){ echo $sekolah['desa'];} ?>,
                <?php echo tgl_indonesia($pembagian['tanggal_mid']) ?>
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

</page>

<?php  
require_once('../html2pdf/html2pdf.class.php');
$content = ob_get_clean();
$html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(2, 2, 2, 2));
$html2pdf->WriteHTML($content);
$html2pdf->Output('Rapor Intra '.$guru['nama'].'.pdf');
?>