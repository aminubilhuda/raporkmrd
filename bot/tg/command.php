<?php
$sekolah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sekolah WHERE id_sekolah='1'"));

if ($userMessage == "Hi" || $userMessage == "hi" || $userMessage == "Hello" || $userMessage == "hello") {
    $botMessage = "Haloo!  ada yang bisa saya bantu?";

} else if ($userMessage == "/help") {
    $botMessage = "Daftar perintah yang tersedia:
        \n /start mulai bot, 
        \n /help bantuan comand, 
        \n /tgl_mid lihat tanggal rapor mid semester,
        \n /tgl_as lihat tanggal rapor akhir semester,
        \n /kelas_ku lihat kelas diampu";
    
} else if ($userMessage == "/tgl_mid") {
       $query = "SELECT tanggal_mid FROM pembagian_raport ORDER BY id_pembagian DESC LIMIT 1";
       $result = mysqli_query($mysqli, $query);



       if (mysqli_num_rows($result) > 0) {
           $botMessage = "";
           while ($row = mysqli_fetch_assoc($result)) {
               $botMessage .= "Tanggal Mid Semester: " . $row['tanggal_mid'] . "\n";
           }
       } else {
           $botMessage = "Tidak ada data.";
       }
}else if ($userMessage == "/tgl_as") {
       $query = "SELECT tanggal_rapor FROM pembagian_raport ORDER BY id_pembagian DESC LIMIT 1";
       $result = mysqli_query($mysqli, $query);

       if (mysqli_num_rows($result) > 0) {
           $botMessage = "";
           while ($row = mysqli_fetch_assoc($result)) {
               $botMessage .= "Tanggal Rapor Semester: " . $row['tanggal_rapor'] . "\n";
           }
       } else {
           $botMessage = "Tidak ada data.";
       }
} else if ($userMessage == "/kelas_ku") {
    // Query untuk mengambil data guru, kelas, tahun pelajaran, semester, dan mata pelajaran yang diajarkan
    $query = "SELECT users.nama, kelas.nama_kelas, tahun_pelajaran.tahun_pelajaran, semester.semester, mapel.nama_mapel 
              FROM mapel_kelas 
              JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
              JOIN kelas ON mapel_kelas.id_kelas = kelas.id_kelas
              JOIN users ON mapel_kelas.id_user = users.id_user
              JOIN telegram ON mapel_kelas.id_user = telegram.pegawai_id
              JOIN tahun_pelajaran ON mapel_kelas.tahun = tahun_pelajaran.id_tahun_pelajaran
              JOIN semester ON mapel_kelas.semester = semester.id_semester
              JOIN sekolah ON mapel_kelas.semester = sekolah.semester AND mapel_kelas.tahun = sekolah.tahun
              WHERE telegram.telegram_id = $userId AND sekolah.semester = $sekolah[semester] AND sekolah.tahun = $sekolah[tahun]
              ORDER BY users.nama, kelas.nama_kelas, tahun_pelajaran.tahun_pelajaran, semester.semester";
    $hasil = mysqli_query($mysqli, $query);

    $guruSaatIni = null;
    $data = [];
    if (mysqli_num_rows($hasil) > 0) {
        while ($row = mysqli_fetch_assoc($hasil)) {
            $botMessage = "";
            if ($guruSaatIni !== $row['nama']) {
                if ($guruSaatIni !== null) {
                    // Menampilkan data guru sebelumnya
                    $botMessage .= "Nama Guru: " . $data['nama'] . "\n" .
                                    "Mengajar Kelas: " . $data['nama_kelas'] . "\n" .
                                    "Tahun Pelajaran: " . $data['tahun_pelajaran'] . "\n" .
                                    "Semester: " . $data['semester'] . "\n" .
                                    "Mata Pelajaran: " . implode(", ", $data['mata_pelajaran']) . "\n\n";
                }
                // Reset data untuk guru baru
                $data = [
                    'nama' => $row['nama'],
                    'nama_kelas' => $row['nama_kelas'],
                    'tahun_pelajaran' => $row['tahun_pelajaran'],
                    'semester' => $row['semester'],
                    'mata_pelajaran' => []
                ];
                $guruSaatIni = $row['nama'];
            }
            $data['mata_pelajaran'][] = $row['nama_mapel'];
        }
        // Menampilkan data guru terakhir
        $botMessage .= "Nama Guru: " . $data['nama'] . "\n" .
                        "Mengajar Kelas: " . $data['nama_kelas'] . "\n" .
                        "Tahun Pelajaran: " . $data['tahun_pelajaran'] . "\n" .
                        "Semester: " . $data['semester'] . "\n" .
                        "Mata Pelajaran: " . implode(", ", $data['mata_pelajaran']) . "\n";
    } else {
        $botMessage = "Tidak ada data.";
    }
}
?>