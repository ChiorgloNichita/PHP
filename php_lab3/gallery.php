<?php
$dir = 'image/';
$files = scandir($dir);
?>

<div class="gallery">
    <?php foreach ($files as $file): ?>
        <?php if ($file !== "." && $file !== ".."): ?>
            <img src="<?= $dir . $file ?>" alt="Image" class="gallery-img">
        <?php endif; ?>
    <?php endforeach; ?>
</div>
