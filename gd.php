<?

// Decide which image format to use
  if (function_exists("imagegif"))
    $gdimageformat = "gif";    
  elseif (function_exists("imagejpeg"))
    $gdimageformat = "jpeg";    
  elseif (function_exists("imagepng"))
    $gdimageformat = "png";    
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
  }
}
?>
