
var xajaxRequestUri="http://erasmus.arlenads.com/devel/schema/util/upgrade.php";
var xajaxDebug=false;
var xajaxStatusMessages=false;
var xajaxWaitCursor=true;
var xajaxDefinedGet=0;
var xajaxDefinedPost=1;
var xajaxLoaded=false;
function xajax_testAjax(){return xajax.call("testAjax", arguments, 1);}
function xajax_loadChangeset(){return xajax.call("loadChangeset", arguments, 1);}
function xajax_loadSchema(){return xajax.call("loadSchema", arguments, 1);}
function xajax_expandTable(){return xajax.call("expandTable", arguments, 1);}
function xajax_collapseTable(){return xajax.call("collapseTable", arguments, 1);}
function xajax_editFieldProperty(){return xajax.call("editFieldProperty", arguments, 1);}
function xajax_exitFieldProperty(){return xajax.call("exitFieldProperty", arguments, 1);}
function xajax_editTableProperty(){return xajax.call("editTableProperty", arguments, 1);}
function xajax_exitTableProperty(){return xajax.call("exitTableProperty", arguments, 1);}
function xajax_editIndexProperty(){return xajax.call("editIndexProperty", arguments, 1);}
function xajax_exitIndexProperty(){return xajax.call("exitIndexProperty", arguments, 1);}
function xajax_addIndexField(){return xajax.call("addIndexField", arguments, 1);}
function xajax_expandOSURow(){return xajax.call("expandOSURow", arguments, 1);}
function xajax_collapseOSURow(){return xajax.call("collapseOSURow", arguments, 1);}
	
