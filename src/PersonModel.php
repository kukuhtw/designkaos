<?php
// src/PersonModel.php
/**
 * PersonModel.php
 * CRUD operations for person endorser images
 */
class PersonModel
{
    private Database $db;
    private string $uploadDir;

    public function __construct(Database $db, string $uploadDir)
    {
        $this->db = $db;
        $this->uploadDir = rtrim($uploadDir, '/') . '/';
    }

    /**
     * Insert new person record
     */
    public function insert(string $title, string $filename): bool
    {
        $sql = "INSERT INTO person (titleperson, person_images, submitdate)
                VALUES (:title, :img, NOW())";
        return $this->db->execute($sql, [':title'=>$title, ':img'=>$filename]) > 0;
    }

    /**
     * Fetch all persons
     */
    public function fetchAll(): array
    {
        return $this->db->fetchAll('SELECT * FROM person ORDER BY submitdate DESC');
    }

    /**
     * Delete person by ID (and remove file)
     */
    public function delete(int $id): bool
    {
        $row = $this->db->fetch('SELECT person_images FROM person WHERE id = :id', [':id'=>$id]);
        if (!$row) return false;
        $file = $this->uploadDir . $row['person_images'];
        if (file_exists($file)) {
            @unlink($file);
        }
        return $this->db->execute('DELETE FROM person WHERE id = :id', [':id'=>$id]) > 0;
    }
}
?>