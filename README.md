# OSCSV

OSCSV è un addon per OsCommerce che permette il caricamento degli articoli direttamente da file CSV.

L'Addon è basato sull'addon dell'Ing. Eugenio Bonifacicio, la versione originale è reperibile qui:
<a href="http://www.eugeniobonifacio.com/content/easy-csv-import"> OSCVS V2.0 </a>

=============================

### Installazione:

Copiare i seguenti file in oscommerce:
* /admin/csv_import.php
* /admin/csv_import/csv_import.ini
* /admin/csv_import/data_parsing.php
* /admin/includes/languages/*/csv_import.php
* la cartella /admin/csv_import/csv deve avere i permessi in scrittura

Se si vuole aggiungere una voce di menu in Amministrazione->Strumenti aggiungete il seguente codice sottostante al file ``` tools.php ``` in ``` /admin/includes/boxes/tools.php ```

```php
<a href="' . tep_href_link('csv_import.php') . '" class="menuBoxContentLink">Importa Excel/Calc</a><br>
```
 O in alternativa aggiungere, preceduto da una virgola:
```php
 array(
        'code' => FILENAME_CSV_IMPORT,
        'title'=> CSV_FILE_IMPORT,
        'link' => tep_href_link('csv_import.php')
      )
```
=============================

### Uso:

Il file CSV deve avere i seguenti campi nello stesso ordine:

1. categoria ( id o il nome )
2. modello ( se unico è usato per aggiornare il record alla successiva importazione )
3. nome_en
4. nome_es
5. nome_it
6. nome_de
7. nome_nl
8. nome_fr
9. quantità
10. immagine ( con estensione, attenzione alle maiuscole/minuscole su linux )
11. prezzo
12. peso
13. descrizione_en
14. descrizione_es
15. descrizione_it
16. descrizione_de
17. descrizione_nl
18. descrizione_fr
19. classe tassa ( id o nome )
20. produttore ( id o nome )
21. status ( 0: disattivo / 1: attivo  )

La prima riga deve essere vuota o con i titoli, verrà ignorata durante la fase di import.

Una volta compilato il fiel si dovrà infine esportare/salvare il file in formato csv: 
* separatore “;” (punto e virgola)
* delimitatore “"” (doppio apice)

=============================

### Personalizzazione:

Per personalizzare i campi del file csv:

* modificare l'associazione delle colonne (a partire da zero) e gli header delle colonne nel file di configurazione ```import.ini``` che si trova in ```admin/csv_import/csv_import.ini```

* Se si vogliono operare delle conversioni prima di importare i dati è necessario aggiungere del codice alla funzione ```parse_csv_data``` all'interno del file ```admin/csv_import/data_parsing.php```

* Se non si vuole utilizzare la funzione "Svuota catalogo" basta impostare ```allow_empty_db = 0``` all'interno del file ```csv_import.ini```

=============================

### Importazione delle categorie:

Si possono importare le categorie a partire dal nome

Le categorie devono essere specificate con il percorso, a partire da quella principale a finire a quella a cui il prodotto appartiene.

Per esempio, se un prodotto appartiene alla categoria ```Hardware -> Graphics Cards -> AGP``` si deve scrivere il percorso separato da punti:
```
Hardware.Graphics Cards.AGP
```

* Si devono scrivere i nomi delle categorie esattamente e si possono inserire spazi tra i punti.

* Se una o più categorie non esistono verranno create.

* Si possono aggiungere più categorie, così se un prodotto appartiene a più categorie si deve scrivere come segue:
```
Hardware.Graphics Cards.AGP|Hardware.Graphics Cards.DVI
```
Il prodotto importato sarà inserito in entrambe le categorie.

=============================

### Importare immagini remote:

Si possono importare immagini remote mettendo nel campo "immagine" l'url dell'immagine da importare. Questa verrà scaricata all'interno della cartella delle immagini di oscommerce.

Ci sono due opzioni:

1. Inserire l'url del file, ad esempio ```http://server.esterno.com/immagine.jpg```. In questo caso il nome dell'immagine sarà quello dell'immagine remota.

2. Inserire il nome e l'url ```immagine.jpg|http://server.esterno.com/visualizza_immagine.php?id=qwerty```. Questo caso è utile quando non si hanno file ma script che restituiscono l'immagine.

Naturalmente la seconda opzione può anche essere usata nel primo caso, per specificare un nome diverso.

=============================

### Change Log:

v3.0.0 (05/01/2014)
	- Sistemazione file lingua
	- Import dello stato prodotto
