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
    <p>Ini adalah QR Code untuk kupon Anda:</p>
    <img src="<?php echo $qrCodePath; ?>" alt="QR Code">
    <p>Silakan simpan kode kupon dan QR Code ini untuk ditukarkan saat penukaran kupon.</p>
    <p><b>INGAT!!! KODE KUPON DAN QRCODE <u>❌TIDAK BOLEH!❌</u> DIBERITAHU/DISEBAR/DITUNJUKKAN/DILIHATKAN/ KEPADA SIAPAPUN</b></p>
    <p><b>KARENA BISA DISALAHGUNAKAN SAAT PENUKARAN KUPON</b></p>
    <p>Untuk mengunduh QR Code Anda, silakan klik tombol➡️ <a href="<?php echo $qrCodePath; ?>" download="qrcode.png" class="button">Unduh QR Code</a>
        <?php
        // Get name and phone number from the database based on the coupon code
        $sql = "SELECT id, nama, no_hp FROM kupon WHERE kode_kupon = '$kode_kupon'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $nama = $row["nama"];
                $no_hp = $row["no_hp"];
        $id = $row["id"];
        ?>
    <p>Berikut Nama dan Nomor HP Anda:</p>
        <p><?php echo $nama . " (" . $no_hp . ")";?> pada Nomor ID: <?php echo $row['id']; ?></p>


    <?php
            }
        } else {
            echo "Data kupon tidak ditemukan";
        }

    $count = 0; // initialize $count with a default value of zero
    if ($count == 0) {

        // get the total number of rows in the table
        $result = mysqli_query($conn, "SELECT COUNT(*) FROM kupon");
        $row = mysqli_fetch_row($result);
        $total_rows = $row[0];

        // check if the table is empty
        if ($total_rows == 0) {
            // reset the auto-increment value of the ID column to 1
            mysqli_query($conn, "ALTER TABLE kupon AUTO_INCREMENT=1");
            $count++; // increment the count variable
        }
    }
    // display a message indicating whether the auto-increment value was reset or not
    if ($count > 0) {
//        echo "The auto-increment value of the ID column has been reset.";
    } else {
//        echo "The table is not empty, so the auto-increment value was not reset.";
    }
        mysqli_close($conn);
?>
<button class="button" onclick="printKupon()">Print Kupon</button>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<!-- Tambahkan tombol "Kembali" dan popup "Are you sure?" -->




<script>
    function printKupon() {
        window.print();
    }
</script>

<a href="ambil_kupon.php" class="button" onclick="return confirmKembali()">Kembali</a>


<script>
    // Fungsi untuk menampilkan popup "Are you sure?"
    function confirmKembali() {
        swal({
            title: "Are you sure?",
            text: "Apakah anda sudah [Screenshot/Simpan] atau Download file gambar QRCODE nya dan print(*opsional). Jika belum maka Pilih button 'Batalkan'.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Konfirmasi",
            cancelButtonText: "Batalkan",
            closeOnConfirm: false
        }, function() {
            // Jika pengguna memilih "Konfirmasi", direct ke halaman "ambil_kupon.php"
            window.location.href = "ambil_kupon.php";
        });
        return false; // Mencegah pengguna mengklik tombol "Kembali" sebelum memilih "Konfirmasi" atau "Batalkan"
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
</style>