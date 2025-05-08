<?php
// Menggunakan isset atau operator null coalescing untuk menghindari undefined index
$pages = isset($_GET['pages']) ? $_GET['pages'] : '';

// Array untuk mapping halaman yang valid
$valid_pages = [
    'kelas-ku'                  => 'kelas-ku.php',
    'tujuan-pembelajaran'       => 'tujuan-pembelajaran.php',
    'penilaian'                 => 'penilaian.php',
    'lager-nilai-kelas'         => 'lager-nilai-kelas.php',
    'catatan-rapor'             => 'catatan-rapor.php',
    'project-kelas'             => 'project-kelas.php',
    'detail-project'            => 'detail-project.php',
    // 'penilaian-profil-pancasila' => 'penilaian-profil-pancasila.php',
    'pembelajaran-kelas'        => 'pembelajaran-kelas.php',
    'anggota-kelas'             => 'anggota-kelas.php',
    'ekstra'                    => 'ekstra.php',
    'prakerin'                  => 'prakerin.php',
    'buku-induk'                => 'buku-induk.php',
    'piket-harian'              => 'piket-harian.php',
    'rekap-presensi'            => 'rekap-presensi.php',
    'tpu'                       => 'tujuan-pembelajaran_umum.php',
    'deskripsi-rapor'           => 'deskripsi-rapor.php',
    'absensi-bk'                => 'absensi-bk.php',
    'penilaian-profil-pancasila' => 'penilaian-profil-pancasila.php',
    'rapor-pkl'                 => 'rapor-pkl.php',
    'p5bk'                      => 'p5bk.php'
];

// Jika pages kosong atau tidak ada dalam valid_pages, tampilkan dashboard
if (empty($pages) || !array_key_exists($pages, $valid_pages)) {
    include "dashboard.php";
} else {
    // Include file sesuai dengan pages yang diminta
    include $valid_pages[$pages];
}
?>