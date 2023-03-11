const express = require('express');
const app = express();
const path = require('path');
const Html5Qrcode = require('html5-qrcode');

// Set static folder
app.use(express.static(path.join(__dirname, 'public')));

// Route to handle QR code scanning
app.get('/scan', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'scan.html'));
});

// Start server
const PORT = process.env.PORT || 5000;
app.listen(PORT, () => console.log(`Server started on port ${PORT}`));

// HTML5 QR code scanning script
const qrCodeScanner = new Html5Qrcode('reader');
const output = document.getElementById('output');
const btnScanQR = document.getElementById('btnScanQR');

// Function to handle QR code scanning
const scanQRCode = () => {
  qrCodeScanner.start((code) => {
    output.value = code;
    qrCodeScanner.stop();
  }, (errorMessage) => {
    console.log(errorMessage);
  }, { fps: 10, qrbox: 250 });
};

// Event listener for QR code scanning button
btnScanQR.addEventListener('click', () => {
  scanQRCode();
});
