<div id="single_project">
    <div class="single_project_inner_wrap">
        <?php
        // Fetch Projects
        $CI = & get_instance();

        $CI->load->model('wyvern_entity_model', '_projects')->init('project');
å
        $CI->load->model('wyvern_entity_model', '_project_costs')->init('project_costs');

        $project_id = $CI->uri->segment(3);

        if (isset($project_id)) {
            // function filter($filter = array(), $like = false, $fetch_unique_id = false, $override = false) 
            $project = $CI->_projects->filter(array('project_id' => $project_id), false, false, true);
            // function filter($filter = array(), $like = false, $fetch_unique_id = false, $override = false) 
            $project_costs = $CI->_project_costs->filter(array('project_parent_id' => $project_id), false, false, true);
        } else {
            echo "We couldn'f find what you need";
        }
        ?>

        <?php if (isset($project_id)): ?>
            <div class="text-content">
                <label>Project Name:</label> <?php echo $project[0]['project_name']; ?><br/>
                <label>Teacher Name:</label> <?php echo $project[0]['teacher_name']; ?><br/>
                <label>School Name:</label> <?php echo $project[0]['school_name']; ?><br/>
                <label>Location:</label> <?php echo $project[0]['school_location']; ?><br/>
            </div>

            <div class="buttons">
                <div class="fb-like" data-href="<?php echo site_url('page/single_project/' . $project[0]['project_id']); ?>" data-width="200" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
                <div class="clearfix"></div>
                <!-- Button trigger modal -->
                <span href="#" data-toggle="modal" data-target="#donate">
                    <img src="<?php echo base_url(); ?>assets/<?php echo WYVERN_ASSET_FOLDER; ?>/images/donate.png" alt="<?php echo WYVERN_SITE_NAME; ?>" width="80"/>
                </span>
                <!-- Button trigger modal -->
                <span href="#" onclick="goBack();">
                    <img src="<?php echo base_url(); ?>assets/<?php echo WYVERN_ASSET_FOLDER; ?>/images/back.png" alt="<?php echo WYVERN_SITE_NAME; ?>" width="80"/>
                </span>

            </div>

            <div class="clearfix"></div>

            <hr class="horizontal-separator" />

            <div class="project-desciption">
                <span class="image">
                    <?php get_file($project[0]['class_photo']); ?>
                </span>
                <?php echo nl2br($project[0]['about_project']); ?>
            </div>

            <div class="clearfix"></div>

            <hr class="horizontal-separator" />

            <div class="post">
                <div class="post-content">
                    <h3 class="project-needs">Project Needs</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="costs">
                <?php if (empty($project_costs)): ?>
                    No Costs Listed For This Project
                <?php else: ?>
                    <?php
                    $CI->load->model('wyvern_table_model');

                    $table_headers = $project_costs[0];
                    unset($table_headers['project_costs_id']);
                    unset($table_headers['project_parent_id']);

                    $project_costs_table = $CI->wyvern_table_model->render($table_headers, $project_costs, false, false, array('class' => 'table-bordered'));

                    $total = 0;

                    foreach ($project_costs as $cost) {
                        $total = $total + abs($cost['project_costs_unit_total']);
                    }
                    ?>
                    <?php echo $project_costs_table; ?>
                <?php endif; ?>
            </div>
            <?php if (isset($total)): ?>
                <div class="total">
                    <label>TOTAL:</label>
                    <?php echo number_format($total, 2); ?>
                </div>
            <?php endif; ?>


        <?php else: ?>
            No Project Found
        <?php endif; ?>
    </div>
</div>

