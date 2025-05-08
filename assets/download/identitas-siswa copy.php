<?php  
session_start();
error_reporting(E_ALL); // Mengaktifkan semua laporan error
ini_set('display_errors', 1); // Menampilkan error di layar
ob_start();

// Memeriksa apakah sesi aktif
if (empty($_SESSION['id_user']) or empty($_SESSION['jabatan'])) {
?>
<script type="text/javascript">
alert('Sesi anda Telah Habis Silahkan login Kembali');
window.location.href = "../../siaptu/login.php";
</script>
<?php
} else {
    include "../../config/function_antiinjection.php";
    include "../../config/koneksi.php";
    include "../../config/kode.php";
    include "../../config/function_date.php";

    // Periksa koneksi ke database
    if (!$mysqli) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Mendapatkan data user
    $user = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM users WHERE id_user='$_SESSION[id_user]'"));
    if (!$user) {
        die("Error: Data user tidak ditemukan.");
    }

    // Mendapatkan data sekolah
    $sekolah = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM sekolah WHERE id_sekolah='1'"));
    if (!$sekolah) {
        die("Error: Data sekolah tidak ditemukan.");
    }

    // Mendapatkan data tahun pelajaran
    $tahun = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tahun_pelajaran WHERE id_tahun_pelajaran='$sekolah[tahun]'"));
    if (!$tahun) {
        die("Error: Data tahun pelajaran tidak ditemukan.");
    }

    // Mendapatkan data semester
    $semester = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM semester WHERE id_semester='$sekolah[semester]'"));
    if (!$semester) {
        die("Error: Data semester tidak ditemukan.");
    }

    // Mendapatkan data pembagian raport
    $pembagian = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM pembagian_raport WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]'"));
    if (!$pembagian) {
        die("Error: Data pembagian raport tidak ditemukan.");
    }

    // Mendapatkan data kepala sekolah
    $kepala = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM users WHERE jabatan='1'"));
    if (!$kepala) {
        die("Error: Data kepala sekolah tidak ditemukan.");
    }

    // Mendapatkan data siswa berdasarkan ID
    if (!isset($_GET['dataID'])) {
        die("Error: dataID tidak ditemukan di URL.");
    }

    $siswa = mysqli_fetch_array(mysqli_query($mysqli, "
        SELECT * FROM siswa 
        JOIN jenis_kelamin ON siswa.kelamin = jenis_kelamin.id_jenis_kelamin
        JOIN agama ON siswa.agama = agama.id_agama
        WHERE id_siswa='$_GET[dataID]'
    "));
    if (!$siswa) {
        die("Error: Data siswa tidak ditemukan.");
    }

    // Mendapatkan data hubungan keluarga
    $hubkel = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM hubungan_keluarga WHERE id_hubungan_keluarga='$siswa[hub_keluarga]'"));
    if (!$hubkel) {
        $hubkel['hubunga_keluarga'] = '' || $hubkel['hubunga_keluarga'] = '0';
    }

    // Mendapatkan data kelas siswa
    $siswakelas = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_siswa='$_GET[dataID]'"));
    if (!$siswakelas) {
        $siswakelas['id_kelas'] = '' || $siswakelas['id_kelas'] = '0';
    }

    // Mendapatkan data kelas
    $kelas = mysqli_fetch_array(mysqli_query($mysqli, "
        SELECT * FROM kelas 
        JOIN tingkat ON kelas.id_tingkat = tingkat.id_tingkat
        JOIN kompetensi_keahlian ON kelas.id_kompetensi_keahlian = kompetensi_keahlian.id_kompetensi_keahlian
        WHERE id_kelas='$siswakelas[id_kelas]'
    "));
    if (!$kelas) {
        $kelas['nama_kelas'] = '' || $kelas['nama_kelas'] = '0';
    }

    // Mendapatkan data terima kelas
    $terimakelas = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tingkat WHERE id_tingkat='$siswa[terima_kelas]'"));
    if (!$terimakelas) {
        $terimakelas['tingkat'] = '' || $terimakelas['tingkat'] = '0';
    }

    ?>


<!-- Output laporan HTML -->
<page backtop="7mm" backbottom="7mm" backleft="7mm" backright="10mm">
    <page_header style="text-align:center;"></page_header>
    <page_footer></page_footer>

    <p style="text-align:center; margin-top:65px;">
        <img src="../dist/img/<?php echo $sekolah['logo_prov']?>" style="width:25%;">
    </p>

    <table width="790px" style="border-collapse: collapse; font-size: 11px; margin-top: 20px;">
        <tr>
            <td style="width: 100%; text-align: center; font-size: 22px; height:30px;"><b>RAPOR</b></td>
        </tr>
        <tr>
            <td style="width: 100%; text-align: center; font-size: 22px; height:30px;"><b>SEKOLAH MENENGAH KEJURUAN</b>
            </td>
        </tr>
        <tr>
            <td style="width: 100%; text-align: center; font-size: 22px; height:30px;"><b>(SMK)</b></td>
        </tr>
    </table>

    <p style="text-align:center; margin-top:30px;">
        <img src="../dist/img/<?php echo $sekolah['logo']?>" style="width:25%;">
    </p>

    <table width="790px" style="border-collapse: collapse; font-size: 11px; margin-top: 20px;">
        <tr>
            <td style="width: 100%; text-align: center; font-size: 22px; height:30px;"><b>KOMPETENSI KEAHLIAN</b></td>
        </tr>
        <tr>
            <td style="width: 100%; text-align: center; font-size: 22px; height:30px;">
                <b><?php echo $kelas['kompetensi_keahlian']?></b>
            </td>
        </tr>
    </table>

    <table width="790px" style="border-collapse: collapse; font-size: 11px; margin-top: 20px;">
        <tr>
            <td style="width: 100%; text-align: center; font-size: 22px; height:30px;"><b>Nama Peserta Didik</b></td>
        </tr>
    </table>

    <table width="600px" style="border-collapse: collapse; font-size: 11px; margin-top: 20px;" border="1"
        align="center">
        <tr>
            <td style="width: 60%; text-align: center; font-size: 22px; height:30px;">
                <b><?php echo $siswa['nama_siswa']?></b>
            </td>
        </tr>
    </table>

    <table width="790px" style="border-collapse: collapse; font-size: 11px; margin-top: 20px;">
        <tr>
            <td style="width: 100%; text-align: center; font-size: 22px; height:30px;"><b>NISN / NIS</b></td>
        </tr>
    </table>

    <table width="600px" style="border-collapse: collapse; font-size: 11px; margin-top: 20px;" border="1"
        align="center">
        <tr>
            <td style="width: 60%; text-align: center; font-size: 22px; height:30px;"><b><?php echo $siswa['nisn']?> /
                    <?php echo $siswa['nis']?></b></td>
        </tr>
    </table>

    <p style="text-align:center; margin-top:75px; font-size:22px;">
        <b>
            KEMENTERIAN PENDIDIKAN, <br>
            KEBUDAYAAN, RISET, DAN TEKNOLOGI <br>
            REPUBLIK INDONESIA
        </b>
    </p>
</page>

<page backtop="7mm" backbottom="7mm" backleft="7mm" backright="10mm">
    <page_header style="text-align:center;"></page_header>
    <page_footer></page_footer>
    <table width="790px" style="border-collapse: collapse; font-size: 11px; margin-top: 65px;">
        <tr>
            <td style="width: 100%; text-align: center; font-size: 20px;"><b>IDENTITAS PESERTA DIDIK</b></td>
        </tr>
    </table>

    <br><br><br>

    <table width="790px" style="border-collapse: collapse; font-size: 11px; margin-top: 20px;">
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">1. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Nama Lengkap Peserta Didik</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;"><?php echo $siswa['nama_siswa'] ?></td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">2. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">NIS / NISN</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;"><?php echo $siswa['nis'] ?> /
                <?php echo $siswa['nisn'] ?></td>
        </tr>

        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">3. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Tempat, Tanggal Lahir</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;"><?php echo $siswa['tempat_lahir'] ?>,
                <?php echo tgl_indonesia(strtoupper(date('Y-m-d'))) ?></td>
        </tr>


        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">4. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Jenis Kelamin</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;"><?php echo $siswa['jenis_kelamin'] ?></td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">5. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Agama</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;"><?php echo $siswa['agama'] ?></td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">6. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Status Dalam Keluarga</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php if($hubkel['hubunga_keluarga']=='' || $hubkel['hubunga_keluarga']=='0'){ echo '-';}else{ echo $hubkel['hubunga_keluarga'];} ?>
            </td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">7. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Anak Ke</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php if($siswa['anak_ke']=='' || $siswa['anak_ke']=='0'){ echo '-';}else{ echo $siswa['anak_ke'];} ?>
            </td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">8. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Alamat</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;"><?php echo $siswa['alamat'] ?></td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">7. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">No. Telepon</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php if($siswa['kontak_siswa']=='' || $siswa['kontak_siswa']=='0'){ echo '-';}else{ echo $siswa['kontak_siswa'];} ?>
            </td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">8. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Sekolah Asal</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php if($siswa['sekolah_asal']=='' || $siswa['sekolah_asal']=='0'){ echo '-';}else{ echo $siswa['sekolah_asal'];} ?>
            </td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">9. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Diterima Di Sekolah Ini</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;"></td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;"></td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Di Kelas</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php echo $kelas['nama_kelas'] ?>
            </td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;"></td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Pada Tanggal</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php echo tgl_indonesia($siswa['terima_tanggal']); ?>
            </td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">10. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Nama Ayah</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php if($siswa['nama_ayah']=='' || $siswa['nama_ayah']=='0'){ echo '-';}else{ echo $siswa['nama_ayah'];} ?>
            </td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">11. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Nama Ibu</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php if($siswa['nama_ibu']=='' || $siswa['nama_ibu']=='0'){ echo '-';}else{ echo $siswa['nama_ibu'];} ?>
            </td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">12. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Pekerjaan Ayah</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php if($siswa['pekerjaan_ayah']=='' || $siswa['pekerjaan_ayah']=='0'){ echo '-';}else{ echo $siswa['pekerjaan_ayah'];} ?>
            </td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">13. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Pekerjaan Ibu</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php if($siswa['pekerjaan_ibu']=='' || $siswa['pekerjaan_ibu']=='0'){ echo '-';}else{ echo $siswa['pekerjaan_ibu'];} ?>
            </td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">14. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Alamat Orang Tua</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php if($siswa['alamat_ortu']=='' || $siswa['alamat_ortu']=='0'){ echo '-';}else{ echo $siswa['alamat_ortu'];} ?>
            </td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">15. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Kontak Orang Tua</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php if($siswa['kontak_ortu']=='' || $siswa['kontak_ortu']=='0'){ echo '-';}else{ echo $siswa['kontak_ortu'];} ?>
            </td>
        </tr>


        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">16. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Nama Wali</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php if($siswa['nama_wali']=='' || $siswa['nama_wali']=='0'){ echo '-';}else{ echo $siswa['nama_wali'];} ?>
            </td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">17. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Pekerjaan Wali</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php if($siswa['pekerjaan_wali']=='' || $siswa['pekerjaan_wali']=='0'){ echo '-';}else{ echo $siswa['pekerjaan_wali'];} ?>
            </td>
        </tr>

        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">18. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Alamat Wali</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php if($siswa['alamat_wali']=='' || $siswa['alamat_wali']=='0'){ echo '-';}else{ echo $siswa['alamat_wali'];} ?>
            </td>
        </tr>
        <tr>
            <td style="width: 10%; text-align: center; font-size: 14px; height: 30px;">19. </td>
            <td style="width: 30%; text-align: left; font-size: 14px;">Kontak Wali</td>
            <td style="width: 10%; text-align: center; font-size: 14px;">:</td>
            <td style="width: 50%; text-align: left; font-size: 14px;">
                <?php if($siswa['kontak_wali']=='' || $siswa['kontak_wali']=='0'){ echo '-';}else{ echo $siswa['kontak_wali'];} ?>
            </td>
        </tr>
    </table>

    <br><br><br>
    <table width="600px" style="border-collapse: collapse; font-size: 14px; margin-top: 5px;" align="center">
        <tr>
            <td style="width: 15%; border-collapse: collapse;  " rowspan="5"></td>
            <td style="width: 20%; background-color:#f6f6f5;" rowspan="5">
                <img src="../dist/img/siswa/<?php if($siswa['foto']==''){ echo 'kosong3.png';}else{ echo $siswa['foto'];} ?>"
                    style="width:100%;">
            </td>
            <td style="width: 10%;" rowspan="5"></td>
            <td style="width: 10%;" rowspan="5"></td>
            <td style="width: 45%; text-align: left;">
                <?php if($sekolah['lokasi']==1){ echo $sekolah['kabupaten'];}elseif($sekolah['lokasi']==2){ echo $sekolah['kecamatan']; }elseif($sekolah['lokasi']==3){ echo $sekolah['desa'];} ?>,
                <?php echo tgl_indonesia($siswa['terima_tanggal']) ?> </td>
        </tr>
        <tr>
            <td style="width: 45%; text-align: left;">Kepala Sekolah,</td>
        </tr>
        <tr>
            <td style="width: 45%; text-align: left; height: 100px;"></td>
        </tr>
        <tr>
            <td style="width: 45%; text-align: left;">
                <u><?php echo $kepala['nama'] ?></u>
            </td>
        </tr>
        <tr>
            <td style="width: 45%; text-align: left;">NIP. <?php echo $kepala['nip'] ?></td>
        </tr>
    </table>

</page>

<?php  
    require_once('../html2pdf/html2pdf.class.php');
    $content = ob_get_clean();
    $html2pdf = new HTML2PDF('P', 'Legal', 'en', false, 'UTF-8', array(2, 2, 2, 2));

    try {
        $html2pdf->WriteHTML($content);
        $html2pdf->Output('Indentitas Siswa '.$siswa['nama_siswa'].'.pdf');
    } catch (HTML2PDF_exception $e) {
        die($e->getMessage());
    }
    ?>

<?php } ?>