<?php
require_once __DIR__ . '/layout/header.php';
?>
<div class="min-h-screen bg-[#f5f1eb] text-[#1a1a1a] py-8 pb-20 transition-colors duration-500">
    <div class="max-w-2xl mx-auto px-6">
        <div class="mb-8">
            <h1 class="text-4xl font-bold tracking-widest mb-2 text-[#1a1a1a]">CRÉER UN PROJET</h1>
            <div class="w-20 h-1 bg-[#1a1a1a]"></div>
        </div>
        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 border border-red-200 text-red-800 px-6 py-4 rounded-lg mb-6">
                <h3 class="font-semibold mb-2">Erreurs :</h3>
                <ul class="list-disc list-inside">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-6">

            <div>
                <label for="title" class="block text-sm font-semibold uppercase tracking-widest mb-3 text-neutral-600">
                    Titre du projet *
                </label>
                <input type="text" id="title" name="title" required
                    value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                    class="w-full bg-white border border-neutral-300 text-[#1a1a1a] px-4 py-3 rounded-md focus:outline-none focus:border-neutral-500 transition"
                    placeholder="Entrez le titre du projet">
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold uppercase tracking-widest mb-3 text-neutral-600">
                    Description *
                </label>
                <textarea id="description" name="description" required rows="5"
                    class="w-full bg-white border border-neutral-300 text-[#1a1a1a] px-4 py-3 rounded-md focus:outline-none focus:border-neutral-500 transition resize-vertical"
                    placeholder="Décrivez votre projet"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
            </div>

            <div>
                <label for="location" class="block text-sm font-semibold uppercase tracking-widest mb-3 text-neutral-600">
                    Localisation *
                </label>
                <input type="text" id="location" name="location" required
                    value="<?= htmlspecialchars($_POST['location'] ?? '') ?>"
                    class="w-full bg-white border border-neutral-300 text-[#1a1a1a] px-4 py-3 rounded-md focus:outline-none focus:border-neutral-500 transition"
                    placeholder="Corte, Corse">
            </div>
            <div>
                <label for="category" class="block text-sm font-semibold uppercase tracking-widest mb-3 text-neutral-600">
                    Catégorie *
                </label>
                <select id="category" name="category" required value="<?= htmlspecialchars($_POST['category'] ?? '') ?>"
                    class="w-full bg-white border border-neutral-300 text-[#1a1a1a] px-4 py-3 rounded-md focus:outline-none focus:border-neutral-500 transition">
                    <option value="">Sélectionnez une catégorie</option>
                    <option value="Appartement">Appartement</option>
                    <option value="Villa">Villa</option>
                    <option value="Batiment">Batiment</option>
                    <option value="Hotel">Hotel</option>
                </select>
            </div>

            <div>
                <label for="main_image" class="block text-sm font-semibold uppercase tracking-widest mb-3 text-neutral-600">
                    Image principale *
                </label>
                <div
                    class="border-2 border-dashed border-neutral-300 rounded-lg p-6 text-center hover:border-neutral-400 transition bg-white">
                    <input type="file" id="main_image" name="main_image" accept="image/*" required class="hidden"
                        onchange="displayFileName(this)">
                    <label for="main_image" class="cursor-pointer">
                        <div class="text-neutral-400 mb-2">
                            <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <p class="text-neutral-500">Cliquez pour sélectionner une image</p>
                        <p class="text-neutral-400 text-sm mt-1">PNG, JPG, GIF jusqu'à 10MB</p>
                    </label>
                    <p id="fileName" class="text-emerald-600 mt-2 hidden"></p>
                </div>
            </div>

            <div>
                <label for="side_images" class="block text-sm font-semibold uppercase tracking-widest mb-3 text-neutral-600">
                    Images secondaires (facultatif)
                </label>
                <input type="file" id="side_images" name="side_images[]" accept="image/*" multiple class="w-full text-neutral-500">
                <p id="sideFileList" class="text-neutral-400 mt-2 hidden"></p>
            </div>

            <div class="flex justify-end space-x-4 pt-6">
                <a href="index.php?action=home"
                    class="px-6 py-3 border border-neutral-300 text-neutral-600 rounded-md hover:bg-neutral-100 transition">
                    Annuler
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-[#1a1a1a] text-white font-semibold rounded-md hover:bg-neutral-800 transition uppercase tracking-widest">
                    Créer le projet
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    function displayFileName(input) {
        const fileName = document.getElementById('fileName');
        if (input.files && input.files[0]) {
            fileName.textContent = '✓ ' + input.files[0].name;
            fileName.classList.remove('hidden');
        }
    }
</script>