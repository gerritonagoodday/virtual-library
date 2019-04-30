<?php
// $Id: admin.virtuallib.php 89 2009-09-08 17:23:19Z gerrit_hoekstra $

error_reporting(E_ALL);
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');
//defined( '_JEXEC_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )
    | $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_virtuallib' ))) {
  mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once $GLOBALS['mosConfig_absolute_path'] .'/includes/PEAR/PEAR.php';
require_once $GLOBALS['mosConfig_absolute_path'] .'/components/com_virtuallib/BibTex.php';
require_once($mainframe->getPath('admin_html'));


// Very Basic multilingual stuff
if( !@include_once( $mosConfig_absolute_path ."/administrator/components/com_virtuallib/language/$mosConfig_lang.messages.php" ) ) {
  include_once( $mosConfig_absolute_path ."/administrator/components/com_virtuallib/language/english.messages.php" );
}
include_once( $mosConfig_absolute_path ."/administrator/components/com_virtuallib/includes/constants.php");

$id = mosGetParam( $_POST, 'cid', array(0) );
if(!is_array($id)) {
  $id = array(0);
}

//retrieve config settings
global $database;
$query = "SELECT * from #__virtuallib_config order by type, id;";
$database->setQuery( $query);
$set=$database->loadRowList();
foreach($set as $row){
  $configvalues[$row[0]]=$row[1];      // Value 'on', 'off' etc...
  $configtypes[$row[0]]=$row[3];       // config type: access, display, table columns
}

// TODO: This does not work yet - see css/virtuallib.css
//insertCustomStyle();

//echo "admin.virtuallib.php:<br> \$act = $act<br>\$task = $task<br>";

// MAIN
//
// Example: index2.php?option=com_virtuallib&act=view&task=edit&eid=1
switch($act){
  case "view":
    switch($task) {
      case "publish":
        publishPublication( $id, 1, $option );
        break;
      case "unpublish":
        publishPublication( $id, 0, $option );
        break;
      case "remove":
        deletePublication( $id ,$option);
        break;
      case "allDelete":
        deleteAllPublications($option);
        break;
      case "new":
        mosRedirect("index2.php?option=$option&act=input&task=new");
        break;
      case "catNew":
        mosRedirect("index2.php?option=$option&act=categories&task=catNew");
        break;
      case "edit":
        editPublication($id ,$option);
        break;
      case "saveEdit":
        saveEditPublication($option,$configvalues);
        break;
      case 'cancel':
        checkinPublication($option);
        break;
      case 'upload':
        HTML_VL::uploadBibTeXFile($option);
        break;
      case 'uploadPub':
        // TODO: No available yet
        break;
      case 'paste':
        HTML_VL::pasteBibTeXString($option);
        break;
      case "save": // save on paste - does not work yet!
        savePublication($option,$configvalues);
        break;
      default:
        listPublications($option,$configvalues);
        break;
    }
    break;
  case "input":
    switch($task) {
      case "save":
        savePublication($option,$configvalues);
        break;
      case "cancel":
        mosRedirect("index2.php?option=$option&act=view", "Input operation cancelled");
        break;
      case "new":
      case "next":
      case "last":
      default:
        enterPublication($option,$configvalues,$editfields);
        break;
    }
    break;
  case "categories":
    switch($task) {
      case "catNew":
        enterCategory($option);
        break;
      case "saveCat":
        saveCategory($option);
        break;
      case "catDelete":
        deleteCategory( $id ,$option);
      break;
      default:
        listSubjectCategories($option);
        break;
    }
    break;
  case "config":
    switch($task) {
      case "confSave":
        saveConf($option);
        break;
      default:
        configInput($option,$configvalues,$configtypes,$conffields);
        break;
    }
    break;
  case "about":
    showAbout();
    break;
  default:
    mosRedirect("index2.php?option=$option&act=view");
    break;
}

// Check in item that was being edited
function checkinPublication($option){
  global $database;
  $id = $_POST['id'];
  //check in
  $database->setQuery("update #__virtuallib set checkedout='0' where pubid=(".$id.");");
    if (!$result = $database->query()) {
      echo $database->stderr();
      return false;
    }
  mosRedirect("index2.php?option=$option&act=view");
}

