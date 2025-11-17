<?php include 'views/layout/header.php'; ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4 bg-black">
    <?php foreach ($projects as $project): ?>
        <div class="bg-white shadow-md rounded overflow-hidden">
            <img src="public/images/<?= $project['image']; ?>" alt="<?= $project['title']; ?>" class="w-full h-48 object-cover">
            <div class="p-4">
                <h2 class="text-xl font-bold"><?= $project['title']; ?></h2>
                <a href="?action=project&id=<?= $project['id']; ?>" class="text-blue-500 hover:underline">Voir le projet</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php include 'views/layout/footer.php'; ?>
