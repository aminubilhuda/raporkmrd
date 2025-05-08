<?php  


include "../../config/function_antiinjection.php";
include "../../config/koneksi.php";
include "../../config/kode.php";
include "../../config/function_date.php";
error_reporting(0);

$user = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$_SESSION[id_user]'"));
$sekolah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sekolah WHERE id_sekolah='1'"));
$guru = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$_GET[dataID]'"));
$tahun = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tahun_pelajaran WHERE id_tahun_pelajaran='$sekolah[tahun]'"));
$semester = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM semester WHERE id_semester='$sekolah[semester]'"));
$pembagian = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM pembagian_raport WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));

$kepala = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE jabatan='1'"));

require_once('../html2pdf/html2pdf.class.php');
// $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(2, 2, 2, 2));
$html2pdf = new HTML2PDF('P', array(210, 330), 'en', false, 'UTF-8', array(2, 2, 2, 2));


$kelas_id = $_GET['kelas'];
$siswaQuery = mysqli_query($mysqli, "SELECT * FROM siswa WHERE id_siswa IN (SELECT id_siswa FROM siswa_kelas WHERE id_kelas='$kelas_id' AND tahun='$sekolah[tahun]' AND semester='$sekolah[semester]')");


$total_siswa = mysqli_num_rows($siswaQuery);
$current_siswa = 0;

mysqli_data_seek($siswaQuery, 0);



while ($siswa = mysqli_fetch_array($siswaQuery)) {
    $current_siswa++; // Hitung nomor siswa saat ini
    ob_start(); // Mulai menangkap konten HTML untuk setiap siswa

    $siswakelas = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM siswa_kelas WHERE id_siswa='$siswa[id_siswa]' AND tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));
    // $kelas = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM kelas WHERE id_kelas='$siswakelas[id_kelas]'"));    
    $kelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas JOIN tingkat ON kelas.id_tingkat = tingkat.id_tingkat WHERE id_kelas='$siswakelas[id_kelas]'"));

    $tingkatsekarang = $kelas['id_tingkat'];

    $tingkatnaik = $tingkatsekarang+1;

    $datatingkat = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM tingkat WHERE id_tingkat='$tingkatnaik'"));

    $siswa_halaman = $current_siswa;

    // Reset halaman setiap kali kita mulai dengan siswa baru
    $siswa_halaman = 1;

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

