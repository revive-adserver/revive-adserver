<?

// Decide which image format to use
if (function_exists("imagepng"))
	$gdimageformat = "png";    
elseif (function_exists("imagejpeg"))
	$gdimageformat = "jpeg";    
elseif (function_exists("imagegif"))
	$gdimageformat = "gif";    
else
	$gdimageformat = "none";

function showimage(&$im)
{
	global $gdimageformat;
	switch($gdimageformat)
	{ 
		case "gif":
			ImageGIF($im);
			break;
		case "jpeg":
			ImageJPEG($im);
			break;
		case "png":
			ImagePNG($im);
			break;
		default:
			// hmm.. what to do here?  
			break; // just break I guess
	}
}
?>
