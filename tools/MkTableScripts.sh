#!/bin/bash
# $Id: MkTableScripts.sh 98 2010-12-05 13:15:25Z gerrit_hoekstra $

# Makes Table Class PHP scripts of the chosen set of tables.
# Creates the table classes in the current working directory, which would normally be here:
# com_<component>/admin/tables
# Assumes table names are in standard Joomla form XXX_tableName, e.g. jos_sections
#  - only filter for table RegEx 'sections'
# Apologies for the foul and inefficient use of mysql metadata, but this is in the nature of shell scripts
# Author: Gerrit Hoekstra DEC2010 gerrit@hoekstra.co.uk, www.hoekstra.co.uk

# Parameters:
# DB User
mysqluser=root
# DB password
mysqlpwd=
# DB name
mysqldb=j1522
# Only create PHP class files for tables that match this RegEx (empty matches all tables):
table_filter="session"
# Package Name
package_name="Virtual Library"
# Copyright to whom:
copyright_to="Gerrit Hoekstra"

# Static data
year=$(date +"%Y")
# Associative array: SQL types to Joomla PHP types
declare -A typemap
typemap[smallint]=int
typemap[mediumint]=int
typemap[int]=int
typemap[integer]=int
typemap[tinyint]=boolean
typemap[bigint]=int
typemap[serial]=number
typemap[float]=number
typemap[double]=number
typemap[decimal]=number
typemap[dec]=number
typemap[date]=date
typemap[datetime]=date
typemap[timestamp]=date
typemap[times]=date
typemap[year]=date
typemap[char]=string
typemap[varchar]=string
typemap[tinytext]=string
typemap[text]=string
typemap[mediumtext]=string
typemap[longtext]=string
typemap[tinyblob]=string
typemap[blob]=string
typemap[mediumblob]=string
typemap[longblob]=string
typemap[binary]=string
typemap[varbinary]=string
typemap[enum]=string
typemap[set]=string


