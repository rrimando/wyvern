<div class="image-buttons">
    <?php foreach ($items as $item => $attributes): ?>
        <a href="<?php echo $attributes['url']; ?>" target="_blank">
            <img src="<?php echo $attributes['img']; ?>" class="image-button" />
        </a>
    <?php endforeach; ?>
</div>
