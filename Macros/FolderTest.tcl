#!CVSGUI1.0 --selection --name "Clean-up merging files"

global numDeleted
set numDeleted 0

proc iterate {dirName} {
	# check it is not a CVS folder
	if {[string compare cvs [string tolower $dirName]] == 0} {
		return
	}

	set oldDir [pwd]
	cd $dirName
	cvsout "Entering $dirName\n"

	set dirList [glob -nocomplain * .#*]
	set dirSize [llength $dirList]
	for {set j 0} {$j < $dirSize} {incr j} {
		set fileName [lindex $dirList $j]
		if {[file isdirectory $fileName]} {
			iterate $fileName
		} elseif {[file isfile $fileName]} {
			if {[string compare [string range $fileName 0 1] ".#"] == 0} {
				file delete $fileName
				global numDeleted
				incr numDeleted
			}
		}
	}
	cd $oldDir
}

set selList [cvsbrowser get]
set selSize [llength $selList]

for {set i 0} {$i < $selSize} {incr i} {
	set filename [lindex $selList $i]
	cvsbrowser info $filename fileInfo

	# check it is a folder
	if {[string compare $fileInfo(kind) "folder"] == 0} {
		iterate $filename
	}
}
cvsout "Done !\n"
cvsout "$numDeleted file(s) deleted !\n"
