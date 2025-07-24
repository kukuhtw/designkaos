<?php
/**
 * config.php
 * Database configuration settings
 * 
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
 

return [
    'db' => [
        'host'       => 'localhost',
        'dbname'     => 'designkaos',
        'user'       => 'root',
        'password'   => '',
        'charset'    => 'utf8mb4',
    ],
    'logger' => [
        'path' => __DIR__ . '/logs/app.log',
        'level' => 'DEBUG',
    ],    
    'features' => [
        'admin_password' => false,  // <— set to true for very first time to set access admin login. set to false if login admin has been set, 
    ],
];

?>


