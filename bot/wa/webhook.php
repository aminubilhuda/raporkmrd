<?php
include '../../config/koneksi.php';
$sekolah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sekolah WHERE id_sekolah='1'"));

header('Content-Type: application/json; charset=utf-8');

$json = file_get_contents('php://input');
$data = json_decode($json, true);
$device = $data['device'];
$sender = $data['sender'];
$message = $data['message'];
$member= $data['member']; //group member who send the message
$name = $data['name'];
$location = $data['location'];
//data below will only received by device with all feature package
//start
$url =  $data['url'];
$filename =  $data['filename'];
$extension=  $data['extension'];
//end


function sendFonnte($target, $data) {
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.fonnte.com/send",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => array(
	    	'target' => $target,
	    	'message' => $data['message'],
	    	// 'url' => $data['url'],
	    	// 'filename' => $data['filename'],
	    ),
	  CURLOPT_HTTPHEADER => array(
	    "Authorization: ZCsbkaSEMfhW9v8AaePt"
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);

	return $response;
}

if ( $message == "test" ) {
	$reply = [
		"message" => "working great! Sender: " . $sender,
	];
} elseif ( $message == "/help" ) {
	$reply = [
		"message" => "Daftar perintah yang tersedia:
        \n /help bantuan comand, 
        \n /mid lihat tanggal rapor mid semester,
        \n /as lihat tanggal rapor akhir semester,
        \n /kelas_ku lihat kelas dan mapel diampuu",
	];
} elseif ( $message == "/mid" || $message == "/MID" || $message == "/Mid" ) {
	 // Query untuk mengambil tanggal_mid
    $result = mysqli_query($mysqli, "SELECT tanggal_mid FROM pembagian_raport LIMIT 1");
    if (mysqli_num_rows($result) > 0) {
        $data_tanggal = mysqli_fetch_assoc($result);
        $tanggal_mid = $data_tanggal['tanggal_mid'];
        $reply = [
            "message" => "Tanggal Pembagian Rapor Tengah Semester adalah: *" . $tanggal_mid . "*",
        ];
    } else {
        $reply = [
            "message" => "Maaf, data tanggal tengah semester tidak ditemukan.",
        ];
    }
	
	
} elseif ( $message == "/as" || $message == "/AS" || $message == "/As" ) {
	 // Query untuk mengambil tanggal_mid
    $result = mysqli_query($mysqli, "SELECT tanggal_rapor FROM pembagian_raport LIMIT 1");
    if (mysqli_num_rows($result) > 0) {
        $data_tanggal = mysqli_fetch_assoc($result);
        $tanggal_as = $data_tanggal['tanggal_rapor'];
        $reply = [
            "message" => "Tanggal Pembagian Rapor Akhir Semester adalah: *" . $tanggal_as . "*",
        ];
    } else {
        $reply = [
            "message" => "Maaf, data tanggal mid semester tidak ditemukan.",
        ];
    }
	
	
} elseif ( $message == "/kelas_ku" || $message == "/KELAS_KU" || $message == "/Kelas_Ku" || $message == "/kelasku" || $message == "/Kelasku" ) {
	$query = mysqli_query($mysqli,
			 "SELECT users.nama, kelas.nama_kelas, tahun_pelajaran.tahun_pelajaran, semester.semester, mapel.nama_mapel 
              FROM mapel_kelas 
              JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
              JOIN kelas ON mapel_kelas.id_kelas = kelas.id_kelas
              JOIN users ON mapel_kelas.id_user = users.id_user
              JOIN tahun_pelajaran ON mapel_kelas.tahun = tahun_pelajaran.id_tahun_pelajaran
              JOIN semester ON mapel_kelas.semester = semester.id_semester
              JOIN sekolah ON mapel_kelas.semester = sekolah.semester AND mapel_kelas.tahun = sekolah.tahun
              WHERE users.kontak = $sender AND sekolah.semester = $sekolah[semester] AND sekolah.tahun = $sekolah[tahun]
              ORDER BY users.nama, kelas.nama_kelas, tahun_pelajaran.tahun_pelajaran, semester.semester");

	$dataGuru = [];
    $reply = ["message" => ""];

    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $namaGuru = $row['nama'];

            if (!isset($dataGuru[$namaGuru])) {
                $dataGuru[$namaGuru] = [
                    'nama' => $namaGuru,
                    'kelas' => []
                ];
            }

            $kelasKey = $row['nama_kelas'] . ' (' . $row['tahun_pelajaran'] . ' - ' . $row['semester'] . ')';

            if (!isset($dataGuru[$namaGuru]['kelas'][$kelasKey])) {
                $dataGuru[$namaGuru]['kelas'][$kelasKey] = [];
            }

            $dataGuru[$namaGuru]['kelas'][$kelasKey][] = $row['nama_mapel'];
        }

        foreach ($dataGuru as $guru) {
            $reply['message'] .= "Nama Guru: " . $guru['nama'] . "\n";

            foreach ($guru['kelas'] as $kelas => $mapel) {
                $reply['message'] .= "Mengajar Kelas: " . $kelas . "\n";
                $reply['message'] .= "Mata Pelajaran: " . implode(", ", $mapel) . "\n\n";
            }
        }
    } else {
        $reply['message'] = "Tidak ada data.";
    }


} else {
	$reply = [
		"message" => "Selamat Datang di Chat BOT Whatsapp SMK Abdi Negara Tuban \nKetik: /help untuk melihat bantuan comand yang tersedia.",
];
}

sendFonnte($sender, $reply);