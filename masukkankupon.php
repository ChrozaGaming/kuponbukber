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
	$nama = test_input($_POST["nama"]);
	$no_hp = test_input($_POST["no_hp"]);
	$kode_kupon = test_input($_POST["kode_kupon"]);

	// Mengecek apakah kode kupon valid
	$sql_check = "SELECT COUNT(*) as count FROM pendaftar WHERE nama='$nama' AND no_hp='$no_hp' AND kode_kupon='$kode_kupon'";
	$result_check = $conn->query($sql_check);
	$count = $result_check->fetch_assoc()["count"];

	if ($count == 1) {
		// Menukar kupon
		$sql = "UPDATE pendaftar SET kupon_ditukar=1 WHERE nama='$nama' AND no_hp='$no_hp' AND kode_kupon='$kode_kupon'";

		if ($conn->query($sql) === TRUE) {
			echo "Kupon berhasil ditukar!";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	} else {
		echo "Maaf, data yang Anda masukkan tidak valid. Silakan periksa kembali nama, nomor handphone, dan kode kupon.";
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
	<title>Menukar Kupon</title>
</head>
<body>
	<h1>Menukar Kupon</h1>
	<form method="POST" action="proses_menukar_kupon.php">
		<label for="nama">Nama:</label><br>
		<input type="text" id="nama" name="nama"><br>
		<label for="no_hp">Nomor Handphone:</label><br>
		<input type="text" id="no_hp" name="no_hp"><br>
		<label for="kode_kupon">Kode Kupon:</label><br>
		<input type="text" id="kode_kupon" name="kode_kupon"><br>
		<button type="submit">Menukar Kupon</button>
	</form>
</body>
</html>

<style>/* Style untuk form */
form {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  border: 1px solid #ddd;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

input[type="text"] {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 3px;
  margin-bottom: 10px;
}

button[type="submit"] {
  display: block;
  margin: 0 auto;
  padding: 10px 20px;
  background-color: #ff9800;
  border: none;
  border-radius: 3px;
  color: #fff;
  font-weight: bold;
  cursor: pointer;
}

button[type="submit"]:hover {
  background-color: #f57c00;
}

/* Style untuk halaman */
body {
  background-color: #f5f5f5;
  font-family: Arial, sans-serif;
  font-size: 14px;
  line-height: 1.5;
  color: #333;
}</style>