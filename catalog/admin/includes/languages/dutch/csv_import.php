<?php
define('CSV_USE_MODE','<b>Het Excel/OOCalc bestand moet de volgende kolommen bevatten in de opgegeven volgorde:</b>

1. category (ID of category naam, zie onder)
2. model (als dit uniek is, wordt dit gebruikt om bij de volgende inport het product te verniewen.)
3. name_en
4. name_es
5. name_it
6. name_de
7. name_nl
8. name_fr
9. quantity
10. image (met extentie, let op: hoofdletter gevoelig bij linux)
11. price
12. weight
13. description_en
14. description_es
15. description_it
16. description_de
17. description_nl
18. description_fr
19. tax class (ID of naam)
20. manufacturer name (ID of naam)

de eerste rij MOET leeg zijn of met titel (wordt genegeerd)

het bestand moet bewaard worden in csv formaat: separator “;” (semicolon), delimiter “"” (double quote)');
define('CSV_FIELDS_MATCH_ERROR','Row %s: Het aantal velden is fout');
define('CSV_UNKNOWN_CATEGORY_ERROR','Row %s: Kan de catagory met gespecificeerde ID niet vinden.');
define('CSV_PRODUCT_INSERT_ERROR','Row %s: FOUT bij invoegen van het produkt');
define('CSV_LANGUAGES_DESCRIPTION_INSERT_ERROR','Row %s: FOUT bij invoegen van produkt taal');
define('CSV_SKIPPED_ROWS_SAVED','Alle overgeslagen rijen zijn opgeslagen in %s');
define('CSV_IMPORT_DONE','Import Succesvol');
define('CSV_ACTION_DONE','Klaar Succesvol');
define('CSV_FILE','CSV bestand:');
define('CSV_LOADED_FILES','Uploaded bestand(en):');
define('CSV_UPLOAD','Upload');
define('CSV_VIEW','Bekijk');
define('CSV_IMPORT','Importeer');
define('CSV_DELETE','Wissen');
define('CSV_EMPTY_CATALOG','Catalogus legen');
define('CSV_CONFIRM_IMPORT','Het geselecteerde bestand Importeren, weet je het zeker?');
define('CSV_CONFIRM_DELETE','Het geselecteerde bestand Wissen, weet je het zeker?');
define('CSV_CONFIRM_EMPTY','Deze actie zal alle produkten uit de catalogus wissen, weet je het zeker?');
define('CSV_MANUFACTURER_INSERT_ERROR','Row %s: FOUT: invoegen fabrikant');
define('CSV_CATEGORY_INSERT_ERROR','Row %s: FOUT: invoegen category %s');
define('CSV_PRODUCT_UPDATE_ERROR','Row %s: FOUT: Updating produkt');
define('CSV_PRODUCT_MULTIPLE_MODELS_ERROR','Row %s: Er zijn 2 produkten met hetzelfde veld MODEL');
define('CSV_CURL_MISSING_CANT_IMPORT_REMOTE_IMAGE','CURL bibliotheek is niet aanwezig in de PHP server. Kan geen afbeeldingen importeren.');
define('CSV_INVALID_FILE_ERROR', '%s is een ongeldig bestand');
define('CSV_FILE_READ_PERMISSIONS_ERROR', 'Je hebt geen toestemming bestand %s te lezen.');
define('CSV_GO_BACK', 'Ga terug');
define('CSV_CONFIGURATION', 'Configuration');
define('CSV_INI_NOT_WRITABLE_ERROR', 'Configuration file %s is not writable');
define('CSV_FOLDER_ERROR', 'De map is ongeldig %s of je hebt geen read/write rechten.');
?>