// Save configuration settings
function saveConf($option){
  global $database;
  // TODO: Only update changed values
  $query = "SELECT variable from #__virtuallib_config";
  $database->setQuery( $query);
  $configs = $database->loadResultArray();
  foreach($configs as $config){
    $configparam = mosGetParam( $_REQUEST, $config, 'off' );
    $database->setQuery("update #__virtuallib_config set value='$configparam' where variable='$config';");
    if (!$result = $database->query()) {
      $errors = $errors.$database->stderr();
    }
  }
  mosRedirect("index2.php?option=$option&act=view","Configuration Saved");
}
// Configuration settings input
function configInput($option,$configvalues,$configtypes,$conffields){
  HTML_VL::configInput($option,$configvalues,$configtypes,$conffields);
}

// save edited publication
function saveEditPublication($option,$configvalues){
  global $database;
  $catIds = $_POST['category'];
  $id = $_POST['id'];
  $authornum = $_POST['authornum'];
  $errors="";
  $bibtex = new Structures_BibTex();
  $minibibtex = new Structures_BibTex();
  //get old content from db.
  $query = "SELECT bibtex from #__virtuallib where pubid=(".$id.");";
  $database->setQuery( $query);
  $content=$database->loadResult();
  $minibibtex->addContent($content);
  $minibibtex->parse();
  $newdata = $minibibtex->data[0];

  $allfields = $database->getTableFields(array('#__virtuallib','#__virtuallib_auth'));
  $fields =array_keys($allfields['#__virtuallib']);
  $authfields =array_keys($allfields['#__virtuallib_auth']);
  $authfields = array_diff($authfields,array('id'));
  $authfields = array_diff($authfields,array('num'));
  $fields = array_diff($fields,array('pubid'));
  $fields = array_diff($fields,array('authorsnames'));
  $fields = array_diff($fields,array('shortauthnames'));
  $fields = array_diff($fields,array('checkedout'));
  foreach($fields as $field){
    $stringin=$_POST[$field];
    if(''!=$stringin){
      $newdata[$field]=$stringin;
    }else{
      if(array_key_exists($field,$newdata)){
        //old data needs to be deleted
        unset($newdata[$field]);
        $database->setQuery("update #__virtuallib set ".$field."=NULL where pubid=".$id);
        if (!$result = $database->query()) {
          $errors = $errors.$database->stderr();
        }
      }
    }
  }
  $newauthor=array();
  for($i=0;$i<$authornum;$i++){
    foreach($authfields as $authfield){
      $stringin=$_POST[$authfield.$i];
      $newdata['author'][$i][$authfield] = $stringin;
    }
    if($newdata['author'][$i]['last']!=''){
      $newauthor[]=$newdata['author'][$i];
    }
  }
  if(count($newauthor)>0){
    $newdata['author']=$newauthor;
  }
  $bibtex->addEntry($newdata);
  //check all fields allowed in mysql
  $fields[]='author';
  foreach ($newdata as $fieldsgiven => $valuesgiven) {
    //should we allow key??
    if((!in_array($fieldsgiven,$fields))||strcmp($fieldsgiven,'key')==0) {
      unset($newdata[$fieldsgiven]);
    }
  }
  $authexists = 0;
  if(array_key_exists('author',$newdata)){
    $authexists = 1;
    $autharray = $newdata['author'];
    $newdata = array_diff($newdata,$autharray);
  }
  //prepare statement for inserting fields
  foreach($newdata as $key=>$data){
    $updates[]=$key."='".mysql_real_escape_string($data)."'";
  }
  if(count($updates)){
    $update = implode(",", array_values($updates));
    $database->setQuery("update #__virtuallib set ".$update." where pubid=".$id);
    if (!$result = $database->query()) {
      $errors = $errors.$database->stderr();
    }
  }

  //prepare statement for author info
  if($authexists){
    $authnames = '';
    $shortauthnames = '';
    //delete old values
      $database->setQuery("delete from #__virtuallib_auth where id=".$id);
      if (!$result = $database->query()) {
        $errors = $errors.$database->stderr();
      }
    $authorcount=0;
    foreach ( $autharray as $author) {
      $authorcount++;
      foreach ($author as $afield => $avalues) {
        $author[$afield]=ereg_replace('[{}]','',$avalues);
      }
      $authnames =$authnames." ";
      if($authorcount==1){
        $shortauthnames =$shortauthnames." ";
      }
      if($configvalues['fullnames']=="on"){
        $authnames =$authnames.$author['first']." ";
        if($authorcount==1){
          $shortauthnames =$shortauthnames.$author['first']." ";
        }
      }
      $authnames =$authnames.$author['last'];
      if($authorcount==1){
        $shortauthnames =$shortauthnames.$author['last'];
      }
      $values2 = implode("','", array_values($author));
      $keys2 = implode(",", array_keys($author));
      $database->setQuery("insert into #__virtuallib_auth (id,num,".$keys2.") values (".$id.",".$authorcount.",'".$values2."')");
      if (!$result = $database->query()) {
        $errors = $errors.$database->stderr();
      }
    }
    if($authorcount>2){
      $shortauthnames = $shortauthnames." <i>et al.</i>";
    }else{
      $shortauthnames = $authnames;
    }
    $database->setQuery("update #__virtuallib set authorsnames='".$authnames."' where pubid='".$id."';");
    if (!$result = $database->query()) {
      $errors = $errors.$database->stderr();
    }
    $database->setQuery("update #__virtuallib set shortauthnames='".$shortauthnames."' where pubid='".$id."';");
    if (!$result = $database->query()) {
      $errors = $errors.$database->stderr();
    }
  }
  //sort out categories
  //delete old values
  $database->setQuery("delete from #__virtuallib_categories where id=".$id);
  if (!$result = $database->query()) {
    $errors = $errors.$database->stderr();
  }
  //prepare statements for inserting categoryids
  foreach ( $catIds as $catId ){
    $database->setQuery("insert into #__virtuallib_categories (id,categories) values ('".$id."','".$catId."')");
    if (!$result = $database->query()) {
      $errors = $errors.$database->stderr();
    }
  }
  //prepare statement for inserting bibtex
  $database->setQuery("update #__virtuallib set bibtex='".mysql_real_escape_string ($bibtex->bibTex())."' where pubid=".$id);
  if (!$result = $database->query()) {
    $errors = $errors.$database->stderr();
  }
  //check in
  $database->setQuery("update #__virtuallib set checkedout='0' where pubid=(".$id.");");
  if (!$result = $database->query()) {
    echo $database->stderr();
    return false;
  }
  mosRedirect("index2.php?option=$option&act=view", $errors.VL_PUBLICATION_EDITED);
}

