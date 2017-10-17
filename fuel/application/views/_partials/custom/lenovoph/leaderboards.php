<?php

$CI = & get_instance();

$show_top = 20;

// Loading all users
$CI->load->model('wyvern_entity_model', '_model_closed_deals')->init('closed_deals');
$CI->load->model('wyvern_data_block');
$closed_deals = $CI->_model_closed_deals->fetch();

$sorted_users = array();

foreach ($closed_deals as $row_data) {

    if (!isset($sorted_users[$row_data['closed_deals_participant_id']]['closed_deals_sales'])) {
        $sorted_users[$row_data['closed_deals_participant_id']]['closed_deals_sales'] = 0;
    }

    $sorted_users[$row_data['closed_deals_participant_id']]['closed_deals_sales'] = abs($sorted_users[$row_data['closed_deals_participant_id']]['closed_deals_sales']) + abs($row_data['closed_deals_tablet_sku_quantity']);
    $sorted_users[$row_data['closed_deals_participant_id']]['name'] = $CI->wyvern_data_block->fetch_single_entity_value($get = 'name', $get_by = 'participant_id', $get_with = $row_data['closed_deals_participant_id'], $get_from = 'participant');
    $sorted_users[$row_data['closed_deals_participant_id']]['summary'] = "<a href='" . site_url('reports/view/user_summary/'.$row_data['closed_deals_participant_id']) ."'>View</a>";
}

usort($sorted_users, function($a, $b) {
    return $b['closed_deals_sales'] - $a['closed_deals_sales'];
});

$CI->load->model('wyvern_table_model');

$top_sellers = array_slice($sorted_users, 0, $show_top);
$leaderboards = $CI->wyvern_table_model->render($sorted_users[0], $top_sellers);
?>

<h2>Leader Boards</h2>
<div class="clearfix"></div>
<?php echo $leaderboards; ?>
