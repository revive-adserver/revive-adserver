#!CVSGUI1.0 --selection  --name "List Locked Files"

#
# ListLockedFiles.tcl - Show a list of files, which have been locked.
#
# The output of this script is a list of file names, which have
# been locked. The output shows the revision number of locked 
# file and name of the user owns the lock.
#   
# FILE PATH 
#     FILE NAME     USERNAME: LOCKED REVISION
#
# /projects/myapp/
#     main.cpp      john: 1.5
#                   mary: 1.6
#     util.cpp      mary: 1.25
#
# /projects/otherapp/gui/
#     wndmain.cpp   john: 1.4
#
# If the file name column is empty then more than one revision of the
# same file has been locked. In the above shown example two revisions
# of main.cpp file have been locked.
#
# The code expects to find "Working file:" and "locks:" and "access list:"
# tags from the output of "CVS -Q -n log -h -N" command. The output
# is grouped by file paths, so you can easily see where the 
# locked files are. 
#
# Please note that if you select the root path entry from WinCVS directory browser 
# then "cvs log" command may not work if root doesn't have CVS/Entries. In this case
# you should select all directories from the file browser (left panel) and you'll
# see a list of locked files from the whole repository.
#
# This code is based on post found in info-cvs newsgroup.
# The original version was for TkCvs and then it was ported 
# to WinCVS. The code here was modified to use "cvs log -h"
# command, because the normal "cvs log" command may give
# a huge ouput in a big project. "-h" option prints only
# a header for each file, but luckily the header has also
# list of locks (if any). 
# 
# This code is provided as-is. Use at your own risk. 
#

global numFound
set numFound 0

global prevFilePath
set prevFilePath "***"


# If "cvs" command returns an error then macro is not automatically
# terminated. We can handle the error in this macro.
cvsexitonerror false

proc report_locks {filePath fileName} {
   global prevFilePath

   #
   # cvs log command gives a list of file revisions.
   #
   # If the file has locks then "locks:" line of cvs log 
   # output is followed by user names and revision numbers.
   #
   # -Q = Minimal output (quiet), -n = Do not change anything (just in case)
   # -h = File header info only, -N = No tag output
   #
   set view_this [cvs -Q -n log -h -N $fileName]

   set errcode [cvslasterrorcode]
   if { $errcode != "0" } {
      cvsout "  Warning: Repository didn't understand " $fileName "\n"
      set view_this ""
   }
   
   set filelist   ""
   set found      "f"
   set parselocks "f"

   set view_lines [split $view_this "\n\r"]

   foreach line $view_lines {
     if {[string match "Working file: *" $line]} {
        #
        # Store file name and create empty locklist for a file.
        # 
        regsub "Working file: " $line "" filename
        lappend filelist $filename
        set locklist($filename) ""
        set parselocks "f"
        continue
     }

     if { $parselocks == "t" } {
        if {[string match "access list:*" $line]} {
           # No more locks for this file
           set parselocks "f"
        } else {
           # Lock found for this file
           set line [string trim $line]
           lappend locklist($filename) $line
           set found "t"
        }
        continue
     } 

     if {[string match "locks: *" $line]} {
         #
         # Let's prepare to parse lock definitions. 
         # The next N lines are lock names and the
         # list is ended at "access list:" line
         # 
         set parselocks "t"
     }
   }

   #
   # If there was at least one lock then go through filelist and locklist
   # and print nicely formatted list of locked file names and revisions
   #
   if { $found == "t" } {
     foreach filename $filelist {
       if { [llength $locklist($filename)] > 0 } {

         #
         # Split filepath+filename to path and filename parts
         #
	 set fullFilePathName [format "%s/%s" $filePath $filename]
         set fpath [string range $fullFilePathName 0 [string last "/" $fullFilePathName]]
         set fname [string range $fullFilePathName [string last "/" $fullFilePathName] end]
	 set fname [string replace $fname 0 0]

         #
         # If the file is in a different path then print
         # path as a group separator in an output
         #
	 if { $prevFilePath != $fpath } {
             cvsout "\n  " $fpath "\n"
	     set prevFilePath $fpath
         } 

         foreach rev $locklist($filename) {
             cvsout [format "     %-15s  %s\n" $fname $rev]

             # If more than one revisions of the same file have been
             # locked then don't print the same file name more than once.
             set fname ""

             global numFound
             incr numFound
         }
       }
     }
   } 
}


#
# MAIN ENTRY
#
set selList [cvsbrowser get]
set selSize [llength $selList]

cvsout "\n--- Locked files:  " 
cvsout [clock format [clock seconds] -format "%a %m/%d/%y %H:%M:%S"] " ---\n"

for {set i 0} {$i < $selSize} {incr i} {
   set file [lindex $selList $i]

   cvsbrowser info $file fileInfo

   if { $fileInfo(missing) == 0 && $fileInfo(unknown) == 0 } {
      cd $fileInfo(path)
      report_locks $fileInfo(path) $fileInfo(name)
   }
}

cvsout "------------------------------\n"
cvsout $numFound " locked files found.\n(done)\n"
