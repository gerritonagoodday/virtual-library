<?php
// $Id: virtuallib.php 93 2009-09-08 17:26:27Z gerrit_hoekstra $

error_reporting(E_ALL);

require_once $GLOBALS['mosConfig_absolute_path'] .'/includes/PEAR/PEAR.php';
require_once 'BibTex.php';
require_once( $mainframe->getPath( 'front_html' ) );
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$limit    = intval( mosGetParam( $_REQUEST, 'limit', 25 ) );
$limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
$aid = mosGetParam( $_REQUEST, 'id', 0 );

//get category id from menu params
$menu   = $mainframe->get( 'menu' );
$params   = new mosParameters( $menu->params );
$catId = intval( mosGetParam( $_REQUEST, 'catid', 0 ) );
if($catId==0){
  $catId = $params->get( "catid", null);
}

global $database;

//retrieve config settings
$query = "SELECT * from #__virtuallib_config;";
$database->setQuery( $query);
$config_rowset=$database->loadRowList();
foreach($config_rowset as $row){
  $configvalues[$row[0]]=$row[1];
}

switch ($task) {
  case 'showBook':
    showBook($aid,$configvalues,$catId);
    break;

  case 'editPublication':
    editPublication($aid,$configvalues,$catId);
    break;

  case 'add':
    addBook($configvalues,$catId);
    break;

  case 'update':
    updateBook($configvalues,$catId);
    break;

  case 'save':
    saveBook($configvalues,$catId);
    break;

  case 'cancel':
    checkin($catId);
    break;

  case 'showallbooks':
    $selected   = strval( mosGetParam( $_REQUEST, 'order', '' ) );
    $filter   = stripslashes( strval( mosGetParam( $_REQUEST, 'filter', '' ) ) );
    $afilter  = stripslashes( strval( mosGetParam( $_REQUEST, 'afilter', '' ) ) );
    showallbooks($database,$mainframe,$selected, $filter,$afilter,$limit,$limitstart,$catId);
    break;

  default:
    $selected   = strval( mosGetParam( $_REQUEST, 'order', '' ) );
    $filter   = stripslashes( strval( mosGetParam( $_REQUEST, 'filter', '' ) ) );
    $afilter  = stripslashes( strval( mosGetParam( $_REQUEST, 'afilter', '' ) ) );
    loadData($database,$mainframe,$selected, $filter,$afilter,$limit,$limitstart,$catId,$configvalues);
    break;
}

function checkin($catId){
  global $database;
  $id = $_POST['eid'];
  //check in
  $database->setQuery("update #__virtuallib set checkedout='0' where pubid=(".$id.");");
  if (!$result = $database->query()) {
    echo $database->stderr();
    return false;
  }
  mosRedirect("index.php?option=com_virtuallib&amp;task=showBook&amp;id=$id&amp;catid=$catId");
}

//wip
function addBook($configvalues,$catId){
  global $database;
  $query = "SELECT * from #__categories where section='com_virtuallib' order by id";
  $database->setQuery( $query);
  $cats = $database->loadObjectList();

  $allfields = $database->getTableFields(array('#__virtuallib','#__virtuallib_auth'));
  $fields =array_keys($allfields['#__virtuallib']);
  $authfields =array_keys($allfields['#__virtuallib_auth']);
  $authfields = array_diff($authfields,array('id'));
  $authfields = array_diff($authfields,array('num'));
  $fields = array_diff($fields,array('pubid'));
  $fields = array_diff($fields,array('authorsnames'));
  $fields = array_diff($fields,array('shortauthnames'));
  $fields = array_diff($fields,array('checkedout'));
  $fields = array_diff($fields,array('viewed'));
  $inputtype = mosGetParam( $_REQUEST, 'inputtype', '' );
  $authornum = mosGetParam( $_REQUEST, 'authornumber', '' );

  HTML_virtuallib::inputForm($cats,$fields,$authfields,$inputtype,$authornum,$configvalues,$catId);
}

