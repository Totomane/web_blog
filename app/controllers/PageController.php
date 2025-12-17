<?php
require_once __DIR__ . '/../Models/project.php';
require_once __DIR__ . '/../Models/User.php';


class PageController
{


    public function home()
    {
        require __DIR__ . '/../views/home.php';
    }

    public function about()
    {
        require __DIR__ . '/../views/about.php';
    }

    public function contact()
    {
        require __DIR__ . '/../views/contact.php';
    }
    public function project($id)
    {
        $project = Project::getById($id);
        require __DIR__ . '/../views/project.php';
    }

    public function create()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['is_admin'])) {
            header('Location: index.php?action=home');
            exit;
        }

        require_once __DIR__ . '/../Models/Image.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $location = trim($_POST['location'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $errors = [];
            if ($title === '')
                $errors[] = 'Le titre est requis';
            if ($description === '')
                $errors[] = 'La description est requise'; // en gros je dis que si la description est vide, je met un message d'erreur


            $mainImageId = null;
            $mainImagePath = null;
            $mainImageName = null;
            if (!empty($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['main_image'];
                $uploadDir = __DIR__ . '/../../storage/uploads/';
                if (!is_dir($uploadDir))
                    mkdir($uploadDir, 0777, true);
                $safeName = time() . '_' . basename($file['name']);
                $dest = $uploadDir . $safeName;
                if (move_uploaded_file($file['tmp_name'], $dest)) {
                    $path = 'storage/uploads/' . $safeName;
                    $mainImagePath = $path;
                    $mainImageName = $file['name'];
                    $mainImageId = Image::create($path, $title);
                    if (!$mainImageId) {
                        $errors[] = 'Erreur en sauvegardant l\'image principale'; // en gros si l'image n'est pas sauvegardée, je met un message d'erreur
                    }
                } else {
                    $errors[] = 'Erreur lors du téléchargement de l\'image principale';
                }
            } else {
                $errors[] = 'Image principale requise';
            }

            if (empty($errors)) {
                $projectId = Project::create([
                    'title' => $title,
                    'description' => $description,
                    'location' => $location,
                    'category' => $category
                ]);

                if ($projectId) {
                    if (!empty($mainImagePath)) {
                        Project::attachImage($projectId, $mainImagePath, $mainImageName);
                    }

                    if (!empty($_FILES['side_images'])) {
                        $files = [];
                        $file_post = $_FILES['side_images'];
                        $file_count = is_array($file_post['name']) ? count($file_post['name']) : 0;
                        $file_keys = array_keys($file_post);
                        for ($i = 0; $i < $file_count; $i++) { // la boucle sert a parcourir le tableau des fichiers
                            foreach ($file_keys as $key) {
                                $files[$i][$key] = $file_post[$key][$i]; // en gros je dis que si le fichier est bien uploadé, je le met dans le tableau
                            }
                        }

                        foreach ($files as $f) {
                            if ($f['error'] === UPLOAD_ERR_OK) {// error 0 = no error
                                $uploadDir = __DIR__ . '/../../storage/uploads/';
                                $safeName = time() . '_' . basename($f['name']);
                                $dest = $uploadDir . $safeName;
                                if (move_uploaded_file($f['tmp_name'], $dest)) { // move_uploaded_file() est une fonction qui permet de déplacer un fichier uploadé et tmp_name est le nom temporaire du fichier uploadé
                                    $path = 'storage/uploads/' . $safeName;
                                    $imgId = Image::create($path, $title);
                                    if ($imgId) {
                                        Project::attachImage($projectId, $path, $f['name']);
                                    }
                                }
                            }
                        }
                    }

                    header('Location: index.php?action=project&id=' . $projectId);
                    exit;
                } else {
                    $errors[] = 'Erreur lors de la création du projet';
                }
            }


            require __DIR__ . '/../views/create.php';
            return;
        }


        require __DIR__ . '/../views/create.php';
    }
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $user = User::findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['username'] ?? $user['name'] ?? '';
                $_SESSION['is_admin'] = !empty($user['is_admin']) ? 1 : 0;
                header('Location: index.php?action=home');
                exit;
            } else {
                if (session_status() !== PHP_SESSION_ACTIVE)
                    session_start();
                $_SESSION['auth_error'] = 'Email ou mot de passe invalide';
                header('Location: index.php?action=home');
                exit;
            }
        }


        header('Location: index.php?action=home');
        exit;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $errors = [];
            if ($username === '')
                $errors[] = 'Le nom est requis';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) // filter_var() est une fonction qui permet de valider une variable email en utilisant le filtre FILTER_VALIDATE_EMAIL qui en gros vérifie si l'email est valide
                $errors[] = 'Email invalide';
            if (strlen($password) < 6)
                $errors[] = 'Le mot de passe doit contenir au moins 6 caractères';

            if (empty($errors)) {
                $existing = User::findByEmail($email);

                if ($existing) {
                    $errors[] = 'Cet email est déjà utilisé';
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $id = User::create(['username' => $username, 'email' => $email, 'password' => $hash]);
                    if ($id) {
                        if (session_status() === PHP_SESSION_NONE) {
                            session_start();
                        }
                        $_SESSION['user_id'] = $id;
                        $_SESSION['user_name'] = $username;
                        $_SESSION['is_admin'] = 0;
                        header('Location: index.php?action=home');
                        exit;
                    } else {
                        $errors[] = 'Erreur lors de la création de compte';
                    }
                }
            }

            if (session_status() !== PHP_SESSION_ACTIVE)
                session_start();
            $_SESSION['auth_errors'] = $errors;
            header('Location: index.php?action=home');
            exit;
        }
        header('Location: index.php?action=home');
        exit;
    }
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header('Location: index.php?action=home');
        exit;
    }
    public function error($code, $message)
    {
        http_response_code($code);
        echo "<h1>$code - $message</h1>";
    }
    public function delete_project()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['is_admin'])) {
            header('Location: index.php?action=home');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

            if ($id > 0) {
                Project::delete($id);
            }
        }

        header('Location: index.php?action=home');
        exit;
    }
}
