<?php
// $Id: germanf.messages.php 88 2009-09-08 17:21:03Z gerrit_hoekstra $
// Deutsche Übersetzung - German Translation
// Formelle Anrede
//
// Component Basics
// {{ No need to translate these two strings
define("VL_NAME","Virtual Library");
define("VL_VERSION","0.8");
// }}

// Header
define("VL_DESCRIPTION", "Virtuelle Bibliothek bei [mosConfig_live_site]" );

// Footer
define("VL_FOOTER", "Virtual Library Version %s 2007 - <a target=\"_blank\" href=\"http://www.hoekstra.co.uk/\">www.hoekstra.co.uk</a>");

// Display Edit Field Names
define("VL_EDT_NAME_MEDIA","Medie");
define("VL_EDT_NAME_ABSTRACT","Kurzfassung");
define("VL_EDT_NAME_ADDRESS","Verlagsadresse");
define("VL_EDT_NAME_ANNOTE","Anmerkung");
define("VL_EDT_NAME_AUTHORSNAMES","Autorname");
define("VL_EDT_NAME_BOOKTITLE","Buchtitel");
define("VL_EDT_NAME_CHAPTER","Kapittel");
define("VL_EDT_NAME_CHECKEDOUT","Ausgechecked");
define("VL_EDT_NAME_CITE","Zitierung");
define("VL_EDT_NAME_DDC","DDC");
define("VL_EDT_NAME_EDITION","Ausgabe");
define("VL_EDT_NAME_EDITOR","Redakteur");
define("VL_EDT_NAME_EPRINT","eBuch");
define("VL_EDT_NAME_HOWPUBLISHED","Veröffentlichungsweise");
define("VL_EDT_NAME_IMAGE","Bild");
define("VL_EDT_NAME_INSTITUTION","Anstalt");
define("VL_EDT_NAME_ISBN","ISBN");
define("VL_EDT_NAME_ISSN","ISSN");
define("VL_EDT_NAME_JOURNAL","Journal");
define("VL_EDT_NAME_KEY","Override-Schlüssel");
define("VL_EDT_NAME_KEYWORDS","Stichwörter ");
define("VL_EDT_NAME_LOCID","Locid");
define("VL_EDT_NAME_MONTH","Monat");
define("VL_EDT_NAME_NOTE","Notiz");
define("VL_EDT_NAME_NUMBER","Nummer");
define("VL_EDT_NAME_ORGANIZATION","Organisation");
define("VL_EDT_NAME_PAGES","Seiten");
define("VL_EDT_NAME_PUBLISHED","Veröffentlicht");
define("VL_EDT_NAME_PUBLISHER","Verlag");
define("VL_EDT_NAME_SCHOOL","Schule");
define("VL_EDT_NAME_SERIES","Serie");
define("VL_EDT_NAME_SHORTAUTHNAMES","Kurze Autornamen");
define("VL_EDT_NAME_TITLE","Titel");
define("VL_EDT_NAME_TYPE","Literaturtype");
define("VL_EDT_NAME_URL","URL-Adresse");
define("VL_EDT_NAME_VIEWED","Angeschaut");
define("VL_EDT_NAME_VOLUME","Band");
define("VL_EDT_NAME_YEAR","Jaar");

define("VL_EDT_NAME_FIRST","Vorname");
define("VL_EDT_NAME_VON","Familiennamenpräfix");
define("VL_EDT_NAME_LAST","Familienname");
define("VL_EDT_NAME_JR","Familiennamesuffix");

define("VL_EDT_NAME_CAT","Fachkategorie");


