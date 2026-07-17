<?php
require_once __DIR__ . '/layout/header.php';
?>

<div id="content" class="fade-in bg-[#f5f1eb] pb-24 min-h-[50vh] pt-4 transition-colors duration-500">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
        <?php if(empty($projects)): ?>
            <div class="col-span-full py-24 text-center text-neutral-500 font-light tracking-widest uppercase text-sm border border-neutral-200 mx-6 md:mx-0">
                Aucun projet trouvé dans cette catégorie.
            </div>
        <?php else: ?>
            <?php foreach ($projects as $project): ?>
                <div class="relative group fade-in block">
                    <a href="index.php?action=project&id=<?= $project['id'] ?>" class="block w-full h-full">
                        <div class="overflow-hidden rounded-sm bg-[#eae3d8]/30">
                            <img src="<?= htmlspecialchars($project['main_image_path'] ?? '') ?>"
                                class="w-full h-[65vh] object-cover transition duration-700 group-hover:scale-102 group-hover:grayscale-0 grayscale"
                                alt="<?= htmlspecialchars($project['title']) ?>">
                        </div>
                        <div class="mt-4 text-center">
                            <h2 class="uppercase text-sm tracking-[0.2em] text-[#1a1a1a] font-medium transition-colors duration-300 hover:text-neutral-500"><?= htmlspecialchars($project['title']) ?></h2>
                        </div>
                    </a>
                    <?php if (!empty($_SESSION['is_admin'])): ?>
                        <form action="index.php?action=delete_project" method="POST" class="absolute top-4 right-4 z-20" onclick="event.stopPropagation(); event.preventDefault();"
                            onsubmit="event.preventDefault(); event.stopPropagation(); if(confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')) { this.submit(); }">
                            <input type="hidden" name="id" value="<?= $project['id'] ?>">
                            <button type="submit" onclick="event.stopPropagation();" class="text-neutral-400 hover:text-red-600 bg-white/80 rounded-full shadow-sm transition-colors duration-300 p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pointer-events-none" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        } ?>
        <?php if (!empty($_SESSION['is_admin'])): ?>
            <div class="relative group fade-in cursor-pointer" onclick="openCreateModal()">
                <div class="w-full h-[65vh] bg-white/50 border-2 border-dashed border-neutral-300 flex items-center justify-center hover:bg-white hover:border-neutral-400 transition duration-700 rounded-sm">
                    <div class="text-center">
                        <div class="text-6xl text-neutral-400 font-light mb-4">+</div>
                        <h2 class="uppercase text-sm tracking-widest text-neutral-500 font-medium">Ajouter un projet</h2>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Creation Modal -->
    <div id="createModal"
        class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden z-50 flex items-center justify-center transition-opacity duration-300">
        <div class="bg-[#fcfaf7] border border-neutral-200 rounded-lg max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto shadow-2xl transform transition-all duration-300">
            <div class="p-8">
                <div class="flex justify-between items-center mb-8 border-b border-neutral-200 pb-4">
                    <h2 class="text-2xl font-light text-[#1a1a1a] uppercase tracking-[0.2em]">Nouveau Projet</h2>
                    <button onclick="closeCreateModal()"
                        class="text-neutral-400 hover:text-black transition-colors duration-200 text-4xl leading-none">&times;</button>
                </div>

                <form action="index.php?action=create" method="post" enctype="multipart/form-data" class="space-y-6">
                    <div>
                        <label for="title"
                            class="block text-xs font-bold text-neutral-500 uppercase tracking-widest mb-3">Titre du projet</label>
                        <input type="text" id="title" name="title" required
                            class="w-full bg-white border border-neutral-300 text-[#1a1a1a] px-4 py-3 rounded-lg focus:outline-none focus:border-neutral-500 focus:bg-white transition duration-300 placeholder-neutral-400"
                            >
                    </div>

                    <div>
                        <label for="description"
                            class="block text-xs font-bold text-neutral-500 uppercase tracking-widest mb-3">Description</label>
                        <textarea id="description" name="description" required
                            class="w-full bg-white border border-neutral-300 text-[#1a1a1a] px-4 py-3 h-32 focus:outline-none focus:border-neutral-500 focus:bg-white transition duration-300 resize-none placeholder-neutral-400"
                            ></textarea>
                    </div>

                    <div>
                        <label for="location"
                            class="block text-xs font-bold text-neutral-500 uppercase tracking-widest mb-3">Localisation</label>
                        <input type="text" id="location" name="location" required
                            class="w-full bg-white border border-neutral-300 text-[#1a1a1a] px-4 py-3 focus:outline-none focus:border-neutral-500 focus:bg-white transition duration-300 placeholder-neutral-400"
                            >
                    </div>

                    <div>
                        <label for="category"
                            class="block text-xs font-bold text-neutral-500 uppercase tracking-widest mb-3">Catégorie</label>
                        <select id="category" name="category"
                            class="w-full bg-white border border-neutral-300 text-[#1a1a1a] px-4 py-3 focus:outline-none focus:border-neutral-500 transition duration-300">
                            <option value="">Sélectionnez une catégorie</option>
                            <option value="Appartement">Appartement</option>
                            <option value="Villa">Villa</option>
                            <option value="Batiment">Batiment</option>
                            <option value="Hotel">Hotel</option>
                        </select>
                    </div>

                    <div>
                        <label for="main_image"
                            class="block text-xs font-bold text-neutral-500 uppercase tracking-widest mb-3">Image principale</label>
                        <label
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-neutral-300 border-dashed cursor-pointer bg-white hover:bg-neutral-50 hover:border-neutral-400 transition duration-300 rounded-lg">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-neutral-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <p class="text-xs text-neutral-500 uppercase tracking-wider">Cliquez pour ajouter une image</p>
                            </div>
                            <input type="file" id="main_image" name="main_image" accept="image/*" required
                                class="hidden" onchange="displayFileName(this)">
                        </label>
                        <p id="fileName"
                            class="text-emerald-600 text-xs mt-2 text-center uppercase tracking-wider hidden">
                        </p>
                    </div>

                    <div>
                        <label for="side_images"
                            class="block text-xs font-bold text-neutral-500 uppercase tracking-widest mb-3">Images secondaires (sous la description)</label>
                        <input type="file" id="side_images" name="side_images[]" accept="image/*" multiple
                            class="block w-full text-sm text-neutral-500" onchange="displayMultipleFiles(this)">
                        <p id="sideFileList" class="text-emerald-600 text-xs mt-2 hidden"></p>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6 border-t border-neutral-200">
                        <button type="button" onclick="closeCreateModal()"
                            class="px-6 py-3 border border-neutral-300 text-neutral-600 rounded-lg hover:bg-neutral-100 transition duration-300 uppercase text-xs tracking-widest font-semibold">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-8 py-3 bg-[#1a1a1a] text-white rounded-lg hover:bg-neutral-800 transition duration-300 uppercase text-xs tracking-widest font-bold shadow-lg shadow-black/10">
                            Créer le projet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCreateModal() { document.getElementById('createModal').classList.remove('hidden'); }
        function closeCreateModal() { document.getElementById('createModal').classList.add('hidden'); }
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
</div>
<?php
include __DIR__ . '/layout/scripts.php';
?>
