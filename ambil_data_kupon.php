<?php
include 'koneksi.php';

// Query untuk menghitung jumlah kupon kupon belum di tukarkan
$sql = "SELECT COUNT(*) AS total_kupon FROM kupon WHERE status = 'kupon belum di tukarkan'";
$result = mysqli_query($koneksi, $sql);
$total_kupon = mysqli_fetch_assoc($result)['total_kupon'];
$sisa_kupon = 350 - $total_kupon;

if ($sisa_kupon > 0) {
?>
    <p style="text-align:center; color:green; margin: auto; width: 50%;">
        Sisa kuota kupon yang belum diambil: <br> <?php echo $sisa_kupon; ?>&nbsp;<b>Kupon</b>
    </p>
<?php
} else {
?>
    <p style="text-align:center; color:red; font-weight:bold; margin: auto; width: 50%;">Maaf, kupon telah habis saat ini</p>
<?php
}
