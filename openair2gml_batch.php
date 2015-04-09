<?php

include "Tools.php";
include "includes/open_aip_airspace.converter.aspc_converter.inc";

// recreate the output dir..
rrmdir("./gml");
mkdir("./gml");

$aspConverter = new AirspaceConverter();

if ($handle = opendir('./openair')) {
   
  while (false !== ($file = readdir($handle))) 
  {
    if ($file != "." && $file != "..") 
    {
      if (substr ($file, 2, 1) != "_")
      {
        echo "Skip $file..<BR>\n";
        continue;
      }
      
      echo "Processing $file..<BR>\n";
        
      if (!$aspConverter->loadFile("./openair/$file", "OPENAIR"))
      {
        echo $aspConverter->warnings;
        echo $aspConverter->errors;
        echo "FAILED<BR>\n";
        continue;
      }
            
      $inputCountryCode = strtolower(substr($file, 0, 2));
      $destPath = "./gml/aspc_".$inputCountryCode.".gml";
      
      if ($aspConverter->writeToFile($destPath, "GML", "23"))
      {
        echo $aspConverter->warnings;
        echo "OK<BR>\n";
      }
      else
      {
        echo $aspConverter->warnings;
        echo $aspConverter->errors;
        echo "FAILED<BR>\n";
      }    
    }
  }
  
  closedir($handle);
}

echo "Finished<BR>\n";

?>


