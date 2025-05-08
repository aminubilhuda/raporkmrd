<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include "../config/function_antiinjection.php";
include "../config/koneksi.php";
include "../config/kode.php";

// Membuat objek Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan header kolom
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Nama Siswa');
$sheet->setCellValue('C1', 'NIS');
$sheet->setCellValue('D1', 'NISN');
$sheet->setCellValue('E1', 'Kelas');
$sheet->setCellValue('F1', 'Jurusan');
$sheet->setCellValue('G1', 'Kelamin');
$sheet->setCellValue('H1', 'Agama');
$sheet->setCellValue('I1', 'Tempat Lahir');
$sheet->setCellValue('J1', 'Tanggal Lahir');
$sheet->setCellValue('K1', 'Alamat');
$sheet->setCellValue('L1', 'Hubungan Keluarga');
$sheet->setCellValue('M1', 'Jumlah Saudara');
$sheet->setCellValue('N1', 'Anak Ke');
$sheet->setCellValue('O1', 'Nama Ayah');
$sheet->setCellValue('P1', 'Pekerjaan Ayah');
$sheet->setCellValue('Q1', 'Nama Ibu');
$sheet->setCellValue('R1', 'Pekerjaan Ibu');
$sheet->setCellValue('S1', 'Tanggal Terima');

// Mendapatkan data siswa dari database
$nomor = 1;
$siswa = mysqli_query($mysqli, "SELECT siswa.*, jenis_kelamin.jenis_kelamin, agama.agama, tingkat.tingkat 
FROM siswa 
JOIN jenis_kelamin ON siswa.kelamin = jenis_kelamin.id_jenis_kelamin
JOIN agama ON siswa.agama = agama.id_agama
JOIN siswa_kelas ON siswa.id_siswa = siswa_kelas.id_siswa
JOIN tingkat ON siswa_kelas.id_tingkat = tingkat.id_tingkat
JOIN sekolah ON siswa_kelas.tahun = sekolah.tahun AND siswa_kelas.semester = sekolah.semester
WHERE siswa.aktif = '1' 
ORDER BY siswa.id_siswa ASC");

$row = 2; // Baris untuk data dimulai dari baris kedua
while ($rsiswa = mysqli_fetch_array($siswa)) {
    $sheet->setCellValue('A' . $row, $nomor++);
    $sheet->setCellValue('B' . $row, $rsiswa['nama_siswa']);
    $sheet->setCellValue('C' . $row, $rsiswa['nis']);
    $sheet->setCellValue('D' . $row, $rsiswa['nisn']);
    $sheet->setCellValue('E' . $row, $rsiswa['tingkat']);
    $sheet->setCellValue('F' . $row, $rsiswa['jurusan']);
    $sheet->setCellValue('G' . $row, ($rsiswa['jenis_kelamin'] == 'Perempuan') ? 'P' : 'L');
    $sheet->setCellValue('H' . $row, $rsiswa['agama']);
    $sheet->setCellValue('I' . $row, $rsiswa['tempat_lahir']);
    $sheet->setCellValue('J' . $row, $rsiswa['tanggal_lahir']);
    $sheet->setCellValue('K' . $row, $rsiswa['alamat']);
    $sheet->setCellValue('L' . $row, $rsiswa['hub_keluarga']);
    $sheet->setCellValue('M' . $row, $rsiswa['jumlah_saudara']);
    $sheet->setCellValue('N' . $row, $rsiswa['anak_ke']);
    $sheet->setCellValue('O' . $row, $rsiswa['nama_ayah']);
    $sheet->setCellValue('P' . $row, $rsiswa['pekerjaan_ayah']);
    $sheet->setCellValue('Q' . $row, $rsiswa['nama_ibu']);
    $sheet->setCellValue('R' . $row, $rsiswa['pekerjaan_ibu']);
    $sheet->setCellValue('S' . $row, $rsiswa['terima_tanggal']);
    $row++;
}

// Membuat file Excel dan mengirimkan ke browser untuk download
$writer = new Xlsx($spreadsheet);
$filename = 'Data_Siswa.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . urlencode($filename) . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');