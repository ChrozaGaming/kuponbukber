<?php
include 'koneksi.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bukberramadhan";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    $result = mysqli_query($conn, $sql);
    session_start();
    if ($result) {
        $_SESSION['username'] = $username;
        header('location: masukkankupon.php');
        exit();
    } else {
        $error = "Terjadi kesalahan saat menyimpan data!";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <style>
        /* styling untuk form */
    </style>
</head>

<body>
    <h2>Register</h2>
    <form method="post" action="">
        <?php if (isset($error)) { ?>
            <div><?php echo $error; ?></div>
        <?php } ?>
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit" name="register">Register</button>
    </form>
</body>

</html>