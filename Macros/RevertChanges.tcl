#!CVSGUI1.0 --selection  --name "Revert Changes"

global numFound
set numFound 0

proc processfile {file revision} {
	set curdir [pwd]
	cd [file dirname $file]
	set fn [file tail $file]
	cvsout "     $revision $fn\n"
	append fileBck $file ".#" $revision
	if {[file exists $fileBck]} {
		file attributes $fileBck -readonly 0
		trash $fileBck        	
	}
	file rename $file $fileBck
	cvs update -j $revision $fn
	cd $curdir
	global numFound
	incr numFound
}

proc iterate {dirName} {
    cvsentries $dirName browsit

	cd $dirName

    set selList [browsit get]
    set selSize [llength $selList]
    set toRecurse {}
    set printFlag 1

    for {set j 0} {$j < $selSize} {incr j} {
        set file [lindex $selList $j]
        browsit info $file fileInfo2

        if {[string compare $fileInfo2(kind) "file"] == 0 && $fileInfo2(modified) == 1} {
			if {$printFlag == 1} {
				cvsout "In $dirName :\n"
				set printFlag 0
			}
		    processfile $file $fileInfo2(revision)
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

	cd ..
}

set selList [cvsbrowser get]
set selSize [llength $selList]

cvsout "Looking for modified files...\n"
for {set i 0} {$i < $selSize} {incr i} {
    set file [lindex $selList $i]
    cvsbrowser info $file fileInfo

    if {$fileInfo(missing) == 0 && $fileInfo(unknown) == 0} {
        if {[string compare $fileInfo(kind) "file"] == 0 && $fileInfo(modified) == 1} {
            processfile $file $fileInfo(revision)
        }
        if {[string compare $fileInfo(kind) "folder"] == 0} {
            iterate $file
        }
    }
}

cvsout "$numFound file(s) reset\n"
