<?php
require('includes/application_top.php');

/*
	register globals emulation
*/
if(!intval(ini_get('register_globals')) || !isset($action)) {
	foreach($HTTP_GET_VARS as $k => $v) {
		if(!isset($$k)) {
			$$k = $v;
		}
	}
	
	foreach($HTTP_POST_VARS as $k => $v) {
		if(!isset($$k)) {
			$$k = $v;
		}
	}
}

if(!isset($action)) {
	$action = '';
}

/***************************** SETTINGS ********************************/

/* Configuration file */
define('CSV_IMPORT_FOLDER', 'csv_import/');
define('CSV_IMPORT_INI_FILE', CSV_IMPORT_FOLDER . 'csv_import.ini');
$config = parse_ini_file(CSV_IMPORT_INI_FILE, true);

/* 	
	CORRECT_FIELDS_COUNT 
	true: it corrects the field count if there's a mismatch (last fields missing)
	false: it skips the import if there's a field count mismatch 
*/
define("CORRECT_FIELDS_COUNT", (isset($config["settings"]["correct_fields_count"]) && $config["settings"]["correct_fields_count"] == 1)); 

/* 
	upload folder, must have write permissions
*/
define('CSV_IMPORT_UPLOAD_FOLDER', CSV_IMPORT_FOLDER . $config["settings"]["csv_upload_folder"] . '/');
define('CSV_IMPORT_PHP_FILE', basename($PHP_SELF));
define('CSV_DEBUG', (isset($config["settings"]["debug"]) && $config["settings"]["debug"]));

