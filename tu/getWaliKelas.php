<?php
include 'koneksi.php'; // Pastikan file koneksi database disertakan

if (isset($_POST['id_kelas'])) {
    $id_kelas = $_POST['id_kelas'];
    $tahun = $_POST['tahun'];
    $semester = $_POST['semester'];

    $result = mysqli_query($mysqli, "SELECT users.id_user, users.nama 
                                      FROM users 
                                      JOIN kelas_wali ON users.id_user = kelas_wali.id_user 
                                      WHERE kelas_wali.id_kelas = '$id_kelas' 
                                      AND kelas_wali.tahun = '$tahun' 
                                      AND kelas_wali.semester = '$semester'");

    $waliKelas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $waliKelas[] = $row;
    }
    echo json_encode($waliKelas);
}
?>