// Change existing publication
function editPublication($id ,$option){
  global $database,$my;
  if($id==array(0)){
    //$id[0] = mosGetParam( $_REQUEST, 'eid', 0 );
    $id[0] = mosGetParam( $_POST, 'eid', 0 );
  }
  $allfields = $database->getTableFields(array('#__virtuallib','#__virtuallib_auth'));
  $fields = array_keys($allfields['#__virtuallib']);
  $authfields = array_keys($allfields['#__virtuallib_auth']);

  // Get publication details
  $query = "SELECT * from #__virtuallib where pubid=(".$id[0].");";
  $database->setQuery( $query);
  $row=$database->loadRowList();
  $row=array_combine_emulated($fields,$row[0]);
  // fail if checked out not by 'me'
  if ($row['checkedout']!=$my->id&&$row['checkedout']!=0) {
    mosRedirect( "index2.php?option=$option", 'The item is currently being edited by another administrator.' );
  }
  //check out item
  $row['checkedout']= $my->id;
  $database->setQuery("update #__virtuallib set checkedout='".$my->id."' where pubid=(".$id[0].");");
  if (!$result = $database->query()) {
    echo $database->stderr();
    return false;
  }
  // get child data for item
  $query = "SELECT * from #__virtuallib_auth where id=(".$id[0].") order by num;";
  $database->setQuery( $query);
  $authrows=$database->loadRowList();
  for($i=0;$i<count($authrows);$i++){
    $authrows[$i]=array_combine_emulated($authfields,$authrows[$i]);
  }
  // number of child items
  //$authornum = mosGetParam( $_REQUEST, 'authornum', count($authrows) );
  $authornum = mosGetParam( $_POST, 'authornum', count($authrows) );
  if($authornum>count($authrows)){
    for($i=count($authrows);$i<$authornum;$i++){
      $authrows[$i]=array_combine_emulated($authfields,array("","","","","",""));
    }
  }
  // Get subject categories
  $query = "SELECT * from #__categories where section='com_virtuallib' order by ordering";
  $database->setQuery( $query);
  $catsobj = $database->loadObjectList();
  foreach($catsobj as $cat){
    $cats[$cat->id]=$cat->name;
  }
  // get categories that this item is in
  $query = "SELECT categories from #__virtuallib_categories where id=(".$id[0].");";
  $database->setQuery( $query);
  $catrows=$database->loadResultArray();

  $authfields = array_diff($authfields,array('id'));
  $authfields = array_diff($authfields,array('num'));
  $fields = array_diff($fields,array('pubid'));
  $fields = array_diff($fields,array('authorsnames'));
  $fields = array_diff($fields,array('shortauthnames'));
  $fields = array_diff($fields,array('checkedout'));

  HTML_VL::editPublication($row,$authrows,$option,$cats,$id[0],$fields,$authfields,$authornum,$catrows);
}

