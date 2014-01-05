<?php
define('CSV_USE_MODE','<b>Excel/OOCalc filen skal have de f�lgende kolonner i den viste r�kkef�lge:</b>

1. category (enten id eller kategorinavnet, se forneden)
2. model (hvis dette er unikt, vil det blive benyttet til at opdatere ved n�ste importering)
3. name_en
4. name_es
5. name_it
6. name_de
7. name_dk
8. name_fr
9. quantity
10. image (med extension, f.eks. http://www.minside.dk/picture.jpg !Bem�rk! linux er case-sensitive, f.eks. /Picture.JPG!)
11. price
12. weight
13. description_en
14. description_es
15. description_it
16. description_de
17. description_dk
18. description_fr
19. tax class (enten id eller navn)
20. manufacturer name (enten id eller navn)

den f�rste r�kke SKAL V�RE TOM eller med titlen (denne vil blive ignoreret)

Du er n�dt til at eksportere/gemme filen i csv format: separator �;� (semikolon), afgr�nser �"� (anf�relsestegn)
');
define('CSV_FIELDS_MATCH_ERROR','R�kke %s: Antallet af felter er forkert');
define('CSV_UNKNOWN_CATEGORY_ERROR','R�kke %s: Kan ikke finde kategorien med det specificerede ID');
define('CSV_PRODUCT_INSERT_ERROR','R�kke %s: Fejl ved inds�tning af produkt');
define('CSV_LANGUAGES_DESCRIPTION_INSERT_ERROR','R�kke %s: Fejl ved inds�tning af produktets sprog');
define('CSV_SKIPPED_ROWS_SAVED','Alle de skippede r�kker er blevet gemt i %s');
define('CSV_IMPORT_DONE','Importering Successfuld');
define('CSV_ACTION_DONE','Udf�rt med Success');
define('CSV_FILE','CSV file:');
define('CSV_LOADED_FILES','Uploadede filer:');
define('CSV_UPLOAD','Upload');
define('CSV_VIEW','Vis');
define('CSV_IMPORT','Importer');
define('CSV_DELETE','Slet');
define('CSV_EMPTY_CATALOG','T�m katalog');
define('CSV_CONFIRM_IMPORT','Import�r de valgte filer, er du sikker?');
define('CSV_CONFIRM_DELETE','Sletter de valgte filer, er du sikker?');
define('CSV_CONFIRM_EMPTY','Dette vil slette alle produkter i kataloget, er du sikker?');
define('CSV_MANUFACTURER_INSERT_ERROR','R�kke %s: Fejl ved inds�tning af producent');
define('CSV_CATEGORY_INSERT_ERROR','R�kke %s: Fejl ved inds�tning af kategorien %s');
define('CSV_PRODUCT_UPDATE_ERROR','R�kke %s: Fejl ved opdatering af produktet');
define('CSV_PRODUCT_MULTIPLE_MODELS_ERROR','R�kke %s: Der er 2 produkter med det samme model felt');
define('CSV_CURL_MISSING_CANT_IMPORT_REMOTE_IMAGE','CURL Biblioteket mangler i din PHP server. Kan ikke importere billeder fra ekstern destination');
define('CSV_INVALID_FILE_ERROR', '%s i en ikke valideret fil');
define('CSV_FILE_READ_PERMISSIONS_ERROR', 'Du har ikke tilladelse til at l�se filen %s');
define('CSV_GO_BACK', 'G� tilbage');
define('CSV_CONFIGURATION', 'Konfiguration');
define('CSV_INI_NOT_WRITABLE_ERROR', 'Konfigurationsfilen %s er ikke skrivbar');
define('CSV_FOLDER_ERROR', 'Mappen %s er ikke gyldig eller du har ikke tilladelse til at l�se/skrive til den');
?>