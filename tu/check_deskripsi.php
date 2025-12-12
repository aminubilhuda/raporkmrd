<?php
include '../config/koneksi.php';

echo "Checking deskripsi_kokurikuler...\n";
$result = mysqli_query($mysqli, "SELECT * FROM deskripsi_kokurikuler");
if(mysqli_num_rows($result) == 0){
    echo "Table is empty. Inserting default data...\n";
    mysqli_query($mysqli, "INSERT INTO deskripsi_kokurikuler (nilai, keterangan) VALUES (4, 'Sangat Baik'), (3, 'Baik'), (2, 'Cukup'), (1, 'Kurang')");
    echo "Data inserted.\n";
} else {
    echo "Table has " . mysqli_num_rows($result) . " rows.\n";
    while($row = mysqli_fetch_assoc($result)){
        print_r($row);
    }
}
?>
