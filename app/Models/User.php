<?php

class User
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

    public static function findByEmail(string $email)
    {
        $pdo = self::getConnection();
        if ($pdo === null)
            return null;
        try {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
            $stmt->execute([$email]);
            return $stmt->fetch() ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public static function create(array $data)
    {
        $pdo = self::getConnection();
        if ($pdo === null)
            return false;
        try {
            $sql = 'INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())';
            $stmt = $pdo->prepare($sql);
            $params = [
                $data['username'],
                $data['email'],
                $data['password']
            ];
            $stmt->execute($params);
            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }
}
