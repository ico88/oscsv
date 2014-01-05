<?php
define('CSV_USE_MODE','<b>The Excel/OOCalc file must have the following columns in the shown order:</b>

1. category (either id or category name, see below)
2. model (if unique it is used to update the product next time you import it again)
3. name_en
4. name_es
5. name_it
6. name_de
7. name_nl
8. name_fr
9. quantity
10. image (with extension, attention! case-sensitive on linux)
11. price
12. weight
13. description_en
14. description_es
15. description_it
16. description_de
17. description_nl
18. description_fr
19. tax class (either id or name)
20. manufacturer name (either id or name)

the first row MUST BE EMPTY or with title (it will be ignored)

you must export/save the file in csv format: separator “;” (semicolon), delimiter “"” (double quote)
');
define('CSV_FIELDS_MATCH_ERROR','Row %s: The count of fields is wrong');
define('CSV_UNKNOWN_CATEGORY_ERROR','Row %s: Cannot find a category with the specified ID');
define('CSV_PRODUCT_INSERT_ERROR','Row %s: Error inserting the product');
define('CSV_LANGUAGES_DESCRIPTION_INSERT_ERROR','Row %s: Error inserting the product\'s languages');
define('CSV_SKIPPED_ROWS_SAVED','All the skipped rows have been saved in %s');
define('CSV_IMPORT_DONE','Imported Successfully');
define('CSV_ACTION_DONE','Done Successfully');
define('CSV_FILE','CSV file:');
define('CSV_LOADED_FILES','Uploaded files:');
define('CSV_UPLOAD','Upload');
define('CSV_VIEW','View');
define('CSV_IMPORT','Import');
define('CSV_DELETE','Delete');
define('CSV_EMPTY_CATALOG','Empty catalog');
define('CSV_CONFIRM_IMPORT','Importing the selected file, are you sure?');
define('CSV_CONFIRM_DELETE','Deleting the selected file, are you sure?');
define('CSV_CONFIRM_EMPTY','This will delete all products in the catalog, are you sure?');
define('CSV_MANUFACTURER_INSERT_ERROR','Row %s: Error inserting the manufacturer');
define('CSV_CATEGORY_INSERT_ERROR','Row %s: Error inserting the category %s');
define('CSV_PRODUCT_UPDATE_ERROR','Row %s: Error updating the product');
define('CSV_PRODUCT_MULTIPLE_MODELS_ERROR','Row %s: There are 2 products with the same model field');
define('CSV_CURL_MISSING_CANT_IMPORT_REMOTE_IMAGE','CURL Library is missing in your PHP server. Can\'t import remote images');
define('CSV_INVALID_FILE_ERROR', '%s in not a valid file');
define('CSV_FILE_READ_PERMISSIONS_ERROR', 'You do not have permission to read the file %s');
define('CSV_GO_BACK', 'Go back');
define('CSV_CONFIGURATION', 'Configuration');
define('CSV_INI_NOT_WRITABLE_ERROR', 'Configuration file %s is not writable');
define('CSV_FOLDER_ERROR', 'The folder %s is invalid or you do not have read/write permissions on it');
?>