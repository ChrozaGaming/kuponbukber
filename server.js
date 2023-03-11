const express = require('express');
const path = require('path');
    
const app = express();

// Menetapkan folder public sebagai static folder
app.use(express.static(path.join(__dirname, 'public')));

// Menjalankan server pada port 3000
const PORT = 3000;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
