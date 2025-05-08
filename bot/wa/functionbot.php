<?php

// Impor token dari file apikey.php
include 'apikey.php'; // Pastikan path-nya sesuai dengan lokasi file apikey.php

function kirimPesanBroadcast($nomorTujuan, $pesan) {
    global $token; // Ambil token dari variabel global yang diimpor dari apikey.php

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
            'target' => implode(',', $nomorTujuan),
            'message' => $pesan,
            'countryCode' => '62', // optional, default Indonesia
        ),
        CURLOPT_HTTPHEADER => array(
            "Authorization: $token"
        ),
    ));

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        // Tangani error cURL
        error_log('Curl error: ' . curl_error($curl));
        return json_encode(['status' => false, 'message' => 'Gagal mengirim pesan.']);
    }

    curl_close($curl);
    return $response;
}

function kirimPesanWali($nomorTujuan, $pesan) {
    global $token; // Ambil token dari variabel global yang diimpor dari apikey.php

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
            'target' => $nomorTujuan,
            'message' => $pesan,
            'countryCode' => '62', // optional, default Indonesia
        ),
        CURLOPT_HTTPHEADER => array(
            "Authorization: $token"
        ),
    ));

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        // Tangani error cURL
        error_log('Curl error: ' . curl_error($curl));
        return json_encode(['status' => false, 'message' => 'Gagal mengirim pesan.']);
    }

    curl_close($curl);
    return $response;
}

function getKontakWaliKelas($id_kelas) {
    global $mysqli, $sekolah;

    $stmt = $mysqli->prepare("SELECT kontak FROM users
    JOIN kelas_wali ON users.id_user=kelas_wali.id_user
    WHERE id_kelas = ? AND semester = ? AND tahun = ?");
    $stmt->bind_param("sss", $id_kelas, $sekolah['semester'], $sekolah['tahun']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Pastikan ada hasil yang dikembalikan
    if ($result->num_rows > 0) {
        $kontakWaliKelas = $result->fetch_array();
        return $kontakWaliKelas['kontak'];
    }

    return null; // Kembalikan null jika tidak ada kontak
}

function tampilkanNotifikasi($responseJson) {
    if (empty($responseJson)) {
        return;
    }

    $response = json_decode($responseJson, true);

    if (!$response || !isset($response['status'])) {
        echo '<div class="alert alert-danger">Gagal memproses permintaan.</div>';
        return;
    }

    $message = $response['detail'] ?? 'Tidak ada detail';
    $processStatus = $response['process'] ?? 'unknown';
    $ids = $response['id'] ?? [];
    $targets = $response['target'] ?? [];

    $successMessages = [];
    $failedMessages = [];

    foreach ($targets as $index => $target) {
        // Misalnya, jika processStatus menunjukkan bahwa pesan berhasil
        if ($response['status'] === true) {
            $successMessages[] = "Nomor: $target - ID: {$ids[$index]} berhasil dikirim.";
        } else {
            $failedMessages[] = "Nomor: $target - ID: {$ids[$index]} gagal dikirim.";
        }
    }

    // Tampilkan notifikasi sukses
    if (!empty($successMessages)) {
        echo '<div class="alert alert-success">';
        echo "<strong>Pesan Berhasil Dikirim:</strong><br>";
        echo '<ul>';
        foreach ($successMessages as $successMessage) {
            echo "<li>$successMessage</li>";
        }
        echo '</ul>';
        echo '</div>';
    }

    // Tampilkan notifikasi gagal
    if (!empty($failedMessages)) {
        echo '<div class="alert alert-danger">';
        echo "<strong>Pesan Gagal Dikirim:</strong><br>";
        echo '<ul>';
        foreach ($failedMessages as $failedMessage) {
            echo "<li>$failedMessage</li>";
        }
        echo '</ul>';
        echo '</div>';
    }
}

?>