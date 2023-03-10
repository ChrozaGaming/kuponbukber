<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bukberramadhan";

$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah form telah terisi dengan benar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["kode_kupon"]) && !empty($_POST["kode_kupon"])) {
        $kode_kupon = test_input($_POST["kode_kupon"]);

        // Mengecek apakah kode kupon telah diambil
        $sql_check = "SELECT COUNT(*) as count FROM pendaftar WHERE kode_kupon='$kode_kupon'";
        $result_check = $conn->query($sql_check);
        $count = $result_check->fetch_assoc()["count"];

        if ($count >= 1) {
            echo "Kode kupon telah diambil.";
        } else {
            echo "Kode kupon belum diambil.";
        }
    } else {
        // Handle the case where "kode_kupon" is not set or empty
    }
}

// Membersihkan data input dari form
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$conn->close();
?>
