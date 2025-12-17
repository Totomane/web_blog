<?php

class Image
{
    private static function getConnection()
    {
        require_once __DIR__ . '/../config/database.php';
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $pdo = new PDO($dsn, DB_USER, DB_PWD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
            return $pdo;
        } catch (PDOException $e) {
            return null;
        }
    }

    public static function create(string $path, string $alt = '')
    {
        $pdo = self::getConnection();
        if ($pdo === null)
            return false;
        try {
            $sql = 'INSERT INTO image (path, alt, created_at) VALUES (?, ?, NOW())';
            $params = [$path, $alt];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return (int) $pdo->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function find(int $id)
    {
        $pdo = self::getConnection();
        if ($pdo === null)
            return null;
        try {
            $stmt = $pdo->prepare('SELECT * FROM image WHERE id = ? LIMIT 1');
            $stmt->execute([$id]);
            return $stmt->fetch() ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }
}
