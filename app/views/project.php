<?php
require_once __DIR__ . '/../Models/project.php';

if (!isset($project) || !$project) {
    header('Location: index.php?action=home');
    exit;
}

$projectImages = Project::getProjectImages($project['id']);
require_once __DIR__ . '/layout/header.php';
?>

<div class="min-h-screen bg-[#f5f1eb] text-[#1a1a1a] pt-8 pb-24">
    <!-- Navigation header bar matching the mockup -->
    <div class="max-w-6xl mx-auto px-6 md:px-12 flex justify-between items-center mb-12 text-sm uppercase tracking-widest border-b border-neutral-200/60 pb-6">
        <div>
            <a href="index.php?action=projects" class="flex items-center gap-2 text-[#1a1a1a] hover:opacity-60 transition-opacity duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"></path>
                </svg>
                Retour aux projets
            </a>
        </div>
        <div class="flex items-center gap-6">
            <?php if (!empty($prevNext['prev'])): ?>
                <a href="index.php?action=project&id=<?= $prevNext['prev'] ?>" class="text-[#1a1a1a] hover:opacity-60 transition-opacity duration-300">Prev</a>
            <?php else: ?>
                <span class="text-neutral-300 cursor-default select-none">Prev</span>
            <?php endif; ?>

            <?php if (!empty($prevNext['next'])): ?>
                <a href="index.php?action=project&id=<?= $prevNext['next'] ?>" class="text-[#1a1a1a] hover:opacity-60 transition-opacity duration-300">Next</a>
            <?php else: ?>
                <span class="text-neutral-300 cursor-default select-none">Next</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="max-w-6xl mx-auto px-6 md:px-12">
        <!-- Title and Metadata Section -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-light tracking-wide mb-6 leading-tight font-serif text-[#1a1a1a]">
                <?= htmlspecialchars($project['title']) ?>
            </h1>

            <div class="flex flex-wrap gap-8 text-xs text-neutral-500 uppercase tracking-widest mb-8">
                <?php if (!empty($project['location'])): ?>
                    <div>
                        <span class="text-neutral-400 block mb-1">Localisation</span>
                        <p class="text-[#1a1a1a] font-medium"><?= htmlspecialchars($project['location']) ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($project['created_at'])): ?>
                    <div>
                        <span class="text-neutral-400 block mb-1">Date</span>
                        <p class="text-[#1a1a1a] font-medium"><?= date('Y', strtotime($project['created_at'])) ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($project['category'])): ?>
                    <div>
                        <span class="text-neutral-400 block mb-1">Catégorie</span>
                        <p class="text-[#1a1a1a] font-medium"><?= htmlspecialchars($project['category']) ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Description Text -->
            <?php if (!empty($project['description'])): ?>
                <div class="max-w-3xl">
                    <p class="text-base md:text-lg leading-relaxed text-neutral-700 font-light">
                        <?= nl2br(htmlspecialchars($project['description'])) ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Stacked Images "En vrac" (All uniform width) -->
        <?php if (!empty($projectImages)): ?>
            <div class="space-y-8 mt-16 max-w-5xl mx-auto">
                <?php foreach ($projectImages as $index => $image): ?>
                    <div class="w-full bg-[#eae3d8]/30 rounded-sm overflow-hidden cursor-zoom-in">
                        <img src="<?= htmlspecialchars($image['image_path']) ?>"
                             alt="<?= htmlspecialchars($image['image_name'] ?? '') ?>" 
                             class="w-full h-auto object-contain max-h-[85vh] mx-auto hover:opacity-95 transition-opacity duration-300"
                             onclick="openLightbox(this.src, <?= $index ?>)">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 bg-black/95 z-50 hidden flex items-center justify-center p-4">
    <button onclick="closeLightbox()" class="absolute top-6 right-6 text-white text-3xl font-light hover:text-gray-300 transition-colors duration-200">✕</button>
    
    <?php if (count($projectImages) > 1): ?>
        <button onclick="prevLightboxImage()" class="absolute left-6 text-white text-5xl font-light hover:text-gray-300 transition-colors duration-200">‹</button>
        <button onclick="nextLightboxImage()" class="absolute right-6 text-white text-5xl font-light hover:text-gray-300 transition-colors duration-200">›</button>
    <?php endif; ?>

    <img id="lightboxImg" src="" alt="Lightbox image" class="max-w-full max-h-[90vh] object-contain select-none">
</div>

<script>
    const allImages = <?= json_encode(array_column($projectImages, 'image_path')) ?>;
    let currentImageIndex = 0;

    function openLightbox(src, index) {
        currentImageIndex = index;
        document.getElementById('lightboxImg').src = src;
        document.getElementById('lightbox').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.add('hidden');
        document.body.style.overflow = '';
    }

    function prevLightboxImage() {
        if (allImages.length <= 1) return;
        currentImageIndex = (currentImageIndex - 1 + allImages.length) % allImages.length;
        document.getElementById('lightboxImg').src = allImages[currentImageIndex];
    }

    function nextLightboxImage() {
        if (allImages.length <= 1) return;
        currentImageIndex = (currentImageIndex + 1) % allImages.length;
        document.getElementById('lightboxImg').src = allImages[currentImageIndex];
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (document.getElementById('lightbox').classList.contains('hidden')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') prevLightboxImage();
        if (e.key === 'ArrowRight') nextLightboxImage();
    });
</script>

<?php
require_once __DIR__ . '/layout/scripts.php';
?>