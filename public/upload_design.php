<?php
// public/upload_design.php
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
if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$md = new MasterDesign($db, __DIR__ . '/imagesmasterdesign');
$errors = [];
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['titledesign'] ?? '');
    if ($title === '') {
        $errors[] = 'Title design wajib diisi.';
    }

    if (empty($_FILES['imagesdesign']['name'])) {
    $errors[] = 'File image wajib diupload.';
} elseif ($_FILES['imagesdesign']['error'] !== UPLOAD_ERR_OK) {
    $errorCode = $_FILES['imagesdesign']['error'];
    $errorMessages = [
        UPLOAD_ERR_INI_SIZE   => 'Ukuran file melebihi batas maksimum yang diizinkan oleh konfigurasi server (php.ini).',
        UPLOAD_ERR_FORM_SIZE  => 'Ukuran file melebihi batas maksimum yang diizinkan oleh form HTML.',
        UPLOAD_ERR_PARTIAL    => 'File hanya terupload sebagian.',
        UPLOAD_ERR_NO_FILE    => 'Tidak ada file yang diupload.',
        UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak tersedia di server.',
        UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk.',
        UPLOAD_ERR_EXTENSION  => 'Upload file dihentikan oleh ekstensi PHP.',
    ];
    $errors[] = $errorMessages[$errorCode] ?? 'Terjadi kesalahan tidak diketahui saat mengupload file.';
}

    if (empty($errors)) {
        $ext = strtolower(pathinfo($_FILES['imagesdesign']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg','jpeg','png','webp'])) {
            $errors[] = 'Format file hanya JPG, JPEG, WEBP atau PNG.';
        } else {
            // generate new id by insert dummy then get lastInsertId?
            // or fetch max id
            $row = $db->fetch('SELECT COALESCE(MAX(id),0)+1 AS nextid FROM masterdesign');
            $id = $row['nextid'];
            $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,8);
            $newName = $id . '_' . $rand . '.' . $ext;
            $dest = __DIR__ . '/imagesmasterdesign/' . $newName;
            if (move_uploaded_file($_FILES['imagesdesign']['tmp_name'], $dest)) {
                if ($md->insert($title, $newName)) {
                    $success = 'Design berhasil diupload.';
                } else {
                    $errors[] = 'Gagal menyimpan data ke database.';
                    unlink($dest);
                }
            } else {
                $errors[] = 'Gagal memindahkan file upload.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Upload Master Design</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex">
  <?php include("nav_admin.php"); ?>
  <div id="content" class="flex-grow-1 p-4">
    <h1 class="mb-4">Upload Master Design</h1>
    <?php if ($errors): ?>
      <div class="alert alert-danger"><ul class="mb-0"><?php foreach($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?=htmlspecialchars($success)?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="titledesign" class="form-label">Title Design</label>
        <input type="text" id="titledesign" name="titledesign" class="form-control" required value="<?=htmlspecialchars($_POST['titledesign']??'')?>">
      </div>
      <div class="mb-3">
        <label for="imagesdesign" class="form-label">Upload Image</label>
        <input type="file" id="imagesdesign" name="imagesdesign" class="form-control" accept=".jpg,.jpeg,.png" required>
      </div>
      <button type="submit" class="btn btn-primary">Upload</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