<page backtop="55mm" backbottom="7mm" backleft="7mm" backright="10mm">
    <page_header width="750">
        <p style="margin-left:23px; font-size:20px;">
            <b>RAPOR PROJEK PENGUATAN PROFIL <br>PELAJAR PANCASILA</b>
        </p>
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

    <!-- baris nilai intrakurikuler -->

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <?php  
    	$projectkelas = mysqli_query($mysqli,"SELECT * FROM proyek_kelas 
    	JOIN proyek_tema ON proyek_kelas.id_tema = proyek_tema.id_tema
    	WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$siswakelas[id_kelas]' ORDER BY id_proyek_kelas ASC");
    	while ($rprojectkelas = mysqli_fetch_array($projectkelas)) {
    	?>
        <tr>
            <td style="width: 100%; text-align: left; vertical-align: middle; height: 20px; font-size: 14px;">
                <b><?php echo $rprojectkelas['judul_proyek'] ?> | <?php echo $rprojectkelas['tema'] ?></b>
            </td>
        </tr>
        <tr>
            <td style="width: 100%; text-align: left; vertical-align: middle; height: 20px; font-size: 13px;">
                <?php echo $rprojectkelas['deskripsi_singkat'] ?>
            </td>
        </tr>
        <?php } ?>
    </table>
    <hr style="color: #edf0ed;">

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <tr>
            <td style="width: 25%; text-align: center; height: 40px; background-color: #fe032c; color: white;">BB. Belum
                Berkembang</td>
            <td style="width: 25%; text-align: center; height: 40px; background-color: #fec709; color: white;">MB. Mulai
                Berkembang</td>
            <td style="width: 25%; text-align: center; height: 40px; background-color: #09bcfe; color: white;">BSH.
                Berkembang Sesuai Harapan</td>
            <td style="width: 25%; text-align: center; height: 40px; background-color: #60e102; color: white;">SB.
                Sangat Berkembang</td>
        </tr>
        <tr>
            <td style="width: 25%; text-align: left; height: 40px; font-size: 10px; padding: 5px;">Siswa masih
                membutuhkan bimbingan dalam mengembangkan kemampuan</td>
            <td style="width: 25%; text-align: left; height: 40px; font-size: 10px; padding: 5px;">Siswa mulai
                mengembangkan kemampuan namun belum menonjol</td>
            <td style="width: 25%; text-align: left; height: 40px; font-size: 10px; padding: 5px;">Siswa telah
                mengembangkan kemampuan hingga berada pada tahap ajek</td>
            <td style="width: 25%; text-align: left; height: 40px; font-size: 10px; padding: 5px;">Siswa mengembangkan
                kemampuannya melampaui harapan</td>
        </tr>
    </table>
    <hr style="color: #edf0ed;">

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <tr>
            <td style="width: 20%; height: 35px;"><b>Project Kelas <?php echo $kelas['nama_kelas'] ?></b></td>
            <?php  
    		$dimensi = mysqli_query($mysqli,"SELECT * FROM dimensi ORDER BY id_dimensi ASC");
    		while ($rdimensi = mysqli_fetch_array($dimensi)) {
    		?>
            <td
                style="width: <?php echo ((100-20)/6)?>%; height: 35px; text-align: center; vertical-align: middle; font-size: 11px;">
                <?php echo $rdimensi['dimensi'] ?></td>
            <?php } ?>
        </tr>
    </table>

    <hr style="color: #edf0ed;">
    <?php  
    	$projectkelas = mysqli_query($mysqli,"SELECT * FROM proyek_kelas 
    	JOIN proyek_tema ON proyek_kelas.id_tema = proyek_tema.id_tema
    	WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$siswakelas[id_kelas]' ORDER BY id_proyek_kelas ASC");
    	while ($rprojectkelas = mysqli_fetch_array($projectkelas)) {
    	?>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 20%; height: 35px; font-size: 12px;"><b><?php echo $rprojectkelas['judul_proyek'] ?></b>
            </td>
            <?php  
    		$dimensi = mysqli_query($mysqli,"SELECT * FROM dimensi ORDER BY id_dimensi ASC");
    		while ($rdimensi = mysqli_fetch_array($dimensi)) {
    			$datanilaiproject = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai) AS nilai_dimensi FROM nilai_proyek WHERE proyek='$rprojectkelas[id_proyek_kelas]' AND id_dimensi='$rdimensi[id_dimensi]' AND id_siswa='$siswa[id_siswa]'"));
    			
    			$datanilaidimensi = round($datanilaiproject['nilai_dimensi']);
    			if ($datanilaidimensi==0) { 
    				$nilaidm = "";
    				$style = "style='width: 13.33%; height: 35px; text-align: center; vertical-align: middle; font-size: 11px; background-color:white;'"; 
    			}elseif($datanilaidimensi==1){ 
    				$nilaidm="BB";
    				$style = "style='width: 13.33%; height: 35px; text-align: center; vertical-align: middle; font-size: 11px; background-color:#fe032c;'";
    			}elseif($datanilaidimensi==2){ 
    				$nilaidm="MB";
    				$style = "style='width: 13.33%; height: 35px; text-align: center; vertical-align: middle; font-size: 11px; background-color:#fec709;'" ;
    			}elseif($datanilaidimensi==3){ 
    				$nilaidm="BSH";
    				$style = "style='width: 13.33%; height: 35px; text-align: center; vertical-align: middle; font-size: 11px; background-color:#09bcfe;'";
    			}elseif($datanilaidimensi==4){ 
    				$nilaidm="SB";
    				$style = "style='width: 13.33%; height: 35px; text-align: center; vertical-align: middle; font-size: 11px; background-color:#60e102;'";
    			}
    		?>
            <td <?php echo $style ?>><?php echo $nilaidm ?></td>
            <?php } ?>
        </tr>
    </table>
    <?php } ?>


    <table style="width: 100%; border-collapse: collapse; margin-top: 45px;">
        <tr>
            <td style="width: 40%; text-align: center; padding: 5px;"></td>
            <td style="width: 20%; text-align: left; padding: 5px;"></td>
            <td style="width: 40%; text-align: center; padding: 5px;">
                <?php if($sekolah['lokasi']==1){ echo $sekolah['kabupaten'];}elseif($sekolah['lokasi']==2){ echo $sekolah['kecamatan']; }elseif($sekolah['lokasi']==3){ echo $sekolah['desa'];} ?>,
                <?php echo tgl_indonesia($pembagian['tanggal_rapor']) ?>
            </td>
        </tr>
        <tr>
            <td style="width: 40%; text-align: center; padding: 3px;"></td>
            <td style="width: 20%; text-align: left; padding: 3px;"></td>
            <td style="width: 40%; text-align: center; padding: 3px;">Wali Kelas </td>
        </tr>
        <tr>
            <td style="width: 40%; text-align: center; padding: 3px; height: 60px;"></td>
            <td style="width: 20%; text-align: left; padding: 3px; height: 60px;"></td>
            <td style="width: 40%; text-align: center; padding: 3px; height: 60px;"></td>
        </tr>
        <tr>
            <td style="width: 40%; text-align: center; padding: 3px;"></td>
            <td style="width: 20%; text-align: left; padding: 3px;"></td>
            <td style="width: 40%; text-align: center; padding: 3px;"><b><u><?php echo $user['nama'] ?></u></b></td>
        </tr>
        <tr>
            <td style="width: 40%; text-align: center; padding: 3px;"></td>
            <td style="width: 20%; text-align: left; padding: 3px;"></td>
            <td style="width: 40%; text-align: center; padding: 3px;">NIP. <?php echo $user['nip'] ?></td>
        </tr>

    </table>

</page>

<!-- halaman 2 -->

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

<page backtop="40mm" backbottom="7mm" backleft="7mm" backright="10mm">
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




    <!-- baris nilai intrakurikuler -->

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;" border="1">
        <?php  
        $nomor=1;
    	$projectkelas = mysqli_query($mysqli,"SELECT * FROM proyek_kelas 
    	JOIN proyek_tema ON proyek_kelas.id_tema = proyek_tema.id_tema
    	WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$siswakelas[id_kelas]' ORDER BY id_proyek_kelas ASC");
    	while ($rprojectkelas = mysqli_fetch_array($projectkelas)) {
    	?>
        <tr>
            <td
                style="width: 60%; text-align: left; vertical-align: middle; height: 15px; font-size: 14px; padding: 5px; background-color: #edebeb;">
                <b><?php echo $nomor++ ?>. <?php echo $rprojectkelas['judul_proyek'] ?></b>
            </td>
            <td
                style="width: 10%; text-align: center; vertical-align: middle; height: 15px; font-size: 14px; background-color: #fe032c; color: white;">
                BB</td>
            <td
                style="width: 10%; text-align: center; vertical-align: middle; height: 15px; font-size: 14px; background-color: #fec709; color: white;">
                MB</td>
            <td
                style="width: 10%; text-align: center; vertical-align: middle; height: 15px; font-size: 14px; background-color: #09bcfe; color: white;">
                BSH</td>
            <td
                style="width: 10%; text-align: center; vertical-align: middle; height: 15px; font-size: 14px; background-color: #60e102; color: white;">
                SB</td>
        </tr>

        <?php  
        $dimensitunggal = mysqli_query($mysqli,"SELECT DISTINCT(id_dimensi) FROM proyek_subelemen WHERE id_proyek_kelas='$rprojectkelas[id_proyek_kelas]' ORDER BY id_dimensi ASC");
        while ($rdimensitunggal = mysqli_fetch_array($dimensitunggal)) {
            $datadimensi = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM dimensi WHERE id_dimensi='$rdimensitunggal[id_dimensi]'"));
        ?>
        <tr>
            <td colspan="5" style="text-align: left; padding-left: 5px; height: 25px; background-color: #f6f6f6;">
                <b><?php echo $datadimensi['dimensi'] ?></b>
            </td>
        </tr>

        <?php  
        $subelemenproyek = mysqli_query($mysqli,"SELECT * FROM proyek_subelemen WHERE id_proyek_kelas='$rprojectkelas[id_proyek_kelas]' AND id_dimensi='$rdimensitunggal[id_dimensi]' ORDER BY id_sub_elemen ASC");
        while ($rsubelemenproyek = mysqli_fetch_array($subelemenproyek)) {
            $datasubelemen = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sub_elemen WHERE id_sub_elemen='$rsubelemenproyek[id_sub_elemen]'"));

            $datanilaiproject2 = mysqli_fetch_array(mysqli_query($mysqli,"SELECT AVG(nilai) AS rata_sub FROM nilai_proyek WHERE proyek='$rprojectkelas[id_proyek_kelas]' AND id_dimensi='$rdimensitunggal[id_dimensi]' AND id_sub_elemen='$rsubelemenproyek[id_sub_elemen]' AND id_siswa='$siswa[id_siswa]'"));

            $nilaisubelemen = round($datanilaiproject2['rata_sub']);
                if ($nilaisubelemen==0) { 
                    $nilaisbdm0 = "";
                    $style1 = "style='width: 10%; height: 10px; text-align: center; vertical-align: middle; font-size: 14px; background-color:white;'"; 
                }elseif($nilaisubelemen==1){ 
                    $nilaisbdm1="BB";
                    $style2 = "style='width: 10%; height: 10px; text-align: center; vertical-align: middle; font-size: 14px; background-color:#fe032c;'";
                }elseif($nilaisubelemen==2){ 
                    $nilaisbdm2="MB";
                    $style3 = "style='width: 10%; height: 10px; text-align: center; vertical-align: middle; font-size: 14px; background-color:#fec709;'" ;
                }elseif($nilaisubelemen==3){ 
                    $nilaisbdm3="BSH";
                    $style4 = "style='width: 10%; height: 10px; text-align: center; vertical-align: middle; font-size: 14px; background-color:#09bcfe;'";
                }elseif($nilaisubelemen==4){ 
                    $nilaisbdm4="SB";
                    $style5 = "style='width: 10%; height: 10px; text-align: center; vertical-align: middle; font-size: 14px; background-color:#60e102;'";
                }



        ?>
        <tr>
            <td style="width: 60%; text-align: left; vertical-align: middle; height: 10px; padding: 5px; ">
                <b><?php echo $datasubelemen['sub_elemen'] ?></b> <br> <i
                    style="font-size:11px;"><?php echo $datasubelemen['capaianE'] ?></i>
            </td>
            <td <?php if($nilaisubelemen==1){ echo $style2;} ?>><?php if($nilaisubelemen==1){echo $nilaisbdm1; } ?></td>
            <td <?php if($nilaisubelemen==2){ echo $style3;} ?>><?php if($nilaisubelemen==2){echo $nilaisbdm2; } ?></td>
            <td <?php if($nilaisubelemen==3){ echo $style4;} ?>><?php if($nilaisubelemen==3){echo $nilaisbdm3; } ?></td>
            <td <?php if($nilaisubelemen==4){ echo $style5;} ?>><?php if($nilaisubelemen==4){echo $nilaisbdm4; } ?></td>
        </tr>
        <?php } ?>

        <?php } ?>



        <?php } ?>
    </table>



    <table style="width: 100%; border-collapse: collapse; margin-top: 45px;">
        <tr>
            <td style="width: 40%; text-align: center; padding: 5px;">Mengetahui,</td>
            <td style="width: 20%; text-align: left; padding: 5px;"></td>
            <td style="width: 40%; text-align: center; padding: 5px;">
                <?php if($sekolah['lokasi']==1){ echo $sekolah['kabupaten'];}elseif($sekolah['lokasi']==2){ echo $sekolah['kecamatan']; }elseif($sekolah['lokasi']==3){ echo $sekolah['desa'];} ?>,
                <?php echo tgl_indonesia($pembagian['tanggal_rapor']) ?>
            </td>
        </tr>
        <tr>
            <td style="width: 40%; text-align: center; padding: 3px;">Kepala Sekolah</td>
            <td style="width: 20%; text-align: left; padding: 3px;"></td>
            <td style="width: 40%; text-align: center; padding: 3px;">Wali Kelas </td>
        </tr>
        <tr>
            <td style="width: 40%; text-align: center; padding: 3px; height: 60px;"></td>
            <td style="width: 20%; text-align: left; padding: 3px; height: 60px;"></td>
            <td style="width: 40%; text-align: center; padding: 3px; height: 60px;"></td>
        </tr>
        <tr>
            <td style="width: 40%; text-align: center; padding: 3px;"><b><u><?php echo $kepala['nama'] ?></u></b></td>
            <td style="width: 20%; text-align: left; padding: 3px;"></td>
            <td style="width: 40%; text-align: center; padding: 3px;"><b><u><?php echo $user['nama'] ?></u></b></td>
        </tr>
        <tr>
            <td style="width: 40%; text-align: center; padding: 3px;">NIP. <?php echo $keapala['nip'] ?></td>
            <td style="width: 20%; text-align: left; padding: 3px;"></td>
            <td style="width: 40%; text-align: center; padding: 3px;">NIP. <?php echo $user['nip'] ?></td>
        </tr>

    </table>

</page>

<?php
   $content = ob_get_clean();
    $html2pdf->WriteHTML($content);

    // Tambahkan halaman baru kecuali untuk siswa terakhir
    // if ($current_siswa < $total_siswa) {
    //     $html2pdf->pdf->AddPage();
    // }
}

$html2pdf->Output('Laporan_Siswa_Kelas_'.$kelas['nama_kelas'].'.pdf');
?>