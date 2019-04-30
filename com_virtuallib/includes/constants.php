<?php
// $Id$
// Constant Values
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// Generate language-dependent field texts in an array:
// Database field for table_name[field][field name],
//                and table_name[field][field description]

$editfields = array();
//global $editfields;
// Field names
$editfields['media']['name']=VL_EDT_NAME_MEDIA;
$editfields['abstract']['name']=VL_EDT_NAME_ABSTRACT;
$editfields['address']['name']=VL_EDT_NAME_ADDRESS;
$editfields['annote']['name']=VL_EDT_NAME_ANNOTE;
$editfields['authorsnames']['name']=VL_EDT_NAME_AUTHORSNAMES;
$editfields['booktitle']['name']=VL_EDT_NAME_BOOKTITLE;
$editfields['chapter']['name']=VL_EDT_NAME_CHAPTER;
$editfields['checkedout']['name']=VL_EDT_NAME_CHECKEDOUT;
$editfields['cite']['name']=VL_EDT_NAME_CITE;
$editfields['ddc']['name']=VL_EDT_NAME_DDC;
$editfields['edition']['name']=VL_EDT_NAME_EDITION;
$editfields['editor']['name']=VL_EDT_NAME_EDITOR;
$editfields['eprint']['name']=VL_EDT_NAME_EPRINT;
$editfields['howpublished']['name']=VL_EDT_NAME_HOWPUBLISHED;
$editfields['image']['name']=VL_EDT_NAME_IMAGE;
$editfields['institution']['name']=VL_EDT_NAME_INSTITUTION;
$editfields['isbn']['name']=VL_EDT_NAME_ISBN;
$editfields['issn']['name']=VL_EDT_NAME_ISSN;
$editfields['journal']['name']=VL_EDT_NAME_JOURNAL;
$editfields['key']['name']=VL_EDT_NAME_KEY;
$editfields['keywords']['name']=VL_EDT_NAME_KEYWORDS;
$editfields['locid']['name']=VL_EDT_NAME_LOCID;
$editfields['month']['name']=VL_EDT_NAME_MONTH;
$editfields['note']['name']=VL_EDT_NAME_NOTE;
$editfields['number']['name']=VL_EDT_NAME_NUMBER;
$editfields['organization']['name']=VL_EDT_NAME_ORGANIZATION;
$editfields['pages']['name']=VL_EDT_NAME_PAGES;
$editfields['published']['name']=VL_EDT_NAME_PUBLISHED;
$editfields['publisher']['name']=VL_EDT_NAME_PUBLISHER;
$editfields['school']['name']=VL_EDT_NAME_SCHOOL;
$editfields['series']['name']=VL_EDT_NAME_SERIES;
$editfields['shortauthnam']['name']=VL_EDT_NAME_SHORTAUTHNAMES;
$editfields['title']['name']=VL_EDT_NAME_TITLE;
$editfields['type']['name']=VL_EDT_NAME_TYPE;
$editfields['url']['name']=VL_EDT_NAME_URL;
$editfields['viewed']['name']=VL_EDT_NAME_VIEWED;
$editfields['volume']['name']=VL_EDT_NAME_VOLUME;
$editfields['year']['name']=VL_EDT_NAME_YEAR;

$editfields['first']['name']=VL_EDT_NAME_FIRST;
$editfields['von']['name']=VL_EDT_NAME_VON;
$editfields['last']['name']=VL_EDT_NAME_LAST;
$editfields['jr']['name']=VL_EDT_NAME_JR;

$editfields['cat']['name']=VL_EDT_NAME_CAT;


