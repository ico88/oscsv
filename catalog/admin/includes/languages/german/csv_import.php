<?php
define('CSV_USE_MODE','<b>Die Excel/Calc-Datei muss nachfolgende Spalten haben:</b>

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

you must export/save the file in csv format: separator �;� (semicolon), delimiter �"� (double quote)
');
define('CSV_FIELDS_MATCH_ERROR','Zeile %s: Der Feldz�hlimpuls passt nicht zusammen');
define('CSV_UNKNOWN_CATEGORY_ERROR','Zeile %s: Die eingetragenen ID f�r die Kategorie wurde nicht gefunden');
define('CSV_PRODUCT_INSERT_ERROR','Zeile %s: Fehler beim Hinzuf�gen des Produktes');
define('CSV_LANGUAGES_DESCRIPTION_INSERT_ERROR','Zeile %s: Fehler beim Einf�gen der Produktsprache');
define('CSV_SKIPPED_ROWS_SAVED','Alle ignorierten Zeilen wurden in %s gespeichert');
define('CSV_IMPORT_DONE','Import erfolgreich abgeschlossen');
define('CSV_ACTION_DONE','Erfolgreich abgeschlossen');
define('CSV_FILE','CSV Datei:');
define('CSV_LOADED_FILES','Verf�gbare Dateien:');
define('CSV_UPLOAD','Upload');
define('CSV_VIEW','Ansehen');
define('CSV_IMPORT','Importieren');
define('CSV_DELETE','L�schen');
define('CSV_EMPTY_CATALOG','Alle Artikel aus DB l�schen');
define('CSV_CONFIRM_IMPORT','Wollen Sie die ausgew�hlte Datei imortieren?');
define('CSV_CONFIRM_DELETE','Wollen Sie die ausgew�hlte Datei l�schen?');
define('CSV_CONFIRM_EMPTY','ACHTUNG: Wollen Sie tats�chlich s�mtliche Produkte aus der Datenbank l�schen?');
define('CSV_MANUFACTURER_INSERT_ERROR','Zeile %s: Der angegebene Hersteller konnte nicht angelegt werden');
define('CSV_CATEGORY_INSERT_ERROR','Row %s: Error inserting the category %s');
define('CSV_PRODUCT_UPDATE_ERROR','Zeile %s: Das Produkt konnte in der Datenbank nicht aktualisiert werden');
define('CSV_PRODUCT_MULTIPLE_MODELS_ERROR','Zeile %s: 2 Produkte mit der selben Modellnummer');
define('CSV_CURL_MISSING_CANT_IMPORT_REMOTE_IMAGE','CURL Library is missing in your PHP server. Can\'t import remote images');
define('CSV_INVALID_FILE_ERROR', '%s ist keine g�ltige Datei');
define('CSV_FILE_READ_PERMISSIONS_ERROR', 'Sie verf�gen nicht �ber die Berechtigung zum Lesen der Datei %s');
define('CSV_GO_BACK', 'Zur�ck');
define('CSV_CONFIGURATION', 'Configuration');
define('CSV_INI_NOT_WRITABLE_ERROR', 'Configuration file %s is not writable');
define('CSV_FOLDER_ERROR', 'Der Ordner %s ist ung�ltig oder nicht gelesen haben / Schreibrechte auf');
?>