//wip
function saveBook($configvalues,$catId){

  //save function
  global $database;
  $message="Data Saved";
  $allfields = $database->getTableFields(array('#__virtuallib','#__virtuallib_auth'));
  $fields =array_keys($allfields['#__virtuallib']);
  $authfields =array_keys($allfields['#__virtuallib_auth']);

  $bibtex = new Structures_BibTex();


  $catIds = $_POST['category'];

  $inputtype=$_POST['inputtype'];


  //adding a bibtex string
  if($inputtype=="file"){
    $filename = $_FILES['userfile']['tmp_name'];
    $origfilename = $_FILES['userfile']['name'];
    if (strcasecmp(substr($origfilename,-4),'.bib')==0){
      $bibtex->loadFile($filename);
      $bibtex->parse();
    }else{
      $message="Not a .bib file";
    }
  }elseif($inputtype=="string"){
    $bibstring = $_POST['bib'];
    $bibstring = str_replace("\\","",$bibstring);
    $bibtex->addContent($bibstring);
    $bibtex->parse();
  }else{
    $authornum=$_POST['authornum'];
    //get fields
    foreach($fields as $field){
      $stringin=$_POST[$field];
      if(''!=$stringin){
        $newdata[$field]=$stringin;
      }
    }
    for($i=0;$i<$authornum;$i++){
      foreach($authfields as $authfield){
        $stringin=$_POST[$authfield.$i];
        if(''!=$stringin){
          $newdata['author'][$i][$authfield] = $stringin;
        }
      }
    }
    if(count($newdata)){
      $bibtex->addEntry($newdata);
    }else{
      $message="No file or text data";
    }
  }
  $errcod = _saveToMySQL($bibtex->data,$fields,$catIds,$configvalues);
  mosRedirect("index.php?option=com_virtuallib&amp;catid=%catId", $message.$errcod);
}

