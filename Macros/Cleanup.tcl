#!CVSGUI1.0 --selection --name "Remove non-CVS files"

global numFound
set numFound 0

proc iterate {dirName} {
	cvsentries $dirName browsit

	set selList [browsit get]
	set selSize [llength $selList]
	set toRecurse {}
	set printFlag 1

	for {set j 0} {$j < $selSize} {incr j} {
		set file [lindex $selList $j]
		browsit info $file fileInfo2

		if {[string compare $fileInfo2(kind) "file"] == 0 || [string compare $fileInfo2(kind) "folder"] == 0} {
			if {$fileInfo2(ignored) == 1 } {
				file delete -force $file
                global numFound
				incr numFound
			} elseif {$fileInfo2(unknown) == 1} {
                if {$printFlag == 1} {
	                cvsout "In $dirName :\n"
	                set printFlag 0
                }
                cvserr "    $fileInfo2(name)\n"
				trash $file
				global numFound
				incr numFound
			}
		}

		if {[string compare $fileInfo2(kind) "folder"] == 0 && $fileInfo2(missing) == 0 && $fileInfo2(unknown) == 0} {
			lappend toRecurse $file
		}
	}

	set selRecurse [llength $toRecurse]
	for {set j 0} {$j < $selRecurse} {incr j} {
		set file [lindex $toRecurse $j]
		iterate $file
	}
}

set selList [cvsbrowser get]
set selSize [llength $selList]

cvsout "Removing non-CVS files...\n"
for {set i 0} {$i < $selSize} {incr i} {
	set file [lindex $selList $i]
	cvsbrowser info $file fileInfo

	if {[string compare $fileInfo(kind) "folder"] == 0 && $fileInfo(missing) == 0 && $fileInfo(unknown) == 0} {
		iterate $file
	}
}

cvsout "Items(s) removed: $numFound \n"

