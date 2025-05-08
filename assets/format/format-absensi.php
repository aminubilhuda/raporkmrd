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
$kepala = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kepala_sekolah WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_sekolah='$_SESSION[id_sekolah]'"));

$kelaswali = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_user='$_SESSION[id_user]'"));


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Format Presensi Kelas:$kelaswali[nama_kelas].xls");

?>

<table style="border-collapse: collapse;">
	<tr>
		<td colspan="50"><b>Format Presensi dan Catatan Wali Kelas</b></td>
	</tr>
	<tr>
		<td colspan="50"><b>Kelas : <?php echo $kelaswali['nama_kelas'] ?></b></td>
	</tr>
</table>

<table style="border-collapse: collapse;" border="1">
	<tr>
		<td rowspan="2" style="text-align: center; vertical-align: middle;">No</td>
		<td rowspan="2" style="text-align: center; vertical-align: middle;">ID System</td>
		<td rowspan="2" style="text-align: center; vertical-align: middle;">Nama Siswa</td>
		<td colspan="3" style="text-align: center; vertical-align: middle;">Absensi</td>
        <td rowspan="2" style="text-align: center; vertical-align: middle;">Catatan Wali Kelas</td>
	</tr>
	<tr>
	<?php  
	$absen = mysqli_query($mysqli,"SELECT * FROM absen ORDER BY id_absen ASC");
    while ($rdim = mysqli_fetch_array($absen)) {
    ?>
        <td style="text-align: center; vertical-align: middle;"><?php echo $rdim['absen'] ?></td>
   	<?php } ?>
    </tr>

        <?php  
        $nomor=1;
                    		$siswa = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
                    		JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
                    		WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$kelaswali[id_kelas]' ORDER BY nama_siswa ASC");
                    		while ($rsiswa = mysqli_fetch_array($siswa)) {
                    		?>
                    		<tr>
                    			<td><?php echo $nomor++ ?></td>
                    			<td><?php echo $rsiswa['id_siswa'] ?></td>
                    			<td><?php echo $rsiswa['nama_siswa'] ?></td>
                    			<?php  
								$absen = mysqli_query($mysqli,"SELECT * FROM absen ORDER BY id_absen ASC");
							    while ($rdim = mysqli_fetch_array($absen)) {
							    ?>
							        <td style="text-align: center; vertical-align: middle;"></td>
							   	<?php } ?>
							   	<td style="text-align: center; vertical-align: middle;"></td>
                    		</tr>
                    		<?php } ?>

</table>

<?php } ?>