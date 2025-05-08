<?php
session_start();
include "../config/koneksi.php";
include "../config/function.php";

if (isset($_POST['import'])) {
    require '../vendor/autoload.php';

    // Declare convertDate function outside the loop
    function convertDate($value) {
        // Remove any leading/trailing whitespace and apostrophes
        $value = trim($value);
        if (substr($value, 0, 1) === "'") {
            $value = substr($value, 1);
        }
        
        // Handle DD/MM/YYYY format (format utama)
        if (preg_match("/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/", $value, $matches)) {
            $day = (int)$matches[1];
            $month = (int)$matches[2];
            $year = (int)$matches[3];
            
            if (checkdate($month, $day, $year)) {
                return sprintf('%04d-%02d-%02d', $year, $month, $day);
            } else {
                throw new Exception("Tanggal tidak valid: $day/$month/$year");
            }
        }
        
        // Handle Excel numeric date format
        if (is_numeric($value)) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (Exception $e) {
                throw new Exception("Format tanggal Excel tidak valid: $value");
            }
        }
        
        throw new Exception("Format tanggal harus DD/MM/YYYY (contoh: 08/01/2025). Input yang diterima: $value");
    }

    $file_tmp = $_FILES['file_excel']['tmp_name'];
    $file_name = $_FILES['file_excel']['name'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

    if ($file_ext !== 'xlsx') {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => 'Format file harus .xlsx'
        ];
        header('Location: index.php?pages=prakerin');
        exit;
    }

    try {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_tmp);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Skip header row
        array_shift($rows);

        $berhasil = 0;
        $gagal = [];
        $errors = [];

        foreach ($rows as $index => $row) {
            try {
                if (count($row) < 5) {
                    throw new Exception("Data tidak lengkap");
                }

                if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4])) {
                    throw new Exception("Ada data yang kosong");
                }

                $mitra = mysqli_real_escape_string($mysqli, $row[0]);
                $lokasi = mysqli_real_escape_string($mysqli, $row[1]);

                try {
                    $tanggal_mulai = convertDate($row[2]);
                    $tanggal_akhir = convertDate($row[3]);
                } catch (Exception $e) {
                    throw new Exception($e->getMessage());
                }

                $nama_guru = mysqli_real_escape_string($mysqli, $row[4]);

                // Cari ID guru dari nama
                $guru_query = mysqli_query($mysqli, "SELECT id_user FROM users WHERE nama='$nama_guru' AND jabatan='3' LIMIT 1");
                if (!$guru_query) {
                    throw new Exception("Error database: " . mysqli_error($mysqli));
                }

                $guru_data = mysqli_fetch_array($guru_query);
                if (!$guru_data) {
                    throw new Exception("Guru dengan nama '$nama_guru' tidak ditemukan");
                }

                $id_user = $guru_data['id_user'];
                $sekolah = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM sekolah WHERE id_sekolah='1'"));

                $simpan = mysqli_query($mysqli, "INSERT INTO prakerin (tahun, semester, mitra, lokasi, tanggal_mulai, tanggal_akhir, id_user) 
                                               VALUES ('$sekolah[tahun]', '$sekolah[semester]', '$mitra', '$lokasi', '$tanggal_mulai', '$tanggal_akhir', '$id_user')");

                if (!$simpan) {
                    throw new Exception("Gagal menyimpan data: " . mysqli_error($mysqli));
                }

                $berhasil++;

            } catch (Exception $e) {
                $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                $gagal[] = $row;
            }
        }

        if (count($errors) > 0) {
            $message = "Berhasil mengimport " . $berhasil . " data prakerin.\n\n";
            $message .= "Data yang gagal diimport:\n" . implode("\n", $errors);
            $_SESSION['flash'] = [
                'type' => 'warning',
                'message' => $message
            ];
        } else {
            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => "Berhasil mengimport " . $berhasil . " data prakerin"
            ];
        }

    } catch (Exception $e) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => "Error: " . $e->getMessage()
        ];
    }

    header('Location: index.php?pages=prakerin');
    exit;
}
?>