<?php if (defined('WYVERN_CAROUSEL') && (WYVERN_CAROUSEL)): ?>
    <div id="<?php echo $id; ?>" class="carousel<?php echo isset($type) ? " " . $type : ' slide'; ?><?php echo isset($class) ? " " . $class : ''; ?>" data-ride="carousel">

        <?php
        if (isset($data)) {
            $_items = fetch_site_variable('all', $data);
            $items = array();

            foreach ($_items as $item_array) {
                $items[] = array(
                    //get_file($file, $alt = WYVERN_SITE_NAME, $class = 'image', $id = '', $variable = false)
                    'img' => $item_array['carousel_file'],
                    'header_caption' => isset($item_array['carousel_caption_title']) ? $item_array['carousel_caption_title'] : '',
                    'caption' => isset($item_array['carousel_caption']) ? $item_array['carousel_caption'] : ''
                );
            }
        }
        ?>
        <?php if (count($items)): ?>
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php
                $counter = 0;
                foreach ($items as $item => $item_attr):
                    ?>
                    <li data-target="#<?php echo $id; ?>" data-slide-to="<?php echo $counter; ?>"></li>
                    <?php
                    $counter++;
                endforeach;
                ?>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <?php foreach ($items as $item => $item_attr): ?>
                    <div class="item">
                        <?php if (isset($data)): ?>
                            <?php get_file($item_attr['img'], isset($item_array['carousel_caption_title']) ? $item_array['carousel_caption_title'] : '', 'carousel-image', false, true); ?>
                        <?php else: ?>
                            <img src="<?php echo base_url(); ?>assets/<?php echo WYVERN_ASSET_FOLDER; ?>/images/carousel/<?php echo $item_attr['img']; ?>" alt="<?php echo $item_attr['header_caption']; ?>">
                        <?php endif; ?>
                        <div class="carousel-caption<?php echo isset($caption_class) ? ' ' . $caption_class : ' transparent'; ?>">
                            <h4><?php echo $item_attr['header_caption']; ?></h4>
                            <p>
                                <?php echo $item_attr['caption']; ?>
                            </p>    
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#<?php echo $id; ?>" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#<?php echo $id; ?>" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>
