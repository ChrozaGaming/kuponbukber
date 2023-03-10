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

<!DOCTYPE html>
<html>
<head>
	<title>Cek Kode Kupon</title>
	<style type="text/css">
		body {
			font-family: sans-serif;
			background-color: #f0f0f0;
		}
        .container {
		display: flex;
		flex-direction: column;
		align-items: center;
		margin-top: 50px;
	}

	.form {
		display: flex;
		flex-direction: column;
		align-items: center;
		background-color: #fff;
		padding: 30px;
		box-shadow: 0px 0px 10px #ccc;
		border-radius: 10px;
	}

	label {
		font-weight: bold;
		margin-bottom: 10px;
	}

	input[type="text"] {
		padding: 10px;
		border: none;
		border-radius: 5px;
		margin-bottom: 20px;
		width: 100%;
		max-width: 400px;
		box-sizing: border-box;
	}

	button[type="submit"] {
		padding: 10px;
		background-color: #4caf50;
		color: #fff;
		border: none;
		border-radius: 5px;
		cursor: pointer;
	}

	.kode-kupon {
		margin-top: 20px;
		padding: 10px;
		background-color: #fff;
		box-shadow: 0px 0px 10px #ccc;
		border-radius: 5px;
		max-width: 400px;
		text-align: center;
	}
</style>

