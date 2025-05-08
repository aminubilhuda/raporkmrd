<?php  
session_start();
error_reporting(0);
if (empty($_SESSION['id_user']) or empty($_SESSION['jabatan'])) {
	?><script type="text/javascript">alert('Sesi anda Telah Habis Silahkan login Kembali'); window.location.href="../";</script><?php
}else{


include "../../config/function_antiinjection.php";
include "../../config/koneksi.php";
include "../../config/kode.php";


$user = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$_SESSION[id_user]'"));
$sekolah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sekolah WHERE id_sekolah='1'"));
$kepala = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kepala_sekolah WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_sekolah='1'"));

$kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]'"));

$jumlahmapel = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM mapel_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$_GET[orderID]'"));


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Format Nilai Lager Kelas : $kelas[nama_kelas].xls");

?>

<table style="border-collapse: collapse;">
	<tr>
		<td colspan="50"><b>Format Nilai Lager Kelas</b></td>
	</tr>
	<tr>
		<td colspan="50"><b>Kelas : <?php echo $kelas['nama_kelas'] ?></b></td>
	</tr>
</table>

<table style="border-collapse: collapse;" border="1">
	<tr>
		<td rowspan="2" style="text-align: center; vertical-align: middle;">No</td>
		<td rowspan="2" style="text-align: center; vertical-align: middle;">ID System</td>
		<td rowspan="2" style="text-align: center; vertical-align: middle;">Nama Siswa</td>
		<td colspan="<?php echo $jumlahmapel ?>" style="text-align: center; vertical-align: middle;">Mata Pelajaran (Nilai)</td>
		<td colspan="<?php echo $jumlahmapel ?>" style="text-align: center; vertical-align: middle;">Mata Pelajaran (Deskripsi)</td>
		<td colspan="<?php echo $jumlahmapel ?>" style="text-align: center; vertical-align: middle;">Mata Pelajaran (KKTP)</td>
		<td colspan="<?php echo '3' ?>" style="text-align: center; vertical-align: middle;">Rekap Absensi</td>
	</tr>
	<tr>
		<?php  
		$tujuan = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
		JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
		WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$kelas[id_kelas]' ORDER BY urut ASC");
	    while ($rtujuan = mysqli_fetch_array($tujuan)) {
	    ?>
	    <td style="text-align: center; vertical-align: middle;">
	        <?php echo $rtujuan['s_mapel'] ?> 
	    </td>
		<?php } ?>

		<?php  
		$tujuan = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
		JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
		WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$kelas[id_kelas]' ORDER BY urut ASC");
	    while ($rtujuan = mysqli_fetch_array($tujuan)) {
	    ?>
	    <td style="text-align: center; vertical-align: middle;">
	        <?php echo $rtujuan['s_mapel'] ?> 
	    </td>
		<?php } ?>


		<?php  
		$tujuan = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
		JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
		WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$kelas[id_kelas]' ORDER BY urut ASC");
	    while ($rtujuan = mysqli_fetch_array($tujuan)) {
	    ?>
	    <td style="text-align: center; vertical-align: middle;">
	        <?php echo $rtujuan['s_mapel'] ?> 
	    </td>
		<?php } ?>


		<?php  
		$absen = mysqli_query($mysqli,"SELECT * FROM absen ORDER BY id_absen ASC");
	    while ($rabsen = mysqli_fetch_array($absen)) {
	    ?>
	    <td style="text-align: center; vertical-align: middle;"><?php echo $rabsen['absen'] ?></td>
		<?php } ?>
	</tr>
	<?php  
	$nomor=1;

	$siswa = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
	JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
	WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$kelas[id_kelas]' ORDER BY nama_siswa ASC");	
	while ($rsiswa = mysqli_fetch_array($siswa)) {
	?>

	<tr>
		<td style="text-align: center;"><?php echo $nomor++ ?></td>
		<td style="text-align: center;"><?php echo $rsiswa['id_siswa'] ?></td>
		<td><?php echo $rsiswa['nama_siswa'] ?></td>
		<?php  
		$tujuan = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
		JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
		WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$kelas[id_kelas]' ORDER BY urut ASC");
	    while ($rtujuan = mysqli_fetch_array($tujuan)) {
	    ?>
	    <td style="text-align: center; vertical-align: middle;"></td>
		<?php } ?>

		<?php  
		$tujuan = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
		JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
		WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$kelas[id_kelas]' ORDER BY urut ASC");
	    while ($rtujuan = mysqli_fetch_array($tujuan)) {
	    ?>
	    <td style="text-align: center; vertical-align: middle;"></td>
		<?php } ?>

		<?php  
		$tujuan = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
		JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
		WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$kelas[id_kelas]' ORDER BY urut ASC");
	    while ($rtujuan = mysqli_fetch_array($tujuan)) {
	    ?>
	    <td style="text-align: center; vertical-align: middle;"></td>
		<?php } ?>

		<?php  
		$absen = mysqli_query($mysqli,"SELECT * FROM absen ORDER BY id_absen ASC");
	    while ($rabsen = mysqli_fetch_array($absen)) {
	    ?>
	    <td style="text-align: center; vertical-align: middle;"></td>
		<?php } ?>


	</tr>

	<?php } ?>
</table>

<?php } ?>