<?php
// public/settings.php

/*
 * 
 * 🛠️ Aplikasi Desain Kaos AI
 * Dibuat oleh: Kukuh TW
 *
 * 📧 Email     : kukuhtw@gmail.com
 * 📱 WhatsApp  : 628129893706
 * 📷 Instagram : @kukuhtw
 * 🐦 X / Twitter: @kukuhtw
 * 👍 Facebook  : https://www.facebook.com/kukuhtw
 * 💼 LinkedIn  : https://id.linkedin.com/in/kukuhtw

*/
require __DIR__ . '/../bootstrap.php';
session_start();
if (empty($_SESSION['admin'])) { header('Location: login.php'); exit; }

$errors  = [];
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = trim($_POST['replicate_token'] ?? '');
    $host   = trim($_POST['host_domain'] ?? '');
    if ($token === '') {
        $errors[] = 'Token tidak boleh kosong.';
    }
    if ($host === '') {
        $errors[] = 'Host domain tidak boleh kosong.';
    }
    if (empty($errors)) {
        try {
            $u1 = $settings->set('REPLICATE_API_TOKEN', $token);
            $u2 = $settings->set('HOST_DOMAIN', $host);
            if ($u1 || $u2) {
                $success = 'Settings berhasil disimpan.';
                Logger::info('Settings updated: REPLICATE_API_TOKEN or HOST_DOMAIN.');
            } else {
                $errors[] = 'Tidak ada perubahan yang disimpan ke database.';
                Logger::error('Settings: No rows affected when updating settings.');
            }
        } catch (PDOException $e) {
            $errors[] = 'Gagal menyimpan settings: ' . $e->getMessage();
            Logger::error('Settings: DB error while updating settings: ' . $e->getMessage());
        }
    }
}
$current = $settings->get('REPLICATE_API_TOKEN');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Settings</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>body{min-height:100vh;display:flex;}#sidebar{width:250px;}#content{flex:1;padding:2rem;}</style>
</head>
<body>
  <?php include(__DIR__ . '/nav_admin.php'); ?>
  <div id="content">
    <div class="container-fluid">
      <h1 class="mb-4">Settings</h1>
      <?php if ($errors): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach ($errors as $e): ?>
              <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>
      <form method="post">
        <div class="mb-3 password-toggle">
          <label for="replicate_token" class="form-label">Replicate API Token</label>
          <div class="input-group">
            <input type="password" id="replicate_token" name="replicate_token" class="form-control" value="<?= htmlspecialchars($current) ?>" required>
            <span class="input-group-text toggle-icon" id="toggleToken"><i class="bi bi-eye"></i></span>
          </div>
        </div>
        <div class="mb-3">
          <label for="host_domain" class="form-label">Host Domain</label>
          <input type="text" id="host_domain" name="host_domain" class="form-control" value="<?= htmlspecialchars($settings->get('HOST_DOMAIN')) ?>" required>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   <script>
    document.getElementById('toggleToken').addEventListener('click', function() {
      var input = document.getElementById('replicate_token');
      var icon = this.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      }
    });
  </script>
</body>
</html>