// Display Edit Field Descriptions
define("VL_EDT_DESC_MEDIA","Publikationmedie");
define("VL_EDT_DESC_ABSTRACT","Kurzfassung dieser Publikation");
define("VL_EDT_DESC_ADDRESS","Verlagadresse in eine eizelne Zeile");
define("VL_EDT_DESC_ANNOTE","Anmerkung zum Artikel in Ihrem Literaturverzeichnis.");
define("VL_EDT_DESC_AUTHORSNAMES","Liste der Autoren der Publikation");
define("VL_EDT_DESC_BOOKTITLE","Titel des Buches wenn nur ein Teil davon als Hinweis zitiert wird");
define("VL_EDT_DESC_CHAPTER","Ausgewählte Kapitel für Ihren Literaturverzeichnis, wenn überhaupt");
define("VL_EDT_DESC_CHECKEDOUT","Artikel ist in Joomla ausgechecked");
define("VL_EDT_DESC_CITE","Ihre eigene Abkürzung für diese Publikation. Wenn nicht besorgt, wird die nächste ganzzahlige Nummer für Sie gegeneriert.");
define("VL_EDT_DESC_DDC","Dewey Decimal Classification-Nummer des Buches");
define("VL_EDT_DESC_EDITION","Die Ausgabe der Publikation, wenn bekannt.");
define("VL_EDT_DESC_EDITOR","Der Name des Redakteurs, wenn überhaupt");
define("VL_EDT_DESC_EPRINT","Relative oder abolute URL-Adresse wo eine Kopie dieses eBuchs gefinden werden kann.");
define("VL_EDT_DESC_HOWPUBLISHED","Kurze Bezeichnung wie diese veröffentlicht worden ist, wenn es auf ungewöhnlicher Weise war");
define("VL_EDT_DESC_IMAGE","Name of front cover thumbnail in thumbs directory. If you do not have a thumb file yet, you can always edit this publication later on again.");
define("VL_EDT_DESC_INSTITUTION","The institution that was involved in the publishing, but not necessarily the publisher");
define("VL_EDT_DESC_ISBN","International Standard Book Number - Nur für Bücher gemeint.");
define("VL_EDT_DESC_ISSN","International Standard Serial Number - Nur für Journalen, Zeitschriften usw. gemeint.");
define("VL_EDT_DESC_JOURNAL","Der Journal oder die Zeitschrift wo dieses Werk veröffentlicht worden ist.");
define("VL_EDT_DESC_KEY","A hidden label when the author or editor names are not known or for overriding the order of listing in your bibliography.");
define("VL_EDT_DESC_KEYWORDS","Keywords that help identify this publication when searching publications");
define("VL_EDT_DESC_LOCID","Location Id of physical book");
define("VL_EDT_DESC_MONTH","The month that this was published");
define("VL_EDT_DESC_NOTE","Ihre eigene Notizen");
define("VL_EDT_DESC_NUMBER","Journalnummer wenn es ein Journal ist. Beachte dass viele akademische Publikationen nur einen 'Band' aber keine 'Nummer' haben.");
define("VL_EDT_DESC_ORGANIZATION","Organisation die die Publikation unterstützten / befürworteten.");
define("VL_EDT_DESC_PAGES","Seitenzahl der Publikation");
define("VL_EDT_DESC_PUBLISHED","This Item is published, which means that it visitors to your site will be able to see it in your Virtual Library. If you are still working on the entry or do not want this visible, set this to Unpublished");
define("VL_EDT_DESC_PUBLISHER","Verlagsname - meistens der Firmenname.");
define("VL_EDT_DESC_SCHOOL","Name der Schule oder des akademischen Instituts die die Publikation unterstützte, bzw. wo die These geschrieben würde.");
define("VL_EDT_DESC_SERIES","Der Name der Serie an der diese Publikation gehöhrt, zB. 'Harry Potter'");
define("VL_EDT_DESC_SHORTAUTHNAMES","Beliebige Abkürzung von alle Autornamen wenn es mehere Autoren gibt. Sonnst wird der erste Autorname gebraucht und wird ein weiteres 'et al' beigefügt, in dessen Fall es wichtig ist dass der wichtigste Autor auch der erste Author ist Sie eintragen.");
define("VL_EDT_DESC_TITLE","Titel wie es in der Publikation erscheint. Sie sollen es nich verkürzen!");
define("VL_EDT_DESC_TYPE","Literaturtype: Artikel, Buch, Handbuch, Patent, usw.");
define("VL_EDT_DESC_URL","Vollständige URL-Adresse der Internetseite wo diese Publikation veröffentlicht ist, zB. die des Verlags. Das ist nicht unbedingt dieselbe Adresse wie die Herunterladadresse.");
define("VL_EDT_DESC_VIEWED","Number of detail and ebook views");
define("VL_EDT_DESC_VOLUME","The name of the journal of the volume number if this is a multi-volume book");
define("VL_EDT_DESC_YEAR","The year that the publication was published");

