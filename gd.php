<?

// Determine php version 
$phpversion = ereg_replace ("([^0-9])", "", phpversion()); 
$phpversion = $phpversion / pow (10, strlen($phpversion) - 1); 

if ($phpversion >= 4.02) { 
    // Use ImageTypes() to dermine image format 
    if (ImageTypes() & IMG_PNG) 
        $gdimageformat = "png"; 
    
    elseif (ImageTypes() & IMG_JPG) 
        $gdimageformat = "jpeg"; 
    
    elseif (ImageTypes() & IMG_GIF) 
        $gdimageformat = "gif"; 
    
    else 
        $gdimageformat = "none"; 

} else { 
    // Use Function_Exists to determine image format 
    if (function_exists("imagepng")) 
        $gdimageformat = "png"; 
    
    elseif (function_exists("imagejpeg")) 
        $gdimageformat = "jpeg"; 
    
    elseif (function_exists("imagegif")) 
        $gdimageformat = "gif"; 
    
    else 
        $gdimageformat = "none"; 
} 


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
