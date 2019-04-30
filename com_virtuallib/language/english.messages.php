<?php
// $Id: english.messages.php 88 2009-09-08 17:21:03Z gerrit_hoekstra $
// English Core language file
//
// Component Basics
// {{ No need to traslate these two strings
define("VL_NAME","Virtual Library");
define("VL_VERSION","0.8");
// }}

// Header
define("VL_DESCRIPTION", "Virtual Library at [mosConfig_live_site]" );

// Footer
define("VL_FOOTER", "Virtual Library Version %s 2007 - <a target=\"_blank\" href=\"http://www.hoekstra.co.uk/\">www.hoekstra.co.uk</a>");

// Display Edit Field Names
define("VL_EDT_NAME_MEDIA","Media");
define("VL_EDT_NAME_ABSTRACT","Abstract");
define("VL_EDT_NAME_ADDRESS","Publisher's Address");
define("VL_EDT_NAME_ANNOTE","Annotation");
define("VL_EDT_NAME_AUTHORSNAMES","Authorsnames");
define("VL_EDT_NAME_BOOKTITLE","Book title");
define("VL_EDT_NAME_CHAPTER","Chapter");
define("VL_EDT_NAME_CHECKEDOUT","Checkedout");
define("VL_EDT_NAME_CITE","Cite");
define("VL_EDT_NAME_DDC","DDC");
define("VL_EDT_NAME_EDITION","Edition");
define("VL_EDT_NAME_EDITOR","Editor");
define("VL_EDT_NAME_EPRINT","eBook");
define("VL_EDT_NAME_HOWPUBLISHED","Publish method");
define("VL_EDT_NAME_IMAGE","Image");
define("VL_EDT_NAME_INSTITUTION","Institution");
define("VL_EDT_NAME_ISBN","ISBN");
define("VL_EDT_NAME_ISSN","ISSN");
define("VL_EDT_NAME_JOURNAL","Journal");
define("VL_EDT_NAME_KEY","Override Key");
define("VL_EDT_NAME_KEYWORDS","Keywords");
define("VL_EDT_NAME_LOCID","Locid");
define("VL_EDT_NAME_MONTH","Month");
define("VL_EDT_NAME_NOTE","Note");
define("VL_EDT_NAME_NUMBER","Number");
define("VL_EDT_NAME_ORGANIZATION","Organization");
define("VL_EDT_NAME_PAGES","Pages");
define("VL_EDT_NAME_PUBLISHED","Published");
define("VL_EDT_NAME_PUBLISHER","Publisher");
define("VL_EDT_NAME_SCHOOL","School");
define("VL_EDT_NAME_SERIES","Series");
define("VL_EDT_NAME_SHORTAUTHNAMES","Short author names");
define("VL_EDT_NAME_TITLE","Title");
define("VL_EDT_NAME_TYPE","Type of Publication");
define("VL_EDT_NAME_URL","URL");
define("VL_EDT_NAME_VIEWED","Viewed");
define("VL_EDT_NAME_VOLUME","Volume");
define("VL_EDT_NAME_YEAR","Year");

define("VL_EDT_NAME_FIRST","First name");
define("VL_EDT_NAME_VON","Surname prefix");
define("VL_EDT_NAME_LAST","Surname");
define("VL_EDT_NAME_JR","Surname postfix");

define("VL_EDT_NAME_CAT","Subject Category");


