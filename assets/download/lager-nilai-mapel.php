<?php  


include "../../config/function_antiinjection.php";
include "../../config/koneksi.php";
include "../../config/kode.php";
include "../../config/function_date.php";


$user = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$_SESSION[id_user]'"));
$sekolah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sekolah WHERE id_sekolah='$_SESSION[id_sekolah]'"));
$guru = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$_GET[dataID]'"));
$tahun = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tahun_pelajaran WHERE id_tahun_pelajaran='$sekolah[tahun]'"));
$semester = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM semester WHERE id_semester='$sekolah[semester]'"));
$pembelajaran = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
JOIN kelas ON mapel_kelas.id_kelas = kelas.id_kelas
WHERE id_mapel_kelas='$_GET[orderID]'"));


$jumlahtp = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]'"));

$jumlahtpfor = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' AND nas='1'"));
?>


<page backtop="7mm" backbottom="7mm" backleft="7mm" backright="25mm">
    <page_header style="text-align:center;">

    </page_header>
    <page_footer>

    </page_footer>


    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="width: 10%; text-align: center;" rowspan="4">
                <img src="../dist/img/<?php echo $sekolah['logo'] ?>" style="width: 60%;">
            </td>
            <td style="width: 70%;"><b>KEMENTERIAN AGAMA REPUBLIK INDONESIA</b></td>
            <td style="width: 20%; text-align: right; font-size: 9px;" rowspan="4"><i>Surat ini adalah dokumen resmi
                    yang diterbitkan oleh <?php echo $sekolah['nama_sekolah'] ?> melalui :
                    <?php echo $sekolah['website'] ?></i></td>
        </tr>
        <tr>
            <td style="width: 70%; font-size: 18px;"><b><?php echo strtoupper($sekolah['nama_sekolah']) ?></b></td>
        </tr>
        <tr>
            <td style="width: 70%; font-size: 11px;"><i>Alamat :
                    <?php echo $sekolah['alamat'].", Kabupaten :".$sekolah['kabupaten'] ?></i></td>
        </tr>
        <tr>
            <td style="width: 70%; font-size: 11px;"><i>Email :
                    <?php echo $sekolah['email'].", Website :".$sekolah['website'] ?></i></td>
        </tr>
    </table>



    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;" border="1">
        <tr>
            <td style="width: 100%;">
                <table style="width: 100%; border-collapse: collapse; padding: 7px;">
                    <tr>
                        <td style="width: 70%;">LAGER NILAI MATA PELAJARAN
                            <?php echo strtoupper($pembelajaran['nama_mapel']) ?> <br>KELAS :
                            <?php echo strtoupper($pembelajaran['nama_kelas']) ?> <br>SEMESTE :
                            <?php echo strtoupper($semester['semester']) ?> / TAHUN PELAJARAN :
                            <?php echo $tahun['tahun_pelajaran'] ?> <br> APLIKASI KURMA MADRASAH IBTIDAIYAH</td>
                        <td style="width: 30%; text-align: right; font-size: 10px; vertical-align: top; padding: 5px;">
                            <i>Ver.202301</i></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 11px;" border="1">
        <tr>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;" rowspan="2">No</td>
            <td style="width: 20%; height: 20px; text-align: center; vertical-align: middle;" rowspan="2">Nama Peserta
                Didik</td>
            <td style="width: <?php echo 3*$jumlahtpfor ?>%; height: 20px; text-align: center; vertical-align: middle;"
                colspan="<?php echo $jumlahtpfor ?>">Penilaian Formatif</td>
            <td style="width: 5%; height: 20px; text-align: center; vertical-align: middle;" rowspan="2">Rata-rata <br>
                Nilai Formatif</td>
            <td style="width: <?php echo 3*$jumlahtp ?>%; height: 20px; text-align: center; vertical-align: middle;"
                colspan="<?php echo $jumlahtp ?>">Penilaian Sumatif PH</td>
            <td style="width: 5%; height: 20px; text-align: center; vertical-align: middle;" rowspan="2">Rata-rata <br>
                Sumatif <br> PH</td>
            <td style="width: 5%; height: 20px; text-align: center; vertical-align: middle;" rowspan="2">Sumatif <br>
                Tengah Semester</td>
            <td style="width: 5%; height: 20px; text-align: center; vertical-align: middle;" rowspan="2">Sumatif <br>
                Akhir Semester</td>
            <td style="width: 5%; height: 20px; text-align: center; vertical-align: middle;" rowspan="2">Nilai Akhir
            </td>
        </tr>
        <tr>
            <?php  
    		$tujuan = mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' AND nas='1' ORDER BY urutan ASC ");
    		while ($rtujuan = mysqli_fetch_array($tujuan)) {
    		?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">TP.
                <?php echo $rtujuan['urutan'] ?></td>
            <?php } ?>
            <?php  
    		$tujuan = mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' ORDER BY urutan ASC ");
    		while ($rtujuan = mysqli_fetch_array($tujuan)) {
    		?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">TP.
                <?php echo $rtujuan['urutan'] ?></td>
            <?php } ?>
        </tr>


        <?php  
    	$nomor=1;
    	if ($pembelajaran['id_kelompok']==1) { 
			$siswa = mysqli_query($mysqli,"SELECT * FROM siswa_kelas 
			JOIN siswa ON siswa_kelas.id_siswa = siswa.id_siswa
			WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' ORDER BY nama_siswa ASC");
		}else{
			$siswa = mysqli_query($mysqli,"SELECT * FROM mapel_siswa
			JOIN siswa ON mapel_siswa.id_siswa = siswa.id_siswa
			WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' ORDER BY nama_siswa ASC");	
		}
		while ($rsiswa = mysqli_fetch_array($siswa)) {

			$nilailager = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' AND id_siswa='$rsiswa[id_siswa]'"));

			if ($nomor % 2 == 0){
				$style = "style='background-color:#fdfcd7;'";
			}else{
				$style = "style='background-color:#d7fafd;'";
			}


    	?>
        <tr <?php echo $style ?>>
            <td style="text-align: center;"><?php echo $nomor++ ?></td>
            <td style="width: 20%; height: 20px; text-align: left; padding: 3px; vertical-align: middle;">
                <?php echo $rsiswa['nama_siswa'] ?></td>
            <?php  
    		$tujuan = mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' AND nas='1' ORDER BY urutan ASC ");
    		while ($rtujuan = mysqli_fetch_array($tujuan)) {
    		?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$nilaiformatif = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_formatif WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' AND id_tujuan='$rtujuan[id_tujuan]' AND nas='1' AND id_siswa='$rsiswa[id_siswa]'"));
    			echo $datanilaiformatif = $nilaiformatif['nilai'];
    			?>
            </td>
            <?php } ?>
            <td style="width: 5%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			echo $datanilailagerformatif = round(($nilailager['nilai_formatif']),2);
    			?>
            </td>
            <?php  
    		$tujuan = mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' ORDER BY urutan ASC ");
    		while ($rtujuan = mysqli_fetch_array($tujuan)) {
    		?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$nilaisumatifph = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_sumatif_ph WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' AND id_tujuan='$rtujuan[id_tujuan]' AND id_siswa='$rsiswa[id_siswa]'"));
    			echo $datanilaisumatifph = $nilaisumatifph['nilai'];
    			?>
            </td>
            <?php } ?>
            <td style="width: 5%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			echo $datanilailagerph = round(($nilailager['nilai_sumatif_ph']),2);
    			?>
            </td>
            <td style="width: 5%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			echo $datanilailagerts = round(($nilailager['nilai_sumatif_ts']),2);
    			?>
            </td>
            <td style="width: 5%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			echo $datanilailageras = round(($nilailager['nilai_sumatif_as']),2);
    			?>
            </td>
            <td style="width: 5%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			echo $datanilailagerakhir = round(($nilailager['nilai_akhir_mapel']),2);
    			?>
            </td>
        </tr>
        <?php } ?>
        <tr style="background-color: #fbdffa;">
            <td colspan="2" style="text-align: right; padding: 5px;">Nilai Rata-rata</td>
            <?php  
    		$tujuan = mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' AND nas='1' ORDER BY urutan ASC ");
    		while ($rtujuan = mysqli_fetch_array($tujuan)) {
    		?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$rataRata = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai) rata_formatif FROM nilai_formatif WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' AND id_tujuan='$rtujuan[id_tujuan]' "));
    			echo $rataformatif = round(($rataRata['rata_formatif']),2);
    			?>
            </td>
            <?php } ?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$ratanilaiformatif = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai_formatif) AS rata_nilai_formatif FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' "));
    			echo $rataformatifsemua = round(($ratanilaiformatif['rata_nilai_formatif']),2);
    			?>
            </td>
            <?php  
    		$tujuan = mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' ORDER BY urutan ASC ");
    		while ($rtujuan = mysqli_fetch_array($tujuan)) {
    		?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$nilaisumatifph = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai) AS rata1_ph FROM nilai_sumatif_ph WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' AND id_tujuan='$rtujuan[id_tujuan]' "));
    			echo $datanilaisumatifph = round(($nilaisumatifph['rata1_ph']),2);
    			?>
            </td>
            <?php } ?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$ratanilaiph2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai_sumatif_ph) AS rata2_ph FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' "));
    			echo $rataph2= round(($ratanilaiph2['rata2_ph']),2);
    			?>
            </td>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$ratanilaits2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai_sumatif_ts) AS rata2_ts FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' "));
    			echo $ratats2= round(($ratanilaits2['rata2_ts']),2);
    			?>
            </td>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$ratanilaias2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai_sumatif_as) AS rata2_as FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' "));
    			echo $rataas2= round(($ratanilaias2['rata2_as']),2);
    			?>
            </td>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$ratanilaiakhir2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai_akhir_mapel) AS rata2_akhir FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' "));
    			echo $rataakhir2= round(($ratanilaiakhir2['rata2_akhir']),2);
    			?>
            </td>
        </tr>
        <tr style="background-color: #dffbe3;">
            <td colspan="2" style="text-align: right; padding: 5px;">Nilai Tertinggi</td>
            <?php  
    		$tujuan = mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' AND nas='1' ORDER BY urutan ASC ");
    		while ($rtujuan = mysqli_fetch_array($tujuan)) {
    		?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$tertinggi1 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(nilai) tertinggi_formatif1 FROM nilai_formatif WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' AND id_tujuan='$rtujuan[id_tujuan]' "));
    			echo $datatertinggi1 = $tertinggi1['tertinggi_formatif1'];
    			?>
            </td>
            <?php } ?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$tertinggiformatif2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(nilai_formatif) AS tertinggi2_formatif FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' "));
    			echo $datatertinggiformatif2= round(($tertinggiformatif2['tertinggi2_formatif']),2);
    			?>
            </td>
            <?php  
    		$tujuan = mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' ORDER BY urutan ASC ");
    		while ($rtujuan = mysqli_fetch_array($tujuan)) {
    		?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$nilaisumatifph = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(nilai) AS tertinggi1_ph FROM nilai_sumatif_ph WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' AND id_tujuan='$rtujuan[id_tujuan]' "));
    			echo $datanilaisumatifph = ($nilaisumatifph['tertinggi1_ph']);
    			?>
            </td>
            <?php } ?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$tertinggiph2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(nilai_sumatif_ph) AS tertinggi2_ph FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' "));
    			echo $datatertinggiph2= round(($tertinggiph2['tertinggi2_ph']),2);
    			?>
            </td>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$tertinggits2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(nilai_sumatif_ts) AS tertinggi2_ts FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' "));
    			echo $datatertinggits2= round(($tertinggits2['tertinggi2_ts']),2);
    			?>
            </td>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$tertinggias2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(nilai_sumatif_as) AS tertinggi2_as FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' "));
    			echo $datatertinggias2= round(($tertinggias2['tertinggi2_as']),2);
    			?>
            </td>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$tertinggiakhir2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MAX(nilai_akhir_mapel) AS tertinggi2_akhir FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' "));
    			echo $datatertinggiakhir2= round(($tertinggiakhir2['tertinggi2_akhir']),2);
    			?>
            </td>
        </tr>
        <tr style="background-color: #fbe8df;">
            <td colspan="2" style="text-align: right; padding: 5px;">Nilai Terendah</td>

            <?php  
    		$tujuan = mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' AND nas='1' ORDER BY urutan ASC ");
    		while ($rtujuan = mysqli_fetch_array($tujuan)) {
    		?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$tertinggi1 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(nilai) tertinggi_formatif1 FROM nilai_formatif WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' AND id_tujuan='$rtujuan[id_tujuan]' "));
    			echo $datatertinggi1 = $tertinggi1['tertinggi_formatif1'];
    			?>
            </td>
            <?php } ?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$tertinggiformatif2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(nilai_formatif) AS tertinggi2_formatif FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' "));
    			echo $datatertinggiformatif2= round(($tertinggiformatif2['tertinggi2_formatif']),2);
    			?>
            </td>
            <?php  
    		$tujuan = mysqli_query($mysqli,"SELECT * FROM tujuan_pembelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' ORDER BY urutan ASC ");
    		while ($rtujuan = mysqli_fetch_array($tujuan)) {
    		?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$nilaisumatifph = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(nilai) AS tertinggi1_ph FROM nilai_sumatif_ph WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' AND id_tujuan='$rtujuan[id_tujuan]' "));
    			echo $datanilaisumatifph = ($nilaisumatifph['tertinggi1_ph']);
    			?>
            </td>
            <?php } ?>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$tertinggiph2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(nilai_sumatif_ph) AS tertinggi2_ph FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' "));
    			echo $datatertinggiph2= round(($tertinggiph2['tertinggi2_ph']),2);
    			?>
            </td>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$tertinggits2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(nilai_sumatif_ts) AS tertinggi2_ts FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' "));
    			echo $datatertinggits2= round(($tertinggits2['tertinggi2_ts']),2);
    			?>
            </td>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$tertinggias2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(nilai_sumatif_as) AS tertinggi2_as FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' "));
    			echo $datatertinggias2= round(($tertinggias2['tertinggi2_as']),2);
    			?>
            </td>
            <td style="width: 3%; height: 20px; text-align: center; vertical-align: middle;">
                <?php  
    			$tertinggiakhir2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT MIN(nilai_akhir_mapel) AS tertinggi2_akhir FROM lager_nilai_mapel WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$pembelajaran[id_kelas]' AND id_mapel='$pembelajaran[id_mapel]' "));
    			echo $datatertinggiakhir2= round(($tertinggiakhir2['tertinggi2_akhir']),2);
    			?>
            </td>

        </tr>
    </table>


</page>

<?php  
require_once('../html2pdf/html2pdf.class.php');
$content = ob_get_clean();
$html2pdf = new HTML2PDF('L', 'Legal', 'en', false, 'UTF-8', array(2, 2, 2, 2));
$html2pdf->WriteHTML($content);
$html2pdf->Output('Lager Nilai Mata Pelajaran '.$guru[nama].'.pdf');
?>