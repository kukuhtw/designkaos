<?php
/**
 * bootstrap.php
 * Application bootstrap: load config, init logger & database
 
// include core classes

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

// **1.** Load core class files
require __DIR__ . '/src/Logger.php';
require __DIR__ . '/src/Database.php';
require __DIR__ . '/src/AdminAuth.php';
require __DIR__ . '/src/MasterDesign.php';
require __DIR__ . '/src/PersonModel.php';
require __DIR__ . '/src/PhotoSample.php';
require __DIR__ . '/src/ReplicateService.php';
require __DIR__ . '/src/Settings.php';

// **2.** Load config
$config = require __DIR__ . '/config.php';

// **3.** Inisialisasi logger
Logger::init($config['logger']);
Logger::info('Logger initialized.');


// initialize database
try {
    $db = new Database($config['db']);
    Logger::info('Database connection established.');
} catch (Exception $e) {
    die('Fatal error: ' . $e->getMessage());
}

// AdminAuth init
$adminAuth = new AdminAuth($db, $config['features']['admin_password']);
$settings  = new Settings($db);

?>
