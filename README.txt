osCommerce 2.2RC2a Contribution

Products Import from CSV File v2.0

18/05/2007
Eugenio Bonifacio (eugh@libero.it) - Comiso (RG) - Italy

The author is not responsible for any damage caused
by the use of this code and any derivatives of it.
So use it at your own risk.

This code is released under the terms of the GNU/GPL v2
http://www.gnu.org/copyleft/gpl.html

-------
INSTALLATION:

Just copy the following files:
/admin/csv_import.php
/admin/csv_import/csv_import.ini
/admin/csv_import/data_parsing.php
/admin/includes/languages/*/csv_import.php

the /admin/csv_import/csv folder must have write permissions

if you want a menu item in administration->tools just add the following line to /admin/includes/boxes/tools.php

'<a href="' . tep_href_link('csv_import.php') . '" class="menuBoxContentLink">Excel/Calc Import</a><br>' .

-------

USAGE:

The Excel/OOCalc file must have the following columns in the shown order:

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

-----------------------------

CUSTOMIZATION:

If you want to fit it to your needs you can change fields easily

*) Edit and change the column bindings (0-index based) and column headers in configuration file (admin/csv_import/csv_import.ini)

*) If you want to process data before importing you can add your code inside “parse_csv_data” function in admin/csv_import/data_parsing.php

*) If "Empty Catalog" function will not be used and you don't want the store operator to accidentally delete all the items in the store, set "allow_empty_db = 0" in csv_import.ini



That's all.

-----------------------------

CATEGORIES IMPORT 

Starting from v2.0.0 version you can import categories by name.

Categories must be specified by category path, so starting from top level category towards the one the product belongs to.

For example, if a product belongs to "Hardware -> Graphics Cards -> AGP" category you must write the category path separated by dots:

	Hardware.Graphics Cards.AGP

You must write the category names exactly and you can add all spaces you want between separator dots.

If one or more categories don't exist they will be created.

You can also add multiple category association, so if a product belongs to more than one category you must write this way:

Hardware.Graphics Cards.AGP|Hardware.Graphics Cards.DVI

The imported product will be put in both categories.

------------------------------

REMOTE IMAGES IMPORT

You can import remote images just putting the url inside the image field. The image will be grabbed to the local images folder. You have two options:

1) Just putting URL of the file, ex: http://external.server.com/image.jpg . In this case the name of the image will be the same of the remote one.

2) Put name and URL together: image.jpg|http://external.server.com/get_image.php?id=qwerty . This is useful when you have not a file, but a script that outputs the image.

You can also use the second option for the first example.

---------
CHANGES LOG

v2.1.3 (02/02/2008)
	- Danish language added (thanks to Olafur)

v2.1.2 (29/12/2008)
	- products_date_added is set only when inserting
	- products_last_modified is updated when updating

v2.1.1 (17/12/2008)
	- fixed bug in data parsing (price and weight)

v2.1.0 (29/09/2008)
	- minor bugs fixed
	- experimental configuration GUI

v2.0.3 (18/09/2008)
	- little documentation revision (thanks to Vince)

v2.0.2 (18/09/2008)
	- source code revision
	- added dutch language
	- added allow_empty_db in config file to not allow emptying catalog

v2.0.1 (10/09/2008)
	- removed unused code
	- few bugs fixes
	- changed default csv separator to semicolon
	- few language adjustments
	- few instructions additions and adjustments
	- image remote import improvement. Now can import from script url (ex /get_image.php?id=#).

v2.0.0 (07/09/2008)
	- revisited import code
	- added configuration by ini file
	- added categories import by name (path) or id. Non existant will be created. Can even add multiple categories.
	- tax class can be either id or class name, if name not exists it will be created
	- manufacturer can be either id or manufacturer name, if name not exists it will be created
	- added capability to import images from remote locations (php curl library needed), just fill in the link in the image field (must start with http:// )

v1.2.5 (20/11/2007)
	- fixed a bug in the import process when the model field is empty.
	- added support for register_globals = off
	- added DEBUG mode
	- added folder permissions check
	- few code improvements

v1.2.4 (12/11/2007)
	- added "CORRECT_FIELDS_COUNT" setting inside csv_import.php to handle the field count mismatch policy.
	- german translation (thanks to dwex)

v1.2.2 (23/08/2007)
	- file load error fixed (it was due by a little try that i forgot to clear, thanks to boclodoa)

v1.2.1 (28/07/2007)
	- few improvements
	- graphical restyling

v1.2 (18/05/2007)
	- Added tax class field (you must insert its ID)
	- Added manufacturer name field, the script automatically manages it: inserts it if not present in the manufacturers table.
	- Now you can update the products using products_model fields as unique ID, it can handle duplicated products_model error.
	
v1.1
	- Bug fix in languages import