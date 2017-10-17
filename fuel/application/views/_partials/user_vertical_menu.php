<nav class="transparent">
    <ul class="nav">
        <li class="sidebar-brand">
            <a href="#">
                <?php echo WYVERN_SITE_NAME; ?> Dashboard
            </a>
        </li>
        <?php
        $nav = explode(',', WYVERN_PAGES);
        ?>
        <?php if (!empty($nav)): ?>
            <?php foreach ($nav as $page): ?>
                <li>
                    <a href="<?php echo base_url() . str_replace(" ", "_", strtolower($page)); ?>"><?php echo ucwords(get_top_level($page, "/")); ?></a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>

        <li>
            <a href="<?php echo base_url() ?>logout" class="logout-link">Logout</a>
        </li>                            
    </ul>
</nav>