// Delete Subject category
function deleteCategory( $id ,$option){
  global $database;
  foreach($id as $cid){
    //find all relevant references
    $query = "SELECT pubid from #__virtuallib left join #__virtuallib_categories on ,#__virtuallib.pubid=#__virtuallib_categories.id where #__virtuallib_categories.categories=(".$cid.");";
    $database->setQuery( $query);
    $pubids = $database->loadResultArray();
    //delete values from cat table
    $database->setQuery("delete from #__virtuallib_categories where categories=(".$cid.");");
    if (!$result = $database->query()) {
      echo $database->stderr();
      return false;
    }
    //clean up author and content data:
    foreach($pubids as $aid){
      //find all relevant references
      $query = "SELECT categories from #__virtuallib_categories where id=(".$aid.");";
      $database->setQuery( $query);
      $catids = $database->loadResultArray();
      if(count($catids)==0){
        $database->setQuery("delete from #__virtuallib_auth where id=(".$aid.");");
        if (!$result = $database->query()) {
          echo $database->stderr();
          return false;
        }
        /*
        $database->setQuery("delete from #__virtuallib_bibtex where id=(".$aid.");");
        if (!$result = $database->query()) {
          echo $database->stderr();
          return false;
        }
        */
      }
    }
    //finally delete category
    $database->setQuery("delete from #__categories where id=(".$cid.");");
    if (!$result = $database->query()) {
      echo $database->stderr();
      return false;
    }
  }
  mosRedirect("index2.php?option=$option&act=categories", "Subjects Deleted");
}

// save subject category
function saveCategory($option){
  global $database;
  $message="Category Added";
  $catName = $_POST['catName'];
  $catDesc = $_POST['catDesc'];
  $database->setQuery("insert into #__categories (name,description,params,section,published,title) ".
                      "values ('".$catName."','".$catDesc."','','com_virtuallib','1','".$catName."');");
  if (!$result = $database->query()) {
    $errors = $errors.$database->stderr();
  }
  mosRedirect("index2.php?option=$option&act=categories");
}

// Edit and New subject category
function enterCategory($option){
  HTML_VL::enterCategory($option);
}

// list subject categories with filter
function listSubjectCategories($option){
  global $database, $mainframe, $mosConfig_list_limit;
  $limit      = intval( $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit ) );
  $limitstart = intval( $mainframe->getUserStateFromRequest( "viewban{$option}limitstart", 'limitstart', 0 ) );
  // Get & apply Search parameters
  $where  = array();
  $search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
  if(get_magic_quotes_gpc()){$search = stripslashes( $search );}
  if($search){$where[] = "lower(name) like '%".$database->getEscaped(trim(strtolower($search)))."%'";}

  // get the total number of records
  $query = "SELECT COUNT(*) from #__categories where section='com_virtuallib'";
  $database->setQuery($query);
  $total = $database->loadResult();

  require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
  $pageNav = new mosPageNav( $total, $limitstart, $limit );

  $query = "SELECT * from #__categories where section='com_virtuallib' "
           .( count($where)? ' and '.implode(' AND ', $where ) : '' ).
           " order by ordering";
  $database->setQuery($query);
  $rows = $database->loadObjectList();
  HTML_VL::listSubjectCategories($rows,$pageNav,$option,$search);
}

