<?php
// Definisi konstanta BASE_URL
define('BASE_URL', (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/');

// Fungsi untuk mendapatkan URL absolut
function getBaseURL() {
    return BASE_URL;
}
?>