<?php
// src/MasterDesign.php
/**
 * MasterDesign.php
 * CRUD for master design uploads
 */

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


class MasterDesign
{
    private Database $db;
    private string $uploadDir;

    public function __construct(Database $db, string $uploadDir)
    {
        $this->db = $db;
        $this->uploadDir = rtrim($uploadDir, '/') . '/';
    }

    /**
     * Insert new design record
     */
    public function insert(string $title, string $filename): bool
    {
        $sql = "INSERT INTO masterdesign (titledesign, imagesdesign, ispublish, submitdate)
                VALUES (:title, :img, 1, NOW())";
        return $this->db->execute($sql, [
            ':title' => $title,
            ':img'   => $filename,
        ]) > 0;
    }


     /**
     * Fetch all designs
     */
    public function fetchAll(): array
    {
        return $this->db->fetchAll('SELECT * FROM masterdesign ORDER BY submitdate DESC');
    }

    /**
     * Delete design by ID (and file)
     */
    public function delete(int $id): bool
    {
        $row = $this->db->fetch('SELECT imagesdesign FROM masterdesign WHERE id = :id', [':id'=>$id]);
        if (!$row) return false;
        $file = $this->uploadDir . $row['imagesdesign'];
        if (file_exists($file)) {
            @unlink($file);
        }
        return $this->db->execute('DELETE FROM masterdesign WHERE id = :id', [':id'=>$id]) > 0;
    }
    
}

?>
