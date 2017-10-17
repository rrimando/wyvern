<?php
$CI = & get_instance();

$participant_id = $CI->uri->segment(4);

if (!$participant_id) {
    echo "No User With That ID";
}


// Fetch User Data
$CI->load->model('wyvern_entity_model', '_participant_model')->init('participant');
$CI->load->model('wyvern_table_model');
$participant = $CI->_participant_model->filter(array('participant_id' => $participant_id));
// render($table_headers, $table_data = array(), $table_controls = false, $table_entity = '', $table_attributes = array())
$details = ($participant) ? $CI->wyvern_table_model->render($participant[0], $participant, true, 'participant', array('class' => 'table-bordered')) : 'No User Found';


// Fetch User Institutions
$CI->load->model('wyvern_entity_model', '_institutions_model')->init('institution');
$institutions = $CI->_institutions_model->filter(array('participant_id' => $participant_id));
$institutions_table = ($institutions) ? $CI->wyvern_table_model->render($institutions[0], $institutions, true, 'institution', array('class' => 'table-bordered')) : 'No Records Found';

// Fetch User Pipelines
$CI->load->model('wyvern_entity_model', '_pipeline_model')->init('pipeline');
$pipelines = $CI->_pipeline_model->filter(array('pipeline_participant_id' => $participant_id));
$pipelines_table = ($pipelines) ? $CI->wyvern_table_model->render($pipelines[0], $pipelines, true, 'pipeline', array('class' => 'table-bordered')) : 'No Records Found';

// Fetch User Closed Deals
$CI->load->model('wyvern_entity_model', '_closed_deals_model')->init('closed_deals');
$closed_deals = $CI->_closed_deals_model->filter(array('closed_deals_participant_id' => $participant_id));
$closed_deals_table = ($closed_deals) ? $CI->wyvern_table_model->render($closed_deals[0], $closed_deals, true, 'closed_deals', array('class' => 'table-bordered')) : 'No Records Found';
?>
<div class="clearfix"></div>
<h2>User Summary</h2>
<div class="clearfix"></div>
<hr/>
<h4>Details</h4>
<?php echo $details; ?>
<hr/>
<h4>Institutions</h4>
<?php echo $institutions_table; ?>
<hr/>
<h4>Pipelines</h4>
<?php echo $pipelines_table; ?>
<hr/>
<h4>Closed Deals</h4>
<?php echo $closed_deals_table; ?>
