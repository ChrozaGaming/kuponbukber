<?php
session_start();

// connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bukberramadhan";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if search term is set
if (isset($_POST['search'])) {
    $search_term = $_POST['search'];
    $sql = "SELECT id, nama, tanggal_dibuat, status FROM kupon WHERE nama LIKE '%$search_term%'";
} else {
    $sql = "SELECT id, nama, tanggal_dibuat, status FROM kupon";
}

$result = mysqli_query($conn, $sql);

// Jika data ditemukan, tampilkan dalam bentuk tabel
if (mysqli_num_rows($result) > 0) {
    echo '<table>';
    echo '<tr><th>ID</th><th>Nama</th><th>Tanggal Dibuat (d-m-Y H:i:s)</th><th>Status</th></tr>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["nama"] . "</td><td>" . date('d-m-Y H:i:s', strtotime($row["tanggal_dibuat"])) . "</td><td>" . $row["status"] . "</td></tr>";
    }
    echo '</table>';
} else {
    echo '<p style="text-align:center; color:red; font-weight:bold;">&#10060; Tidak ditemukan data yang sesuai dengan pencarian  &#10060;</p>';
}

// Close database connection
mysqli_close($conn);
?>
