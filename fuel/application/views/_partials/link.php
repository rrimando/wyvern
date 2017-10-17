<?php if ($multiple) : ?>
    <?php $links = explode(",", $url); ?>
    <?php $link_titles = explode(",", $link_title); ?>
    <?php $count = 0; ?>

    <ul>
        <?php foreach ($links as $link): ?>
            <li>
                <a href="<?php echo $link; ?>" target="_blank">
                    <?php echo $link_titles[$count]; ?>
                </a>
            </li>
            <?php $count++; ?>
        <?php endforeach; ?>
    </ul>

<?php else: ?>

    <a href="<?php echo $url; ?>" target="_blank">
        <?php echo $link_title; ?>
    </a>

<?php endif; ?>