declare -a tables
tables=(`mysql -u${mysqluser} -p${mysqlpwd} ${mysqldb} -Bse 'show tables' | grep ${table_filter:-_}`)
if [[ ${#tables[@]} -eq 0 ]]; then
  printf "Could not get any tables that match the regular expression: %s\n" ${table_filter}
  exit 1
fi

for (( i=0; i<${#tables[@]}; i++ )); do
  # Tablename without prefix
  table=$(echo ${tables[$i]} | sed -e 's/^.\{3\}_//')
  printf "Getting the details for table %s...\n" ${table}
  desc_cmd="mysql -u${mysqluser} -p${mysqlpwd} ${mysqldb} -Bse 'desc ${tables[$i]}'"
  desc_cmd_box="mysql -u${mysqluser} -p${mysqlpwd} ${mysqldb} -t -e 'desc ${tables[$i]}'"
  desc_cmd_indexes="mysql -u${mysqluser} -p${mysqlpwd} ${mysqldb} -Bse 'show indexes from ${tables[$i]}'"

  # Columns
  declare -a columns  
  columns=(`eval $desc_cmd | cut -f1`)
  [[ ${#columns[@]} -eq 0 ]] && printf " - No columns for table %s. Skipping.\n" ${tables[$i]} && continue
  printf " - ${#columns[@]} columns for table %s\n" ${tables[$i]}

  # Primary Keys
  declare -a primarykeys  
  primarykeys=(`eval $desc_cmd | grep "[[:space:]]PRI[[:space:]]" | cut -f1`)
  [[ ${#primarykeys[@]} -eq 0 ]] && printf " - No primary key columns for table %s\n" ${tables[$i]}
  [[ ${#primarykeys[@]} -gt 0 ]] && printf " - %d primary key column for table %s\n" ${#primarykeys[@]} ${tables[$i]}

  # Foreign keys
  declare -a foreignkeys  
  foreignkeys=(`eval $desc_cmd | grep "[[:space:]]MUL[[:space:]]" | cut -f1`)
  [[ ${#foreignkeys[@]} -eq 0 ]] && printf " - No foreign key columns for table %s\n" ${tables[$i]}
  [[ ${#foreignkeys[@]} -gt 0 ]] && printf " - %d foreign key columns for table %s\n" ${#foreignkeys[@]} ${tables[$i]}

  # Other columns
  declare -a remainingcols
  remainingcols=(`eval $desc_cmd | grep -v "[[:space:]]MUL[[:space:]]" | grep -v "[[:space:]]PRI[[:space:]]" | cut -f1`)
  [[ ${#remainingcols[@]} -eq 0 ]] && printf " - No other columns for table %s\n" ${tables[$i]}
  [[ ${#remainingcols[@]} -gt 0 ]] && printf " - %d other columns for table %s\n" ${#remainingcols[@]} ${tables[$i]}

  # Camel case table name
  camelname=$(echo ${tables[$i]} | sed -e 's/^.\{3\}_//g' | sed -e 's/^\([a-z]\)/\U\1/g')
  # Make up nice table name
  classname="Table"$camelname
  # make up lowercase table name file
  filename=$(echo ${tables[$i]} | sed -e 's/^.\{3\}_//g' | tr "[:upper:]" "[:lower:]").php
  printf "Building PHP file %s for table %s...\n" $filename ${tables[$i]}

  printf "<?php
/**
* @version    \$Id: \$
* @package    ${package_name}
* @subpackage Table
* @copyright  Copyright (C) ${year} ${copyright_to}. All rights reserved.
* @license    GNU/GPL
* @since      1.5
*
* Joomla! table class for #__${table}:
" > $filename
  eval $desc_cmd_box | sed -e 's/^/* /' >> $filename
  printf "*/

defined('_JEXEC') or die( 'Restricted access' );

class $classname extends JTable {

  // Primary Key columns:\n" >> $filename
  # Primary key column
  if [[ ${#primarykeys[@]} -ge 0 ]]; then
    for ((j=0;j<${#primarykeys[@]};j++)); do
      type=${typemap[$(eval $desc_cmd | grep "^${primarykeys[$j]}\s" | cut -f2 | sed -e 's/(.\+//')]}
      printf "  /** @var %s Primary key */\n  var \$%s = null;\n" ${type} ${primarykeys[$j]} >> $filename
    done
  fi
  # Foreign key columns
  printf "\n  // Foreign key columns:\n" >> $filename
  for ((j=0;j<${#foreignkeys[@]};j++)); do
    type=${typemap[$(eval $desc_cmd | grep "^${foreignkeys[$j]}\s" | cut -f2 | sed -e 's/(.\+//')]}
    printf "  /** @var %s Foreign key */\n  var \$%s = null;\n" ${type} ${foreignkeys[$j]} >> $filename
  done
  # Other columns
  printf "\n  // Other columns:\n" >> $filename
  for ((j=0;j<${#remainingcols[@]};j++)); do
    type=${typemap[$(eval $desc_cmd | grep "^${remainingcols[$j]}\s" | cut -f2 | sed -e 's/(.\+//')]}
    printf "  /** @var %s */\n  var \$%s = null;\n" ${type} ${remainingcols[$j]} >> $filename
  done

  # Constructor
  [[ -n ${primarykeys[0]} ]] && key=${primarykeys[0]} || key=${insert_colums[0]}
  printf "\n  /**\n  * Constructor\n  * @param database A database connector object\n  */\n  function __construct(&\$db){
    parent::__construct('#__${table}','${key}',\$db);
  }\n" >> $filename


  # Select data
  # Make up filter columns based on existing table indexes
  filter_colums=(`eval $desc_cmd_indexes | cut -f5`)
  if [[ ${#filter_colums[@]} -eq 0 ]]; then
    # If no columns are indexed, then allow filtering of all columns
    filter_colums=(`eval $desc_cmd | cut -f1`)
  fi
  printf "\n  /**\n  * Select with AND filter - returns rowset\n  * @param \$$(echo ${filter_colums[*]} | sed -e 's/\s/\n  * @param \$/g')\n  */\n  function select(\$$(echo ${filter_colums[*]} | sed -e 's/\s/=null, \$/g')=null){\n"  >> $filename
  printf "    // Determine the filter clause\n" >> $filename
  for ((j=0;j<${#filter_colums[@]};j++)); do
    if [[ $j -gt 0 ]]; then
      printf "    if(\$where && \$${filter_colums[$j]}){\$where .= ' and ';}\n" >> $filename
    fi
    printf "    if(\$${filter_colums[$j]}){\$where .= \"${filter_colums[$j]}=\".\$this->_db->Quote('\$${filter_colums[$j]}');}\n" >> $filename
  done
  printf "    if(\$where){\$query='SELECT * FROM #__$table WHERE \$where';}else{\$query='SELECT * FROM #__$table';}\n" >> $filename
  printf "    \$this->_db->setQuery(\$query);
    \$result=\$this->_db->loadRowList();
    if(!\$result){
      \$this->setError(get_class(\$this).\"::\".JText::_('SELECT FAILED').\"<br />\".\$this->_db->stderr().\"<br/>\".\$query);
      return false;
    }
    return \$result;
  }\n" >> $filename



  # Insert of not-nullable mandatory values
  declare -a insert_colums
  insert_colums=(`eval $desc_cmd | grep -v auto_increment | grep "..*\sNO\s" | cut -f1`) 
  printf "\n  /**\n  * Insert\n  * @param \$$(echo ${insert_colums[*]} | sed -e 's/\s/\n  * @param \$/g')\n  */\n  function insert(\$$(echo ${insert_colums[*]} | sed -e 's/\s/, \$/g')){\n"  >> $filename  
  for ((j=0;j<${#insert_colums[@]};j++)); do
    printf "    \$this->${insert_colums[$j]} = \$${insert_colums[$j]};\n"  >> $filename
  done
  if [[ -n $primarykeys[0] ]]; then
    printf "    \$ret = \$this->_db->insertObject(\$this->_tbl, \$this, '${primarykeys[0]}');\n" >> $filename
  else
    printf "    \$ret = \$this->_db->insertObject(\$this->_tbl, \$this);\n" >> $filename
  fi
  printf "    if(!\$ret) {
      \$this->setError(get_class(\$this).\"::\".JText::_('INSERT FAILED').\"<br />\".\$this->_db->stderr());
      return false;
    } else {
      return true;
    }
  }\n" >> $filename

  # Update of non-nullable values
  update_colums=(`eval $desc_cmd | grep -v "^$key\s" | grep "..*\sNO\s" | cut -f1`)
  printf "\n  /**\n  * Update\n  * @param \$$(echo ${update_colums[*]} | sed -e 's/\s/\n  * @param \$/g')\n  */\n  function update(\$$(echo ${update_colums[*]} | sed -e 's/\s/, \$/g'), \$updateNulls=false){\n"  >> $filename
  for ((j=0;j<${#update_colums[@]};j++)); do
    printf "    \$this->${update_colums[$j]} = \$${update_colums[$j]};\n"  >> $filename
  done
  printf "    \$ret = \$this->_db->updateObject(\$this->_tbl, \$this, '$key', \$updateNulls );\n" >> $filename
  printf "    if(!\$ret) {
      \$this->setError(get_class(\$this).\"::\".JText::_('UPDATE FAILED').\"<br />\".\$this->_db->stderr());
      return false;
    }else{
      return true;
    }
  }\n" >> $filename

  printf "\n  /**\n  * Delete record\n  * @param \$$key\n  */\n  function delete(\$$key=null){
    \$k = \$this->_tbl_key;
    if(\$$key){
      \$this->\$k = \$$key;
    }
    \$query = 'DELETE FROM '.\$this->_db->nameQuote(\$this->_tbl).' WHERE '.\$this->_tbl_key.' = '.\$this->_db->Quote(\$this->\$k);
    \$this->_db->setQuery(\$query);
    if(\$this->_db->query()){
      return true;
    }else{      
      \$this->setError(get_class(\$this).\"::\".JText::_('DELETE FAILED').\"<br />\".\$this->_db->stderr());
      return false;
    }
  }\n" >> $filename

  # Overloaded check function
  printf "\n  /**\n  * Content Validation before record update or insert\n  */
  function check(){
    // You should put your own custom content validation in here or else remove this function.
    // This example uselessly checks if the table is empty
    if(!\$this->contents){
      \$this->setError('#__${table} '.JText::_('TABLE IS EMPTY'));
      return false;
    }else{
      return true;
    }
  }\n" >> $filename

  # Check if record exists
  printf "\n  /**\n  * Check if record exists\n  * @param \$$key\n  */\n  function exists(\$$key){
    \$query = 'SELECT COUNT($key) FROM #__$table WHERE $key = '.\$this->_db->Quote('$key');
    \$this->_db->setQuery(\$query);
    if(!\$result = \$this->_db->loadResult()){
      \$this->setError(\$this->_db->stderr());
      return false;
    }
    return (boolean) \$result;
  }\n" >> $filename

  printf "}\n?>" >> $filename
 
done



