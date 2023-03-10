

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

// Mengecek jumlah pendaftar yang sudah mengambil kupon
$sql_count = "SELECT COUNT(*) as count FROM pendaftar";
$result_count = $conn->query($sql_count);
$count = $result_count->fetch_assoc()["count"];

// Membatasi jumlah pendaftar menjadi maksimal 350
if ($count >= 350) {
  echo '<div style="text-align:center; font-size:50px;">Maaf, jumlah pendaftar sudah mencapai batas maksimal.</div>';
  exit;
}

// Memeriksa apakah form telah terisi dengan benar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = test_input($_POST["nama"]);
  if (isset($_POST["no_hp"]) && !empty($_POST["no_hp"])) {
    $no_hp = test_input($_POST["no_hp"]);

// Mengecek jumlah kupon yang telah diambil
$sql_check = "SELECT COUNT(*) as count FROM pendaftar WHERE nama='$nama' AND no_hp='$no_hp'";
$result_check = $conn->query($sql_check);
$count = $result_check->fetch_assoc()["count"];

if ($count >= 1) {
  $sql_kupon = "SELECT kode_kupon FROM pendaftar WHERE nama='$nama' AND no_hp='$no_hp'";
  $result_kupon = $conn->query($sql_kupon);
  $row = $result_kupon->fetch_assoc();
  
  echo '<div style="text-align:center; font-size:50px;">Maaf, Anda sudah mengambil kupon.</div>';
  echo '<ul style="text-align:center;">';
  echo '<p style="color:red; font-weight:bold; font-size:30px;">Data yang Anda masukkan:</p>';
  echo '<ul style="text-align:center;">';
  echo '<li><p style="color:red; font-weight:bold; font-size:30px;">Nama: ' . $nama . '</p></li>';
  echo '<li><p style="color:red; font-weight:bold; font-size:30px;">Nomor Handphone: ' . $no_hp . '</p></li>';
  echo '<li><p style="color:red; font-weight:bold; font-size:30px;">Kode Kupon: ' . $row["kode_kupon"] . '</p></li>';
  echo '</ul>';

  echo '<a href="ambil_kupon.php" style="display:inline-block;padding:10px 20px;background-color:#ff6a00;color:#fff;text-align:center;text-decoration:none;text-shadow:1px 1px 0px #333;border-radius:5px;border:1px solid #333;box-shadow:inset 0 1px 0px #ffca28, 0 1px 0px #666;"><strong>Kembali ke Beranda</strong></a>';

  
  
  exit;
}
$kode_kupon = generate_kode_kupon();

// Mengecek apakah kode kupon sudah ada di database dan sudah ditukar
$sql_check = "SELECT COUNT(*) as count FROM pendaftar WHERE kode_kupon = '$kode_kupon' AND kupon_ditukar = '1'";
$result_check = $conn->query($sql_check);
$count_check = $result_check->fetch_assoc()["count"];

while ($count_check > 0) {
  $kode_kupon = generate_kode_kupon();

  $sql_check = "SELECT COUNT(*) as count FROM pendaftar WHERE kode_kupon = '$kode_kupon' AND kupon_ditukar = '1'";
  $result_check = $conn->query($sql_check);
  $count_check = $result_check->fetch_assoc()["count"];
}

$sql = "INSERT INTO pendaftar (nama, no_hp, kode_kupon) VALUES ('$nama', '$no_hp', '$kode_kupon')";

if ($conn->query($sql) === TRUE) {
  // Menampilkan kode kupon jika sudah ditukar
  $sql_kupon = "SELECT kode_kupon FROM pendaftar WHERE nama='$nama' AND no_hp='$no_hp' AND kupon_ditukar='1'";
  $result_kupon = $conn->query($sql_kupon);
  if ($result_kupon->num_rows > 0) {
    $row_kupon = $result_kupon->fetch_assoc();
    $kode_kupon = $row_kupon["kode_kupon"];
    echo '<p style="text-align:center;">Kode kupon yang telah ditukar adalah: ' . $kode_kupon . '</p>';
  } else {
    // Update nilai kupon_ditukar menjadi 1
    $sql_update = "UPDATE pendaftar SET kupon_ditukar = '1' WHERE nama='$nama' AND no_hp='$no_hp' AND kode_kupon='$kode_kupon'";
    if ($conn->query($sql_update) === TRUE) {
      echo '<p style="text-align:center;">Kode kupon Anda adalah: ' . $kode_kupon . '</p>';
    } else {
      echo "Error updating record: " . $conn->error;
    }
  }
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}


  } else {
    // Handle the case where "no_hp" is not set or empty
  }
}

// Membersihkan data input dari form
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Fungsi untuk generate kode kupon secara acak
function generate_kode_kupon() {
  $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $code_length = 12;
  $code = "";
  for ($i = 0; $i < $code_length; $i++) {
    $code .= $chars[mt_rand(0, strlen($chars) - 1)];
  }
  return $code;
}

$conn->close();
?>

<style>
		body {
			font-family: 'Montserrat', sans-serif;
			background-color: #f9f9f9;
			color: #333;
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		h1 {
			font-size: 36px;
			font-weight: bold;
			text-align: center;
			margin-top: 40px;
		}

		form {
			margin: 40px auto;
			max-width: 500px;
			background-color: #fff;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
		}

		label {
			display: block;
			margin-top: 20px;
			font-size: 20px;
			font-weight: bold;
		}

		input[type="text"], input[type="tel"] {
			display: block;
			width: 100%;
			padding: 10px;
			font-size: 18px;
			border: none;
			border-bottom: 2px solid #333;
			background-color: #f9f9f9;
			margin-top: 10px;
			box-sizing: border-box;
		}

		button[type="submit"] {
			background-color: #ff6a00;
			color: #fff;
			padding: 10px 20px;
			border: none;
			border-radius: 5px;
			font-size: 20px;
			font-weight: bold;
			cursor: pointer;
			margin-top: 20px;
			transition: background-color 0.3s ease;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
		}

		button[type="submit"]:hover {
			background-color: #ff7f50;
		}
	</style>

  <!DOCTYPE html>
<html>
<head>
	<title>Ambil Kupon</title>
</head>
<body>
	<h1>Ambil Kupon</h1>
  <form method="POST" action="">
  <label for="nama">Nama:</label>
  <input type="text" id="nama" name="nama" required>
  <br>
  <label for="no_hp">Nomor HP:</label>
  <input type="tel" id="no_hp" name="no_hp" required>
  <br>
  <button type="submit">Ambil Kupon</button>
</form>

  
</body>
</html>