define("VL_EDT_DESC_FIRST","Der/Die Autor/ins Vorname");
define("VL_EDT_DESC_VON","Familiennamenpäfix wie 'von' in 'von M&uuml;nchausen' oder 'van' wie in 'van Halen'");
define("VL_EDT_DESC_LAST","Der/Die Autor/ins Familienname / Letztername");
define("VL_EDT_DESC_JR","Altmodischer Familiennamensuffix wie zB. 'Jr.', 'Sr.' or 'Esq.'");

define("VL_EDT_DESC_CAT","Wähle die Fachkategorie die Sie an der Publikation anweisen möchten. Sie können mehr als eine Kategorie wählen wenn Sie die Steuerungstaste (Strg) währent der Wahl herabdrücken.");

// Configuration table field names
define("VL_CNF_NAME_ADD","Allow user add");
define("VL_CNF_NAME_COL_ABSTRACT","Kurzfassung");
define("VL_CNF_NAME_COL_ANNOTE","Anmerkung");
define("VL_CNF_NAME_COL_AUTHORS","Authors or Editor");
define("VL_CNF_NAME_COL_CHAPTER","Kapitel");
define("VL_CNF_NAME_COL_CITE","Eigene Abkürzung");
define("VL_CNF_NAME_COL_DDC","Dewey-Nummer");
define("VL_CNF_NAME_COL_EDITION","Ausgabe");
define("VL_CNF_NAME_COL_EPRINT","eBook or Link");
define("VL_CNF_NAME_COL_IMAGE","Bucheinband");
define("VL_CNF_NAME_COL_ISBNISSN","ISBN oder ISSN-Nummer");
define("VL_CNF_NAME_COL_LOC","Location");
define("VL_CNF_NAME_COL_NOTE","Eigene Notizen");
define("VL_CNF_NAME_COL_PAGES","Seitenzahl");
define("VL_CNF_NAME_COL_PUBDATE","Veröffenlichungsjaar und Monat");
define("VL_CNF_NAME_COL_PUBLISHER","Verlagsname oder Journal");
define("VL_CNF_NAME_COL_TITLE","Publikationtitel");
define("VL_CNF_NAME_COL_TYPE","Literaturtype");
define("VL_CNF_NAME_COL_URL","WWW-Adresse");
define("VL_CNF_NAME_DOWNLOAD","Allow BibTeX export");
define("VL_CNF_NAME_EDIT","Allow user edit");
define("VL_CNF_NAME_ETAL","Gebrauch 'et al' für Autoren.");
define("VL_CNF_NAME_FORMATTED","Text display");
define("VL_CNF_NAME_FULLNAMES","Display full names");
define("VL_CNF_NAME_MANUALINPUT","Manuelle Eingabe");
define("VL_CNF_NAME_SHOWLOGO","Zeig Komponent-Logo");
define("VL_CNF_NAME_SMALLICONS","Kleine Ikone");
define("VL_CNF_NAME_SQUEEZE","In eine Zeile einpassen");

