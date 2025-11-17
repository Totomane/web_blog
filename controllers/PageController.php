<?php
require_once __DIR__ . '/../Models/project.php';

class PageController {
    public function home() {
        $projects = Project::getAll();
        require 'views/home.php';
    }

    public function about() {
        require 'views/about.php';
    }

    public function contact() {
        require 'views/contact.php';
    }

    public function project($id) {
        $project = Project::getById($id);
        require 'views/project.php';
    }

    public function error($code, $message) {
        http_response_code($code);
        echo "<h1>$code - $message</h1>";
    }
}
