<?php
/***********************************
 HERE YOU CAN CHECK OR CHANGE YOUR DATA BEFORE IMPORT
************************************/

function parse_csv_data(&$row) {
	global $bindings, $languages_ids, $config;
	
	/*
		decimal correction based on locale, set decimal_point and thousand_sep in admin/csv_import/csv_import.ini file if this doesn't work
	*/
	// price correction
	$row[$bindings['products']['products_price']] = str_replace($config['settings']['thousands_sep'], '', $row[$bindings['products']['products_price']]);
	$row[$bindings['products']['products_price']] = str_replace($config['settings']['decimal_point'], '.', $row[$bindings['products']['products_price']]);

	// weight correction
	$row[$bindings['products']['products_weight']] = str_replace($config['settings']['thousands_sep'], '', $row[$bindings['products']['products_weight']]);
	$row[$bindings['products']['products_weight']] = str_replace($config['settings']['decimal_point'], '.', $row[$bindings['products']['products_weight']]);
	
	/* 
		NEW LINE chars conversion to <br> HTML tags 
	*/
	foreach($languages_ids as $l_code => $l_id) {
		$l_col = $bindings['products_description'][$l_code]['products_description'];
		$row[$l_col] = nl2br($row[$l_col]);
	}
}
?>