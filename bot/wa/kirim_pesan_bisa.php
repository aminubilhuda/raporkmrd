<?php
include 'token.php'; 
include '../../config/koneksi.php';
date_default_timezone_set("Asia/Bangkok");


$sql = "SELECT waktu_pengingat, pesan FROM pengingat WHERE aktif = '1'"; 
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pesan = $row['pesan'];
    $schedule = strtotime($row['waktu_pengingat']); 

    $sql_kontak = "SELECT kontak FROM users"; 
    $result_kontak = $mysqli->query($sql_kontak);

    if ($result_kontak->num_rows > 0) {
        $berhasil = []; 
        $gagal = []; 

        while ($row_kontak = $result_kontak->fetch_assoc()) {
            $target = $row_kontak['kontak'];
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $target, 
                    'message' => $pesan, 
                    'schedule' => $schedule, 
                    'countryCode' => '62', 
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $token 
                ),
            ));

            $response = curl_exec($curl);
            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
                $gagal[] = $target; 
                $status = "Gagal: " . $error_msg;
                // Menambahkan penanganan kesalahan untuk query
                if (!$mysqli->query("INSERT INTO laporan_wa (kontak, status_pengiriman) VALUES ('$target', '$status')")) {
                    echo "Error: " . $mysqli->error; // Menampilkan kesalahan
                }
            } else {
                $berhasil[] = $target; 
                $response_data = json_decode($response, true); // Decode JSON response
                $status = ($response_data['status'] ? 'true' : 'false');
                // Menambahkan penanganan kesalahan untuk query
                if (!$mysqli->query("INSERT INTO laporan_wa (kontak, status_pengiriman) VALUES ('$target', '$status')")) {
                    echo "Error: " . $mysqli->error; // Menampilkan kesalahan
                }
            }
            curl_close($curl);
        }

        echo "<script>
            alert('Pesan berhasil dikirim ke: " . implode(", ", $berhasil) . "\\nPesan gagal dikirim ke: " . implode(", ", $gagal) . "' );
            window.close();
        </script>";
    } else {
        echo "Tidak ada kontak yang ditemukan.";
    }
} else {
    echo "Tidak ada pengingat aktif yang perlu dikirim saat ini.";
}

$mysqli->close();
?>