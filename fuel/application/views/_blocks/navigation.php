<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top transparent" role="navigation">
    <div class="container">
        <div class="collapse navbar-collapse" >
            <?php if ($this->wyvern_page_model->login_required) : ?>
                <?php if (is_logged()): ?>
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
                <?php endif; ?>
            <?php else: ?>
                <ul class="nav navbar-nav">
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
            <?php endif; ?>
            <?php if (is_logged()): ?>
                <ul class="nav navbar-nav pull-right">
                    <li>
                        <a href="<?php echo base_url() ?>logout" class="logout-link">Logout</a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="nav navbar-nav pull-right">
                    <?php if (defined('WYVERN_ENABLE_USER_SIGNUP') && WYVERN_ENABLE_USER_SIGNUP == true): ?>
                        <li>
                            <a href="<?php echo base_url() ?>register" class="signup-link">Sign up</a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?php echo base_url() ?>login" class="login-link">Login</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>">
                            <?php $this->wyvern_page_model->render_partial('logo'); ?>
                        </a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
