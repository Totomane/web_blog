<?php
require_once __DIR__ . '/../Models/project.php';

if (!isset($project) || !$project) {
    header('Location: index.php?action=home');
    exit;
}

$projectImages = Project::getProjectImages($project['id']);

require_once __DIR__ . '/layout/header.php';
?>

<div class="min-h-screen bg-black text-white">

    <div class="w-full h-screen relative overflow-hidden">
        <img src="<?= htmlspecialchars($project['main_image_path'] ?? '') ?>"
            alt="<?= htmlspecialchars($project['title']) ?>" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/20"></div>
    </div>

    <div class="max-w-4xl mx-auto px-6 md:px-12 py-16">

        <div class="mb-16">
            <h1 class="text-4xl md:text-6xl font-light tracking-wide mb-6 leading-tight">
                <?= htmlspecialchars($project['title']) ?>
            </h1>

            <div class="flex flex-wrap gap-8 text-sm text-neutral-400 uppercase tracking-widest">
                <?php if (!empty($project['location'])): ?>
                    <div>
                        <span class="text-neutral-600">Location</span>
                        <p class="text-white mt-1"><?= htmlspecialchars($project['location']) ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($project['created_at'])): ?>
                    <div>
                        <span class="text-neutral-600">Date</span>
                        <p class="text-white mt-1"><?= date('Y', strtotime($project['created_at'])) ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($project['category'])): ?>
                    <div>
                        <span class="text-neutral-600">Category</span>
                        <p class="text-white mt-1"><?= htmlspecialchars($project['category']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($project['description'])): ?>
            <div class="mb-16">
                <div class="prose prose-invert prose-lg max-w-none">
                    <p class="text-lg md:text-xl leading-relaxed text-neutral-300 font-light">
                        <?= nl2br(htmlspecialchars($project['description'])) ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($projectImages)): ?>
            <div class="mb-16 space-y-12">
                <?php foreach ($projectImages as $index => $image): ?>
                    <?php if ($index === 0): ?>
                        <div class="w-full">
                            <img src="<?= htmlspecialchars($image['image_path']) ?>"
                                alt="<?= htmlspecialchars($image['image_name']) ?>" class="w-full h-auto object-cover rounded-sm">
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if (count($projectImages) > 1): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <?php foreach (array_slice($projectImages, 1) as $image): ?>
                            <div class="w-full aspect-square bg-neutral-900 rounded-sm overflow-hidden">
                                <img src="<?= htmlspecialchars($image['image_path']) ?>"
                                    alt="<?= htmlspecialchars($image['image_name']) ?>"
                                    class="w-full h-full object-cover opacity-90 hover:opacity-100 transition-opacity duration-300">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="py-12 border-t border-neutral-800">
            <a href="index.php?action=home"
                class="inline-flex items-center gap-2 text-sm uppercase tracking-widest text-neutral-400 hover:text-white transition-colors duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Projects
            </a>
        </div>

    </div>
</div>

<?php
require_once __DIR__ . '/layout/scripts.php';

?>