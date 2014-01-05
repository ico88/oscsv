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

you must export/save the file in csv format: separator “;” (semicolon), delimiter “"” (double quote)
');
define('CSV_FIELDS_MATCH_ERROR','Zeile %s: Der Feldzählimpuls passt nicht zusammen');
define('CSV_UNKNOWN_CATEGORY_ERROR','Zeile %s: Die eingetragenen ID für die Kategorie wurde nicht gefunden');
define('CSV_PRODUCT_INSERT_ERROR','Zeile %s: Fehler beim Hinzufügen des Produktes');
define('CSV_LANGUAGES_DESCRIPTION_INSERT_ERROR','Zeile %s: Fehler beim Einfügen der Produktsprache');
define('CSV_SKIPPED_ROWS_SAVED','Alle ignorierten Zeilen wurden in %s gespeichert');
define('CSV_IMPORT_DONE','Import erfolgreich abgeschlossen');
define('CSV_ACTION_DONE','Erfolgreich abgeschlossen');
define('CSV_FILE','CSV Datei:');
define('CSV_LOADED_FILES','Verfügbare Dateien:');
define('CSV_UPLOAD','Upload');
define('CSV_VIEW','Ansehen');
define('CSV_IMPORT','Importieren');
define('CSV_DELETE','Löschen');
define('CSV_EMPTY_CATALOG','Alle Artikel aus DB löschen');
define('CSV_CONFIRM_IMPORT','Wollen Sie die ausgewählte Datei imortieren?');
define('CSV_CONFIRM_DELETE','Wollen Sie die ausgewählte Datei löschen?');
define('CSV_CONFIRM_EMPTY','ACHTUNG: Wollen Sie tatsächlich sämtliche Produkte aus der Datenbank löschen?');
define('CSV_MANUFACTURER_INSERT_ERROR','Zeile %s: Der angegebene Hersteller konnte nicht angelegt werden');
define('CSV_CATEGORY_INSERT_ERROR','Row %s: Error inserting the category %s');
define('CSV_PRODUCT_UPDATE_ERROR','Zeile %s: Das Produkt konnte in der Datenbank nicht aktualisiert werden');
define('CSV_PRODUCT_MULTIPLE_MODELS_ERROR','Zeile %s: 2 Produkte mit der selben Modellnummer');
define('CSV_CURL_MISSING_CANT_IMPORT_REMOTE_IMAGE','CURL Library is missing in your PHP server. Can\'t import remote images');
define('CSV_INVALID_FILE_ERROR', '%s ist keine gültige Datei');
define('CSV_FILE_READ_PERMISSIONS_ERROR', 'Sie verfügen nicht über die Berechtigung zum Lesen der Datei %s');
define('CSV_GO_BACK', 'Zurück');
define('CSV_CONFIGURATION', 'Configuration');
define('CSV_INI_NOT_WRITABLE_ERROR', 'Configuration file %s is not writable');
define('CSV_FOLDER_ERROR', 'Der Ordner %s ist ungültig oder nicht gelesen haben / Schreibrechte auf');
?>