//delete one or more selected entries
function deletePublication($id,$option){
  global $database;
  foreach($id as $cid){
    $database->setQuery("delete from #__virtuallib where pubid=(".$cid.");");
    if (!$result = $database->query()) {
      echo $database->stderr();
      return false;
    }
    $database->setQuery("delete from #__virtuallib_auth where id=(".$cid.");");
    if (!$result = $database->query()) {
      echo $database->stderr();
      return false;
    }
    /*
    $database->setQuery("delete from #__virtuallib_bibtex where id=(".$cid.");");
    if (!$result = $database->query()) {
      echo $database->stderr();
      return false;
    }
    */
    $database->setQuery("delete from #__virtuallib_categories where id=(".$cid.");");
    if (!$result = $database->query()) {
      echo $database->stderr();
      return false;
    }
  }
  mosRedirect("index2.php?option=$option&act=view", "Items Deleted");
}

// delete all publications
function deleteAllPublications($option){
  global $database;
    $database->setQuery("delete from #__virtuallib;");
    if (!$result = $database->query()) {
      echo $database->stderr();
      return false;
    }
    $database->setQuery("delete from #__virtuallib_auth;");
    if (!$result = $database->query()) {
      echo $database->stderr();
      return false;
    }
    /*
    $database->setQuery("delete from #__virtuallib_bibtex;");
    if (!$result = $database->query()) {
      echo $database->stderr();
      return false;
    }
    */
    $database->setQuery("delete from #__virtuallib_categories;");
    if (!$result = $database->query()) {
      echo $database->stderr();
      return false;
    }
  mosRedirect("index2.php?option=$option&act=view", "Items Deleted");
}

// list publications
function listPublications($option,$configvalues) {
  global $database, $mainframe, $mosConfig_list_limit;
  $where = array();
  $limit      = intval( $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit ) );
  $limitstart = intval( $mainframe->getUserStateFromRequest( "viewban{$option}limitstart", 'limitstart', 0 ) );
  // Get & apply Author Search parameters
  $authsearch = $mainframe->getUserStateFromRequest( "authsearch{$option}", 'authsearch');
  if (get_magic_quotes_gpc()) { $authsearch = stripslashes( $authsearch );}
  if ( $authsearch ) {$where[] = "lower(a2.last) like '%" . $database->getEscaped(trim(strtolower($authsearch)))."%'";}
  // Get & apply Title Search parameters
  $titlesearch = $mainframe->getUserStateFromRequest("titlesearch{$option}",'titlesearch');
  if (get_magic_quotes_gpc()) {$titlesearch = stripslashes( $titlesearch );}
  if ( $titlesearch ) {$where[] = "lower(b1.title) like '%" . $database->getEscaped(trim(strtolower($titlesearch )))."%'";}
  // Get & apply category criteria
  $last_catid = intval($mainframe->getUserStateFromRequest("catid{$option}",'catid', 0 ));
  if($last_catid!=0){$where[] = "jc.id = $last_catid";}

  // get the total number of records
  $query = "SELECT COUNT(*) FROM #__virtuallib";
  $database->setQuery( $query );
  $total = $database->loadResult();

  require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
  $pageNav = new mosPageNav( $total, $limitstart, $limit );

  // Get publication content
  $query = "
select if(length(a2.last)>0,
          concat(a2.last,',',
                 substring(a2.first,1,1),
                 if(count(a1.last)>1,' et al.','')),
          ifnull(b1.editor,ifnull(b1.key,'Unknown'))) as 'author',
       ifnull(b1.title,ifnull(b1.booktitle,ifnull(b1.series,'Unknown'))) as 'title',
       concat(ifnull(concat(month,' '),''),year) as 'pubdate',
       checkedout,
       b1.published,
       viewed,
       pubid,
       b1.ordering,
       jc.id as 'catid',
       jc.name as 'catname'
  from #__virtuallib_auth a1
  left join #__virtuallib b1 on a1.id = b1.pubid
  left join #__virtuallib_auth a2 on b1.pubid = a2.id
  left join #__virtuallib_categories c1 on c1.id = b1.pubid
  left join #__categories jc on c1.categories = jc.id
 where a2.num = 1" . ( count($where)? " and ".implode(" AND ", $where ) : "" ). "
 group by a1.id
 order by b1.ordering,1,2,3";

  // Get all available categories for filter combo box
  $database->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
  $rows = $database->loadObjectList();

  // Get categories and populate category HTML
  $query = "SELECT id as 'value', title as 'text' from #__categories where section='com_virtuallib' order by ordering";
  $lists['catid']   = comboboxCategory($query, $last_catid);

  HTML_VL::listPublications($rows, $pageNav, $lists, $authsearch, $titlesearch, $option, $last_catid);
}

