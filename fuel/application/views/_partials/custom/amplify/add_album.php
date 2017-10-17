<?php
// Reaching out to muthafucking codeigniter :D 
$CI = & get_instance();
?>
<div class="container" id="add-album">
    <?php // session_dump(); ?>
    <?php // nice_dump($partials); ?>
    <?php display_constants(); ?>
    <div class="left">
        <div class="album-details panel panel-default">
            <div class="album-name panel-heading">Untitled Album</div>
            <div class="album-art-thumbnail"></div>
            <div class="album-content-details">
                <div class="album-artist">by <strong><?php echo ucwords($this->session->userdata('artist_band_name')); ?></strong></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="tracks">
            <?php echo $CI->wyvern_blocks_model->__partial('add_track_form'); ?>
        </div>
    </div>
    <div class="right">
        <?php echo $CI->wyvern_blocks_model->__partial('add_album_form'); ?>
    </div>
    <div class="clearfix"></div>
</div>