// Display Edit Field Descriptions
define("VL_EDT_DESC_MEDIA","Publication output media");
define("VL_EDT_DESC_ABSTRACT","Abstract of this publication");
define("VL_EDT_DESC_ADDRESS","Publisher's address as a single line");
define("VL_EDT_DESC_ANNOTE","Annotation to listing of this item on your bibliography.");
define("VL_EDT_DESC_AUTHORSNAMES","List of authors");
define("VL_EDT_DESC_BOOKTITLE","Title of the book if only part of it is cited as a reference");
define("VL_EDT_DESC_CHAPTER","Selected chapters for your bibliography, if any");
define("VL_EDT_DESC_CHECKEDOUT","Item in Joomla checked out");
define("VL_EDT_DESC_CITE","Your own abbreviation for the publication. If not provided, then an integer-based identity will be generated for you.");
define("VL_EDT_DESC_DDC","Dewey Decimal Classification number for the book");
define("VL_EDT_DESC_EDITION","The publication's edition, if known.");
define("VL_EDT_DESC_EDITOR","The name of the editor, if any");
define("VL_EDT_DESC_EPRINT","Relative or abolute URL of where a copy of the ebook can be found. This is in adition to the URL of the original publisher or author.");
define("VL_EDT_DESC_HOWPUBLISHED","Brief description of how this was published if it was done in an unusual way");
define("VL_EDT_DESC_IMAGE","Name of front cover thumbnail in thumbs directory. If you do not have a thumb file yet, you can always edit this publication later on again.");
define("VL_EDT_DESC_INSTITUTION","The institution that was involved in the publishing, but not necessarily the publisher");
define("VL_EDT_DESC_ISBN","International Standard Book Number - use this for books.");
define("VL_EDT_DESC_ISSN","International Standard Serial Number  use this for journals, magazines");
define("VL_EDT_DESC_JOURNAL","The journal or magazine the work was published in.");
define("VL_EDT_DESC_KEY","A hidden label when the author or editor names are not known or for overriding the order of listing in your bibliography.");
define("VL_EDT_DESC_KEYWORDS","Keywords that help identify this publication when searching publications");
define("VL_EDT_DESC_LOCID","Location Id of physical book");
define("VL_EDT_DESC_MONTH","The month that this was published");
define("VL_EDT_DESC_NOTE","Your own notes");
define("VL_EDT_DESC_NUMBER","Journal Number if this is a journal. Note that many academic publications have a 'volume', but no 'number'.");
define("VL_EDT_DESC_ORGANIZATION","Organisation that sponsored the publication.");
define("VL_EDT_DESC_PAGES","Number of pages in publication");
define("VL_EDT_DESC_PUBLISHED","This Item is published, which means that it visitors to your site will be able to see it in your Virtual Library. If you are still working on the entry or do not want this visible, set this to Unpublished");
define("VL_EDT_DESC_PUBLISHER","Publisher's name - mostly the name of a company.");
define("VL_EDT_DESC_SCHOOL","Name of school or academic department that advised or supported this publication, i.e. where the thesis was written.");
define("VL_EDT_DESC_SERIES","The name of the series if this publication belongs to a series, e.g. Harry Potter");
define("VL_EDT_DESC_SHORTAUTHNAMES","Optional abbreviation of all the author names if there are many authors. Otherwise Virtual Library will use the first name with an 'et al', in which case you should ensure that the most pertinant author is the first one you enter.");
define("VL_EDT_DESC_TITLE","Title as it appears in the publication. You should not shorten it ");
define("VL_EDT_DESC_TYPE","Type of publication; Article, book, manual, patent, etc..");
define("VL_EDT_DESC_URL","Fully-qualified URL of the website that published the publication. Note that this is not necessarily the place that the publication can be downloaded from.");
define("VL_EDT_DESC_VIEWED","Number of detail and ebook views");
define("VL_EDT_DESC_VOLUME","The name of the journal of the volume number if this is a multi-volume book");
define("VL_EDT_DESC_YEAR","The year that the publication was published");

define("VL_EDT_DESC_FIRST","The author's first name");
define("VL_EDT_DESC_VON","Surname prefix such as the 'von' in 'von M&uuml;nchausen' or 'van' in 'van Halen'");
define("VL_EDT_DESC_LAST","The author's surname / last name");
define("VL_EDT_DESC_JR","A quaint name postfix such as 'Jr', 'Sr' or 'Esq'");

define("VL_EDT_DESC_CAT","Select the Subject Category that you want to assign this publication to. You can choose more than one category for a publication by holding the Ctrl-key down when choosing.");

