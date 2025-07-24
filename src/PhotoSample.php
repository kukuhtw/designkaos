<?php
// src/PhotoSample.php
/**
 * PhotoSample.php
 * CRUD operations for photo sample combinations
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



class PhotoSample
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function exists(int $designId, int $personId): bool
    {
        $row = $this->db->fetch(
            'SELECT id FROM photosample WHERE designid = :d AND personid = :p',
            [':d' => $designId, ':p' => $personId]
        );
        return (bool)$row;
    }

    /**
     * Update the prediction ID for an existing sample
     *
     * @param int    $id              PhotoSample record ID
     * @param string $newPredictionId New prediction ID to store
     * @return bool                   True jika update berhasil
     */
    public function updatePredictionId(int $id, string $newPredictionId): bool
    {
        $sql = 'UPDATE photosample SET predictionid = :pred WHERE id = :id';
        return $this->db->execute($sql, [
            ':pred' => $newPredictionId,
            ':id'   => $id,
        ]) > 0;
    }

    public function insert(string $predictionId, int $designId, int $personId, string $urlDesign, string $urlPerson, string $urlResult = '', bool $publish = true): bool
    {
        $sql = "INSERT INTO photosample
            (predictionid, designid, personid, urlimagesdesign, urlimagesperson, imagesresult, ispublish, generateddate)
            VALUES
            (:pred, :d, :p, :u1, :u2, :res, :isp, NOW())";
        return $this->db->execute($sql, [
            ':pred' => $predictionId,
            ':d'    => $designId,
            ':p'    => $personId,
            ':u1'   => $urlDesign,
            ':u2'   => $urlPerson,
            ':res'  => $urlResult,
            ':isp'  => $publish ? 1 : 0,
        ]) > 0;
    }

    
     public function updateResult(int $id, string $imageUrl): bool
    {
        $sql = 'UPDATE photosample SET imagesresult = :img, ispublish = 1 WHERE id = :id';
        return $this->db->execute($sql, [
            ':img' => $imageUrl,
            ':id'  => $id,
        ]) > 0;
    }


    public function fetchAll(): array
    {
        return $this->db->fetchAll('SELECT * FROM photosample ORDER BY generateddate DESC');
    }

    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM photosample WHERE id = :id';
        return $this->db->execute($sql, [':id' => $id]) > 0;
    }

}
?>
