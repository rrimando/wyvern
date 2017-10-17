<div class="image-buttons row">
    <?php foreach ($items as $item => $attributes): ?>
        <img src="<?php echo base_url(); ?>assets/<?php echo WYVERN_ASSET_FOLDER; ?>/images/image-buttons/<?php echo $attributes['img']; ?>" class="img-responsive image-button" />
    <?php endforeach; ?>
</div>
<div class="clearfix"></div>
