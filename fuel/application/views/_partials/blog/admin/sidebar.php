<?php
$CI = & get_instance();
$CI->load->model('wyvern_entity_model', '_pages')->init('page');
$CI->load->model('wyvern_entity_model', '_posts')->init('post');

$pages = $CI->_pages->fetch();
$posts = $CI->_pages->fetch();
?>

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                <!-- /input-group -->
            </li>
            <li>
                <a href="<?php echo site_url('admin'); ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <!-- REPORTS -->
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Reports<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <?php if (isset($reports) && !empty($reports)): ?>
                        <?php foreach ($reports as $report): ?>
                            <li>
                                <a href="<?php echo site_url('reports/view/' . $report) ?>">
                                    <i class="fa fa-eye fa-fw"></i> <?php echo ucwords(str_replace("_", " ", $report)); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>
                            <a href="javascript:void(0)"><i class="fa fa-exclamation-triangle fa-fw"></i> No Reports Have Been Setup <br/><small>Contact info@pixeljump.com.ph for more details</small></a>
                        </li>
                    <?php endif; ?>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <!-- PAGES -->
            <li>
                <a href="#"><i class="fa fa-files-o fa-fw"></i> Pages<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?php echo site_url('entity/page/create'); ?>"><i class="fa fa-pencil fa-fw"></i> Add A Page</a>
                    </li>
                    <?php if ($pages): ?>
                        <?php foreach ($pages as $page): ?>
                            <li>
                                <a href="<?php echo site_url('entity/edit/page/' . $page['page_id']); ?>"><i class="fa fa-edit fa-fw"></i> <?php echo $page['page_title']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <!-- POSTS -->
            <li>
                <a href="#"><i class="fa fa-files-o fa-fw"></i> Posts<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?php echo site_url('entity/post/create'); ?>"><i class="fa fa-pencil fa-fw"></i> Add A Post</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('entity/post/View'); ?>"><i class="fa fa-eye fa-fw"></i> View Posts</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <!-- SETTINGS -->
            <li>
                <a href="<?php echo site_url('entity/edit/site_settings/1'); ?>"><i class="fa fa-gear fa-fw"></i> Settings</a>
            </li>
            <!-- ENTITIES -->
            <li>
                <a href="javascript:void(0)"><i class="fa fa-table fa-fw"></i> Entities<span class="fa arrow"></span></a>
                <?php foreach ($entities as $entity): ?>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="javascript:void(0)"><i class="fa fa-table fa-fw"></i><?php echo ucwords(str_replace("_", " ", $entity)); ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li><a href="<?php echo base_url(); ?>entity/<?php echo $entity; ?>/view">View</a></li>
                                <li><a href="<?php echo base_url(); ?>entity/<?php echo $entity; ?>/create">Add</a></li>
                                <?php if (WYVERN_ENTITY_DEBUG): ?>
                                    <li><a href="<?php echo base_url(); ?>entity/<?php echo $entity; ?>/define">Entity Definition</a></li>
                                    <li><a href="<?php echo base_url(); ?>entity/<?php echo $entity; ?>/reset_entity">Reset Entity</a></li>
                                    <li><a href="<?php echo base_url(); ?>entity/<?php echo $entity; ?>/create_test_data">Create Test Data</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                    <?php if (WYVERN_ENTITY_DEBUG): ?>
                    </ul>
                <li><a href="<?php echo base_url(); ?>entity/<?php echo $entity; ?>/clear_entity_tables"><strong>Clear Entity Tables</strong></a></li>
            <?php endif; ?>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
