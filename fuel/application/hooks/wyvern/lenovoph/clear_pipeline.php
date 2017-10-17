<?php

$CI = & get_instance();

$CI->load->model('wyvern_entity_model', '_pipeline')->init('pipeline');

$pipeline_target = array(
    'pipeline_participant_id' => $entity_data['closed_deals_participant_id'],
    'pipeline_institution_id' => $entity_data['closed_deals_institution_id'],
    'tablet_sku_id' => $entity_data['closed_deals_tablet_sku_id']
);

$pipeline_result = $CI->_pipeline->filter($pipeline_target, false);

if (isset($pipeline_result[0])) {

    $resulting_quantity = $pipeline_result[0]['pipeline_tablet_sku_quantity'] - $entity_data['closed_deals_tablet_sku_quantity'];

    if ($resulting_quantity > 0) {
        // Update the pipeline
        $pipeline_unique_id = $CI->_pipeline->filter($pipeline_target, false, true);
        $CI->_pipeline->update($pipeline_unique_id[0]['unique_id'], array('pipeline_tablet_sku_quantity' => $resulting_quantity));
    } else {
        $CI->_pipeline->delete($pipeline_result[0]);
    }
}
