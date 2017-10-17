<?php
/* Lets See If This Dude Can Get A Reward */
$CI = & get_instance();

$total_count_of_closed_deals = 0;

$CI->load->model('wyvern_entity_model', '_model')->init('closed_deals');


$participant_id = $this->session->userdata('participant_id');
$filters = array(
    'closed_deals_participant_id' => $participant_id
);

$participants_closed_deals = $CI->_model->filter($filters);


// Lets get the sum

foreach ($participants_closed_deals as $closed_deal) {
    $total_count_of_closed_deals = $total_count_of_closed_deals + abs($closed_deal['closed_deals_tablet_sku_quantity']);
    // $total_count_of_closed_deals = $total_count_of_closed_deals + abs($closed_deal['closed_deals_tablet_mtm_quantity']);
}

$rewards = array(
    '1000' => array(
        'reward_title' => '3D / 2N Trip to Yamato Lab',
    ),
    '300' => array(
        'reward_title' => '3D / 2N Trip to Balesin Island and taste the infamous Yaya Meals',
    ),
    '200' => array(
        'reward_title' => 'Lenovo E10-30',
    ),
    '100' => array(
        'reward_title' => 'Lenovo Miix 3 8" Tablet',
    )
);

foreach ($rewards as $margin => $details) {
    if (abs($margin) <= $total_count_of_closed_deals) {
        $reward_key = $margin;
        break;
    }
}

if (isset($reward_key)) {
    $congrats = "Congratulations you are eligible for <strong>{$rewards[$reward_key]['reward_title']}</strong>, please contact us @here.com or 999-9999-999 for more claim your prize and more details!";
} else {
    $congrats = "Keep logging your closed deals for a chance to win!";
}
?>

You have registered <strong><?php echo $total_count_of_closed_deals; ?></strong> units sold.
<br/>
<?php echo $congrats; ?>
