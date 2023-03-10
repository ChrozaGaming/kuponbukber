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
        echo "Kupon berhasil ditukar!";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    } else {
      echo "Maaf, kupon yang Anda masukkan sudah ditukarkan sebelumnya.";
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
