<?php

class Project
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

    public static function getAll()
    {
        $pdo = self::getConnection();
        if ($pdo === null)
            return [];

        try {
            $sql = 'SELECT p.*, (
                        SELECT pi.image_path FROM project_images pi
                        WHERE pi.project_id = p.id
                        ORDER BY pi.id ASC LIMIT 1
                    ) as main_image_path FROM projects p ORDER BY p.created_at DESC';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }



    public static function getById($id)
    {
        $pdo = self::getConnection();
        if ($pdo === null)
            return null;

        try {
            $sql = 'SELECT p.* FROM projects p WHERE p.id = ? LIMIT 1';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $project = $stmt->fetch();

            if (!$project)
                return null;


            $sql2 = 'SELECT id, image_path, image_name, created_at FROM project_images WHERE project_id = ? ORDER BY id ASC';
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute([$id]);
            $project['side_images'] = $stmt2->fetchAll();

            if (!empty($project['side_images'])) {
                $project['main_image_path'] = $project['side_images'][0]['image_path'];
            }

            return $project;
        } catch (PDOException $e) {
            return null;
        }
    }



    public static function create($data)
    {
        $pdo = self::getConnection();
        if ($pdo === null)
            return false;

        try {
            $sql = 'INSERT INTO projects (title, description, location, category, created_at) VALUES (?, ?, ?, ?, NOW())';
            $params = [
                $data['title'],
                $data['description'] ?? '',
                $data['location'] ?? '',
                $data['category'] ?? ''
            ];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $projectId = (int) $pdo->lastInsertId();
            return $projectId;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function attachImage(int $projectId, string $imagePath, ?string $imageName = null): bool
    {
        $pdo = self::getConnection();
        if ($pdo === null)
            return false;
        try {
            $sql = 'INSERT INTO project_images (project_id, image_path, image_name, created_at) VALUES (?, ?, ?, NOW())';
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$projectId, $imagePath, $imageName]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getProjectImages(int $projectId): array
    {
        $pdo = self::getConnection();
        if ($pdo === null)
            return [];
        try {
            $sql = 'SELECT id, image_path, image_name, created_at FROM project_images WHERE project_id = ? ORDER BY id ASC';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$projectId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    public static function delete(int $id): bool
    {
        $pdo = self::getConnection();
        if ($pdo === null)
            return false;

        try {

            $stmtImg = $pdo->prepare('DELETE FROM project_images WHERE project_id = ?');
            $stmtImg->execute([$id]);


            $stmt = $pdo->prepare('DELETE FROM projects WHERE id = ?');
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
