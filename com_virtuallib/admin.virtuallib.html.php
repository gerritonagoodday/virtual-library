<?php
// $Id: admin.virtuallib.html.php 89 2009-09-08 17:23:19Z gerrit_hoekstra $

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HTML_VL{

  // Display configuration input screen
  // TODO: Use tabbed dialog - see admin.garyscookbook.php line 900
  function configInput($option,$configvalues,$configtypes,$conffields){
    global $mosConfig_live_site;
    ?>
    <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
    <script language="JavaScript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js" type="text/javascript"></script>
    <table class="adminheading">
      <tr>
        <th class="config">
          <?=VL_CONFIGURATION;?>
        </th>
      </tr>
    </table>
    <form action="index2.php" method="POST" name="adminForm">
      <table class="adminform">
        <tr>
          <th colspan="4">
            <?=VL_ACCESS_SETTINGS;?>
            &nbsp;&nbsp;
            <?php echo mosToolTip(str_replace("'","\'",VL_ACCESS_SETTINGS_DESC));?>
          </th>
        </tr>
        <?php
        // Access control suff
        foreach($configvalues as $variable=>$value){
          if($configtypes[$variable]=='access'){
        ?>
            <tr>
              <td>
                <?php echo $conffields[$variable]['name'];?>
              </td>
              <td width="30">
                <input type="checkbox" name="<?php echo $variable?>" <?php if($value=="on"){echo "checked";}?>/>
              </td>
              <td width="30"><?php echo mosToolTip(str_replace("'","\'",$conffields[$variable]['desc']));?></td>
              <td width="75%">
              </td>
            </tr>
        <?php
          }
        }
        ?>
        <tr>
          <th colspan="4">
            <?=VL_GENERAL_DISPLAY;?>
            &nbsp;&nbsp;
            <?php echo mosToolTip(str_replace("'","\'",VL_GENERAL_DISPLAY_DESC));?>
          </th>
        </tr>
        <?php
        // General display stuff:
        foreach($configvalues as $variable=>$value){
          if($configtypes[$variable]=='display'){
        ?>
            <tr>
              <td>
                <?php echo $conffields[$variable]['name'];?>
              </td>
              <td width="30">
                <input type="checkbox" name="<?php echo $variable?>" <?php if($value=="on"){echo "checked";}?>/>
              </td>
              <td width="30"><?php echo mosToolTip(str_replace("'","\'",$conffields[$variable]['desc']));?></td>
              <td width="75%">
              </td>
            </tr>
        <?php
          }
        }
        ?>
        <tr>
          <th colspan="4">
            <?=VL_TABLE_COLUMN_SELECTION;?>
            &nbsp;&nbsp;
            <?php echo mosToolTip(str_replace("'","\'",VL_TABLE_COLUMN_SELECTION_DESC));?>
          </th>
        </tr>
        <?php
        // Table columns display:
        foreach($configvalues as $variable=>$value){
          if($configtypes[$variable]=='tab_column'){
        ?>
            <tr>
              <td>
                <?php echo $conffields[$variable]['name'];?>
              </td>
              <td width="30">
                <input type="checkbox" name="<?php echo $variable?>" <?php if($value=="on"){echo "checked";}?>/>
              </td>
              <td width="30"><?php echo mosToolTip(str_replace("'","\'",$conffields[$variable]['desc']));?></td>
              <td width="75%">
              </td>
            </tr>
        <?php
          }
        }
        // Hidden form save
        ?>
        <tr>
          <td colspan="2">
            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="task" value="confSave" />
            <input type="hidden" name="act" value="config" />
          </td>
        </tr>
      </table>
    </form>
    <?php
    printf(VL_FOOTER,VL_VERSION);
  }

  // Display field entry for editing
  function editPublication($row,$authrows,$option,$cats,$id,$fields,$authfields,$authornum,$catrows){
  ?>
    <table class="adminheading">
      <tr>
        <th>
          Edit Publication
        </th>
      </tr>
    </table>
    <form action="index2.php" method="POST" name="adminForm">
      <table class="adminform">
        <tr>
          <th colspan="2">
            Edit existing Publication
          </th>
        </tr>
        <tr>
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
                <TEXTAREA name="<?php echo $field?>" rows="5" cols="50"><?php echo $row[$field]?></TEXTAREA>
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
              echo $match;
              if($match==1){
          ?>
            <option value="<?php echo $caid ?>" SELECTED><?php echo $caname ?></option>
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
          <input type="hidden" name="option" value="<?php echo $option; ?>" />
          <input type="hidden" name="id" value="<?php echo $id; ?>" />
          <input type="hidden" name="task" value="saveEdit" />
          <input type="hidden" name="act" value="view" />
          <input type="hidden" name="authornum" value="<?php echo $authornum; ?>" />
        </td>
      </tr>
    </table>
    </form>
    <form action="index2.php" method="POST" name="adminForm2">
      <table class="adminform">
        <tr>
          <td colspan="2">
            <input type="Submit" name="Add" value="Add Author"/>
            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="eid" value="<?php echo $id; ?>" />
            <input type="hidden" name="task" value="edit" />
            <input type="hidden" name="act" value="view" />
            <input type="hidden" name="authornum" value="<?php echo $authornum + 1; ?>" />
          </td>
        </tr>
      </table>
    </form>
  <?php
  }

  // List all publication in table form
  function listPublications(&$rows, $pageNav, &$lists, $authsearch, $titlesearch, $option, $last_catid) {
    // global $option;
    mosCommonHTML::loadOverlib();
  ?>
    <form action="index2.php?option=com_virtuallib" method="post" name="adminForm">
      <table class="adminheading">
        <tr>
          <th class="edit" rowspan="2" nowrap="nowrap" valign="center">
            <?=VL_PUBLICATION_MANAGER;?>
            <!--
            TODO:
            This does not work yet:
            <small><small>[ Category: <?php echo ($last_catid==NULL)?"All":$lists['catid']{$last_catid}->name;?> ]</small></small>
            -->
          </th>
          <td align="right" valign="center">
            <?php echo $lists['catid'];?>
          </td>
          <td align="right" valign="center" nowrap="nowrap">
            <?=VL_AUTHOR_FILTER;?>
          </td>
          <td nowrap="nowrap" valign="center">
            <input type="text" name="authsearch"
                   value="<?php echo htmlspecialchars($authsearch);?>"
                   class="text_area" onChange="document.adminForm.submit();" />
          </td>
          <td align="right" valign="center" nowrap="nowrap">
            <?=VL_TITLE_FILTER;?>
          </td>
          <td nowrap="nowrap" valign="center">
            <input type="text" name="titlesearch"
                   value="<?php echo htmlspecialchars($titlesearch);?>"
                   class="text_area" onChange="document.adminForm.submit();" />
          </td>
          <td>
            <input name="searchBtn" type=submit value="Filter">
          </td>
        </tr>
      </table>
      <table class="adminlist">
        <tr>
          <th width="5">&#35;</th>
          <th width="5"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows ); ?>);" /></th>
          <th width="15%" align="left" nowrap="nowrap">Authors/<br />Editors</th>
          <th align="left" nowrap="nowrap">Publication Title</th>
          <th width="5%" align="left" nowrap="nowrap">Year/<br />Month</th>
          <th class="title" width="5%">Published</th>
          <th colspan="2" align="center" width="5%">Reorder</th>
          <th width="2%">Order</th>
          <th width="1%">
            <a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )">
              <img src="images/filesave.png" border="0" width="16" height="16" alt="Save Order" />
            </a>
          </th>
          <th class="title">Category</th>
          <th width="5%" align="left" nowrap="nowrap">Times<br />Viewed</th>
        </tr>
        <?php
        $k = 0;
        for ($i=0, $n=count( $rows ); $i < $n; $i++) {
          $row = &$rows[$i];
          mosMakeHtmlSafe($row);
          $row->checked_out = $row->checkedout;
          $link = 'index2.php?option='. $option . '&act=categories&task=edit&hidemainmenu=1&cid='. $row->catid;
        ?>
          <tr>
            <td><?php echo $pageNav->rowNumber( $i ); ?></td>
            <td><?php echo mosHTML::idBox($i, $row->pubid); ?></td>
            <td align="left"><?php echo $row->author; ?></td>
            <td>
              <a href="index2.php?option=com_virtuallib&act=view&task=edit&eid=<?php echo $row->pubid; ?>" title="Edit Publication">
                <?php echo $row->title; ?>
              </a>
            </td>
            <td align="left"><?php echo $row->pubdate; ?></td>
            <td align="center">
              <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $row->published ? "unpublish" : "publish";?>')">
                <img src="images/<?php echo ($row->published ? 'tick.png' : 'publish_x.png');?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
              </a>
            </td>
            <td align="right">
              <?php echo $pageNav->orderUpIcon( $i, ($row->catid == @$rows[$i-1]->catid) );?>
            </td>
            <td align="left">
              <?php echo $pageNav->orderDownIcon( $i, $n, ($row->catid == @$rows[$i+1]->catid) );?>
            </td>
            <td align="center" colspan="2">
              <input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
            </td>
            <td>
              <a href="<?php echo $link; ?>" alt="Edit Category">
                <?php echo stripslashes( $row->catname ); ?>
              </a>
            </td>
            <td>
              <?php echo $row->viewed; ?>
            </td>
          </tr>
        <?php
        }
        ?>
      </table>
      <?php echo $pageNav->getListFooter(); ?>
      <input type="hidden" name="option" value="<?php echo $option; ?>" />
      <input type="hidden" name="act" value="view" />
      <input type="hidden" name="task" value="" />
      <input type="hidden" name="boxchecked" value="0" />
      <input type="hidden" name="hidemainmenu" value="0" />
    </form>
    <?php
    printf(VL_FOOTER,VL_VERSION);
  }

  // List all categories in table form
  // $rows      Results from last query
  // $pageNav   Page navihation HTML
  // $option    Not used
  // $search    Previously used search criteria
  function listSubjectCategories($rows,$pageNav,$option,$search) {
    global $my;
    mosCommonHTML::loadOverlib();
    ?>
    <form action="index2.php" method="post" name="adminForm">
      <table class="adminheading">
        <tr>
          <th class="edit" rowspan="2" nowrap="nowrap" valign="center">
            <?=VL_SUBJECT_MANAGER;?>
          </th>
          <td align="right" valign="center" nowrap="nowrap">
            Filter on Subject Category:
          </td>
          <td nowrap="nowrap" valign="center">
            <input type="text" name="search"
                   value="<?php echo htmlspecialchars($search);?>"
                   class="text_area" onChange="document.adminForm.submit();" />
          </td>
          <td>
            <input name="searchBtn" type=submit value="Filter">
          </td>
        </tr>
      </table>
      <table class="adminlist">
        <tr >
          <th width="10" align="left"> # </th>
          <th width="20"><input type="checkbox" onclick="checkAll(<?php echo count( $rows );?>);" value="" name="toggle"/></th>
          <th align="left" class="Title"> Subject Category </th>
          <th width="10%">Published</th>
          <th colspan="2" width="5%"> Reorder </th>
          <th width="2%"> Order </th>
          <th width="1%"><a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="Save Order" /></a></th>
          <th width="5%" nowrap> Category ID </th>
        </tr>
        <?php
        // List categories
        $k = 0;
        for ($i=0, $n=count( $rows ); $i < $n; $i++) {
          $row  = &$rows[$i];
          mosMakeHtmlSafe($row);
          $link = 'index2.php?option='. $option . '&act=categories&task=edit&hidemainmenu=1&cid='. $row->id;
          $checked  = mosCommonHTML::CheckedOutProcessing( $row, $i );
          $published  = mosCommonHTML::PublishedProcessing( $row, $i );
          ?>
          <tr class="<?php echo "row$k"; ?>">
            <td><?php echo $pageNav->rowNumber( $i ); ?></td>
            <td><?php echo $checked; ?></td>
            <td>
              <?php
              if ( $row->checked_out && ( $row->checked_out != $my->id ) ) {
                // Checked out and not by myself
                echo stripslashes( $row->name ) .' ( '. stripslashes( $row->title ) .' )';
              } else {
                // Cat is available for modification
                ?>
                <a href="<?php echo $link; ?>">
                <?php echo stripslashes( $row->name ); ?>
                </a>
                <?php
              }
              ?>
            </td>
            <td align="center"><?php echo $published;?></td>
            <td><?php echo $pageNav->orderUpIcon( $i ); ?></td>
            <td><?php echo $pageNav->orderDownIcon( $i, $n ); ?></td>
            <td align="center" colspan="2"><input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" /></td>
            <td align="center"><?php echo $row->id; ?></td>
            <?php
            $k = 1 - $k;
            ?>
          </tr>
          <?php
        }
        ?>
      </table>
      <?php echo $pageNav->getListFooter(); ?>
      <input type="hidden" name="option" value="<?php echo $option; ?>" />
      <input type="hidden" name="task" value="" />
      <input type="hidden" name="act" value="categories" />
      <input type="hidden" name="boxchecked" value="0" />
      <input type="hidden" name="hidemainmenu" value="0" />
    </form>
    <?php
    printf(VL_FOOTER,VL_VERSION);
  }

  // FSM to Enter publications detail in a field form
  //   - control for manual entry wizard based on "where we last time"
  function enterPublicationFSM($option,$cats,$pubfields,$authfields,$authornum,$itementryfsm,$configvalues,$editfields){
  ?>
    <table class="adminheading">
      <tr>
        <th>
          <?php echo VL_PUBLICATION_MANUAL_ENTRY; ?>
        </th>
      </tr>
    </table>

    <?php
    $itementryfsm=(!$itementryfsm?0:$itementryfsm);
    $authorindex=0;

    //echo "1 admin.virtuallib.html.php:<br> \$itementryfsm = $itementryfsm<br>\$authorindex = $authorindex<br>";

    if($itementryfsm<60 && $itementryfsm>=40){
      // Special case: dealing with author entry
      if($authornum==''){
        // We've not been here before -> Author number dialog
        $itementryfsm=40;
      } else {
        // We've done dialog0 at least
        if($authornum==0){
          // No authors
          $itementryfsm=60;
        } else {
          // At least one author
          if($itementryfsm<51 || $itementryfsm>59 || !$itementryfsm){
            // First Author entry
            $itementryfsm=51;
            $authorindex=1;
          }else{
            // Subsequent Author entries
            $authorindex=$itementryfsm-50;
            if($authorindex>=$authornum){
              // Done with authors
              $itementryfsm=60;
            }else{
              // Next author
              $itementryfsm++;
              $authorindex++;
            }
          }
        }
      }
    }else{
      switch($itementryfsm){
        case 0:
          $itementryfsm=10;
          break;
        case 10:
          $itementryfsm=20;
          break;
        case 20:
          $itementryfsm=30;
          break;
        case 30:
          $itementryfsm=40;
          break;
        case 60:
          printf("FSM ERROR %s:%d: This should have been saved by now.",__FILE__,__LINE__);
          break;
      }
    }


//echo "2 admin.virtuallib.html.php:<br> \$itementryfsm = $itementryfsm<br>\$authorindex = $authorindex<br>";

// where do I use
// mosRedirect("index2.php?option=$option&act=inpu&task=last");
// ?

    // FSM control main
    switch($itementryfsm){
      case 10:
        HTML_VL::enterPublicationFields($option,$cats,$pubfields,$authornum,$configvalues,$itementryfsm,$editfields);
        break;
      case 20:
        HTML_VL::uploadPublication($option,$cats,$pubfields,$authornum,$configvalues,$itementryfsm,$editfields);
        break;
      case 30:
        HTML_VL::enterBibliographyFields($option,$cats,$pubfields,$authornum,$configvalues,$itementryfsm,$editfields);
        break;
      case 40:
        HTML_VL::enterNumberOfAuthors($option,$authfields,$authornum,$authorindex,$itementryfsm,$editfields);
        break;
      case 51: case 52: case 53: case 54: case 55: case 56: case 57: case 58: case 59:
        // Enter each author's details
        HTML_VL::enterAuthor($option,$authfields,$authornum,$authorindex,$itementryfsm,$editfields);
        break;
      case 60:
        HTML_VL::uploadPublicationImage($option,$cats,$pubfields,$authornum,$configvalues,$itementryfsm,$editfields);
        break;
      default:
        printf("FSM ERROR %s:%d: You should not be here!",__FILE__,__LINE__);
        break;
    }
  }

  // Allow the user to select the number of authors
  function enterNumberOfAuthors($option,$authfields,$authornum,$authorindex,$itementryfsm,$editfields){
  ?>
    <form action="index2.php" enctype="multipart/form-data" method="POST" name="adminForm">
      <table class="adminform">
        <tr>
          <th colspan="5">
            <?=VL_AUTHOR_INPUT;?>
          </th>
        </tr>
        <tr>
          <th class="edit" colspan="5">
            <?php echo VL_AUTHOR_ENTER_NUMBER;?>
            &nbsp;&nbsp;
            <?php echo mosToolTip(str_replace("'","\'",VL_AUTHOR_ENTER_NUMBER_DESC));?>
          </th>
        </tr>
        <tr>
          <td >
            <?php echo VL_NUMBER_OF_AUTHORS; ?>
          </td>
          <td align="right">
              <img src="/administrator/images/addusers.png"/>
          </td>
          <td  align="left">
            <select name="authornum">
            <option value="0" SELECTED><?php echo VL_AUTHOR_UNKNOWN; ?></option>
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
          </td>
          <td align="left">
            <?php echo mosToolTip(str_replace("'","\'",VL_AUTHOR_ENTER_NUMBER_DESC));?>
          </td>
          <td>
            <input type="hidden" name="option" value="<?=$option;?>" />
            <input type="hidden" name="itementryfsm" value="<?=$itementryfsm;?>" />
            <input type="hidden" name="act" value="input"/>
            <input type="hidden" name="task" value="next"/>
          </td>
        </tr>
      </table>
    </form>
  <?php
  }

  // Enter the details for an author
  function enterAuthor($option,$authfields,$authornum,$authorindex,$itementryfsm,$editfields){
  ?>
    <form action="index2.php" enctype="multipart/form-data" method="POST" name="adminForm">
      <table class="adminform">
        <tr>
          <th colspan="3">
            <?=VL_AUTHOR_INPUT;?>
          </th>
        </tr>
        <tr>
          <th class="edit" colspan="3">
            <?php printf(VL_AUTHOR_DETAILS_ENTER, $authorindex, $authornum); ?>
            &nbsp;&nbsp;
            <?php echo mosToolTip(str_replace("'","\'",VL_AUTHOR_DETAILS_ENTER_DESC));?>
          </td>
          </th>
        </tr>
        <tr>
          <td valign="top">
            <?php echo VL_INPUT_FIELDS;?>
          <td align="left">
            <table>
              <?php
              // Display Author fields
              foreach($authfields as $authfield){
              ?>
                <tr>
                  <td>
                    <?=$editfields[$authfield]['name'];?>
                  </td>
                  <td>
                    <input type="text" name="<?php echo $authfield.$authorindex?>"/>
                  </td>
                  <td width="30">
                    <?php echo mosToolTip(str_replace("'","\'",$editfields[$authfield]['desc']));?>
                  </td>
                  <td width="75%">
                  </td>
                </tr>
              <?php
              }
              ?>
            </table>
          </td>
        </tr>
        <tr>
          <td>
          </td>
          <td>
            <input type="hidden" name="option" value="<?=$option;?>"/>
            <input type="hidden" name="act" value="input"/>
            <input type="hidden" name="task" value="next" />
            <input type="hidden" name="itementryfsm" value="<?=$itementryfsm;?>" />
            <input type="hidden" name="authornum" value="<?=$authornum;?>" />
          </td>
        </tr>
      </table>
    </form>
  <?php
  }

  // Entry fields for the publication
  function enterPublicationFields($option,$cats,$pubfields,$authornum,$configvalues,$itementryfsm,$editfields){
  ?>
    <form action="index2.php" enctype="multipart/form-data" method="POST" name="adminForm">
      <table class="adminform">
        <tr>
          <th class="edit" colspan="3">
            <?=VL_DETAIL_INPUT;?>
          </th>
        </tr>
        <tr>
          <th class="edit" colspan="2">
            <?php echo VL_PUBLICATION_DETAILS;?>
            &nbsp;&nbsp;
            <?php echo mosToolTip(str_replace("'","\'",VL_PUBLICATION_DETAILS_DESC));?>
          </th>
        </tr>
        <tr>
          <td valign="top">
            <?php echo VL_INPUT_FIELDS;?>
          </td>
          <td align="left">
            <table>
              <?php
              $k=0;
              foreach($pubfields as $field){
                switch($field){
                  case "title":
                    $k=0;
                    ?>
                    <tr>
                      <td>
                        <?php echo $editfields[$field]['name'];?>
                      </td>
                      <td colspan="4">
                        <textarea name="<?=$field;?>" rows="1" cols="50"></textarea>
                      </td>
                      <td>
                        <?php echo mosToolTip(str_replace("'","\'",$editfields[$field]['desc']));?>
                      </td>
                    </tr>
                    <?php
                    break;
                  case "media":
                    $k=0;
                    ?>
                    <tr>
                      <td>
                        <?=VL_MEDIA_TYPE;?>
                      </td>
                      <td>
                        <input type=radio name=mediatype value="ebook" checked><?=VL_EBOOK;?>
                      </td>
                      <td>
                        <?php echo mosToolTip(str_replace("'","\'",VL_EBOOK_DESC));?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                      </td>
                      <td>
                        <input type=radio name=mediatype value="website"><?=VL_WEBSITE;?>
                      </td>
                      <td>
                        <?php echo mosToolTip(str_replace("'","\'",VL_WEBSITE_DESC));?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                      </td>
                      <td>
                        <input type=radio name=mediatype value="print"><?=VL_PRINTED_MEDIA;?>
                      </td>
                      <td>
                        <?php echo mosToolTip(str_replace("'","\'",VL_PRINTED_MEDIA_DESC));?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                      </td>
                      <td>
                        <input type=radio name=mediatype value="other"><?=VL_OTHER_MEDIA;?>
                      </td>
                      <td>
                        <?php echo mosToolTip(str_replace("'","\'",VL_OTHER_MEDIA_DESC));?>
                      </td>
                    </tr>
                    <?php
                    break;
                  case "journal":
                  case "volume":
                  case "number":
                  case "series":
                  case "abstract":
                  case "type":
                  case "keywords":
                  case "url":
                  case "address":
                  case "annote":
                  case "bibtex":
                  case "booktitle":
                  case "chapter":
                  case "cite":
                  case "dcc":
                  case "ddc":
                  case "editor":
                  case "eprint":
                  case "howpublished":
                  case "image":
                  case "institution":
                  case "isbn":
                  case "issn":
                  case "key":
                  case "locid":
                  case "note":
                  case "ordering":
                  case "organization":
                  case "pages":
                  case "published":
                  case "publisher":
                  case "school":
                  case "viewed":
                     // Ignore these
                     break;
                  default:
                    // All remaining not-so-interesting columns
                    if($k==0){echo "<tr>";}
                    ?>
                    <td>
                      <?php echo $editfields[$field]['name'];?>
                    </td>
                    <td>
                      <?php
                      if($field == "month"){
                        // display months in combobox
                      ?>
                        <select name="month" size="1">
                          <option value="0" SELECTED><?=VL_PUBLICATION_SELECT_MONTH; ?></option>
                          <option value="1"><?=_JAN; ?></option>
                          <option value="2"><?= _FEB; ?></option>
                          <option value="3"><?= _MAR; ?></option>
                          <option value="4"><?= _APR; ?></option>
                          <option value="5"><?= _MAY; ?></option>
                          <option value="6"><?= _JUN; ?></option>
                          <option value="7"><?= _JUL; ?></option>
                          <option value="8"><?= _AUG; ?></option>
                          <option value="9"><?= _SEP; ?></option>
                          <option value="10"><?= _OCT; ?></option>
                          <option value="11"><?= _NOV; ?></option>
                          <option value="12"><?= _DEC; ?></option>
                        </select>
                      <?php
                      }else{
                        // others
                        echo "<input type=\"text\" name=\"$field\"/>";
                      }
                      ?>
                    </td>
                    <td>
                      <?php echo mosToolTip(str_replace("'","\'",$editfields[$field]['desc']));?>
                    </td>
                    <?php
                    // end of row
                    if($k==1){echo "</tr>";}
                    $k=1-$k;
                    break;
                } // switch
              } // for
              // Display categories
              ?>
              <tr>
                <td valign="top">
                  <?php echo $editfields['cat']['name']; ?>
                </td>
                <td valign="top" colspan="4">
                  <select name="category[]" multiple>
                    <?php
                    // TODO: Highlight most recently selected category or the first one if none
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
                    } // for
                    ?>
                  </select>
                </td>
                <td>
                  <?php echo mosToolTip(str_replace("'","\'",$editfields['cat']['desc']));?>
                </td>
              </tr>
              <tr>
                <td>
                  <input type="hidden" name="task" value="next" />
                  <input type="hidden" name="act" value="input" />
                  <input type="hidden" name="option" value="<?=$option;?>" />
                  <input type="hidden" name="itementryfsm" value="<?=$itementryfsm;?>" />
                  <input type="hidden" name="authornum" value="<?=$authornum;?>" />
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </form>
  <?php
  }

  // Enter boring fields about the publications
  function enterBibliographyFields($option,$cats,$pubfields,$authornum,$configvalues,$itementryfsm,$editfields){
  ?>
    <form action="index2.php" enctype="multipart/form-data" method="POST" name="adminForm">
      <table class="adminform">
        <tr>
          <th class="edit" colspan="3">
            <?=VL_DETAIL_INPUT;?>
          </th>
        </tr>
        <tr>
          <th class="edit" colspan="2">
            <?php echo VL_BIBLIOGRAPHY_DETAILS; ?>
            &nbsp;&nbsp;
            <?php echo mosToolTip(str_replace("'","\'",VL_BIBLIOGRAPHY_DETAILS_DESC));?>
          </th>
        </tr>
        <tr>
          <td valign="top">
            <?php echo VL_INPUT_FIELDS;?>
          </td>
          <td align="left">
            <table>
              <?php
              $k=0;
              foreach($pubfields as $field){
                switch($field){
                  case "keywords":
                    $k=0;
                    ?>
                    <tr>
                      <td>
                        <?php echo $editfields[$field]['name'];?>
                      </td>
                      <td colspan="4">
                        <textarea name="<?=$field;?>" rows="1" cols="50"></textarea>
                      </td>
                      <td>
                        <?php echo mosToolTip(str_replace("'","\'",$editfields[$field]['desc']));?>
                      </td>
                    </tr>
                    <?php
                    break;
                  case "abstract":
                    $k=0;
                    ?>
                    <tr>
                      <td valign="top">
                        <?php echo $editfields[$field]['name'];?>
                      </td>
                      <td colspan="4">
                        <textarea name="<?=$field;?>" rows="5" cols="50"></textarea>
                      </td>
                      <td valign="top">
                        <?php echo mosToolTip(str_replace("'","\'",$editfields[$field]['desc']));?>
                      </td>
                    </tr>
                    <?php
                    break;
                  case "type":
                    $k=0;
                    // TODO: Map names back and forth for entry and retreival
                    ?>
                    <tr>
                      <td>
                         <?=$editfields[$field]['name'];?>
                      </td>
                      <td align="left" colspan="4">
                        <select name="type">
                        <option value="book" selected><?php echo VL_TYPE_BOOK; ?></option>
                        <option value="article"><?php echo VL_TYPE_ARTICLE; ?></option>
                        <option value="booklet"><?php echo VL_TYPE_BOOKLET; ?></option>
                        <option value="conference"><?php echo VL_TYPE_BOOKLET; ?></option>
                        <option value="collection"><?php echo VL_TYPE_COLLECTION; ?></option>
                        <option value="inbook"><?php echo VL_TYPE_INBOOK; ?></option>
                        <option value="incollection"><?php echo VL_TYPE_INCOLLECTION; ?></option>
                        <option value="manual"><?php echo VL_TYPE_MANUAL; ?></option>
                        <option value="mastersthesis"><?php echo VL_TYPE_MASTERSTHESIS; ?></option>
                        <option value="misc"><?php echo VL_TYPE_MISC; ?></option>
                        <option value="techreport"><?php echo VL_TYPE_TECHREPORT; ?></option>
                        <option value="patent"><?php echo VL_TYPE_PATENT; ?></option>
                        <option value="unpublished"><?php echo VL_TYPE_UNPUBLISHED; ?></option>
                      </td>
                      <td>
                        <?php echo mosToolTip(str_replace("'","\'",$editfields[$field]['desc']));?>
                      </td>
                    </tr>
                    <?php
                    break;
                  case "address":
                    $k=0;
                    ?>
                    <tr>
                      <td>
                        <?php echo $editfields[$field]['name'];?>
                      </td>
                      <td colspan="4">
                        <TEXTAREA name="<?=$field;?>" rows="1" cols="50"></TEXTAREA>
                      </td>
                      <td>
                        <?php echo mosToolTip(str_replace("'","\'",$editfields[$field]['desc']));?>
                      </td>
                    </tr>
                    <?php
                    break;
                  case "annote":
                    $k=0;
                    ?>
                    <tr>
                      <td valign="top">
                        <?=$editfields[$field]['name'];?>
                      </td>
                      <td colspan="4">
                        <TEXTAREA name="<?=$field;?>" rows="5" cols="50"></TEXTAREA>
                      </td>
                      <td valign="top">
                        <?php echo mosToolTip(str_replace("'","\'",$editfields[$field]['desc']));?>
                      </td>
                    </tr>
                    <?php
                    break;
                  case "note":
                    $k=0;
                    ?>
                    <tr>
                      <td valign="top">
                        <?=$editfields[$field]['name'];?>
                      </td>
                      <td colspan="4">
                        <TEXTAREA name="<?=$field;?>" rows="5" cols="50"></TEXTAREA>
                      </td>
                      <td valign="top">
                        <?php echo mosToolTip(str_replace("'","\'",$editfields[$field]['desc']));?>
                      </td>
                    </tr>
                    <?php
                    break;
                  case "url":
                    $k=0;
                    ?>
                    <tr>
                      <td valign="top">
                        <?php echo $editfields[$field]['name'];?>
                      </td>
                      <td colspan="4">
                        <textarea name="<?=$field;?>" rows="1" cols="50"></textarea>
                      </td>
                      <td valign="top">
                        <?php echo mosToolTip(str_replace("'","\'",$editfields[$field]['desc']));?>
                      </td>
                    </tr>
                    <?php
                    break;
                  case "abstract":
                  case "bibtex":
                  case "dcc":
                  case "edition":
                  case "image":
                  case "locid":
                  case "month":
                  case "ordering":
                  case "published":
                  case "title":
                  case "type":
                  case "viewed":
                  case "year":
                     break;
                  default:
                    // All remaining not-so-interesting columns
                    if($k==0){echo "<tr>";}
                    ?>
                    <td>
                      <?=$editfields[$field]['name'];?>
                    </td>
                    <td>
                      <input type="text" name="<?php echo $field?>"/>
                    </td>
                    <td>
                      <?php echo mosToolTip(str_replace("'","\'",$editfields[$field]['desc']));?>
                    </td>
                    <?php
                    // end of row
                    if($k==1){echo "</tr>";}
                    $k=1-$k;
                    break;
                } // switch
              } // for
              ?>
              <tr>
                <td>
                  <input type="hidden" name="task" value="next" />
                  <input type="hidden" name="act" value="input" />
                  <input type="hidden" name="option" value="<?=$option;?>" />
                  <input type="hidden" name="itementryfsm" value="<?=$itementryfsm;?>" />
                  <input type="hidden" name="authornum" value="<?=$authornum;?>" />
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </form>
  <?php
  }


  // Upload or select an image for the publication
  function uploadPublicationImage($option,$cats,$pubfields,$authornum,$configvalues,$itementryfsm,$editfields){
  ?>
    <form action="index2.php" enctype="multipart/form-data" method="POST" name="adminForm">
      <table class="adminform">
        <tr>
          <th class="edit" colspan="3">
            <?php echo VL_COVER_IMAGE; ?>
          </th>
        </tr>
        <tr>
          <td width="20%">
            <?=VL_UPLOAD_PUBLICATION_IMAGE;?>
          </td>
          <td align="right">
            <img src="/administrator/images/upload_f2.png"/>
          </td>
          <td align="left" valign="middle">
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
            <input type="hidden" name="act" value="input"/>
            <input type="hidden" name="task" value="save"/>
            <input class="inputbox" name="userfile" type="file" size="70"/>
            &nbsp;&nbsp;
            <?php echo mosToolTip(str_replace("'","\'",VL_BIBTEX_FILE_CHOOSE_DESC));?>
          </td>
        </tr>
      </table>
    </form>
  <?php
  }

  // Upload or select an image for the publication
  function uploadPublication($option,$cats,$pubfields,$authornum,$configvalues,$itementryfsm,$editfields){
  ?>
    <form action="index2.php" enctype="multipart/form-data" method="POST" name="adminForm">
      <table class="adminform">
        <tr>
          <th class="edit" colspan="3">
            <?php echo VL_EBOOK; ?>
          </th>
        </tr>
        <tr>
          <td width="20%">
            <?=VL_UPLOAD_EBOOK;?>
          </td>
          <td align="right">
            <img src="/administrator/images/upload_f2.png"/>
          </td>
          <td align="left" valign="middle">
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
            <input type="hidden" name="act" value="input"/>
            <input type="hidden" name="task" value="save"/>
            <input class="inputbox" name="userfile" type="file" size="70"/>
            &nbsp;&nbsp;
            <?php echo mosToolTip(str_replace("'","\'",VL_UPLOAD_EBOOK_DESC));?>
          </td>
        </tr>
      </table>
    </form>
  <?php
  }

  // File Input
  function uploadBibTeXFile($option){
  ?>
    <form action="index2.php" enctype="multipart/form-data" method="POST" name="adminForm">
      <table class="adminform">
        <tr>
          <th class="edit" colspan="3">
            <?php echo VL_BIBTEX_FILE_UPLOAD; ?>
          </th>
        </tr>
        <tr>
          <td width="20%">
            <?=VL_BIBTEX_FILE_CHOOSE;?>
          </td>
          <td align="right">
            <img src="/administrator/images/upload_f2.png"/>
          </td>
          <td align="left" valign="middle">
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
            <input type="hidden" name="act" value="input"/>
            <input type="hidden" name="task" value="save"/>
            <input class="inputbox" name="userfile" type="file" size="70"/>
            &nbsp;&nbsp;
            <?php echo mosToolTip(str_replace("'","\'",VL_BIBTEX_FILE_CHOOSE_DESC));?>
          </td>
        </tr>
      </table>
    </form>
  <?php
  }

  // Paste a BibTeX string containing one or more publications
  function pasteBibTeXString($options){
  ?>
    <form action="index2.php" enctype="multipart/form-data" method="POST" name="adminForm">
      <table class="adminform">
        <tr>
          <th class="edit" colspan="3">
            <?php echo VL_COPYPASTE_BIBTEX; ?>
          </th>
        </tr>
        <tr>
          <td valign="top">
            <?php echo VL_PASTE_BIBTEX_STRING; ?>
          </td>
          <td align="right">
            <img src="paste_f2.png"/>
          </td>
          <td align="left">
            <TEXTAREA name="bib" rows="5" cols="80"></TEXTAREA>
          </td>
        </tr>
      </table>
    </form>
  <?php
  }

  // New Category create form
  function enterCategory($option){
  ?>
    <table class="adminheading">
      <tr>
        <th>
          <?=VL_NEW_SUBJECT_CATEGORY;?>
        </th>
      </tr>
    </table>
    <form action="index2.php" method="POST" name="adminForm">
      <table class="adminform">
        <tr>
          <th colspan="2">
            Category
          </th>
        </tr>
        <tr>
          <td width="20%">
            Name:
          </td>
          <td width="80%">
            <input type="text" name="catName" size="80" maxlength="100">
          </td>
        </tr>
        <tr>
          <td width="20%">
            Description:
          </td>
          <td>
            <TEXTAREA name="catDesc" rows="5" cols="80"></TEXTAREA>
          </td>
        </tr>
        <tr>
          <td width="80%">
          <input type="hidden" name="option" value="<?php echo $option; ?>" />
          <input type="hidden" name="task" value="saveCat" />
          <input type="hidden" name="act" value="categories" />
          </td>
        </tr>
      </table>
    </form>
  <?php
  }


  // About Form - does not need to be multilingual
  function showAbout() {
  ?>
    <table class="adminheading">
      <tr>
        <th class="info">
          <?php printf("About %s (Version %s)",VL_NAME,VL_VERSION);?>
        </th>
      </tr>
    </table>
    <table class="adminlist">
      <tr>
        <td>
          <h1>Creator and Maintainer</h1>
            <p>
              <a href="mailto:gerrit@hoekstra.co.uk" title="Check forums before mailing me, please!">
              Gerrit Hoekstra
              </a>
              who lives in a dark forest at
              <a href="http://www.hoekstra.co.uk" target="_blank">
              www.hoekstra.co.uk
              </a>
            </p>
        </td>
      </tr>
      <tr>
        <td>
          <h1>The Virtual Library Joomla Component</h1>
<p>
This Joomla component creates a Virtual Library that attempts to simulate
a real library, but without the musty smell and the officious librarian in horn-rimmed
glasses and beehive hairstyle who goes <i>Shhhhhhhhhhhhh!</i>&nbsp;to hapless patrons at the
slightest acoustic infringement. Just like in a real library, you can search and browse your
marvelous collection of ebooks, open a book, page through it,
close it (<i>and</i>&nbsp;you don&apos;t need to put
it back in the right place again), open another one and peruse it - all in the comfort
of wherever you are and without incurring the wrath of the dreaded librarian.
You can catalogue and sort your publications and store accompanying notes
</p>
        </td>
      </tr>
      <tr>
        <td>
          <h1>Ancestry</h1>
          <ul>
            <li>
              Mark Austin&apos;s BibTex component V1.3: <a title="Mark Austin&apos;s BibTex component:" href="http://www.everythingthatiknowabout.com/Joomla/">http://www.everythingthatiknowabout.com</a>
            </li>
          </ul>
          <ul>
            <li>
              Sascha Claren, Martin Brampton and Bernhard Zechmann&apos;s Glossary Component: <a title="Remository" href="http://www.remository.com/">http://www.remository.com/</a>
            </li>
          </ul>
        </td>
      </tr>
      <tr>
      	<td>
          <h1>Compatibility</h1>
          <p>
          Joomla 1.0.13 is the only version of Joomla that is supported. It may work on 1.0.12, perhaps even on 1.0.11...
          </p>
        </td>
      </tr>
      <tr>
        <td>
          <h1>License</h1>
<p>Virtual Library is free software; you can redistribute it and/or modify it under the terms
of the <a href="http://www.gnu.org/licenses/gpl.html" target="_blank">GNU General Public
License</a> as published by the Free Software Foundation. This program is distributed in
the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
for more details.</p>
        </td>
      </tr>
    </table>
<?php
  }
} // class
?>
