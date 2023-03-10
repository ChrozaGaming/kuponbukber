<?php>
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bukberramadhan";
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    
    // Mengecek koneksi
    if ($conn->connect_error) {
      die("Koneksi gagal: " . $conn->connect_error);
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <h1>Mohon Maaf Kupon Anda Sudah Diambil <?php 		
    echo '<p style="color:red; font-weight:bold;">Data yang Anda masukkan:</p>';
		echo '<ul>';
		echo '<p style="color:red; font-weight:bold;">Nama: ' . $nama . '</p>';
		echo '<p style="color:red; font-weight:bold;">Nomor Handphone: ' . $no_hp . '</p>';
		echo '<p style="color:red; font-weight:bold;">Kode Kupon: ' . $kode_kupon . '</p>';
		echo '</ul>';?></h1>
</head>
<body>
    
</body>
</html>

<style>
    h1 {
        text-align: center;
    }
</style>