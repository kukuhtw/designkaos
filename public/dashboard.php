<?php
// public/dashboard.php
/*
 * 🛠️ Aplikasi Desain Kaos AI
 * Dibuat oleh: Kukuh TW
 *
 * 📧 Email     : kukuhtw@gmail.com
 * 📱 WhatsApp  : 628129893706
 * 📷 Instagram : @kukuhtw
 * 🐦 Twitter   : @kukuhtw
 * 👍 Facebook  : https://www.facebook.com/kukuhtw
 * 💼 LinkedIn  : https://id.linkedin.com/in/kukuhtw
 */
require __DIR__ . '/../bootstrap.php';
session_start();
if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body { min-height: 100vh; display: flex; }
    #sidebar { width: 250px; }
    #content { flex: 1; padding: 2rem; }
  </style>
</head>
<body>

  <?php include("nav_admin.php"); ?>

  <div id="content">
    <div class="container-fluid">
      <h1 class="mb-4">📊 Dashboard Admin</h1>

      <div class="card mb-4">
        <div class="card-body">
          <p><strong>Login Sejak / Logged in since:</strong> <?= htmlspecialchars($_SESSION['login_time'] ?? '') ?></p>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-body">
          <h3>🎨 AI T-Shirt Design App — Turn Your Creativity into Profit! </h3>
          <p><strong>ID:</strong> Bayangkan jika setiap ide desain kaos di kepala Anda bisa langsung divisualisasikan dengan cepat dan profesional.<br>
             <strong>EN:</strong> Imagine if every t-shirt design idea in your head could be visualized quickly and professionally.</p>

          <p><strong>ID:</strong> Itulah yang ditawarkan oleh <b>Aplikasi Desain Kaos AI</b> ini.<br>
             <strong>EN:</strong> That’s exactly what this <b>AI T-shirt Design App</b> offers.</p>

          <p><strong>ID:</strong> Dengan bantuan teknologi AI, Anda bisa menciptakan mockup realistis seseorang mengenakan kaos hasil desain Anda sendiri.<br>
             <strong>EN:</strong> With the help of AI technology, you can create realistic mockups of someone wearing your custom-designed t-shirt.</p>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-body">
          <h4>🔥Perfect for a Side Hustle!</h4>
          <ul>
            <li><strong>ID:</strong> Desain kaos Anda sendiri. <br><strong>EN:</strong> Design your own t-shirts.</li>
            <li><strong>ID:</strong> Cari vendor sablon DTG di sekitar Anda. <br><strong>EN:</strong> Find a DTG printing vendor near you.</li>
            <li><strong>ID:</strong> Tentukan margin keuntungan Anda sendiri. <br><strong>EN:</strong> Set your own profit margin.</li>
            <li><strong>ID:</strong> Upload desain dan foto endorser. <br><strong>EN:</strong> Upload your design and an endorser’s photo.</li>
          </ul>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-body">
          <h4>🧠 Powered by AI, Create Stunning Mockup Photos Effortlessly!</h4>
          <p><strong>ID:</strong> Aplikasi ini menggunakan AI dari replicate.com untuk menggabungkan desain Anda dengan foto orang memakai kaos polos.<br>
             <strong>EN:</strong> This app uses AI from replicate.com to merge your design with a photo of a person wearing a blank t-shirt.</p>

          <p><strong>ID:</strong> Pastikan file desain Anda beresolusi tinggi. <br>
             <strong>EN:</strong> Make sure your design files are in high resolution.</p>
        </div>
      </div>

      <div class="card mb-4">
  <div class="card-body">
    <h4>🚀 Installation Guide</h4>
    <ol class="mb-0">
      <li>
        <strong>Upload the Application</strong><br>
        Linux: <code>/var/www/html/yourfolder</code><br>
        Windows: <code>C:/xampp/htdocs/yourfolder</code>
      </li>
      <li class="mt-2">
        <strong>Create the Database</strong><br>
        Create a MySQL database and import <code>sql/designkaos.sql</code> via phpMyAdmin.
      </li>
      <li class="mt-2">
        <strong>Edit Database Configuration</strong><br>
        Open <code>config.php</code> and update with your database credentials.
      </li>
      <li class="mt-2">
        <strong>Edit .htaccess</strong><br>
        Open <code>.htaccess</code> and set your folder:<br>
        <code>RewriteBase /yourfolder/</code><br>
        Replace <code>yourfolder</code> with your actual app folder name.
      </li>
      <li class="mt-2">
        <strong>Create Admin Account</strong><br>
        Run <code>/public/create_admin.php</code> from browser and set login credentials.
      </li>
      <li class="mt-2">
        <strong>Login to Admin Dashboard</strong><br>
        Go to <code>/public/login.php</code> and log in with the admin account.
      </li>
      <li class="mt-2">
        <strong>Set API Key & Host</strong><br>
        In the Settings menu, enter your Replicate API Token and application base URL.
      </li>
      <li class="mt-2">
        <strong>Delete Logs (Optional)</strong><br>
        Use the “Delete Logs” menu in the dashboard to clear old logs.
      </li>
    </ol>
  </div>
</div>


      <div class="card mb-4">
        <div class="card-body">
          <h4>💬 Ready to Become a T-Shirt Designer?</h4>
          <p><strong>ID:</strong> Segera mulai bisnis desain kaos Anda hari ini dan nikmati penghasilannya!<br>
             <strong>EN:</strong> Start your t-shirt design business today and enjoy the profits!</p>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <h5>📞 Kontak / Contact</h5>
          <ul class="list-unstyled">
            <li><strong>Nama / Name:</strong> Kukuh TW</li>
            <li><strong>Email:</strong> <a href="mailto:kukuhtw@gmail.com">kukuhtw@gmail.com</a></li>
            <li><strong>WhatsApp:</strong> <a href="https://wa.me/628129893706" target="_blank">Klik di sini / Click here</a></li>
            <li><strong>Instagram:</strong> <a href="https://instagram.com/kukuhtw" target="_blank">📷 @kukuhtw</a></li>
            <li><strong>Twitter / X:</strong> <a href="https://x.com/kukuhtw" target="_blank">🐦 @kukuhtw</a></li>
            <li><strong>Facebook:</strong> <a href="https://facebook.com/kukuhtw" target="_blank">👍 facebook.com/kukuhtw</a></li>
            <li><strong>LinkedIn:</strong> <a href="https://linkedin.com/in/kukuhtw" target="_blank">💼 linkedin.com/in/kukuhtw</a></li>
          </ul>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
