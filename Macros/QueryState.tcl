#!CVSGUI1.0 --selection --name "Query state"

#
# 27.5.2000 Mika Nieminen (poiu@altavista.net)
#
# QueryState.tcl - Query to see the state of local and remote files.
#
# Show a list of files, which are somehow out of date with
# the repository. Repository may have newer file (patch)
# available or local file has been modified. 
#
# The output of this script is a table of file status
# and revision numbers.
#   
#   FILE STATUS | LOCAL REVISION | REMOTE REVISION | FILE NAME
#
#   Status: Needs patch       1.2  1.5   /cvsroot/app/main.cpp
#   Status: Locally modified  2.3        /cvsroot/app/util.cpp
#
# If remote revision field is empty then it is the same as local revision.
# It is easy to see if there are new patches available by looking at 
# the REMOTE REVISION column. If there is a value then patch is needed.
#
# The code expects to find "File:", "Working revision:" and "Repository revision:"
# tags from the output of "CVS -Q -n status" command. 
#
# Place this file in "<WinCVSInstall>\Macros\" subdirectory with rest
# of the *.TCL files. WinCVS will automatically use TCL files in this directory.
#
# This code is provided as-is. Use at your own risk. 
# 

#
# PROC: Print file status entry with working and repository revision numbers
#
proc printEntry {status workrev reporev fname} {
   if {[string compare $workrev $reporev] == 0} {
      # If working and repository revision are the same 
      # then no need to show the same value twice. This 
      # makes it also easy to see if there are new patches available.
      set reporev ""
   }
 
   cvsout [format "%-28s %-6s %-6s %s" $status $workrev $reporev $fname] "\n"
}


#
# MAIN ENTRY
#

cvsout "--- Status request " 
cvsout [clock format [clock seconds] -format "%a %m/%d/%y %H:%M:%S"] " ---\n"

#
# Get a list of selected items (could be more than one)
#
set selList [cvsbrowser get]
set selSize [llength $selList]

for {set i 0} {$i < $selSize} {incr i} {
   set file [lindex $selList $i]
   cvsbrowser info $file fileInfo

   cd $fileInfo(path)

   #
   # Get the status of the selection. If selection was path
   # then raw text contains file status to more than one file.
   # The code below will parse the output text and extract
   # file names and revision numbers.
   #
   # -Q = Minimal text output,  -n = Do not change repository state (just in case)
   #
   set text [cvs -Q -n status $fileInfo(name)]

   # Convert raw text to a list where item separator is newline char
   set lineList [split $text \n]
   set lineListSize [llength $lineList]
    
   set text    ""
  
   set status  ""
   set workrev ""
   set reporev ""

   #
   # Iterate through every line in lineList and parse
   # status and revision tags
   #
   for {set idx 0} {$idx < $lineListSize} {incr idx} {
      set text [lindex $lineList $idx]
      set text [string trim $text]

      if {[string match "File:*" $text] == 1} {
         if {[string match "*Status: Up-to-date*" $text] == 0} {
	    # This file is NOT up-to-date, so let's store the status
            set status [string range $text [string first "Status:" $text] end]
            set status [string trim $status]
         }

      } elseif {[string match "Working revision:*" $text] == 1} {
         # Store working revision number (ie. local file)
	 set workrev [string replace $text 0 17]
         set workrev [string trim $workrev]

      } elseif {[string match "Repository revision:*" $text] == 1} {
         # Store repository revision number (ie. remote file)
	 set reporev [string replace $text 0 20]
         set reporev [string trim $reporev]

         #
         # Split repository revision and file name items.
         # Append two dummy items to make sure that there
         # are at least 2 items in the list.
         #
         set tmpList [split $reporev \t]
         lappend tmpList "x" "x"

         set reporev [lindex $tmpList 0]
	 set fname   [lindex $tmpList 1]

         # If file is NOT up-to-date then print the status
	 if {[string compare $status ""] != 0} {
	    printEntry $status $workrev $reporev $fname
         }

	 set status  ""
         set workrev ""
         set reporev ""
      }
   }
}

cvsout "(done)\n"

