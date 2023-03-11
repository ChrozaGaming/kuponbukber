<style>
  /* Style untuk form */
  /* Style untuk body */
  body {
    background-color: #F7F7F7;
    font-family: Arial, sans-serif;
  }

  /* Style untuk header */
  header {
    background-color: #5D5FEF;
    color: #fff;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  header h1 {
    margin: 0;
    font-size: 28px;
  }

  nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
  }

  nav li {
    margin-left: 20px;
  }

  nav a {
    color: #fff;
    text-decoration: none;
    font-size: 18px;
  }

  /* Style untuk banner */
  .banner {
    background-color: #FCD34D;
    color: #333;
    padding: 40px 20px;
    text-align: center;
  }

  .banner h2 {
    margin: 0;
    font-size: 48px;
    font-weight: bold;
    line-height: 1.2;
    margin-bottom: 20px;
  }

  .banner p {
    margin: 20px 0;
    font-size: 24px;
    line-height: 1.5;
  }

  .button {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #5D5FEF;
    color: #fff;
    border: 2px solid #5D5FEF;
    border-radius: 3px;
    text-decoration: none;
    font-weight: bold;
    font-size: 18px;
    transition: all 0.3s ease-in-out;
  }

  .button:hover {
    background-color: transparent;
    color: #5D5FEF;
    text-decoration: none;
  }

  /* Style untuk kupon */
  .kupon {
    padding: 40px 20px;
    background-color: #fff;
    text-align: center;
  }


  .kupon h3 {
    margin: 0 0 20px 0;
    font-size: 28px;
    color: #5D5FEF;
  }

  .kupon-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
  }

  .kupon-item {
    width: calc(100% / 3 - 20px);
    margin: 10px;
    padding: 20px;
    background-color: #5D5FEF;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
    color: #fff;
  }

  .kupon-item h4 {
    margin: 0 0 10px 0;
    font-size: 24px;
    font-weight: bold;
  }

  .kupon-item p {
    font-size: 18px;
    margin-bottom: 20px;
  }

  /* Style untuk footer */
  footer {
    background-color: #333;
    color: #fff;
    padding: 20px;
    text-align: center;
    margin-top: 40px;
  }

  footer p {
    margin: 0;
    font-size: 18px;
  }
</style>
<!DOCTYPE html>
<html>

<head>
  <title>Ambil Kupon Buka Puasa Bersama</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <header>
    <div class="container">
      <h1>Ambil Kupon Buka Puasa Bersama</h1>
      <nav>
        <ul>
          <li><a href="#">Beranda</a></li>
          <li><a href="#">Kupon</a></li>
          <li><a href="#">Tentang Kami</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <section class="banner">
    <div class="container">
      <h2>Ambil Kupon Buka Puasa Bersama Sekarang</h2>
      <p>Kami menyediakan kupon makanan gratis untuk acara buka puasa bersama. Ambil sekarang sebelum kehabisan!</p>
      <a href="ambil_kupon.php" class="button">Ambil Kupon</a>
    </div>
  </section>

  <section class="kupon">
    <div class="container">
      <h3 style="color: #1883C4;">Kupon Yang Tersedia :</h3>
      <div class="kupon-container">
        <?php include 'ambil_data_kupon.php'; ?>
      </div>
    </div>
  </section>

  <footer>
    <div class="container">
      <p>&copy; 2023 Ambil Kupon Buka Puasa Bersama</p>
    </div>
  </footer>

  <script src="script.js"></script>
</body>

</html>