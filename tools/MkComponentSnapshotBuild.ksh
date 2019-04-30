#!/bin/ksh
# $Id: MkComponentSnapshotBuild.ksh 83 2007-12-18 00:02:56Z gerrit_hoekstra $

# What does it do?
# ~~~~~~~~~~~~~~~~
# This script fetches the latest state of all the code in your component
# repository and collates it into a Joomla installation package.
# This installtion is then checked back into SVN in the Snapshots directory.
#
# Using daily builds allows a curious person, who is prepared to take some
# risks with regards to instability, to install the component and to evaluate
# it (and to fawn and marvel over your work before any else)
#
# Usage
# ~~~~~
# You would normally run this via a cron job on a daily basis.
# Copy this script to a suitable place such as /usr/local/bin.
# Enter the following in your cron table (use the command `crontab -e` as
# user `root`) to run this process every night at 2.08 am for example:
# 08 2 * * * /usr/local/bin/MkComponentSnapshotBuild.ksh
#
# Environment:
# ~~~~~~~~~~~
# Below is what the expected directory structure off the SVN root of your
# project is expected to look like for component "com_xxx"
#
# +--com_xxx
# |     com_xxx.xml
# |     code.php
# |     etc..
# |
# +--nightlybuilds
#
# Configuration
# ~~~~~~~~~~~~~
# 0. Set the project name of the component
PROJECT="com_xxx"
#PROJECT="com_virtuallib"
# 1. Set the SVN project name, nighly build directory and the source files
#    directory (no trailing slashes)
SVNPROJECT="http://joomlacode.org/svn/${PROJECT}"
#    This is a sub-directory off the SVNPROJECT where snapshots are stored.
#    Don't change
SVNSNAPSHOTS="nightlybuilds"
#    This is the sub directory off the SVNPROJECT where actual translations
#    files are worked on.
SVNFILES=$PROJECT
# 2. Set your local working folder (no trailing slashes)
WORKFOLDER="/tmp"
# 3. Set the SVN user name and password
SVNUSERNAME="My svn user name"
SVNPASSWD="very_secret_password"
#SVNUSERNAME="gerrit_hoekstra"
#SVNPASSWD="xxxxx"
# 4. Nightly Build installation file name
#    This is a standard Joomla component install.
#    The build date in the file name will be displayed in
#    the format YYYYMMDD.
NIGHTLYBUILDFILENAME="${PROJECT}-nightlybuild"

# Save current environment
STARTDIR=${PWD}

# Static values
BUILDDATE=$(date +%Y%m%d)
TODAY=$(date +"%d %b %Y")
FINALBUILDFILENAME="${NIGHTLYBUILDFILENAME}-${BUILDDATE}.zip"
DEBUG=true

