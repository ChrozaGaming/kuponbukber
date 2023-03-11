<?php

$host = "localhost"; // hostname
$user = "root"; // database username
$password = ""; // database password
$database = "bukberramadhan"; // database name

$koneksi = mysqli_connect($host, $user, $password, $database);

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
