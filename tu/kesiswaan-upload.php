<?php  
include "../config/function_antiinjection.php";
include "../config/koneksi.php";
include "../config/kode.php";
include "../config/function_date.php";
require '../vendor/autoload.php'; // Pastikan PHPSpreadsheet terinstall via Composer

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['uploaddata'])) {
    $target = basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $target);
    
    // beri permisi agar file xls dapat di baca
    chmod($target, 0777);
    
    // membaca file excel menggunakan PhpSpreadsheet
    $spreadsheet = IOFactory::load($target);
    $sheet = $spreadsheet->getActiveSheet();
    
    // menghitung jumlah baris data yang ada
    $jumlah_baris = $sheet->getHighestRow();
    
    // jumlah default data yang berhasil di import
    $berhasil = 0;
    $gagal = []; // array untuk menyimpan data yang gagal diinput
    
    for ($i = 4; $i <= $jumlah_baris; $i++) {
        $nama = htmlspecialchars(addslashes($sheet->getCell("B$i")->getValue()));
        $nis = $sheet->getCell("C$i")->getValue();
        $nisn = $sheet->getCell("D$i")->getValue();
        $kelamin = $sheet->getCell("E$i")->getValue();
        $agama = $sheet->getCell("F$i")->getValue();
        $tempat_lahir = $sheet->getCell("G$i")->getValue();
        $tanggal_lahir = $sheet->getCell("H$i")->getValue();
        $alamat = $sheet->getCell("I$i")->getValue();
        $kontak_siswa = $sheet->getCell("J$i")->getValue();
        
        $hub_keluarga = $sheet->getCell("K$i")->getValue();
        $jumlah_saudara = $sheet->getCell("L$i")->getValue();
        $anak_ke = $sheet->getCell("M$i")->getValue();
        $nama_ayah = htmlspecialchars(addslashes($sheet->getCell("N$i")->getValue()));
        $nama_ibu = htmlspecialchars(addslashes($sheet->getCell("O$i")->getValue()));
        $alamat_ortu = $sheet->getCell("P$i")->getValue();
        $kontak_ortu = $sheet->getCell("Q$i")->getValue();
        $pekerjaan_ayah = $sheet->getCell("R$i")->getValue();
        $pekerjaan_ibu = $sheet->getCell("S$i")->getValue();
        $nama_wali = htmlspecialchars(addslashes($sheet->getCell("T$i")->getValue()));
        $alamat_wali = $sheet->getCell("V$i")->getValue();
        $pekerjaan_wali = $sheet->getCell("U$i")->getValue();
        $kontak_wali = $sheet->getCell("W$i")->getValue();
        
        $sekolah_asal = mysqli_real_escape_string($mysqli, $sheet->getCell("X$i")->getValue());
        $terima_tanggal = $sheet->getCell("Y$i")->getValue();
        $terima_kelas = $sheet->getCell("Z$i")->getValue();
        $jurusan = $sheet->getCell("AA$i")->getValue();
        $nik_siswa = $sheet->getCell("AB$i")->getValue();
        
        $pass = $nisn;
        $password = password_hash($pass, PASSWORD_DEFAULT);
        
        //ceknisn
        $query = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM siswa WHERE aktif='1' AND nisn='$nisn'"));
        if ($query == 0) {
            if (!mysqli_query($mysqli, "INSERT INTO siswa 
            SET nama_siswa='$nama', 
            nis='$nis', nisn='$nisn', 
            kelamin='$kelamin', 
            agama='$agama', 
            tempat_lahir='$tempat_lahir', 
            tanggal_lahir='$tanggal_lahir', 
            alamat='$alamat', 
            kontak_siswa='$kontak_siswa', 
            hub_keluarga='$hub_keluarga', 
            jumlah_saudara='$jumlah_saudara', 
            anak_ke='$anak_ke', 
            nama_ayah='$nama_ayah', 
            nama_ibu='$nama_ibu', 
            alamat_ortu='$alamat_ortu', 
            kontak_ortu='$kontak_ortu', 
            pekerjaan_ayah='$pekerjaan_ayah', 
            pekerjaan_ibu='$pekerjaan_ibu', 
            nama_wali='$nama_wali', 
            alamat_wali='$alamat_wali', 
            pekerjaan_wali='$pekerjaan_wali', 
            kontak_wali='$kontak_wali', 
            sekolah_asal='$sekolah_asal', 
            terima_kelas='$terima_kelas', 
            jurusan='$jurusan', 
            nik_siswa='$nik_siswa',
            terima_tanggal='$terima_tanggal', 
            username='$nisn', 
            pass='$pass', 
            password='$password', 
            foto='', 
            jenis_siswa='1', 
            aktif='1'")) {
                $gagal[] = "Baris $i: NISN Gagal ditambah $nisn. Detail : " . mysqli_error($mysqli);
            }
        } else {
            if (!mysqli_query($mysqli, "UPDATE siswa SET nama_siswa='$nama', 
            nis='$nis', 
            nisn='$nisn', 
            kelamin='$kelamin', 
            agama='$agama', 
            tempat_lahir='$tempat_lahir', 
            tanggal_lahir='$tanggal_lahir', 
            alamat='$alamat', 
            kontak_siswa='$kontak_siswa', 
            hub_keluarga='$hub_keluarga', 
            jumlah_saudara='$jumlah_saudara', 
            anak_ke='$anak_ke', 
            nama_ayah='$nama_ayah', 
            nama_ibu='$nama_ibu', 
            alamat_ortu='$alamat_ortu', 
            kontak_ortu='$kontak_ortu', 
            pekerjaan_ayah='$pekerjaan_ayah', 
            pekerjaan_ibu='$pekerjaan_ibu', 
            nama_wali='$nama_wali', 
            pekerjaan_wali='$pekerjaan_wali', 
            alamat_wali='$alamat_wali', 
            kontak_wali='$kontak_wali', 
            sekolah_asal='$sekolah_asal', 
            terima_tanggal='$terima_tanggal', 
            terima_kelas='$terima_kelas', 
            jurusan='$jurusan',
            nik_siswa='$nik_siswa',
            username='$nisn', 
            pass='$pass', 
            password='$password', 
            foto='', 
            jenis_siswa='1' WHERE nisn='$nisn'")) {
                $gagal[] = "Baris $i: NISN Gagal diupdate $nisn. Detail : " . mysqli_error($mysqli);
            }
        }
    }
    
    // hapus kembali file excel yang di upload tadi
    unlink($target);
    
    // alihkan halaman ke index.php
    ?>
<script type="text/javascript">
let message = "Berhasil Mengupload <?php echo $jumlah_baris - 3 ?> Data";
<?php if (!empty($gagal)) { ?>
message += "\ndan Data yang gagal diinput:\n<?php echo implode('\n', $gagal); ?>";
<?php } ?>
swal.fire({
    title: "Berhasil!",
    text: message,
    icon: "success",
    width: '600px', // Perbesar modal sweet alert
    padding: '3em', // Tambahkan padding untuk memperbesar modal
}).then(function() {
    window.location.href = "?pages=kesiswaan";
});
</script>
<?php
}
?>