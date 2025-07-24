<?php
// public/view_designs.php

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

$md      = new MasterDesign($db, __DIR__ . '/imagesmasterdesign');
$designs = $md->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar Master Designs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex">
  <?php include __DIR__ . '/nav_admin.php'; ?>
  <div id="content" class="flex-grow-1 p-4">
    <h1 class="mb-4">Master Designs</h1>
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Gambar</th>
          <th>Publish</th>
          <th>Dikirim</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($designs as $d): ?>
        <tr>
          <td><?= $d['id'] ?></td>
          <td><?= htmlspecialchars($d['titledesign']) ?></td>
          <td>
            <a href="#" data-bs-toggle="modal" data-bs-target="#designModal" data-src="imagesmasterdesign/<?= htmlspecialchars($d['imagesdesign']) ?>">
              <img src="imagesmasterdesign/<?= htmlspecialchars($d['imagesdesign']) ?>" width="80" class="img-thumbnail" alt="">
            </a>
          </td>
          <td><?= $d['ispublish'] ? 'Ya' : 'Tidak' ?></td>
          <td><?= $d['submitdate'] ?></td>
          <td>
            <a href="delete_design.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin akan menghapus design ini?');">
              <i class="bi bi-trash"></i> Hapus
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- Modal for full image view -->
    <div class="modal fade" id="designModal" tabindex="-1" aria-labelledby="designModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="designModalLabel">Preview Gambar Design</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <img src="" id="modalDesignImage" class="img-fluid" alt="Full View">
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    var designModal = document.getElementById('designModal');
    designModal.addEventListener('show.bs.modal', function (event) {
      var trigger = event.relatedTarget;
      var src = trigger.getAttribute('data-src');
      var modalImg = designModal.querySelector('#modalDesignImage');
      modalImg.src = src;
    });
  </script>
</body>
</html>

