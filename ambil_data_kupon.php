<?php
include 'koneksi.php';

// Query untuk menghitung jumlah kupon tersedia
$sql = "SELECT COUNT(*) AS total_kupon FROM kupon WHERE status = 'tersedia'";
$result = mysqli_query($koneksi, $sql);
$total_kupon = mysqli_fetch_assoc($result)['total_kupon'];
$sisa_kupon = 350 - $total_kupon;

if ($sisa_kupon > 0) {
?>
    <p style="text-align:center; color:green; margin: auto; width: 50%;">
        Sisa kupon yang tersedia: <?php echo $sisa_kupon; ?> <b>Kupon</b>
    </p>
<?php
} else {
?>
    <p style="text-align:center; color:red; font-weight:bold; margin: auto; width: 50%;">Maaf, kupon telah habis saat ini</p>
<?php
}
