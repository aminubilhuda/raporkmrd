<?php  


include "../../config/function_antiinjection.php";
include "../../config/koneksi.php";
include "../../config/kode.php";
include "../../config/function_date.php";


$user = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$_SESSION[id_user]'"));
$sekolah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sekolah WHERE id_sekolah='1'"));
$guru = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$_GET[dataID]'"));
?>


<page backtop="7mm" backbottom="7mm" backleft="7mm" backright="7mm">
    <page_header style="text-align:center;">

    </page_header>
    <page_footer>

    </page_footer>


    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="width: 10%; text-align: center;" rowspan="5">
                <img src="../dist/img/<?php echo $sekolah['logo'] ?>" style="width: 80%;">
            </td>
            <td style="width: 70%;"><b>PEMBERINTAH PROVINSI <?php echo strtoupper($sekolah['provinsi'])?></b></td>
            <td style="width: 20%; text-align: right; font-size: 9px;" rowspan="4"><i>Surat ini adalah dokumen resmi
                    yang diterbitkan oleh <?php echo $sekolah['nama_sekolah'] ?> melalui :
                    <?php echo $sekolah['website'] ?></i></td>
        </tr>
        <tr>
            <td style="width: 70%; font-size: 14px;"><b><?php echo "DINAS PENDIDIKAN DAN KEBUDAYAAN" ?></b></td>
        </tr>
        <tr>
            <td style="width: 70%; font-size: 18px;"><b><?php echo $sekolah['nama_sekolah'] ?></b></td>
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
                        <td style="width: 70%;">SURAT PEMEBERITAHUAN RESET PASSWORD <br> PUSAT LAYANAN PTK <br>
                            <b><?php echo $sekolah['nama_sekolah']?></b>
                        </td>
                        <td style="width: 30%; text-align: right; font-size: 10px; vertical-align: top; padding: 5px;">
                            <i>Ver.202301</i>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="width: 5%;"></td>
            <td style="width: 60%;">Kepada Yth, <br> <b><?php echo $guru['nama'] ?></b> <br> di
                <?php echo strtoupper($sekolah['nama_sekolah']) ?> <br> di Kab. <?php echo $sekolah['kabupaten'] ?> -
                <?php echo $sekolah['provinsi'] ?></td>
            <td style="width: 10%;">No Surat <br> Tanggal <br> Sifat </td>
            <td style="width: 25%;">: 001 <br> <?php echo ": ". tgl_indonesia(date('Y-m-d')); ?> <br> : Sangat Rahasia
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="width: 5%;"></td>
            <td style="width: 95%; text-align: justify; line-height: 20px; padding: 5px;">Dengan hormat, </td>
        </tr>
        <tr>
            <td style="width: 5%;"></td>
            <td style="width: 95%; text-align: justify; line-height: 20px; padding: 5px;">Sehubungan dengan permintaan
                saudara untuk melakukan RESET PASSWORD atas PTK dengan informasi sebagai berikut : </td>
        </tr>
    </table>

    <table style="width: 60%; border-collapse: collapse; margin-top: 35px;" align="center" border="1">
        <tr>
            <td style="width: 45%; height: 15px; text-align: right; padding: 5px;">Username</td>
            <td style="width: 55%; padding: 5px;"><?php echo $guru['username'] ?></td>
        </tr>
        <tr>
            <td style="width: 45%; height: 15px; text-align: right; padding: 5px;">Nama PTK</td>
            <td style="width: 55%; padding: 5px;"><?php echo $guru['nama'] ?></td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="width: 5%;"></td>
            <td style="width: 95%; line-height: 20px;">Maka kami telah melakukan RESET PASSWORD anda. Untuk dapat
                menggunakan kembali layanan Program Aplikasi E-RAPOR MI, silahkan gunakan password sebagai berikut :
            </td>
        </tr>
    </table>

    <table style="width: 60%; border-collapse: collapse; margin-top: 25px;" align="center" border="1">
        <tr>
            <td style="width: 45%; height: 15px; text-align: right; padding: 5px;">Password</td>
            <td style="width: 55%; padding: 5px; font-size: 16px;"><b><?php echo $guru['pass'] ?></b></td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="width: 5%;"></td>
            <td style="width: 94%; line-height: 20px;">Setelah anda login, lakukan penggantian password demi keamanan
                dan kemudahan anda. Pastikan password baru
                yang anda buat MUDAH DIINGAT dan AMAN. Anda bertanggung jawab penuh terhadap kerahasian dan keamanan
                AKUN PTK ini.
            </td>
        </tr>
    </table>


    <table style="width: 100%; border-collapse: collapse; margin-top: 35px;">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%;"><?php echo $sekolah['kabupaten'] ?>, <?php echo tgl_indonesia(date('Y-m-d')); ?>
            </td>
        </tr>
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%;">Hormat Kami,</td>
        </tr>

        <tr>
            <td style="width: 60%; height: 70px;"></td>
            <td style="width: 40%;"></td>
        </tr>

        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%;">Admin Sekolah</td>
        </tr>
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%;"><b><?php echo strtoupper($sekolah['nama_sekolah']) ?></b></td>
        </tr>
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%;"><?php echo $sekolah['kabupaten'] ?> - <?php echo $sekolah['provinsi'] ?></td>
        </tr>
    </table>

</page>

<?php  
require_once('../html2pdf/html2pdf.class.php');
$content = ob_get_clean();
$html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'UTF-8', array(2, 2, 2, 2));
$html2pdf->WriteHTML($content);
$html2pdf->Output('Password Pendidik '.$guru['nama'].'.pdf');
?>