// Configuration table field descrioptions
define("VL_CNF_DESC_ADD","Allow frontend users to add new publications");
define("VL_CNF_DESC_COL_ABSTRACT","User-entered publication abstract");
define("VL_CNF_DESC_COL_ANNOTE","An annotation for annotated bibliography styles (not typical)");
define("VL_CNF_DESC_COL_AUTHORS","Display the first author of the publication and then et al if there are further authors, or the editor. The order of this column can be overridden with a user-defined value in the key field.");
define("VL_CNF_DESC_COL_CHAPTER","The chapter or section cited as a reference or which ebook librarian feels is important.");
define("VL_CNF_DESC_COL_CITE","Your own abbreviation for the publication that you refer to instead of the author name");
define("VL_CNF_DESC_COL_DDC","Show the Dewey Decimal Classification number.");
define("VL_CNF_DESC_COL_EDITION","The edition of a book in ordinal form, e.g. First or Second");
define("VL_CNF_DESC_COL_EPRINT","Indicates if it is an electronic publication");
define("VL_CNF_DESC_COL_IMAGE","Image of the front cover of the publication");
define("VL_CNF_DESC_COL_ISBNISSN","ISBN number if it a book, ISSN number if it a journal");
define("VL_CNF_DESC_COL_LOC","Shortened description of the physical location of the publication.");
define("VL_CNF_DESC_COL_NOTE","Miscellaneous extra information about the publication, if any");
define("VL_CNF_DESC_COL_PAGES","One or more page numbers or range of numbers, such as 42-111 or 7,41,73-97 or 43");
define("VL_CNF_DESC_COL_PUBDATE","The year and month (if known) of publication or, if unpublished, the year and month of creation");
define("VL_CNF_DESC_COL_PUBLISHER","The name of the publisher or the name of the journal and number. Also includes the institution that sponsored the publication, the organization that sponsored the publication, the school where the work was written and how it was published if the publishing method is nonstandard");
define("VL_CNF_DESC_COL_TITLE","The title of the publication or title of the book if it contains the publication. Also includes the name of the series of books that the book was published in, e.g. The Hardy Boys");
define("VL_CNF_DESC_COL_TYPE","Can be one of a predefined set of publication types, e.g. article, book, manual");
define("VL_CNF_DESC_COL_URL","Relative or absolute URL to publication");
define("VL_CNF_DESC_DOWNLOAD","Allow frontend users to export the library as a BibTex file");
define("VL_CNF_DESC_EDIT","Allow frontend users to edit");
define("VL_CNF_DESC_ETAL","Shorten multiple author names in table and text display to the main author and the 'et al.' abbreviation");
define("VL_CNF_DESC_FORMATTED","Display formatted text instead of table and columns");
define("VL_CNF_DESC_FULLNAMES","Show full names rather than just surnames when displaying publications");
define("VL_CNF_DESC_MANUALINPUT","Allow manual input of fields when adding new a publication");
define("VL_CNF_DESC_SHOWLOGO","Display the Virtual Library logo at the bottom of the page");
define("VL_CNF_DESC_SMALLICONS","Display small instead of large icons for links");
define("VL_CNF_DESC_SQUEEZE","Shorten titles, author names etc. to fit one publication on one line in table display");

// Publication Types
define("VL_TYPE_ARTICLE","Artikel");
define("VL_TYPE_BOOK","Buch");
define("VL_TYPE_BOOKLET","Büchlein");
define("VL_TYPE_CONFERENCE","Konferenz-verfahren");
define("VL_TYPE_COLLECTION","Sammlung von Arbeiten");
define("VL_TYPE_INBOOK","Teil eines Buches");
define("VL_TYPE_INCOLLECTION","Teil einer Büchersammlung");
define("VL_TYPE_MANUAL","Technische  Dokumentierung");
define("VL_TYPE_MASTERSTHESIS","These");
define("VL_TYPE_MISC","Diverses");
define("VL_TYPE_TECHREPORT","Technischer Bericht");
define("VL_TYPE_UNPUBLISHED","Unveröffentlicht");
define("VL_TYPE_PATENT","Patent");

