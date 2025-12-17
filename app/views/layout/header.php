<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MS Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/public/style.css">
    <?php include __DIR__ . '/styles.php'; ?>
</head>
<body class="bg-black text-white font-sans">

<div id="loader" class="fixed inset-0 flex flex-col items-center justify-center bg-black z-50">
    <h1 class="text-5xl font-bold tracking-widest mb-6">MS STUDIO</h1>
    <div class="w-16 h-16 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
</div>

<?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } ?>
<?php
    $__openLoginModal = false;
    $__openRegisterModal = false;
    if (!empty($_SESSION['auth_error'])) { $__openLoginModal = true; }
    if (!empty($_SESSION['auth_errors'])) { $__openRegisterModal = true; }
?>
<header class="flex justify-between items-center p-6 border-b border-gray-800">
    <div class="flex items-center space-x-6">
        <div class="flex items-center space-x-4">
            <a href="index.php?action=home" class="text-2xl font-semibold tracking-widest text-white">MS STUDIO</a>
            <span class="text-gray-400 text-sm font-light">Architects</span>
        </div>
    </div>

    <div class="hidden md:flex items-center space-x-3">
        <?php if (!empty($_SESSION['user_name'])): ?>
            <span class="text-sm text-gray-300">Bonjour, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
            <a href="index.php?action=logout" class="px-3 py-1 border border-gray-600 text-sm rounded hover:bg-gray-800">Logout</a>
        <?php else: ?>
            <button id="loginBtn" class="px-3 py-1 border border-gray-600 text-sm rounded hover:bg-gray-800">Login</button>
            <button id="registerBtn" class="px-3 py-1 bg-white text-black text-sm rounded hover:bg-gray-200">Sign up</button>
        <?php endif; ?>
    </div>

    <div class="md:hidden cursor-pointer">
        <div class="w-6 h-0.5 bg-white mb-1"></div>
        <div class="w-6 h-0.5 bg-white mb-1"></div>
        <div class="w-6 h-0.5 bg-white"></div>
        
        <div class="menu-dropdown absolute right-6 mt-2 w-56 bg-black border border-gray-800 rounded shadow-lg">
            <a href="index.php?action=home" class="block px-4 py-2 hover:bg-gray-800">Home</a>
            <a href="index.php?action=projects" class="block px-4 py-2 hover:bg-gray-800">Projects</a>
            <a href="index.php?action=about" class="block px-4 py-2 hover:bg-gray-800">About</a>
            <a href="index.php?action=contact" class="block px-4 py-2 hover:bg-gray-800">Contact</a>
            <?php if (empty($_SESSION['user_name'])): ?>
                <button onclick="openLoginModal()" class="w-full text-left px-4 py-2 hover:bg-gray-800">Login</button>
                <button onclick="openRegisterModal()" class="w-full text-left px-4 py-2 hover:bg-gray-800">Sign up</button>
            <?php else: ?>
                <a href="index.php?action=logout" class="block px-4 py-2 hover:bg-gray-800">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Login Modal -->
<div id="loginModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70">
    <div class="w-full max-w-md bg-black border border-gray-800 rounded p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Se connecter</h3>
            <button onclick="closeLoginModal()" class="text-gray-400">✕</button>
        </div>
        <form method="POST" action="index.php?action=login" class="space-y-4">
            <?php if (!empty($_SESSION['auth_error'])): ?>
                <div class="bg-red-900 text-red-100 p-3 rounded mb-2"><?= htmlspecialchars($_SESSION['auth_error']) ?></div>
            <?php unset($_SESSION['auth_error']); endif; ?>
            <div>
                <label class="block text-sm font-semibold">Email</label>
                <input type="email" name="email" required class="w-full bg-gray-900 border border-gray-700 text-white px-3 py-2 rounded" value="">
            </div>
            <div>
                <label class="block text-sm font-semibold">Mot de passe</label>
                <input type="password" name="password" required class="w-full bg-gray-900 border border-gray-700 text-white px-3 py-2 rounded">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-white text-black rounded">Se connecter</button>
            </div>
        </form>
    </div>
</div>

<!-- Register Modal -->
<div id="registerModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70">
    <div class="w-full max-w-md bg-black border border-gray-800 rounded p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Créer un compte</h3>
            <button onclick="closeRegisterModal()" class="text-gray-400">✕</button>
        </div>
        <form method="POST" action="index.php?action=register" class="space-y-4">
            <?php if (!empty($_SESSION['auth_errors'])): ?>
                <div class="bg-red-900 text-red-100 p-3 rounded mb-2">
                    <ul class="list-disc list-inside">
                        <?php foreach($_SESSION['auth_errors'] as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php unset($_SESSION['auth_errors']); endif; ?>
            <div>
                <label class="block text-sm font-semibold">Nom</label>
                <input type="text" name="username" required class="w-full bg-gray-900 border border-gray-700 text-white px-3 py-2 rounded">
            </div>
            <div>
                <label class="block text-sm font-semibold">Email</label>
                <input type="email" name="email" required class="w-full bg-gray-900 border border-gray-700 text-white px-3 py-2 rounded">
            </div>
            <div>
                <label class="block text-sm font-semibold">Mot de passe</label>
                <input type="password" name="password" required class="w-full bg-gray-900 border border-gray-700 text-white px-3 py-2 rounded">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-white text-black rounded">S'inscrire</button>
            </div>
        </form>
    </div>
</div>

<script>
    const loginBtn = document.getElementById('loginBtn');
    const registerBtn = document.getElementById('registerBtn');
    function openLoginModal() { document.getElementById('loginModal').classList.remove('hidden'); }
    function closeLoginModal() { document.getElementById('loginModal').classList.add('hidden'); }
    function openRegisterModal() { document.getElementById('registerModal').classList.remove('hidden'); }
    function closeRegisterModal() { document.getElementById('registerModal').classList.add('hidden'); }
    if (loginBtn) loginBtn.addEventListener('click', openLoginModal);
    if (registerBtn) registerBtn.addEventListener('click', openRegisterModal);
    // close on ESC
    document.addEventListener('keydown', function(e){ if (e.key === 'Escape') { closeLoginModal(); closeRegisterModal(); } });
</script>
    <?php if ($__openLoginModal): ?>
    <script>openLoginModal();</script>
    <?php endif; ?>
    <?php if ($__openRegisterModal): ?>
    <script>openRegisterModal();</script>
    <?php endif; ?>
