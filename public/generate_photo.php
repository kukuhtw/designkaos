<?php
// public/generate_photo.php
require __DIR__ . '/../bootstrap.php';
session_start();
if (empty($_SESSION['admin'])) { header('Location: login.php'); exit; }

$settings = new Settings($db);
$token    = $settings->get('REPLICATE_API_TOKEN');
$ps       = new PhotoSample($db);
$rs       = new ReplicateService($token);

// params from request
$id = (int)($_POST['id'] ?? 0);
if (!$id) {
    die('Invalid sample ID');
}

// fetch sample row
$sample = $db->fetch('SELECT * FROM photosample WHERE id = :id', [':id'=>$id]);
if (!$sample) {
    die('Sample not found');
}

// Prepend host domain:
$host = rtrim($settings->get('HOST_DOMAIN'), '/');
$sample['urlimagesdesign'] = $host . '/' . ltrim($sample['urlimagesdesign'], '/');
$sample['urlimagesperson'] = $host . '/' . ltrim($sample['urlimagesperson'], '/');

Logger::info("GeneratePhoto: Using design URL: {$sample['urlimagesdesign']}");
Logger::info("GeneratePhoto: Using person URL: {$sample['urlimagesperson']}");

try {
    
    // public/generate_photo.php
    
    $prompt="Put the person into a plain t-shirt with the medium design on it. Size of design is medium.";

    // Generate and wait
    Logger::debug('GeneratePhoto: calling generateAndWait');
    $prediction = $rs->generateAndWait(
        $sample['urlimagesdesign'], 
        $sample['urlimagesperson'], $prompt
    );
    $predId = $prediction['id'];
    Logger::info('GeneratePhoto: prediction ID ' . $predId);
    Logger::info('prediction generateAndWait: ' . json_encode($prediction));

    // Update prediction ID
    if (!$ps->updatePredictionId($id, $predId)) {
        Logger::warning("GeneratePhoto: prediction ID not updated for sample {$id}");
    }

    // Get output URL
    //= $prediction['output'];
    $outputUrl = $prediction['output']?? null;

    Logger::info('outputUrl: ' . $outputUrl);

    if (!$outputUrl) {
        throw new RuntimeException('No output URL in response');
    }
    Logger::info('GeneratePhoto: output URL ' . $outputUrl);

    // Download image
    $dir = __DIR__ . '/imagesresult';
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $ext = pathinfo(parse_url($outputUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'png';
    $fname = $id . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $local = "{$dir}/{$fname}";
    $data = file_get_contents($outputUrl);
    if ($data === false) {
        throw new RuntimeException('Failed to download image');
    }
    file_put_contents($local, $data);

    // Save result path
    $relative = 'imagesresult/' . $fname;
    if (!$ps->updateResult($id, $relative)) {
        throw new RuntimeException('Failed saving result to database');
    }
    Logger::info("GeneratePhoto: result saved as {$relative}");

    header('Location: view_photo_sample.php');
    exit;
} catch (Exception $e) {
    Logger::error('GeneratePhoto error: ' . $e->getMessage());
    die('Error: ' . $e->getMessage());
}
?>