// General
define("VL_ACCESS_SETTINGS","Zugangseinstellungen");
define("VL_ACCESS_SETTINGS_DESC","Specify to what degree you want users to change the content of the virtual library or bibliography");
define("VL_AUTHOR_DETAILS_ENTER","Details for Author %s (of %s)");
define("VL_AUTHOR_DETAILS_ENTER_DESC","For a useful virtual library or bibliography, you should enter at least the author's surname.");
define("VL_AUTHOR_ENTER_NUMBER","Autorenzahl");
define("VL_AUTHOR_ENTER_NUMBER_DESC","Choose the number of authors of this publication. Not all authors will always be displayed and the author list for a publication will sometimes be shorted to the first author and the Latin 'et al', so ensure that the first author that you enter is the most prominent author. Remember that you can add authors at a later stage.");
define("VL_AUTHOR_FILTER","Filter on Authors");
define("VL_AUTHOR_INPUT","Author Input");
define("VL_AUTHOR_UNKNOWN","No author or unknown");
define("VL_BIBLIOGRAPHY_DETAILS","Bibliography Details");
define("VL_BIBLIOGRAPHY_DETAILS_DESC","These details are optional. Fill them in only if you want to create a formal bibliography.");
define("VL_BIBTEX_FILE_UPLOAD","BibTeX Datei Hochladen");
define("VL_BIBTEX_FILE_CHOOSE","Wähle die BibTeX-Datei zum hochladen");
define("VL_BIBTEX_FILE_CHOOSE_DESC","Wähle eine Datei mit eine .bib-Erweiterung von Ihrem Rechner und klick den Upload-Knopf.");
define("VL_CONFIGURATION","Konfiguration");
define("VL_COPYPASTE_BIBTEX","Copy&amp;Paste BibTeX input");
define("VL_PASTE_BIBTEX_STRING","Paste BibTeX String");
define("VL_COVER_IMAGE","Cover Image");
define("VL_DATA_SAVED","Data Saved");
define("VL_DETAIL_INPUT","Detail Input");
define("VL_EBOOK","Electronic Document / eBook");
define("VL_EBOOK_DESC","The relative directory and actual file name is required. An eBook consisting of multiple files should be hosted in its own directory and the main entry file should be indicated - mostly something like 'publication_title.html' or 'index.html'.");
define("VL_EDIT_PUBLICATION","Edit Publication");
define("VL_EDIT_X_PUBLICATION","Edit existing Publication");
define("VL_FILE_DATE","Datei Datum");
define("VL_FILE_EXT","Dateierweiterung");
define("VL_FILE_NAME","Datei Name");
define("VL_FILE_SIZE","Datei Grösse");
define("VL_GENERAL_DISPLAY","General Display");
define("VL_GENERAL_DISPLAY_DESC","High-level control of the display of the virtual library or bibliography content");
define("VL_INPUT_FIELDS","Input Fields");
define("VL_MANUAL_INPUT","Manual Input");
define("VL_MEDIA_TYPE","Media Type");
define("VL_MEDIA_TYPE_DESC","The media that this publication has been published on. e.g. printed on paper, electronic document / ebook, website, CDROM, ancient clay tablet, etc. If it an electronic document, then you will also have the opportunity to upload it.");
define("VL_MIME_TYPE","Mime Type");
define("VL_NEW_SUBJECT_CATEGORY","Neue Fachkategorie");
define("VL_NUMBER_OF_AUTHORS","Autorenzahl");
define("VL_OTHER_MEDIA","Andere Medie");
define("VL_OTHER_MEDIA_DESC","Any other type of output media not listed here that this publication is published on");
define("VL_PRINTED_MEDIA","Gedruckte Medie");
define("VL_PRINTED_MEDIA_DESC","Most publications are printed on paper. Remember to recycle your printed publication when you are done with it ;-)");
define("VL_PUBLICATION_SELECT_MONTH"," - Wähle Monat");
define("VL_PUBLICATION_COVERS","Publikation Covers");
define("VL_PUBLICATION_DETAILS","Publikation Details");
define("VL_PUBLICATION_DETAILS_DESC","Nur der Titel ist verpflichtend, aber wenn man eine schöne Virtuelle Bibliothek haben möchte, dann sollte man die anderen Feldern auch eintragen.");
define("VL_PUBLICATION_MANAGER","Publication Manager");
define("VL_PUBLICATION_MANUAL_ENTRY","Manual Entry for New Publication");
define("VL_PUBLICATION_EDITED","Publication Edited");
define("VL_PUBLICATIONS","Publikationen");
define("VL_SUBJECT_CATEGORY","Fachkategorie");
define("VL_SUBJECT_MANAGER","Fach-Manager");
define("VL_SUBJECTS","Fächer");
define("VL_TABLE_COLUMN_SELECTION","Tabelspalten Wahl");
define("VL_TABLE_COLUMN_SELECTION_DESC","Indicate which aspects of your publications are displayed in the table display. Note that all aspects will be displayed when the user views the details of the publication.");
define("VL_TITLE_FILTER","Filter on Title");
define("VL_TOOLBAR_BACK","Zurück");
define("VL_TOOLBAR_CANCEL","Cancel");
define("VL_TOOLBAR_CATEGORY_DELETE","Lösch Fach");
define("VL_TOOLBAR_CATEGORY_EDIT","Editier Kategorie");
define("VL_TOOLBAR_CATEGORY_NEW","Neuer Fach");
define("VL_TOOLBAR_DELETE_ALL_PUBLICATIONS","Lösche Alle");
define("VL_TOOLBAR_DELETE_CAT_WARNING","This will remove all book references that belong to this subject catagory");
define("VL_TOOLBAR_DELETE_PUB_WARNING","Note: This will permanently delete the item.");
define("VL_TOOLBAR_DELETE_PUBLICATION","Lösch");
define("VL_TOOLBAR_FINISH_SAVE","Fertig &amp; Speichern");
define("VL_TOOLBAR_NEXT","Nächster");
define("VL_TOOLBAR_PASTE_BIBTEX_STRING","Paste BibTeX string");
define("VL_TOOLBAR_PUBLICATION_CREATE_NEW","Schöpf Neu");
define("VL_TOOLBAR_PUBLICATION_EDIT","Publikation editieren");
define("VL_TOOLBAR_PUBLICATION_UPLOAD","Publikation hochladen");
define("VL_TOOLBAR_PUBLICATIONS_UPLOAD","Publikationsverzeichnis hochladen");
define("VL_TOOLBAR_PUBLISH","Veröffentlichen");
define("VL_TOOLBAR_SAVE","Speichern");
define("VL_TOOLBAR_UNPUBLISH","Unveröffentlichen");
define("VL_TOOLBAR_UPLOAD_BIBTEX_FILE","BibTeX-Datei hochladen");
define("VL_UPLOAD_EBOOK","eBuch Hochladen");
define("VL_UPLOAD_EBOOK_DESC","Select the eBook file that you are creating this publication entry for and click the Upload button. Note that there are still some web-servers that do not support the uploading of files over 1MByte, in which case you need to FTP the ebook file to the server.");

define("VL_UPLOAD_PUBLICATION_IMAGE","Upload Publication Cover");
define("VL_UPLOAD_PUBLICATION_IMAGE_DESC","Select a scanned-in image of the cover of this publication from your local machine and click the Upload button. The image will be scaled to 54 pixels wide and 70 pixels heigh and your uploaded will be discarded.");
define("VL_WEBSITE","Internetseite");
define("VL_WEBSITE_DESC","Die vollständige URL-Adresse der Internetseite die nach der Publikation/Zitat zeigt.");

// Error Messages
define("VL_ERROR_PARSE_FILE","Parsierfeher in Datei %s:<br>%s");
define("VL_ERROR_PARSE_STRING","Parsierfehler in der Buchstabenkette:<br>%s");
define("VL_ERROR_BIBTEXFILE","Datei %s ist nicht eine .bib BibTeX-Datei");
define("VL_ERROR_SAVE","Speicherfehler: %s");
define("VL_ERROR_NO_DATA","Keine Daten um zu speichern gefunden");


?>