// input of publication
//   $editfields    Names & descriptions of all fields
function enterPublication($option,$configvalues,$editfields){
  global $database;
  // Get categories for pulldown list
  $query = "SELECT * from #__categories where section='com_virtuallib' order by ordering";
  $database->setQuery( $query);
  $cats = $database->loadObjectList();

  // Get fields from tables
  $allfields = $database->getTableFields(array('#__virtuallib','#__virtuallib_auth'));
  // Get fields from authors table that need to be edited and remove unnecessary ones
  $authfields = array_keys($allfields['#__virtuallib_auth']);
  $authfields = array_diff($authfields,array('id'));
  $authfields = array_diff($authfields,array('num'));
  // Get fields from publications table that need to be edited and remove unnecessary ones
  $pubfields = array_keys($allfields['#__virtuallib']);
  $pubfields = array_diff($pubfields,array('pubid'));
  $pubfields = array_diff($pubfields,array('authorsnames'));
  $pubfields = array_diff($pubfields,array('shortauthnames'));
  $pubfields = array_diff($pubfields,array('checkedout'));
  $pubfields = array_diff($pubfields,array('viewed'));
  $pubfields = array_diff($pubfields,array('bibtex'));
  $pubfields = array_diff($pubfields,array('ordering'));
  $pubfields = array_diff($pubfields,array('locid'));

  // Get state $authornum
  $authornum = mosGetParam($_POST,'authornum','');
  // Get state $itementryfsm
  $itementryfsm = mosGetParam($_POST,'itementryfsm','');

  HTML_VL::enterPublicationFSM($option,$cats,$pubfields,$authfields,$authornum,$itementryfsm,$configvalues,$editfields);
}

// Save publication data
function savePublication($option,$configvalues){
  global $database;

  // Success message
  $message=VL_DATA_SAVED;
  $errorcode=true;

  // Get fields from tables
  $allfields = $database->getTableFields(array('#__virtuallib','#__virtuallib_auth'));
  // Get fields from publications table (don't need to worry about unnecessary fields)
  $pubfields =array_keys($allfields['#__virtuallib']);
  // Get fields from authors table (don't need to worry about unnecessary fields)
  $authfields =array_keys($allfields['#__virtuallib_auth']);

  $bibtex = new Structures_BibTex();
  $catIds = $_POST['category'];
  $inputtype=$_POST['inputtype'];

  switch($inputtype){
    case "file":
      // uploaded a BibTeX file
      $filename = $_FILES['userfile']['tmp_name'];
      $origfilename = $_FILES['userfile']['name'];
      if (strcasecmp(substr($origfilename,-4),'.bib')==0){
        $bibtex->loadFile($filename);
        $errorcode = $bibtex->parse();
        if($errorcode!=true){
          $message=sprintf(VL_ERROR_PARSE_FILE,$filename,$errorcode);
        }
      }else{
        $message=sprintf(VL_ERROR_BIBTEXFILE,$filename);
      }
      break;
    case "string":
      // pasted a BibTeX string
      $bibstring = $_POST['bib'];
      $bibstring = str_replace("\\","",$bibstring);
      $bibtex->addContent($bibstring);
      $errorcode = $bibtex->parse();
      if($errorcode!=true){
        $message=sprintf(VL_ERROR_PARSE_STRING,$filename,$errorcode);
      }
      break;
    default:
      // Manual field entry
      $authornum=$_POST['authornum'];
      // Get publication field values
      foreach($pubfields as $pubfield){
        $stringin=$_POST[$pubfield];
        if($stringin!=''){
          $newdata[$pubfield]=$stringin;
        }
      }
      // Get author field values
      for($i=0;$i<$authornum;$i++){
        foreach($authfields as $authfield){
          $stringin=$_POST[$authfield.$i];
          if(''!=$stringin){
            $newdata['author'][$i][$authfield] = $stringin;
          }
        }
      }
      if(count($newdata)){
        // Add details for this publication to BibTeX array
        $bibtex->addEntry($newdata);
      }else{
        $message=VL_ERROR_NO_DATA;
        $errorcode=false;
      }
      break;
  }

  // Save to database
  if($errorcode==true){
    $errorcode = _saveToMySQL($bibtex->data,$pubfields,$catIds,$configvalues);
    if($errorcode!=true){
      $message=sprintf(VL_ERROR_SAVE,$errorcode);
    }
  }
  mosRedirect("index2.php?option=$option&act=view", $message);
}

