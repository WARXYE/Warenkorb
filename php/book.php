<?php
class Book
{
    public static function getAll()
    {
        include "dbConnection.php";
        $sql = "SELECT * FROM bookdata";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public static function get($id)
    {
        include "dbConnection.php";
        $sql = "SELECT title FROM bookdata WHERE id = $id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getBookDetails($book_id)
    {
        include "dbConnection.php";
        $sql = "SELECT * FROM bookdata WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $book_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
}