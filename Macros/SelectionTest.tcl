#!CVSGUI1.0 --selection  --name "Selection sample"

set selList [cvsbrowser get]
set selSize [llength $selList]

cvsout "Hello, this is a sample macro !\n"
cvsout "Total selected : " $selSize "\n\n"
for {set i 0} {$i < $selSize} {incr i} {
	#file tail
	#file dirname
	set file [lindex $selList $i]
	cvsbrowser info $file fileInfo

	cvsout "Info for " $file "\n"
	cvsout "--> Name :         " $fileInfo(name) "\n"
	cvsout "--> Kind :         " $fileInfo(kind) "\n"
	cvsout "--> Path :         " $fileInfo(path) "\n"
	cvsout "--> Missing :      " $fileInfo(missing) "\n"
	cvsout "--> Unknown :      " $fileInfo(unknown) "\n"
	cvsout "--> Ignored :      " $fileInfo(ignored) "\n"
	cvsout "--> Locked :       " $fileInfo(locked) "\n"
	cvsout "--> Modified :     " $fileInfo(modified) "\n"
	cvsout "--> Status :       " $fileInfo(status) "\n"

	if {[string compare $fileInfo(kind) "file"] == 0} {
		cvsout "--> Revision :     " $fileInfo(revision) "\n"
		cvsout "--> Timestamp :    " $fileInfo(timestamp) "\n"
		cvsout "--> Option :       " $fileInfo(option) "\n"
		cvsout "--> Tag :          " $fileInfo(tag) "\n"
		cvsout "--> Conflict :     " $fileInfo(conflict) "\n"
	}
	cvsout "\n"
}
