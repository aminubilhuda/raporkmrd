<?php  
session_start();
error_reporting(0);

    // Pastikan autoload.php berada di lokasi yang benar
    require __DIR__ . '/../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    include "../../config/function_antiinjection.php";
    include "../../config/koneksi.php";
    include "../../config/kode.php";

    $user = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE id_user='$_SESSION[id_user]'"));
    $sekolah = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM sekolah WHERE id_sekolah='1'"));
    $kepala = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users WHERE jabatan='1'"));

    $datakelas = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM kelas_wali 
    JOIN kelas on kelas_wali.id_kelas=kelas.id_kelas
    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND kelas.id_kelas='$_GET[orderID]'"));

    $jumlahmapelkelas = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM mapel_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]'"));
    $jumlahsiswakelas = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM siswa_kelas WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]'"));

// Membuat objek Spreadsheet baru
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Menambahkan judul dan informasi kelas
    $sheet->setCellValue('A1', 'Lager Nilai Kelas');
    $sheet->setCellValue('A2', 'Kelas / Rombel: ' . $datakelas['nama_kelas']);

    // Format untuk kolom NISN sebagai teks
    $sheet->getStyle('B')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

    // Menambahkan header tabel
    $sheet->setCellValue('A4', 'No');
    $sheet->setCellValue('B4', 'NISN');
    $sheet->setCellValue('C4', 'Nama Peserta Didik');

    $sheet->getColumnDimension('C')->setAutoSize(true);
    
	// Set alignment header ke tengah
	$sheet->getStyle('A4:C4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Loop untuk mapel (mata pelajaran)
    $column = 'D'; // Mulai dari kolom D
    $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
        JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
        WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' ORDER BY urut ASC");
    $mapelList = []; // Array untuk menyimpan daftar mapel

    while ($rmapelkelas = mysqli_fetch_array($mapelkelas)) {
        $sheet->setCellValue($column . '4', $rmapelkelas['nama_mapel']); // Menambahkan header untuk mapel
        $mapelList[] = $rmapelkelas['id_mapel']; // Menyimpan id_mapel ke array untuk digunakan nanti

		// Set text di header ke tengah
    	$sheet->getStyle($column . '4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $column++;
    }

    // Kolom tambahan untuk jumlah, rata-rata, dan ranking
    $columnJumlah = $column;
    $sheet->setCellValue($column . '4', 'Jumlah Nilai');
    $column++;
    $columnRata = $column;
    $sheet->setCellValue($column . '4', 'Rata-rata');
    $column++;
    $sheet->setCellValue($column . '4', 'Rank');

    // Set Header untuk presensi
    $absen = mysqli_query($mysqli,"SELECT * FROM absen ORDER BY id_absen ASC");
    while ($rabsen = mysqli_fetch_array($absen)) {
        $sheet->setCellValue($column . '4', $rabsen['absen']);
        $column++;
    }

    // Menulis data siswa dan nilai
    $row = 5; // Mulai dari baris ke-5
    $nomor = 1;
    $nomorrank = 1;
    $nilai_mapel_total = []; // Menyimpan nilai total untuk setiap mapel
    $jumlah_total = [];
    $rata_total = [];

    $siswakelas = mysqli_query($mysqli,"SELECT * FROM nilai_kelas 
        JOIN siswa ON nilai_kelas.id_siswa = siswa.id_siswa
        WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' ORDER BY nilai DESC");

    while ($rsiswakelas = mysqli_fetch_array($siswakelas)) {
        $sheet->setCellValue('A' . $row, $nomor++);
        $sheet->setCellValue('B' . $row, $rsiswakelas['nisn']);
        $sheet->setCellValue('C' . $row, $rsiswakelas['nama_siswa']);
		
		// Set alignment nilai ke tengah
		$sheet->getStyle('A' . $row . ':C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $col = 'D';
        foreach ($mapelList as $id_mapel) {
            $nilaimapel = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM nilai_mata_pelajaran WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' AND id_mapel='$id_mapel' AND id_siswa='$rsiswakelas[id_siswa]'"));
            $nilai_mapel_kelas = round(($nilaimapel['nilai']), 2);
            $sheet->setCellValue($col . $row, $nilai_mapel_kelas);

			// Set alignment untuk nilai mapel ke tengah
        	$sheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            
            // Menyimpan nilai untuk statistik (rata-rata, min, max)
            if (!isset($nilai_mapel_total[$id_mapel])) {
                $nilai_mapel_total[$id_mapel] = [
                    'total' => 0,
                    'count' => 0,
                    'min' => $nilai_mapel_kelas,
                    'max' => $nilai_mapel_kelas
                ];
            }
            $nilai_mapel_total[$id_mapel]['total'] += $nilai_mapel_kelas;
            $nilai_mapel_total[$id_mapel]['count'] += 1;
            $nilai_mapel_total[$id_mapel]['min'] = min($nilai_mapel_total[$id_mapel]['min'], $nilai_mapel_kelas);
            $nilai_mapel_total[$id_mapel]['max'] = max($nilai_mapel_total[$id_mapel]['max'], $nilai_mapel_kelas);
            
            $col++;
        }

        // Simpan nilai Jumlah dan Rata-rata untuk statistik
        $jumlah_total[] = $rsiswakelas['jumlah'];
        $rata_total[] = $rsiswakelas['nilai'];

        $sheet->setCellValue($columnJumlah . $row, $rsiswakelas['jumlah']);
		$sheet->getStyle($columnJumlah . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Nilai Jumlah ke tengah

        $col++;
        $sheet->setCellValue($columnRata . $row, $rsiswakelas['nilai']);
		$sheet->getStyle($columnRata . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Nilai Rata-rata ke tengah

        $col++;
        $sheet->setCellValue($col . $row, $nomorrank++);
		$sheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Rank ke tengah

        // Tambahkan kolom presensi
        $absen = mysqli_query($mysqli,"SELECT * FROM absen ORDER BY id_absen ASC");
        while ($rabsen = mysqli_fetch_array($absen)) {
            $presensi = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM presensi WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_absen='$rabsen[id_absen]' AND id_siswa='$rsiswakelas[id_siswa]'"));
            $sheet->setCellValue($col . $row, $presensi['jumlah']);
			// Set alignment untuk presensi ke tengah
    		$sheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $col++;
        }
        $row++;
		
		// Zebra Stripes (warna alternatif untuk baris)
        if ($row % 2 == 0) {
            $sheet->getStyle('A' . $row . ':' . $columnRata . $row)->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'E0E0E0', // Warna abu-abu terang untuk baris genap
                    ],
                ],
            ]);
        }
    }

    // Tambahkan baris untuk rata-rata, nilai terendah, dan tertinggi per mapel dan juga untuk kolom Jumlah Nilai dan Rata-rata
    $row++; // Pindah ke baris berikutnya untuk menambahkan statistik

    // Baris rata-rata
	$sheet->mergeCells('A' . $row . ':C' . $row); // Merge dari kolom A sampai C
    $sheet->setCellValue('A' . $row, 'Rata-rata');
	$sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $col = 'D';
    foreach ($mapelList as $id_mapel) {
        $rata_rata = round($nilai_mapel_total[$id_mapel]['total'] / $nilai_mapel_total[$id_mapel]['count'], 2);
        $sheet->setCellValue($col . $row, $rata_rata);
		
		// Set alignment untuk rata-rata ke tengah
   	 	$sheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $col++;
    }

    // Tambahkan rata-rata untuk Jumlah Nilai dan Rata-rata Nilai
    $rata_jumlah = round(array_sum($jumlah_total) / count($jumlah_total), 2);
    $rata_rata_rata = round(array_sum($rata_total) / count($rata_total), 2);
    $sheet->setCellValue($columnJumlah . $row, $rata_jumlah);
	$sheet->getStyle($columnJumlah . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Rata-rata Jumlah

    $sheet->setCellValue($columnRata . $row, $rata_rata_rata);
	$sheet->getStyle($columnRata . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Rata-rata Nilai


    $row++; // Pindah ke baris berikutnya untuk nilai terendah

    // Baris nilai terendah
	$sheet->mergeCells('A' . $row . ':C' . $row); // Merge dari kolom A sampai C
    $sheet->setCellValue('A' . $row, 'Nilai Terendah');
	$sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $col = 'D';
    foreach ($mapelList as $id_mapel) {
        $sheet->setCellValue($col . $row, $nilai_mapel_total[$id_mapel]['min']);
        $col++;
    }

    // Nilai terendah untuk Jumlah Nilai dan Rata-rata Nilai
    $nilai_terendah_jumlah = min($jumlah_total);
    $nilai_terendah_rata = min($rata_total);
    $sheet->setCellValue($columnJumlah . $row, $nilai_terendah_jumlah);
    $sheet->setCellValue($columnRata . $row, $nilai_terendah_rata);

    $row++; // Pindah ke baris berikutnya untuk nilai tertinggi

    // Baris nilai tertinggi
	$sheet->mergeCells('A' . $row . ':C' . $row); // Merge dari kolom A sampai C
    $sheet->setCellValue('A' . $row, 'Nilai Tertinggi');
	$sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $col = 'D';
    foreach ($mapelList as $id_mapel) {
        $sheet->setCellValue($col . $row, $nilai_mapel_total[$id_mapel]['max']);
		$sheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Nilai Tertinggi Mapel ke tengah
        $col++;
    }

    // Nilai tertinggi untuk Jumlah Nilai dan Rata-rata Nilai
    $nilai_tertinggi_jumlah = max($jumlah_total);
    $nilai_tertinggi_rata = max($rata_total);
    $sheet->setCellValue($columnJumlah . $row, $nilai_tertinggi_jumlah);
	$sheet->getStyle($columnJumlah . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Nilai Tertinggi Jumlah ke tengah
    $sheet->setCellValue($columnRata . $row, $nilai_tertinggi_rata);
	$sheet->getStyle($columnRata . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Nilai Tertinggi Rata-rata ke tengah

	// Tambahkan border ke tabel, termasuk baris "Nilai Tertinggi"
	$styleArray = [
		'borders' => [
			'allBorders' => [
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				'color' => ['argb' => '000000'],
			],
		],
	];
	$sheet->getStyle('A4:' . $columnRata . $row)->applyFromArray($styleArray);

    // Tambahkan warna pada header tabel
    $headerStyleArray = [
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'argb' => 'FFFF00', // Warna kuning
            ],
        ],
        'font' => [
            'bold' => true,
        ],
    ];
    $sheet->getStyle('A4:' . $columnRata . '4')->applyFromArray($headerStyleArray);

	// Setelah semua data telah diisi (sebelum bagian writer->save())
	$sheet->getStyle('D5:' . $columnRata . ($row - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Menyimpan file Excel
    $writer = new Xlsx($spreadsheet);
    $filename = "Lager Nilai Kelas - " . $datakelas['nama_kelas'] . ".xlsx";

    // Output ke browser untuk download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');