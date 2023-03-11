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

// Check if the kode_kupon parameter is set in the URL
if (isset($_GET['kode_kupon'])) {
    $kode_kupon = $_GET['kode_kupon'];
    $_SESSION['kode_kupon'] = $kode_kupon;
} else {
    // If the kode_kupon parameter is not set, redirect to the index page
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Kupon Anda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #f1f1f1;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #666666;
            margin-top: 50px;
        }

        p {
            color: #333333;
            font-size: 18px;
        }

        img {
            width: 300px;
            height: auto;
            margin-top: 20px;
            border: 2px solid #666666;
        }

        a {
            color: #666666;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            color: red;
            font-weight: bold;
        }
    </style>

</head>

<body>
    <h1>Kupon Anda</h1>
    <?php
    require_once('phpqrcode/qrlib.php');
    // Check if the kode_kupon is set
    if (isset($_SESSION['kode_kupon'])) {
        $kode_kupon = $_SESSION['kode_kupon'];
    } else {
        $kode_kupon = '';
    }
    ?>
    <p>Ini adalah kode kupon Anda:</p>
    <p><?php echo $kode_kupon; ?></p>
    <?php
    // Generate QR code for the coupon code
    $qrCodePath = 'qrcodes/' . $kode_kupon . '.png';
    QRcode::png($kode_kupon, $qrCodePath, QR_ECLEVEL_L, 25, 1);
    // Get the URL of the coupon page with the coupon code as a parameter
    $coupon_url = "coupon.php?kode_kupon=" . urlencode($kode_kupon);
    ?>
    <p>Ini adalah QR code untuk kupon Anda:</p>
    <img src="<?php echo $qrCodePath; ?>" alt="QR Code">
    <p>Silakan simpan kode kupon dan QR code ini untuk ditukarkan saat penukaran kupon.</p>
    <p><b>INGAT!!! KODE KUPON DAN QRCODE <u>❌TIDAK BOLEH!❌</u> DIBERITAHU/DISEBAR/DITUNJUKKAN/DILIHATKAN/ KEPADA SIAPAPUN</b></p>
    <p><b>KARENA BISA DISALAHGUNAKAN SAAT PENUKARAN KUPON</b></p>
    <p>Untuk mengunduh QR code Anda, silakan klik <a href="<?php echo $qrCodePath; ?>" download="qrcode.png">di sini</a>.</p>
    <?php
    // Get name and phone number from the database based on the coupon code
    $sql = "SELECT nama, no_hp FROM kupon WHERE kode_kupon = '$kode_kupon'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $nama = $row["nama"];
            $no_hp = $row["no_hp"];
    ?>
            <p>Berikut Nama dan Nomor HP Anda:</p>
            <p><?php echo $nama . " (" . $no_hp . ")"; ?></p>
    <?php
        }
    } else {
        echo "Data kupon tidak ditemukan";
    }
    mysqli_close($conn);
    ?>
    <button onclick="printKupon()">Print Kupon</button>

    <script>
        function printKupon() {
            window.print();
        }
    </script>
</body>

</html>
<style>
    img {
        width: 300px;
        /* ubah angka sesuai dengan ukuran yang diinginkan */
        height: auto;
        margin-top: 20px;
        border: 2px solid #666666;
    }
</style>