# Set up logging - this is important if we run this as a cron job
PROGNAME=${0##*/}
LOGFILE="/var/log/${PROGNAME%\.*}.log"
touch $LOGFILE 2>/dev/null
if [[ $? -ne 0 ]]; then
  LOGFILE="~/${PROGNAME%\.*}.log"
  touch "$LOGFILE" 2>/dev/null
  if [[ $? -ne 0 ]]; then
    LOGFILE="${PROGNAME%\.*}.log"
    touch "$LOGFILE" 2>/dev/null
    if [[ $? -ne 0 ]]; then
      printf "Could not write to $LOGFILE. Exiting...\n"
      exit 1
    fi
  fi
fi
printf "============= BEGIN: $(date) ===========\n" | tee -a $LOGFILE

# Debug
function debug {
  [[ -z $DEBUG ]] && return
  msg=$1
  printf "DEBUG: $msg\n" | tee -a $LOGFILE
}

printf "Check working directory $WORKFOLDER...\n" | tee -a $LOGFILE
if [[ ! -d $WORKFOLDER ]]; then
  printf "Making $WORKFOLDER...\n"
  mkdir -p $WORKFOLDER
fi
if [[ ! -d $WORKFOLDER ]]; then
  printf "Working folder $WORKFOLDER does not exist.\nExiting...\n" | tee -a $LOGFILE
  exit 1
fi
if [[ ! -w $WORKFOLDER ]]; then
  printf "Working folder $WORKFOLDER is not writable.\nExiting...\n" | tee -a $LOGFILE
  exit 1
fi

cd $WORKFOLDER
rm -fr $SVNSNAPSHOTS 2>/dev/null
rm -fr $SVNFILES 2>/dev/null

printf "Get all nightly builds from $SVNPROJECT/$SVNSNAPSHOTS to $WORKFOLDER...\n" | tee -a $LOGFILE
debug "svn checkout --username $SVNUSERNAME --password $SVNPASSWD $SVNPROJECT/$SVNSNAPSHOTS"
RETCODE=$(svn checkout --username $SVNUSERNAME --password $SVNPASSWD $SVNPROJECT/$SVNSNAPSHOTS)
if [[ $RETCODE = +(error) ]]; then
  printf "Could not check out project $SVNPROJECT/$SVNSNAPSHOTS as user $SVNUSERNAME to $WORKFOLDER.\nExiting...\n" | tee -a $LOGFILE
  cd $STARTDIR
  exit 1
fi

printf "Most recent nightly build is..." | tee -a $LOGFILE
debug "find $SVNSNAPSHOTS -type f -name \"*.zip\" | grep $NIGHTLYBUILDFILENAME | sort | tail -1 | sed -e \"s|\.\/||g\""
LASTNIGHTLYBUILDFILENAME=$(find $SVNSNAPSHOTS -type f -name "*.zip" | grep $NIGHTLYBUILDFILENAME | sort | tail -1 | sed -e "s|\.\/||g")
if [[ -z $LASTNIGHTLYBUILDFILENAME ]]; then
  printf "none yet\n" | tee -a $LOGFILE
else
  printf "$LASTNIGHTLYBUILDFILENAME\n" | tee -a $LOGFILE
fi

printf "Get Source Files from $SVNPROJECT/$SVNFILES...\n" | tee -a $LOGFILE
debug "svn checkout --username $SVNUSERNAME $SVNPROJECT/$SVNFILES"
RETCODE=$(svn checkout --username $SVNUSERNAME $SVNPROJECT/$SVNFILES)
if [[ $RETCODE = +(error) ]]; then
  printf "Could not check out files from $SVNPROJECT/$SVNFILES as user $SVNUSERNAME to $WORKFOLDER. Error code from svn: $RETCODE\nExiting...\n" | tee -a $LOGFILE
  cd $STARTDIR
  exit 1
fi

if [[ -z $LASTNIGHTLYBUILDFILENAME ]]; then
  printf "Package up installation snapshot to $SVNSNAPSHOTS/$FINALBUILDFILENAME...\n" | tee -a $LOGFILE
  debug "zip -r -m $SVNSNAPSHOTS/$FINALBUILDFILENAME $SVNFILES -x '*/.svn/*' 1>/dev/null 2>&1"
  RETCODE=$(zip -r -m $SVNSNAPSHOTS/$FINALBUILDFILENAME $SVNFILES -x '*/.svn/*' 1>/dev/null 2>&1)
  if [[ $RETCODE -ne 0 ]]; then
    printf "Could not package the snapshot into file $FINALBUILDFILENAME. Error code from zip: $RETCODE.\nExiting...\n" | tee -a $LOGFILE
    cd $STARTDIR
    exit 1
  fi
else
  # Exists already - need to override existing and then rename in SVN
  printf "Package up installation snapshot to overwrite $LASTNIGHTLYBUILDFILENAME...\n" | tee -a $LOGFILE
  debug "rm -f $LASTNIGHTLYBUILDFILENAME 2>/dev/null"
  rm -f $LASTNIGHTLYBUILDFILENAME 2>/dev/null
  debug    "zip -r -m $LASTNIGHTLYBUILDFILENAME $SVNFILES -x '*/\.svn/*' 1>/dev/null 2>&1"
  RETCODE=$(zip -r -m $LASTNIGHTLYBUILDFILENAME $SVNFILES -x '*/\.svn/*' 1>/dev/null 2>&1)
  if [[ $RETCODE -ne 0 ]]; then
    printf "Could not package the snapshot into file $LASTNIGHTLYBUILDFILENAME. Error code from zip: $RETCODE.\nExiting...\n" | tee -a $LOGFILE
    cd $STARTDIR
    exit 1
  fi
  printf "Renaming $LASTNIGHTLYBUILDFILENAME to $SVNSNAPSHOTS/$FINALBUILDFILENAME in SVN...\n" | tee -a $LOGFILE
  debug    "svn rename $LASTNIGHTLYBUILDFILENAME $SVNSNAPSHOTS/$FINALBUILDFILENAME --force"
  RETCODE=$(svn rename $LASTNIGHTLYBUILDFILENAME $SVNSNAPSHOTS/$FINALBUILDFILENAME --force)
  if [[ $RETCODE = +(error) ]]; then
    printf "Could not rename $LASTNIGHTLYBUILDFILENAME to $FINALBUILDFILENAME in SVN. Error code from svn: $RETCODE.\nExiting...\n" | tee -a $LOGFILE
    cd $STARTDIR
    exit 1
  fi  
fi

printf "Check-in installation snapshot $SVNSNAPSHOTS/$FINALBUILDFILENAME...\n" | tee -a $LOGFILE
cd $SVNSNAPSHOTS
debug "svn commit --username $SVNUSERNAME --password $SVNPASSWD -m \"Latest Installation Package as of $TODAY\""
RETCODE=$(svn commit --username $SVNUSERNAME --password $SVNPASSWD -m "Latest Installation Package as of $TODAY")
if [[ $RETCODE = +(error) ]]; then
  printf "Could not check-in the snapshot $FINALBUILDFILENAME. Error code from svn: $RETCODE.\nExiting...\n" | tee -a $LOGFILE
  cd $STARTDIR
  exit 1
fi
cd -

printf "Cleaning up...\n" | tee -a $LOGFILE
#rm -fr $SVNSNAPSHOTS 2>/dev/null
#rm -fr $SVNFILES 2>/dev/null
cd $STARTDIR

printf "============= END:   $(date) ===========\n" | tee -a $LOGFILE
