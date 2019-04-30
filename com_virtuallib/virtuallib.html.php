<?php
// $Id: virtuallib.html.php 93 2009-09-08 17:26:27Z gerrit_hoekstra $

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );
require_once $GLOBALS['mosConfig_absolute_path'] .'/includes/PEAR/PEAR.php';
require_once 'BibTex.php';

/**
* @package Joomla bibtex
*/
class HTML_virtuallib {

  // Export as BibTex Bibliography file
  // The file download.bib is updated whenever a publication is altered.
  // TODO: Make nice button to download this file
  function displayBibDownload(){
    global $mosConfig_live_site;
?>
    <table class="contentpaneopen">
      <tr>
        <td class="contentheading" width="100%">
          .bib File Download
        </td>
      </tr>
    </table>
    <table>
      <tr>
        <td>
          <a href='<?php echo $mosConfig_live_site."/components/com_virtuallib/download.bib";?>'>Download BibTeX File</a>
          (Right-click and "Save Target As..")
        </td>
      </tr>
    </table>
    <?php
  }
  
  function inputForm($cats,$fields,$authfields,$inputtype,$authornum,$configvalues,$catId){
    require_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/HTML_toolbar.php' );
    ?>
    <script language="javascript" type="text/javascript">
    function submitbutton(pressbutton) {
      var form = document.adminForm;
      if (pressbutton == 'cancel') {
        form.task.value="";
      }
        form.submit();
    }
    </script>
    <?php
    if($inputtype==""){
    ?>
      <form action="index.php?option=com_virtuallib" method="post" name="adminForm" id="adminForm">
      <table cellpadding="0" cellspacing="0" border="0" width="100%">
      <tr>
        <td class="contentheading">
        Add Publication
        </td>
      </tr>
      </table>
      <table class="adminform">
      <tr>
        <td width="20%">
        Input Method:
        </td>
        <td width="80%">
        <select name="inputtype">
          <option value="file">Bibtex File</option>
          <option value="string">Paste Bibtex String</option>
      <?php
      if($configvalues['manualinput']=="on"){
      ?>
          <option value="fields">Manually by Fields</option>
      <?php
        }
      ?>
        </select>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="Submit" name="Submit" value="Select"/>
          <input type="hidden" name="task" value="add" />
        </td>
      </tr>
      </table>
      </form>
    <?php
    }else{
    ?>
      <form action="index.php?option=com_virtuallib" enctype="multipart/form-data" method="POST" name="adminForm">
      <table cellpadding="0" cellspacing="0" border="0" width="100%">
      <tr>
        <td class="contentheading">
        Add Publication
        </td>
        <td width="10%">
        <?php
        mosToolBar::startTable();
        mosToolBar::spacer();
        mosToolBar::save();
        mosToolBar::spacer();
        mosToolBar::cancel();
        mosToolBar::endtable();
        ?>
        </td>
      </tr>
      </table>
      <table class="adminform">
      <?php
        if($inputtype=="file"){
        ?>
        <tr>
          <td width="20%">
          Bibtex File:
          </td>
          <td width="80%">
          <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
          <input class="inputbox" name="userfile" type="file" />
          </td>
        </tr>
        <?php
        }elseif($inputtype=="string"){
        ?>
        <tr>
          <td>
          Bibtex String
          </td>
          <td align="left">
          <TEXTAREA name="bib" rows="5" cols="60"></TEXTAREA>
          </td>
        </tr>
      <?php
        }elseif($inputtype=="fields"){
        ?>
        <tr>
          <?php
          if($authornum==""){
          ?>
          <td>
          Number of authors
          </td>
          <td align="left">
            <select name="authornumber">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            </select>
            <input type="Submit" name="Submit" value="Select"/>
            <input type="hidden" name="task" value="add" />
            <input type="hidden" name="inputtype" value="<?php echo $inputtype; ?>" />
          </td>
          </form>
          <?php
          }else{
          ?>
        <td>
        Input Fields
        </td>
        <td align="left">
        <table>
        <?php
          $k=0;
          foreach($fields as $field){
            if($field!="abstract"){
              if($k==0){echo "<tr>";}
        ?>
          <td>
          <?php echo $field?>
          </td>
          <td>
          <input type="text" name="<?php echo $field?>"/>
          </td>
        <?php
              if($k==1){echo "</tr>";}
              $k=1-$k;
            }else{
        ?>
            <tr>
              <td>
              <?php echo $field?>
              </td>
              <td colspan="3">
                <TEXTAREA name="<?php echo $field?>" rows="5" cols="42"></TEXTAREA>
              </td>
            </tr>
        <?php
            }
          }
          for($i=0;$i<(int)$authornum;$i++){
            ?>
          <tr>
            <td>Author No. <?php echo $i+1 ?></td>
          </tr>
          <?php
            foreach($authfields as $authfield){
          ?>
          <tr>
            <td>
            <?php echo $authfield?>
            </td>
            <td>
            <input type="text" name="<?php echo $authfield.$i?>"/>
            </td>
          </tr>
          <?php
            }
          }
        }
        ?>
        <tr>
        </tr>
        </table>
        </td>
      </tr>
      <?php
      }
        if($authornum!=""||$inputtype=="file"||$inputtype=="string"){
        ?>
        <tr>
          <td>
            Category
          </td>
          <td>
          <select name="category[]" multiple>
          <?php
            for ($i=0, $n=count( $cats ); $i < $n; $i++) {
              $cat = &$cats[$i];
              if($i==0){
          ?>
                <option value="<?php echo $cat->id ?>" SELECTED><?php echo $cat->name ?></option>
          <?php
              }else{
          ?>
                <option value="<?php echo $cat->id ?>"><?php echo $cat->name ?></option>
          <?php
              }
            }
          ?>
          </select>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="hidden" name="task" value="save" />
            <input type="hidden" name="authornum" value="<?php echo $authornum; ?>" />
            <input type="hidden" name="inputtype" value="<?php echo $inputtype; ?>" />
            <input type="hidden" name="catid" value="<?php echo $catId; ?>" />
          </td>
        </tr>
        </table>
      </form>
      <?php
      }
    }
  }

