<?php
include "../config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_prakerin']) && isset($_POST['id_user'])) {
    $id_prakerin = mysqli_real_escape_string($mysqli, $_POST['id_prakerin']);
    $id_user = mysqli_real_escape_string($mysqli, $_POST['id_user']);

    $query = "UPDATE prakerin SET id_user='$id_user' WHERE id_prakerin='$id_prakerin'";
    $update = mysqli_query($mysqli, $query);

    ob_clean(); // bersihkan output sebelumnya (seperti dari error atau BOM)
    header('Content-Type: application/json');
    if ($update) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($mysqli)]);
    }
    exit;
} else {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}
?>