// Unpacks the BibTeX structure and saves data to database
function _saveToMySQL($bibarray,$fields,$catIds,$configvalues){
  global $database;
  $errors=true;
  foreach ($bibarray as $paper) {
    $minibibtex = new Structures_BibTex();
    $minibibtex->data[0] = $paper;
    $authexists = 0;
    if(array_key_exists('author',$paper)){
      $authexists = 1;
      $autharray = $paper['author'];
      $paper = array_diff($paper,$autharray);
    }
    $errors = "";
    // check all fields allowed
    $unsavedfields=array();
    foreach ($paper as $fieldsgiven => $valuesgiven) {
      //should we allow key??
      if((!in_array($fieldsgiven,$fields))||strcmp($fieldsgiven,'key')==0) {
        $unsavedfields[]=$paper[$fieldsgiven];
        unset($paper[$fieldsgiven]);
      }else{
        //sort out escape chars and remove {}
        $paper[$fieldsgiven]=ereg_replace('[{}]','',mysql_real_escape_string($valuesgiven));
      }
    }
    //search for urls elsewhere
    if(!array_key_exists('url',$paper)){
      $urlstring1=array();
      foreach($unsavedfields as $field){
        if(preg_match('!(http://|ftp://|https://)[a-z0-9_\.\/\?\&-\=]*!i',$field,$urlstring1) ){
          $paper['url']=$urlstring1[0];
        }elseif(preg_match('!(www\.)[a-z0-9_\.\/\?\&-\=]*!i',$field,$urlstring1) ){
          $paper['url']="http://".$urlstring1[0];
        }
      }
      $urlstring2=array();
      if(array_key_exists('note',$paper)){
        if(preg_match('!(http://|ftp://|https://)[a-z0-9_\.\/\?\&-\=]*!i',$paper['note'],$urlstring2) ){
          $paper['url']=$urlstring2[0];
        }elseif(preg_match('!(www\.)[a-z0-9_\.\/\?\&-\=]*!i',$paper['note'],$urlstring2) ){
          $paper['url']="http://".$urlstring2[0];
        }
      }
      if(array_key_exists('howpublished',$paper)){
        if(preg_match('!(http://|ftp://|https://)[a-z0-9_\.\/\?\&-\=]*!i',$paper['howpublished'],$urlstring2) ){
          $paper['url']=$urlstring2[0];
        }elseif(preg_match('!(www\.)[a-z0-9_\.\/\?\&-\=]*!i',$paper['howpublished'],$urlstring2) ){
          $paper['url']="http://".$urlstring2[0];
        }
      }
    }

    // sort out eprint
    // TODO: Make it work as a local ebook library
    if((!array_key_exists('eprint',$paper))&&array_key_exists('url',$paper)){
      $urlstring=$paper['url'];
      // TODO: Add other ebook formats here
      if(lowercase(substr($urlstring, -3, 3))=="pdf"){
        $paper['eprint']=$urlstring;
        unset($paper['url']);
      }
    }

    // prepare statement for inserting fields
    $values = implode("','", array_values($paper));
    $keys = implode(",", array_keys($paper));
    $database->setQuery("insert into #__virtuallib (".$keys.") values ('".$values."')");
    if (!$result = $database->query()) {
      $errors = $errors.$database->stderr();
    }
    // get the new pubid
    // TODO: &*(^&%! there must be a better way to do this!
    $database->setQuery("select pubid from #__virtuallib order by pubid desc limit 1");
    $pubid = $database->loadResult();
    // prepare statements for inserting categoryids
    foreach ( $catIds as $catId ){
      $database->setQuery("insert into #__virtuallib_categories (id,categories) ".
                          "values ('".$pubid."','".$catId."')");
      if (!$result = $database->query()) {
        $errors = $errors.$database->stderr();
      }
    }

    // Author info
    if($authexists){
      $authnames = '';
      $shortauthnames = '';
      $authorcount=0;
      foreach ( $autharray as $author) {
        $authorcount++;
        foreach ($author as $afield => $avalues) {
          $author[$afield]=ereg_replace('[{}]','',mysql_real_escape_string($avalues));
        }
        $authnames =$authnames." ";
        if($authorcount==1){
          $shortauthnames =$shortauthnames." ";
        }
        if($configvalues['fullnames']=="on"){
          $authnames =$authnames.$author['first']." ";
          if($authorcount==1){
            $shortauthnames =$shortauthnames.$author['first']." ";
          }
        }
        $authnames =$authnames.$author['last'];
        if($authorcount==1){
          $shortauthnames =$shortauthnames.$author['last'];
        }
        $values2 = implode("','", array_values($author));
        $keys2 = implode(",", array_keys($author));
        $database->setQuery("insert into #__virtuallib_auth (id,num,".$keys2.") ".
                            "values (".$pubid.",".$authorcount.",'".$values2."')");
        if (!$result = $database->query()) {
          $errors = $errors.$database->stderr();
        }
      }
      if($authorcount>2){
        $shortauthnames = $shortauthnames." <i>et al.</i>";
      }else{
        $shortauthnames = $authnames;
      }
      $database->setQuery("update #__virtuallib set authorsnames='".$authnames."' where pubid='".$pubid."';");
      if (!$result = $database->query()) {
        $errors = $errors.$database->stderr();
      }
      $database->setQuery("update #__virtuallib set shortauthnames='".$shortauthnames."' where pubid='".$pubid."';");
      if (!$result = $database->query()) {
        $errors = $errors.$database->stderr();
      }
    }

    // Update BibTeX data
    $database->setQuery("update #__virtuallib set bibtex='".mysql_real_escape_string ($minibibtex->bibTex())."' ".
                        "where pubid = ".$pubid);
    if (!$result = $database->query()) {
      $errors = $errors.$database->stderr();
    }
  }
  return $errors;
}

