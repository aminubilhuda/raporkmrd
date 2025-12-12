<?php
$mysqli = new mysqli("localhost", "root", "", "abdinega_db_raporkm");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

echo "Tables:\n";
$result = $mysqli->query("SHOW TABLES");
while ($row = $result->fetch_array()) {
    echo $row[0] . "\n";
}

echo "\nStructure of proyek_tujuan:\n";
$result = $mysqli->query("DESCRIBE proyek_tujuan");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
} else {
    echo "Table proyek_tujuan does not exist.\n";
}

echo "\nContent of deskripsi_kokurikuler:\n";
$result = $mysqli->query("SELECT * FROM deskripsi_kokurikuler");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
} else {
    echo "Table deskripsi_kokurikuler does not exist.\n";
}

echo "\nStructure of nilai_kokurikuler:\n";
$result = $mysqli->query("DESCRIBE nilai_kokurikuler");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
} else {
    echo "Table nilai_kokurikuler does not exist.\n";
}
?>
