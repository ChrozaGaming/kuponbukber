<!DOCTYPE html>
<html>
<head>
	<title>Ambil Kupon</title>
</head>
<body>
	<h1>Ambil Kupon</h1>
  <form method="POST" action="ambil_kupon.php">
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
  if (isset($_POST["no_hp"]) && !empty($_POST["no_hp"])) {
    $no_hp = test_input($_POST["no_hp"]);

    // Mengecek jumlah kupon yang telah diambil
    $sql_check = "SELECT COUNT(*) as count FROM pendaftar WHERE nama='$nama' AND no_hp='$no_hp'";
    $result_check = $conn->query($sql_check);
    $count = $result_check->fetch_assoc()["count"];

    if ($count >= 1) {
      echo "Maaf, Anda sudah mengambil kupon sebelumnya.";
      exit;
    }
    
    $kode_kupon = generate_kode_kupon();

    $sql_check = "SELECT COUNT(*) as count FROM pendaftar WHERE kode_kupon = '$kode_kupon'";
    $result_check = $conn->query($sql_check);
    $count_check = $result_check->fetch_assoc()["count"];
      
    while ($count_check > 0) {
      $kode_kupon = generate_kode_kupon();
      
      $sql_check = "SELECT COUNT(*) as count FROM pendaftar WHERE kode_kupon = '$kode_kupon'";
      $result_check = $conn->query($sql_check);
      $count_check = $result_check->fetch_assoc()["count"];
    }

    $sql = "INSERT INTO pendaftar (nama, no_hp, kode_kupon) VALUES ('$nama', '$no_hp', '$kode_kupon')";

    if ($conn->query($sql) === TRUE) {
      echo "Kode kupon Anda adalah: " . $kode_kupon;
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

