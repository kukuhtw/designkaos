<?php
// public/delete_person.php
require __DIR__ . '/../bootstrap.php';
session_start();

// Redirect to login if not authenticated
if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Initialize PersonModel
$pm = new PersonModel($db, __DIR__ . '/imagesperson');

// Get ID from query string
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Attempt delete
    if ($pm->delete($id)) {
        Logger::info("PersonModel: Deleted person ID {$id} by {$_SESSION['admin']}");
    } else {
        Logger::error("PersonModel: Failed to delete person ID {$id}");
    }
}

// Redirect back to list
header('Location: view_person.php');
exit;
