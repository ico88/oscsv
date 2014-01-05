<?php
define('CSV_USE_MODE','<b>Το αρχείο Excel/OOCalc θα πρέπει να είναι ως εξής:</b>

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
define('CSV_FIELDS_MATCH_ERROR','Γραμμή %s: Η αρίθμιση του πεδίου δεν ταιρίαζει');
define('CSV_UNKNOWN_CATEGORY_ERROR','Γραμμή %s: Δεν ήταν δυνατή η εύρεση κατηγορίας με το δοσμένο κωδικό');
define('CSV_PRODUCT_INSERT_ERROR','Γραμμή %s: Σφάλμα στην εισαγωγή του προϊόντος');
define('CSV_LANGUAGES_DESCRIPTION_INSERT_ERROR','Γραμμή %s: Σφάλμα στην εισαγωγή των γλωσσών του προιόντος');
define('CSV_SKIPPED_ROWS_SAVED','Οι γραμμές στις οποίε έγινε παράληψη έχουν σωθεί στο %s');
define('CSV_IMPORT_DONE','Imported Επιτυχώς');
define('CSV_ACTION_DONE','Ολοκληρώθηκε Επιτυχώς');
define('CSV_FILE','Αρχείο CSV:');
define('CSV_LOADED_FILES','Ανεβασμένα αρχεία:');
define('CSV_UPLOAD','Ανέβασμα');
define('CSV_VIEW','Προβολή');
define('CSV_IMPORT','Εισαγωγή');
define('CSV_DELETE','Διαγραφή');
define('CSV_EMPTY_CATALOG','Άδειος κατάλογος');
define('CSV_CONFIRM_IMPORT','Εισαγωγή επιλεγμένου αρχείου, είστε βέβαιος;');
define('CSV_CONFIRM_DELETE','Διαγραφή επιλεγμένου αρχείου, είστε βέβαιος;');
define('CSV_CONFIRM_EMPTY','Θα γίνει διαγραφή όλων των προϊόντων στον κατάλογο, είστε βέβαιος;');
define('CSV_MANUFACTURER_INSERT_ERROR','Γραμμή %s: Σφάλμα στην εισαγωγή της εταιρίας');
define('CSV_CATEGORY_INSERT_ERROR','Row %s: Error inserting the category %s');
define('CSV_PRODUCT_UPDATE_ERROR','Γραμμή %s: Σφάλμα στην ενημέρωση του προϊόντος');
define('CSV_PRODUCT_MULTIPLE_MODELS_ERROR','Γραμμή %s: Υπάρχουν 2 προϊόντα με το ίδιο όνομα μοντέλου');
define('CSV_CURL_MISSING_CANT_IMPORT_REMOTE_IMAGE','CURL Library is missing in your PHP server. Can\'t import remote images');
define('CSV_INVALID_FILE_ERROR', '%s δεν είναι έγκυρο αρχείο');
define('CSV_FILE_READ_PERMISSIONS_ERROR', 'Δεν έχετε δικαίωμα να διαβάσετε το αρχείο %s');
define('CSV_GO_BACK', 'Πίσω');
define('CSV_CONFIGURATION', 'Configuration');
define('CSV_INI_NOT_WRITABLE_ERROR', 'Configuration file %s is not writable');
define('CSV_FOLDER_ERROR', 'Ο φάκελος %s δεν είναι έγκυρος ή δεν έχετε δικαιώματα ανάγνωση/εγγραφής σε αυτόν');
?>