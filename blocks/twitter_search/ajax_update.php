<?php 
require_once('../../config.php');
$block = block_instance('twitter_search', get_record_select('block_instance','id="'.required_param("blockid",PARAM_NUMBER).'"'));
echo $block->get_content()->text
?>
