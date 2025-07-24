<?php
// public/view_photo_sample.php
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

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int) $_POST['delete_id'];
    $ps = new PhotoSample($db);
    if ($ps->delete($deleteId)) {
        $_SESSION['flash_success'] = "Record ID {$deleteId} berhasil dihapus.";
    } else {
        $_SESSION['flash_error'] = "Gagal menghapus record ID {$deleteId}.";
    }
    header('Location: ?page=' . (int)($_GET['page'] ?? 1));
    exit;
}

// Pagination setup
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

$ps      = new PhotoSample($db);
$total    = $db->fetch('SELECT COUNT(*) AS cnt FROM photosample', [])['cnt'];
$pages   = ceil($total / $perPage);
$samples  = $db->fetchAll(
    'SELECT * FROM photosample ORDER BY generateddate DESC LIMIT :limit OFFSET :offset',
    [':limit'=>$perPage, ':offset'=>$offset]
);

$settings = new Settings($db);
$host     = rtrim($settings->get('HOST_DOMAIN'), '/');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>View Photo Samples</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex">
  <?php include __DIR__ . '/nav_admin.php'; ?>
  <div id="content" class="flex-grow-1 p-4">
    <h1 class="mb-4">Photo Samples</h1>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th><th>PredictionID</th><th>Design Img</th><th>Person Img</th><th>Result Img</th><th>Generated</th><th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($samples as $s): ?>
        <tr>
          <td><?= $s['id'] ?></td>
          <td><?= htmlspecialchars($s['predictionid']) ?></td>
          <?php foreach (['urlimagesdesign','urlimagesperson','imagesresult'] as $col): ?>
          <td>
            <?php if ($s[$col]):
              $url = strpos($s[$col], 'http')===0 ? $s[$col] : "{$host}/{$s[$col]}";
            ?>
              <a href="#" data-bs-toggle="modal" data-bs-target="#photoModal" data-src="<?= htmlspecialchars($url) ?>">
                <img src="<?= htmlspecialchars($url) ?>" width="80" class="img-thumbnail">
              </a>
            <?php else: ?>-
            <?php endif; ?>
          </td>
          <?php endforeach; ?>
          <td><?= $s['generateddate'] ?></td>
          <td>
            <?php if ($s['predictionid'] && $s['imagesresult']): ?>
              <button class="btn btn-sm btn-secondary" disabled>
                <i class="bi bi-check2-circle"></i> Done
              </button>
            <?php else: ?>
              <form method="post" action="generate_photo.php" style="display:inline">
                <input type="hidden" name="id" value="<?= $s['id'] ?>">
                
<button
  class="btn btn-sm btn-success"
  onclick="this.disabled=true; this.innerHTML='<i class=\'bi bi-hourglass-split\'></i> Generating…'; this.form.submit();"
>
  <i class="bi bi-lightning-charge-fill"></i> Generate
</button>


              </form>



            <?php endif; ?>

 <form method="post" action="" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus record ID <?= $s['id'] ?>?');">
              <input type="hidden" name="delete_id" value="<?= $s['id'] ?>">
              <button type="submit" class="btn btn-sm btn-danger">
                <i class="bi bi-trash"></i> Delete
              </button>
            </form>
            
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- Pagination -->
    <nav>
      <ul class="pagination">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
          <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
        </li>
        <?php endfor; ?>
      </ul>
    </nav>

    <!-- Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Preview</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center">
            <img id="modalPhotoImage" class="img-fluid" src="" alt="Full View">
          </div>
        </div>
      </div>
    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  document.querySelectorAll('form[action="generate_photo.php"]').forEach(form => {
    form.addEventListener('submit', function(e) {
      // Cari tombol submit dalam form yang sedang discroll
      const btn = form.querySelector('button[type="submit"], button.btn-success');
      if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Generating…';
      }
    });
  });
</script>


  <script>
    var photoModal = document.getElementById('photoModal');
    photoModal.addEventListener('show.bs.modal', function (e) {
      var src = e.relatedTarget.getAttribute('data-src');
      photoModal.querySelector('#modalPhotoImage').src = src;
    });
  </script>
</body>
</html>
