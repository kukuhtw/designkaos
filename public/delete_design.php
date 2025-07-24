<?php
// public/delete_design.php

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
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
    if ($md->delete($id)) {
        Logger::info("MasterDesign ID {$id} dihapus oleh {$_SESSION['admin']}");
    } else {
        Logger::error("Gagal menghapus MasterDesign ID {$id}");
    }
}

header('Location: view_designs.php');
exit;
