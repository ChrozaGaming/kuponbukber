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
    // Mengecek apakah kode kupon sudah pernah ditukarkan
    $sql_check_kupon_ditukar = "SELECT kupon_ditukar FROM pendaftar WHERE nama='$nama' AND no_hp='$no_hp' AND kode_kupon='$kode_kupon'";
    $result_check_kupon_ditukar = $conn->query($sql_check_kupon_ditukar);
    $kupon_ditukar = $result_check_kupon_ditukar->fetch_assoc()["kupon_ditukar"];

    if ($kupon_ditukar == 0) {
		// Menukar kupon
		$sql = "UPDATE pendaftar SET kupon_ditukar=1 WHERE nama='$nama' AND no_hp='$no_hp' AND kode_kupon='$kode_kupon'";
  
		if ($conn->query($sql) === TRUE) {
		  echo '<p style="color:green; font-weight:bold;">✅Selamat Kupon Anda Telah Teraktivasi✅ Silahkan mengambil <b>Makanan</b>.</p>';
		} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		}
	} else {
		echo '<p style="color:red; font-weight:bold;">Maaf, kupon yang Anda masukkan sudah ditukarkan sebelumnya.</p>';
		echo '<p style="color:red; font-weight:bold;">❌Maaf, anda belum bisa menukarkan kupon ini untuk mengambil <b>Makanan</b>❌.</p>';
		echo '<p style="color:red; font-weight:bold;">Data yang Anda masukkan:</p>';
		echo '<ul>';
		echo '<p style="color:red; font-weight:bold;">Nama: ' . $nama . '</p>';
		echo '<p style="color:red; font-weight:bold;">Nomor Handphone: ' . $no_hp . '</p>';
		echo '<p style="color:red; font-weight:bold;">Kode Kupon: ' . $kode_kupon . '</p>';
		echo '</ul>';
		
		
	}
} else {
	echo "<p>Maaf, data yang Anda masukkan tidak valid. Silakan periksa kembali nama, nomor handphone, dan kode kupon.</p>";
	echo "<p>Data yang Anda masukkan:</p>";
	echo "<ul>";
	echo "<p>Nama: " . $nama . "</p>";
	echo "<p>Nomor Handphone: " . $no_hp . "</p>";
	echo "<p>Kode Kupon: " . $kode_kupon . "</p>";
	echo "</ul>";
}
}
  
  ?>
<br>
<br>
<div style="text-align:center;">
  <a href="masukkankupon.php" style="display:inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-align: center; font-size: 28px; font-weight: bold; border: none; border-radius: 3px; cursor: pointer; box-shadow: 0 3px 0 #2F3D44;">Kembali ke halaman input kode kupon</a>
</div>

</div>


<?php

// Membersihkan data input dari form
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$conn->close();
?>

<style>
    p {
        font-size: 28px;
		text-align: center;
    }

   button {
  display: inline-block;
  background-color: #4CAF50;
  border: none;
  color: #4CAF50;
  text-align: center;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 28px;
  margin: 4px 2px;
  cursor: pointer;
  border-style: inset;
  border-width: 2px;
  border-color: #70AD47;
}

.button:active {
  background-color: #70AD47;
  box-shadow: inset 0 3px 5px rgba(0,0,0,0.2);
  transform: translateY(2px);
}
</style>

<style>
		/* Style the button */
		.button {
			display: inline-block;
			border-radius: 3px;
			background-color: #70AD47;
			border: none;
			color: #ffff;
			text-align: center;
			font-size: 28px;
			padding: 30px;
			width: 300px;
			transition: all 0.8s;
			cursor: pointer;
			box-shadow: 0 4px #70AD47;
		}

		/* Add a press effect on click */
		.button:active {
			box-shadow: 0 2px #70AD47;
			transform: translateY(4px);
		}

		/* Center the button horizontally and vertically */
		.center {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
		}

		/* Set the button to be responsive on mobile devices */
		@media only screen and (max-width: 600px) {
			.button {
				font-size: 20px;
				padding: 10px;
				width: 150px;
			}
		}
	</style>


