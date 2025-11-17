<?php
class Project {
    public static function getAll() {
        return [
            ['id' => 1, 'title' => 'Domaine YE Marrakech', 'image' => 'vue-entree-mono-.webp'],
            ['id' => 2, 'title' => 'Community School', 'image' => 'vue-scenario-nuit2.webp'],
            
        ];
    }

    public static function getById($id) {
        $projects = self::getAll();
        foreach ($projects as $project) {
            if ($project['id'] === $id) {
                return $project;
            }
        }
        return null;
    }
}