// Configuration table field names
define("VL_CNF_NAME_ADD","Allow user add");
define("VL_CNF_NAME_COL_ABSTRACT","Abstract");
define("VL_CNF_NAME_COL_ANNOTE","Annotation");
define("VL_CNF_NAME_COL_AUTHORS","Authors or Editor");
define("VL_CNF_NAME_COL_CHAPTER","Chapters");
define("VL_CNF_NAME_COL_CITE","Own abbreviation");
define("VL_CNF_NAME_COL_DDC","Dewey number");
define("VL_CNF_NAME_COL_EDITION","Edition");
define("VL_CNF_NAME_COL_EPRINT","eBook or Link");
define("VL_CNF_NAME_COL_IMAGE","Publication cover");
define("VL_CNF_NAME_COL_ISBNISSN","ISBN or ISSN number");
define("VL_CNF_NAME_COL_LOC","Location");
define("VL_CNF_NAME_COL_NOTE","Personal notes");
define("VL_CNF_NAME_COL_PAGES","Number of pages");
define("VL_CNF_NAME_COL_PUBDATE","Publication Year and Month");
define("VL_CNF_NAME_COL_PUBLISHER","Publisher''s name or Journal");
define("VL_CNF_NAME_COL_TITLE","Publication Title");
define("VL_CNF_NAME_COL_TYPE","Publication Type");
define("VL_CNF_NAME_COL_URL","WWW address");
define("VL_CNF_NAME_DOWNLOAD","Allow BibTeX export");
define("VL_CNF_NAME_EDIT","Allow user edit");
define("VL_CNF_NAME_ETAL","Use 'et al' for authors.");
define("VL_CNF_NAME_FORMATTED","Text display");
define("VL_CNF_NAME_FULLNAMES","Display full names");
define("VL_CNF_NAME_MANUALINPUT","Allow manual input");
define("VL_CNF_NAME_SHOWLOGO","Show Component Logo");
define("VL_CNF_NAME_SMALLICONS","Small icons");
define("VL_CNF_NAME_SQUEEZE","Squeeze into one line");

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
define("VL_TYPE_ARTICLE","Article");
define("VL_TYPE_BOOK","Book");
define("VL_TYPE_BOOKLET","Booklet");
define("VL_TYPE_CONFERENCE","Conference Proceeding");
define("VL_TYPE_COLLECTION","Collection of Works");
define("VL_TYPE_INBOOK","Part of a book");
define("VL_TYPE_INCOLLECTION","Part of a book collection");
define("VL_TYPE_MANUAL","Technical documentation");
define("VL_TYPE_MASTERSTHESIS","Thesis");
define("VL_TYPE_MISC","Miscellaneous");
define("VL_TYPE_TECHREPORT","Technical Report");
define("VL_TYPE_UNPUBLISHED","Unpublished");
define("VL_TYPE_PATENT","Patent");

