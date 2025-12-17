<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Models/project.php';
$projects = Project::getAll();
require_once __DIR__ . '/layout/header.php';
?>
<div id="content" class="opacity-0 transition-opacity duration-1000">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-0 p-2">
        <?php foreach ($projects as $project): ?>
            <div class="relative group fade-in block">
                <a href="index.php?action=project&id=<?= $project['id'] ?>" class="block w-full h-full">
                    <img src="<?= htmlspecialchars($project['main_image_path'] ?? '') ?>"
                        class="w-full h-[80vh] object-cover transition duration-700 group-hover:scale-105 group-hover:grayscale-0 grayscale"
                        alt="<?= htmlspecialchars($project['title']) ?>">
                    <div class="absolute bottom-0 w-full bg-black bg-opacity-50 text-center py-3">
                        <h2 class="uppercase text-lg tracking-widest"><?= htmlspecialchars($project['title']) ?></h2>
                    </div>
                </a>
                <?php if (!empty($_SESSION['is_admin'])): ?>
                    <form action="index.php?action=delete_project" method="POST" class="absolute top-4 right-4 z-20"
                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');">
                        <input type="hidden" name="id" value="<?= $project['id'] ?>">
                        <button type="submit" class="text-white/30 hover:text-white transition-colors duration-300 p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <?php if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        } ?>
        <?php if (!empty($_SESSION['is_admin'])): ?>
            <div class="relative group fade-in cursor-pointer" onclick="openCreateModal()">
                <div
                    class="w-full h-[80vh] bg-gray-800 border-2 border-dashed border-gray-600 flex items-center justify-center hover:bg-gray-700 transition duration-700">
                    <div class="text-center">
                        <div class="text-6xl text-gray-400 mb-4">+</div>
                        <h2 class="uppercase text-lg tracking-widest text-gray-400">Ajouter un projet</h2>
                    </div>
                </div>
            </div>
        <?php endif; ?>




    </div>

    <div id="createModal"
        class="fixed inset-0 bg-black/90 backdrop-blur-sm hidden z-50 flex items-center justify-center transition-opacity duration-300">
        <div
            class="bg-neutral-900 border border-neutral-800 rounded-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto shadow-2xl transform transition-all duration-300">
            <div class="p-8">
                <div class="flex justify-between items-center mb-8 border-b border-neutral-800 pb-4">
                    <h2 class="text-2xl font-light text-white uppercase tracking-[0.2em]">Nouveau Projet</h2>
                    <button onclick="closeCreateModal()"
                        class="text-neutral-500 hover:text-white transition-colors duration-200 text-4xl leading-none">&times;</button>
                </div>

                <form action="index.php?action=create" method="post" enctype="multipart/form-data" class="space-y-6">
                    <div>
                        <label for="title"
                            class="block text-xs font-bold text-neutral-400 uppercase tracking-widest mb-3">Titre du
                            projet</label>
                        <input type="text" id="title" name="title" required
                            class="w-full bg-neutral-800/50 border border-neutral-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:border-white focus:bg-neutral-800 transition duration-300 placeholder-neutral-600"
                            placeholder="EX: VILLA MARRAKECH">
                    </div>

                    <div>
                        <label for="description"
                            class="block text-xs font-bold text-neutral-400 uppercase tracking-widest mb-3">Description</label>
                        <textarea id="description" name="description" required
                            class="w-full bg-neutral-800/50 border border-neutral-700 text-white px-4 py-3 rounded-lg h-32 focus:outline-none focus:border-white focus:bg-neutral-800 transition duration-300 resize-none placeholder-neutral-600"
                            placeholder="Description du projet..."></textarea>
                    </div>

                    <div>
                        <label for="location"
                            class="block text-xs font-bold text-neutral-400 uppercase tracking-widest mb-3">Localisation</label>
                        <input type="text" id="location" name="location" required
                            class="w-full bg-neutral-800/50 border border-neutral-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:border-white focus:bg-neutral-800 transition duration-300 placeholder-neutral-600"
                            placeholder="EX: MARRAKECH, MAROC">
                    </div>

                    <div>
                        <label for="category"
                            class="block text-xs font-bold text-neutral-400 uppercase tracking-widest mb-3">Catégorie</label>
                        <select id="category" name="category"
                            class="w-full bg-neutral-800/50 border border-neutral-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:border-white focus:bg-neutral-800 transition duration-300">
                            <option value="">Sélectionnez une catégorie</option>
                            <option value="Appartement">Appartement</option>
                            <option value="Villa">Villa</option>
                            <option value="Batiment">Batiment</option>
                            <option value="Special">Special</option>
                        </select>
                    </div>

                    <div>
                        <label for="main_image"
                            class="block text-xs font-bold text-neutral-400 uppercase tracking-widest mb-3">Image
                            principale</label>
                        <label
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-neutral-700 border-dashed rounded-lg cursor-pointer hover:bg-neutral-800/50 hover:border-neutral-500 transition duration-300">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-neutral-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <p class="text-xs text-neutral-500 uppercase tracking-wider">Cliquez pour ajouter une
                                    image
                                </p>
                            </div>
                            <input type="file" id="main_image" name="main_image" accept="image/*" required
                                class="hidden" onchange="displayFileName(this)">
                        </label>
                        <p id="fileName"
                            class="text-green-500 text-xs mt-2 text-center uppercase tracking-wider hidden">
                        </p>
                    </div>

                    <div>
                        <label for="side_images"
                            class="block text-xs font-bold text-neutral-400 uppercase tracking-widest mb-3">Images
                            secondaires (sous la description)</label>
                        <input type="file" id="side_images" name="side_images[]" accept="image/*" multiple
                            class="block w-full text-sm text-gray-400" onchange="displayMultipleFiles(this)">
                        <p id="sideFileList" class="text-green-500 text-xs mt-2 hidden"></p>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6 border-t border-neutral-800">
                        <button type="button" onclick="closeCreateModal()"
                            class="px-6 py-3 border border-neutral-700 text-neutral-300 rounded-lg hover:bg-neutral-800 hover:text-white transition duration-300 uppercase text-xs tracking-widest font-semibold">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-8 py-3 bg-white text-black rounded-lg hover:bg-neutral-200 transition duration-300 uppercase text-xs tracking-widest font-bold shadow-lg shadow-white/10">
                            Créer le projet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function displayFileName(input) {
            const fileName = document.getElementById('fileName');
            if (input.files && input.files[0]) {
                fileName.textContent = 'IMAGE SÉLECTIONNÉE: ' + input.files[0].name;
                fileName.classList.remove('hidden');
            }
        }
        function displayMultipleFiles(input) {
            const list = document.getElementById('sideFileList');
            if (input.files && input.files.length > 0) {
                const names = Array.from(input.files).map(f => f.name).join(', ');
                list.textContent = 'FICHIERS: ' + names;
                list.classList.remove('hidden');
            } else {
                list.classList.add('hidden');
            }
        }
    </script>

    <?php
    include __DIR__ . '/layout/scripts.php';
    ?>