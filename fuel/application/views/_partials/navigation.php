<!-- Navigation -->
<nav class="navbar navbar-inverse" role="navigation">
    <div class="container">
        <div class="collapse navbar-collapse" >
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?php echo base_url() ?>">
                        <?php $this->wyvern_page_model->render_partial('logo'); ?>
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
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
