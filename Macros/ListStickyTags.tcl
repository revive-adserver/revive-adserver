#!CVSGUI1.0 --selection  --name "List Sticky Tags"

#
# ListStickyTagss.tcl - Show a list of files grouped by sticky tags.
#
# This macro can be used to make sure that all files within a subdirectory tree
# use the same tag. If you should build a new release then you may want to
# know that all files are from the same tag group.
#
# Note! This macro uses "cvs status" command to query tags.
#       Faster method would be to use local CVS/Entries files to list
#       tags. However, this would not reveal whether a remote repository
#       has new files, which are not updated to local disk. If this is not
#       required then this macro could be modified to use "FastModSearch.tcl"
#       type of recursion to parse CVS/Entries file.
# 
# This code is provided as-is. Use at your own risk. 
#

global numFound
set numFound 0

global taglist
set taglist ""

global tagfilelist
set tagfilelist("") ""


# If "cvs" command returns an error then macro is not automatically
# terminated. We can handle the error in this macro.
cvsexitonerror false


#
# Identify files and tags
#
proc find_tags {filepath filename} {
   global numFound
   global taglist
   global tagfilelist

   cvsout "    Processing " $filepath "/" $filename "\n"

   #
   # Get file status, which showns sticky tags also.
   # -q = Somewhat minimal output, -n = Do not change anything (just in case)
   #
   set view_this [cvs -q -n status $filename]

   set errcode [cvslasterrorcode]
   if { $errcode != "0" } {
      cvsout "    Warning: Repository didn't understand " $filename "\n"
      set view_this ""
   }

   set stickytag  ""
   set view_lines [split $view_this "\n\r"]

   foreach line $view_lines {
     set line [string trim $line]

     if {[string match "Repository revision:*" $line]} {
        regsub "Repository revision:" $line "" filename
        set filename [string range $filename [string last "\t" $filename] end]
	set filename [string trim $filename]	

        continue
     }

     if {[string match "Sticky Tag:*" $line]} {
        regsub "Sticky Tag:" $line "" stickytag

	set stickytag [string trim $stickytag]
        set stickytag [string range $stickytag 0 [string first " " $stickytag]]

        if { $stickytag == "" } {
           set stickytag "(none)"
        }

        # Is this a new sticky tag?
	if { [lsearch -exact $taglist $stickytag] == -1 } {
           set tagfilelist($stickytag) ""
           lappend taglist $stickytag

           incr numFound
        }
      
	lappend tagfilelist($stickytag) $filename
     }
   }
}


#
# Print tag groups
#
proc report_tags {} {
   global taglist
   global tagfilelist
   global numFound

   set stickytag ""
   set filename  ""

   #
   # If there was at least one tag then go through taglist
   #
   if { $numFound > 1 } {
     foreach stickytag $taglist {
       if { [llength $tagfilelist($stickytag)] > 0 } {

         cvsout "\n  Sticky Tag: " $stickytag "\n"

         set prevfpath ""
         set fpath     ""
         set onlydir   "f"

         if { [llength $tagfilelist($stickytag)] > 15 } {
            cvsout "     More than 15 files in the group. Printing only directory names.\n"
            set onlydir "t"
         }

         foreach filename $tagfilelist($stickytag) {
             if { $onlydir == "f" } {
                 cvsout [format "     %s\n" $filename]
             } else {
                 set fpath [string range $filename 0 [string last "/" $filename]]                 
                 if { $prevfpath != $fpath } {
                      cvsout [format "     %s...\n" $fpath]
                      set prevfpath $fpath
                 }
             }
         }
       }
     }
   } else { 
     set stickytag [lindex $taglist 0]
     cvsout "    All files use the same sticky tag: " $stickytag "\n"
   }
}


#
# MAIN ENTRY
#
set selList [cvsbrowser get]
set selSize [llength $selList]

cvsout "\n--- Tagged files:  " 
cvsout [clock format [clock seconds] -format "%a %m/%d/%y %H:%M:%S"] " ---\n"

for {set i 0} {$i < $selSize} {incr i} {
   set file [lindex $selList $i]

   cvsbrowser info $file fileInfo

   if { $fileInfo(missing) == 0 && $fileInfo(unknown) == 0 } {
      cd $fileInfo(path)
      find_tags $fileInfo(path) $fileInfo(name)
   }
}

report_tags

cvsout "------------------------------\n"
cvsout $numFound " tag groups found.\n(done)\n"
