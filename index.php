<?php
	
	include_once 'utils/TransactionLayer.php';

	// Instanciate Transaction Layer
	$trans_inst = TransactionLayer::instance();

	// Get query result
	$query_result = $trans_inst->post_query($argv);

	// Return query result
	print_r($query_result);

?>
