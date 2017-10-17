<?php
$CI = & get_instance();

$CI->load->model('wyvern_table_model');

/* Reports Custom File */

// Pipeline
$CI->load->model('wyvern_entity_model', '_model_pipeline')->init('pipeline');
$pipeline_deals = $CI->_model_pipeline->fetch();

// Total Items On Pipeline 
$total_pipeline = 0;
// Items Sorted By SKU
$sorted_items_by_sku = array();
// $sorted_items_by_mtm = array();

foreach ($pipeline_deals as $deal) {
    // Total Items On Pipeline 
    $total_pipeline = $total_pipeline + abs($deal['pipeline_tablet_sku_quantity']);
    // $total_pipeline = $total_pipeline + abs($deal['pipeline_tablet_mtm_quantity']);
    // Items Sorted By SKU
    if (!isset($sorted_items_by_sku[$deal['pipeline_tablet_sku_id']])) {
        $sorted_items_by_sku[$deal['pipeline_tablet_sku_id']] = 0;
    }

    /* if (!isset($sorted_items_by_mtm[$deal['pipeline_tablet_mtm_id']])) {
        $sorted_items_by_mtm[$deal['pipeline_tablet_mtm_id']] = 0;
    } */

    $sorted_items_by_sku[$deal['pipeline_tablet_sku_id']] = $sorted_items_by_sku[$deal['pipeline_tablet_sku_id']] + abs($deal['pipeline_tablet_sku_quantity']);
    // $sorted_items_by_mtm[$deal['pipeline_tablet_mtm_id']] = $sorted_items_by_mtm[$deal['pipeline_tablet_mtm_id']] + abs($deal['pipeline_tablet_mtm_quantity']);
}

//render($table_headers, $table_data = array(), $table_controls = false, $table_entity = '', $table_attributes = array())
$headers = array('pipeline_tablet_sku_id', 'Qty');
$sorted_items_by_sku_table = $CI->wyvern_table_model->render_simplified_table($headers, $sorted_items_by_sku);
// $sorted_items_by_mtm_table = $CI->wyvern_table_model->render_simplified_table($headers, $sorted_items_by_mtm);

/* * **************************************************** */

// Total Items Closed
$total_closed_deals = 0;
// Items Sorted By SKU
$closed_deal_sorted_items_by_sku = array();
// $closed_deal_sorted_items_by_mtm = array();

$CI->load->model('wyvern_entity_model', '_model_closed_deals')->init('closed_deals');
$closed_deals = $CI->_model_closed_deals->fetch();

foreach ($closed_deals as $deal) {
    // Items Sorted By SKU
    $total_closed_deals = $total_closed_deals + abs($deal['closed_deals_tablet_sku_quantity']);
    // $total_closed_deals = $total_closed_deals + abs($deal['closed_deals_tablet_mtm_quantity']);
    // Items Sorted By SKU
    if (!isset($closed_deal_sorted_items_by_sku[$deal['closed_deals_tablet_sku_id']])) {
        $closed_deal_sorted_items_by_sku[$deal['closed_deals_tablet_sku_id']] = 0;
    }

    /* if (!isset($closed_deal_sorted_items_by_mtm[$deal['closed_deals_tablet_mtm_id']])) {
        $closed_deal_sorted_items_by_mtm[$deal['closed_deals_tablet_mtm_id']] = 0;
    } */

    $closed_deal_sorted_items_by_sku[$deal['closed_deals_tablet_sku_id']] = $closed_deal_sorted_items_by_sku[$deal['closed_deals_tablet_sku_id']] + abs($deal['closed_deals_tablet_sku_quantity']);
    // $closed_deal_sorted_items_by_mtm[$deal['closed_deals_tablet_mtm_id']] = $closed_deal_sorted_items_by_mtm[$deal['closed_deals_tablet_mtm_id']] + abs($deal['closed_deals_tablet_mtm_quantity']);
}

$closed_deals_sorted_items_by_sku_table = $CI->wyvern_table_model->render_simplified_table($headers, $closed_deal_sorted_items_by_sku);
// $closed_deals_sorted_items_by_mtm_table = $CI->wyvern_table_model->render_simplified_table($headers, $closed_deal_sorted_items_by_mtm);

// Total Registered Users
$CI->load->model('wyvern_entity_model', '_model_participants')->init('participant');
$users = $CI->_model_participants->fetch();

$total_user_count = count($users);
?>
<h2>Overview</h2>
<div class="clearfix"></div>
<hr/>
<br/>
<h4><label>Total Pipeline Items:</label>
    <strong><?php echo $total_pipeline; ?></strong></h4>
<br/>
<h4>Items by SKU</h4>
<?php echo $sorted_items_by_sku_table; ?>
<br/>

<?php /* 
<h4>Items by MTM</h4>
<?php echo $sorted_items_by_mtm_table; ?>
 * 
 */ ?>
<hr/>
<br/>
<h4><label>Total Closed Deals Items:</label>
    <strong><?php echo $total_closed_deals; ?></strong></h4>
<br/>
<h4>Items by SKU</h4>
<?php echo $closed_deals_sorted_items_by_sku_table; ?>
<br/>
<?php /*
<h4>Items by MTM</h4>
<?php echo $closed_deals_sorted_items_by_mtm_table; ?>
 * 
 */ ?>
<hr/>
<br/>
<h4><label>Number of Registered Users:</label>
    <strong><?php echo $total_user_count; ?></strong></h4>







