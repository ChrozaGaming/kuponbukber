<!DOCTYPE html>
<html>

<head>
    <title>Ambil Kupon</title>
    <style>
        body {
            background-color: lightblue;
        }

        h1 {
            text-align: center;
            color: #1883C4;
            background-color: #ccc;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            font-size: 16px;
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 16px;
            border: none;
            border-radius: 3px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        input[type="submit"] {
            background-color: #5D5FEF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        input[type="submit"]:hover {
            background-color: #fff;
            color: #5D5FEF;
            border: 2px solid #5D5FEF;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 40px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        /* Media queries */
        @media only screen and (max-width: 600px) {
            form {
                padding: 10px;
            }

            input[type="text"],
            input[type="password"] {
                margin-bottom: 10px;
            }

            input[type="submit"] {
                margin-top: 20px;
            }
        }

        p {
            text-align: center;
            margin: 20px 0;
            color: green;
            font-weight: bold;
        }

        .button-3d {
            display: inline-block;
            position: relative;
            padding: 10px 30px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            text-shadow: 1px 1px #000;
            background-color: #007bff;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .button-3d {
            /* Your button styles here */
        }

        .button-3d:hover {
            background-color: #0062cc;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
            transform: translate(1px, 1px);
        }

        .button-3d:active {
            box-shadow: none;
            transform: translate(0, 0);
        }

    </style>
</head>

<body>
    <h1>Ambil Kupon</h1>
    <?php
    // Check if the form is submitted

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bukberramadhan";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_POST['nama']) && isset($_POST['no_hp'])) {

        $nama = mysqli_real_escape_string($conn, $_POST['nama']);

        if (!ctype_upper($_POST['nama'])) {
            echo "<p>Nama harus diawali huruf kapital</p>";
            ?> <div class="button-container">
                <button class="button-3d" onclick="window.location.href='ambil_kupon.php'">Input Ulang</button>
            </div>
            <?php
            exit; ?>

<?php
    }

        // Make sure that no_hp is set before using it
        if (isset($_POST['no_hp'])) {
            $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);

            // Check if the user has already claimed a coupon
            $sql = "SELECT * FROM kupon WHERE nama='$nama' AND no_hp='$no_hp'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "<p>Anda sudah pernah mengambil kupon<br> atau data Nama dan No HP <u>tidak diisi</u></p>";
            } else {
                // Check if the phone number has already been registered
                $sql = "SELECT * FROM kupon WHERE no_hp='$no_hp'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    echo "<p>No. HP ini sudah terdaftar</p>";
                } else {
                    // Check if the coupon limit has been reached
                    $sql = "SELECT * FROM kupon";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) >= 350) {
                        echo "<p>Batas kupon sudah tercapai</p>";
                    } else {
                        // Generate a unique coupon code
                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $charactersLength = strlen($characters);
                        $kode_kupon = '';
                        for ($i = 0; $i < 15; $i++) {
                            $kode_kupon .= $characters[rand(0, $charactersLength - 1)];
                        }

                        // Generate QR code for the coupon code
                        if (isset($_POST['nama']) && isset($_POST['no_hp'])) {
                            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                            $charactersLength = strlen($characters);
                            $kode_kupon = '';
                            for ($i = 0; $i < 15; $i++) {
                                $kode_kupon .= $characters[rand(0, $charactersLength - 1)];
                            }
                        }
                    }
                }
            }
        }

        // Generate QR code for the coupon code
        if (isset($nama) && isset($no_hp) && isset($kode_kupon)) {
            require_once "phpqrcode/qrlib.php";
            $path = "qrcodes/";
            $filename = uniqid() . ".png";
            QRcode::png($kode_kupon, $path . $filename);
            $qrCodeImage = file_get_contents($path . $filename);
            unlink($path . $filename);

            $qrcode = mysqli_real_escape_string($conn, $qrCodeImage);
            $sql = "INSERT INTO kupon (nama, no_hp, kode_kupon, qrcode) VALUES ('$nama', '$no_hp', '$kode_kupon', '$qrcode')";
            if (mysqli_query($conn, $sql)) {
                // Redirect to coupon page
                $coupon_url = "coupon.php?kode_kupon=" . urlencode($kode_kupon);
                header("Location: " . $coupon_url);
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

        // Check if the user has already claimed a coupon
        if (isset($nama) && isset($no_hp) && isset($kode_kupon)) {
            $sql = "SELECT * FROM kupon WHERE nama='$nama' AND no_hp='$no_hp'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                // echo "<p>Anda sudah pernah mengambil kupon</p>";
            } else {
                // Check if the phone number has already been registered
                $sql = "SELECT * FROM kupon WHERE no_hp='$no_hp'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    echo "<p>No. HP ini sudah terdaftar</p>";
                } else {
                    // Check if the coupon limit has been reached
                    $sql = "SELECT * FROM kupon";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) >= 350) {
                        echo "<p>Batas kupon sudah tercapai</p>";
                    } else {
                        if (isset($qrCodeImage)) {
                            $qrcode = mysqli_real_escape_string($conn, $qrCodeImage);
                            $sql = "INSERT INTO kupon (nama, no_hp, kode_kupon, qrcode) VALUES ('$nama', '$no_hp', '$kode_kupon', '$qrcode')";
                            if (mysqli_query($conn, $sql)) {
                                echo "<p>Kupon berhasil diambil. Kode kupon Anda adalah $kode_kupon</p>";
                                echo "<img src='data:image/png;base64," . base64_encode($qrCodeImage) . "' alt='QR Code' style='display: block; margin: auto; width: 80%; max-width: 500px;'>";
                            } else {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                            }
                        }
                    }
                }
            }
        } else {
            // echo "<p>Silakan isi nama dan nomor HP Anda</p>";
        }
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
    ?>




    <!-- Coupon claim form -->
    <form action="" method="post">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" placeholder="Masukkan nama Lengkap Anda (Dengan Huruf Kapital Semuanya)
        <br><br>
        <label for="no_hp">No. HP:</label>
        <input type="text" id="no_hp" name="no_hp" placeholder="Masukkan no. HP Anda" pattern="[0-9]*">
        <br><br>
        <input type="submit" name="submit" value="Ambil Kupon"><br><br><br>
        <section class="kupon">
            <div class="container">
                <!-- <h3 style="color: #1883C4;">Kupon Yang Tersedia :</h3> -->
                <div class="kupon-container">
                    <?php include 'ambil_data_kupon.php'; ?>
                </div>
            </div>
        </section>
        <br>
        <h2 for="nama">Lupa Simpan Kode Kupon/QRCode Kupon maka:</h2>
        <h2><b>Segera Lapor Panitia!</b></h2>
    </form>
</body>


</html>