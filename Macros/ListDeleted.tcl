#!CVSGUI1.0 --selection --name "List Deleted Files"

global numFound
set numFound 0

global folderTag
set folderTag ""

proc initFolderTag {path fname} {
	global folderTag
	set folderTag ""
	cd $path
	set tagFile [file join $path $fname "CVS" "Tag"]
	if {[file exist $tagFile] == 1} {
		set channel [open $tagFile RDONLY]
		gets $channel tagFileContent
		close $channel
		if {[regexp  "^T(.*)" $tagFileContent match tag] == 1} {			
		    set folderTag $tag
		} 
	}	
}

proc process {entry folder} {
	set pos [string first "cvs server: warning: " $entry]
	if {$pos < 0} {
		if {[string first "selected revisions: 1" $entry] >= 0} {		
			global numFound
			incr numFound 
			set user "xx"
			if {[regexp  "\nWorking file: (.*?)\n.*?\nrevision (.*?)\n.*; +author:(\[^;\]*?);" $entry match filename rev user] == 1} {
				set fn [file join  $folder $filename]
				cvserr $user "\t " $rev "\t " $fn  "\n"
			}
		}	
	}
}

proc iterate {path fname } {
	global folderTag	
	cd $fname
	append command "|cvs -q log  -N -s dead -r" $folderTag ". |& find /v \"\""
	set pipe [open $command RDONLY]
	while {[gets $pipe line] >= 0} {	
		if {[string compare $line "============================================================================="] == 0} {
			process $entry $fname
			set entry ""
		} else {
			append entry $line	"\n"
		}		 
	}
	close $pipe

	cd ..
}

set selList [cvsbrowser get]
set selSize [llength $selList]
set initDir [pwd]
cvsout "Looking for deleted files...\n"

for {set i 0} {$i < $selSize} {incr i} {
	set file [lindex $selList $i]
	cvsbrowser info $file fileInfo

	if {[string compare $fileInfo(kind) "folder"] == 0 && $fileInfo(missing) == 0 && $fileInfo(unknown) == 0} {
		initFolderTag $fileInfo(path) $fileInfo(name)
		iterate $fileInfo(path)	$fileInfo(name) 
	}
}

cd $initDir
cvsout "Files found: $numFound\n"