switch($action) {
	case 'config':
		define('CSV_IMPORT_INI_COMMENTS_FILE', CSV_IMPORT_FOLDER . 'csv_import.comments.ini');
		$comments = parse_ini_file(CSV_IMPORT_INI_COMMENTS_FILE, true);
	break;
	
	case 'config_save':
		if($h = fopen(CSV_IMPORT_INI_FILE . '.tmp', 'wb')) {
			foreach($_POST['config'] as $section => $values) {
				fwrite($h, "\n\n[$section]\n");
				foreach($values as $key => $value) {
					fwrite($h, "\n$key = \"" . str_replace('"', "", trim(stripslashes($value))) . "\"");
				}
			}
			
			copy(CSV_IMPORT_INI_FILE . '.tmp', CSV_IMPORT_INI_FILE);
			@unlink(CSV_IMPORT_INI_FILE . '.tmp');
			csv_import_message(CSV_ACTION_DONE, 'success');
			tep_redirect(CSV_IMPORT_PHP_FILE . '?action=config');
		}
	break;

	case 'delete':
		@unlink(CSV_IMPORT_UPLOAD_FOLDER.$file);
		tep_redirect(CSV_IMPORT_PHP_FILE);
	break;
	
	case 'upload':
		$file = new upload('csvfile', CSV_IMPORT_UPLOAD_FOLDER, '777', array('csv','txt'));
		tep_redirect(CSV_IMPORT_PHP_FILE);
	break;
	
	case 'empty':
		if((bool)$config['settings']['allow_empty_db']) {
			tep_db_query('TRUNCATE `' . TABLE_PRODUCTS . '`');
			tep_db_query('TRUNCATE `' . TABLE_PRODUCTS_ATTRIBUTES . '`');
			tep_db_query('TRUNCATE `' . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . '`');
			tep_db_query('TRUNCATE `' . TABLE_PRODUCTS_DESCRIPTION . '`');
			tep_db_query('TRUNCATE `' . TABLE_PRODUCTS_NOTIFICATIONS . '`');
			tep_db_query('TRUNCATE `' . TABLE_PRODUCTS_OPTIONS . '`');
			tep_db_query('TRUNCATE `' . TABLE_PRODUCTS_OPTIONS_VALUES . '`');
			tep_db_query('TRUNCATE `' . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . '`');
			tep_db_query('TRUNCATE `' . TABLE_PRODUCTS_TO_CATEGORIES . '`');
			
			csv_import_exit(CSV_ACTION_DONE, 'success');
		}
		else {
			tep_redirect(CSV_IMPORT_PHP_FILE);
		}
	break;
	
	case 'view':
		$file = CSV_IMPORT_UPLOAD_FOLDER . $file;
		if(file_exists($file)) {
			$size = filesize($file);
			header("Content-type: application/x-octet-stream");
			header("Content-Length: $size");
			header("Content-Disposition: attachment; filename=$file");
			readfile($file);		
			exit();
		}
	break;
	
	case 'import':
		/* BINDINGS */ 
		$bindings = array();
		$bindings['products'] = $config["products"];
		$bindings['products_description'] = $config["products_description"];
		$bindings['categories'] = $config["categories"];
		$bindings['manufacturers'] = $config["manufacturers"];

		/* COLUMN HEADERS */
		$csv_headers_tmp = explode($config["csv"]["columns_headers_delimiter"], $config["csv"]["columns_headers"]);

		$csv_headers = array();
		foreach($csv_headers_tmp as $h) {
			$csv_headers[] = trim($h);
		}

		/* FIELDS COUNT */
		$csv_fields_count = count($csv_headers);

		/* LANGUAGES */
		$installed_languages = tep_db_query('SELECT languages_id, code FROM ' . TABLE_LANGUAGES);	
		
		$languages_ids = array();
		while($l_row = tep_db_fetch_array($installed_languages)) {
			$languages_ids[$l_row['code']] = $l_row['languages_id'];
		}

		/* FILE CHECKING */
		$file = CSV_IMPORT_UPLOAD_FOLDER . basename($GLOBALS['file']);
		
		if(!is_file($file)) {
			csv_import_exit(sprintf(CSV_INVALID_FILE_ERROR, $file));
		}
		
		if(!is_readable($file)) {
			csv_import_exit(sprintf(CSV_FILE_READ_PERMISSIONS_ERROR, $file));
		}
		
		decode_bindings($bindings);

		/* CSV PREPROCESSING */
		require(CSV_IMPORT_FOLDER . 'data_parsing.php');
		
		$handle = fopen($file,"r");
		$csv = array();
		$row = 1;
		$delimiter = (empty($config["csv"]["delimiter"]) ? "\t":$config["csv"]["delimiter"]);
		$enclosure = (empty($config["csv"]["enclosure"]) ? '"':$config["csv"]["enclosure"]);

		while(($data = fgetcsv($handle, 10000, $delimiter, $enclosure)) !== false) {
		    $row_fields_count = count($data);

			if($row == 1 && !$csv_fields_count) {
				$csv_fields_count = $row_fields_count;
			}
			elseif($row > 1 && $row_fields_count != $csv_fields_count) {
				if(CORRECT_FIELDS_COUNT && abs($row_fields_count - $csv_fields_count) <= (int)$config['settings']['correct_fields_radius']) {
					$data = array_pad($data, $csv_fields_count, "");
				}
				else {
					csv_import_exit(sprintf(CSV_FIELDS_MATCH_ERROR,$row), 'error');
				}
			}

			if($row > 1) {
				parse_csv_data($data);
				$csv[] = $data;
			}

		    $row++;
		}

		fclose($handle);
		
		csv_import($csv);
		csv_import_exit(CSV_IMPORT_DONE, 'success');
	break;
}

function decode_bindings(&$bindings) {
	global $config, $languages_ids;
	
	$descriptions = $bindings['products_description'];
	$bindings['products_description'] = array();
	
	// names decoding
	$products_names_codes = explode(',', $descriptions['products_name']);
	foreach($products_names_codes as $v) {
		list($code, $col) = explode(':', $v);
		$bindings['products_description'][trim($code)]['products_name'] = trim($col);
	}

	// descriptions decoding
	$products_descriptions_codes = explode(',', $descriptions['products_description']);
	foreach($products_descriptions_codes as $v) {
		list($code, $col) = explode(':', $v);
		$bindings['products_description'][trim($code)]['products_description'] = trim($col);
	}

	foreach($languages_ids as $lang => $lang_id) {
		if(isset($bindings['products_description'][$lang]) && (!isset($bindings['products_description'][$lang]['products_name']) || !isset($bindings['products_description'][$lang]['products_description']))) {
			unset($bindings['products_description'][$lang]);
		}	
	}
}