// General
define("VL_ACCESS_SETTINGS","Access Settings");
define("VL_ACCESS_SETTINGS_DESC","Specify to what degree you want users to change the content of the virtual library or bibliography");
define("VL_AUTHOR_DETAILS_ENTER","Details for Author %s (of %s)");
define("VL_AUTHOR_DETAILS_ENTER_DESC","For a useful virtual library or bibliography, you should enter at least the author's surname.");
define("VL_AUTHOR_ENTER_NUMBER","Number of Authors");
define("VL_AUTHOR_ENTER_NUMBER_DESC","Choose the number of authors of this publication. Not all authors will always be displayed and the author list for a publication will sometimes be shorted to the first author and the Latin 'et al', so ensure that the first author that you enter is the most prominent author. Remember that you can add authors at a later stage.");
define("VL_AUTHOR_FILTER","Filter on Authors");
define("VL_AUTHOR_INPUT","Author Input");
define("VL_AUTHOR_UNKNOWN","No author or unknown");
define("VL_BIBLIOGRAPHY_DETAILS","Bibliography Details");
define("VL_BIBLIOGRAPHY_DETAILS_DESC","These details are optional. Fill them in only if you want to create a formal bibliography.");
define("VL_BIBTEX_FILE_UPLOAD","BibTeX File Upload");
define("VL_BIBTEX_FILE_CHOOSE","Choose BibTeX file to upload");
define("VL_BIBTEX_FILE_CHOOSE_DESC","Select a file with a .bib extension from your local machine and click the Upload button.");
define("VL_CONFIGURATION","Configuration");
define("VL_COPYPASTE_BIBTEX","Copy&amp;Paste BibTeX input");
define("VL_PASTE_BIBTEX_STRING","Paste BibTeX String");
define("VL_COVER_IMAGE","Cover Image");
define("VL_DATA_SAVED","Data Saved");
define("VL_DETAIL_INPUT","Detail Input");
define("VL_EBOOK","Electronic Document / eBook");
define("VL_EBOOK_DESC","The relative directory and actual file name is required. An eBook consisting of multiple files should be hosted in its own directory and the main entry file should be indicated - mostly something like 'publication_title.html' or 'index.html'.");
define("VL_EDIT_PUBLICATION","Edit Publication");
define("VL_EDIT_X_PUBLICATION","Edit existing Publication");
define("VL_FILE_DATE","File Date");
define("VL_FILE_EXT","File Extension");
define("VL_FILE_NAME","File Name");
define("VL_FILE_SIZE","File Size");
define("VL_GENERAL_DISPLAY","General Display");
define("VL_GENERAL_DISPLAY_DESC","High-level control of the display of the virtual library or bibliography content");
define("VL_INPUT_FIELDS","Input Fields");
define("VL_MANUAL_INPUT","Manual Input");
define("VL_MEDIA_TYPE","Media Type");
define("VL_MEDIA_TYPE_DESC","The media that this publication has been published on. e.g. printed on paper, electronic document / ebook, website, CDROM, ancient clay tablet, etc. If it an electronic document, then you will also have the opportunity to upload it.");
define("VL_MIME_TYPE","Mime Type");
define("VL_NEW_SUBJECT_CATEGORY","New Subject Category");
define("VL_NUMBER_OF_AUTHORS","Number of authors");
define("VL_OTHER_MEDIA","Other Media");
define("VL_OTHER_MEDIA_DESC","Any other type of output media not listed here that this publication is published on");
define("VL_PRINTED_MEDIA","Printed Media");
define("VL_PRINTED_MEDIA_DESC","Most publications are printed on paper. Remember to recycle your printed publication when you are done with it ;-)");
define("VL_PUBLICATION_SELECT_MONTH"," - Select Month");
define("VL_PUBLICATION_COVERS","Publication Covers");
define("VL_PUBLICATION_DETAILS","Publication Details");
define("VL_PUBLICATION_DETAILS_DESC","Only the title is mandatory, but for a nice virtual library you might want to add the other fields.");
define("VL_PUBLICATION_MANAGER","Publication Manager");
define("VL_PUBLICATION_MANUAL_ENTRY","Manual Entry for New Publication");
define("VL_PUBLICATION_EDITED","Publication Edited");
define("VL_PUBLICATIONS","Publications");
define("VL_SUBJECT_CATEGORY","Subject Category");
define("VL_SUBJECT_MANAGER","Subject Manager");
define("VL_SUBJECTS","Subjects");
define("VL_TABLE_COLUMN_SELECTION","Table Column Selection");
define("VL_TABLE_COLUMN_SELECTION_DESC","Indicate which aspects of your publications are displayed in the table display. Note that all aspects will be displayed when the user views the details of the publication.");
define("VL_TITLE_FILTER","Filter on Title");
define("VL_TOOLBAR_BACK","Back");
define("VL_TOOLBAR_CANCEL","Cancel");
define("VL_TOOLBAR_CATEGORY_DELETE","Delete Subject");
define("VL_TOOLBAR_CATEGORY_EDIT","Edit Category");
define("VL_TOOLBAR_CATEGORY_NEW","New Subject");
define("VL_TOOLBAR_DELETE_ALL_PUBLICATIONS","Delete All");
define("VL_TOOLBAR_DELETE_CAT_WARNING","This will remove all book references that belong to this subject catagory");
define("VL_TOOLBAR_DELETE_PUB_WARNING","Note: This will permanently delete the item.");
define("VL_TOOLBAR_DELETE_PUBLICATION","Delete");
define("VL_TOOLBAR_FINISH_SAVE","Finish &amp; Save");
define("VL_TOOLBAR_NEXT","Next");
define("VL_TOOLBAR_PASTE_BIBTEX_STRING","Paste BibTeX string");
define("VL_TOOLBAR_PUBLICATION_CREATE_NEW","Create New");
define("VL_TOOLBAR_PUBLICATION_EDIT","Edit Publication");
define("VL_TOOLBAR_PUBLICATION_UPLOAD","Upload Publication");
define("VL_TOOLBAR_PUBLICATIONS_UPLOAD","Upload Directory of Publications");
define("VL_TOOLBAR_PUBLISH","Publish");
define("VL_TOOLBAR_SAVE","Save");
define("VL_TOOLBAR_UNPUBLISH","Unpublish");
define("VL_TOOLBAR_UPLOAD_BIBTEX_FILE","Upload BibTeX file");
define("VL_UPLOAD_EBOOK","Upload eBook");
define("VL_UPLOAD_EBOOK_DESC","Select the eBook file that you are creating this publication entry for and click the Upload button. Note that there are still some web-servers that do not support the uploading of files over 1MByte, in which case you need to FTP the ebook file to the server.");

define("VL_UPLOAD_PUBLICATION_IMAGE","Upload Publication Cover");
define("VL_UPLOAD_PUBLICATION_IMAGE_DESC","Select a scanned-in image of the cover of this publication from your local machine and click the Upload button. The image will be scaled to 54 pixels wide and 70 pixels heigh and your uploaded will be discarded.");
define("VL_WEBSITE","Website");
define("VL_WEBSITE_DESC","The fully-qualified URL to the Website that points to the publication / reference.");

// Error Messages
define("VL_ERROR_PARSE_FILE","Parse error in file %s:<br>%s");
define("VL_ERROR_PARSE_STRING","Parse error in string:<br>%s");
define("VL_ERROR_BIBTEXFILE","File %s is not a .bib BibTeX file");
define("VL_ERROR_SAVE","Save Error: %s");
define("VL_ERROR_NO_DATA","No data found to save");


?>
