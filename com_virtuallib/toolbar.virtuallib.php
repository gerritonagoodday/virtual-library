<?php
// $Id: toolbar.virtuallib.php 90 2009-09-08 17:24:47Z gerrit_hoekstra $

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
require_once( $mainframe->getPath( 'toolbar_html' ) );

//echo "toolbar.virtuallib.php: \$act = $act<br>\$task = $task<br>";

switch ($act) {
  case 'view':
    switch ($task) {
      case "edit":
        menuVirtualLib::EDIT_PUB_MENU();
        break;
      case "paste":
        menuVirtualLib::SAVE_PASTE_MENU();
        break;
      case "upload":
        menuVirtualLib::UPLOAD_BIBTEX_FILE_MENU();
        break;
      default:
        menuVirtualLib::LIST_PUB_MENU();
        break;
    }
    break;
  case 'input':
    switch ($task) {
      case "new":
        menuVirtualLib::FIRST_ENTRY_MENU();
        break;
      case "authornum":
      case "enterauthor":
      case "next":
        // Additional FSM
        $itementryfsm = mosGetParam($_POST,'itementryfsm','');
        $authornum = mosGetParam($_POST,'authornum','');
        // echo "1 toolbar.virtuallib.html.php:<br> \$itementryfsm = $itementryfsm<br>\$authornum = $authornum<br>";
        if(($itementryfsm==40 && $authornum==0) || ($itementryfsm==($authornum+50) && $authornum>0)){
          menuVirtualLib::FINAL_ENTRY_MENU();
        }else{
          menuVirtualLib::NEXT_ENTRY_MENU();
        }
        break;
      case "last":
        menuVirtualLib::FINAL_ENTRY_MENU();
        break;
      case "save":
        menuVirtualLib::SAVE_ENTRY_MENU();
        break;
      default:
        menuVirtualLib::BACK_MENU();
        break;
    }
    break;
  case 'categories':
    switch ($task) {
      case "catEdit":
        menuVirtualLib::LIST_CAT_MENU();
        break;
      case "catNew":
        menuVirtualLib::NEW_CAT_MENU();
        break;
      default:
        menuVirtualLib::LIST_CAT_MENU();
        break;
    }
    break;
  case 'config':
    menuVirtualLib::CONF_MENU();
    break;
  default:
    menuVirtualLib::BACK_MENU();
    break;
}
?>
