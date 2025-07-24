<?php
// public/add_photo_sample.php

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

$md = new MasterDesign($db, __DIR__ . '/imagesmasterdesign');
$pm = new PersonModel($db, __DIR__ . '/imagesperson');$ps = new PhotoSample($db);

$designs = $md->fetchAll();
$persons = $pm->fetchAll();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $designId = (int)$_POST['designid'];
    $personId = (int)$_POST['personid'];

    // Pemeriksaan keberadaan data dihilangkan
    // Kode sekarang akan langsung mencoba menyisipkan data baru
    $urlDesign = 'imagesmasterdesign/' . $db->fetch(
        'SELECT imagesdesign FROM masterdesign WHERE id = :d', [':d'=>$designId]
    )['imagesdesign'];
    $urlPerson = 'imagesperson/' . $db->fetch(
        'SELECT person_images FROM person WHERE id = :p', [':p'=>$personId]
    )['person_images'];
    $predictionId = "";
    $urlResult = '';

    if ($ps->insert($predictionId, $designId, $personId, $urlDesign, $urlPerson, $urlResult)) {
        header('Location: view_photo_sample.php'); exit;
    } else {
        $errors[] = 'Gagal menyimpan photo sample.';
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Tambah Photo Sample</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex">
  <?php include("nav_admin.php"); ?>
 
  <div id="content" class="flex-grow-1 p-4">
    <h1 class="mb-4">Tambah Photo Sample</h1>
    <?php if ($errors): ?><div class="alert alert-danger"><ul><?php foreach ($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach;?></ul></div><?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label for="designid" class="form-label">Master Design</label>
        <select id="designid" name="designid" class="form-select" required>
          <option value="">-- Pilih Design --</option>
          <?php foreach ($designs as $d): ?>
          <option value="<?=$d['id']?>"><?=htmlspecialchars($d['titledesign'])?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="personid" class="form-label">Person Endorser</label>
        <select id="personid" name="personid" class="form-select" required>
          <option value="">-- Pilih Person --</option>
          <?php foreach ($persons as $p): ?>
          <option value="<?=$p['id']?>"><?=htmlspecialchars($p['titleperson'])?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>