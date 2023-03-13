<!DOCTYPE html>
<html>

<head>
    <title>Penukaran Kupon</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsqrcode/0.6.2/jsqrcode.min.js"></script>
</head>

<body>
<h1>Penukaran Kupon</h1>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bukberramadhan";

session_start();

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}



// Connect to the database

// Create connection
// Check connection
// session_start();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Check if the nama and no_hp fields are set
    if (isset($_POST['nama']) && isset($_POST['no_hp'])) {
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
        $kode_kupon = mysqli_real_escape_string($conn, $_POST['kode_kupon']);

        // Check if the coupon has already been redeemed
        $sql = "SELECT * FROM kupontelahdireedem WHERE kode_kupon='$kode_kupon'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<p style='text-align: center; color: red;'>&#10006; Kupon sudah terpakai oleh " . $row['nama'] . " dengan no. HP " . $row['no_hp'] . " dan kode kupon " . $row['kode_kupon'] . "</p>";
            }
        } else {
            // Check if the coupon code belongs to the user
            $sql = "SELECT * FROM kupon WHERE nama='$nama' AND no_hp='$no_hp' AND kode_kupon='$kode_kupon'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                // Insert the redeemed coupon code into the database
                $sql = "INSERT INTO kupontelahdireedem (nama, no_hp, kode_kupon) VALUES ('$nama', '$no_hp', '$kode_kupon')";
                if (mysqli_query($conn, $sql)) {
                    echo "<p style='text-align: center; color: green;'>&#10004; Kupon berhasil dipakai</p>";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "<p style='text-align: center; color: red;'>&#10006; Kupon sudah tidak cocok dengan no hp dan nama anda!</p>";
            }
        }
    } else {
        echo "<p style='text-align: center; color: red;'>&#10006; Nama dan No. HP harus diisi!</p>";
    }
}

// Check if the coupon code has been redeemed before
$sql = "SELECT * FROM kupontelahdireedem WHERE kode_kupon='$kode_kupon'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
//    echo "<p style='text-align: center; font-weight: bold; color: red;'>Kupon telah digunakan oleh orang tersebut</p>";
    // Update the status of the coupon in the kupon table
    $sql = "UPDATE kupon SET status='digunakan' WHERE kode_kupon='$kode_kupon'";
    if (mysqli_query($conn, $sql)) {
        echo "<p style='text-align: center; font-weight: bold; color: green;'>Status kupon telah diubah menjadi digunakan</p>";
    } else {
//        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    // Insert the coupon code into the kupontelahdireedem table
    $sql = "INSERT INTO kupontelahdireedem (kode_kupon) VALUES ('$kode_kupon')";
    if (mysqli_query($conn, $sql)) {
        echo "<p>Kupon berhasil diredeem. Kode kupon Anda adalah $kode_kupon</p>";
        echo "<img src='data:image/png;base64," . base64_encode($qrCodeImage) . "' alt='QR Code' style='display: block; margin: auto; width: 80%; max-width: 500px;'>";
    } else {
        echo "Error inserting record: " . mysqli_error($conn);
    }
}




// Close the connection
mysqli_close($conn);
?>

<form method="post" action="logout.php">
    <input type="submit" name="logout" value="Logout Dari Admin">
</form>

<style>
    body {
        background-color: #FFC107;
    }

    h1 {
        text-align: center;
        color: white;
    }

    form {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.2);
        margin: 50px auto;
        width: 500px;
        text-align: center;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-size: 20px;
    }

    input[type="text"] {
        padding: 10px;
        font-size: 18px;
        width: 100%;
        margin-bottom: 20px;
        border-radius: 5px;
        border: none;
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        font-size: 18px;
        cursor: pointer;
    }

    p {
        margin-top: 20px;
        font-size: 20px;
        color: #333;
    }
</style>
<!-- Coupon redeem form -->
<form action="" method="post">
    <label for="nama">Nama:</label>
    <input type="text" id="nama" name="nama" placeholder="Masukkan nama Anda">
    <br><br>
    <label for="no_hp">No. HP:</label>
    <input type="text" id="no_hp" name="no_hp" placeholder="Masukkan no. HP Anda">
    <br><br>
    <label for="kode_kupon">Kode Kupon:</label>
    <input type="text" id="kode_kupon" name="kode_kupon" placeholder="Masukkan kode kupon Anda">
    <br><br>
    <input type="submit" name="submit" value="Tukar Kupon"><br><br>

</form>
<!-- Include JavaScript library for QR code scanning -->
<script src="https://rawgit.com/LazarSoft/jsqrcode/master/src/qr_packed.js"></script>
<!-- HTML for the QR code scanning button -->
<!-- <button id="scanBtn" onclick="scanQR()">Scan QR Code</button> -->

<script src="./node_modules/html5-qrcode/html5-qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js" integrity="sha512-k/KAe4Yff9EUdYI5/IAHlwUswqeipP+Cp5qnrsUjTPCgl51La2/JhyyjNciztD7mWNKLSXci48m7cctATKfLlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
    main {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #reader {
        width: 600px;
    }

    #result {
        text-align: center;
        font-size: 1.5rem;
    }
</style>

<main>
    <div id="reader"></div>
    <div id="result"></div>
</main>


<script>
    const scanner = new Html5QrcodeScanner('reader', {
        // Scanner will be initialized in DOM inside element with id of 'reader'
        qrbox: {
            width: 575,
            height: 575,
        }, // Sets dimensions of scanning box (set relative to reader element width)
        fps: 60, // Frames per second to attempt a scan
    });


    scanner.render(success, error);
    // Starts scanner

    function success(result) {
        document.getElementById('kode_kupon').value = result;
        scanner.clear();
        document.getElementById('reader').remove();
    }

    function error(err) {
        console.error(err);
        // Prints any errors to the console
    }
</script>

<!-- JavaScript function for QR code scanning -->
<!-- <script>
    const scanner = new Html5QrcodeScanner('reader', {
        // Scanner will be initialized in DOM inside element with id of 'reader'
        qrbox: {
            width: 250,
            height: 250,
        }, // Sets dimensions of scanning box (set relative to reader element width)
        fps: 20, // Frames per second to attempt a scan
    });


    scanner.render(success, error);
    // Starts scanner

    function success(result) {

        document.getElementById('result').innerHTML = `
<h2>Success!</h2>
<p><a href="${result}">${result}</a></p>
`;
        // Prints result as a link inside result element

        scanner.clear();
        // Clears scanning instance

        document.getElementById('reader').remove();
        // Removes reader element from DOM since no longer needed

    }

    function error(err) {
        console.error(err);
        // Prints any errors to the console
    } -->
</script>

</body>

</html>