// WTF?
function array_combine_emulated( $keys, $vals ) {
  $keys = array_values( (array) $keys );
  $vals = array_values( (array) $vals );
  $n = max( count( $keys ), count( $vals ) );
  $r = array();
  for( $i=0; $i<$n; $i++ ) {
    $r[ $keys[ $i ] ] = $vals[ $i ];
  }
  return $r;
}

// Publishes or unpublishes a book
function publishPublication( $cid=null, $publish=1,  $option ) {
  global $database;

  if (!is_array( $cid ) || count( $cid ) < 1) {
    $action = $publish ? 'publish' : 'unpublish';
    echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
    exit;
  }

  $cids = implode(',', $cid );
  $database->setQuery( "UPDATE #__virtuallib SET published='$publish' WHERE pubid IN ($cids)" );
  if (!$database->query()) {
    echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
    exit();
  }
  mosRedirect("index2.php?option=$option&act=view");
}

// Show about screen to user
function showAbout() {
  HTML_VL::showAbout();
}

// Makes HTML for category combobox
function comboboxCategory( $query, $active=NULL ) {
  global $database;
  $categories[] = mosHTML::makeOption( '0', _SEL_CATEGORY );
  $database->setQuery( $query );
  $categories = array_merge( $categories, $database->loadObjectList() );
  $category = mosHTML::selectList( $categories, 'catid', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active );
  return $category;
}

// We want to use our own CSS with nice pictures
function insertCustomStyle(){
  global $mainframe;
  $customstyle = $GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_virtuallib/css/virtuallib.css';
  $mainframe->addCustomHeadTag('<link href="'.$customstyle.'" rel="stylesheet" type="text/css" />' );
}

?>
