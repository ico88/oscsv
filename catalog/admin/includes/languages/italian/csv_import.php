<?php
define('HEADING_TITLE', 'Importa CSV');
define('CSV_USE_MODE','<b>Il file Excel/OOCalc deve essere strutturato come segue:</b>

1. categoria (id o il nome, vedi in seguito)
2. modello (se unico è usato per aggiornare il record alla successiva importazione)
3. nome_en
4. nome_es
5. nome_it
6. nome_de
7. nome_nl
8. nome_fr
9. quantità
10. immagine (con estensione, attenzione alle maiuscole/minuscole su linux)
11. prezzo
12. peso
13. descrizione_en
14. descrizione_es
15. descrizione_it
16. descrizione_de
17. descrizione_nl
18. descrizione_fr
19. classe tassa (id o nome)
20. produttore ( id o nome)
21. status ( 1: attivo, 0: disattivo)

la prima riga deve essere vuota o con i titoli, verrà ignorata.

si dovrà infine esportare/salvare il file in formato csv: separatore “;” (punto e virgola), delimitatore “"” (doppio apice)
');
define('CSV_FIELDS_MATCH_ERROR','Riga %s: Il numero dei campi non corrisponde');
define('CSV_UNKNOWN_CATEGORY_ERROR','Riga %s: La categoria del prodotto non esiste');
define('CSV_PRODUCT_INSERT_ERROR','Riga %s: Errore nell\'inserimento del prodotto');
define('CSV_LANGUAGES_DESCRIPTION_INSERT_ERROR','Riga %s: Errore nell\'inserimento delle lingue del prodotto');
define('CSV_SKIPPED_ROWS_SAVED','Le righe saltate sono state salvate nel file %s');
define('CSV_IMPORT_DONE','Importazione completata');
define('CSV_ACTION_DONE','Operazione completata');
define('CSV_FILE','File CSV:');
define('CSV_LOADED_FILES','File caricati:');
define('CSV_UPLOAD','Carica');
define('CSV_VIEW','Visualizza');
define('CSV_IMPORT','Importa');
define('CSV_DELETE','Elimina');
define('CSV_EMPTY_CATALOG','Svuota il catalogo');
define('CSV_CONFIRM_IMPORT','Sicuro di voler importare i dati?');
define('CSV_CONFIRM_DELETE','Sicuro di voler eliminare il file?');
define('CSV_CONFIRM_EMPTY','Verranno cancellati tutti i prodotti in catalogo, sicuro?');
define('CSV_MANUFACTURER_INSERT_ERROR','Riga %s: Errore nell\'inserimento del produttore');
define('CSV_CATEGORY_INSERT_ERROR','Row %s: Errore nell\'inserimento della categoria %s');
define('CSV_PRODUCT_UPDATE_ERROR','Riga %s: Errore nell\'aggiornamento del prodotto');
define('CSV_PRODUCT_MULTIPLE_MODELS_ERROR','Riga %s: Ci sono 2 prodotti con lo stesso campo modello');
define('CSV_CURL_MISSING_CANT_IMPORT_REMOTE_IMAGE','In questo server manca la libreria CURL. Non si possono importare immagini remote');
define('CSV_INVALID_FILE_ERROR', 'Il file %s non è valido');
define('CSV_FILE_READ_PERMISSIONS_ERROR', 'Non si dispone dei permessi in lettura per il file %s');
define('CSV_GO_BACK', 'Torna indietro');
define('CSV_CONFIGURATION', 'Configurazione');
define('CSV_INI_NOT_WRITABLE_ERROR', 'Il file di configurazione %s non è scrivibile');
define('CSV_FOLDER_ERROR', 'La cartella %s non è valida o non si dispone dei permessi di lettura/scrittura su di essa');
define('CSV_FILE_IMPORT', 'Importa CSV');
?>