// Field description
$editfields['media']['desc']=VL_EDT_DESC_MEDIA;
$editfields['abstract']['desc']=VL_EDT_DESC_ABSTRACT;
$editfields['address']['desc']=VL_EDT_DESC_ADDRESS;
$editfields['annote']['desc']=VL_EDT_DESC_ANNOTE;
$editfields['authorsnames']['desc']=VL_EDT_DESC_AUTHORSNAMES;
$editfields['booktitle']['desc']=VL_EDT_DESC_BOOKTITLE;
$editfields['chapter']['desc']=VL_EDT_DESC_CHAPTER;
$editfields['checkedout']['desc']=VL_EDT_DESC_CHECKEDOUT;
$editfields['cite']['desc']=VL_EDT_DESC_CITE;
$editfields['ddc']['desc']=VL_EDT_DESC_DDC;
$editfields['edition']['desc']=VL_EDT_DESC_EDITION;
$editfields['editor']['desc']=VL_EDT_DESC_EDITOR;
$editfields['eprint']['desc']=VL_EDT_DESC_EPRINT;
$editfields['howpublished']['desc']=VL_EDT_DESC_HOWPUBLISHED;
$editfields['image']['desc']=VL_EDT_DESC_IMAGE;
$editfields['institution']['desc']=VL_EDT_DESC_INSTITUTION;
$editfields['isbn']['desc']=VL_EDT_DESC_ISBN;
$editfields['issn']['desc']=VL_EDT_DESC_ISSN;
$editfields['journal']['desc']=VL_EDT_DESC_JOURNAL;
$editfields['key']['desc']=VL_EDT_DESC_KEY;
$editfields['keywords']['desc']=VL_EDT_DESC_KEYWORDS;
$editfields['locid']['desc']=VL_EDT_DESC_LOCID;
$editfields['month']['desc']=VL_EDT_DESC_MONTH;
$editfields['note']['desc']=VL_EDT_DESC_NOTE;
$editfields['number']['desc']=VL_EDT_DESC_NUMBER;
$editfields['organization']['desc']=VL_EDT_DESC_ORGANIZATION;
$editfields['pages']['desc']=VL_EDT_DESC_PAGES;
$editfields['published']['desc']=VL_EDT_DESC_PUBLISHED;
$editfields['publisher']['desc']=VL_EDT_DESC_PUBLISHER;
$editfields['school']['desc']=VL_EDT_DESC_SCHOOL;
$editfields['series']['desc']=VL_EDT_DESC_SERIES;
$editfields['shortauthnam']['desc']=VL_EDT_DESC_SHORTAUTHNAMES;
$editfields['title']['desc']=VL_EDT_DESC_TITLE;
$editfields['type']['desc']=VL_EDT_DESC_TYPE;
$editfields['url']['desc']=VL_EDT_DESC_URL;
$editfields['viewed']['desc']=VL_EDT_DESC_VIEWED;
$editfields['volume']['desc']=VL_EDT_DESC_VOLUME;
$editfields['year']['desc']=VL_EDT_DESC_YEAR;

$editfields['first']['desc']=VL_EDT_DESC_FIRST;
$editfields['von']['desc']=VL_EDT_DESC_VON;
$editfields['last']['desc']=VL_EDT_DESC_LAST;
$editfields['jr']['desc']=VL_EDT_DESC_JR;

$editfields['cat']['desc']=VL_EDT_DESC_CAT;

// Configuration fields
$conffields = array();
//global $conffields;

