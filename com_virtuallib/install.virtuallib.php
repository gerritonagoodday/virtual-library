<?php
// $Id$

// Set the icon for an Admin menu item
// changeIcon("com_virtuallib&act=view","../administrator/components/com_virtuallib/icons/virtuallib.png");
function changeIcon($admin_menu_link,$icon) {
  global $database;
  $query = "UPDATE #__components
    SET admin_menu_img='".$icon."'
    WHERE `admin_menu_link`='option=".$admin_menu_link."'
    and `option` = 'com_virtuallib'";
  $database->setQuery($query);
  if (!$database->query()) {
    echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
    exit();
  }
}

function com_install() {
  ?>
<div align='center'><img src='components/com_virtuallib/images/logo.gif'></div><br />
<p align='center'><font class='small'>&copy; Copyright 2007 Gerrit Hoekstra -
<a href='http://www.hoekstra.co.uk'>www.hoekstra.co.uk</a></font><br />
See the README file for ancestry, contributors and documentation.<br />
Updates and Support at <a href='http://www.hoekstra.co.uk'>www.hoekstra.co.uk</a><br/>
<p align='center'>This program is free software; you can redistribute it and/or modify <br />
it under the terms of the GNU General Public License as published by <br />
the Free Software Foundation; either version 2 of the License, or <br />
(at your option) any later version. <br />
This program is distributed in the hope that it will be useful, <br />
but WITHOUT ANY WARRANTY; without even the implied warranty of <br />
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the <br />
GNU General Public License for more details. <br /><br /></p>
<p align='center'><b>Virtual Library Installed Successfully</b></p>
<p align='center'><b>For updates and support on Virtual Library,
visit <a href='http://www.hoekstra,co.uk'>www.hoekstra.co.uk</a></b></p>

<?php
/*
  chdir("../components/com_virtuallib");
  // Create directory of book covers
  mkdir("covers", 0755);
  echo "<font color='green'>SUCCESS:</font>Publication Covers directory created.<br /></p>";
  echo "Created publication cover directory<br /><br /><br />";

  echo "<tr>";
  echo "<td background='F0F0F0' colspan='2'>";
  echo "  <code>Installation Process:<br />";


  # Set up new icons for admin menu
  $database->setQuery("UPDATE #__components SET admin_menu_img='../components/com_virtuallib/images/virtuallib.png'".
                      " WHERE admin_menu_link='option=com_virtuallib'");
  $iconresult[0] = $database->query();
  foreach ($iconresult as $i=>$icresult) {
    if ($icresult) {
      echo "<font color='green'>FINISHED:</font> Image of menu entry $i has been corrected.<br />";
    } else {
      echo "<font color='red'>ERROR:</font> Image of menu entry $i could not be corrected.<br />";
    }
  }

Does the following:

UPDATE #__components
SET `admin_menu_img`='../administrator/components/com_virtuallib/icons/virtuallib.png'
WHERE `admin_menu_link` ='option=com_virtuallib' and `option` = 'com_virtuallib';
UPDATE #__components
SET `admin_menu_img` ='../administrator/components/com_virtuallib/icons/virtuallib.png'
WHERE `admin_menu_link` ='option=com_virtuallib&act=view' and `option` = 'com_virtuallib';
UPDATE #__components
SET `admin_menu_img` ='../administrator/components/com_virtuallib/icons/virtuallibconf.png'
WHERE `admin_menu_link` ='option=com_virtuallib&act=config' and `option` = 'com_virtuallib';
UPDATE #__components
SET `admin_menu_img` ='js/ThemeOffice/help.png'
WHERE `admin_menu_link` ='option=com_virtuallib&act=about' and `option` = 'com_virtuallib';
UPDATE #__components
SET `admin_menu_img` ='js/ThemeOffice/categories.png'
WHERE `admin_menu_link` ='option=com_virtuallib&act=categories' and `option` = 'com_virtuallib';


*/
  //echo "Setting menu icons... ";
  changeIcon("com_virtuallib","../administrator/components/com_virtuallib/icons/virtuallib.png");
  changeIcon("com_virtuallib&act=view","../administrator/components/com_virtuallib/icons/virtuallib.png");
  changeIcon("com_virtuallib&act=config","../administrator/components/com_virtuallib/icons/virtuallibconf.png");
  changeIcon("com_virtuallib&act=categories","js/ThemeOffice/categories.png");
  changeIcon("com_virtuallib&act=about","js/ThemeOffice/help.png");
  //echo "<b>OK</b><br />";

/*
  //Updates Main menu option
  $query = "UPDATE #__components
    SET admin_menu_img='../administrator/components/com_virtuallib/icons/virtuallib.png'
    WHERE admin_menu_link='option=com_virtuallib'";
  $database->setQuery($query);
  if(!$database->query()){
    echo $database->getErrorMsg() . '<br />';
  }

  // Update View Publications option
  $query = "UPDATE #__components
    SET admin_menu_img='../administrator/components/com_virtuallib/icons/virtuallib.png'
    WHERE admin_menu_link='option=com_virtuallib&act=view'";
  $database->setQuery($query);
  if(!$database->query()){
    echo $database->getErrorMsg() . '<br />';
  }

  //Updates Configure menu option
  $query = "UPDATE #__components
    SET admin_menu_img='../administrator/components/com_virtuallib/icons/virtuallibconf.png'
    WHERE admin_menu_link='option=com_virtuallib&act=configuration'";
  $database->setQuery($query);
  if(!$database->query()){
    echo $database->getErrorMsg() . '<br />';
  }

  //Updates Categories menu option
  $query = "UPDATE #__components
    SET admin_menu_img='js/ThemeOffice/categories.png'
    WHERE admin_menu_link='option=com_virtuallib&act=categories'";
  $database->setQuery($query);
  if(!$database->query()){
    echo $database->getErrorMsg() . '<br />';
  }

  //Updates About menu option
  $query = "UPDATE #__components
    SET admin_menu_img='js/ThemeOffice/help.png'
    WHERE admin_menu_link='option=com_easygallery&act=about'";
  $database->setQuery($query);
  if(!$database->query()){
    echo $database->getErrorMsg() . '<br />';
  }
*/

}
?>
