#!CVSGUI1.0 --selection --name "Change Root"

global numChanged
set numChanged 0
global changeTo

# PUT THE NEW VALUE HERE ! (ex: set changeTo ":pserver:alexgui@stratadev.strata3d.com:/cvspub/cvsgui")
set changeTo ""

if {[string compare $changeTo ""] == 0} {
	cvserr "You need to open-up this file and edit manually the new cvsroot\n"
	return
}

proc changeRoot {dirName} {
	set oldDir [pwd]
	cd $dirName

	set fileid [open Root w]
	global changeTo
	puts $fileid $changeTo
	close $fileid
	
	global numChanged
	incr numChanged
	
	cd $oldDir
}

proc iterate {dirName} {
	set oldDir [pwd]
	cd $dirName
	cvsout "Entering $dirName\n"

	set dirList [glob -nocomplain *]
	set dirSize [llength $dirList]
	for {set j 0} {$j < $dirSize} {incr j} {
		set fileName [lindex $dirList $j]
		if {[file isdirectory $fileName]} {
			if {[string compare cvs [string tolower $fileName]] == 0} {
				changeRoot $fileName
			} else {
				iterate $fileName
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
cvsout "$numChanged file(s) changed !\n"
