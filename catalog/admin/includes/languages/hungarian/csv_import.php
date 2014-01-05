<?php
define('CSV_USE_MODE','<b>Excel vagy OpenOffice Calc kell az al�bbiakhoz:</b>

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
define('CSV_FIELDS_MATCH_ERROR','Sor %s: A mez�sz�m nem egyezik');
define('CSV_UNKNOWN_CATEGORY_ERROR','Sor %s: Nem tal�lom a megadott ID-j� kateg�ri�t');
define('CSV_PRODUCT_INSERT_ERROR','Row %s: Error inserting the product');
define('CSV_LANGUAGES_DESCRIPTION_INSERT_ERROR','Sor %s: Hiba a term�k nyelv�nek besz�r�s�n�l');
define('CSV_SKIPPED_ROWS_SAVED','Minden �tl�pett sor elmentve %s');
define('CSV_IMPORT_DONE','Sikeres import�l�s');
define('CSV_ACTION_DONE','Sikeresen elk�sz�lt');
define('CSV_FILE','CSV f�jl:');
define('CSV_LOADED_FILES','Felt�lt�tt f�jlok:');
define('CSV_UPLOAD','Felt�lt');
define('CSV_VIEW','N�zet');
define('CSV_IMPORT','Import');
define('CSV_DELETE','T�rl�s');
define('CSV_EMPTY_CATALOG','�res katal�gus');
define('CSV_CONFIRM_IMPORT','Import�lom a kiv�lasztott f�jlt, biztos benne?');
define('CSV_CONFIRM_DELETE','T�rl�m a kiv�lasztott f�jlt, biztos benne?');
define('CSV_CONFIRM_EMPTY','Az �sszes term�ket t�rl�m a katal�gusb�l, biztos benne?');
define('CSV_MANUFACTURER_INSERT_ERROR','Sor %s: Hiba a gy�rt� besz�r�sn�l');
define('CSV_CATEGORY_INSERT_ERROR','Row %s: Error inserting the category %s');
define('CSV_PRODUCT_UPDATE_ERROR','Sor %s: Hiba a term�k beviteln�l');
define('CSV_PRODUCT_MULTIPLE_MODELS_ERROR','Sor %s: 2 term�k van azonos cikksz�mon');
define('CSV_CURL_MISSING_CANT_IMPORT_REMOTE_IMAGE','CURL Library is missing in your PHP server. Can\'t import remote images');
define('CSV_INVALID_FILE_ERROR', '%s nem egy �rv�nyes f�jl ');
define('CSV_FILE_READ_PERMISSIONS_ERROR', 'Nincs enged�lyed, hogy olvassd a f�jlt  %s');
define('CSV_GO_BACK', 'Vissza');
define('CSV_CONFIGURATION', 'Configuration');
define('CSV_INI_NOT_WRITABLE_ERROR', 'Configuration file %s is not writable');
define('CSV_FOLDER_ERROR', 'A %s mappa nem l�tezik vagy nincs olvas�si/�r�si jogosults�god');
?>