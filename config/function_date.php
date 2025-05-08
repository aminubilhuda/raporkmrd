<?php
// function tgl_indonesia($tgl){
//    $nama_bulan = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		
// 	$tanggal = substr($tgl,8,2);
// 	$bulan = $nama_bulan[(int)substr($tgl,5,2)];
// 	$tahun = substr($tgl,0,4);
	
// 	return $tanggal.' '.$bulan.' '.$tahun;		 
// }	

function tgl_indonesia($tgl){
    // Cek apakah format tanggal valid
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $tgl)) {
        return "Format tanggal tidak valid";
    }
    
    $nama_bulan = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    
    $tanggal = substr($tgl,8,2);
    $bulan = $nama_bulan[(int)substr($tgl,5,2)];
    $tahun = substr($tgl,0,4);
    
    return $tanggal.' '.$bulan.' '.$tahun;		 
}



function namaBulan ($num)
{
	switch ($num)
	{
		case 1: return 'Januari';
		case 2: return 'Februari';
		case 3: return 'Maret';
		case 4: return 'April';
		case 5: return 'Mei';
		case 6: return 'Juni';
		case 7: return 'Juli';
		case 8: return 'Agustus';
		case 9: return 'September';
		case 10: return 'Oktober';
		case 11: return 'November';
		case 12: return 'Desember';
	}
	return 'error';
}

// function getPembukaBerdasarkanNilai($nilai) {
//    if ($nilai == 0) {
//     return "Belum ada capaian kompetensi yang dinilai.";
// } elseif ($nilai >= 90) {
//     return "Menunjukkan penguasaan yang sangat baik dalam ";
// } elseif ($nilai >= 80 && $nilai < 90) {
//     return "Menunjukkan penguasaan yang baik dalam ";
// } elseif ($nilai >= 70 && $nilai < 80) {
//     return "Menunjukkan penguasaan dalam ";
// } else {
//     return "Perlu pendampingan dalam ";
// }
// }
?>