  function keyExistsOrIsNotEmpty($key,$array){
    if(array_key_exists($key,$array)){
      if($array[$key]!=""){
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }

  // Create a string that looks like a typical academic reference
  // Example:
  // Rath, M. & Rocchesso, D. (2004). Audio-visual continuous interaction with the ballancer, a
  //    tangible interface based on a model of rolling. 8th European Workshop on Ecological
  //    Psychology, pp. 50-51. 26-29 juin, Verone, Italy.
  function formatReference($row,$authrows,$link="none"){
    //authors:
    $authstring = "";
    if (HTML_virtuallib::keyExistsOrIsNotEmpty('authorsnames',$row)){
      for($i=0;$i<count($authrows);$i++){
        if($i!=0){
          if($i==count($authrows)-1){
            $authstring = $authstring." and ";
          }else{
            $authstring = $authstring.", ";
          }
        }
        if(HTML_virtuallib::keyExistsOrIsNotEmpty('von',$authrows[$i])){
          $authstring = $authstring." ".$authrows[$i]['von'];
        }
        if(HTML_virtuallib::keyExistsOrIsNotEmpty('last',$authrows[$i])){
          $authstring = $authstring." ".$authrows[$i]['last'];
        }
        if(HTML_virtuallib::keyExistsOrIsNotEmpty('jr',$authrows[$i])){
          $authstring = $authstring." ".$authrows[$i]['jr'];
        }
        if(HTML_virtuallib::keyExistsOrIsNotEmpty('first',$authrows[$i])){
          $authstring = $authstring.", ".$authrows[$i]['first'];
        }
      }
    } elseif (HTML_virtuallib::keyExistsOrIsNotEmpty('editor',$row)){
      $authstring = $row['editor'];
    }
    echo $authstring;
    // Publication Year
    if (HTML_virtuallib::keyExistsOrIsNotEmpty('year',$row)){
      echo " (".$row['year'].")";
    }
    if (HTML_virtuallib::keyExistsOrIsNotEmpty('title',$row)){
      if($link=="none"){
        echo ", \"".$row['title']."\"";
      }else{
        echo ", \"<a href='$link' title='View Publication Details'>".$row['title']."</a>\"";
      }
    }
    if (HTML_virtuallib::keyExistsOrIsNotEmpty('journal',$row)){
      echo ", <i>".$row['journal']."</i>";
    }elseif (HTML_virtuallib::keyExistsOrIsNotEmpty('booktitle',$row)){
      echo ", <i>".$row['booktitle']."</i>";
    }
    if (HTML_virtuallib::keyExistsOrIsNotEmpty('chapter',$row)){
      echo ", ".$row['chapter'];
    }
    if (HTML_virtuallib::keyExistsOrIsNotEmpty('series',$row)){
      echo ", ".$row['series'];
    }
    if (HTML_virtuallib::keyExistsOrIsNotEmpty('volume',$row)){
      echo ", <b>".$row['volume']."</b>";
    }
    if (HTML_virtuallib::keyExistsOrIsNotEmpty('number',$row)){
      echo ", <b>".$row['number']."</b>";
    }
    if (HTML_virtuallib::keyExistsOrIsNotEmpty('pages',$row)){
      echo ": ".$row['pages'];
    }
    if (HTML_virtuallib::keyExistsOrIsNotEmpty('organization',$row)){
      echo ", ".$row['organization'];
    }
    echo ".";
  }


  function viewBook($row,$authrows,$cats,$id,$fields,$authfields,$authornum,$configvalues,$catId){
    global $my,$mosConfig_live_site;
  ?>
    <form action="index.php?option=com_virtuallib" enctype="multipart/form-data" method="POST" name="adminForm">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
      <tr>
        <td class="contentheading">
          Publication Details:
  <?php
    if ($my->gid > 0 && $configvalues['edit']=="on") {
  ?>
          <a href="index.php?option=com_virtuallib&amp;task=editPublication&amp;catid=$catId&amp;id=<?php echo $id?>" title="Edit Publication"><img src="<?php echo $mosConfig_live_site.'/images/M_images/edit.png'?>" alt="Edit publication" align="middle" border="0" /></a>
  <?php
    }
  ?>
        </td>
      </tr>
    </table>
    <input type="hidden" name="task" value="editPublication" />
    <input type="hidden" name="id" value="$id" />
    </form>
    <table class="adminform">
      <tr>
        <td>
          <?php
          HTML_virtuallib::formatReference($row,$authrows);
          if ($row['abstract']!=""){
               echo "<br />";
               echo "<br />";
               echo "<b>Abstract:</b>";
               echo "<br />";
               echo $row['abstract'];
            }
            if ($row['keywords']!=""){
               echo "<br />";
               echo "<br />";
               echo "<b>Keywords:</b>";
               echo "<br />";
               echo $row['keywords'];
            }
            if ($row['note']!=""){
               echo "<br />";
               echo "<br />";
               echo "<b>Notes:</b>";
               echo "<br />";
               echo $row['note'];
            }
            if ($row['annote']!=""){
               echo "<br />";
               echo "<br />";
               echo "<b>Annotations:</b>";
               echo "<br />";
               echo $row['annote'];
            }
          if ($row['url']!=""){
          ?>
          <br />
          <br />
          <a href="<?php echo $row['url']?>" title="Webpage Link">
                  <img src="<?php echo $mosConfig_live_site.'/images/M_images/weblink.png'?>" alt="Webpage Link" width="12" height="12" align="middle" border="0" />&nbsp Webpage Link
                </a>
          <?php
          }
          if ($row['eprint']!=""){
          ?>
          <br />
          <br />
          <a href="<?php echo $row['eprint']?>" title="Link to eBook">
            <img src="<?php echo $mosConfig_live_site.'/images/M_images/pdf_button.png'?>" alt="Electronic Paper Link" width="12" height="12" align="middle" border="0" />&nbsp Electronic Paper Link
          </a>
          <?php
          }
          ?>
        </td>
      </tr>
    </table>
    <?php
  }

  // user edits an item
  function editPublication($row,$authrows,$cats,$id,$fields,$authfields,$authornum,$catId,$catrows){
    require_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/HTML_toolbar.php' );
  ?>
    <script language="javascript" type="text/javascript">
      function submitbutton(pressbutton) {
        var form = document.adminForm;
        if (pressbutton == 'cancel') {
          form.task.value="cancel";
        }
        // do field validation
        form.submit();
      }
    </script>
    <form action="index.php?option=com_virtuallib" method="post" name="adminForm" id="adminForm">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
      <tr>
        <td class="contentheading">
          Edit Publication
        </td>
        <td width="10%">
        <?php
          mosToolBar::startTable();
          mosToolBar::spacer();
          mosToolBar::save();
          mosToolBar::cancel();
          mosToolBar::endtable();
        ?>
        </td>
      </tr>
    </table>
    <table class="adminform">
      <td valign="top">
      Input Fields
      </td>
      <td align="left">
      <table>
        <?php
          $k=0;
          foreach($fields as $field){
            if($field!="abstract"){
              if($k==0){echo "<tr>";}
        ?>
          <td>
             <?php echo $field?>
          </td>
          <td>
            <input type="text" name="<?php echo $field?>" value="<?php echo $row[$field]?>"/>
          </td>
        <?php
        if($k==1){echo "</tr>";}
          $k=1-$k;
        }else{
        ?>
        <tr>
          <td>
            <?php echo $field?>
          </td>
          <td colspan="3">
            <TEXTAREA name="<?php echo $field?>" rows="5" cols="42"><?php echo $row[$field]?></TEXTAREA>
          </td>
        </tr>
      <?php
          }
        }
        for($i=0;$i<count($authrows);$i++){
      ?>
        <tr>
          <td>Author No. <?php echo $i+1 ?></td>
        </tr>
        <?php
          foreach($authfields as $authfield){
        ?>
        <tr>
          <td>
            <?php echo $authfield?>
          </td>
          <td>
            <input type="text" name="<?php echo $authfield.$i?>" value="<?php echo $authrows[$i][$authfield]?>"/>
          </td>
        </tr>
        <?php
          }
        }
      ?>
      <tr>
      </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td>
        Category
      </td>
      <td>
      <select name="category[]" multiple>
        <?php
        foreach ($cats as $caid=>$caname){
          $match=0;
          foreach ($catrows as $catrow){
            if($caid==$catrow){
              $match=1;
            }
          }
          if($match==1){
        ?>
             <option value="<?php echo $caid ?>" selected><?php echo $caname ?></option>
      <?php
          }else{
      ?>
        <option value="<?php echo $caid ?>"><?php echo $caname ?></option>
      <?php
          }
        }
      ?>
      </select>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="hidden" name="eid" value="<?php echo $id; ?>" />
        <input type="hidden" name="task" value="update" />
        <input type="hidden" name="catid" value="<?php echo $catId; ?>" />
        <input type="hidden" name="authornum" value="<?php echo $authornum; ?>" />
      </td>
    </tr>
    </table>
    </form>
    <form action="index.php?option=com_virtuallib" method="POST" name="adminForm2">
    <table class="adminform">
    <tr>
      <td colspan="2">
        <input type="Submit" name="Add" value="Add Author"/>
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="task" value="editPublication" />
        <input type="hidden" name="catid" value="<?php echo $catId; ?>" />
        <input type="hidden" name="authornum" value="<?php echo $authornum + 1; ?>" />
      </td>
    </tr>
    </table>
    </form>
  <?php
  }

  // Wrapper to listing publications based on selected filter criteria
  // @param $bibtex     Data structure
  // @param $lists      Selection lists
  // ....
  function listPublications($bibtex,$lists,$pageNav,$catName,$configvalues,$catId) {
    $data = $bibtex->data;
    global $Itemid, $mosConfig_live_site, $hide_js;
    // TODO: Get a nice CSS class to display against
  ?>
    <div>
      <form method="post" name="adminForm">
        <table class="adminheading">
          <tbody>
            <tr>
              <th>
                Virtual Library
                <?php
                // Display category name if one has been selected
                if($catName!=""){
                  echo " - ".$catName;
                }
                ?>
              </th>
            </tr>
          </tbody>
        </table>
        <?php
        // show search table
        HTML_virtuallib::showSearch($data,$lists,$pageNav,$configvalues,$catId);

        if($configvalues['formatted']=="off"){
          // show publication list table
          HTML_virtuallib::showResultsTable($data,$lists,$pageNav,$configvalues,$catId);
        }else{
          // show publication list in text form
          HTML_virtuallib::showResultsText($data,$lists,$pageNav,$configvalues,$catId);
        }
        // show the table footer
        HTML_virtuallib::showResultFooter($data,$lists,$pageNav,$configvalues,$catId);
        ?>
        <input type="hidden" name="option" value="com_virtuallib" />
        <input type="hidden" name="catid" value="$catId" />
      </form>
    </div>
  <?php
  }

  // show search table
  function showSearch($data,$lists,$pageNav,$configvalues,$catId){
    global $mosConfig_live_site,$my;
  ?>
    <table class="adminlist">
      <tbody>
        <tr>
          <th>
            Search
          </th>
        </tr>
        <tr>
          <td>
            Author:
          </td>
          <td width="5%" align="right">
          <?php
            echo mosToolTip("Enter a partial name of any of the authors\' names. Click on the Search button to display the results.","Search on author");
            echo "<script type=\"text/javascript\" src=\"$mosConfig_live_site/includes/js/overlib_mini.js\"></script>";
          ?>
          </td>
          <td>
            <input type="text" name="afilter" value="<?php echo $lists['afilter'];?>"
             class="inputbox" onchange="document.adminForm.submit();" />
          </td>
          <td>
            &nbsp;
          </td>
          <td>
            Title:
          </td>
          <td width="5%" align="right">
          <?php
            echo mosToolTip("Enter a partial title. Click on the Search button to display the results.","Search on title");
            echo "<script type=\"text/javascript\" src=\"$mosConfig_live_site/includes/js/overlib_mini.js\"></script>";
          ?>
          </td>
          <td>
            <input type="text" name="filter" value="<?php echo $lists['filter'];?>"
             class="inputbox" onchange="document.adminForm.submit();" />
          </td>
          <td width="48%" align="right">
            <input type="submit" value="Search"/>
          </td>
        </tr>
        <tr>
          <td nowrap="nowrap">
            Pub. Type:
          </td>
          <td width="5%" align="right">
          <?php
            echo mosToolTip("Filter the results based on the type of publication.","Publication Type");
            echo "<script type=\"text/javascript\" src=\"$mosConfig_live_site/includes/js/overlib_mini.js\"></script>";
          ?>
          </td>
          <td>
            <?php echo $lists['pubtype']; ?>
          </td>
<?php
/*


figure out what happens here when we select.

resulting Code:
<select class="inputbox" onchange="document.adminForm.submit();" size="1" name="order">
<option value="Date ASC">xxxxx</option>
<option value="Date DSC">xxxxx</option>
</select>

          <td>
            <?php echo _ORDER_DROPDOWN.':'; ?>
          </td>
          <td>
            <?php echo $lists['order']; ?>
          </td>
*/
?>
          <td>
            &nbsp;
          </td>
          <td nowrap="nowrap">
            Subject:
          </td>
          <td width="5%" align="right">
          <?php
            echo mosToolTip("Filter the results based on a the subject.","Search on Subject");
            echo "<script type=\"text/javascript\" src=\"$mosConfig_live_site/includes/js/overlib_mini.js\"></script>";
          ?>
          </td>
          <td>
            <?php echo $lists['category']; ?>
          </td>
          <td width="48%" align="right">
            <input type="submit" value="Clear"/>
          </td>
        </tr>
      </tbody>
    </table>
  <?php
  }


  // Display Table of items
  //  TODO: Add Category Display and Filtering
  // @param $data       data structure
  // @param $lists      selected options
  function showResultsTable($data,$lists,$pageNav,$configvalues,$catId){
    global $mosConfig_live_site,$my;
    $link = "index.php?option=com_virtuallib";
  ?>
    <table>
      <tr>
       <?php
        // TODO: Put all this in a nice loop
        if($configvalues['col_image']=="on"){
        ?>
          <th class="sectiontableheader" align="left" valign="top" width="10%"  nowrap="nowrap">
          <?php echo "Front<br />Cover"; ?>
          </th>
        <?php
        }
        // TODO: Put all this in a nice loop
        if($configvalues['col_authors']=="on"){
        ?>
          <th class="sectiontableheader" align="left" valign="top" width="10%"  nowrap="nowrap">
          <?php echo "Authors/<br />Editors"; ?>
          </th>
        <?php
        }
        if($configvalues['col_title']=="on"){
        ?>
          <th class="sectiontableheader" valign="top" align="left" width="35%" nowrap="nowrap">
          <?php echo "Publication Title"; ?>
          </th>
        <?php
        }
        if($configvalues['col_publisher']=="on"){
        ?>
          <th class="sectiontableheader" align="left" valign="top" width="15%" nowrap="nowrap">
          <?php echo "Publisher/<br />Journal"; ?>
          </th>
        <?php
        }
        if($configvalues['col_pubdate']=="on"){
        ?>
          <th class="sectiontableheader" width="5%" valign="top" nowrap="nowrap">
          <?php echo "Year/<br />Month"; ?>
          </th>
        <?php
        }
        if($configvalues['col_type']=="on"){
        ?>
          <th align="left" valign="top" class="sectiontableheader" width="5%" nowrap="nowrap">
          <?php echo "Publication<br />Type"; ?>
          </th>
        <?php
        }
        if($configvalues['col_url']=="on"){
        ?>
          <th align="left" valign="top" class="sectiontableheader" width="1%" nowrap="nowrap">
          <?php echo "Links"; ?>
          </th>
        <?php
        }
        ?>
      </tr>
      <?php
      // List each publication in a row in the table or in a text summary
      $k = 0;
      foreach($data as $row){
      ?>
        <tr class="sectiontableentry<?php echo ($k+1)?>" >
          <?php
          if($configvalues['col_image']=="on"){
          ?>
          <td width="5%" align="left">
          <?php
            $tt=HTML_virtuallib::_MkPubTooltipText($row);
            // Display a 70x54 image
            echo mosToolTip($tt['tooltip'],
                            $tt['title'],"",
                            "../../../components/com_virtuallib/thumbs/".$row['image'],"",
                            "index.php?option=com_virtuallib&amp;task=showBook&amp;id=".$row['pubid']);
            echo "<script type=\"text/javascript\" src=\"$mosConfig_live_site/includes/js/overlib_mini.js\"></script>";
          ?>
          </td>
          <?php
          }
          if($configvalues['col_authors']=="on"){
          ?>
            <td  align="left" valign="top">
              <?php
              // Author
              if (array_key_exists('authorsnames', $row)){
                $authstring = $row['authorsnames'];
                if($configvalues['etal']=="on"){
                  // TODO: This does not work if shortauthnames is not defined!
                  $authstring = $row['shortauthnames'];
                }
                echo HTML_virtuallib::squeeze($authstring,12,$configvalues);
              }elseif (array_key_exists('editor', $row)){
                echo HTML_virtuallib::truncate($row['editor'],12,$configvalues);
              }else{
                echo "--";
              }
              ?>
            </td>
          <?php
          }
          if($configvalues['col_title']=="on"){
          ?>
          <td  align="left" valign="top">
            <?php
              if (array_key_exists('title', $row)){
            ?>
                <a href="index.php?option=com_virtuallib&amp;task=showBook&amp;id=<?php echo $row['pubid']?>" title="View Details">
                  <?php echo HTML_virtuallib::squeeze($row['title'],45,$configvalues); ?>
                </a>
            <?php
              }else{
            ?>
                <a href="index.php?option=com_virtuallib&amp;task=showBook&amp;id=<?php echo $row['pubid']?>" title="View Details">
                  --
                </a>
            <?php
              }
            ?>
          </td>
          <?php
          }
          if($configvalues['col_publisher']=="on"){
          ?>
            <td align="left" valign="top">
              <?php
                if (array_key_exists('journal', $row)){
              ?>
                <?php echo HTML_virtuallib::squeeze($row['journal'],20,$configvalues); ?>
              <?php
              }elseif (array_key_exists('booktitle', $row)){
              ?>
                <?php echo HTML_virtuallib::squeeze($row['booktitle'],20,$configvalues); ?>
              <?php
              }elseif (array_key_exists('number', $row)){
              ?>
                <?php echo HTML_virtuallib::squeeze($row['number'],20,$configvalues); ?>
              <?php
              }elseif (array_key_exists('institution', $row)){
              ?>
                <?php echo HTML_virtuallib::squeeze($row['institution'],20,$configvalues); ?>
              <?php
              }elseif (array_key_exists('series', $row)){
              ?>
                <?php echo HTML_virtuallib::squeeze($row['series'],20,$configvalues); ?>
              <?php
              }elseif (array_key_exists('publisher', $row)){
              ?>
                <?php echo HTML_virtuallib::squeeze($row['publisher'],20,$configvalues); ?>
              <?php
              }else{
                echo "--";
                }
              ?>
            </td>
          <?php
          }
          if($configvalues['col_pubdate']=="on"){
          ?>
            <td align="left" valign="top">
              <?php
              if (array_key_exists('year', $row)){
              ?>
              <?php echo $row['year']; ?>
              <?php
              }else{
                echo "--";
              }
              ?>
            </td>
          <?php
          }
          if($configvalues['col_type']=="on"){
          ?>
            <td align="left" valign="top">
              <?php
              if (array_key_exists('type', $row)){
                echo $row['type'];
              }else{
                echo "--";
              }
              ?>
            </td>
          <?php
          }
          if($configvalues['col_url']=="on"){
          ?>
          <td align="left" valign="top">
            <?php
            if (array_key_exists('url', $row)){
            ?>
              <a href="<?php echo $row['url']?>">
                <img src="<?php echo $mosConfig_live_site.'/images/M_images/weblink.png'?>" alt="Webpage Link" name="Webpage Link" width="<?php if($configvalues['smallicons']=="on"){echo "8";}else{echo "12";}?>" height="<?php if($configvalues['smallicons']=="on"){echo "8";}else{echo "12";}?>" align="middle" border="0" />
              </a>
              <?php
            }
            ?>
            <?php
            if (array_key_exists('eprint', $row)){
            ?>
              <a href="<?php echo $row['eprint']?>">
                <img src="<?php echo $mosConfig_live_site.'/images/M_images/pdf_button.png'?>" alt="Electronic Paper Link" name="Electronic Paper Link" width="<?php if($configvalues['smallicons']=="on"){echo "8";}else{echo "12";}?>" height="<?php if($configvalues['smallicons']=="on"){echo "8";}else{echo "12";}?>" align="middle" border="0" />
              </a>
            <?php
            }
            ?>
          </td>
          <?php
          }
          ?>
        </tr>
      <?php
        $k = 1 - $k;
      }
      ?>
    </table>
  <?php
  }

   // show publication list in text form
  function showResultsText($data,$lists,$pageNav,$configvalues,$catId){
    global $mosConfig_live_site,$my;
    $link = "index.php?option=com_virtuallib";
  ?>
    <table>
      <tbody>
        <tr>
          <th colspan="6" >
            Publications:
          </th>
        </tr>
        <?php
        // List each publication in a row in the table or in a text summary
        $k = 0;
        foreach($data as $row){
          // Display Text summary of all publications
          if(!array_key_exists('author', $row)){
            $row['author']=array();
          }
        ?>
          <tr class="sectiontableentry<?php echo ($k+1)?>" >
            <td colspan="6">
              <?php echo HTML_virtuallib::formatReference($row,$row['author'],
                               "index.php?option=com_virtuallib&amp;task=showBook&amp;id=".$row['pubid']);?>
            </td>
          </tr>
        <?php
          $k = 1 - $k;
        }
        ?>
      </tbody>
    </table>
  <?php
  }

  // show the table footer
  function showResultFooter($data,$lists,$pageNav,$configvalues,$catId){
    global $mosConfig_live_site,$my;
    $link = "index.php?option=com_virtuallib";
  ?>
      <table class="adminlist">
        <tr class="sectiontableheader">
          <td width="%48">
            &nbsp;
          </td>
          <td nowrap="nowrap">
            <?php
            $order = '';
            if ( $lists['order_value'] ) {
              $order = '&amp;order='. $lists['order_value'];
            }
            $filter = '';
            if ( $lists['filter'] ) {
              $filter = '&amp;filter='. $lists['filter'];
            }
            $afilter = '';
            if ( $lists['afilter'] ) {
              $afilter = '&amp;afilter='. $lists['afilter'];
            }
            $link = "index.php?option=com_virtuallib&amp;catid=$catId".$order.$filter.$afilter;
            echo $pageNav->writePagesLinks( $link );
            ?>
          </td>
          <td width="48%">
            &nbsp;
          </td>
        </tr>
      </table>
      <table>
        <tr>
          <td width="48%" nowrap="nowrap" align="right">
            <?php echo _PN_DISPLAY_NR; // "Display" ?>
          </td>
          <td>
            &nbsp;
            <?php
            $order = '';
            if ( $lists['order_value'] ) {
              $order = '&amp;order='. $lists['order_value'];
            }
            $filter = '';
            if ( $lists['filter'] ) {
              $filter = '&amp;filter='. $lists['filter'];
            }
            $limitlink = "index.php?option=com_virtuallib&amp;catid=$catId". $order . $filter;
            echo $pageNav->getLimitBox( $limitlink );
            ?>
            &nbsp;
          </td>
          <td width="48%" nowrap="nowrap" align="left">
            <?php echo $pageNav->writePagesCounter(); ?>
          </td>
        </tr>
      </table>
      <table>
        <tr>
          <td width="80%" colspan="3"  align="left">
            <?php
            if($configvalues['download']=="on"){
            ?>
              <a href="index.php?option=com_virtuallib&amp;task=showallbooks&amp;filter=<?php echo $lists['filter']?>&amp;afilter=<?php echo $lists['afilter']?>&amp;catid=<?php echo $catId?>&amp;order=<?php echo $lists['order_value']?>">
                Download BibTeX file for
                <?php if($pageNav->total>1){echo "all ".$pageNav->total." results";}else{echo "result";}?>?
              </a>
            <?php
            }
            ?>
          </td>
          <?php
          if ($my->gid > 0 && $configvalues['add']=="on"){
          ?>
            <td width="20%" colspan="3" align="right">
              <a href="index.php?option=com_virtuallib&amp;task=add" title="Add new publication"><img src="<?php echo $mosConfig_live_site.'/images/M_images/new.png'?>" alt="Add" align="middle" border="0" />
                Add..
              </a>
            </td>
          <?php
          }
          ?>
        </tr>
      </table>
<?php
  }

  // Squeezes the data to help it into into one line
  // TODO: Still crude - make more elegant and calc. how much squeezing it required
  // @param
  function squeeze($stringin,$n,$configvalues){
    //change this with options
    if($configvalues['squeeze']=="on"){
      $stringout=substr($stringin,0,$n);
      if(strlen($stringin)>$n){
        $stringout=$stringout."...";
      }
    }else{
      $stringout=$stringin;
    }
    return $stringout;
  }

  // Prepare descriptive text for presenting in tool tip
  // 1. Select best available field
  // 2. Escape apostrophes
  function _MkPubTooltipText($row){
    if($row['abstract']<>""){
      $s=$row['abstract'];
      $t="Abstract";
    }elseif($row['annote']<>""){
      $s=$row['abstract'];
      $t="Annotation";
    }elseif($row['keywords']<>""){
      $s=$row['keywords'];
      $t="Keywords";
    }elseif($row['authorsnames']<>""){
      $s=$row['authorsnames'];
      $t="Author(s)";
    }else{
      $s="No further information available";
      $t="";
    }
    $tt['tooltip']=preg_replace('/\'/','\\\'',$s);
    $tt['title']=$t;
    return $tt;
  }
}
?>
