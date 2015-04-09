<?php

include "Tools.php";
include "includes/open_aip_airspace.converter.aspc_converter.inc";

// recreate the output dir..
rrmdir("./aip");
mkdir("./aip");

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
      $aipFileName = "./aip/".$inputCountryCode."_asp.aip";
      
      if ($aspConverter->writeToFile($aipFileName, "OPENAIP", "23"))
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

zipDir("./aip", "./asp_all.zip");

echo "Finished<BR>\n";

?>


