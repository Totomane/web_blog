<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MS Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/public/style.css">
    <?php include __DIR__ . '/styles.php'; ?>
</head>
<body class="bg-[#f5f1eb] text-[#1a1a1a] font-sans transition-colors duration-500">

<div id="loader" class="fixed inset-0 flex flex-col items-center justify-center bg-[#f5f1eb] z-50">
    <h1 class="text-5xl font-bold tracking-widest mb-6 text-[#1a1a1a]">MS STUDIO</h1>
    <div class="w-16 h-16 border-4 border-[#1a1a1a] border-t-transparent rounded-full animate-spin"></div>
</div>

<?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } ?>
<?php
    $__openLoginModal = false;
    $__openRegisterModal = false;
    if (!empty($_SESSION['auth_error'])) { $__openLoginModal = true; }
    if (!empty($_SESSION['auth_errors'])) { $__openRegisterModal = true; }
?>
<header class="flex justify-between items-center p-6 border-b border-neutral-200 bg-[#f5f1eb]">
    <div class="flex items-center space-x-6">
        <div class="flex items-center space-x-4">
            <a href="index.php?action=choice" class="text-2xl font-semibold tracking-widest text-[#1a1a1a]">MS STUDIO</a>
            <span class="text-neutral-500 text-sm font-light">Architects</span>
        </div>
    </div>

    <div class="hidden md:flex items-center space-x-3">
        <?php if (!empty($_SESSION['user_name'])): ?>
            <span class="text-sm text-neutral-600">Bonjour, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
            <a href="index.php?action=logout" class="px-3 py-1 border border-neutral-300 text-sm rounded hover:bg-neutral-100 text-[#1a1a1a] transition-all">Logout</a>
        <?php else: ?>
            <?php if (isset($_GET['action']) && $_GET['action'] === 'admin'): ?>
                <button id="loginBtn" class="px-3 py-1 border border-neutral-300 text-sm rounded hover:bg-neutral-100 text-[#1a1a1a] transition-all">Login</button>
                <button id="registerBtn" class="px-3 py-1 bg-[#1a1a1a] text-white text-sm rounded hover:bg-neutral-800 transition-all">Sign up</button>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="md:hidden cursor-pointer relative" onclick="toggleMobileDropdown()">
        <div class="w-6 h-0.5 bg-[#1a1a1a] mb-1"></div>
        <div class="w-6 h-0.5 bg-[#1a1a1a] mb-1"></div>
        <div class="w-6 h-0.5 bg-[#1a1a1a]"></div>
        
        <div id="mobileMenuDropdown" class="hidden absolute right-0 mt-2 w-56 bg-[#f5f1eb] border border-neutral-200 rounded shadow-lg text-[#1a1a1a] z-50">
            <a href="index.php?action=choice" class="block px-4 py-2 hover:bg-neutral-100">Home</a>
            <a href="index.php?action=projects" class="block px-4 py-2 hover:bg-neutral-100">Projects</a>
            <a href="index.php?action=about" class="block px-4 py-2 hover:bg-neutral-100">About</a>
            <a href="index.php?action=contact" class="block px-4 py-2 hover:bg-neutral-100">Contact</a>
            <?php if (empty($_SESSION['user_name'])): ?>
                <?php if (isset($_GET['action']) && $_GET['action'] === 'admin'): ?>
                    <button onclick="openLoginModal()" class="w-full text-left px-4 py-2 hover:bg-neutral-100">Login</button>
                    <button onclick="openRegisterModal()" class="w-full text-left px-4 py-2 hover:bg-neutral-100">Sign up</button>
                <?php endif; ?>
            <?php else: ?>
                <a href="index.php?action=logout" class="block px-4 py-2 hover:bg-neutral-100">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Login Modal -->
<div id="loginModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="w-full max-w-md bg-[#fcfaf7] border border-neutral-200 rounded p-6 shadow-xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-[#1a1a1a]">Se connecter</h3>
            <button onclick="closeLoginModal()" class="text-neutral-400 hover:text-black">✕</button>
        </div>
        <form method="POST" action="index.php?action=login" class="space-y-4">
            <?php if (!empty($_SESSION['auth_error'])): ?>
                <div class="bg-red-100 text-red-800 p-3 rounded mb-2 border border-red-200"><?= htmlspecialchars($_SESSION['auth_error']) ?></div>
            <?php unset($_SESSION['auth_error']); endif; ?>
            <div>
                <label class="block text-sm font-semibold text-neutral-600">Email</label>
                <input type="email" name="email" required class="w-full bg-white border border-neutral-300 text-[#1a1a1a] px-3 py-2 rounded focus:outline-none focus:border-neutral-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-neutral-600">Mot de passe</label>
                <input type="password" name="password" required class="w-full bg-white border border-neutral-300 text-[#1a1a1a] px-3 py-2 rounded focus:outline-none focus:border-neutral-500">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-[#1a1a1a] text-white rounded hover:bg-neutral-800 transition-all">Se connecter</button>
            </div>
        </form>
    </div>
</div>

<!-- Register Modal -->
<div id="registerModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="w-full max-w-md bg-[#fcfaf7] border border-neutral-200 rounded p-6 shadow-xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-[#1a1a1a]">Créer un compte</h3>
            <button onclick="closeRegisterModal()" class="text-neutral-400 hover:text-black">✕</button>
        </div>
        <form method="POST" action="index.php?action=register" class="space-y-4">
            <?php if (!empty($_SESSION['auth_errors'])): ?>
                <div class="bg-red-100 text-red-800 p-3 rounded mb-2 border border-red-200">
                    <ul class="list-disc list-inside">
                        <?php foreach($_SESSION['auth_errors'] as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php unset($_SESSION['auth_errors']); endif; ?>
            <div>
                <label class="block text-sm font-semibold text-neutral-600">Nom</label>
                <input type="text" name="username" required class="w-full bg-white border border-neutral-300 text-[#1a1a1a] px-3 py-2 rounded focus:outline-none focus:border-neutral-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-neutral-600">Email</label>
                <input type="email" name="email" required class="w-full bg-white border border-neutral-300 text-[#1a1a1a] px-3 py-2 rounded focus:outline-none focus:border-neutral-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-neutral-600">Mot de passe</label>
                <input type="password" name="password" required class="w-full bg-white border border-neutral-300 text-[#1a1a1a] px-3 py-2 rounded focus:outline-none focus:border-neutral-500">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-[#1a1a1a] text-white rounded hover:bg-neutral-800 transition-all">S'inscrire</button>
            </div>
        </form>
    </div>
</div>

<script>
    const loginBtn = document.getElementById('loginBtn');
    const registerBtn = document.getElementById('registerBtn');
    
    function toggleMobileDropdown() {
        document.getElementById('mobileMenuDropdown').classList.toggle('hidden');
    }
    
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
