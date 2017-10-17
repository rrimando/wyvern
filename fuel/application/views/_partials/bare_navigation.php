
<!-- Navigation -->
<ul class="nav navbar-nav">
    <?php
    $nav = explode(',', WYVERN_PAGES);
    ?>
    <?php if (!empty($nav)): ?>
        <?php foreach ($nav as $page): ?>
            <?php $unpretty_name = str_replace(" ", "-", strtolower(get_top_level($page, "/"))); ?>
            <?php $active_name = str_replace(" ", "_", strtolower(get_top_level($page, "/"))); ?>
    
            <li class="li-<?php echo $unpretty_name; ?><?php echo ($this->wyvern_page_model->page == $active_name) ? " active" : ''; ?>" onclick="window.location.href = '<?php echo site_url(str_replace(" ", "_", strtolower($page))); ?>'">
                <a href="<?php echo site_url(str_replace(" ", "_", strtolower($page))); ?>"<?php echo ($this->wyvern_page_model->page == $active_name) ? " class='active'" : ''; ?>>
                    
                    <?php echo ucwords(get_top_level($page, "/")); ?>
                </a>
            </li>
        <?php endforeach; ?>
        <?php if (defined('WYVERN_LOGIN_ENABLED')): ?>
            <?php if (is_logged()): ?>
            
                <li>
                    <a href="<?php echo base_url() ?>logout" class="logout-link">Logout</a>
                </li>  
            <?php else: ?>
                
                <li>
                    <a href="<?php echo base_url() ?>login" class="login-link">Login</a>
                </li>  
            <?php endif; ?>    
        <?php endif; ?>
    <?php endif; ?>
                
</ul>
