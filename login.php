<?php
session_start();
include 'koneksi.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bukberramadhan";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "<p style='color: green; position: absolute; top: 0; right: 0;'>Connected to Al-Hikmah-Data.system  &#10004;</p>";
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query untuk mencari user berdasarkan username dan password
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Jika user ditemukan, simpan data user pada session dan redirect ke halaman masukkankupon.php
        $_SESSION['username'] = $username;
        header('location: masukkankupon.php');
        exit();
    } else {
        // Jika user tidak ditemukan, tampilkan pesan error
        $error = "Username atau password salah!";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <h2>Login Admin</h2>
    <style>
        p {
            text-align: center;
            color: red;
        }
    </style>
    <p>Dilarang mengakses halaman ini selain admin!</p>

    <form method="post" action="">
        <?php if (isset($error)) { ?>
            <div><?php echo $error; ?></div>
        <?php } ?>
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit" name="login">Login</button>
        <br>

    </form>
</body>

</html>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        background-color: #f8f8f8;
    }

    .login {
        background-color: #fff;
        width: 400px;
        margin: 50px auto;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding: 100px;
    }

    label {
        font-size: 20px;
        color: #333;
    }

    input {
        padding: 10px;
        font-size: 18px;
        border: none;
        border-radius: 5px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
    }

    input:focus {
        outline: none;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5);
    }

    button {
        background-color: #4CAF50;
        color: #fff;
        padding: 10px;
        font-size: 18px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
    }

    button:hover {
        background-color: #3e8e41;
    }

    .fa-user {
        position: absolute;
        top: 33%;
        left: 5%;
        color: #999;
        font-size: 20px;
    }

    .fa-lock {
        position: absolute;
        top: 53%;
        left: 5%;
        color: #999;
        font-size: 20px;
    }
</style>