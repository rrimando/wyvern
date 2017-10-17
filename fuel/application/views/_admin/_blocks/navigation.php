<?php if (is_admin_logged()): ?>
    <!-- Navigation -->
    <nav class="admin navbar navbar-inverse navbar-fixed-top transparent" role="navigation">
        <div class="container">
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php
                    $nav = explode(',', WYVERN_ADMIN_PAGES);
                    ?>
                    <?php if (!empty($nav)): ?>
                        <?php foreach ($nav as $page): ?>
                            <li>
                                <a href="<?php echo base_url() . strtolower($page); ?>"><?php echo ucwords(str_replace("_", " ", get_top_level($page, "/"))); ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <?php if (is_admin_logged()): ?>      
                    <ul class="nav navbar-nav pull-right">
                        <li>
                            <a href="<?php echo base_url() ?>logout" class="logout-link">Logout</a>
                        </li>   
                    </ul>
                <?php endif; ?>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
<?php else: ?>
    <nav class="navbar navbar-inverse navbar-fixed-top transparent" role="navigation">
        <div class="container">
            <div class="collapse navbar-collapse" >
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?php echo base_url() ?>/login">
                            &laquo; Back
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php endif; ?>
