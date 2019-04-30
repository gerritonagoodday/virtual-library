<?php
// $Id$
// Based on the DOCMAN Joomla Component of johanjanssens

defined('_VALID_MOS') or die('Direct access to this location is not allowed.');

class HTML_VLFiles {

  // Boilerplate file listing display
  function listFiles($rows, $lists, $search, $pageNav){
    global $database,
    global $mosConfig_live_site;
    ?>
    <form action="index2.php" method="post" name="adminForm">
      <table class="adminheading">
        <tr class="edit">
          <th>
            <?VL_NAME." - ".VL_PUBLICATION_COVERS;?>
          </th>
          <td align="right" valign="center" nowrap="nowrap">
            <?=VL_FILENAME_FILTER:>
          </td>
          <td nowrap="nowrap" valign="center">
            <input type="text" name="authsearch"
                   value="<?php echo htmlspecialchars($authsearch);?>"
                   class="text_area" onChange="document.adminForm.submit();" />
          </td>
          <td>
            <input name="searchBtn" type=submit value="Filter">
          </td>
        </tr>
      </table>

      <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
        <tr>
          <th width="2%" class="title">
            <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows);?>);" />
          </th>
          <th width="15%" align="left"><?=VL_FILE_NAME;?></th>
          <th width="15%" align="center"><?=VL_FILE_DATE;?></th>
          <th width="15%"><?=VL_FILE_EXT;?></th>
          <th width="15%"><?=VL_MIME_TYPE;?></th>
          <th width="5%"><?=VL_FILE_SIZE;?></th>
          <!--
          <th width="5%"># <?php echo _DML_LINKS;?></th>
          <th width="5%" align="center"><?php echo _UPDATE;?></th>
          -->
        </tr>
        <?php
        $k = 0;
        for($i = 0, $n = count($rows);$i < $n;$i++){
          $row = &$rows[$i];
        ?>
          <tr class="<?php echo "row$k";?>">
            <td width="20">
              <input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->name?>" onclick="isChecked(this.checked);" />
            </td>
            <td><?php echo $row->name;?></td>
            <td align="center"><?php echo mosFormatDate($row->getDate());?></td>
            <td align="center"><?php echo $row->ext;?></td>
            <td align="center"><?php echo $row->mime;?></td>
            <td align="center"><?php echo $row->getSize();?></td>
            <td align="center"><?php echo $row->links;?></td>
            <td align="center">
              <a href="index2.php?option=com_docman&section=files&task=update&old_filename=<?php echo $row->name;?>"><img src="<?php echo $mosConfig_live_site;?>/components/com_docman/themes/default/images/icons/16x16/submit.png" alt="<?php echo _UPDATE;?>" border="0" /></a>
            </td>
          </tr>
        <?php
            $k = 1 - $k;
        }
        ?>
      </table>
      <?php echo $pageNav->getListFooter(); ?>
      <input type="hidden" name="option" value="com_docman" />
      <input type="hidden" name="section" value="files" />
      <input type="hidden" name="task" value="" />
      <input type="hidden" name="boxchecked" value="0" />
    </form>
  <?php
    printf(VL_FOOTER,VL_VERSION);
  }

  function uploadWizard(&$lists){
    global $mosConfig_live_site;
  ?>
    <form action="index2.php?option=com_docman&section=files&task=upload&step=2" method="post">
      <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
        <tr>
          <td colspan="3" class="sectionname" align="center"><?php echo _DML_UPLOADWIZARD;?></td>
        </tr>
        <tr>
          <td colspan="3" align="center"><b><?php echo _DML_UPLOADMETHOD;?></b></td>
        </tr>
        <tr>
          <td width="38%" rowspan="4" align="center">
          <div align="right" >
           <img src="<?php echo $mosConfig_live_site;?>/administrator/components/com_docman/images/upload.png">
            </div>
          </td>
          <td width="4%" align="center">
            <div align="right">
              <?php echo $lists['methods'];?>
            </div>
          </td>
          <td width="60%">&nbsp;</td>
          </tr>
        <tr>
          <td><div align="center">
              <input type="submit" name="Submit" value="<?php echo _DML_NEXT;?>>>>">
            </div></td>
          <td>&nbsp;</td>
        </tr>
      </table>
    </form>
    <form action="index2.php" method="post" name="adminForm">
      <input type="hidden" name="task" value=""/>
    </form>
  <?php
  }

  function uploadWizard_http($old_filename = null){
    global $mosConfig_live_site;
  ?>
    <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
    <script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
    <script language="Javascript" src="<?php echo $mosConfig_live_site;?>/administrator/components/com_docman/includes/js/docmanjavascript.js"></script>

    <form action="index2.php?option=com_docman&section=files&task=upload&step=3&method=http&old_filename=<?php echo $old_filename;?>" method="post" enctype="multipart/form-data" onSubmit="MM_showHideLayers('Layer1','','show')" name="fm_upload">
      <style type="text/css">
        <!--
        .style1 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-weight: bold;
        }
        .style2 {color: #FF0000}
        .style3 {color: #FFFFFF}
        //-->
      </style>

      <div id="Layer1" style="position:absolute; margin-left: auto; margin-right: auto;  width:200px; height:130px; z-index:1; visibility: hidden; left: 14px; top: 11px; background-color: #99989D; layer-background-color: #FF0000; border: 3px solid #F19518;">
        <div align="center" class="style1">
          <p align="center" class="style2"><br />
            <span class="style3"><?php echo _DML_ISUPLOADING;?></span>
          </p>

          <p align="center" class="style2"><img src="<?php echo $mosConfig_live_site;?>/administrator/components/com_docman/images/connect1.gif" ></p>
          <p align="center" class="style3"><?php echo _DML_PLEASEWAIT;?><br /></p>
        </div>
      </div>

      <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
        <tr>
          <td colspan="3" class="sectionname" align="center"><?php echo _DML_UPLOADDISK;?></td>
        </tr>
        <tr>
          <td colspan="3" align="center"><b><?php echo _DML_FILETOUPLOAD;?></b></td>
        </tr>
        <tr >
          <td width="40%" align="center" rowspan="6">
            <div align="right"><img src="<?php echo $mosConfig_live_site;?>/administrator/components/com_docman/images/upload.png">
          </td>
          <td nowrap >
            <?php echo _DML_FILETOUPLOAD;?>:
          </td>
          <td  align="left" width="80%">
            <div align="left">
              <input name="upload" type="file" id="upload" size="35">
            </div>
          </td>
        </tr>
        <?php
        if ($old_filename == '1') {
        ?>
          <tr>
            <td>
              <?php echo _DML_BATCHMODE;?>:
            </td>
            <td>
              <div align="left">
                <input name="batch" type="checkbox" id="batch" value="1"
                  onClick="if( ! document.fm_upload.localfile.disabled ){document.fm_upload.localfile.value='';}
                  document.fm_upload.localfile.disabled=!document.fm_upload.localfile.disabled;
                  return(true);">
                <?php echo mosWarning(_DML_BATCHMODETT, _DML_CFG_DOCMANTT);?>
              </div>
            </td>
          </tr>
        <?php
        }
        ?>
        <tr>
          <td align="left">
            <input type="button" name="Submit2" value="&lt;&lt;&lt;" onclick="window.history.back()">
          </td>
          <td align="center"><div align="left">
            <input type="submit" name="Submit" value="<?php echo _DML_SUBMIT ?>">
          </td>
        </tr>
      </table>
    </form>

    <form action="index2.php" method="post" name="adminForm">
      <input type="hidden" name="task" value="" />
    </form>
  <?php
  }

  function uploadWizard_transfer() {
    global $mosConfig_live_site;
  ?>

      <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
        <script language="Javascript" src="<?php echo $mosConfig_live_site;?>/administrator/components/com_docman/includes/js/docmanjavascript.js"></script>
        <script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
        <style type="text/css">
          .style1 {
              font-family: Verdana, Arial, Helvetica, sans-serif;
              font-weight: bold;
          }
    .style2 {color: #FF0000}
    .style3 {color: #FFFFFF}
    </style>

    <div id="Layer1" style="position:absolute; margin-left: auto; margin-right: auto;  width:200px; height:130px; z-index:1; visibility: hidden; left: 14px; top: 11px; background-color: #99989D; layer-background-color: #FF0000; border: 3px solid #F19518;">
      <div align="center" class="style1">
        <p align="center" class="style2"><br />
        <span class="style3"><?php echo _DML_DOCMANISTRANSF;?></span></p>
        <p align="center" class="style2"><img src="<?php echo $mosConfig_live_site;?>/administrator/components/com_docman/images/connect1.gif" ></p>
        <p align="center" class="style3"><?php echo _DML_PLEASEWAIT;?><br />
      </p>
      </div>
    </div>
      <form action="index2.php?option=com_docman&section=files&task=upload&step=3&method=transfer" method="post" onSubmit="MM_showHideLayers('Layer1','','show')">
        <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
        <tr>
          <td colspan="4" class="sectionname" align="center"><?php echo _DML_TRANSFERFROMWEB;?></td>
        </tr>
        <tr>
            <td width="40%" align="center"> <div align="right"><img src="<?php echo $mosConfig_live_site;?>/administrator/components/com_docman/images/upload.png">
            </td>
      <td nowrap><?php echo _DML_REMOTEURL;?>:</td>
            <td align="left">
            <div align="left">
                <input name="url" type="text" id="url" value="http://">
            </div></td>
      <td align="left"><?php echo mosToolTip(_DML_REMOTEURLTT . '</span>', _DML_CFG_DOCMANTT . '<br />' . _DML_REMOTEURL);?></td>
  </tr>
  <tr><td colspan="4">&nbsp;</td></tr>
  <tr>
      <td>&nbsp;</td>
            <td><?php echo _DML_LOCALNAME;?>:</td>
            <td align="left">
            <div align="left">
                <input name="localfile" type="text" id="url" value="">
            </div></td>
      <td align="left" width="40%"><?php echo mosToolTip(_DML_LOCALNAMETT . '</span>', _DML_CFG_DOCMANTT . '<br />' . _DML_LOCALNAME);?></td>
        </tr>
        <tr>
            <td colspan="2" align="center">&nbsp;</td>
            <td align="center"><div align="left">
                <input type="button" name="Submit2" value="&lt;&lt;&lt;" onclick="window.history.back()">
                <input type="submit" name="Submit" value="<?php echo _DML_SUBMIT;?>">
            </td>
        </tr>
      </table>
    </form>

    <form action="index2.php" method="post" name="adminForm"><input type="hidden" name="task" value="" /></form>
    <?php
    }

  function uploadWizard_sucess(&$file, $batch = 0, $old_filename = null, $show_completion = 1){
    global $mosConfig_live_site;
    if ($old_filename <> '1') {
        mosredirect("index2.php?option=com_docman&section=files", "&quot;" . $old_filename . "&quot; - " . _DML_DOCUPDATED);
    }
    ?>
    <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
    <tr>
      <td colspan="3" class="sectionname" align="center"><?php echo _DML_UPLOADWIZARD;?></td>
    </tr>
    <?php if($show_completion){
    /* backwards compatible */
    ?>
      <tr>
        <td width="38%" align="center">
          <div align="right">
            <img src="<?php echo $mosConfig_live_site;?>/administrator/components/com_docman/images/upload.png" />
          </div>
        </td>
        <td colspan="2"><div align="left">'<?php echo $file->name?>' -<?php echo _DML_FILEUPLOADED;?></div></td>
      </tr>
      <tr>
        <td colspan=2><div align="center"><hr /></td>
      <tr>
    <?php
    }
    ?>

    <!-- Give them a nice sub menu -->
    <?php
    if (!$batch && $old_filename == '1') {
        /* Can't create docs from a batch or existing file */
    ?>
      <tr>
        <td>
        <div align="right">
          <a href="index2.php?option=com_docman&section=documents&task=new&uploaded_file=<?php echo $file->name;?>">
          <img src="<?php echo $mosConfig_live_site;?>/administrator/images/edit_f2.png" border="0">
          </a>
        </div>
        </td>

        <td>
        <div align="left"><?php echo _DML_MAKENEWENTRY;?></div>
        </td>
      </tr>
    <?php
    }
    ?>
    <tr>
      <td>
        <div align="right">
          <a href="index2.php?option=com_docman&section=files&task=upload">
          <img src="<?php echo $mosConfig_live_site;?>/administrator/images/upload_f2.png" border="0">
          </a>
        </div>
      </td>
      <td><div align="left"><?php echo _DML_UPLOADMORE;?></div></td>
    </tr>
  <tr>
    <td>
      <div align="right">
        <a href="index2.php?option=com_docman&section=files">
          <img src="<?php echo $mosConfig_live_site;?>/administrator/images/next_f2.png" border="0">
        </a>
      </div>
    </td>
    <td>
      <div align="left"><?php echo _DML_DISPLAYFILES;?></div>
    </td>
  </tr>
  </table>

  <form action="index2.php" method="post" name="adminForm"><input type="hidden" name="task" value="" /></form>
  </body>
  <?php
  }
}

?>
