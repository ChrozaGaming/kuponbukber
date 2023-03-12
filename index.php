<style>
  /* Style untuk form */
  /* Style untuk body */
  body {
    background-color: #F7F7F7;
    font-family: Arial, sans-serif;
  }

  /* Style untuk header */
  header {
    background-color: #5D5FEF;
    color: #fff;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  header h1 {
    margin: 0;
    font-size: 28px;
  }

  nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
  }

  nav li {
    margin-left: 20px;
  }

  nav a {
    color: #fff;
    text-decoration: none;
    font-size: 18px;
  }

  /* Style untuk banner */
  .banner {
    background-color: #FCD34D;
    color: #333;
    padding: 40px 20px;
    text-align: center;
  }

  h1 {
      text-align: center;
      color: white;
  }

  .banner h2 {
    margin: 0;
    font-size: 48px;
    font-weight: bold;
    line-height: 1.2;
    margin-bottom: 20px;
  }

  .banner p {
    margin: 20px 0;
    font-size: 24px;
    line-height: 1.5;
  }

  .button {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #5D5FEF;
    color: #fff;
    border: 2px solid #5D5FEF;
    border-radius: 3px;
    text-decoration: none;
    font-weight: bold;
    font-size: 18px;
    transition: all 0.3s ease-in-out;
  }

  .button:hover {
    background-color: transparent;
    color: #5D5FEF;
    text-decoration: none;
  }

  /* Style untuk kupon */
  .kupon {
    padding: 40px 20px;
    background-color: #fff;
    text-align: center;
  }


  .kupon h3 {
    margin: 0 0 20px 0;
    font-size: 28px;
    color: #5D5FEF;
  }

  .kupon-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
  }

  .kupon-item {
    width: calc(100% / 3 - 20px);
    margin: 10px;
    padding: 20px;
    background-color: #5D5FEF;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
    color: #fff;
  }

  .kupon-item h4 {
    margin: 0 0 10px 0;
    font-size: 24px;
    font-weight: bold;
  }

  .kupon-item p {
    font-size: 18px;
    margin-bottom: 20px;
  }

  /* Style untuk footer */
  footer {
    background-color: #333;
    color: #fff;
    padding: 20px;
    text-align: center;
    margin-top: 40px;
  }

  .center {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }

  footer p {
    margin: 0;
    font-size: 18px;
  }

  /* Style for screens up to 768px wide (e.g. mobile devices) */
  @media (max-width: 768px) {
    header h1 {
      font-size: 24px;
    }

    header ul {
      display: none;
    }

    header {
      flex-direction: column;
    }

    header h1:nth-child(1) {
      margin-top: 20px;
    }

    header h1:nth-child(2) {
      margin-bottom: 20px;
    }

    nav {
      margin-top: 20px;
    }

    nav li {
      margin-left: 0;
      margin-bottom: 10px;
    }

    nav a {
      font-size: 16px;
    }

    .kupon-item {
      width: calc(100% / 2 - 20px);
    }
  }
</style>
<!DOCTYPE html>
<html>

<head>
  <title>Pengambilan Kupon Masjid Al Hikmah</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <header class="center">
    <div class="container">
      <h1>Ambil Kupon Buka Puasa Bersama</h1>
      <br>
      <h1>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;MasjidAl Hikmah Candi</h1>
      <br>
      <nav>
        <ul>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
          <li><a href="#">Beranda</a></li>
          <li><a href="login.php">Penukaran Kupon</a></li>
          <li><a href="#">Tentang Kami</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <section class="banner">
    <div class="container">
      <h2>Ambil Kupon Buka Puasa Bersama Sekarang</h2>
      <p>Kami menyediakan kupon makanan gratis untuk agenda rutin buka puasa bersama. Ambil sekarang sebelum kehabisan!</p>
      <a href="ambil_kupon.php" class="button">Ambil Kupon</a>
    </div>
  </section>

  <section class="kupon">
    <div class="container">
      <h3 style="color: #1883C4;">Kupon Yang Tersedia :</h3>
      <div class="kupon-container">
        <?php include 'ambil_data_kupon.php'; ?>
      </div>
    </div>
  </section>

  <footer>
    <div class="container">
      <p>&copy; 2023 Sistem Kupon Masjid Al Hikmah Candi</p>
    </div>
  </footer>

  <script src="script.js"></script>
</body>

<h2 style="text-align: center; color: #219eff; text-shadow: 2px 2px 4px #888;">Berikut adalah kupon yang sudah terdaftar/diambil</h2>

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
// Query untuk menampilkan data dari tabel kupon
$sql = "SELECT id, nama, tanggal_dibuat, status FROM kupon";
$result = mysqli_query($conn, $sql);

// Jika data ditemukan, tampilkan dalam bentuk tabel
if (mysqli_num_rows($result) > 0) {
    echo '<form>';
    echo '<label for="search">Cari Nama:</label>';
    echo '<input type="text" id="search" name="search" placeholder="Masukkan nama...">';
    echo '</form>';

    echo "<table>";
    echo "<tr><th>ID</th><th>Nama</th><th>Tanggal Dibuat (y-m-d)</th><th>Status</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["nama"] . "</td><td>" . $row["tanggal_dibuat"] . "</td><td>" . $row["status"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo '<p style="text-align:center; color:red; font-weight:bold;">&#10060; Belum ada yang mengambil kupon  &#10060;</p>';
}
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search').on('input', function() {
            var search_term = $(this).val();

            $.ajax({
                url: 'search.php',
                type: 'POST',
                data: { search: search_term },
                success: function(response) {
                    $('table').html(response);
                }
            });
        });
    });
</script>
</html>

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

<style>
    form {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    label {
        font-size: 18px;
        font-weight: bold;
        margin-right: 10px;
    }

    input[type="text"] {
        font-size: 18px;
        padding: 5px;
        border: 2px solid #ccc;
        border-radius: 5px;
    }

    input[type="text"]:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 5px #007bff;
    }

    button[type="submit"] {
        font-size: 18px;
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #0062cc;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #007bff;
        color: #fff;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
