<?php
// public/upload_person.php
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

$pm      = new PersonModel($db, __DIR__ . '/imagesperson');
$errors  = [];
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['titleperson'] ?? '');
    if ($title === '') {
        $errors[] = 'Title person wajib diisi.';
    }
    if (empty($_FILES['person_images']['name'])) {
        $errors[] = 'File image wajib diupload.';
    }

    if (empty($errors)) {
        $ext = strtolower(pathinfo($_FILES['person_images']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg','jpeg','png'])) {
            $errors[] = 'Format file hanya JPG, JPEG, atau PNG.';
        } else {
            // determine next ID
            $row = $db->fetch('SELECT COALESCE(MAX(id),0)+1 AS nextid FROM person');
            $id  = $row['nextid'];
            $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
            $newName = $id . '_' . $rand . '.' . $ext;
            $dest    = __DIR__ . '/imagesperson/' . $newName;
            if (move_uploaded_file($_FILES['person_images']['tmp_name'], $dest)) {
                if ($pm->insert($title, $newName)) {
                    $success = 'Person image berhasil diupload.';
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Upload Person Endorser</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex">
  <?php include("nav_admin.php"); ?>
  <div id="content" class="flex-grow-1 p-4">
    <h1 class="mb-4">Upload Person Endorser</h1>

    <?php if ($errors): ?>
      <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="titleperson" class="form-label">Title Person</label>
        <input type="text" id="titleperson" name="titleperson" class="form-control" required value="<?= htmlspecialchars($_POST['titleperson'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label for="person_images" class="form-label">Upload Image</label>
        <input type="file" id="person_images" name="person_images" class="form-control" accept=".jpg,.jpeg,.png" required>
      </div>
      <button type="submit" class="btn btn-primary">Upload</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>