$conffields['add']['name']=VL_CNF_NAME_ADD;
$conffields['col_abstract']['name']=VL_CNF_NAME_COL_ABSTRACT;
$conffields['col_annote']['name']=VL_CNF_NAME_COL_ANNOTE;
$conffields['col_authors']['name']=VL_CNF_NAME_COL_AUTHORS;
$conffields['col_chapter']['name']=VL_CNF_NAME_COL_CHAPTER;
$conffields['col_cite']['name']=VL_CNF_NAME_COL_CITE;
$conffields['col_ddc']['name']=VL_CNF_NAME_COL_DDC;
$conffields['col_edition']['name']=VL_CNF_NAME_COL_EDITION;
$conffields['col_eprint']['name']=VL_CNF_NAME_COL_EPRINT;
$conffields['col_image']['name']=VL_CNF_NAME_COL_IMAGE;
$conffields['col_isbnissn']['name']=VL_CNF_NAME_COL_ISBNISSN;
$conffields['col_loc']['name']=VL_CNF_NAME_COL_LOC;
$conffields['col_note']['name']=VL_CNF_NAME_COL_NOTE;
$conffields['col_pages']['name']=VL_CNF_NAME_COL_PAGES;
$conffields['col_pubdate']['name']=VL_CNF_NAME_COL_PUBDATE;
$conffields['col_publisher']['name']=VL_CNF_NAME_COL_PUBLISHER;
$conffields['col_title']['name']=VL_CNF_NAME_COL_TITLE;
$conffields['col_type']['name']=VL_CNF_NAME_COL_TYPE;
$conffields['col_url']['name']=VL_CNF_NAME_COL_URL;
$conffields['download']['name']=VL_CNF_NAME_DOWNLOAD;
$conffields['edit']['name']=VL_CNF_NAME_EDIT;
$conffields['etal']['name']=VL_CNF_NAME_ETAL;
$conffields['formatted']['name']=VL_CNF_NAME_FORMATTED;
$conffields['fullnames']['name']=VL_CNF_NAME_FULLNAMES;
$conffields['manualinput']['name']=VL_CNF_NAME_MANUALINPUT;
$conffields['showlogo']['name']=VL_CNF_NAME_SHOWLOGO;
$conffields['smallicons']['name']=VL_CNF_NAME_SMALLICONS;
$conffields['squeeze']['name']=VL_CNF_NAME_SQUEEZE;

$conffields['add']['desc']=VL_CNF_DESC_ADD;
$conffields['col_abstract']['desc']=VL_CNF_DESC_COL_ABSTRACT;
$conffields['col_annote']['desc']=VL_CNF_DESC_COL_ANNOTE;
$conffields['col_authors']['desc']=VL_CNF_DESC_COL_AUTHORS;
$conffields['col_chapter']['desc']=VL_CNF_DESC_COL_CHAPTER;
$conffields['col_cite']['desc']=VL_CNF_DESC_COL_CITE;
$conffields['col_ddc']['desc']=VL_CNF_DESC_COL_DDC;
$conffields['col_edition']['desc']=VL_CNF_DESC_COL_EDITION;
$conffields['col_eprint']['desc']=VL_CNF_DESC_COL_EPRINT;
$conffields['col_image']['desc']=VL_CNF_DESC_COL_IMAGE;
$conffields['col_isbnissn']['desc']=VL_CNF_DESC_COL_ISBNISSN;
$conffields['col_loc']['desc']=VL_CNF_DESC_COL_LOC;
$conffields['col_note']['desc']=VL_CNF_DESC_COL_NOTE;
$conffields['col_pages']['desc']=VL_CNF_DESC_COL_PAGES;
$conffields['col_pubdate']['desc']=VL_CNF_DESC_COL_PUBDATE;
$conffields['col_publisher']['desc']=VL_CNF_DESC_COL_PUBLISHER;
$conffields['col_title']['desc']=VL_CNF_DESC_COL_TITLE;
$conffields['col_type']['desc']=VL_CNF_DESC_COL_TYPE;
$conffields['col_url']['desc']=VL_CNF_DESC_COL_URL;
$conffields['download']['desc']=VL_CNF_DESC_DOWNLOAD;
$conffields['edit']['desc']=VL_CNF_DESC_EDIT;
$conffields['etal']['desc']=VL_CNF_DESC_ETAL;
$conffields['formatted']['desc']=VL_CNF_DESC_FORMATTED;
$conffields['fullnames']['desc']=VL_CNF_DESC_FULLNAMES;
$conffields['manualinput']['desc']=VL_CNF_DESC_MANUALINPUT;
$conffields['showlogo']['desc']=VL_CNF_DESC_SHOWLOGO;
$conffields['smallicons']['desc']=VL_CNF_DESC_SMALLICONS;
$conffields['squeeze']['desc']=VL_CNF_DESC_SQUEEZE;

?>
