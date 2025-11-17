<?php require __DIR__ . '/../layout.php'; ?>

<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #333;">Créer un nouveau projet</h1>

    <?php if (!isset($categories)) { echo "<p style='color: red;'>Erreur : la variable \$categories n'est pas définie !</p>"; exit; } ?>

    <form action="/projects/create" method="post" enctype="multipart/form-data" style="background-color: #f9f9f9; padding: 20px; border-radius: 8px;">

        <div style="margin-bottom: 15px;">
            <label for="title" style="font-weight: bold;">Titre du projet :</label><br>
            <input type="text" id="title" name="title" required style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="description" style="font-weight: bold;">Description :</label><br>
            <textarea id="description" name="description" required style="width: 100%; padding: 8px; height: 120px;"></textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="location" style="font-weight: bold;">Localisation :</label><br>
            <input type="text" id="location" name="location" required style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            
            <label for="category" style="font-weight: bold;">Catégorie :</label><br>
            <select id="category" name="category" required style="width: 100%; padding: 8px;">
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['id']) ?>">
                        <?= htmlspecialchars($cat['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="main_image" style="font-weight: bold;">Image principale :</label><br>
            <input type="file" id="main_image" name="main_image" accept="image/*" required>
        </div>

        <button type="submit" style="padding: 10px 20px; background-color: #0066cc; color: white; border: none; border-radius: 4px;">
            Créer le projet
        </button>
    </form>
</div>