function csv_import(&$data) {
	global $bindings, $languages_ids, $config;

	$n = count($data);
	$skipped = array();
	$categories_cache = array();
	for($i = 0; $i < $n; $i++) {
		foreach($data[$i] as $col => $value) {
			$data[$i][$col] = trim($value);	
		}

		$fields = array();
		foreach($bindings['products'] as $field => $pos) {	
			$fields[$field] = tep_db_input($data[$i][$pos]);
		}

// categories
		$cId = array();	
		$categories = trim($data[$i][$bindings['categories']['categories_id']]);
		
		$categories = explode($config['csv']['categories_delimiter'], $categories);
		foreach($categories as $c) {
			$c = trim($c);

			// category by ID
			if(is_numeric($c)) {
				$category_check_flag = tep_db_fetch_array(tep_db_query('SELECT COUNT(*) AS total FROM ' . TABLE_CATEGORIES . ' WHERE categories_id = ' . $c));
				if((int)$category_check_flag['total']) {
					$cId[] = $c;
				}
			}
			// category by name
			else {
				$subcats = explode($config['csv']['categories_subcat_delimiter'], $c);
				foreach($subcats as $k => $v) {
					if(!empty($v)) {
						$subcats[$k] = trim($v);
					}
				}

				$key = md5(strtolower(implode($config['csv']['categories_subcat_delimiter'], $subcats)));
				if(!isset($categories_cache[$key])) {
					$c_parent_id = 0;
					$category_language = (!empty($config['csv']['categories_language']) ? $config['csv']['categories_language']:DEFAULT_LANGUAGE);
					
					if(isset($languages_ids[$category_language])) {
						$category_language = $languages_ids[$category_language];
					}
					else {
						$category_language = $languages_ids[DEFAULT_LANGUAGE];
					}
					
					$c_error = false;
					foreach($subcats as $sc) {
						$subcat_query = tep_db_query("SELECT c.categories_id FROM " . TABLE_CATEGORIES . " c INNER JOIN " . TABLE_CATEGORIES_DESCRIPTION . " cd ON c.categories_id = cd.categories_id WHERE language_id = '$category_language' AND categories_name = '$sc' AND parent_id = '$c_parent_id'");
						if($subcat_query != null && tep_db_num_rows($subcat_query) == 1) {
							$fetched = tep_db_fetch_array($subcat_query);
							$c_parent_id = (int)$fetched['categories_id'];
						}
						elseif((bool)$config['settings']['auto_add_categories']) {
							$m_fields = array();
							$m_values = array();

							$m_fields[] = "`parent_id`";
							$m_values[] = "'" . (int)$c_parent_id . "'";
							
							$m_fields[] = "`date_added`";
							$m_values[] = "'".strftime('%Y-%m-%d %H:%M:%S',time())."'";
							
							$new_category_query = 'INSERT INTO ' . TABLE_CATEGORIES . ' ('.implode(',',$m_fields).') VALUES('.implode(',',$m_values).')';

							if(!tep_db_query($new_category_query)) {
								csv_import_message(sprintf(CSV_CATEGORY_INSERT_ERROR, $i, $sc), 'error');
								$skipped[$i] = $data[$i];
								continue;
							}

							$c_parent_id = tep_db_insert_id();
							
							foreach($languages_ids as $lang => $lang_id) {
								$m_fields = array(
									'`categories_id`',
									'`language_id`',
									'`categories_name`',
								);
								
								$m_values = array(
									"'$c_parent_id'",
									"'$lang_id'",
									"'$sc'",
								);
								
								$new_category_language_query = tep_db_query('INSERT INTO ' . TABLE_CATEGORIES_DESCRIPTION . ' ('.implode(',',$m_fields).') VALUES('.implode(',',$m_values).')');
							}
						}
						else {
							$c_error = true;
							break;
						}
					}
					
					if($c_error) {
						continue;
					}
					
					$categories_cache[$key] = $c_parent_id;
				}

				$cId[] = $categories_cache[$key];
			}
		}
		
		if(empty($cId)) {
			csv_import_message(sprintf(CSV_UNKNOWN_CATEGORY_ERROR,$i), 'error');
			$skipped[$i] = $data[$i];
			continue;
		}

// tax class
		if(isset($bindings['products']['products_tax_class_id']) && !empty($data[$i][$bindings['products']['products_tax_class_id']])) {
			$tax_class_id = 0;
			$tax_class = tep_db_input($data[$i][$bindings['products']['products_tax_class_id']]);
			if(is_numeric($tax_class)) {
				$tax_class_check = tep_db_query('SELECT tax_class_id FROM ' . TABLE_TAX_CLASS . ' WHERE tax_class_id = \'' . (int)$tax_class . '\'');
				if(tep_db_num_rows($tax_class_check) == 1) {
					$fetched = tep_db_fetch_array($tax_class_check);
					$tax_class_id = (int)$fetched['tax_class_id'];
				}			
			}
			else {
				$tax_class_check = tep_db_query('SELECT tax_class_id FROM ' . TABLE_TAX_CLASS . ' WHERE tax_class_title = \'' . $tax_class . '\'');
				$tax_class_count = tep_db_num_rows($tax_class_check);

				if($tax_class_count == 0) {
					$m_fields = array();
					$m_values = array();

					$m_fields[] = "`tax_class_title`";
					$m_values[] = "'" . $tax_class . "'";

					$m_fields[] = "`tax_class_description`";
					$m_values[] = "'" . $tax_class . "'";
					
					$m_fields[] = "`date_added`";
					$m_values[] = "'".strftime('%Y-%m-%d %H:%M:%S',time())."'";				

					$tax_class_query = 'INSERT INTO ' . TABLE_TAX_CLASS . ' (' . implode(',', $m_fields) . ') VALUES(' . implode(',', $m_values) . ')';
					
					if(!tep_db_query($tax_class_query)) {
						csv_import_message(sprintf(CSV_TAX_CLASS_INSERT_ERROR,$i), 'error');
						$skipped[$i] = $data[$i];
						continue;
					}
					
					$tax_class_id = tep_db_insert_id();					
				}
				elseif($tax_class_count == 1) {
					$tax_class_query = tep_db_fetch_array($tax_class_check);
					$tax_class_id = $tax_class_query['tax_class_id'];
				}
				else {
					csv_import_message(sprintf(CSV_TAX_CLASS_INSERT_ERROR,$i), 'error');
					$skipped[$i] = $data[$i];
					continue;			
				}
			}
			
			if($tax_class_id) {
				$fields['products_tax_class_id'] = $tax_class_id;
			}
		}
		
// manufacturer
		if(isset($bindings['manufacturers']['manufacturers_id']) && !empty($data[$i][$bindings['manufacturers']['manufacturers_id']])) {
			
			$manufacturer_id = 0;
			$manufacturer = tep_db_input($data[$i][$bindings['manufacturers']['manufacturers_id']]);
			if(is_numeric($manufacturer)) {
				$manufacturer_check = tep_db_query('SELECT manufacturers_id FROM ' . TABLE_MANUFACTURERS . ' WHERE manufacturers_id = \'' . (int)$manufacturer . '\'');
				if(tep_db_num_rows($manufacturer_check) == 1) {
					$fetched = tep_db_fetch_array($manufacturer_check);
					$manufacturer_id = (int)$fetched['manufacturers_id'];
				}
			}
			else {
				$manufacturer_check = tep_db_query('SELECT manufacturers_id FROM ' . TABLE_MANUFACTURERS . ' WHERE manufacturers_name = \'' . $manufacturer . '\'');
				$manufacturers_count = tep_db_num_rows($manufacturer_check);

				if($manufacturers_count == 0) {
					$m_fields = array();
					$m_values = array();

					$m_fields[] = "`manufacturers_name`";
					$m_values[] = "'" . $manufacturer . "'";
					
					$m_fields[] = "`date_added`";
					$m_values[] = "'".strftime('%Y-%m-%d %H:%M:%S',time())."'";				

					$manufacturers_query = 'INSERT INTO '.TABLE_MANUFACTURERS.' ('.implode(',',$m_fields).') VALUES('.implode(',',$m_values).')';
					
					if(!tep_db_query($manufacturers_query)) {
						csv_import_message(sprintf(CSV_MANUFACTURER_INSERT_ERROR,$i), 'error');
						$skipped[$i] = $data[$i];
						continue;
					}
					
					$manufacturer_id = tep_db_insert_id();
					
					foreach($languages_ids as $lang => $lang_id) {
						$m_fields = array();
						$m_values = array();					
						if(isset($manufacturers_info_fields) && count($manufacturers_info_fields) > 0) {				
							$m_lang_fields = $manufacturers_info_fields[$lang];
							foreach($m_lang_fields as $field => $pos) {	
								$m_fields[] = "`$field`";
								$m_values[] = "'".tep_db_input($data[$i][$pos])."'";
							}
						}
												
						$m_fields[] = '`manufacturers_id`';
						$m_values[] = "'$manufacturer_id'";
						
						$m_fields[] = '`languages_id`';
						$m_values[] = "'$lang_id'";

						$products_query = 'INSERT INTO '.TABLE_MANUFACTURERS_INFO.' ('.implode(',',$m_fields).') VALUES('.implode(',',$m_values).')';
						if(!tep_db_query($products_query)) {
							csv_import_message(sprintf(CSV_MANUFACTURER_INSERT_ERROR,$i), 'error');		
							$skipped[$i] = $data[$i];
							continue;
						}
					}
				}
				elseif($manufacturers_count == 1) {
					$manufacturers_query = tep_db_fetch_array($manufacturer_check);
					$manufacturer_id = $manufacturers_query['manufacturers_id'];
				}
				else {
					csv_import_message(sprintf(CSV_MANUFACTURER_INSERT_ERROR,$i), 'error');
					$skipped[$i] = $data[$i];
					continue;			
				}
			}
			
			if($manufacturer_id) {
				$fields['manufacturers_id'] = $manufacturer_id;
			}
		}
		
// Now it can update the products using products_model fields as unique ID -----------------------------------------
		//if(isset($bindings['products']['products_model'])) {
			$model_check = 0;
			if(isset($bindings['products']['products_model']) && !empty($data[$i][$bindings['products']['products_model']])) {
				$model_check_query = tep_db_query('SELECT COUNT(*) AS total FROM ' . TABLE_PRODUCTS . ' p WHERE p.products_model = \'' . $data[$i][$bindings['products']['products_model']] . '\'');
				$model_check = tep_db_fetch_array($model_check_query);
				$model_check = intval($model_check['total']);
			}
			
			if($model_check === 0) {
				$fields['products_date_added'] = strftime('%Y-%m-%d %H:%M:%S',time());
				$fields['products_status'] = (isset($config['settings']['products_default_status']) ? (int)$config['settings']['products_default_status']:0);
				
				if((bool)$config['settings']['import_images_urls'] && isset($fields['products_image']) && !empty($fields['products_image'])) {
					if(preg_match('/^http:\/\//', $fields['products_image'])) {
						$image_url = $fields['products_image'];
						$fields['products_image'] = basename($fields['products_image']);					
					}
					elseif(preg_match('/\|http:\/\//', $fields['products_image'])) {
						$params = explode($config['settings']['image_name_delimiter'], $fields['products_image']);
						$image_url = trim($params[1]);
						$fields['products_image'] = trim($params[0]);
					}
				}
				
				$quoted_fields = array();
				$quoted_values = array();				
				foreach($fields as $key => $value) {
					$quoted_fields[] = "`$key`";
					$quoted_values[] = "'$value'";
				}
				
				$products_query = 'INSERT INTO ' . TABLE_PRODUCTS.' (' . implode(',', $quoted_fields) . ') VALUES(' . implode(',', $quoted_values) . ')';
	
				if(!tep_db_query($products_query)) {
					csv_import_message(sprintf(CSV_PRODUCT_INSERT_ERROR,$i), 'error');
					$skipped[$i] = $data[$i];
					continue;
				}
				
				$product_id = tep_db_insert_id();
	
				foreach($cId as $c_id) {
					tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (`products_id`,`categories_id`) VALUES ('.$product_id.','.$c_id.')');
				}
	
				foreach($languages_ids as $lang => $lang_id) {
					if(isset($bindings['products_description'][$lang])) {
						$description_fields = array();
						$description_values = array();
						$lang_fields = $bindings['products_description'][$lang];
						
						foreach($lang_fields as $field => $col) {
							$description_fields[] = "`$field`";
							$description_values[] = "'".tep_db_input($data[$i][$col])."'";
						}
						
						if(!tep_db_query('INSERT INTO '.TABLE_PRODUCTS_DESCRIPTION.' (`products_id`,`language_id`,'.implode(',',$description_fields).") VALUES ('$product_id','$lang_id',".implode(',',$description_values).")")) {
							csv_import_message(sprintf(CSV_LANGUAGES_DESCRIPTION_INSERT_ERROR,$i), 'error');
						}
					}
					else {
						if(!tep_db_query("INSERT INTO ".TABLE_PRODUCTS_DESCRIPTION." (`products_id`,`language_id`) VALUES ('$product_id','$lang_id')")) {
							csv_import_message(sprintf(CSV_LANGUAGES_DESCRIPTION_INSERT_ERROR,$i), 'error');
						}
					}
				}
				
				if(isset($image_url)) {
					get_image_from_url($image_url, $fields['products_image']);
				}
			}
			elseif($model_check === 1) {
				$fields['products_last_modified'] = strftime('%Y-%m-%d %H:%M:%S',time());
				$model_id_query = tep_db_query('SELECT products_id FROM ' . TABLE_PRODUCTS . ' p WHERE p.products_model = \'' . $data[$i][$bindings['products']['products_model']] . '\'');
				$product_id = tep_db_fetch_array($model_id_query);
				$product_id = intval($product_id['products_id']);
	
				$fields['products_image'] = basename($fields['products_image']);
				
				$expressions = array();
				foreach($fields as $key => $value) {
					$expressions[] = "`$key` = '$value'";
				}
	
				$products_query = 'UPDATE ' . TABLE_PRODUCTS . ' SET ' . implode(',', $expressions) . ' WHERE products_id = \'' . $product_id . '\'';
	
				if(!tep_db_query($products_query)) {		
					csv_import_message(sprintf(CSV_PRODUCT_UPDATE_ERROR,$i), 'error');
					$skipped[$i] = $data[$i];
					continue;
				}
	
				tep_db_query("DELETE FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " WHERE products_id = '$product_id'");
				foreach($cId as $c_id) {
					tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (`products_id`,`categories_id`) VALUES ('.$product_id.','.$c_id.')');
				}
				
				foreach($languages_ids as $lang => $lang_id) {
					if(isset($bindings['products_description'][$lang])) {
						$description_couples = array();
						$lang_fields = $bindings['products_description'][$lang];
						foreach($lang_fields as $field => $col) {
							$description_couples[] = $field . "= '" . tep_db_input($data[$i][$col]) . "'";
						}
	
						if(!tep_db_query('UPDATE ' . TABLE_PRODUCTS_DESCRIPTION . ' SET ' . implode(',',$description_couples) . " WHERE products_id = $product_id AND language_id = $lang_id")) {
							csv_import_message(sprintf(CSV_LANGUAGES_DESCRIPTION_INSERT_ERROR,$i), 'error');
						}
					}
				}			
			}
			else {
				csv_import_message(sprintf(CSV_PRODUCT_MULTIPLE_MODELS_ERROR,$i), 'error');
				$skipped[$i] = $data[$i];
				continue;
			}	
		//}
	
		if(!empty($skipped)) {
			$log_file = CSV_IMPORT_UPLOAD_FOLDER.'log_'.strftime('%d%m%y_%H%M%S',time()).'.csv';
	
			$csv_rows = array();
			foreach($skipped as $row) {
				$fields = array();
				foreach($row as $field) {
					$fields[] = '"'.str_replace('<br />','',$field).'"';
				}
				$csv_rows[] = implode("\t",$fields);
			}
			
			$fp = fopen($log_file, 'w');
			fwrite($fp, implode("\n",$csv_rows));
			fclose($fp);
	
			csv_import_message(sprintf(CSV_SKIPPED_ROWS_SAVED,$log_file), 'warning');
		}
	}
}

function get_image_from_url($url, $filename) {
	if(function_exists('curl_init')) {
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$out = curl_exec($ch);
		curl_close($ch);
	
		if($out === false) {
			return false;
		}

		if($handle = fopen(DIR_FS_CATALOG_IMAGES . $filename, 'wb')) {
			fwrite($handle, $out);
			fclose($handle);
		}
		
		return true;
	}

	csv_import_message(CSV_CURL_MISSING_CANT_IMPORT_REMOTE_IMAGE, 'warning');
	return false;
}

function csv_import_message($message, $type) {
	if(CSV_DEBUG) {
		echo $type . ": " . $message;
		return;
	}
	elseif($type == "debug") {
		return;
	}

	if(isset($_SESSION)) {
		global $messageToStack;
	    if(isset($_SESSION['messageToStack'])) {
			$messageToStack = $_SESSION['messageToStack'];
	    } 
		else {
			$messageToStack = array();
	    }

	    $messageToStack[] = array('text' => $message, 'type' => $type);
	    $_SESSION['messageToStack'] = $messageToStack;
	}
	else {
		global $messageStack;
		$messageStack->add_session($message, $type);	
	}
}

function csv_import_exit($message, $type) {
	csv_import_message($message, $type);

	if(CSV_DEBUG) {
		echo "<br/><br/><a href=\"".CSV_IMPORT_PHP_FILE."\">" . CSV_GO_BACK . "</a>";
		exit();
	}

	tep_redirect(CSV_IMPORT_PHP_FILE);
}

function debug() {
	$args = func_get_args();
	
	echo "<pre>";
	foreach($args as $arg) {
		echo print_r($arg, true) . "\n";
	}
	echo "</pre>";
}

if(!is_dir(CSV_IMPORT_UPLOAD_FOLDER) || !is_readable(CSV_IMPORT_UPLOAD_FOLDER) || !is_writable(CSV_IMPORT_UPLOAD_FOLDER)) {
	$messageStack->add(sprintf(CSV_FOLDER_ERROR, CSV_IMPORT_UPLOAD_FOLDER));
}

if(preg_match('/^config/', $action) && !is_writable(CSV_IMPORT_INI_FILE)) {
	$messageStack->add(sprintf(CSV_INI_NOT_WRITABLE_ERROR, CSV_IMPORT_INI_FILE));
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>
<style type="text/css">
	a.button {
		font-weight:bold;
		text-align:center;
		padding:2px 5px;
		border:1px solid black;
		background-color:#555;
		text-decoration:none;
		color:#fff;
	}
	
	td.file_column {
		background:#eee;
		padding:2px 3px;
		font-family:Tahoma, Verdana, Arial, sans-serif;	
		font-size:12px;	
	}
	pre {
		margin:0;
		border:0;
		padding:0;
	}
</style>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'template_top.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="100%" valign="top">
	<!-- body_text //-->
	<?php if($action != 'config') { ?>
		<br/>
		<form name="csvimport" action="<?php echo CSV_IMPORT_PHP_FILE; ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="upload"/>
			<table>
				<tr>
					<td><b><?php echo CSV_FILE; ?></b></td>
					<td><input name="csvfile" type="file" accept="text/plain"/></td>
					<td><input type="submit" value="<?php echo CSV_UPLOAD; ?>"/></td>
				</tr>
			</table>
		</form>
		<hr/>
		<a class="button" href="<?php echo CSV_IMPORT_PHP_FILE; ?>?action=config"><?php echo CSV_CONFIGURATION; ?></a>
		<?php if((bool)$config['settings']['allow_empty_db']) { ?>
		<a class="button" href="?action=empty" onclick="return confirm('<?php echo CSV_CONFIRM_EMPTY; ?>');" title="<?php echo CSV_EMPTY_CATALOG; ?>"><?php echo CSV_EMPTY_CATALOG; ?></a>
		<br/>
		<br/>
		<?php } ?>
<?php
if($handle = @opendir(CSV_IMPORT_UPLOAD_FOLDER)) {
?>
<table>
	<tr>
		<th width="200" align="left"><?php echo CSV_LOADED_FILES; ?></th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
<?php
	while (false !== ($file = readdir($handle))) { 	
		if($file != '.' && $file != '..') {
?>
	<tr>
		<td class="file_column"><?php echo $file; ?></td>
		<td>
			<a class="button" href="?action=view&amp;file=<?php echo $file; ?>" title="<?php echo CSV_VIEW; ?>"><?php echo CSV_VIEW; ?></a>
		</td>		
		<td>
			<a class="button" href="?action=import&amp;file=<?php echo $file; ?>" onclick="return confirm('<?php echo CSV_CONFIRM_IMPORT; ?>');" title="<?php echo CSV_IMPORT; ?>"><?php echo CSV_IMPORT; ?></a>
		</td>
		<td>
			<a class="button" href="?action=delete&amp;file=<?php echo $file; ?>" onclick="return confirm('<?php echo CSV_CONFIRM_DELETE; ?>');" title="<?php echo CSV_DELETE; ?>"><?php echo CSV_DELETE; ?></a>
		</td>
	</tr>
<?php			
		}
	}

   closedir($handle);
?>
</table>
<?php
}
?>	
		<br/>
		<br/>
		<div style="border:1px solid #aaa;padding:5px;font-size:13px;background:#eee;"><pre><?php echo CSV_USE_MODE; ?></pre></div>
		<br/>
		<?php } else { ?>
			<br/>
			<a class="button" href="<?php echo CSV_IMPORT_PHP_FILE; ?>"><?php echo CSV_GO_BACK; ?></a>
			<br/>
			<br/>

			<form action="<?php echo CSV_IMPORT_PHP_FILE; ?>" method="post">
			<input type="hidden" name="action" value="config_save"/>
			<table>
			<?php foreach($config as $section => $values) { ?>
				<tr><td colspan="3"><h1><?php echo $section; ?></h1></td></tr>
				<?php foreach($values as $key => $value) { ?>
					<tr><td><?php echo $key ?>:</td><td><?php if(strlen($value) > 100) { ?><textarea name="config[<?php echo $section ?>][<?php echo $key ?>]" rows="5" cols="50"><?php echo $value ?></textarea><?php } else { ?><input name="config[<?php echo $section ?>][<?php echo $key ?>]" size="<?php echo strlen($value) ?>" type="text" value="<?php echo $value ?>"/><?php } ?></td><td><?php echo (isset($comments[$section][$key]) ? $comments[$section][$key]:'') ?></td></tr></div>
				<?php } ?>
			<?php } ?>
			</table>
			<input type="submit" value="Save"/>
			</form>
		<?php } ?>
	<!-- body_text_eof //-->
	</td>
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>

</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>