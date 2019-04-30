<?php
// $Id: toolbar.virtuallib.html.php 91 2009-09-08 17:25:02Z gerrit_hoekstra $

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class menuVirtualLib{
  function LIST_PUB_MENU() {
   // Publication
    mosMenuBar::startTable();
    mosMenuBar::publish('publish',VL_TOOLBAR_PUBLISH);
    mosMenuBar::spacer();
    mosMenuBar::unpublish('unpublish',VL_TOOLBAR_UNPUBLISH);
    mosMenuBar::spacer();
    mosMenuBar::editList('edit',VL_TOOLBAR_PUBLICATION_EDIT);
    mosMenuBar::spacer();
    mosMenuBar::addNew('new',VL_TOOLBAR_PUBLICATION_CREATE_NEW);
    mosMenuBar::spacer();
    mosMenuBar::custom('paste','paste.png','paste_f2.png',VL_TOOLBAR_PASTE_BIBTEX_STRING,false);
    mosMenuBar::spacer();
    mosMenuBar::custom('upload','upload.png','upload_f2.png',VL_TOOLBAR_UPLOAD_BIBTEX_FILE,false);
    mosMenuBar::spacer();
    //mosMenuBar::custom('uploadPub','upload.png','upload_f2.png',VL_TOOLBAR_PUBLICATION_UPLOAD,false);
    //mosMenuBar::spacer();
    //mosMenuBar::custom('uploadDir','upload.png','upload_f2.png',VL_TOOLBAR_PUBLICATIONS_UPLOAD,false);
    //mosMenuBar::spacer();
    mosMenuBar::deleteList('\n'.VL_TOOLBAR_DELETE_PUB_WARNING, 'remove', VL_TOOLBAR_DELETE_PUBLICATION);
    mosMenuBar::spacer();
    mosMenuBar::custom('allDelete','delete.png', 'delete_f2.png', VL_TOOLBAR_DELETE_ALL_PUBLICATIONS, false);
    mosMenuBar::spacer();
    // TODO: Integrate into the Joomla Help mechanism
    mosMenuBar::help( '../../../../index2.php?option=com_content&task=view&id=76&Itemid=36',true );
    mosMenuBar::endTable();
  }
  function BACK_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::back(VL_TOOLBAR_BACK);
    mosMenuBar::endTable();
  }
  function FIRST_ENTRY_MENU(){
    mosMenuBar::startTable();
    mosMenuBar::cancel('cancel',VL_TOOLBAR_CANCEL);
    mosMenuBar::spacer();
    mosMenuBar::custom('next','next.png', 'next_f2.png', VL_TOOLBAR_NEXT, false);
    mosMenuBar::endTable();
  }
  function NEXT_ENTRY_MENU(){
    mosMenuBar::startTable();
    mosMenuBar::cancel('cancel',VL_TOOLBAR_CANCEL);
    mosMenuBar::spacer();
    mosMenuBar::back(VL_TOOLBAR_BACK);
    mosMenuBar::spacer();
    mosMenuBar::custom('next','next.png', 'next_f2.png', VL_TOOLBAR_NEXT, false);
    mosMenuBar::endTable();
  }
  function FINAL_ENTRY_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::cancel('cancel',VL_TOOLBAR_CANCEL);
    mosMenuBar::spacer();
    mosMenuBar::back(VL_TOOLBAR_BACK);
    mosMenuBar::spacer();
    mosMenuBar::save('save',VL_TOOLBAR_FINISH_SAVE);
    mosMenuBar::endTable();
  }
  function SAVE_ENTRY_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::cancel('cancel',VL_TOOLBAR_CANCEL);
    mosMenuBar::spacer();
    mosMenuBar::back(VL_TOOLBAR_BACK);
    mosMenuBar::spacer();
    mosMenuBar::save('save',VL_TOOLBAR_SAVE);
    mosMenuBar::endTable();
  }
  function SAVE_PASTE_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::cancel('cancel',VL_TOOLBAR_CANCEL);
    mosMenuBar::spacer();
    mosMenuBar::save('save',VL_TOOLBAR_FINISH_SAVE);
    mosMenuBar::endTable();
  }
  function UPLOAD_BIBTEX_FILE_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::cancel('cancel',VL_TOOLBAR_CANCEL);
    mosMenuBar::spacer();
    mosMenuBar::custom('upload','upload.png', 'upload_f2.png', VL_TOOLBAR_UPLOAD_BIBTEX_FILE, false);
    mosMenuBar::endTable();
  }
  function EDIT_PUB_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::cancel('cancel',VL_TOOLBAR_CANCEL);
    mosMenuBar::spacer();
    mosMenuBar::save('saveEdit',VL_TOOLBAR_SAVE);
    mosMenuBar::endTable();
  }
  function CONF_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::back(VL_TOOLBAR_BACK);
    mosMenuBar::spacer();
    mosMenuBar::save('confSave',VL_TOOLBAR_SAVE);
    mosMenuBar::endTable();
  }
  function NEW_CAT_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::cancel('cancel',VL_TOOLBAR_CANCEL);
    mosMenuBar::spacer();
    mosMenuBar::back(VL_TOOLBAR_BACK);
    mosMenuBar::spacer();
    mosMenuBar::save('catSave',VL_TOOLBAR_SAVE);
    mosMenuBar::endTable();
  }
  function LIST_CAT_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::editList('catEdit', VL_TOOLBAR_CATEGORY_EDIT);
    mosMenuBar::spacer();
    mosMenuBar::addNew('catNew',VL_TOOLBAR_CATEGORY_NEW);
    mosMenuBar::spacer();
    mosMenuBar::deleteList('\n'.VL_TOOLBAR_DELETE_CAT_WARNING,'catDelete',VL_TOOLBAR_CATEGORY_DELETE);
    mosMenuBar::spacer();
    mosMenuBar::back('Back');
    mosMenuBar::endTable();
  }
}
?>
