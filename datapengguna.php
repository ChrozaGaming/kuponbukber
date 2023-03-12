<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bukberramadhan";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Query untuk menampilkan data dari tabel kupon
$sql = "SELECT id, nama, tanggal_dibuat, status FROM kupon";
$result = mysqli_query($conn, $sql);

// Jika data ditemukan, tampilkan dalam bentuk tabel
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Nama</th><th>Tanggal Dibuat</th><th>Status</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["nama"] . "</td><td>" . $row["tanggal_dibuat"] . "</td><td>" . $row["status"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "Data tidak ditemukan";
}

// Tutup koneksi
mysqli_close($conn);
?>


<style>
    table {
        border-collapse: collapse;
        width: 100%;
        font-family: Arial, sans-serif;
        color: #333;
    }

    th, td {
        text-align: left;
        padding: 12px;
    }

    th {
        background-color: #4CAF50;
        color: white;
        text-transform: uppercase;
        font-size: 18px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    tbody tr td:first-child {
        text-transform: uppercase;
    }

    tbody tr td:last-child {
        text-transform: capitalize;
    }

    thead {
        font-weight: bold;
    }

    tfoot {
        font-style: italic;
        background-color: #f2f2f2;
    }

    tfoot tr td:first-child {
        text-align: right;
        font-weight: bold;
    }

    tfoot tr td:last-child {
        text-align: center;
    }

    .btn {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
    }

    .btn:hover {
        background-color: #2E8B57;
    }

    @media only screen and (max-width: 600px) {
        table {
            font-size: 14px;
        }

        th, td {
            padding: 8px;
        }
    }
</style>