//wip
function updateBook($configvalues,$catId){
  global $database;
  $id = $_POST['eid'];
  $newCatIds = $_POST['category'];
  $authornum = $_POST['authornum'];
  $errors="";
  $bibtex = new Structures_BibTex();
  $minibibtex = new Structures_BibTex();
  //get old content from db.
  $query = "SELECT content from #__virtuallib_bibtex where id=(".$id.");";
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
  $fields = array_diff($fields,array('viewed'));

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
    }else{
      //sort out escape chars
      $newdata[$fieldsgiven]=$valuesgiven;
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
  //sort out categories
  //delete old values
  $database->setQuery("delete from #__virtuallib_categories where id=".$id);
  if (!$result = $database->query()) {
    $errors = $errors.$database->stderr();
  }
  foreach ( $newCatIds as $catId ){
    $database->setQuery("insert into #__virtuallib_categories (id,categories) values ('".$id."','".$catId."')");
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
      //add new ones
      $database->setQuery("insert into #__virtuallib_auth (id,num,".$keys2.") values (".$id.",".$authorcount.",'".$values2."')");
      if (!$result = $database->query()) {
        $errors = $errors.$database->stderr();
      }
    }
    if($authorcount>2){
      $shortauthnames = $shortauthnames." et.al";
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

  //prepare statement for inserting bibtex
  $database->setQuery("update #__virtuallib_bibtex set content='".mysql_real_escape_string($bibtex->bibTex())."' where id=".$id);
  if (!$result = $database->query()) {
    $errors = $errors.$database->stderr();
  }
  //check in
  $database->setQuery("update #__virtuallib set checkedout='0' where pubid=(".$id.");");
  if (!$result = $database->query()) {
    echo $database->stderr();
    return false;
  }
  mosRedirect("index.php?option=com_virtuallib&task=showBook&id=$id&catid=$catId", $errors."Reference Edited");
}

function showallbooks($database,$mainframe,$selected, $filter,$afilter,$limit,$limitstart,$catId){
  global $database;
  if ( $selected ) {
    $orderby        = $selected;
  } else {
    $orderby        = 'rdate';
  }
  $orderby = _OrderBySQL( $orderby );
  if($catId>0){
    $andfilter="where #__virtuallib_categories.categories='".$catId."'";
  }else{
    $andfilter="where 1>0";
  }
  if($afilter!=""){
    $andfilter=$andfilter." AND LOWER(authorsnames) LIKE '%".$afilter."%'";
  }
  if($filter!=""){
    $andfilter=$andfilter." AND LOWER(title) LIKE '%".$filter."%'";
  }
  if((strcmp($orderby,'#__virtuallib_auth.last')==0)||(strcmp($orderby,'#__virtuallib_auth.last DESC')==0)){
    $orderby="authorsnames";
  }
  $database->setQuery("select pubid
                         from #__virtuallib left join #__virtuallib_categories
                           on #__virtuallib.pubid=#__virtuallib_categories.id ".$andfilter."
                        order by ".$orderby);
  $result = $database->loadResultArray();
  $fp = fopen("components/com_virtuallib/download.bib", "w") or die("can't open file");
  foreach($result as $contid){
    $database->setQuery("SELECT content from #__virtuallib_bibtex where id='".$contid."';");
    $bibstringall=$database->loadResult();
    fwrite($fp, $bibstringall);
  }
  fclose($fp);
  HTML_virtuallib::displayBibDownload();
}

// Show book details
function showBook($aid,$configvalues,$catId){
  global $database,$my;

  $allfields = $database->getTableFields(array('#__virtuallib','#__virtuallib_auth'));
  $fields =array_keys($allfields['#__virtuallib']);
  $authfields =array_keys($allfields['#__virtuallib_auth']);

  // first increment the item view count
  $database->setQuery("update #__virtuallib set viewed=viewed+1 where pubid=(".$aid.");");
  if (!$result = $database->query()) {
    echo $database->stderr();
    return false;
  }

  // Get authors
  $query = "SELECT * from #__virtuallib where pubid=(".$aid.");";
  $database->setQuery( $query);
  $row=$database->loadRowList();
  $row=array_combine_emulated($fields,$row[0]);

  $query = "SELECT * from #__virtuallib_auth where id=(".$aid.") order by num;";
  $database->setQuery( $query);
  $authrows=$database->loadRowList();
  for($i=0;$i<count($authrows);$i++){
    $authrows[$i]=array_combine_emulated($authfields,$authrows[$i]);
  }
  $authornum = mosGetParam( $_REQUEST, 'authornum', count($authrows) );
  if($authornum>count($authrows)){
    for($i=count($authrows);$i<$authornum;$i++){
      $authrows[$i]=array_combine_emulated($authfields,array("","","","","",""));
    }
  }
  $query = "SELECT * from #__categories where section='com_virtuallib' order by id";
  $database->setQuery( $query);
  $catsobj = $database->loadObjectList();
  foreach($catsobj as $cat){
    $cats[$cat->id]=$cat->name;
  }
  $authfields = array_diff($authfields,array('id'));
  $authfields = array_diff($authfields,array('num'));
  $fields = array_diff($fields,array('pubid'));
  $fields = array_diff($fields,array('authorsnames'));
  $fields = array_diff($fields,array('shortauthnames'));
  $fields = array_diff($fields,array('checkedout'));
  HTML_virtuallib::viewBook($row,$authrows,$cats,$aid,$fields,$authfields,$authornum,$configvalues,$catId);
  return;
}

function editPublication($aid,$configvalues,$catId){
  global $database,$my;

  $allfields = $database->getTableFields(array('#__virtuallib','#__virtuallib_auth'));
  $fields =array_keys($allfields['#__virtuallib']);
  $authfields =array_keys($allfields['#__virtuallib_auth']);

  $query = "SELECT * from #__virtuallib where pubid=(".$aid.");";
  $database->setQuery( $query);
  $row=$database->loadRowList();
  $row=array_combine_emulated($fields,$row[0]);

        // fail if checked out not by 'me'
  if ($row['checkedout']!=$my->id&&$row['checkedout']!=0) {
    mosRedirect( "index.php?option=com_virtuallib&catid=$catId", 'The module is currently being edited by another administrator.' );
  }
    //check out
  $row['checkedout']= $my->id;
  $database->setQuery("update #__virtuallib set checkedout='".$my->id."' where pubid=(".$aid.");");
  if (!$result = $database->query()) {
    echo $database->stderr();
    return false;
  }

  $query = "SELECT * from #__virtuallib_auth where id=(".$aid.") order by num;";
  $database->setQuery( $query);
  $authrows=$database->loadRowList();
  for($i=0;$i<count($authrows);$i++){
    $authrows[$i]=array_combine_emulated($authfields,$authrows[$i]);
  }
  $authornum = mosGetParam( $_REQUEST, 'authornum', count($authrows) );
  if($authornum>count($authrows)){
    for($i=count($authrows);$i<$authornum;$i++){
      $authrows[$i]=array_combine_emulated($authfields,array("","","","","",""));
    }
  }
  $query = "SELECT * from #__categories where section='com_virtuallib' order by id";
  $database->setQuery( $query);
  $catsobj = $database->loadObjectList();
  foreach($catsobj as $cat){
    $cats[$cat->id]=$cat->name;
  }
    //get category info
  $query = "SELECT categories from #__virtuallib_categories where id=(".$aid.");";
  $database->setQuery( $query);
  $catrows=$database->loadResultArray();
  $authfields = array_diff($authfields,array('id'));
  $authfields = array_diff($authfields,array('num'));
  $fields = array_diff($fields,array('pubid'));
  $fields = array_diff($fields,array('authorsnames'));
  $fields = array_diff($fields,array('shortauthnames'));
  $fields = array_diff($fields,array('checkedout'));
  HTML_virtuallib::editPublication($row,$authrows,$cats,$aid,$fields,$authfields,$authornum,$catId,$catrows);
  return;
}

// @param $database
// @param $mainframe
// @param $selected
// @param $filter
// @param $afilter        Author filter string
// @param $limit
// @param $limitstart
// @param $catId          Category Id
// @param $configvalues
function loadData($database,$mainframe,$selected, $filter,$afilter,$limit,$limitstart,$catId,$configvalues){
  global $Itemid, $mosConfig_list_limit;

  // Get names of fields
  $allfields = $database->getTableFields(array('#__virtuallib','#__virtuallib_auth'));
  $fields =array_keys($allfields['#__virtuallib']);
  $authfields =array_keys($allfields['#__virtuallib_auth']);

  // Get category name if one is specified
  if($catId>0){
    $database->setQuery("select name from #__categories where id='".$catId."';");
    $catName = $database->loadResult();
  }else{
    $catName='';
  }

  // Get Number of Authors based on category and author search criteria
  if($catId>0){
    $andfilter="where #__virtuallib_categories.categories='".$catId."' and #__virtuallib.published = 1";
  }else{
    $andfilter="where #__virtuallib.published = 1";
  }
  // ...filter on author name if specified
  if($afilter!=""){
    $andfilter=$andfilter." and lower(authorsnames) like '%".$afilter."%'";
  }
  if($filter!=""){
    $andfilter=$andfilter." and lower(title) like '%".$filter."%'";
  }
  if($catId>0){
    $database->setquery("select count(pubid)
                           from #__virtuallib
                      left join #__virtuallib_categories
                             on #__virtuallib.pubid=#__virtuallib_categories.id ".$andfilter);
  }else{
    $database->setquery("select count(pubid)
                           from #__virtuallib ".$andfilter);
  }
  $total = $database->loadResult();

  // Get number of the publications
  if ( $selected ) {
    // .. that match the filter criteria
    $orderby        = $selected;
    $lists['order_value']   = $selected;
    //if ordering by author, extend the total number to take into account repeated references
    // TODO: Integrate this logic with the above query
    if((strcmp($orderby,'author')==0)||(strcmp($orderby,'rauthor')==0)){
      $database->setquery("select count(#__virtuallib.pubid)
                             from #__virtuallib
                        left join #__virtuallib_auth
                               on #__virtuallib.pubid=#__virtuallib_auth.id
                        left join #__virtuallib_categories
                               on #__virtuallib.pubid=#__virtuallib_categories.id ".$andfilter);
      $total = $database->loadResult();
    }
  } else {
    // ...with no filtering criteria specified
    $lists['order_value'] = ''; // ? What does this do?
    $orderby          = 'rdate';
    $selected         = $orderby;
  }

  require_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/pageNavigation.php' );
  $limitstart = $limitstart ? $limitstart : 0;
  $pageNav = new mosPageNav( $total, $limitstart, $limit );

  // Build Ordering control
  $orderby = _OrderBySQL( $orderby );

  // Picklist of sorting
  $order = array();
  $order[] = mosHTML::makeOption( 'ryear', _ORDER_DROPDOWN_DD );        // date desc
  $order[] = mosHTML::makeOption( 'year', _ORDER_DROPDOWN_DA );         // date asc.
  $order[] = mosHTML::makeOption( 'title', _ORDER_DROPDOWN_TA );        // title asc.
  $order[] = mosHTML::makeOption( 'rtitle', _ORDER_DROPDOWN_TD );       // title desc
  $order[] = mosHTML::makeOption( 'author', 'Author asc' );
  $order[] = mosHTML::makeOption( 'rauthor', 'Author desc' );
  $order[] = mosHTML::makeOption( 'journal', 'Journal asc' );
  $order[] = mosHTML::makeOption( 'rjournal', 'Journal desc' );
  $order[] = mosHTML::makeOption( 'type', 'Type' );
  $lists['order'] = mosHTML::selectList( $order, 'order', 'class="inputbox" size="1" onchange="document.adminForm.submit();"',
                                        'value', 'text', $selected );

  // Picklst of Types of publications
  $pubtype = array();
  $pubtype[] = mosHTML::makeOption('any', 'Any');
  $pubtype[] = mosHTML::makeOption('article','Article');
  $pubtype[] = mosHTML::makeOption('book', 'Book');
  $pubtype[] = mosHTML::makeOption('booklet','Booklet');
  $pubtype[] = mosHTML::makeOption('conference','Conference Proceeding');
  $pubtype[] = mosHTML::makeOption('collection','Collection of Works');
  $pubtype[] = mosHTML::makeOption('inbook','Part of a book');
  $pubtype[] = mosHTML::makeOption('incollection','Part of a book collection');
  $pubtype[] = mosHTML::makeOption('manual','Technical documentation');
  $pubtype[] = mosHTML::makeOption('mastersthesis','Thesis');
  $pubtype[] = mosHTML::makeOption('misc','Miscellaneous');
  $pubtype[] = mosHTML::makeOption('techreport','Technical Report');
  $pubtype[] = mosHTML::makeOption('unpublished','Unpublished');
  $pubtype[] = mosHTML::makeOption('patent','Patent');
  $lists['pubtype'] = mosHTML::selectList( $pubtype, 'pubtype', 'class="inputbox" size="1"
                                         onchange="document.adminForm.submit();"',
                                        'value', 'text', $selected );

  // Picklist for category
  $category = array();
  $category[] = mosHTML::makeOption('all', 'All subjects');
  $database->setQuery("select title,name from #__categories where section='com_virtuallib' order by name;");
  $cat_rowset = $database->loadRowList();
  if(count($cat_rowset)>0){
    foreach($cat_rowset as $cat_row){
      $category[] = mosHTML::makeOption($cat_row[0],$cat_row[1]);
    }
  }
  $lists['category'] = mosHTML::selectList( $category, 'category', 'class="inputbox" size="1"
                                            onchange="document.adminForm.submit();"',
                                            'value', 'text', $selected );

  //$lists['task']    = 'category';
  $lists['filter']    = $filter;
  $lists['afilter']   = $afilter;

  $bibtex = new Structures_BibTex();
  $bibtex->data = _retrieveFromMySQL($fields,$authfields,$database,$limit,$limitstart,$orderby,$filter,$afilter,$catId);

  HTML_virtuallib::listPublications($bibtex,$lists,$pageNav,$catName,$configvalues,$catId);
}

// Fetch publication data based on the prevailing query criteria
function _retrieveFromMySQL($fields,$authfields,$database,$limit,$limitstart,$orderby,$filter,$afilter,$catId){
  // get bibtex data from db
  //extract all from db
  //get total amount
  if($catId>0){
    $andfilter="where #__virtuallib_categories.categories='".$catId."'  and #__virtuallib.published = 1";
  }else{
    $andfilter="where 1>0  and #__virtuallib.published = 1";
  }
  if($afilter!=""){
    $andfilter=$andfilter." AND LOWER(authorsnames) LIKE '%".$afilter."%'";
  }
  if($filter!=""){
    $andfilter=$andfilter." AND LOWER(title) LIKE '%".$filter."%'";
  }

  if($catId>0){
    if((strcmp($orderby,'#__virtuallib_auth.last')==0)||(strcmp($orderby,'#__virtuallib_auth.last DESC')==0)){
      $database->setQuery("select #__virtuallib.*,
                                  #__virtuallib_auth.last
                             from #__virtuallib
                        left join #__virtuallib_auth
                               on #__virtuallib.pubid=#__virtuallib_auth.id
                        left join #__virtuallib_categories
                               on #__virtuallib.pubid=#__virtuallib_categories.id ".$andfilter."
                         order by ".$orderby, $limitstart, $limit );
      $fields[] = 'last';
    }else{
      $database->setQuery("select #__virtuallib.*
                             from #__virtuallib
                        left join #__virtuallib_categories
                               on #__virtuallib.pubid=#__virtuallib_categories.id ".$andfilter."
                         order by ".$orderby, $limitstart, $limit );
    }
  }else{
    if((strcmp($orderby,'#__virtuallib_auth.last')==0)||(strcmp($orderby,'#__virtuallib_auth.last DESC')==0)){
      $database->setQuery("select #__virtuallib.*,
                                  #__virtuallib_auth.last
                             from #__virtuallib
                        left join #__virtuallib_auth
                               on #__virtuallib.pubid=#__virtuallib_auth.id ".$andfilter."
                         order by ".$orderby, $limitstart, $limit );
      $fields[] = 'last';
    }else{
      $database->setQuery("select *
                             from #__virtuallib ".$andfilter."
                            order by ".$orderby, $limitstart, $limit );
    }
  }
  $result = $database->loadRowList();
  $newdata = array();//new bibtex array data
  $index=0;
  // Check that that there records first or foreach carps
  if(count($result)>0){
    //for each row in db
    foreach($result as $row) {
      //for each field
      foreach ($row as $resfield => $resvalue){
        //if pubid field
        if (strcmp($fields[$resfield],'pubid')==0) {
          //extact author data
          $newdata[$index]['pubid']=$resvalue;
          $database->setQuery("SELECT * from #__virtuallib_auth where id=".$resvalue." order by num;");
          $authresult = $database->loadRowList();
          $authindex=0;
          foreach($authresult as $authrow) {
            foreach ($authrow as $authresfield => $authresvalue){
              //dont include id field
              if (strcmp($authfields[$authresfield],'id')!=0){
                //create array data
                $newdata[$index]['author'][$authindex][$authfields[$authresfield]] = $authresvalue;
              }
            }
            $authindex++;
          }
        }else {
          //create array data
          if(!is_null($resvalue)){
            $newdata[$index][$fields[$resfield]] = $resvalue;
          }
        }
      }
      if((strcmp($orderby,'#__virtuallib_auth.last')==0)||(strcmp($orderby,'#__virtuallib_auth.last DESC')==0)){
        $newdata[$index]['authorsnames'] = $newdata[$index]['last'];
        $newdata[$index]['shortauthnames'] = $newdata[$index]['last'];
      }
      $index++;
    }
  }
  return $newdata;
}

// Make up Select Columns based on the configuration
/* Basic construct

select concat(a2.last,',', substring(a2.first,1,1), if(count(a1.last)>1,' et al.','')),
       b1.title
  from mos_virtuallib_auth a1,
       mos_virtuallib_auth a2,
       mos_virtuallib b1 left join mos_virtuallib_auth on b1.pubid = mos_virtuallib_auth.id
 where a2.num = 1
 group by a1.id;

select if(length(a2.last)>0,
          concat(a2.last,',',
                 substring(a2.first,1,1),
                 if(count(a1.last)>1,' et al.','')),
          ifnull(b1.editor,ifnull(b1.key,'Unknown'))),
       b1.title
  from mos_virtuallib_auth a1,
   mos_virtuallib_auth a2,
   mos_virtuallib b1 left join mos_virtuallib_auth on b1.pubid = mos_virtuallib_auth.id
 where a2.num = 1
 group by a1.id;

it gets better...

select if(length(a2.last)>0,
          concat(a2.last,',',
                 substring(a2.first,1,1),
                 if(count(a1.last)>1,' et al.','')),
          ifnull(b1.editor,ifnull(b1.key,'Unknown'))) as 'author',
       ifnull(b1.title,ifnull(b1.booktitle,ifnull(b1.series,'Unknown'))) as 'title'
  from mos_virtuallib_auth a1,
       mos_virtuallib_auth a2,
       mos_virtuallib b1 left join mos_virtuallib_auth on b1.pubid = mos_virtuallib_auth.id
 where a2.num = 1
 group by a1.id;

*/

function _SelectSQL() {
  //$selectsql = 'select ';
  if($configvalues['col_authors']){
    $selectsql .=
"if(length(a2.last)>0,
    concat(a2.last,'','',
           substring(a2.first,1,1),
           if(count(a1.last)>1,'' et al.'','''')),
    ifnull(b1.editor,ifnull(b1.key,''Unknown''))) as ''author''";
  }
  if($configvalues['col_title']){
    $selectsql.="ifnull(b1.title,ifnull(b1.booktitle,ifnull(b1.series,''Unknown''))) as ''title''";
  }

  return $selectsql;
}

function _FromSQL(){
  //$fromSQL = "from ";
  if($configvalues['col_authors']){
    $fromSQL.='mos_virtuallib_auth a1,
       mos_virtuallib_auth a2';
  }
  if($configvalues['col_title']){
    $selectsql.='mos_virtuallib b1 left join mos_virtuallib_auth on b1.pubid = mos_virtuallib_auth.id';
  }

  return $fromSQL;
}

// Make up the GroupBy clause
function _WhereSQL(){
  if($configvalues['col_authors']){
    $whereSQL.='a2.num = 1';
  }
  //if($configvalues['col_title']){

  return $whereSQL;
}

// Make up the GroupBy clause
function _GroupBySQL(){
  if($configvalues['col_authors']){
    $groupBySQL.='a1.id';
  }
  return $groupBySQL;
}

// Make up the order by string
function _OrderBySQL( $orderby ) {
  switch ( $orderby ) {
    case 'col_authors':
      $orderby = '#__virtuallib.key, #__virtuallib_auth.last, #__virtuallib_auth.last, #__virtuallib_auth.von, editors';
      break;
    case 'r_col_authors':
      $orderby = '#__virtuallib.key, #__virtuallib_auth.last, #__virtuallib_auth.last, #__virtuallib_auth.von, editors desc';
      break;
    case 'col_title':
      $orderby = 'title, booktitle, series, volume';
      break;
    case 'r_col_title':
      $orderby = 'title, booktitle, series, volume desc';
      break;
    case 'col_type':
      // TODO: Should use mapping of type to actual translations text when ordering
      $orderby = 'type';
      break;
    case 'r_col_type':
      $orderby = 'type desc';
      break;
    case 'col_annote':
      $orderby = 'annote';
      break;
    case 'r_col_annote':
      $orderby = 'annote desc';
      break;
    case 'col_chapter':
      $orderby = 'chapter';
      break;
    case 'r_col_chapter':
      $orderby = 'chapter desc';
      break;
    case 'col_edition':
      $orderby = 'edition';
      break;
    case 'r_col_edition':
      $orderby = 'edition desc';
      break;
    case 'col_publisher':
      $orderby = 'publisher, journal, institution, organization';
      break;
    case 'r_col_publisher':
      $orderby = 'publisher, journal, institution, organization desc';
      break;
    case 'col_pubdate':
      $orderby = 'year, month';
      break;
    case 'r_col_pupdate':
      $orderby = 'year, month desc';
      break;
    case 'col_note':
      $orderby = 'note';
      break;
    case 'r_col_note':
      $orderby = 'note desc';
      break;
    case 'col_pages':
      $orderby = 'pages';
      break;
    case 'r_col_pages':
      $orderby = 'pages desc';
      break;
    case 'col_abstract':
      $orderby = 'abstract';
      break;
    case 'r_col_abstract':
      $orderby = 'abstract desc';
      break;
    case 'col_cite':
      $orderby = 'cite';
      break;
    case 'r_col_cite':
      $orderby = 'cite desc';
      break;
    case 'col_presentation':
      $orderby = 'eprint, url';
      break;
    case 'r_col_presentation':
      $orderby = 'eprint, url desc';
      break;

//Legacy
    // Order by year, month, most recent first
    case 'year':
      $orderby = 'year,month';
      break;

    // reverse order by year
    case 'ryear':
      $orderby = 'year DESC';
      break;

    // order by title
    case 'title':
      $orderby = 'title';
      break;

    // reverse order by title
    case 'rtitle':
      $orderby = 'title DESC';
      break;

    // order by publication / journal
    case 'journal':
      $orderby = 'journal,publication,volume,number';
      break;

    case 'rjournal':
      $orderby = 'journal,publication,volume,number desc';
      break;

    // Order by author's last name
    case 'author':
      $orderby = '#__virtuallib_auth.last';
      break;

    case 'rauthor':
      $orderby = '#__virtuallib_auth.last DESC';
      break;

    // Order by publication type
    case 'type':
      $orderby = 'type';
      break;

    // order by oldest
    default:
      $orderby = 'year,month DESC';
      break;
  }

  return $orderby;
}

// save BibTeX data in mysql
function _saveToMySQL($bibarray,$fields,$catIds,$configvalues){
  global $database;
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
    //check all fields allowed
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
    //sort out eprint
    if((!array_key_exists('eprint',$paper))&&array_key_exists('url',$paper)){
      $urlstring=$paper['url'];
      if(substr($urlstring, -3, 3)=="pdf"||substr($urlstring, -3, 3)=="PDF"){
        $paper['eprint']=$urlstring;
        unset($paper['url']);
      }
    }
    //prepare statement for inserting fields
    $values = implode("','", array_values($paper));
    $keys = implode(",", array_keys($paper));
    $database->setQuery("insert into #__virtuallib (".$keys.")
                         values ('".$values."')");
    if (!$result = $database->query()) {
      $errors = $errors.$database->stderr();
    }
    $database->setQuery("select pubid from #__virtuallib order by pubid desc limit 1");
    $authid = $database->loadResult();
    //prepare statements for inserting categoryids
    foreach ( $catIds as $catId ){
      $database->setQuery("insert into #__virtuallib_categories (id,categories)
                           values ('".$authid."','".$catId."')");
      if (!$result = $database->query()) {
        $errors = $errors.$database->stderr();
      }
    }
    //prepare statement for author info
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
        $database->setQuery("insert into #__virtuallib_auth (id,num,".$keys2.")
                             values (".$authid.",".$authorcount.",'".$values2."')");
        if (!$result = $database->query()) {
          $errors = $errors.$database->stderr();
        }
      }
      if($authorcount>2){
        $shortauthnames = $shortauthnames." <i>et al.</i>";
      }else{
        $shortauthnames = $authnames;
      }
      $database->setQuery("update #__virtuallib set authorsnames='".$authnames."'
                            where pubid='".$authid."';");
      if (!$result = $database->query()) {
        $errors = $errors.$database->stderr();
      }
      $database->setQuery("update #__virtuallib set shortauthnames='".$shortauthnames."'
                            where pubid='".$authid."';");
      if (!$result = $database->query()) {
        $errors = $errors.$database->stderr();
      }
    }

    //prepare statement for inserting bibtex
    $database->setQuery("insert into #__virtuallib_bibtex (id,content)
                         values (".$authid.",'".mysql_real_escape_string($minibibtex->bibTex())."')");
    if (!$result = $database->query()) {
      $errors = $errors.$database->stderr();
    }
  }
  return $errors;
}

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
?>
