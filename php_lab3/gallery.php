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
<p style="text-align:center; margin-top: 20px;">USM @ 2025</p>