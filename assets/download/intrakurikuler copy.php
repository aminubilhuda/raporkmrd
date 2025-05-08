<?php  

session_start();
error_reporting(0);
ob_start();
if (empty($_SESSION['id_user']) or empty($_SESSION['jabatan'])) {
	?><script type="text/javascript">
alert('Sesi anda Telah Habis Silahkan login Kembali');
window.location.href = "../";
</script><?php
}else{


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
            <td style="width: 51%; text-align: center; vertical-align: middle; height: 30px;"><b>Capaian Kompetensi</b>
            </td>
        </tr>
        <?php
    	$kelompokmapel = mysqli_query($mysqli,"SELECT * FROM kelompok_mapel ORDER BY id_kelompok ASC");
    	while($rkelompok = mysqli_fetch_array($kelompokmapel)){
    	?>
        <tr>
            <td style="width: 100%; text-align: left; padding:5px; height: 10px;" colspan="4">
                <b><?php echo $rkelompok['huruf'].". ".$rkelompok['kelompok']?></b>
            </td>
        </tr>

        <?php  
    	$nomor=1;
    	$mapel = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
    	JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
    	WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$siswakelas[id_kelas]' AND id_kelompok='$rkelompok[id_kelompok]' ORDER BY urut ASC");
    	while ($rmapel = mysqli_fetch_array($mapel)) {
    		$nilai = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$kelas[id_kelas]' AND id_mapel='$rmapel[id_mapel]' AND id_siswa='$_GET[orderID]'"));
    	?>
        <tr>
            <td style="width: 5%; text-align: center; vertical-align: middle; "><?php echo $nomor++ ?></td>
            <td style="width: 30%; text-align: left; padding: 3px; vertical-align: middle; ">
                <?php echo $rmapel['nama_mapel'] ?></td>
            <td style="width: 15%; text-align: center; vertical-align: middle; "><?php echo round($nilai['nilai'],0) ?>
            </td>
            <td style="width: 50%; text-align: left; padding: 3px; vertical-align: middle; ">
                <?php  
    			$datamax = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_formatif WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$siswakelas[id_kelas]' AND id_mapel='$rmapel[id_mapel]' AND id_siswa='$_GET[orderID]' ORDER BY nilai DESC LIMIT 1"));
    			
    			$nilaimax = $datamax['nilai'];
    			if ($nilaimax == 0) {
    				echo $pembuka = "";
    			}elseif($nilaimax > 70){
    				echo $pembuka = "Memiliki penguasaan yang baik dalam ";
    			}else{
    				echo $pembuka = "Dengan pendampingan yang lebih, dapat mengembangkan kemampuan dalam ";
    			}

    			$tujuanmax = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE id_tujuan='$datamax[id_tujuan]'"));
    			echo $tujuanmax['tujuan'];

    			$datamin = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_formatif WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$siswakelas[id_kelas]' AND id_mapel='$rmapel[id_mapel]' AND id_siswa='$_GET[orderID]' ORDER BY nilai ASC LIMIT 1"));
    			$nilaimin = $datamin['nilai'];

    			$tujuanmin = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE id_tujuan='$datamin[id_tujuan]'"));
    			

    				echo "
    				<hr style='color:#f1f2f0;'>
    				";
    				$pembukamin = "Dengan pendampingan yang lebih, dapat mengembangkan kemampuan dalam ";
    				echo $pembukamin." ".$tujuanmin['tujuan'];
    	
    			?>
            </td>
        </tr>
        <?php } ?>




        <?php } ?>


    </table>

    <?php  
    $eskul = mysqli_query($mysqli,"SELECT * FROM siswa_prakerin WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$_GET[orderID]'");
    if (mysqli_num_rows($eskul) > 0) { // Cek apakah ada data prakerin
    ?>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="width: 100%; text-align: left;"><b>PRAKTIK KERJA INDUSTRI</b></td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;" border="1">
        <tr>
            <td style="width: 5%; text-align: center;">No</td>
            <td style="width: 20%; text-align: center;">Mitra DU/DI</td>
            <td style="width: 15%; text-align: center; vertical-align: middle; height: 20px;">Lokasi</td>
            <td style="width: 10%; text-align: center; vertical-align: middle; height: 20px;">Lamanya (Bulan)</td>
            <td style="width: 50%; text-align: center;">Keterangan</td>
        </tr>
        <?php  
    	$nomor=1;
    	$eskul = mysqli_query($mysqli,"SELECT * FROM siswa_prakerin WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$_GET[orderID]' ORDER BY id_prakerin ASC");
    	while ($reskul = mysqli_fetch_array($eskul)) {
    		$dataeskul = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM prakerin WHERE id_prakerin='$reskul[id_prakerin]'"));
    		
    		$tanggalawal = date_create($dataeskul['tanggal_mulai']);
                            	$tanggalakhir = date_create($dataeskul['tanggal_akhir']);

                            	$interval = date_diff($tanggalawal, $tanggalakhir); 
    	?>
        <tr>
            <td style="width: 5%; text-align: center;"><?php echo $nomor++ ?></td>
            <td style="width: 20%; text-align: left; padding: 3px;"><?php echo $dataeskul['mitra'] ?></td>
            <td style="width: 15%; text-align: center; vertical-align: middle; padding: 3px;">
                <?php echo $dataeskul['lokasi'] ?></td>
            <td style="width: 10%; text-align: center; vertical-align: middle; height: 20px;">
                <?php echo $interval->m.' Bulan'?></td>
            <td style="width: 50%; text-align: left; padding: 3px; vertical-align: middle; ">
                <?php echo $reskul['keterangan'] ?></td>
        </tr>
        <?php } ?>
    </table>
    <?php } ?>


    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="width: 100%; text-align: left;"><b>ESKTRAKURIKULER</b></td>
        </tr>
    </table>
    <!-- data esktrakurikuler yang digeluti -->

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;" border="1">
        <tr>
            <td style="width: 5%; text-align: center;">No</td>
            <td style="width: 30%; text-align: center;">Esktrakurikuler</td>
            <td style="width: 15%; text-align: center; vertical-align: middle; height: 20px;">Predikat</td>
            <td style="width: 50%; text-align: center; vertical-align: middle; height: 20px;">Keterangan</td>
        </tr>
        <?php  
    	$nomor=1;
    	$eskul = mysqli_query($mysqli,"SELECT * FROM siswa_eskul WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$_GET[orderID]' ORDER BY id_eskul ASC");
    	while ($reskul = mysqli_fetch_array($eskul)) {
    		$dataeskul = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM eskul WHERE id_eskul='$reskul[id_eskul]'"));
    	?>
        <tr>
            <td style="width: 5%; text-align: center;"><?php echo $nomor++ ?></td>
            <td style="width: 30%; text-align: left; padding: 3px;"><?php echo $dataeskul['nama_eskul'] ?></td>
            <td style="width: 15%; text-align: center; vertical-align: middle; padding: 3px;">
                <?php echo $reskul['predikat'] ?></td>
            <td style="width: 50%; text-align: left; padding: 3px; vertical-align: middle; ">
                <?php echo $reskul['keterangan'] ?></td>
        </tr>
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
        $presensi_result = mysqli_query($mysqli,"SELECT * FROM presensi WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_absen='$rabsen[id_absen]' AND id_siswa='$_GET[orderID]'");
        $presensi_count = mysqli_num_rows($presensi_result);
        $presensi_data = mysqli_fetch_array($presensi_result);
    ?>
        <tr>
            <td style="width: 35%; text-align: left; padding: 3px;"><?php echo $rabsen['absen'] ?></td>
            <td style="width: 65%; text-align: left; padding: 3px;">
                <?php 
            if($presensi_count == 0) {
                echo "-";
            } else {
                if(isset($presensi_data['jumlah']) && $presensi_data['jumlah'] != "") {
                    echo $presensi_data['jumlah'];
                } else {
                    echo $presensi_count;
                }
            }
            ?> Hari
            </td>
        </tr>
        <?php } ?>
    </table>



    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="width: 100%; text-align: left;"><b>CATATAN WALI KELAS</b></td>
        </tr>
    </table>
    <!-- data catatan wali kelas yang digeluti -->

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;" border="1">
        <tr>
            <td style="width: 100%; text-align: left; height: 35px; padding: 5px;">
                <?php  
                $catatan = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM catatan_wali WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$siswakelas[id_kelas]' AND id_siswa='$_GET[orderID]' "));
                                        echo $catatan['catatan'];
                ?>
            </td>
        </tr>
    </table>

    <?php if($sekolah['semester']==2){ ?>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="width: 100%; text-align: left;"><b>KETERANGAN KENAIKAN KELAS</b></td>
        </tr>
    </table>

    <!-- data Keterangan Naik Kelas -->

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;" border="1">
        <tr>
            <td style="width: 100%; text-align: left; padding: 5px; height: 35px;">
                Berdasarkan Hasil Penilaian Semester Ganjil dan Genap Tahun Pelajaran
                <?php echo $tahun['tahun_pelajaran'] ?>, maka Peserta Didik <br> dinyatakan : <b>Naik Ke Tingkat
                    <?php echo $datatingkat['tingkat']?></b> / <b>Tinggal di Kelas
                    <?php echo $kelas['nama_kelas'] ?></b>
            </td>
        </tr>
    </table>

    <?php } ?>

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

</page>

<?php  
require_once('../html2pdf/html2pdf.class.php');
$content = ob_get_clean();
// $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(2, 2, 2, 2));
$html2pdf = new HTML2PDF('P', array(210, 330), 'en', false, 'UTF-8', array(2, 2, 2, 2));
$html2pdf->WriteHTML($content);
$html2pdf->Output('Rapor Intra '.$siswa['nama_siswa'].'.pdf');
?>


<?php } ?>