<?php

class Book {
    private static $books;

    private static function loadBooks() {
        $jsonFile = 'bookdata.json';

        if (file_exists($jsonFile)) {
            $jsonContent = file_get_contents($jsonFile);
            self::$books = json_decode($jsonContent, true);
        } else {
            self::$books = [];
        }
    }

    public static function getAll() {
        if (!isset(self::$books)) {
            self::loadBooks();
        }

        return self::$books;
    }

    public static function get($id) {
        if (!isset(self::$books)) {
            self::loadBooks();
        }

        return isset(self::$books[$id]) ? self::$books[$id] : null;
    }
}
