// Ambil elemen button dan input pada file HTML
const scanBtn = document.getElementById('scanBtn');
const kodeKuponInput = document.getElementById('kode_kupon');

// Buat objek html5QrcodeScanner
const html5QrcodeScanner = new Html5QrcodeScanner(
  'reader', { fps: 10, qrbox: 250 });

// Tambahkan event listener pada button untuk memulai scanning QR code
scanBtn.addEventListener('click', () => {
  html5QrcodeScanner.render((qrCode) => {
    // Isi input dengan hasil scanning QR code
    kodeKuponInput.value = qrCode;
  });
});
